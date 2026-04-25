<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
    <title>الصفحة الرئيسية | منصة أمان</title>
    <style>
        .dashbord-tables { animation: fadeIn 0.8s ease forwards; }
        .filter-container { animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .sub-table,.anime { animation: slideUp 0.6s ease forwards; }
        .glass-card {
            background: rgba(255, 255, 255, 0.6);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
        }
        .glass-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
            background: rgba(255, 255, 255, 0.8);
        }

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
    <style>
        .notification-dropdown {
            position: relative;
            display: inline-block;
        }
        .notification-content {
            display: none;
            position: absolute;
            left: 0;
            background-color: #fff;
            min-width: 300px;
            box-shadow: var(--shadow-lg);
            border-radius: var(--radius-md);
            z-index: 1002;
            padding: 15px;
            border: 1px solid rgba(0,0,0,0.05);
            animation: fadeIn 0.3s ease;
        }
        .notification-dropdown:hover .notification-content {
            display: block;
        }
        .notif-item {
            padding: 10px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 13px;
            transition: background 0.2s;
        }
        .notif-item:hover { background: #f8fafc; }
        .notif-item:last-child { border: none; }
    </style>
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
                    <td class="menu-btn menu-icon-home menu-active menu-icon-home-active">
                        <a href="index.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">الرئيسية</p></a></div></a>
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
                    <td class="menu-btn menu-icon-doctor">
                        <a href="medical-records.php" class="non-style-link-menu"><div><p class="menu-text">السجل الطبي</p></a></div>
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
        <div class="dash-body" style="margin-top:15px">
            <table border="0" width="100%" style="border-spacing:0;margin:0;padding:0;">
                <tr>
                    <td colspan="1" class="nav-bar">
                        <p style="font-size:23px;padding-right:12px;font-weight:700;margin-right:20px;">الرئيسية</p>
                    </td>
                    <td width="25%"></td>
                    <td width="15%">
                        <p style="font-size:14px;color:#64748b;padding:0;margin:0;text-align:left;">التاريخ</p>
                        <p class="heading-sub12" style="padding:0;margin:0;">
                        <?php 
                            date_default_timezone_set('Asia/Aden');
                            $today = date('Y-m-d');
                            echo $today;
                            $patientrow = $database->query("select * from patient;");
                            $doctorrow = $database->query("select * from doctor;");
                            $appointmentrow = $database->query("select * from appointment where appodate>='$today';");
                            $schedulerow = $database->query("select * from schedule where scheduledate='$today';");
                        ?>
                        </p>
                    </td>
                    <td width="10%">
                        <button class="btn-label" style="display:flex;justify-content:center;align-items:center;"><img src="../img/calendar.svg" width="100%"></button>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <center>
                        <div class="filter-container doctor-header patient-header animate-slide-up delay-100" style="border:none;width:95%; padding: 40px; margin-bottom: 30px; position: relative; overflow: hidden;">
                            <div style="position: absolute; top:0; left:0; width:100%; height:100%; background: url('../img/b4.jpg'); opacity: 0.15; z-index: -1;"></div>
                            <div style="position: relative; z-index: 1; text-align: right;">
                                <h3 class="animate-fade-in delay-200" style="opacity: 0.9;">مرحباً بك مجدداً</h3>
                                <h1 class="animate-slide-up delay-300" style="font-size: 42px; margin: 10px 0;"><?php echo $username ?> ✨</h1>
                                <p class="animate-fade-in delay-400" style="font-size: 18px; max-width: 600px; margin-bottom: 25px; line-height: 1.8;">
                                    نحن في منصة أمان نهتم بصحتك. يمكنك البحث عن أفضل مقدمي الرعاية المنزلية، مراجعة سجلاتك الطبية، ومتابعة حجوزاتك بكل سهولة.
                                </p>
                                <form action="schedule.php" method="post" style="display:flex; gap: 10px;" class="animate-slide-up delay-500">
                                    <input type="search" name="search" class="input-text" placeholder="ابحث عن مزود خدمة أو نوع الخدمة" list="doctors" style="width:400px; max-width: 80%; background:rgba(255,255,255,0.95);">
                                    <?php
                                        echo '<datalist id="doctors">';
                                        $list11 = $database->query("select docname,docemail from doctor;");
                                        while ($row00=$list11->fetch_assoc()){
                                            echo "<option value='".$row00["docname"]."'>";
                                        };
                                        echo '</datalist>';
                                    ?>
                                    <button type="submit" class="btn btn-primary" style="padding: 0 30px; background: #fff; color: var(--primary);">بحث الآن</button>
                                </form>
                            </div>
                        </div>
                        </center>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <table border="0" width="100%">
                            <tr>
                                <td width="50%">
                                    <div class="animate-slide-up delay-200" style="padding: 0 25px;">
                                        <p style="font-size:20px;font-weight:700;margin-bottom: 20px;">نظرة عامة على الحالة</p>
                                        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                            <div class="glass-card" style="padding:25px; display: flex; align-items: center; gap: 15px;">
                                                <div class="dashboard-icons" style="margin:0; background: var(--primary-light); color: var(--primary); width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; font-size: 24px;">👨‍⚕️</div>
                                                <div>
                                                    <div class="h3-dashboard">مزودي الخدمات</div>
                                                    <div class="h1-dashboard" style="padding:0; margin-top:5px;"><?php echo $doctorrow->num_rows ?></div>
                                                </div>
                                            </div>
                                            <div class="glass-card" style="padding:25px; display: flex; align-items: center; gap: 15px;">
                                                <div class="dashboard-icons" style="margin:0; background: rgba(5, 150, 105, 0.08); color: var(--secondary); width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; font-size: 24px;">📅</div>
                                                <div>
                                                    <div class="h3-dashboard">حجوزات جديدة</div>
                                                    <div class="h1-dashboard" style="padding:0; margin-top:5px;"><?php echo $appointmentrow->num_rows ?></div>
                                                </div>
                                            </div>
                                            <div class="glass-card" style="padding:25px; display: flex; align-items: center; gap: 15px;">
                                                <div class="dashboard-icons" style="margin:0; background: rgba(5, 150, 105, 0.08); color: var(--accent); width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; font-size: 24px;">📝</div>
                                                <div>
                                                    <div class="h3-dashboard">سجلات طبية</div>
                                                    <div class="h1-dashboard" style="padding:0; margin-top:5px;">2</div>
                                                </div>
                                            </div>
                                            <div class="glass-card" style="padding:25px; display: flex; align-items: center; gap: 15px;">
                                                <div class="dashboard-icons" style="margin:0; background: rgba(5, 150, 105, 0.08); color: var(--warning); width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; font-size: 24px;">🔔</div>
                                                <div>
                                                    <div class="h3-dashboard">تنبيهات</div>
                                                    <div class="h1-dashboard" style="padding:0; margin-top:5px;">0</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <p style="font-size:20px;font-weight:700;padding-right:40px;" class="anime">حجوزاتك القادمة</p>
                                    <center>
                                    <div class="abc scroll" style="height:250px;padding:0;margin:0;">
                                    <table width="85%" class="sub-table scrolldown" border="0">
                                        <thead>
                                        <tr>
                                            <th class="table-headin">رقم الحجز</th>
                                            <th class="table-headin">عنوان الجلسة</th>
                                            <th class="table-headin">مزود الخدمة</th>
                                            <th class="table-headin">التاريخ والوقت</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $nextweek=date("Y-m-d",strtotime("+1 week"));
                                            $sqlmain= "select * from schedule inner join appointment on schedule.scheduleid=appointment.scheduleid inner join patient on patient.pid=appointment.pid inner join doctor on schedule.docid=doctor.docid where patient.pid=$userid and schedule.scheduledate>='$today' order by schedule.scheduledate asc";
                                            $result= $database->query($sqlmain);
                                            if($result->num_rows==0){
                                                echo '<tr><td colspan="4"><br><br><center>
                                                <img src="../img/notfound.svg" width="25%"><br>
                                                <p class="heading-main12" style="font-size:18px;color:#475569">لا توجد حجوزات قادمة</p>
                                                <a class="non-style-link" href="schedule.php"><button class="login-btn btn-primary-soft btn" style="display:flex;justify-content:center;align-items:center;margin-right:20px;">&nbsp; احجز خدمة الآن &nbsp;</button></a>
                                                </center><br><br></td></tr>';
                                            }else{
                                                for($x=0;$x<$result->num_rows;$x++){
                                                    $row=$result->fetch_assoc();
                                                    echo '<tr>
                                                        <td style="padding:25px;font-size:22px;font-weight:700;">&nbsp;'.$row["apponum"].'</td>
                                                        <td style="padding:18px;">&nbsp;'.substr($row["title"],0,30).'</td>
                                                        <td>'.substr($row["docname"],0,20).'</td>
                                                        <td style="text-align:center;">'.substr($row["scheduledate"],0,10).' '.substr($row["scheduletime"],0,5).'</td>
                                                    </tr>';
                                                }
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                    </div>
                                    </center>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>