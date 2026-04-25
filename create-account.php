<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">  
    <link rel="stylesheet" href="css/main.css">  
    <title>إنشاء الحساب | منصة أمان</title>
    <style>
        body {
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 50%, #d1fae5 100%);
            min-height: 100vh;
            display: flex; align-items: center; justify-content: center; padding: 20px;
        }
        .container { animation: transitionIn-X 0.5s; }
        .signup-container {
            background: #fff; border-radius: 20px;
            box-shadow: 0 20px 60px rgba(5,150,105,0.1);
            padding: 40px; width: 500px; max-width: 95%;
        }
        .logo-section { text-align: center; margin-bottom: 25px; }
        .logo-icon-big {
            width: 60px; height: 60px;
            background: linear-gradient(135deg, #059669, #0d9488);
            border-radius: 16px; display: inline-flex;
            align-items: center; justify-content: center;
            font-size: 28px; margin-bottom: 12px;
            box-shadow: 0 8px 20px rgba(5,150,105,0.25);
        }
        .header-text { font-size: 24px; font-weight: 800; color: #1e293b; margin-bottom: 5px; }
        .sub-text { font-size: 14px; color: #64748b; }
        .form-label {
            font-size: 14px; font-weight: 600; color: #374151;
            display: block; margin-bottom: 5px; margin-top: 14px;
        }
        .input-text {
            width: 100%; padding: 11px 15px;
            border: 1.5px solid #e2e8f0; border-radius: 10px;
            font-size: 14px; font-family: 'Tajawal', sans-serif;
        }
        .input-text:focus {
            border-color: #059669;
            box-shadow: 0 0 0 3px rgba(5,150,105,0.12);
            outline: none;
        }
        .row { display: flex; gap: 15px; }
        .row > div, .row > td { flex: 1; }
        .login-btn {
            width: 100%; padding: 12px; border: none; border-radius: 10px;
            font-size: 15px; font-weight: 700; cursor: pointer;
            font-family: 'Tajawal', sans-serif; margin-top: 8px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #059669, #047857);
            color: #fff; box-shadow: 0 4px 15px rgba(5,150,105,0.3);
        }
        .btn-primary:hover { transform: translateY(-2px); box-shadow: 0 8px 25px rgba(5,150,105,0.4); }
        .btn-reset { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }
        .btn-reset:hover { background: #e2e8f0; }
        .bottom-links { text-align: center; margin-top: 18px; }
        .hover-link1 { color: #059669; font-weight: 700; text-decoration: none; }
        .hover-link1:hover { text-decoration: underline; }
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

include("connection.php");

if($_POST){
    $result= $database->query("select * from webuser");
    $fname=$_SESSION['personal']['fname'];
    $lname=$_SESSION['personal']['lname'];
    $name=$fname." ".$lname;
    $address=$_SESSION['personal']['address'];
    $nic=$_SESSION['personal']['nic'];
    $dob=$_SESSION['personal']['dob'];
    $email=$_POST['newemail'];
    $tele=$_POST['tele'];
    $newpassword=$_POST['newpassword'];
    $cpassword=$_POST['cpassword'];
    
    if ($newpassword==$cpassword){
        $sqlmain= "select * from webuser where email=?;";
        $stmt = $database->prepare($sqlmain);
        $stmt->bind_param("s",$email);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows==1){
            $error='<label for="promter" class="form-label" style="color:#ef4444;text-align:center;">يوجد حساب مسجل بهذا البريد الإلكتروني بالفعل</label>';
        }else{
            $database->query("insert into patient(pemail,pname,ppassword, paddress, pnic,pdob,ptel) values('$email','$name','$newpassword','$address','$nic','$dob','$tele');");
            $database->query("insert into webuser values('$email','p')");
            $_SESSION["user"]=$email;
            $_SESSION["usertype"]="p";
            $_SESSION["username"]=$fname;
            header('Location: patient/index.php');
            $error='<label for="promter" class="form-label"></label>';
        }
    }else{
        $error='<label for="promter" class="form-label" style="color:#ef4444;text-align:center;">كلمة المرور غير متطابقة! أعد إدخال كلمة المرور</label>';
    }
}else{
    $error='<label for="promter" class="form-label"></label>';
}
?>

    <div class="container">
        <div class="signup-container">
            <div class="logo-section">
                <div class="logo-icon-big">🏥</div>
                <p class="header-text">أكمل إنشاء حسابك</p>
                <p class="sub-text">أدخل بيانات الحساب لإتمام التسجيل</p>
            </div>

            <form action="" method="POST">
                <label class="form-label">البريد الإلكتروني</label>
                <input type="email" name="newemail" class="input-text" placeholder="أدخل بريدك الإلكتروني" required>

                <label class="form-label">رقم الهاتف</label>
                <input type="tel" name="tele" class="input-text" placeholder="مثال: 0771234567" pattern="[0]{1}[0-9]{9}">

                <label class="form-label">كلمة المرور</label>
                <input type="password" name="newpassword" class="input-text" placeholder="أدخل كلمة مرور قوية" required>

                <label class="form-label">تأكيد كلمة المرور</label>
                <input type="password" name="cpassword" class="input-text" placeholder="أعد إدخال كلمة المرور" required>

                <div style="margin-top:10px;">
                    <?php echo $error ?>
                </div>

                <div class="row" style="margin-top:15px;">
                    <div>
                        <input type="reset" value="إعادة تعيين" class="login-btn btn-reset">
                    </div>
                    <div>
                        <input type="submit" value="إنشاء الحساب" class="login-btn btn-primary btn">
                    </div>
                </div>

                <div class="bottom-links">
                    <label class="sub-text" style="font-weight:400;">لديك حساب بالفعل؟ </label>
                    <a href="login.php" class="hover-link1">تسجيل الدخول</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>