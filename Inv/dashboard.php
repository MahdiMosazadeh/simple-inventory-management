<?php
session_start();
require_once '../Scripts/dbConnect.php';
require_once '../Scripts/functions.php';

//Check the User Session Login , If Session Doesn't Set
//Then Redirect To The Login Page And If Login Is Set Show The Page
if (!isset($_SESSION['logged_in'])) {
    redirect('../');
} else {
    // select and fetch zero qty products.
    $sqlZeroQty = "SELECT COUNT(*) FROM `products` WHERE p_qty=0;";
    $stmt = $conn->query($sqlZeroQty);
    $zeroQtyCount = $stmt->fetchColumn();

    // select and fetch less than 5 qty products.
    $sqlLessQty = "SELECT COUNT(*) FROM `products` WHERE p_qty <= 5;";
    $stmtLess = $conn->query($sqlLessQty);
    $lessQtyCount = $stmtLess->fetchColumn();

    // select all qty products.
    $sqlAllQty = "SELECT COUNT(*) FROM `products`";
    $stmtAll = $conn->query($sqlAllQty);
    $AllQtyCount = $stmtAll->fetchColumn();

    // select all qty products. all SUM QTY
    $sqlSUMQty = "SELECT SUM(p_qty) FROM `products`";
    $stmtSUM = $conn->query($sqlSUMQty);
    $sumQtyCount = $stmtSUM->fetchColumn();

    // Select All Input Outputs
    if (isset($_POST['btnFilter'])) {
        $year = strval($_POST['year']);
        $month = strval($_POST['month']);

        $inOutAllSql = "SELECT * FROM `inputoutput` where `year`= '$year' and `month`= '$month' order by date desc";
        $stmtInOutAll = $conn->query($inOutAllSql);
        $allInOut = $stmtInOutAll->fetchAll();
    }
    else
    {
        $inOutAllSql = "SELECT * FROM `inputoutput` order by date desc";
        $stmtInOutAll = $conn->query($inOutAllSql);
        $allInOut = $stmtInOutAll->fetchAll();
    }

    //delete inputoutput by id
    if (isset($_GET['id'])) {
        try
        {
            $id = cleanUpInputs($_GET['id']);

            $sql = $conn->prepare("DELETE FROM `inputoutput` WHERE `inputoutput`.`id` = ?");
            $sql->bindParam(1, $id);
            $sql->execute();
        }
        catch (PDOException $e)
        {
            $delError = 1;
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

                    <div class="row" style="width:100%; max-width:1200px;margin-bottom: 15px;margin-right:0px;text-align: right;">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" class="form-control dashboard">

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



                            <button class="btn btn-primary" name="btnFilter" type="submit" id="btnFilter">لیست را فیلتر کن</button>
                        </form>

                    </div>

                    <div class="row" style="width:100%; max-width:1200px;margin-bottom: 15px;margin-right:0px;text-align: right;">
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
                                    if (isset($_POST['btnFilter'])) {
                                    $i = 1;
                                    foreach ($allInOut as $row): ?>
                                        <tr <?php if ($row['in_out'] == 1) {
                                                echo "class='table-success'";
                                            } else if ($row['in_out'] == 2) {
                                                echo "class='table-warning'";
                                            } ?>>
                                            <th scope="row"><?php echo $i++; ?></th>
                                            <td><?php echo htmlspecialchars($row['date']) ?></td>
                                            <td><?php echo htmlspecialchars($row['time']) ?></td>
                                            <td><?php if ($row['in_out'] == 1) {
                                                    echo "ورود";
                                                } else if ($row['in_out'] == 2) {
                                                    echo "خروج";
                                                } ?></td>
                                            <td><?php echo htmlspecialchars($row['qty']) ?></td>

                                            <?php //fetch P_name from Product with FK
                                            $pID = $row['p_id'];
                                            $fetchProductNameSql = "select p_name from products where id = $pID";
                                            $stmtName = $conn->query($fetchProductNameSql);
                                            $pName = $stmtName->fetchColumn();
                                            ?>
                                            <?php //fetch P_codeing from Product with FK
                                            $pID = $row['p_id'];
                                            $fetchProductCodeingSql = "select p_codeing from products where id = $pID";
                                            $stmtCodeing = $conn->query($fetchProductCodeingSql);
                                            $pCodeing = $stmtCodeing->fetchColumn();
                                            ?>
                                            <?php //fetch P_QTY from Product with FK
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
                                    <?php endforeach;} ?>

                                    <?php
                                    if (!isset($_POST['btnFilter'])) {
                                    $i = 1;
                                    foreach ($allInOut as $row): ?>
                                        <tr <?php if ($row['in_out'] == 1) {
                                                echo "class='table-success'";
                                            } else if ($row['in_out'] == 2) {
                                                echo "class='table-warning'";
                                            } ?>>
                                            <th scope="row"><?php echo $i++; ?></th>
                                            <td><?php echo htmlspecialchars($row['date']) ?></td>
                                            <td><?php echo htmlspecialchars($row['time']) ?></td>
                                            <td><?php if ($row['in_out'] == 1) {
                                                    echo "ورود";
                                                } else if ($row['in_out'] == 2) {
                                                    echo "خروج";
                                                } ?></td>
                                            <td><?php echo htmlspecialchars($row['qty']) ?></td>

                                            <?php //fetch P_name from Product with FK
                                            $pID = $row['p_id'];
                                            $fetchProductNameSql = "select p_name from products where id = $pID";
                                            $stmtName = $conn->query($fetchProductNameSql);
                                            $pName = $stmtName->fetchColumn();
                                            ?>
                                            <?php //fetch P_codeing from Product with FK
                                            $pID = $row['p_id'];
                                            $fetchProductCodeingSql = "select p_codeing from products where id = $pID";
                                            $stmtCodeing = $conn->query($fetchProductCodeingSql);
                                            $pCodeing = $stmtCodeing->fetchColumn();
                                            ?>
                                            <?php //fetch P_QTY from Product with FK
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
                                    <?php endforeach;} ?>
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