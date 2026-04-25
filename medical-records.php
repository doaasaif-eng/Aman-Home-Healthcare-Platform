<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();
    if(isset($_SESSION["user"])){
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='p'){
            header("location: ../login.php");
        }else{
            $useremail=$_SESSION["user"];
        }
    }else{
        header("location: ../login.php");
    }
    include("../connection.php");
    $sqlmain= "select * from patient where pemail=?";
    $stmt = $database->prepare($sqlmain);
    $stmt->bind_param("s",$useremail);
    $stmt->execute();
    $userrow = $stmt->get_result();
    $userfetch=$userrow->fetch_assoc();
    $userid= $userfetch["pid"];
    $username=$userfetch["pname"];
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
    <title>السجل الطبي | منصة أمان</title>
    <style>
        /* Mobile Menu Toggle */
        .menu-toggle {
            display: none;
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1001;
            background: var(--primary);
            color: white;
            border: none;
            padding: 10px;
            border-radius: 8px;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        @media (max-width: 991px) {
            .menu-toggle { display: block; }
            .menu {
                position: fixed;
                right: -280px;
                top: 0;
                height: 100vh;
                z-index: 1000;
                box-shadow: -5px 0 15px rgba(0,0,0,0.1);
                transition: right 0.3s ease;
            }
            .menu.active { right: 0; }
            .dash-body { padding: 80px 20px 20px 20px !important; }
        }
    </style>
    <script>
        function toggleMenu() {
            document.querySelector('.menu').classList.toggle('active');
        }
    </script>
</head>
<body>
    <div class="container animate-fade-in">
        <button class="menu-toggle" onclick="toggleMenu()">☰ القائمة</button>
        <div class="menu">
            <table class="menu-container" border="0">
                <tr>
                    <td style="padding:10px" colspan="2">
                        <table border="0" class="profile-container">
                            <tr>
                                <td width="30%" style="padding-right:20px">
                                    <img src="../img/user.png" alt="" width="100%" style="border-radius:50%">
                                </td>
                                <td style="padding:0px;margin:0px;">
                                    <p class="profile-title"><?php echo substr($username,0,15) ?></p>
                                    <p class="profile-subtitle"><?php echo substr($useremail,0,22) ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="../logout.php"><input type="button" value="تسجيل خروج" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-home">
                        <a href="index.php" class="non-style-link-menu"><div><p class="menu-text">الرئيسية</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor">
                        <a href="doctors.php" class="non-style-link-menu"><div><p class="menu-text">مزودي الخدمات</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-session">
                        <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">الجلسات المتاحة</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">حجوزاتي</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor menu-active menu-icon-doctor-active">
                        <a href="medical-records.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">السجل الطبي</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-schedule">
                        <a href="payments.php" class="non-style-link-menu"><div><p class="menu-text">المدفوعات</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-settings">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">الإعدادات</p></a></div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="dash-body">
            <div class="animate-slide-up delay-100">
                <table border="0" width="100%" style="border-spacing:0;margin:0;padding:0;margin-top:25px;">
                    <tr>
                        <td width="13%">
                            <a href="index.php"><button class="login-btn btn-primary-soft btn btn-icon-back" style="padding-top:11px;padding-bottom:11px;margin-right:20px;width:125px"><font class="tn-in-text">العودة</font></button></a>
                        </td>
                        <td>
                            <p class="heading-main12" style="margin-right:15px;">سجلي الطبي</p>
                        </td>
                        <td width="15%">
                            <p style="font-size:14px;color:#64748b;padding:0;margin:0;text-align:left;">اليوم</p>
                            <p class="heading-sub12" style="padding:0;margin:0;"><?php echo date('Y-m-d'); ?></p>
                        </td>
                        <td width="10%">
                            <button class="btn-label" style="display:flex;justify-content:center;align-items:center;"><img src="../img/calendar.svg" width="100%"></button>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="animate-slide-up delay-200" style="margin-top:40px;">
                <center>
                    <div class="abc scroll" style="height:550px;width:95%;">
                        <table width="100%" class="sub-table scrolldown glass-card" border="0" style="border-collapse: collapse;">
                            <thead>
                                <tr>
                                    <th class="table-headin">التاريخ</th>
                                    <th class="table-headin">مزود الخدمة</th>
                                    <th class="table-headin">التشخيص</th>
                                    <th class="table-headin">الوصفة الطبية</th>
                                    <th class="table-headin">العمليات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "select medical_records.*, doctor.docname from medical_records 
                                        inner join doctor on medical_records.docid = doctor.docid 
                                        where medical_records.pid = ? order by record_date desc";
                                $stmt = $database->prepare($sql);
                                $stmt->bind_param("i", $userid);
                                $stmt->execute();
                                $result = $stmt->get_result();

                                if($result->num_rows == 0){
                                    echo '<tr><td colspan="5"><center><br><br><br><br>
                                    <img src="../img/notfound.svg" width="25%"><br>
                                    <p class="heading-main12" style="font-size:18px;color:#475569">لا توجد سجلات طبية حتى الآن</p>
                                    </center><br><br><br><br></td></tr>';
                                } else {
                                    while($row = $result->fetch_assoc()){
                                        echo '<tr class="animate-fade-in">
                                            <td style="padding:15px;text-align:center;">'.$row["record_date"].'</td>
                                            <td style="padding:15px;text-align:center;font-weight:600;">'.$row["docname"].'</td>
                                            <td style="padding:15px;text-align:center;">'.substr($row["diagnosis"],0,30).'...</td>
                                            <td style="padding:15px;text-align:center;">'.substr($row["prescription"],0,30).'...</td>
                                            <td style="padding:15px;text-align:center;">
                                                <a href="?action=view&id='.$row["record_id"].'" class="non-style-link">
                                                    <button class="btn-primary-soft btn btn-view" style="padding:10px 20px;">عرض التفاصيل</button>
                                                </a>
                                            </td>
                                        </tr>';
                                    }
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </center>
            </div>
        </div>
    </div>

    <?php
    if($_GET){
        $rid = $_GET["id"];
        $action = $_GET["action"];
        if($action == 'view'){
            $sql = "select medical_records.*, doctor.docname, specialties.sname from medical_records 
                    inner join doctor on medical_records.docid = doctor.docid 
                    inner join specialties on doctor.specialties = specialties.id
                    where medical_records.record_id = ?";
            $stmt = $database->prepare($sql);
            $stmt->bind_param("i", $rid);
            $stmt->execute();
            $row = $stmt->get_result()->fetch_assoc();
            echo '
            <div id="popup1" class="overlay">
                <div class="popup animate-scale-in">
                    <center>
                    <a class="close" href="medical-records.php">&times;</a>
                    <div style="padding:20px;text-align:right;">
                        <h2 style="color:var(--primary);">تفاصيل السجل الطبي</h2>
                        <hr style="border:0.5px solid #eee;margin:20px 0;">
                        <p><b>التاريخ:</b> '.$row["record_date"].'</p>
                        <p><b>مزود الخدمة:</b> '.$row["docname"].' ('.$row["sname"].')</p>
                        <hr style="border:0.5px solid #eee;margin:20px 0;">
                        <p><b>التشخيص:</b></p>
                        <div style="background:#f8fafc;padding:15px;border-radius:10px;margin-bottom:20px;">'.$row["diagnosis"].'</div>
                        <p><b>الوصفة الطبية:</b></p>
                        <div style="background:#f0fdf4;padding:15px;border-radius:10px;margin-bottom:20px;color:var(--primary); font-weight:600;">'.$row["prescription"].'</div>
                        <p><b>ملاحظات إضافية:</b></p>
                        <div style="padding:10px;">'.$row["notes"].'</div>
                    </div>
                    </center>
                </div>
            </div>';
        }
    }
    ?>
</body>
</html>
