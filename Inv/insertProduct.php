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
        //check the btn are isset ? if isset then recive paramets and connect DB and Insert Them.
        if(isset($_POST['newProductBtn']))
        {
            //recive form Paramets
            $productCodeing = cleanUpInputs($_POST['productCodeing']);
            $productName = cleanUpInputs($_POST['productName']);
            $productPlace = cleanUpInputs($_POST['productPlace']);
            $productUnit = cleanUpInputs($_POST['productUnit']);
            $productQty = cleanUpInputs($_POST['productQty']);
            $productDescription = cleanUpInputs($_POST['productDescription']);
            
            //Insert SQL
            try
            {
                $sqlInsertProduct = $conn -> prepare("INSERT INTO `products` (`id`, `p_codeing`, `p_name`, `p_place`, `p_unit`, `p_qty`, `p_description`) VALUES (NULL, ?, ?, ?, ?, ?, ?);");
                $sqlInsertProduct -> execute([$productCodeing,$productName,$productPlace,$productUnit,$productQty,$productDescription]);
                $conn = null;
                // if query execute successfully then Alert Success 
                if($sqlInsertProduct)
                {
                    $successMessage = 1;
                }
            }
            catch (\PDOException $e)
            {  
                    throw new \PDOException($e->getMessage(), (int)$e->getCode());
                    $error = $e;
                    $errorMessage = 1;
            }  
        }
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
    <link rel="stylesheet" href="../Assets/Css/sweetalert2.min.css"> 
    <script src="../Assets/Js/sweetalert2.js"></script>
    <script src="../Assets/Js/bootstrap.bundle.min.js"></script>
    <script src="../Assets/Js/bootstrap.min.js"></script> 
</head>
<body dir="rtl" style="background-color: #eee;">
    <main class="container">
        <section class="row" >
            <div class="col insertProduct">
                <h3>
                    معرفی کالا جدید
                </h3>
                <?php
                    //Success Insert Message
                    if(isset($successMessage))
                    {
                     echo '<script type="text/javascript">  
                            Swal.fire
                                    ({  
                                        text: "کالای جدید با موفقیت درج شد", 
                                        icon: "success", 
                                        confirmButtonText: "تأیید"  
                                    });
                      </script>';
                    }
                    //Error Insert Message
                    else if(isset($errorMessage))
                    {
                     echo '<script type="text/javascript">  
                            Swal.fire
                                    ({    
                                        text: "'.$e.'",  
                                        icon: "error", 
                                        confirmButtonText: "تأیید"  
                                    });
                      </script>';
                    }
                ?>
                
                      
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form-control">
                <input type="number" name="productCodeing" id="productCodeing" class="form-control" style="direction: rtl" placeholder="کدینگ (اختیاری)" oninvalid="this.setCustomValidity('شماره گذاری کالا ها')" oninput="setCustomValidity('')">
                <input type="text" name="productName" id="productName" class="form-control" style="direction: rtl" placeholder="نام کالا" required="required" oninvalid="this.setCustomValidity('نام کامل کالا را وارد کنید')" oninput="setCustomValidity('')">
                <input type="text" name="productPlace" id="productPlace" class="form-control" style="direction: rtl" placeholder="محل استقرار کالا" required="required" oninvalid="this.setCustomValidity('محل قرارگیری کالا را وارد کنید')" oninput="setCustomValidity('')">
                <input type="text" name="productUnit" id="productUnit" class="form-control" style="direction: rtl" placeholder="واحد سنجش کالا (به طور مثال : عدد)" required="required" oninvalid="this.setCustomValidity('واحد سنجش کالا را وارد کنید')" oninput="setCustomValidity('')">
                <input type="number" name="productQty" id="productQty" class="form-control" min="0" max="10000000" step="1" style="direction: rtl" placeholder="موجودی اولیه" required="required" oninvalid="this.setCustomValidity('نمیتواند اعشار یا خالی باشد')" oninput="setCustomValidity('')">
                <input type="text" name="productDescription" id="productDescription" class="form-control" style="direction: rtl" placeholder="توضیحات (اختیاری)" oninvalid="this.setCustomValidity('توضیحات')" oninput="setCustomValidity('')">
                <button type="submit" name="newProductBtn" id="newProductBtn" class="btn btn-primary">ثبت کالای جدید</button>
                </form>
            </div>
        </section>
    </main>
</body>
</html>
<?php
    }
?>