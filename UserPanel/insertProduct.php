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
</head>
<body dir="rtl" style="background-color: #eee;">
    <main class="container">
        <section class="row" >
            <div class="col insertProduct">
                <h3>
                    معرفی کالا جدید
                </h3>
                <form action="" method="post" class="form-control">
                <input type="number" name="" id="" class="form-control" style="direction: rtl" placeholder="کدینگ (اختیاری)" oninvalid="this.setCustomValidity('شماره گذاری کالا ها')" oninput="setCustomValidity('')">
                <input type="text" name="" id="" class="form-control" style="direction: rtl" placeholder="نام کالا" required="required" oninvalid="this.setCustomValidity('نام کامل کالا را وارد کنید')" oninput="setCustomValidity('')">
                <input type="text" name="" id="" class="form-control" style="direction: rtl" placeholder="محل استقرار کالا" required="required" oninvalid="this.setCustomValidity('محل قرارگیری کالا را وارد کنید')" oninput="setCustomValidity('')">
                <input type="text" name="" id="" class="form-control" style="direction: rtl" placeholder="واحد سنجش کالا (به طور مثال : عدد)" required="required" oninvalid="this.setCustomValidity('واحد سنجش کالا را وارد کنید')" oninput="setCustomValidity('')">
                <input type="number" name="" id="" class="form-control" min="0" max="10000000" step="1" style="direction: rtl" placeholder="موجودی اولیه" required="required" oninvalid="this.setCustomValidity('نمیتواند اعشار یا خالی باشد')" oninput="setCustomValidity('')">
                <input type="text" name="" id="" class="form-control" style="direction: rtl" placeholder="توضیحات (اختیاری)" oninvalid="this.setCustomValidity('توضیحات')" oninput="setCustomValidity('')">
                <button type="submit"  class="btn btn-primary">ثبت کالای جدید</button>
                </form>
            </div>
        </section>
    </main>
<script src="../Assets/Js/bootstrap.bundle.min.js"></script>
<script src="../Assets/Js/bootstrap.min.js"></script>
</body>
</html>