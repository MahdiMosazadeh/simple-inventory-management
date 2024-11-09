<?php
session_start();
require_once '../Scripts/dbConnect.php';
require_once '../Scripts/functions.php';

//Check the User Session Login , If Session Doesn't Set
//Then Redirect To The Login Page And If Login Is Set Show The Page
if (!isset($_SESSION['logged_in'])) {
    redirect('../');
} else {


?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>فاکتور غیررسمی | صدور فاکتور</title>
        <link rel="stylesheet" href="../Assets/Css/fonts.css">
        <link rel="stylesheet" href="../Assets/Css/bootstrap.rtl.min.css">
        <link rel="stylesheet" href="../Assets/Css/Style.css">
        <link rel="stylesheet" href="../Assets/Css/all.css">
        <link rel="stylesheet" href="../Assets/Css/sweetalert2.min.css">
        <script src="../Assets/Js/sweetalert2.js"></script>

    </head>
    <?php

    ?>

    <body style="font-family: iranFamily;">
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" <?php if (isset($_POST['rowsBtn'])) {echo 'style="display:none;"';} ?>>
            <input type="number" size="2" min="1" max="10" name="rows" require>
            <button type="submit" name="rowsBtn">تعداد ردیف فاکتور</button>
        </form>
        <?php if (isset($_POST['rowsBtn']) and isset($_POST['rows']))
        {
            $rowsCount = $_POST['rows'];
        ?>
        <section class="row" style="width: 95%;margin: auto;display: inline-block;" dir="rtl">
            <h4>فاکتور فروش</h4>
            <form action="" method="post">
                <select name="year" id="">
                    <option value="1400">1400</option>
                    <option value="1401">1401</option>
                    <option value="1402">1402</option>
                    <option value="1403" selected>1403</option>
                    <option value="1404">1404</option>
                </select>

                <select name="month" id="">
                    <option value="1" selected>فروردین</option>
                    <option value="2">اردیبهشت</option>
                    <option value="3">خرداد</option>
                    <option value="4">تیر</option>
                    <option value="5">مرداد</option>
                    <option value="6">شهریور</option>
                    <option value="7">مهر</option>
                    <option value="8">آبان</option>
                    <option value="9">آذر</option>
                    <option value="10">دی</option>
                    <option value="11">بهمن</option>
                    <option value="12">اسفند</option>
                </select>

                <select name="day" id="">
                    <?php $day = 1;
                    while ($day < 32) { ?>
                        <option value="<?php echo $day; ?>"><?php echo $day; ?></option>
                    <?php $day++;
                    } ?>
                </select>
                <br><br>
                <input type="text" placeholder="نام فروشنده">
                <input type="text" placeholder="نام خریدار">
                <br><br>
                <input type="text" placeholder="شماره تماس فروشنده">
                <input type="text" placeholder="شماره تماس خریدار">
                <input type="text" placeholder="آدرس فروشنده">
                <br><br>

                <?php for ($rowsCount ; $rowsCount > 0 ; $rowsCount--) { ?>
                    <input type="text" placeholder="شرح کالا" name="<?php echo $rowsCount; ?>">
                    <input type="text" placeholder="تعداد" name="<?php echo $rowsCount; ?>">
                    <input type="text" placeholder="قیمت واحد" name="<?php echo $rowsCount; ?>">
                    <br>
                <?php } ?>
                <button type="submit">صدور فاکتور فروش</button>
            </form>
        </section>

        <?php } ?>
        <script src="../Assets/Js/bootstrap.bundle.min.js"></script>
        <script src="../Assets/Js/bootstrap.min.js"></script>
    </body>

    </html>

<?php
}
?>