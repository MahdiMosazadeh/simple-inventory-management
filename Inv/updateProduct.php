<?php

use function PHPSTORM_META\type;

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

        if ($searchProductSql->rowCount() == 0) {
            //Set Error Message Alert Var.
            $dosntExist = 1;
        }
    } else if (isset($_POST['updateP'])) { // IF This Var Set Then : Update DB With New Info In Blow.

        $codeingg = htmlspecialchars($_POST['codeing']);
        $pName = htmlspecialchars($_POST['pName']);
        $pPlace = htmlspecialchars($_POST['pPlace']);
        $pUnit = htmlspecialchars($_POST['pUnit']);
        $pQty = htmlspecialchars($_POST['pQty']);
        $pDesc = htmlspecialchars($_POST['pDesc']);



        $sqlUpdate = "UPDATE products SET p_name = :pname, p_place = :place, p_unit = :unit, p_qty = :qty, p_description = :pdesc WHERE products.p_codeing = :codeing; ";

        // Prepare And Run The Sql Update
        $stmt = $conn->prepare($sqlUpdate);
        $stmt->bindParam(':pname', $pName);
        $stmt->bindParam(':place', $pPlace);
        $stmt->bindParam(':unit', $pUnit);
        $stmt->bindParam(':qty', $pQty);
        $stmt->bindParam(':pdesc', $pDesc);
        $stmt->bindParam(':codeing', $codeingg);

        $stmt->execute();
        $conn = null;
        if (isset($stmt)) {
            $updateSuccess = 1;
        };
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
                                                    } ?>" required="required" name="codeing" id="myInput" oninput="checkValue()" class="form-control" style="direction: rtl" placeholder="کدینگ" oninvalid="this.setCustomValidity('شماره گذاری کالا ها')" oninput="setCustomValidity('')">

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
                    if (isset($dosntExist)) {
                        echo '<script type="text/javascript">  
                            Swal.fire
                                    ({    
                                        text: "این کدینگ وجود ندارد",  
                                        icon: "warning", 
                                        confirmButtonText: "تأیید"  
                                    });
                            </script>';
                    } else if (isset($updateSuccess)) {
                        echo '<script type="text/javascript">  
                            Swal.fire
                                    ({    
                                        text: "بروزرسانی با موفقیت انجام شد",  
                                        icon: "success", 
                                        confirmButtonText: "تأیید"  
                                    });
                            </script>';
                    } else if (isset($_POST['searchP'])) { // readOnly Codeing Input When User Search.
                        echo "<script>  
                                document.getElementById('myInput').readOnly = true;  
                              </script>";
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