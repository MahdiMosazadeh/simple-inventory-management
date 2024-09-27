<?php
session_start();
require_once '../Scripts/dbConnect.php';
require_once '../Scripts/functions.php';

//Check the User Session Login , If Session Doesn't Set
//Then Redirect To The Login Page And If Login Is Set Show The Page
if (!isset($_SESSION['logged_in'])) {
    redirect('../');
} else {
    if (isset($_POST['productSearchBtn'])) {
        if (isset($_POST['select']) && $_POST['select'] == 'p_name') {
            $productName = $_POST['productName'];

            $num = 1;

            $searchProductSql = $conn->prepare("SELECT * FROM `products` WHERE `p_name` LIKE :search");
            $searchProductSql->execute(['search' => '%' . $productName . '%']);

            // دریافت نتایج  
            $searchProductSqlResult = $searchProductSql->fetchAll(PDO::FETCH_ASSOC);
        } else if (isset($_POST['select']) && $_POST['select'] == 'p_codeing') {
            $productCodeing = $_POST['productName'];

            $num = 1;

            $searchProductSql = $conn->prepare("SELECT * FROM `products` WHERE `p_codeing` = :search");
            $searchProductSql->execute(['search' => $productCodeing]);

            // دریافت نتایج  
            $searchProductSqlResult = $searchProductSql->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    //delete product by id
    if (isset($_GET['id'])) {
        try {
            $id = cleanUpInputs($_GET['id']);

            $fileNameSql = "select imgAddress from products where id = $id";
            $stmtPicName = $conn->query($fileNameSql);
            $stmtPicNameResult = $stmtPicName->fetchColumn();
            $filename = $stmtPicNameResult; // نام فایلی که می‌خواهید حذف کنید  

            if (file_exists($filename)) {
                // بررسی وجود فایل  
                unlink($filename);
            }

            $sql = $conn->prepare("DELETE FROM `products` WHERE `products`.`id` = ?");
            $sql->bindParam(1, $id);
            $sql->execute();
        } catch (PDOException $e) {
            $delError = 1;
        }
    }
?>
    <!DOCTYPE html>
    <html lang="fa">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="../Assets/Images/finger.png" />
        <title>جستجوی کالا</title>

        <link rel="stylesheet" href="../Assets/Css/fonts.css">
        <link rel="stylesheet" href="../Assets/Css/bootstrap.rtl.min.css">
        <link rel="stylesheet" href="../Assets/Css/Style.css">
        <link rel="stylesheet" href="../Assets/Css/all.css">
        <link rel="stylesheet" href="../Assets/Css/sweetalert2.min.css">
        <script src="../Assets/Js/sweetalert2.js"></script>
        <style>
            .popup {
                display: none;
                left: 0;
                top: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.8);
                z-index: 100000000;
            }

            .popup-content {
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                background-color: #fff;
                border-radius: 8px;
                padding: 20px;
                text-align: center;
                animation: fade-in 0.5s ease;
                z-index: 100000000;
            }

            .popup img {
                max-width: 100%;
                height: auto;
                border-radius: 8px;
                z-index: 100000000;
            }

            .close-btn {
                margin-top: 10px;
                padding: 10px 20px;
                background-color: #f44336;
                color: white;
                border: none;
                border-radius: 5px;
                cursor: pointer;
                transition: background-color 0.2s;
                z-index: 100000000;
            }

            .close-btn:hover {
                background-color: #c62828;
                z-index: 100000000;
            }

            @keyframes fade-in {
                from {
                    opacity: 0;
                }

                to {
                    opacity: 1;
                }
            }
        </style>

    </head>

    <body dir="rtl">
        <!-- پاپ آپ نمایش تصویر محصول -->
        <?php
        if (isset($_GET['picAddress'])) {
            $id = $_GET['picAddress'];

            $fileNameSql = "select imgAddress from products where id = $id";
            $stmtPicName = $conn->query($fileNameSql);
            $stmtPicNameResult = $stmtPicName->fetchColumn();
            $filename = $stmtPicNameResult; // File Address And Name
        ?>
        <div class="popup" id="popup">
            <div class="popup-content">
                <img src="<?php echo $filename; ?>" alt="تصویری برای این محصول انتخاب نشده است">
                <button class="close-btn" id="close-popup">بستن</button>
            </div>
        </div>
            <script>
                window.onload = function() {
                    var popup = document.getElementById("popup");
                    if (popup) {
                        popup.style.display = "block";
                    }
                };

                document.getElementById("close-popup").onclick = function() {
                    document.getElementById("popup").style.display = "none";
                }

                // برای بستن پاپ آپ با کلیک خارج از آن  
                window.onclick = function(event) {
                    const popup = document.getElementById("popup");
                    if (event.target == popup) {
                        popup.style.display = "none";
                    }
                }
            </script>
        <?php
        }
        ?>
        <main class="container searchProduct">
            <section class="row">
                <div class="col">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form-control">
                        <h3 class="blue-color">
                            جستجوی کالا
                        </h3>
                        <div class="input-group mb-3">
                            <select class="form-select" name="select" id="select" required>
                                <option value="p_name">جستجو بر اساس نام کالا</option>
                                <option value="p_codeing">جستجو بر اساس کدینگ کالا</option>
                            </select>
                            <input type="text" name="productName" class="form-control" required="required" placeholder="" oninvalid="this.setCustomValidity('قسمتی از نام کالا را وارد کنید')" oninput="setCustomValidity('')">
                            <button class="btn btn-outline-secondary" name="productSearchBtn" type="submit" id="button-addon1">جستجو</button>
                        </div>
                        <?php
                        if (isset($searchProductSqlResult)) {
                            if ($searchProductSql->rowCount() == 0) {
                                echo '<script type="text/javascript">  
                            Swal.fire
                                    ({    
                                        text: "کالایی با این نام/کدینگ وجود ندارد",  
                                        icon: "error", 
                                        confirmButtonText: "تأیید"  
                                    });
                      </script>';
                            }
                        ?>
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">ردیف</th>
                                        <th scope="col">کدینگ</th>
                                        <th scope="col">نام</th>
                                        <th scope="col">استقرار</th>
                                        <th scope="col">واحد</th>
                                        <th scope="col">تعداد</th>
                                        <th scope="col">توضیحات</th>
                                        <th scope="col" style="color:blueviolet;width: 20px;">تصویر</th>
                                        <th scope="col" style="color: red;width: 20px;">حذف</th>
                                        <th scope="col" style="color: blue;width: 20px;">اصلاح</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($searchProductSqlResult as $row): ?>
                                        <tr>
                                            <th scope="row"><?php echo $num++ ?></th>
                                            <td><?php if (htmlspecialchars($row['p_codeing']) == 0) {
                                                    echo "ندارد";
                                                } else {
                                                    echo htmlspecialchars($row['p_codeing']);
                                                } ?></td>
                                            <td><?php echo htmlspecialchars($row['p_name']) ?></td>
                                            <td><?php echo htmlspecialchars($row['p_place']) ?></td>
                                            <td><?php echo htmlspecialchars($row['p_unit']) ?></td>
                                            <td><?php echo htmlspecialchars($row['p_qty']) ?></td>
                                            <td><?php echo htmlspecialchars($row['p_description']) ?></td>
                                            <td><a id="open-popup" style="color: black;" href="?picAddress=<?php echo htmlspecialchars($row['id']) ?>"><i class="fa-duotone fa-solid fa-image"></i></a></td>
                                            <td><a style="color: black;" href="?id=<?php echo htmlspecialchars($row['id']) ?>"><i style="margin-right: 5px;" onmouseout="this.style.color='black';" onmouseover="this.style.color='red';" class="fa-thin fa-bin-recycle"></i></a></td>
                                            <td><a style="color: black;" href="updateProduct.php?id=<?php echo htmlspecialchars($row['id']) ?>"><i style="margin-right: 10px;" onmouseout="this.style.color='black';" onmouseover="this.style.color='blue';" class="fa-thin fa-pen-to-square edit-icon"></i></a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php } ?>
                    </form>
                </div>
            </section>
            <section class="row" style="margin-top: 15px;">
                <div class="col">
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="post" class="form-control">
                        <h3 class="blue-color">
                            جستجوی شخص
                        </h3>
                        <div class="input-group mb-3">
                            <input name="personName" type="text" class="form-control" required="required" placeholder="قسمتی از نام شخص را وارد کنید" aria-label="Example text with button addon" aria-describedby="button-addon1">
                            <button name="personSearchBtn" class="btn btn-outline-secondary" type="submit" id="button-addon1">جستجو</button>
                        </div>
                        <?php if (isset($_POST['personSearchBtn'])) {

                            $personName = $_POST['personName'];

                            $num = 1;

                            $searchPersonSql = $conn->prepare("SELECT * FROM `persons` WHERE `flName` LIKE :search");
                            $searchPersonSql->execute(['search' => '%' . $personName . '%']);

                            // دریافت نتایج  
                            $searchPersonSqlResult = $searchPersonSql->fetchAll(PDO::FETCH_ASSOC);

                            if ($searchPersonSql->rowCount() == 0) {
                                echo '<script type="text/javascript">  
                            Swal.fire
                                    ({    
                                        text: "شخصی با این نام وجود ندارد",  
                                        icon: "error", 
                                        confirmButtonText: "تأیید"  
                                    });
                      </script>';
                            }
                        ?>

                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">ردیف</th>
                                        <th scope="col">نام</th>
                                        <th scope="col">نوع</th>
                                        <th scope="col">آدرس</th>
                                        <th scope="col">شماره</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($searchPersonSqlResult as $row): ?>
                                        <tr>
                                            <th scope="row"><?php echo $num++ ?></th>
                                            <td><?php echo htmlspecialchars($row['flName']) ?></td>
                                            <td><?php echo htmlspecialchars($row['persType']) ?></td>
                                            <td><?php echo htmlspecialchars($row['persAddress']) ?></td>
                                            <td><?php echo htmlspecialchars($row['persNumber']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>

                                </tbody>
                            </table>
                        <?php } ?>
                    </form>
                </div>

                <?php
                if (isset($delError)) {
                    echo '<script type="text/javascript">  
                                Swal.fire
                                        ({    
                                            text: "این کد کالا دارای گردش است و قابل حذف نیست",  
                                            icon: "error", 
                                            confirmButtonText: "تأیید"  
                                        });
                                </script>';
                    $delError = null;
                }
                ?>
            </section>
        </main>
        <script src="../Assets/Js/bootstrap.bundle.min.js"></script>
        <script src="../Assets/Js/bootstrap.min.js"></script>
    </body>

    </html>
<?php
}
?>