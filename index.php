<?php
session_start();
require_once './Scripts/dbConnect.php';
require_once './Scripts/functions.php';
    
// If User Click Login Btn Then Check This IF
if (isset($_POST['loginBtn']))
{
    //filter user and pass (inputs) with function cleanUpInputs.
    $userName = cleanUpInputs($_POST['userName']);
    $passWord = cleanUpInputs($_POST['passWord']);
    $passWord = md5(md5(md5($passWord)));
    
    //Connect To DataBase With PDO And Select User && Pass And Close The Connection.
    $sql = $conn->prepare("SELECT * FROM users WHERE username= :user and password= :pass");
    $sql -> bindParam(':user',$userName);
    $sql -> bindParam(':pass',$passWord);
    $sql -> execute();
    $result = $sql -> fetchAll(PDO::FETCH_ASSOC);
    $conn = null;
    
    //If User And Pass Exist Set The Login Session And Redirect To Select System Type , Else Alert.
    if ($sql -> rowCount() > 0)
    {
        $type = $result[0]['type'];
        $_SESSION['logged_in']= $username;
        $_SESSION['user_type']= $type;
        redirect('./Login/system');
    }
    else
    {
        $incurectUserPass = 1;
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
    <link rel="stylesheet" href="./Assets/Css/sweetalert2.min.css"> 
    <script src="./Assets/Js/sweetalert2.js"></script>
</head>
<body dir="rtl">
    <main class="container">
        <section class="row login-system">
            <div class="col">
                <?php
                    if(isset($incurectUserPass))
                    {
                     echo '<script type="text/javascript">  
                            Swal.fire
                                    ({    
                                        text: "نام کاربری یا رمزعبور اشتباه است",  
                                        icon: "error", 
                                        confirmButtonText: "تأیید"  
                                    });
                      </script>';
                    }
                ?>
                <img src="./Assets/Images/logo.png" alt="لولوی داده فراز">
                <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" class="form-control">
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