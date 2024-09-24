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
    $stmt = $conn -> query($sqlZeroQty);
    $zeroQtyCount = $stmt -> fetchColumn();

    // select and fetch less than 5 qty products.
    $sqlLessQty = "SELECT COUNT(*) FROM `products` WHERE p_qty <= 5;";
    $stmtLess = $conn -> query($sqlLessQty);
    $lessQtyCount = $stmtLess -> fetchColumn();

    // select all qty products.
    $sqlAllQty = "SELECT COUNT(*) FROM `products`";
    $stmtAll = $conn -> query($sqlAllQty);
    $AllQtyCount = $stmtAll -> fetchColumn();
    $conn = null;
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
              <h5 class="card-title">تعداد کل موجودی کالا</h5>  
              <p class="card-text" style="font-family: iranFamily;"><?php echo $AllQtyCount; ?></p>  
            </div>  
          </div>  
        </div>  




        <div class="row" style="width:100%; max-width:1200px;margin-bottom: 15px;margin-right:0px;text-align: right;">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form-control" style="margin-top: 10px;">

                <label for="year">سال</label>
                <select class="form-select" style="display: inline-block;" name="year" id="year" required>
                    <option value="allYear" selected>تمام سال ها</option>
                    <option value="1404">1405</option>
                    <option value="1404">1404</option>
                    <option value="1404">1403</option>
                </select>

                <label for="month">ماه</label>
                <select class="form-select" style="display: inline-block;" name="month" id="month" required>
                    <option value="allMonth" selected>تمام ماه ها</option>
                    <option value="01">فروردین</option>
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
                
                <label for="day">روز</label>
                <select class="form-select" style="display: inline-block;" name="day" id="day" required>
                    <option value="allDay" selected>تمام روز ها</option>
                    <?php
                        $i = 01;
                        while($i <= 31)
                        {
                            if($i < 10)
                            {
                                (int)$i = 0 . $i;
                                echo "<option value=".$i.">".$i."</option>";
                                $i++;
                            }
                            else
                            {
                                echo "<option value=".$i.">".$i."</option>";
                                $i++;
                            }
                        }
                    ?>

                </select>

                <button class="btn btn-primary" style="width: 100%;margin-top: 15px;" name="productSearchBtn" type="submit" id="btnFilter">لیست را فیلتر کن</button>
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