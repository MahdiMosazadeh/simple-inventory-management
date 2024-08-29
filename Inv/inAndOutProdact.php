<?php
session_start();
require_once '../Scripts/dbConnect.php';
require_once '../Scripts/functions.php';
require_once '../Scripts/jdf.php';

//Check the User Session Login , If Session Doesn't Set
//Then Redirect To The Login Page And If Login Is Set Show The Page
if (!isset($_SESSION['logged_in'])) {
    redirect('../');
} else {
    //In Product
    if (isset($_POST['inBtn'])) {
        date_default_timezone_set('Asia/Tehran');

        $inCodeing = cleanUpInputs($_POST['inCodeing']);
        $inQty = cleanUpInputs($_POST['inQty']);
        $in_out = 1;
        $inDate = date('Y-m-d');
        $inTime = date('H:i:s');
        // تبدیل تاریخ میلادی به شمسی  
        list($year, $month, $day) = explode('-', $inDate);
        $shamsiDate = jdate('Y-m-d', mktime(0, 0, 0, $month, $day, $year));

        //Select Product By p_codeing And Check Exist Or Not.
        $checkCodeSql = $conn->prepare("SELECT * FROM products WHERE p_codeing= :code");
        $checkCodeSql->bindParam(':code', $inCodeing);
        $checkCodeSql->execute();
        //If Exist Then : Execute Update Sql.
        if ($checkCodeSql->rowCount() > 0) {
            try {
                // update product table qty col.
                $inSql = "UPDATE products SET p_qty = p_qty + :qty WHERE p_codeing = :code ";

                $inSqlExe = $conn->prepare($inSql);
                $inSqlExe->bindParam('qty', $inQty);
                $inSqlExe->bindParam('code', $inCodeing);
                $inSqlExe->execute();

                // Insert in inputoutput table.
                $inLogSql = "INSERT INTO `inputoutput` (`id`, `in_out`, `date`, `time`, `qty`, `p_codeing`) VALUES (NULL, :inOutType, :inDate, :inTime, :inQty, :inProductCodeing);";

                $inLogSqlExe = $conn->prepare($inLogSql);
                $inLogSqlExe->bindParam('inOutType', $in_out);
                $inLogSqlExe->bindParam('inDate', $inDate);
                $inLogSqlExe->bindParam('inTime', $inTime);
                $inLogSqlExe->bindParam('inQty', $inQty);
                $inLogSqlExe->bindParam('inProductCodeing', $inCodeing);
                $inLogSqlExe->execute();

                //Set Success Update Message Var.
                $updateSuccess = 1;
            } catch (PDOException $error) {
                echo $error->getMessage();
            }
        } else {
            $notExist = 1;
        }
    }
    //Out Product
    else if (isset($_POST['outBtn'])) {
        date_default_timezone_set('Asia/Tehran');

        $outCodeing = cleanUpInputs($_POST['outCodeing']);
        $outQty = cleanUpInputs($_POST['outQty']);
        $in_out = 2;
        $outDate = date('Y-m-d');
        $outTime = date('H:i:s');
        // تبدیل تاریخ میلادی به شمسی  
        list($year, $month, $day) = explode('-', $outDate);
        $shamsiDate = jdate('Y-m-d', mktime(0, 0, 0, $month, $day, $year));

        //Select Product By p_codeing And Check Exist Or Not.
        $checkCodeSql = $conn->prepare("SELECT * FROM products WHERE p_codeing= :code");
        $checkCodeSql->bindParam(':code', $outCodeing);
        $checkCodeSql->execute();
        foreach ($checkCodeSql as $row) :
            $currentQty = $row['p_qty'];
        endforeach;
        //If Exist Then : Execute Update Sql.
        if ($checkCodeSql->rowCount() > 0) {
            if($currentQty - $outQty < 0)
            {
                $blowZero = 1;
            }
            else
            {
                try {
                    // update product table qty col.
                    $outSql = "UPDATE products SET p_qty = p_qty - :qty WHERE p_codeing = :code ";
    
                    $outSqlExe = $conn->prepare($outSql);
                    $outSqlExe->bindParam('qty', $outQty);
                    $outSqlExe->bindParam('code', $outCodeing);
                    $outSqlExe->execute();
    
                    // Insert in inputoutput table.
                    $outLogSql = "INSERT INTO `inputoutput` (`id`, `in_out`, `date`, `time`, `qty`, `p_codeing`) VALUES (NULL, :inOutType, :inDate, :inTime, :inQty, :inProductCodeing);";
    
                    $outLogSqlExe = $conn->prepare($outLogSql);
                    $outLogSqlExe->bindParam('inOutType', $in_out);
                    $outLogSqlExe->bindParam('inDate', $outDate);
                    $outLogSqlExe->bindParam('inTime', $outTime);
                    $outLogSqlExe->bindParam('inQty', $outQty);
                    $outLogSqlExe->bindParam('inProductCodeing', $outCodeing);
                    $outLogSqlExe->execute();
    
                    //Set Success Update Message Var.
                    $updateSuccessOut = 1;
                } catch (PDOException $error) {
                    echo $error->getMessage();
                }
            }
            
        } else {
            $notExist = 1;
        }
    }
?>
    <!DOCTYPE html>
    <html lang="fa">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="../Assets/Images/finger.png" />
        <title>ورود و خروج کالا</title>

        <link rel="stylesheet" href="../Assets/Css/fonts.css">
        <link rel="stylesheet" href="../Assets/Css/bootstrap.rtl.min.css">
        <link rel="stylesheet" href="../Assets/Css/Style.css">
        <link rel="stylesheet" href="../Assets/Css/all.css">
        <link rel="stylesheet" href="../Assets/Css/sweetalert2.min.css">
        <script src="../Assets/Js/sweetalert2.js"></script>
    </head>

    <body dir="rtl" style="background-color: #eee;">
        <main class="container">
            <section class="row">
                <div class="col in">
                    <h3>
                        ورود کالا
                    </h3>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form-control">
                        <input type="number" name="inCodeing" id="" class="form-control" min="0" max="10000000" step="1" required="required" style="direction: rtl" placeholder="کدینگ" oninvalid="this.setCustomValidity('کدینگ کالا نمیتواند خالی یا اعشاری باشد')" oninput="setCustomValidity('')">
                        <input type="number" name="inQty" id="" class="form-control" min="0" max="10000000" step="1" style="direction: rtl" placeholder="تعداد" required="required" oninvalid="this.setCustomValidity('نمیتواند اعشار یا خالی باشد')" oninput="setCustomValidity('')">
                        <button type="submit" name="inBtn" class="btn btn-primary">ورود کالا</button>
                    </form>
                    <?php
                    //Message Dosn't Exist Codeing.
                    if (isset($notExist)) {
                        echo '<script type="text/javascript">  
                                Swal.fire
                                        ({    
                                            text: "این کدینگ وجود ندارد",  
                                            icon: "warning", 
                                            confirmButtonText: "تأیید"  
                                        });
                                </script>';
                    } else if (isset($updateSuccess)) {
                        echo '<script type="text/javascript">  
                                Swal.fire
                                        ({    
                                            text: "ورود کالا ثبت شد",  
                                            icon: "success", 
                                            confirmButtonText: "تأیید"  
                                        });
                                </script>';
                    } else if (isset($updateSuccessOut)) {
                        echo '<script type="text/javascript">  
                                Swal.fire
                                        ({    
                                            text: "خروج کالا ثبت شد",  
                                            icon: "success", 
                                            confirmButtonText: "تأیید"  
                                        });
                                </script>';
                    } else if (isset($blowZero)) {
                        echo '<script type="text/javascript">  
                                Swal.fire
                                        ({    
                                            text: "بیش از موجودی شماست ، مقدار کالا منفی میشود.",  
                                            icon: "error", 
                                            confirmButtonText: "تأیید"  
                                        });
                                </script>';
                    }
                    ?>
                </div>
            </section>

            <section class="row">
                <div class="col out">
                    <h3>
                        خروج کالا
                    </h3>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form-control">
                        <input type="number" name="outCodeing" id="" class="form-control" min="0" max="10000000" step="1" required="required" style="direction: rtl" placeholder="کدینگ" oninvalid="this.setCustomValidity('کدینگ کالا نمیتواند خالی یا اعشاری باشد')" oninput="setCustomValidity('')">
                        <input type="number" name="outQty" id="" class="form-control" min="0" max="10000000" step="1" style="direction: rtl" placeholder="تعداد" required="required" oninvalid="this.setCustomValidity('نمیتواند اعشار یا خالی باشد')" oninput="setCustomValidity('')">
                        <button type="submit" name="outBtn" class="btn btn-primary">خروج کالا</button>
                    </form>
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