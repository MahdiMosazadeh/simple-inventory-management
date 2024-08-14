<?php
session_start();
require_once './Scripts/dbConnect.php';
require_once './Scripts/functions.php';

if (isset($_POST['loginBtn']))
{
    //filter user and pass with function cleanUpInputs.
    $userName = cleanUpInputs($_POST['userName']);
    $passWord = cleanUpInputs($_POST['passWord']);
    
    $sql = $conn->prepare("SELECT * FROM users WHERE username= :user and password= :pass");
    $sql -> bindParam(':user',$userName);
    $sql -> bindParam(':pass',$passWord);
    $sql->execute();
    $conn = null;
    
    if ($sql -> rowCount() > 0)
    {
        $_SESSION['logged_in']= $username;
        redirect('./login/login.php');
    }
    else
    {
        $incorrect = true;
    }
}

?>
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
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="form-control">
                    <?php if(isset($incorrect)){echo "<script>alert('نام کاربری یا رمزعبور اشتباه است');</script>";} ?>
                    <input id="userName" name="userName" class="form-control" type="text"  required="required" placeholder="نام کاربری" oninvalid="this.setCustomValidity('لطفا نام کاربری یا یوزرنیم خود را وارد کنید')" oninput="setCustomValidity('')"></input>
                    <input id="passWord" name="passWord" class="form-control" type="password"  required="required" placeholder="رمز عبور" oninvalid="this.setCustomValidity('لطفا نام گذرواژه یا پسورد خود را وارد کنید')" oninput="setCustomValidity('')"></input>
                    <button id="loginBtn" name="loginBtn" type="submit" class="btn btn-primary form-control" name="select-system">ورود</button>
                </form>
            </div>
        </section>
    </main>
<script src="./Assets/Js/bootstrap.bundle.min.js"></script>
<script src="./Assets/Js/bootstrap.min.js"></script>
</body>
</html>