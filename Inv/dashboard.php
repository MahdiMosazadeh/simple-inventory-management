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
        <script src="../Assets/Js/Chart.min.js"></script>
    </head>

    <body style="font-family: iranFamily;">

        <section class="row" style="width: 95%;text-align: center;margin: auto;display: inline-block;" dir="rtl">

        <div class="container" style="display: flex; justify-content: center; flex-direction: column; align-items: center;">  

    <div class="row" style="width:100%; max-width:800px;margin-bottom: 15px;">  
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
    </div>  

    <div class="row" style="width:100%; max-width:800px;">  
        <canvas id="myChart" style="width:100%; max-width:800px;"></canvas>  
        <script>  
            const xValues = ['فروردین', 'اردیبهشت', 'خرداد', 'تیر', 'مرداد', 'شهریور', 'مهر', 'آبان', 'آذر', 'دی', 'بهمن', 'اسفند'];  

            new Chart("myChart", {  
                type: "line",  
                data: {  
                    labels: xValues,  
                    datasets: [{  
                            data: [20, 40, 30, 70, 10, 5, 100, 40, 25, 32],  
                            borderColor: "red",  
                            fill: false  
                        },  
                        {  
                            data: [0, 70, 30, 200, 125, 75, 45, 140, 400, 100],  
                            borderColor: "blue",  
                            fill: false  
                        }  
                    ]  
                },  
                options: {  
                    legend: {  
                        display: false  
                    },  
                    title: {  
                        display: true,  
                        text: "1403 ورود / خروج"  
                    }  
                }  
            });  
        </script>  
    </div>  
</div>
        <script src="../Assets/Js/bootstrap.bundle.min.js"></script>
        <script src="../Assets/Js/bootstrap.min.js"></script>
    </body>

    </html>

<?php
}
?>