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
    <title>معرفی کالا</title>

    <link rel="stylesheet" href="../Assets/Css/fonts.css">
    <link rel="stylesheet" href="../Assets/Css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="../Assets/Css/Style.css">
    <link rel="stylesheet" href="../Assets/Css/all.css">
</head>
<body dir="rtl">
    <main class="container statisticsProduct">
        <section class="row">
            <div class="col">
                <form action="" method="post" class="form-control">
                <h3 class="red-color">
                        ناموجود 
                    </h3>
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

                <h3 class="orange-color">
                        در آستانه اتمام
                    </h3>
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

                <h3 class="blue-color">
                        لیست کامل کالا ها
                    </h3>
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
    </main>
<script src="../Assets/Js/bootstrap.bundle.min.js"></script>
<script src="../Assets/Js/bootstrap.min.js"></script>
</body>
</html>
<?php
    }
?>