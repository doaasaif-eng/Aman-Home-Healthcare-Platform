<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">  
    <link rel="stylesheet" href="css/main.css">  
    <title>تسجيل الدخول | منصة أمان</title>
    <style>
        body {
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 50%, #d1fae5 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .container {
            animation: transitionIn-Y-bottom 0.5s;
        }
        .login-container {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(5, 150, 105, 0.1);
            padding: 45px 40px;
            width: 420px;
            max-width: 95%;
        }
        .logo-section {
            text-align: center;
            margin-bottom: 30px;
        }
        .logo-icon-big {
            width: 65px; height: 65px;
            background: linear-gradient(135deg, #059669, #0d9488);
            border-radius: 18px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            margin-bottom: 15px;
            box-shadow: 0 8px 20px rgba(5,150,105,0.25);
        }
        .header-text {
            font-size: 26px;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 5px;
        }
        .sub-text {
            font-size: 14px;
            color: #64748b;
            font-weight: 400;
        }
        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            display: block;
            margin-bottom: 6px;
            margin-top: 18px;
        }
        .input-text {
            width: 100%;
            padding: 12px 16px;
            border: 1.5px solid #e2e8f0;
            border-radius: 10px;
            font-size: 15px;
            transition: 0.3s;
            font-family: 'Tajawal', sans-serif;
        }
        .input-text:focus {
            border-color: #059669;
            box-shadow: 0 0 0 3px rgba(5,150,105,0.12);
            outline: none;
        }
        .login-btn {
            width: 100%;
            padding: 13px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            font-family: 'Tajawal', sans-serif;
            margin-top: 8px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #059669, #047857);
            color: #fff;
            box-shadow: 0 4px 15px rgba(5,150,105,0.3);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(5,150,105,0.4);
        }
        .bottom-links {
            text-align: center;
            margin-top: 22px;
        }
        .hover-link1 {
            color: #059669;
            font-weight: 700;
            text-decoration: none;
            transition: 0.3s;
        }
        .hover-link1:hover {
            color: #047857;
            text-decoration: underline;
        }
        .back-link {
            display: inline-block;
            margin-top: 15px;
            color: #64748b;
            text-decoration: none;
            font-size: 14px;
            transition: 0.3s;
        }
        .back-link:hover { color: #059669; }
    </style>
</head>
<body>
    <?php
    session_start();
    $_SESSION["user"]="";
    $_SESSION["usertype"]="";
    
    date_default_timezone_set('Asia/Aden');
    $date = date('Y-m-d');
    $_SESSION["date"]=$date;

    //import database
    include("connection.php");

    if($_POST){
        $email=$_POST['useremail'];
        $password=$_POST['userpassword'];
        
        $error='<label for="promter" class="form-label"></label>';

        $result= $database->query("select * from webuser where email='$email'");
        if($result->num_rows==1){
            $utype=$result->fetch_assoc()['usertype'];
            if ($utype=='p'){
                $checker = $database->query("select * from patient where pemail='$email' and ppassword='$password'");
                if ($checker->num_rows==1){
                    $_SESSION['user']=$email;
                    $_SESSION['usertype']='p';
                    header('location: patient/index.php');
                }else{
                    $error='<label for="promter" class="form-label" style="color:#ef4444;text-align:center;">بيانات خاطئة: البريد الإلكتروني أو كلمة المرور غير صحيحة</label>';
                }
            }elseif($utype=='a'){
                $checker = $database->query("select * from admin where aemail='$email' and apassword='$password'");
                if ($checker->num_rows==1){
                    $_SESSION['user']=$email;
                    $_SESSION['usertype']='a';
                    header('location: admin/index.php');
                }else{
                    $error='<label for="promter" class="form-label" style="color:#ef4444;text-align:center;">بيانات خاطئة: البريد الإلكتروني أو كلمة المرور غير صحيحة</label>';
                }
            }elseif($utype=='d'){
                $checker = $database->query("select * from doctor where docemail='$email' and docpassword='$password'");
                if ($checker->num_rows==1){
                    $_SESSION['user']=$email;
                    $_SESSION['usertype']='d';
                    header('location: doctor/index.php');
                }else{
                    $error='<label for="promter" class="form-label" style="color:#ef4444;text-align:center;">بيانات خاطئة: البريد الإلكتروني أو كلمة المرور غير صحيحة</label>';
                }
            }
        }else{
            $error='<label for="promter" class="form-label" style="color:#ef4444;text-align:center;">لا يوجد حساب مسجل بهذا البريد الإلكتروني</label>';
        }
    }else{
        $error='<label for="promter" class="form-label">&nbsp;</label>';
    }
    ?>

    <div class="container">
        <div class="login-container">
            <div class="logo-section">
                <div class="logo-icon-big">🏥</div>
                <p class="header-text">مرحباً بك في أمان</p>
                <p class="sub-text">سجل دخولك للمتابعة</p>
            </div>

            <form action="" method="POST">
                <label for="useremail" class="form-label">البريد الإلكتروني</label>
                <input type="email" name="useremail" class="input-text" placeholder="أدخل بريدك الإلكتروني" required>

                <label for="userpassword" class="form-label">كلمة المرور</label>
                <input type="password" name="userpassword" class="input-text" placeholder="أدخل كلمة المرور" required>

                <div style="margin-top:12px;">
                    <?php echo $error ?>
                </div>

                <input type="submit" value="تسجيل الدخول" class="login-btn btn-primary btn">

                <div class="bottom-links">
                    <label class="sub-text" style="font-weight:400;">ليس لديك حساب؟ </label>
                    <a href="signup.php" class="hover-link1">إنشاء حساب جديد</a>
                    <br>
                    <a href="index.html" class="back-link">→ العودة للصفحة الرئيسية</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
