<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/animations.css">  
    <link rel="stylesheet" href="css/main.css">  
    <title>إنشاء حساب | منصة أمان</title>
    <style>
        body {
            background: linear-gradient(135deg, #f0fdf4 0%, #ecfdf5 50%, #d1fae5 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .container { animation: transitionIn-Y-bottom 0.5s; }
        .signup-container {
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(5,150,105,0.1);
            padding: 40px;
            width: 500px;
            max-width: 95%;
        }
        .logo-section { text-align: center; margin-bottom: 25px; }
        .logo-icon-big {
            width: 60px; height: 60px;
            background: linear-gradient(135deg, #059669, #0d9488);
            border-radius: 16px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            margin-bottom: 12px;
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
        .row > div { flex: 1; }
        .login-btn {
            width: 100%; padding: 12px; border: none; border-radius: 10px;
            font-size: 15px; font-weight: 700; cursor: pointer;
            font-family: 'Tajawal', sans-serif; margin-top: 8px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #059669, #047857);
            color: #fff; box-shadow: 0 4px 15px rgba(5,150,105,0.3);
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(5,150,105,0.4);
        }
        .btn-reset {
            background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0;
        }
        .btn-reset:hover { background: #e2e8f0; }
        .bottom-links { text-align: center; margin-top: 18px; }
        .hover-link1 { color: #059669; font-weight: 700; text-decoration: none; }
        .hover-link1:hover { text-decoration: underline; }
        .back-link {
            display: inline-block; margin-top: 12px;
            color: #64748b; text-decoration: none; font-size: 14px;
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

if($_POST){
    $_SESSION["personal"]=array(
        'fname'=>$_POST['fname'],
        'lname'=>$_POST['lname'],
        'address'=>$_POST['address'],
        'nic'=>$_POST['nic'],
        'dob'=>$_POST['dob']
    );
    header("location: create-account.php");
}
?>

    <div class="container">
        <div class="signup-container">
            <div class="logo-section">
                <div class="logo-icon-big">🏥</div>
                <p class="header-text">إنشاء حساب جديد</p>
                <p class="sub-text">أدخل بياناتك الشخصية للمتابعة</p>
            </div>

            <form action="" method="POST">
                <label class="form-label">الاسم الكامل</label>
                <div class="row">
                    <div>
                        <input type="text" name="fname" class="input-text" placeholder="الاسم الأول" required>
                    </div>
                    <div>
                        <input type="text" name="lname" class="input-text" placeholder="اسم العائلة" required>
                    </div>
                </div>

                <label class="form-label">العنوان</label>
                <input type="text" name="address" class="input-text" placeholder="مثال: صنعاء - شارع الزبيري" required>

                <label class="form-label">رقم الهوية</label>
                <input type="text" name="nic" class="input-text" placeholder="رقم الهوية الوطنية" required>

                <label class="form-label">تاريخ الميلاد</label>
                <input type="date" name="dob" class="input-text" required>

                <div class="row" style="margin-top:20px;">
                    <div>
                        <input type="reset" value="إعادة تعيين" class="login-btn btn-reset">
                    </div>
                    <div>
                        <input type="submit" value="التالي ←" class="login-btn btn-primary btn">
                    </div>
                </div>

                <div class="bottom-links">
                    <label class="sub-text" style="font-weight:400;">لديك حساب بالفعل؟ </label>
                    <a href="login.php" class="hover-link1">تسجيل الدخول</a>
                    <br>
                    <a href="index.html" class="back-link">→ العودة للصفحة الرئيسية</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>