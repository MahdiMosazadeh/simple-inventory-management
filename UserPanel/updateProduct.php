<?php
    session_start();
    require_once '../Scripts/dbConnect.php';
    require_once '../Scripts/functions.php';

    if(!isset($_SESSION['logged_in']))
    {
        redirect('../index.php');
    }
    else
    {
?>
<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../Assets/Images/finger.png" />
    <title>اصلاح محصول</title>

    <link rel="stylesheet" href="../Assets/Css/fonts.css">
    <link rel="stylesheet" href="../Assets/Css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="../Assets/Css/Style.css">
    <link rel="stylesheet" href="../Assets/Css/all.css">
</head>
<body dir="rtl">
    <main class="container updateProduct">
        <section class="row">
            <div class="col">
                <form action="" method="post" class="form-control">
                    <h3 class="blue-color">
                    اصلاح کالای تعریف شده
                    </h3>
                    <p>
                    ابتدا نام کالا یا کدینگ آن را وارد کرده و دکمه "جستجوی کالا" را بزنید سپس مواردی که قصد دارید اصلاح کنید را بروزرسانی کرده و دکمه "بروزرسانی کالا" را بزنید
                    </p>
                    <input type="number" name="" id="" class="form-control" style="direction: rtl" placeholder="کدینگ" oninvalid="this.setCustomValidity('شماره گذاری کالا ها')" oninput="setCustomValidity('')">
                    <input type="text" name="" id="" class="form-control" style="direction: rtl" placeholder="نام کالا" required="required" oninvalid="this.setCustomValidity('نام کامل کالا را وارد کنید')" oninput="setCustomValidity('')">
                    <input type="text" name="" id="" class="form-control" style="direction: rtl" placeholder="محل استقرار کالا" required="required" oninvalid="this.setCustomValidity('محل قرارگیری کالا را وارد کنید')" oninput="setCustomValidity('')">
                    <input type="text" name="" id="" class="form-control" style="direction: rtl" placeholder="واحد سنجش کالا (به طور مثال : عدد)" required="required" oninvalid="this.setCustomValidity('واحد سنجش کالا را وارد کنید')" oninput="setCustomValidity('')">
                    <input type="number" name="" id="" class="form-control" min="0" max="10000000" step="1" style="direction: rtl" placeholder="موجودی اولیه" required="required" oninvalid="this.setCustomValidity('نمیتواند اعشار یا خالی باشد')" oninput="setCustomValidity('')">
                    <input type="text" name="" id="" class="form-control" style="direction: rtl" placeholder="توضیحات" oninvalid="this.setCustomValidity('توضیحات')" oninput="setCustomValidity('')">
                    <button type="submit"  class="btn btn-dark">جستجوی کالا</button>
                    <button type="submit"  class="btn btn-primary">بروزرسانی کالا</button>
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