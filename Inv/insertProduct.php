<?php
session_start();
require_once '../Scripts/dbConnect.php';
require_once '../Scripts/functions.php';
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
    <?php
    //Check the User Session Login , If Session Doesn't Set
    //Then Redirect To The Login Page And If Login Is Set Show The Page
if (!isset($_SESSION['logged_in'])) {
    redirect('../');
} else {
    //اگر روی دکمه کلیک شده بود و عکس انتخاب شده بود
    if (isset($_POST['newProductBtn']) and !empty($_FILES["image"]["name"])) {
        //دریافت اطلاعات
        $productCodeing = cleanUpInputs($_POST['productCodeing']);
        $productName = cleanUpInputs($_POST['productName']);
        $productPlace = cleanUpInputs($_POST['productPlace']);
        $productUnit = cleanUpInputs($_POST['productUnit']);
        $productQty = cleanUpInputs($_POST['productQty']);
        $productDescription = cleanUpInputs($_POST['productDescription']);

        //آماده سازی ذخیره تصویر
        $targetDir = "../Assets/Uploads/Img/Products/";
        $imageFileType = strtolower(pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION));

        // محدود کردن فرمت و اندازه فایل  
        $allowedTypes = array("jpg" => "image/jpeg", "jpeg" => "image/jpeg", "png" => "image/png", "gif" => "image/gif");
        $fileMimeType = mime_content_type($_FILES['image']['tmp_name']);
        if (!in_array($fileMimeType, $allowedTypes)) {
            $incurrectTypeImg = 1;
            echo '<script type="text/javascript">  
                            Swal.fire
                                    ({    
                                        text: "این نوع فایل مجاز نیست ، فقط تصویر میتوانید انتخاب کنید",  
                                        icon: "error", 
                                        confirmButtonText: "تأیید"  
                                    });
                      </script>';
            die();
        }
        if ($_FILES['image']['size'] > 2 * 1024 * 1024) {
            echo '<script type="text/javascript">  
                            Swal.fire
                                    ({    
                                        text: "اندازه فایل نباید از 2 مگابایت بیشتر باشد",  
                                        icon: "error", 
                                        confirmButtonText: "تأیید"  
                                    });
                      </script>';
            die();
        }

        // بررسی اینکه آیا فایل واقعاً یک تصویر است  
        if (!getimagesize($_FILES['image']['tmp_name'])) {
            echo '<script type="text/javascript">  
                            Swal.fire
                                    ({    
                                        text: "این فایل یک تصویر واقعی نیست",  
                                        icon: "error", 
                                        confirmButtonText: "تأیید"  
                                    });
                      </script>';
            die();
        }

        // ایجاد پوشه uploads اگر وجود نداشته باشد  
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0700, true);
        }

        // تولید نام فایل منحصر به فرد  
        $newFileName = uniqid('img_', true) . '.' . $imageFileType;
        $targetFilePath = $targetDir . $newFileName;

        $checkCodeSql = $conn->prepare("SELECT * FROM products WHERE p_codeing= :code");
        $checkCodeSql->bindParam(':code', $productCodeing);
        $checkCodeSql->execute();

        if ($checkCodeSql->rowCount() > 0) {//بررسی وجود کدینگ وارد شده توسط کاربر اگر وجود نداشت محصول جدید ذخیر میشود
            $duplicateCode = 1;
        } else {
            //Insert SQL
            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFilePath)) {
                try {
                    $sqlInsertProduct = $conn->prepare("INSERT INTO `products` (`id`, `p_codeing`, `p_name`, `p_place`, `p_unit`, `p_qty`, `p_description`, `imgAddress`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?);");
                    $sqlInsertProduct->execute([$productCodeing, $productName, $productPlace, $productUnit, $productQty, $productDescription, $targetFilePath]);
                    $conn = null;
                    // if query execute successfully then Alert Success 
                    if ($sqlInsertProduct) {
                        $successMessage = 1;
                    }
                } catch (\PDOException $e) {
                    throw new \PDOException($e->getMessage(), (int)$e->getCode());
                    $error = $e;
                    $errorMessage = 1;
                }
            } else {
                echo "خطا در آپلود تصویر.";
            }
        }
    }

    //اگر تصویر انتخاب نشده بود ذخیره سازی در دیتابیس بدون تصویر و با مقدار نال ذخیره میشود
    if (isset($_POST['newProductBtn']) and empty($_FILES["image"]["name"])) {
        //recive form Paramets
        $productCodeing = cleanUpInputs($_POST['productCodeing']);
        $productName = cleanUpInputs($_POST['productName']);
        $productPlace = cleanUpInputs($_POST['productPlace']);
        $productUnit = cleanUpInputs($_POST['productUnit']);
        $productQty = cleanUpInputs($_POST['productQty']);
        $productDescription = cleanUpInputs($_POST['productDescription']);

        $checkCodeSql = $conn->prepare("SELECT * FROM products WHERE p_codeing= :code");
        $checkCodeSql->bindParam(':code', $productCodeing);
        $checkCodeSql->execute();

        if ($checkCodeSql->rowCount() > 0) {
            $duplicateCode = 1;
        } else {
            //Insert SQL
                try {
                    $sqlInsertProduct = $conn->prepare("INSERT INTO `products` (`id`, `p_codeing`, `p_name`, `p_place`, `p_unit`, `p_qty`, `p_description`, `imgAddress`) VALUES (NULL, ?, ?, ?, ?, ?, ?, NULL);");
                    $sqlInsertProduct->execute([$productCodeing, $productName, $productPlace, $productUnit, $productQty, $productDescription,]);
                    $conn = null;
                    // if query execute successfully then Alert Success 
                    if ($sqlInsertProduct) {
                        $successMessage = 1;
                    }
                } catch (\PDOException $e) {
                    throw new \PDOException($e->getMessage(), (int)$e->getCode());
                    $error = $e;
                    $errorMessage = 1;
                }
        }
    }
?>
        <main class="container">
            <section class="row">
                <div class="col insertProduct">
                    <h3>
                        معرفی کالا جدید
                    </h3>
                    <?php
                    //Success Insert Message
                    if (isset($successMessage)) {
                        echo '<script type="text/javascript">  
                            Swal.fire
                                    ({  
                                        text: "کالای جدید با موفقیت درج شد", 
                                        icon: "success", 
                                        confirmButtonText: "تأیید"  
                                    });
                      </script>';
                        $successMessage = null;
                    }
                    //Error Insert Message
                    else if (isset($errorMessage)) {
                        echo '<script type="text/javascript">  
                            Swal.fire
                                    ({    
                                        text: "' . $e . '",  
                                        icon: "error", 
                                        confirmButtonText: "تأیید"  
                                    });
                      </script>';
                        $errorMessage = null;
                    } else if (isset($duplicateCode)) {
                        echo '<script type="text/javascript">  
                            Swal.fire
                                    ({    
                                        text: "این کد کالا تکراری است",  
                                        icon: "error", 
                                        confirmButtonText: "تأیید"  
                                    });
                      </script>';
                        $duplicateCode = null;
                    }
                    else if (isset($incurrectTypeImg)) {
                        echo '<script type="text/javascript">  
                            Swal.fire
                                    ({    
                                        text: "این نوع فایل مجاز نیست ، فقط تصویر میتوانید انتخاب کنید",  
                                        icon: "error", 
                                        confirmButtonText: "تأیید"  
                                    });
                      </script>';
                        $incurrectTypeImg = null;
                    }
                    ?>


                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form-control" enctype="multipart/form-data">
                        <input type="number" name="productCodeing" id="productCodeing" class="form-control" style="direction: rtl" required="required" placeholder="کدینگ" oninvalid="this.setCustomValidity('شماره گذاری کالا ها')" oninput="setCustomValidity('')">
                        <input type="text" name="productName" id="productName" class="form-control" style="direction: rtl" placeholder="نام کالا" required="required" oninvalid="this.setCustomValidity('نام کامل کالا را وارد کنید')" oninput="setCustomValidity('')">
                        <input type="text" name="productPlace" id="productPlace" class="form-control" style="direction: rtl" placeholder="محل استقرار کالا" required="required" oninvalid="this.setCustomValidity('محل قرارگیری کالا را وارد کنید')" oninput="setCustomValidity('')">
                        <input type="text" name="productUnit" id="productUnit" class="form-control" style="direction: rtl" placeholder="واحد سنجش کالا (به طور مثال : عدد)" required="required" oninvalid="this.setCustomValidity('واحد سنجش کالا را وارد کنید')" oninput="setCustomValidity('')">
                        <input type="number" name="productQty" id="productQty" class="form-control" min="0" max="10000000" step="1" style="direction: rtl" placeholder="موجودی اولیه" required="required" oninvalid="this.setCustomValidity('نمیتواند اعشار یا خالی باشد')" oninput="setCustomValidity('')">
                        <input type="text" name="productDescription" id="productDescription" class="form-control" style="direction: rtl" placeholder="توضیحات (اختیاری)" oninvalid="this.setCustomValidity('توضیحات')" oninput="setCustomValidity('')">
                        <input type="file" name="image" id="image" class="form-control" placeholder="تصویر محصول" value="تصویر محصول" accept="image/*">
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