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
    //اگر کاربر معمولی وارد شده بود برگردد به داشبورد
    if($_SESSION['user_type'] == 1) {redirect('userPanel');;} 

    //اگر کاربر روی دکمه ورود کالا کلیک کند این شرط اجرا میشود
    if (isset($_POST['inBtn'])) {
        date_default_timezone_set('Asia/Tehran');

        $inCodeing = cleanUpInputs($_POST['inCodeing']);// دریافت کدینگ کالا از کاربر
            $inP_idSql = $conn -> query("select id from products where p_codeing = $inCodeing");// واکشی آی دی محصول و پردازش با استفاده از آی دی
            $inP_idSqlResult = $inP_idSql -> fetchColumn();
           
        $inQty = cleanUpInputs($_POST['inQty']);
        $in_out = 1; // وضعیت ورودی با کد1 مشخص میشود در دیتابیس
        $inDate = date('Y-m-d');
        $inTime = date('H:i:s');
        // تبدیل تاریخ میلادی به شمسی  
        list($year, $month, $day) = explode('-', $inDate);
        $shamsiDate = jdate('Y-m-d', mktime(0, 0, 0, $month, $day, $year));// تاریخ کامل

        $inYear = substr($shamsiDate, 0,8);// جدا کردن سال از تاریخ
        $inMonth = substr($shamsiDate, 9,4);// جدا کردن ماه از تاریخ

        //بررسی وجود کالا با استفاده از کدینگ وارد شده و در صورت وجود کالا ورود ثبت میشود در غیراین صورت خطای عدم وجود میدهد
        $checkCodeSql = $conn->prepare("SELECT * FROM products WHERE p_codeing= :code");
        $checkCodeSql->bindParam(':code', $inCodeing);
        $checkCodeSql->execute();
        //در صورت وجود کالا ادامه فرایند ثبت ورود در دیتابیس انجام میشود
        if ($checkCodeSql->rowCount() > 0) {
            try {
                // آپدیت مقدار تعداد کالا در جدول محصولات و جمع با مقدار قبلی
                $inSql = "UPDATE products SET p_qty = p_qty + :qty WHERE p_codeing = :code ";

                $inSqlExe = $conn->prepare($inSql);
                $inSqlExe->bindParam('qty', $inQty);
                $inSqlExe->bindParam('code', $inCodeing);
                $inSqlExe->execute();

                // ثبت لاگ مروبط به این ورود خروج در دیتابیس
                $inLogSql = "INSERT INTO `inputoutput` (`id`, `in_out`, `date`, `year`, `month`, `time`, `qty`, `p_id`) VALUES (NULL, :inOutType, :inDate, :inYear, :inMonth, :inTime, :inQty, :inP_id);";

                $inLogSqlExe = $conn->prepare($inLogSql);
                $inLogSqlExe->bindParam('inOutType', $in_out);
                $inLogSqlExe->bindParam('inDate', $shamsiDate);
                $inLogSqlExe->bindParam('inYear', $inYear);
                $inLogSqlExe->bindParam('inMonth', $inMonth);
                $inLogSqlExe->bindParam('inTime', $inTime);
                $inLogSqlExe->bindParam('inQty', $inQty);
                $inLogSqlExe->bindParam('inP_id', $inP_idSqlResult);
                $inLogSqlExe->execute();

                //تنظیم پیغام ثبت موفقیت آمیز بودن
                $updateSuccess = 1;
            } catch (PDOException $error) {
                echo $error->getMessage();
            }
        } else {
            $notExist = 1; // خطای عدم وجود کدینگ
        }
    }
    //اگر کاربر روی دکمه خروج کالا کلیک کرده باشد
    else if (isset($_POST['outBtn'])) {
        date_default_timezone_set('Asia/Tehran');

        $outCodeing = cleanUpInputs($_POST['outCodeing']);
            $outP_idSql = $conn -> query("select id from products where p_codeing = $outCodeing");
            $outP_idSqlResult = $outP_idSql -> fetchColumn();
        $outQty = cleanUpInputs($_POST['outQty']);
        $in_out = 2;
        $outDate = date('Y-m-d');
        $outTime = date('H:i:s');
        // تبدیل تاریخ میلادی به شمسی  
        list($year, $month, $day) = explode('-', $outDate);
        $shamsiDate = jdate('Y-m-d', mktime(0, 0, 0, $month, $day, $year));

        $outYear = substr($shamsiDate, 0,8);
        $outMonth = substr($shamsiDate, 9,4);

        //بررسی وجود کالا با استفاده از کدینگ
        $checkCodeSql = $conn->prepare("SELECT * FROM products WHERE p_codeing= :code");
        $checkCodeSql->bindParam(':code', $outCodeing);
        $checkCodeSql->execute();
        foreach ($checkCodeSql as $row) :
            $currentQty = $row['p_qty']; // واکشی مقدار فعلی کالا مد نظر کاربر
        endforeach;
        //اگر کالا وجود داشته باشد
        if ($checkCodeSql->rowCount() > 0) {
            if($currentQty - $outQty < 0) // اگر مقدار خروجی کالای کاربر بیشتر از مقدار فعلی انبار باشد خطا میدهد
            {
                $blowZero = 1;
            }
            else // در غیر این صورت فرآیند ثبت خروج کالا و کسر آن از جدول محصولات انجام میشود
            {
                try {
                    // update product table qty col.
                    $outSql = "UPDATE products SET p_qty = p_qty - :qty WHERE p_codeing = :code ";
    
                    $outSqlExe = $conn->prepare($outSql);
                    $outSqlExe->bindParam('qty', $outQty);
                    $outSqlExe->bindParam('code', $outCodeing);
                    $outSqlExe->execute();
    
                    // Insert in inputoutput table.
                    $outLogSql = "INSERT INTO `inputoutput` (`id`, `in_out`, `date`, `year`, `month`, `time`, `qty`, `p_id`) VALUES (NULL, :inOutType, :inDate, :inYear, :inMonth, :inTime, :inQty, :inP_id);";
    
                    $outLogSqlExe = $conn->prepare($outLogSql);
                    $outLogSqlExe->bindParam('inOutType', $in_out);
                    $outLogSqlExe->bindParam('inDate', $shamsiDate);
                    $outLogSqlExe->bindParam('inYear', $outYear);
                    $outLogSqlExe->bindParam('inMonth', $outMonth);
                    $outLogSqlExe->bindParam('inTime', $outTime);
                    $outLogSqlExe->bindParam('inQty', $outQty);
                    $outLogSqlExe->bindParam('inP_id', $outP_idSqlResult);
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