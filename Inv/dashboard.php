<?php
session_start();
require_once '../Scripts/dbConnect.php';
require_once '../Scripts/functions.php';

//Check the User Session Login , If Session Doesn't Set
//Then Redirect To The Login Page And If Login Is Set Show The Page
if (!isset($_SESSION['logged_in'])) {
    redirect('../');
} else {
    // انتخاب محصولاتی که تعدادشان صفر است
    $sqlZeroQty = "SELECT COUNT(*) FROM `products` WHERE p_qty=0;";
    $stmt = $conn->query($sqlZeroQty);
    $zeroQtyCount = $stmt->fetchColumn();

    // انتخاب محصولاتی که تعدادشان کمتر از 5 عدد است
    $sqlLessQty = "SELECT COUNT(*) FROM `products` WHERE p_qty <= 5;";
    $stmtLess = $conn->query($sqlLessQty);
    $lessQtyCount = $stmtLess->fetchColumn();

    // انتخاب تعداد محصولات
    $sqlAllQty = "SELECT COUNT(*) FROM `products`";
    $stmtAll = $conn->query($sqlAllQty);
    $AllQtyCount = $stmtAll->fetchColumn();

    // جمع موجودی کل اجناس انبار
    $sqlSUMQty = "SELECT SUM(p_qty) FROM `products`";
    $stmtSUM = $conn->query($sqlSUMQty);
    $sumQtyCount = $stmtSUM->fetchColumn();

    // انتخاب تمام ورودی و خروجی ها اگر دکمه فیلر زده شود ، لیست فیلتر میشود اگه زده نشود تمام ورودی خروجی ها نمایش داده میشود
    if (isset($_POST['btnFilter'])) {
        $year = strval($_POST['year']);
        $month = strval($_POST['month']);

        $inOutAllSql = "SELECT * FROM `inputoutput` where `year`= '$year' and `month`= '$month' order by id desc";
        $stmtInOutAll = $conn->query($inOutAllSql);
        $allInOut = $stmtInOutAll->fetchAll();
    } else // نمایش تمام ورودی خروجی ها
    {
        $inOutAllSql = "SELECT * FROM `inputoutput` order by id desc";
        $stmtInOutAll = $conn->query($inOutAllSql);
        $allInOut = $stmtInOutAll->fetchAll();
    }

    //حذف ورودی و خروجی با استفاده از فیلد آی دی
    if (isset($_GET['id'])) {
        try {
            $id = cleanUpInputs($_GET['id']);

            $sql = $conn->prepare("DELETE FROM `inputoutput` WHERE `inputoutput`.`id` = ?");
            $sql->bindParam(1, $id);
            $sql->execute();
            redirect('dashboard.php'); // رفرش صفحه تا لیست بروز شود
        } catch (PDOException $e) {
            $delError = 1; // خطا
        }
    }
    if (isset($delError)) {
        echo '<script type="text/javascript">  
                Swal.fire
                        ({    
                            text: "خطایی در حذف این ردیف رخ داده است",  
                            icon: "error", 
                            confirmButtonText: "تأیید"  
                        });
                </script>';
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>داشبورد | انبارداری</title>
        <link rel="stylesheet" href="../Assets/Css/fonts.css">
        <link rel="stylesheet" href="../Assets/Css/bootstrap.rtl.min.css">
        <link rel="stylesheet" href="../Assets/Css/Style.css">
        <link rel="stylesheet" href="../Assets/Css/all.css">
        <link rel="stylesheet" href="../Assets/Css/sweetalert2.min.css">
        <script src="../Assets/Js/sweetalert2.js"></script>

    </head>
    <?php

    ?>

    <body style="font-family: iranFamily;">

        <section class="row" style="width: 95%;text-align: center;margin: auto;display: inline-block;" dir="rtl">

            <div class="container" style="display: flex; justify-content: center; flex-direction: column; align-items: center;">

                <div class="row" style="width:100%; max-width:1200px;margin-bottom: 15px;">
                    <div class="card-group" style="text-align: center;">
                        <div class="card">
                            <div class="card-body" style="background-color: #ff9999;">
                                <h5 class="card-title">تعداد کالا ناموجود</h5>
                                <p class="card-text" style="font-family: iranFamily;"><?php echo $zeroQtyCount; ?></p>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body" style="background-color: #ffcc99;">
                                <h5 class="card-title">تعداد کالا کمتر از 5 عدد</h5>
                                <p class="card-text" style="font-family: iranFamily;"><?php echo $lessQtyCount; ?></p>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body" style="background-color: #99ff99;">
                                <h5 class="card-title">تعداد کالاهای دارای موجودی</h5>
                                <p class="card-text" style="font-family: iranFamily;"><?php echo $AllQtyCount; ?></p>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body" style="background-color: #99e2ff;">
                                <h5 class="card-title">تعداد کل کالاها</h5>
                                <p class="card-text" style="font-family: iranFamily;"><?php echo $sumQtyCount; ?></p>
                            </div>
                        </div>
                    </div>



                    <!-- فیلتر لیست کالاهای موجود در هر انبار -->
                    <div class="row" style="width:100%; max-width:1200px;margin-bottom: 15px;margin-right:0px;text-align: right;">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form-control dashboard" style="text-align: right;">

                            <select class="form-select" style="display: inline-block;" name="invName" id="invName" required>
                                <option value="nothing" selected disabled>انبار مورد نظر را انتخاب کنید</option>
                                <?php
                                $sqlSelectInv = $conn->query("select name,id from inv;");
                                $sqlSelectInv->execute();
                                foreach ($sqlSelectInv as $row):
                                ?>

                                    <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>

                                <?php
                                endforeach;
                                ?>
                            </select>

                            <button class="btn btn-primary" name="btnInv" type="submit" id="btnInv" style="float: left;">کالاهای انبار را لیست کن</button>
                        </form>

                    </div>


                    <?php
                    if (isset($_POST['btnInv'])) { // اگر دکمه فیلتر زده شده بود
                    ?>
                        <div class="row" style="width:100%; max-width:1200px;margin-bottom: 15px;margin-right:0px;text-align: right;">
                            <form class="form-control" style="padding:10px 5px 0px 5px;">
                                <table class="table">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">ردیف</th>
                                            <th scope="col">انبار</th>
                                            <th scope="col">کدینگ کالا</th>
                                            <th scope="col">نام کالا</th>
                                            <th scope="col">موجود در انبار</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $invId = $_POST['invName'];
                                        // واکشی اطلاعات کالای مورد نظر با کد انبار
                                        $invProductsListsSql = "SELECT * FROM `products` WHERE inv_id = (SELECT id from `inv` WHERE id = $invId)";
                                        $stmtInvProdutsList = $conn->query($invProductsListsSql);
                                        $invProductsList = $stmtInvProdutsList->fetchAll();

                                        // واکشی نام انبار با کد انباری که کاربر وارد کرده
                                        $invNameSql = "SELECT name FROM inv where id = $invId";
                                        $stmtinvName = $conn->query($invNameSql);
                                        $invName = $stmtinvName->fetchColumn();

                                        $rowNum = 1;
                                        foreach ($invProductsList as $row):
                                        ?>
                                            <tr>
                                                <th><?php echo $rowNum; ?></th>
                                                <td><?php echo $invName ?></td>
                                                <td><?php echo $row['p_codeing'] ?></td>
                                                <td><?php echo $row['p_name'] ?></td>
                                                <td><?php echo $row['p_qty'] ?></td>
                                            </tr>
                                        <?php
                                            $rowNum++;
                                        endforeach;
                                        ?>
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    <?php
                    } ?>


                    <!-- فیلتر لیست ورود و خروج کالا ها -->
                    <div class="row" style="width:100%; max-width:1200px;margin-bottom: 15px;margin-right:0px;text-align: right;">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form-control dashboard" style="text-align: right;">

                            <select class="form-select" style="display: inline-block;" name="year" id="year" required>
                                <option value="1403" selected>1403</option>
                                <option value="1404">1404</option>
                                <option value="1405">1405</option>
                            </select>

                            <select class="form-select" style="display: inline-block;" name="month" id="month" required>
                                <option value="01" selected>فروردین</option>
                                <option value="02">اردیبهشت</option>
                                <option value="03">خرداد</option>
                                <option value="04">تیر</option>
                                <option value="05">مرداد</option>
                                <option value="06">شهریور</option>
                                <option value="07">مهر</option>
                                <option value="08">آبان</option>
                                <option value="09">آذر</option>
                                <option value="10">دی</option>
                                <option value="11">بهمن</option>
                                <option value="12">اسفند</option>
                            </select>



                            <button class="btn btn-primary" name="btnFilter" type="submit" id="btnFilter" style="float: left;">لیست را فیلتر کن</button>
                        </form>

                    </div>

                    <div class="row" style="width:100%; max-width:1200px;margin-bottom: 15px;margin-right:0px;text-align: right;">



                        <?php
                        if (isset($_POST['btnFilter'])) { // اگر دکمه فیلتر زده شده بود
                            $i = 1;
                        ?>
                            <form class="form-control" style="padding:10px 5px 0px 5px;">
                                <table class="table">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">ردیف</th>
                                            <th scope="col">تاریخ</th>
                                            <th scope="col">ساعت</th>
                                            <th scope="col">ورود/خروج</th>
                                            <th scope="col">تعداد</th>
                                            <th scope="col">نام کالا</th>
                                            <th scope="col">کدینگ</th>
                                            <th scope="col">موجودی</th>
                                            <th scope="col" style="color: red;width: 20px;">حذف</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($allInOut as $row): ?>
                                            <tr <?php if ($row['in_out'] == 1) { // نمایش ورودی ها با رنگ سبز
                                                    echo "class='table-success'";
                                                } else if ($row['in_out'] == 2) { // نمایش خروجی ها با رنگ قرمز
                                                    echo "class='table-warning'";
                                                } ?>>
                                                <th scope="row"><?php echo $i++; ?></th>
                                                <td><?php echo htmlspecialchars($row['date']) ?></td>
                                                <td><?php echo htmlspecialchars($row['time']) ?></td>
                                                <td><?php if ($row['in_out'] == 1) {
                                                        echo "ورود"; // درصورتی که ردیفی فیلد ورودخروجش 1 باشد کلمه ورود چاپ شود 2 باشد خروج چاپ شود
                                                    } else if ($row['in_out'] == 2) {
                                                        echo "خروج";
                                                    } ?></td>
                                                <td><?php echo htmlspecialchars($row['qty']) ?></td>

                                                <?php //واکشی اسم محصول با استفاده از کلید خارجی پی آی دی
                                                $pID = $row['p_id'];
                                                $fetchProductNameSql = "select p_name from products where id = $pID";
                                                $stmtName = $conn->query($fetchProductNameSql);
                                                $pName = $stmtName->fetchColumn();
                                                ?>
                                                <?php //واکشی کدینگ کالای دارای گردش با استفاده از کلید خارجی
                                                $pID = $row['p_id'];
                                                $fetchProductCodeingSql = "select p_codeing from products where id = $pID";
                                                $stmtCodeing = $conn->query($fetchProductCodeingSql);
                                                $pCodeing = $stmtCodeing->fetchColumn();
                                                ?>
                                                <?php //واکشی تعداد موجودی کالای گردش داده شده 
                                                $pID = $row['p_id'];
                                                $fetchProductQTYSql = "select p_qty from products where id = $pID";
                                                $stmtQTY = $conn->query($fetchProductQTYSql);
                                                $pQTY = $stmtQTY->fetchColumn();
                                                ?>

                                                <td><?php echo $pName; ?></td>
                                                <td><?php echo $pCodeing; ?></td>
                                                <td><?php echo $pQTY; ?></td>
                                                <td><a style="color: black;" href="?id=<?php echo htmlspecialchars($row['id']) ?>"><i style="margin-right: 5px;" onmouseout="this.style.color='black';" onmouseover="this.style.color='red';" class="fa-thin fa-bin-recycle"></i></a></td>
                                            </tr>
                                    <?php endforeach;
                                    } ?>


                                    </tbody>
                                </table>
                            </form>
                    </div>

                </div>
            </div>
            <script src="../Assets/Js/bootstrap.bundle.min.js"></script>
            <script src="../Assets/Js/bootstrap.min.js"></script>
    </body>

    </html>

<?php
}
?>