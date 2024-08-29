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
    <title>پنل مدیریت کاربر</title>

    <link rel="stylesheet" href="../Assets/Css/fonts.css">
    <link rel="stylesheet" href="../Assets/Css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="../Assets/Css/Style.css">
    <link rel="stylesheet" href="../Assets/Css/all.css">
</head>
<body dir="rtl" style="background-color: #eee;">
    <main class="container">
        <section class="row" >
            <div class="col">
                <nav class="navbar bg-body-tertiary fixed-top" style="box-shadow: 0px 0px 5px #ccc;">
                    <div class="container-fluid">
                        <img src="../Assets/Images/finger.png" alt="لوگو بند انگشتی داده فراز" width="35px">
                        <a class="navbar-brand" href="#">پنل مدیریت کالا</a>
                        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
                                <div class="offcanvas-header">
                                    <h5 class="offcanvas-title" id="offcanvasNavbarLabel">مدیریت انبار داده فراز</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                </div>
                            <div class="offcanvas-body">
                                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                                    <li class="nav-item">
                                        <a target="user-panel-frame" class="nav-link active" aria-current="page" href="dashboard.php"><i class="fa-solid fa-gauge"></i> داشبورد</a>
                                    </li>
                                    <li class="nav-item">
                                        <a target="user-panel-frame" class="nav-link" href="insertProduct.php"><i class="fa-solid fa-square-plus"></i> معرفی کالا</a>
                                    </li>
                                    <li class="nav-item">
                                        <a target="user-panel-frame" class="nav-link" href="inAndOutProdact.php"><i class="fa-solid fa-arrow-down-arrow-up"></i> ورود / خروج کالا</a>
                                    </li>
                                    <li class="nav-item">
                                        <a target="user-panel-frame" class="nav-link" href="searchProduct.php"><i class="fa-solid fa-magnifying-glass"></i> جستجو</a>
                                    </li>
                                    <li class="nav-item">
                                        <a target="user-panel-frame" class="nav-link" href="statisticsProduct.php"><i class="fa-solid fa-chart-simple"></i> آمار</a>
                                    </li>
                                    <li class="nav-item">
                                        <a target="user-panel-frame" class="nav-link" href="updateProduct.php"><i class="fa-solid fa-pen-to-square"></i> اصلاح کالا</a>
                                    </li>
                                    <li class="nav-item">
                                        <a target="user-panel-frame" class="nav-link" href="phoneNumbers.php"><i class="fa-duotone fa-solid fa-book-user"></i> اشخاص</a>
                                    </li>
                                    <li class="nav-item">
                                        <a target="user-panel-frame" class="nav-link" href="aboutApp.php"><i class="fa-solid fa-address-card"></i> درباره داده فراز</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="<?php $_SESSION['logged_in']= null; echo "../index"; ?>"><i class="fa-solid fa-right-from-bracket"></i> خروج</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </section>
                
        <section class="row">
            <div class="col dash-main">
                <iframe src="dashboard.php" frameborder="0" name="user-panel-frame">
                
                </iframe>
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