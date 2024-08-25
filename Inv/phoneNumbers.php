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
        //check Btn Are Clicked Or Not 
        if(isset($_POST['persBtn']))
        {
            //recive form Paramets
            $flName = cleanUpInputs($_POST['flName']);
            $persType = cleanUpInputs($_POST['persType']);
            $persAddress = cleanUpInputs($_POST['persAddress']);
            $persNumber = cleanUpInputs($_POST['persNumber']);
            
            //Insert SQL
            try
            {
                $sqlInsertPers = $conn -> prepare("INSERT INTO `persons` (`id`, `flName`, `persType`, `persAddress`, `persNumber`) VALUES (NULL, ?, ?, ?, ?);");
                $sqlInsertPers -> execute([$flName,$persType,$persAddress,$persNumber]);
                // if query execute successfully then Alert Success 
                if($sqlInsertPers)
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
    <title>اشخاص</title>

    <link rel="stylesheet" href="../Assets/Css/fonts.css">
    <link rel="stylesheet" href="../Assets/Css/bootstrap.rtl.min.css">
    <link rel="stylesheet" href="../Assets/Css/Style.css">
    <link rel="stylesheet" href="../Assets/Css/all.css">
    <link rel="stylesheet" href="../Assets/Css/sweetalert2.min.css"> 
    <script src="../Assets/Js/sweetalert2.js"></script>
</head>
<body dir="rtl">
    <main class="container updateProduct">
        <section class="row phoneNumber">

            <div class="col col-12 col-sm-12 col-md-4">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" class="form-control">
                    <h3 class="blue-color">
                        شخص جدید
                    </h3>
                    <?php
                    //Success Insert Message
                    if(isset($successMessage))
                    {
                     echo '<script type="text/javascript">  
                            Swal.fire
                                    ({  
                                        text: "شخص جدید با موفقیت ثبت شد", 
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
                    <input type="text" name="flName" id="flName" class="form-control" style="direction: rtl" placeholder="نام و نام خانوادگی" required="required" oninvalid="this.setCustomValidity('لطفا نام و نام خانوادگی شخص را وارد کنید')" oninput="setCustomValidity('')">
                    <input type="text" name="persType" id="persType" class="form-control" style="direction: rtl" placeholder="نوع (مثلا : شخص ، شرکت ، مشتری و ...)" required="required" oninvalid="this.setCustomValidity('نوع شخص یا شرکت را وارد کنید')" oninput="setCustomValidity('')">
                    <input type="text" name="persAddress" id="persAddress" class="form-control" style="direction: rtl" placeholder="آدرس" required="required" oninvalid="this.setCustomValidity('آدرس را وارد کنید')" oninput="setCustomValidity('')">
                    <input type="number" name="persNumber" id="persNumber" class="form-control" style="direction: rtl" placeholder="شماره تماس" required="required" oninvalid="this.setCustomValidity('تلفن را وارد کنید')" oninput="setCustomValidity('')">
                    <button type="submit" name="persBtn" id="persBtn" class="btn btn-primary">ثبت شخص</button>
                </form>
            </div>

            <div class="col">
                <form action="" class="form-control" method="post">
                <h3 class="blue-color">
                    لیست اشخاص
                </h3>
                <?php
                        $searchSqlNothing = $conn -> query('SELECT * FROM persons');
                        $resultPers = $searchSqlNothing -> fetchAll(PDO::FETCH_ASSOC);
                        $conn = null;
                        $num = 1;
                    ?>
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ردیف</th>
                            <th scope="col">اسم</th>
                            <th scope="col">نوع</th>
                            <th scope="col">آدرس</th>
                            <th scope="col">شماره</th>
                        </tr>
                    </thead>
                    <tbody>
                            <?php foreach ($resultPers as $row): ?>
                                <tr>
                                    <th scope="row"><?php echo $num++ ?></th>
                                    <td><?php echo htmlspecialchars($row['flName']) ?></td>
                                    <td><?php echo htmlspecialchars($row['persType']) ?></td>
                                    <td><?php echo htmlspecialchars($row['persAddress']) ?></td>
                                    <td><?php echo htmlspecialchars($row['persNumber']) ?></td>
                                </tr>
                            <?php endforeach; ?>
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