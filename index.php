<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="./Assets/Images/finger.png" />
    <title>صفحه ورود</title>

    <link rel="stylesheet" href="./Assets/Css/fonts.css">
    <link rel="stylesheet" href="./Assets/Css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="./Assets/Css/Style.css">
    <link rel="stylesheet" href="./Assets/Css/all.css">
</head>
<body dir="rtl">
    <main class="container">
        <section class="row login-system">
            <div class="col">
                <img src="./Assets/Images/logo.png" alt="لولوی داده فراز">
                <form action="./login/login.php" method="post" class="form-control">
                    <input class="form-control" type="text"  required="required" placeholder="نام کاربری" oninvalid="this.setCustomValidity('لطفا نام کاربری یا یوزرنیم خود را وارد کنید')" oninput="setCustomValidity('')"></input>
                    <input class="form-control" type="password"  required="required" placeholder="رمز عبور" oninvalid="this.setCustomValidity('لطفا نام گذرواژه یا پسورد خود را وارد کنید')" oninput="setCustomValidity('')"></input>
                    <button type="submit" class="btn btn-primary form-control" name="select-system">ورود</button>
                </form>
            </div>
        </section>
    </main>
<script src="./Assets/Js/bootstrap.bundle.min.js"></script>
<script src="./Assets/Js/bootstrap.min.js"></script>
</body>
</html>