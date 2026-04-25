<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();
    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='d'){
            header("location: ../login.php");
        }else{
            $useremail=$_SESSION["user"];
        }
    }else{
        header("location: ../login.php");
    }
    include("../connection.php");
    
    $userrow = $database->query("select * from doctor where docemail='$useremail'");
    $userfetch=$userrow->fetch_assoc();
    $userid= $userfetch["docid"];
    $username=$userfetch["docname"];

    if($_POST){
        $pid=$_POST["pid"];
        $diagnosis=$_POST["diagnosis"];
        $prescription=$_POST["prescription"];
        $notes=$_POST["notes"];
        
        $sql = "insert into medical_records (pid, docid, diagnosis, prescription, notes, record_date) values (?, ?, ?, ?, ?, NOW())";
        $stmt = $database->prepare($sql);
        $stmt->bind_param("iisss", $pid, $userid, $diagnosis, $prescription, $notes);
        $stmt->execute();
        
        header("location: patient.php?action=view&id=".$pid."&success=1");
    }

    if($_GET){
        $pid=$_GET["id"];
        $sqlmain= "select * from patient where pid='$pid'";
        $result= $database->query($sqlmain);
        $row=$result->fetch_assoc();
        $pname=$row["pname"];
    }
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
    <title>إضافة سجل طبي | منصة أمان</title>
</head>
<body>
    <div class="container animate-fade-in">
        <div class="menu">
            <!-- Simplified Sidebar for brevity -->
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-right:20px">
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title"><?php echo substr($username,0,13) ?>..</p>
                                    <p class="profile-subtitle"><?php echo substr($useremail,0,22) ?></p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-dashbord">
                        <a href="index.php" class="non-style-link-menu"><div><p class="menu-text">لوحة التحكم</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-patient menu-active menu-icon-patient-active">
                        <a href="patient.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">مرضاي</p></a></div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="dash-body">
            <div class="animate-slide-up delay-100">
                <table border="0" width="100%" style="border-spacing:0;margin:0;padding:0;margin-top:25px;">
                    <tr>
                        <td width="13%">
                            <a href="patient.php?action=view&id=<?php echo $pid ?>"><button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;margin-right:20px;width:125px"><font class="tn-in-text">العودة</font></button></a>
                        </td>
                        <td>
                            <p class="heading-main12" style="margin-right:15px;">إضافة سجل طبي جديد لـ: <?php echo $pname ?></p>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="animate-slide-up delay-200 glass-card" style="margin: 40px auto; padding: 40px; width: 80%; max-width: 800px;">
                <form action="" method="post">
                    <input type="hidden" name="pid" value="<?php echo $pid ?>">
                    
                    <div style="margin-bottom:25px;">
                        <label class="form-label">التشخيص الطبي:</label>
                        <textarea name="diagnosis" class="input-text" rows="4" placeholder="اكتب التشخيص هنا..." required style="height:auto;"></textarea>
                    </div>

                    <div style="margin-bottom:25px;">
                        <label class="form-label">الوصفة الطبية (العلاج):</label>
                        <textarea name="prescription" class="input-text" rows="4" placeholder="اكتب العلاج الموصوف هنا..." required style="height:auto; border-color:var(--primary);"></textarea>
                    </div>

                    <div style="margin-bottom:25px;">
                        <label class="form-label">ملاحظات إضافية:</label>
                        <textarea name="notes" class="input-text" rows="3" placeholder="أي ملاحظات أخرى..." style="height:auto;"></textarea>
                    </div>

                    <div style="display:flex; justify-content: flex-end; gap: 15px;">
                        <input type="reset" value="إعادة تعيين" class="login-btn btn-primary-soft btn">
                        <input type="submit" value="حفظ السجل الطبي" class="login-btn btn-primary btn">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
