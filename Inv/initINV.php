<?php
session_start();
require_once '../Scripts/dbConnect.php';
require_once '../Scripts/functions.php';

//Check the User Session Login , If Session Doesn't Set
//Then Redirect To The Login Page And If Login Is Set Show The Page
if (!isset($_SESSION['logged_in'])) {
    redirect('../');
} else {
    //check Btn Are Clicked Or Not 
    if (isset($_POST['invBtn'])) {
        //recive form Paramets
        $invName = cleanUpInputs($_POST['invName']);
        $invAddress = cleanUpInputs($_POST['invAddress']);
        $invDescription = cleanUpInputs($_POST['invDescription']);

        //Insert SQL
        try {
            $sqlInsertINV = $conn->prepare("INSERT INTO `inv` (`id`, `name`, `address`, `description`) VALUES (NULL, ?, ?, ?);");
            $sqlInsertINV->execute([$invName, $invAddress, $invDescription]);
            // if query execute successfully then Alert Success 
            if ($sqlInsertINV) {
                $successMessage = 1;
            }
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
            $error = $e;
            $errorMessage = 1;
        }
    }
    try
    {
    if (isset($_GET['id'])) {
        $id = cleanUpInputs($_GET['id']);

        $sql = $conn->prepare("DELETE FROM `inv` WHERE `inv`.`id` = ?");
        $sql->bindParam(1, $id);
        $del = $sql->execute();
        if($del) { $delSuccess = 1; }

    }
    }
    catch (PDOException $e) {
        $delError = 1;
    }
?>
    <!DOCTYPE html>
    <html lang="fa">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="../Assets/Images/finger.png" />
        <title>انبارها</title>

        <link rel="stylesheet" href="../Assets/Css/fonts.css">
        <link rel="stylesheet" href="../Assets/Css/bootstrap.rtl.min.css">
        <link rel="stylesheet" href="../Assets/Css/Style.css">
        <link rel="stylesheet" href="../Assets/Css/all.css">
        <link rel="stylesheet" href="../Assets/Css/sweetalert2.min.css">
        <script src="../Assets/Js/sweetalert2.js"></script>
    </head>

    <body dir="rtl">
        <?php
        //Success Insert Message
        if (isset($successMessage)) {
            echo '<script type="text/javascript">  
                            Swal.fire
                                    ({  
                                        text: " انبار جدید با موفقیت ثبت شد", 
                                        icon: "success", 
                                        confirmButtonText: "تأیید"  
                                    });
                      </script>';
        }

        else if (isset($delSuccess)) {
            echo '<script type="text/javascript">  
                            Swal.fire
                                    ({  
                                        text: " انبار با موفقیت حذف شد", 
                                        icon: "error", 
                                        confirmButtonText: "تأیید"  
                                    });
                      </script>';
        }
        //Error Insert Message
        else if (isset($errorMessage)) {
            echo '<script type="text/javascript">  
                            Swal.fire
                                    ({    
                                        text: "خطایی رخ داده است لطفا با پشتیبانی تماس بگیرید",  
                                        icon: "error", 
                                        confirmButtonText: "تأیید"  
                                    });
                      </script>';
        }
        else if (isset($delError)) {
            echo '<script type="text/javascript">  
                            Swal.fire
                                    ({    
                                        text: "این انبار گردش دارد و امکان حذف آن وجود ندارد",  
                                        icon: "error", 
                                        confirmButtonText: "تأیید"  
                                    });
                      </script>';
        }
        ?>
        <main class="container updateProduct">
            <section class="row phoneNumber">
                <div class="row">
                    <div class="col">
                        <form style="display: <?php if(isset($_GET['editId'])) {echo "none";} ?>;" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form-control">
                            <h3 class="blue-color">
                                انبار جدید
                            </h3>
                            <input type="text" name="invName" id="invName" class="form-control" style="direction: rtl" placeholder="نام انبار" required="required" oninvalid="this.setCustomValidity('لطفا نام انبار را وارد کنید')" oninput="setCustomValidity('')">
                            <input type="text" name="invAddress" id="invAddress" class="form-control" style="direction: rtl" placeholder="آدرس انبار را وارد کنید" required="required" oninvalid="this.setCustomValidity('لطفا آدرس انبار را وارد کنید')" oninput="setCustomValidity('')">
                            <input type="text" name="invDescription" id="invDescription" class="form-control" style="direction: rtl" placeholder="توضیحات" oninvalid="this.setCustomValidity('توضیحات انبار (اختیاری)')" oninput="setCustomValidity('')">

                            <button type="submit" name="invBtn" id="invBtn" class="btn btn-primary">ثبت انبار جدید</button>
                        </form>
                    </div>
                </div>

                <div class="row">
                    <div class="col">
                        <form action="" class="form-control" method="post">
                            <h3 class="blue-color">
                                انبار ها
                            </h3>
                            <?php
                            $invList = $conn->query('SELECT * FROM inv');
                            $invResult = $invList->fetchAll(PDO::FETCH_ASSOC);
                            $num = 1;
                            ?>
                            <table class="table">
                                <thead class="thead-dark">
                                    <tr>
                                        <th scope="col">ردیف</th>
                                        <th scope="col">اسم</th>
                                        <th scope="col">نوع</th>
                                        <th scope="col">آدرس</th>
                                        <!-- <th scope="col">ویرایش</th> -->
                                        <th scope="col">حذف</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($invResult as $row): ?>
                                        <tr>
                                            <th scope="row"><?php echo $num++ ?></th>
                                            <td><?php echo htmlspecialchars($row['name']) ?></td>
                                            <td><?php echo htmlspecialchars($row['address']) ?></td>
                                            <td><?php echo htmlspecialchars($row['description']) ?></td>
                                            <!-- <td><a style="color: black;" href="?editId=<?php echo htmlspecialchars($row['id']) ?>"><i style="margin-right: 10px;" onmouseout="this.style.color='black';" onmouseover="this.style.color='blue';" class="fa-thin fa-pen-to-square edit-icon"></i></a></td> -->
                                            <td><a style="color: black;" href="?id=<?php echo htmlspecialchars($row['id']) ?>"><i style="margin-right: 5px;" onmouseout="this.style.color='black';" onmouseover="this.style.color='red';" class="fa-thin fa-bin-recycle"></i></a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>
            </section>
        </main>
        <script src="../Assets/Js/bootstrap.bundle.min.js"></script>
        <script src="../Assets/Js/bootstrap.min.js"></script>
    </body>

    </html>
<?php
}
?>