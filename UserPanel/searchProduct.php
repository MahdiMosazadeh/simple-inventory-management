<?php
    session_start();
    require_once '../Scripts/dbConnect.php';
    require_once '../Scripts/functions.php';

    //Check the User Session Login , If Session Doesn't Set
    //Then Redirect To The Login Page And If Login Is Set Show The Page
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
    <title>معرفی کالا</title>

    <link rel="stylesheet" href="../Assets/Css/fonts.css">
    <link rel="stylesheet" href="../Assets/Css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="../Assets/Css/Style.css">
    <link rel="stylesheet" href="../Assets/Css/all.css">
</head>
<body dir="rtl">
    <main class="container searchProduct">
        <section class="row">
            <div class="col">
                <form action="" method="post" class="form-control">
                    <h3 class="blue-color">
                        جستجوی کالا
                    </h3>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="قسمتی از نام کالا را وارد کنید" aria-label="Example text with button addon" aria-describedby="button-addon1">
                        <button class="btn btn-outline-secondary" type="button" id="button-addon1">جستجو</button>
                    </div>
                    <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ردیف</th>
                            <th scope="col">کدینگ</th>
                            <th scope="col">نام</th>
                            <th scope="col">استقرار</th>
                            <th scope="col">واحد</th>
                            <th scope="col">تعداد</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                            <th scope="row">1</th>
                            <td>14673</td>
                            <td>آچار فرانسه کوچک</td>
                            <td>انبار ابزار | قفسه 4</td>
                            <td>عدد</td>
                            <td>4</td>
                        </tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>14674</td>
                            <td>آچار فرانسه بزرگ</td>
                            <td>انبار ابزار | قفسه 5</td>
                            <td>عدد</td>
                            <td>3</td>
                        </tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>14673</td>
                            <td>آچار فرانسه کوچک</td>
                            <td>انبار ابزار | قفسه 4</td>
                            <td>عدد</td>
                            <td>4</td>
                        </tr>
                        <tr>
                            <th scope="row">4</th>
                            <td>14674</td>
                            <td>آچار فرانسه بزرگ</td>
                            <td>انبار ابزار | قفسه 5</td>
                            <td>عدد</td>
                            <td>3</td>
                        </tr>
                    </tbody>
                </table>
                </form>
            </div>
        </section>
        <section class="row" style="margin-top: 15px;">
            <div class="col">
            <form action="" method="post" class="form-control">
                    <h3 class="blue-color">
                        جستجوی شخص
                    </h3>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="قسمتی از نام شخص را وارد کنید" aria-label="Example text with button addon" aria-describedby="button-addon1">
                        <button class="btn btn-outline-secondary" type="button" id="button-addon1">جستجو</button>
                    </div>
                    <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ردیف</th>
                            <th scope="col">نام</th>
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
                            <td>تبریز، میدان آذربایجان، ارم</td>
                            <td>09146528873</td>
                            </tr>
                        <tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>علی ولی زاده</td>
                            <td>فروشنده</td>
                            <td>تبریز، میدان آذربایجان، ارم</td>
                            <td>09143452873</td>
                            </tr>
                        <tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>مهدی موسی زاده</td>
                            <td>مشتری</td>
                            <td>تبریز، میدان آذربایجان، ارم</td>
                            <td>09146528873</td>
                            </tr>
                        <tr>
                        <tr>
                            <th scope="row">4</th>
                            <td>علی ولی زاده</td>
                            <td>فروشنده</td>
                            <td>تبریز، میدان آذربایجان، ارم</td>
                            <td>09143452873</td>
                            </tr>
                        <tr>
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