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
    <title>حسابداری | انبارداری داده فراز</title>

    <link rel="stylesheet" href="../Assets/Css/fonts.css">
    <link rel="stylesheet" href="../Assets/Css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="../Assets/Css/Style.css">
    <link rel="stylesheet" href="../Assets/Css/all.css">
</head>
<body dir="rtl">
    <main class="container">
        <section class="row select-system">
            <div class="col">
                <img src="../Assets/Images/logo.png" alt="لولوی داده فراز">
                <form action="check.php" method="post" class="form-control">
                    <label for="select" class="lable-control">سیستم مورد نظر را انتخاب کنید</label>
                    <select id="select" class="form-select">
                        <option value="1" disabled>حسابداری</option>
                        <option value="2">انبارداری</option>
                    </select>
                    <button type="submit" class="btn btn-primary form-control" name="select-system">انتخاب سیستم</button>
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