<?php
session_start();
require_once '../Scripts/dbConnect.php';
require_once '../Scripts/functions.php';

//Check the User Session Login , If Session Doesn't Set
//Then Redirect To The Login Page And If Login Is Set Show The Page
if (!isset($_SESSION['logged_in'])) {
    redirect('../');
} else {

    //delete product by id
    if (isset($_GET['id'])) {
        $id = cleanUpInputs($_GET['id']);

        $sql = $conn->prepare("DELETE FROM `products` WHERE `products`.`id` = ?");
        $sql->bindParam(1, $id);
        $sql->execute();
    }
?>
    <!DOCTYPE html>
    <html lang="fa">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="../Assets/Images/finger.png" />
        <title>معرفی کالا</title>

        <link rel="stylesheet" href="../Assets/Css/fonts.css">
        <link rel="stylesheet" href="../Assets/Css/bootstrap.rtl.min.css">
        <link rel="stylesheet" href="../Assets/Css/Style.css">
        <link rel="stylesheet" href="../Assets/Css/all.css">
        <script src="../Assets/Js/sweetalert2.js"></script>
    </head>

    <body dir="rtl">
        <main class="container statisticsProduct">
            <section class="row">
                <div class="col">
                    <form action="" method="post" class="form-control">
                        <h3 class="red-color">
                            ناموجود
                        </h3>
                        <?php
                        $searchSqlNothing = $conn->query('SELECT * FROM products WHERE p_qty=0 or p_qty < 0');
                        $resultNothing = $searchSqlNothing->fetchAll(PDO::FETCH_ASSOC);
                        $num = 1;
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
                                <?php foreach ($resultNothing as $row): ?>
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
                                        <td><i id="myText" style="margin-right: 5px;cursor:pointer;" onmouseout="this.style.color='black';" onmouseover="this.style.color='purple';" class="fa-duotone fa-solid fa-image"></i></td>
                                        <td><a style="color: black;" href="?id=<?php echo htmlspecialchars($row['id']) ?>"><i style="margin-right: 5px;" onmouseout="this.style.color='black';" onmouseover="this.style.color='red';" class="fa-thin fa-bin-recycle"></i></a></td>
                                        <td><a style="color: black;" href="updateProduct.php?id=<?php echo htmlspecialchars($row['id']) ?>"><i style="margin-right: 10px;" onmouseout="this.style.color='black';" onmouseover="this.style.color='blue';" class="fa-thin fa-pen-to-square edit-icon"></i></a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <h3 class="orange-color">
                            در آستانه اتمام
                        </h3>
                        <?php
                        $searchSqlLess = $conn->query('SELECT * FROM products WHERE p_qty <= 5 AND p_qty > 0');
                        $resultLess = $searchSqlLess->fetchAll(PDO::FETCH_ASSOC);
                        $num = 1;
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
                                <?php foreach ($resultLess as $row): ?>
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
                                        <td><a style="color: black;" href="#"><i style="margin-right: 5px;" onmouseout="this.style.color='black';" onmouseover="this.style.color='purple';" class="fa-duotone fa-solid fa-image"></i></a></td>
                                        <td><a style="color: black;" href="?id=<?php echo htmlspecialchars($row['id']) ?>"><i style="margin-right: 5px;" onmouseout="this.style.color='black';" onmouseover="this.style.color='red';" class="fa-thin fa-bin-recycle"></i></a></td>
                                        <td><a style="color: black;" href="updateProduct.php?id=<?php echo htmlspecialchars($row['id']) ?>"><i style="margin-right: 10px;" onmouseout="this.style.color='black';" onmouseover="this.style.color='blue';" class="fa-thin fa-pen-to-square edit-icon"></i></a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <h3 class="blue-color">
                            لیست کامل کالا ها
                        </h3>
                        <p>
                            به جز ناموجود ها و در آستانه اتمام ها
                        </p>
                        <?php
                        $searchSqlAll = $conn->query('SELECT * FROM products WHERE p_qty > 5');
                        $resultAll = $searchSqlAll->fetchAll(PDO::FETCH_ASSOC);
                        $conn = null;
                        $num = 1;
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
                                <?php foreach ($resultAll as $row): ?>
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
                                        <td><a style="color: black;" href="#"><i style="margin-right: 5px;" onmouseout="this.style.color='black';" onmouseover="this.style.color='purple';" class="fa-duotone fa-solid fa-image"></i></a></td>
                                        <td><a style="color: black;" href="?id=<?php echo htmlspecialchars($row['id']) ?>"><i style="margin-right: 5px;" onmouseout="this.style.color='black';" onmouseover="this.style.color='red';" class="fa-thin fa-bin-recycle"></i></a></td>
                                        <td><a style="color: black;" href="updateProduct.php?id=<?php echo htmlspecialchars($row['id']) ?>"><i style="margin-right: 10px;" onmouseout="this.style.color='black';" onmouseover="this.style.color='blue';" class="fa-thin fa-pen-to-square edit-icon"></i></a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                    </form>
                </div>
            </section>
        </main>
        <?php
        if (isset($_SESSION['updateSuccess'])) {
            echo '<script type="text/javascript">  
                    Swal.fire
                            ({    
                                text: "بروزرسانی با موفقیت انجام شد",  
                                icon: "success", 
                                confirmButtonText: "تأیید"  
                            });
                    </script>';
            $_SESSION['updateSuccess'] = null;
        }
        ?>
        <script src="../Assets/Js/bootstrap.bundle.min.js"></script>
        <script src="../Assets/Js/bootstrap.min.js"></script>
        <script src="../Assets/Js/scripts.js"></script>
    </body>

    </html>
<?php
}
?>