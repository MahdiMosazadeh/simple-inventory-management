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
    <title>اشخاص</title>

    <link rel="stylesheet" href="../Assets/Css/fonts.css">
    <link rel="stylesheet" href="../Assets/Css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="../Assets/Css/Style.css">
    <link rel="stylesheet" href="../Assets/Css/all.css">
</head>
<body dir="rtl">
    <main class="container updateProduct">
        <section class="row phoneNumber">

            <div class="col col-12 col-sm-12 col-md-4">
            <form action="" method="post" class="form-control">
                    <h3 class="blue-color">
                        شخص جدید
                    </h3>
                    <input type="text" name="" id="" class="form-control" style="direction: rtl" placeholder="نام و نام خانوادگی" oninvalid="this.setCustomValidity('لطفا نام و نام خانوادگی شخص را وارد کنید')" oninput="setCustomValidity('')">
                    <input type="text" name="" id="" class="form-control" style="direction: rtl" placeholder="نوع (مثلا : شخص ، شرکت ، مشتری و ...)" required="required" oninvalid="this.setCustomValidity('نوع شخص یا شرکت را وارد کنید')" oninput="setCustomValidity('')">
                    <input type="text" name="" id="" class="form-control" style="direction: rtl" placeholder="آدرس" required="required" oninvalid="this.setCustomValidity('آدرس را وارد کنید')" oninput="setCustomValidity('')">
                    <input type="number" name="" id="" class="form-control" min="0" step="1" style="direction: rtl" placeholder="شماره تماس" required="required" oninvalid="this.setCustomValidity('تلفن را وارد کنید')" oninput="setCustomValidity('')">
                    <button type="submit"  class="btn btn-primary">ثبت شخص</button>
                </form>
            </div>

            <div class="col">
                <form action="" class="form-control" method="post">
                <h3 class="blue-color">
                    لیست اشخاص
                </h3>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ردیف</th>
                            <th scope="col">اسم</th>
                            <th scope="col">نوع</th>
                            <th scope="col">آدرس</th>
                            <th scope="col">شماره</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th scope="row">1</th>
                            <td>مهدی موسی زاده</td>
                            <td>مشتری</td>
                            <td>تبریز، میدان آذربایجان ، پایگاه دوم شکاری</td>
                            <td>09146528873</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>داده فراز</td>
                            <td>شرکت</td>
                            <td>تبریز،آخرشهناز، چهارراه طالقانی قدیم</td>
                            <td>09146528873</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>مهدی موسی زاده</td>
                            <td>مشتری</td>
                            <td>تبریز، میدان آذربایجان ، پایگاه دوم شکاری</td>
                            <td>09146528873</td>
                        </tr>
                        <tr>
                            <th scope="row">4</th>
                            <td>مهدی موسی زاده</td>
                            <td>مشتری</td>
                            <td>تبریز، میدان آذربایجان ، پایگاه دوم شکاری</td>
                            <td>09146528873</td>
                        </tr>
                    </tbody>
                </table>
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