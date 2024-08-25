<?php
session_start();
require_once '../Scripts/dbConnect.php';
require_once '../Scripts/functions.php';

//Check the User Session Login , If Session Doesn't Set
//Then Redirect To The Login Page And If Login Is Set Show The Page
if (!isset($_SESSION['logged_in'])) {
    redirect('../index.php');
} else {
    if (isset($_POST['searchP'])) { //IF User Click Search , Then -> Fetch That Product Row.
        $codeing = htmlspecialchars($_POST['codeing']);

        $searchProductSql = $conn->prepare("SELECT * FROM `products` WHERE p_codeing = :search");
        $searchProductSql->execute(['search' => $codeing]);

        // Recive Select Results
        $searchProductSqlResult = $searchProductSql->fetchAll(PDO::FETCH_ASSOC);

        //If That Codeing Is Exist , Then -> Codeing Input Become Disabled.
        if ($searchProductSql->rowCount() > 0) {
                echo "<script>  
                            window.onload = function() {  
                                                        const inputElement = document.getElementById('myInput');  
                                                        inputElement.disabled = true;
                                                        };  
                      </script>";

        } else {
            //Set Error Message Alert Var.
            $dosntExist = 1;
        }
    }
?>
    <!DOCTYPE html>
    <html lang="fa">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="icon" type="image/png" href="../Assets/Images/finger.png" />
        <title>اصلاح محصول</title>

        <link rel="stylesheet" href="../Assets/Css/fonts.css">
        <link rel="stylesheet" href="../Assets/Css/bootstrap.rtl.min.css">
        <link rel="stylesheet" href="../Assets/Css/Style.css">
        <link rel="stylesheet" href="../Assets/Css/all.css">
        <link rel="stylesheet" href="../Assets/Css/sweetalert2.min.css"> 
        <script src="../Assets/Js/sweetalert2.js"></script>
    </head>

    <body dir="rtl">
        <main class="container updateProduct">
            <section class="row">
                <div class="col">
                    <form action="" method="post" class="form-control">
                        <h3 class="blue-color">
                            اصلاح کالای تعریف شده
                        </h3>
                        <p>
                            ابتدا کدینگ کالا را وارد کرده و دکمه "جستجوی کالا" را بزنید سپس مواردی که قصد دارید اصلاح کنید را بروزرسانی کرده و دکمه "بروزرسانی کالا" را بزنید
                        </p>
                        <!-- If That Codeing Is Exist , Then : Set The Value With That Product Row Informations. -->
                        <input type="number" value="<?php if (isset($searchProductSqlResult)) {
                                                        foreach ($searchProductSqlResult as $result) {
                                                            echo $result['p_codeing'];
                                                        }
                                                    } ?>" required name="codeing" id="myInput" oninput="checkValue()" class="form-control" style="direction: rtl" placeholder="کدینگ" oninvalid="this.setCustomValidity('شماره گذاری کالا ها')" oninput="setCustomValidity('')">

                        <input type="text" value="<?php if (isset($searchProductSqlResult)) {
                                                        foreach ($searchProductSqlResult as $result) {
                                                            echo $result['p_name'];
                                                        }
                                                    } ?>" name="pName" id="" class="form-control" style="direction: rtl" placeholder="نام کالا" oninvalid="this.setCustomValidity('نام کامل کالا را وارد کنید')" oninput="setCustomValidity('')">
                        <input type="text" value="<?php if (isset($searchProductSqlResult)) {
                                                        foreach ($searchProductSqlResult as $result) {
                                                            echo $result['p_place'];
                                                        }
                                                    } ?>" name="pPlace" id="" class="form-control" style="direction: rtl" placeholder="محل استقرار کالا" oninvalid="this.setCustomValidity('محل قرارگیری کالا را وارد کنید')" oninput="setCustomValidity('')">
                        <input type="text" value="<?php if (isset($searchProductSqlResult)) {
                                                        foreach ($searchProductSqlResult as $result) {
                                                            echo $result['p_unit'];
                                                        }
                                                    } ?>" name="pUnit" id="" class="form-control" style="direction: rtl" placeholder="واحد سنجش کالا (به طور مثال : عدد)" oninvalid="this.setCustomValidity('واحد سنجش کالا را وارد کنید')" oninput="setCustomValidity('')">
                        <input type="number" value="<?php if (isset($searchProductSqlResult)) {
                                                        foreach ($searchProductSqlResult as $result) {
                                                            echo $result['p_qty'];
                                                        }
                                                    } ?>" name="pQty" id="" class="form-control" min="0" max="10000000" step="1" style="direction: rtl" placeholder="موجودی اولیه" oninvalid="this.setCustomValidity('نمیتواند اعشار یا خالی باشد')" oninput="setCustomValidity('')">
                        <input type="text" value="<?php if (isset($searchProductSqlResult)) {
                                                        foreach ($searchProductSqlResult as $result) {
                                                            echo $result['p_description'];
                                                        }
                                                    } ?>" name="pDesc" id="" class="form-control" style="direction: rtl" placeholder="توضیحات" oninvalid="this.setCustomValidity('توضیحات')" oninput="setCustomValidity('')">
                        <button type="submit" name="searchP" class="btn btn-dark">جستجوی کالا</button>
                        <button type="submit" name="updateP" class="btn btn-primary">بروزرسانی کالا</button>
                    </form>
                    <?php
                        // Errot Alert , Codeing Dosn't Exist.
                        if(isset($dosntExist)){
                            echo '<script type="text/javascript">  
                            Swal.fire
                                    ({    
                                        text: "این کدینگ وجود ندارد",  
                                        icon: "warning", 
                                        confirmButtonText: "تأیید"  
                                    });
                            </script>';
                            
                        }
                    ?>
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