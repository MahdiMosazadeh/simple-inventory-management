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
        if(isset($_POST['productSearchBtn']))
        {
            $productName = $_POST['productName'];
            
            $num = 1;

            $searchProductSql = $conn -> prepare("SELECT * FROM `products` WHERE `p_name` LIKE :search");  
            $searchProductSql -> execute(['search' => '%' . $productName . '%']);  

            // دریافت نتایج  
            $searchProductSqlResult = $searchProductSql->fetchAll(PDO::FETCH_ASSOC);
        }
?>
<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="../Assets/Images/finger.png" />
    <title>جستجوی کالا</title>

    <link rel="stylesheet" href="../Assets/Css/fonts.css">
    <link rel="stylesheet" href="../Assets/Css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="../Assets/Css/Style.css">
    <link rel="stylesheet" href="../Assets/Css/all.css">
    <link rel="stylesheet" href="../Assets/Css/sweetalert2.min.css"> 
    <script src="../Assets/Js/sweetalert2.js"></script>
</head>
<body dir="rtl">
    <main class="container searchProduct">
        <section class="row">
            <div class="col">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form-control">
                    <h3 class="blue-color">
                        جستجوی کالا
                    </h3>
                    <div class="input-group mb-3">
                        <input type="text" name="productName" class="form-control" required="required" placeholder="قسمتی از نام کالا را وارد کنید" oninvalid="this.setCustomValidity('قسمتی از نام کالا را وارد کنید')" oninput="setCustomValidity('')">
                        <button class="btn btn-outline-secondary" name="productSearchBtn" type="submit" id="button-addon1">جستجو</button>
                    </div>
                    <?php
                     if(isset($searchProductSqlResult)) {
                        if ($searchProductSql -> rowCount() == 0 )
                        {
                            echo '<script type="text/javascript">  
                            Swal.fire
                                    ({    
                                        text: "کالایی با این نام وجود ندارد",  
                                        icon: "error", 
                                        confirmButtonText: "تأیید"  
                                    });
                      </script>';
                        }    
                    ?>
                    <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ردیف</th>
                            <th scope="col">کدینگ</th>
                            <th scope="col">نام</th>
                            <th scope="col">استقرار</th>
                            <th scope="col">واحد</th>
                            <th scope="col">تعداد</th>
                            <th scope="col">توضیحات</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php foreach ($searchProductSqlResult as $row): ?>
                                <tr>
                                    <th scope="row"><?php echo $num++ ?></th>
                                    <td><?php if(htmlspecialchars($row['p_codeing'])==0) {echo "ندارد";} else {echo htmlspecialchars($row['p_codeing']);}?></td>
                                    <td><?php echo htmlspecialchars($row['p_name']) ?></td>
                                    <td><?php echo htmlspecialchars($row['p_place']) ?></td>
                                    <td><?php echo htmlspecialchars($row['p_unit']) ?></td>
                                    <td><?php echo htmlspecialchars($row['p_qty']) ?></td>
                                    <td><?php echo htmlspecialchars($row['p_description']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                    </tbody>
                    </table>
                    <?php } ?>
                </form>
            </div>
        </section>
        <section class="row" style="margin-top: 15px;">
            <div class="col">
            <form action="" method="post" class="form-control">
                    <h3 class="blue-color">
                        جستجوی شخص
                    </h3>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="قسمتی از نام شخص را وارد کنید" aria-label="Example text with button addon" aria-describedby="button-addon1">
                        <button class="btn btn-outline-secondary" type="button" id="button-addon1">جستجو</button>
                    </div>
                    <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ردیف</th>
                            <th scope="col">نام</th>
                            <th scope="col">نوع</th>
                            <th scope="col">آدرس</th>
                            <th scope="col">شماره</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
                            <th scope="row">1</th>
                            <td>مهدی موسی زاده</td>
                            <td>مشتری</td>
                            <td>تبریز، میدان آذربایجان، ارم</td>
                            <td>09146528873</td>
                            </tr>
                        <tr>
                        <tr>
                            <th scope="row">2</th>
                            <td>علی ولی زاده</td>
                            <td>فروشنده</td>
                            <td>تبریز، میدان آذربایجان، ارم</td>
                            <td>09143452873</td>
                            </tr>
                        <tr>
                        <tr>
                            <th scope="row">3</th>
                            <td>مهدی موسی زاده</td>
                            <td>مشتری</td>
                            <td>تبریز، میدان آذربایجان، ارم</td>
                            <td>09146528873</td>
                            </tr>
                        <tr>
                        <tr>
                            <th scope="row">4</th>
                            <td>علی ولی زاده</td>
                            <td>فروشنده</td>
                            <td>تبریز، میدان آذربایجان، ارم</td>
                            <td>09143452873</td>
                            </tr>
                        <tr>
                    </tbody>
                </table>
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