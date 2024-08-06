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
</head>
<body dir="rtl" style="background-color: #eee;">
    <main class="container">
    <section class="row" >
            <div class="col in">
                <h3>
                    ورود کالا
                </h3>
                <form action="" method="post" class="form-control">
                <input type="number" name="" id="" class="form-control" min="0" max="10000000" step="1" style="direction: rtl" placeholder="کدینگ" oninvalid="this.setCustomValidity('کدینگ کالا نمیتواند اعشاری باشد')" oninput="setCustomValidity('')">
                <h5>
                    یا
                </h5>
                <input type="text" name="" id="" class="form-control" style="direction: rtl" placeholder="قسمت از نام کالا را وارد کرده و انتخاب کنید" required="required" oninvalid="this.setCustomValidity('نام کامل کالا را وارد کنید')" oninput="setCustomValidity('')">
                <input type="number" name="" id="" class="form-control" min="0" max="10000000" step="1" style="direction: rtl" placeholder="تعداد" required="required" oninvalid="this.setCustomValidity('نمیتواند اعشار یا خالی باشد')" oninput="setCustomValidity('')">
                <button type="submit"  class="btn btn-primary">ورود کالا</button>
                </form>
            </div>
        </section>

        <section class="row" >
            <div class="col out">
                <h3>
                    خروج کالا
                </h3>
                <form action="" method="post" class="form-control">
                <input type="number" name="" id="" class="form-control" min="0" max="10000000" step="1" style="direction: rtl" placeholder="کدینگ" oninvalid="this.setCustomValidity('کدینگ کالا نمیتواند اعشاری باشد')" oninput="setCustomValidity('')">
                <h5>
                    یا
                </h5>
                <input type="text" name="" id="" class="form-control" style="direction: rtl" placeholder="قسمت از نام کالا را وارد کرده و انتخاب کنید" required="required" oninvalid="this.setCustomValidity('نام کامل کالا را وارد کنید')" oninput="setCustomValidity('')">
                <input type="number" name="" id="" class="form-control" min="0" max="10000000" step="1" style="direction: rtl" placeholder="تعداد" required="required" oninvalid="this.setCustomValidity('نمیتواند اعشار یا خالی باشد')" oninput="setCustomValidity('')">
                <button type="submit"  class="btn btn-primary">خروج کالا</button>
                </form>
            </div>
        </section>
    </main>
<script src="../Assets/Js/bootstrap.bundle.min.js"></script>
<script src="../Assets/Js/bootstrap.min.js"></script>
</body>
</html>