<?php
    session_start();
    require_once '../Scripts/dbConnect.php';
    require_once '../Scripts/functions.php';

    //Check the User Session Login , If Session Doesn't Set
    //Then Redirect To The Login Page And If Login Is Set Show The Page
    if(!isset($_SESSION['logged_in']))
    {
        redirect('../');
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
    <title>اشخاص</title>

    <link rel="stylesheet" href="../Assets/Css/fonts.css">
    <link rel="stylesheet" href="../Assets/Css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="../Assets/Css/Style.css">
    <link rel="stylesheet" href="../Assets/Css/all.css">
</head>
<body dir="rtl">
    <main class="container updateProduct">
        <section class="row phoneNumber">

            <div class="col">
            
                    <h3 class="blue-color">
                        شرکت طرح و توسعه داده فراز
                    </h3>
                    <p style="text-align: justify;">
                        داده فراز یک شرکت نرم افزاری می باشد که فعالیت اصلی آن طراحی و توسعه انواع وب سایت های تخصصی می باشد ، همچنین نرم افزار انبارداری و حسابداری داده فراز با قیمت بسیار مقرون به صرف گزینه ای عالی برای کسب و کار های خرده و کوچک می باشد تا بتوانند با هزینه ای کم امکانات نرم افزارهای انبارداری و حسابداری را برای مدیریت کالا ها و دخل و خرج خود را داشته باشند.
                    </p>
                    <p style="text-align: justify;">
                        راه های ارتباطی با داده فراز : 09146528873
                    </p>
                    <p style="text-align: justify;">
                        تلگرام : @persvens
                    </p>
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