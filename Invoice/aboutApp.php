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

هدف اصلی ما در شرکت داده فراز ایجاد راهکارهایی مناسب جهت رشد کسب و کارها با استفاده از بستر وسیع اینترنت است. تلاش کرده ایم تا به روز بودن، رعایت استانداردها، ایجاد ارزش افزوده و همیشه در حال رشد بودن بخشی از فرهنگ سازمانی مان باشد.
<br>
شرکت طراحی و توسعه فناوری اطلاعات داده فراز در سال 1401 برای فعالیت در زمینه طراحی انواع وب سایت شروع به فعالیت کرد.
<br>
نیاز مشتریان در زمینه های غیر از توسعه وبسایت باعث گسترس زمینه های فعالیت در حوزه تکنولوژی داده فرار شد و در حال حاضر داده فراز پاسخگوی تمام نیاز های شما در زمینه وب و نرم افزار های تحت وب اختصاصی و فضای مجازی و تولید محتوا می باشد
                    </p>
                    <p style="text-align: justify;">
                        <a href="https://www.dadefaraz.ir" target="_blank" style="text-decoration: none;">وب سایت داده فراز</a>
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