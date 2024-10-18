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
        <title>داشبورد | صدور فاکتور</title>
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

        <section class="row" style="width: 95%;text-align: center;margin: auto;display: inline-block;" dir="rtl">

            dashboard
        </section>
            <script src="../Assets/Js/bootstrap.bundle.min.js"></script>
            <script src="../Assets/Js/bootstrap.min.js"></script>
    </body>

    </html>

<?php
}
?>