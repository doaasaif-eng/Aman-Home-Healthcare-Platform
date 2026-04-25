<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
    <title>لوحة التحكم | منصة أمان</title>
    <style>
        .dashbord-tables { animation: fadeIn 0.8s ease forwards; }
        .filter-container { animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards; }
        .sub-table { animation: slideUp 0.6s ease forwards; }
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
        if(($_SESSION["user"])=="" or $_SESSION['usertype']!='a'){
            header("location: ../login.php");
        }
    }else{
        header("location: ../login.php");
    }
    include("../connection.php");
    ?>
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
                                    <p class="profile-title">مدير النظام</p>
                                    <p class="profile-subtitle">admin@aman.com</p>
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
                    <td class="menu-btn menu-icon-dashbord menu-active menu-icon-dashbord-active">
                        <a href="index.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">لوحة التحكم</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor">
                        <a href="doctors.php" class="non-style-link-menu"><div><p class="menu-text">مزودي الخدمات</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-schedule">
                        <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">الجدول الزمني</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">الحجوزات</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-patient">
                        <a href="patient.php" class="non-style-link-menu"><div><p class="menu-text">المرضى</p></a></div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="dash-body" style="margin-top: 15px">
            <table border="0" width="100%" style="border-spacing: 0;margin:0;padding:0;">
                <tr>
                    <td colspan="2" class="nav-bar">
                        <form action="doctors.php" method="post" class="header-search">
                            <input type="search" name="search" class="input-text header-searchbar" placeholder="البحث عن مزود خدمة بالاسم أو البريد الإلكتروني" list="doctors">&nbsp;&nbsp;
                            <?php
                                echo '<datalist id="doctors">';
                                $list11 = $database->query("select docname,docemail from doctor;");
                                for ($y=0;$y<$list11->num_rows;$y++){
                                    $row00=$list11->fetch_assoc();
                                    $d=$row00["docname"];
                                    $c=$row00["docemail"];
                                    echo "<option value='$d'><br/>";
                                    echo "<option value='$c'><br/>";
                                };
                                echo '</datalist>';
                            ?>
                            <input type="Submit" value="بحث" class="login-btn btn-primary-soft btn" style="padding:10px 25px;">
                        </form>
                    </td>
                    <td width="20%">
                        <div style="display:flex; justify-content: flex-end; align-items: center; gap: 15px; padding-left: 20px;">
                            <div class="notification-dropdown">
                                <button class="btn-label" style="display:flex; justify-content:center; align-items:center;">
                                    <span style="font-size: 20px;">🔔</span>
                                </button>
                                <div class="notification-content" style="text-align: right;">
                                    <p style="font-weight:700; border-bottom:1px solid #eee; padding-bottom:10px; margin-bottom:10px;">نظام التنبيهات</p>
                                    <div class="notif-item">تنبيه: يوجد 3 مزودين جدد بانتظار المراجعة.</div>
                                    <div class="notif-item">تم تحديث النظام بنجاح إلى النسخة 2.0.</div>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td width="10%">
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
                        <div class="animate-slide-up delay-200" style="padding: 20px 40px;">
                            <p style="font-size:20px;font-weight:800;margin-bottom: 25px;">الإحصائيات العامة للمنصة</p>
                            <div style="display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px;">
                                <div class="glass-card" style="padding:25px; display: flex; align-items: center; gap: 15px;">
                                    <div class="dashboard-icons" style="margin:0; background: var(--primary-light); color: var(--primary); width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; font-size: 24px;">👨‍⚕️</div>
                                    <div>
                                        <div class="h3-dashboard">مزودي الخدمات</div>
                                        <div class="h1-dashboard" style="padding:0; margin-top:5px;"><?php echo $doctorrow->num_rows ?></div>
                                    </div>
                                </div>
                                <div class="glass-card" style="padding:25px; display: flex; align-items: center; gap: 15px;">
                                    <div class="dashboard-icons" style="margin:0; background: rgba(5, 150, 105, 0.08); color: var(--secondary); width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; font-size: 24px;">👥</div>
                                    <div>
                                        <div class="h3-dashboard">إجمالي المرضى</div>
                                        <div class="h1-dashboard" style="padding:0; margin-top:5px;"><?php echo $patientrow->num_rows ?></div>
                                    </div>
                                </div>
                                <div class="glass-card" style="padding:25px; display: flex; align-items: center; gap: 15px;">
                                    <div class="dashboard-icons" style="margin:0; background: rgba(5, 150, 105, 0.08); color: var(--accent); width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; font-size: 24px;">🎫</div>
                                    <div>
                                        <div class="h3-dashboard">حجوزات جديدة</div>
                                        <div class="h1-dashboard" style="padding:0; margin-top:5px;"><?php echo $appointmentrow->num_rows ?></div>
                                    </div>
                                </div>
                                <div class="glass-card" style="padding:25px; display: flex; align-items: center; gap: 15px;">
                                    <div class="dashboard-icons" style="margin:0; background: rgba(5, 150, 105, 0.08); color: var(--warning); width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; font-size: 24px;">📅</div>
                                    <div>
                                        <div class="h3-dashboard">جلسات اليوم</div>
                                        <div class="h1-dashboard" style="padding:0; margin-top:5px;"><?php echo $schedulerow->num_rows ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4">
                        <table width="100%" border="0" class="dashbord-tables">
                            <tr>
                                <td>
                                    <p style="padding:10px;padding-right:48px;padding-bottom:0;font-size:21px;font-weight:700;color:var(--primarycolor);">
                                        الحجوزات القادمة حتى <?php echo date("l",strtotime("+1 week")); ?>
                                    </p>
                                    <p style="padding-bottom:15px;padding-right:50px;font-size:14px;font-weight:500;color:#475569;line-height:22px;">
                                        وصول سريع للحجوزات القادمة خلال 7 أيام<br>
                                        لمزيد من التفاصيل توجه إلى قسم الحجوزات
                                    </p>
                                </td>
                                <td>
                                    <p style="text-align:left;padding:10px;padding-left:48px;padding-bottom:0;font-size:21px;font-weight:700;color:var(--primarycolor);">
                                        الجلسات القادمة حتى <?php echo date("l",strtotime("+1 week")); ?>
                                    </p>
                                    <p style="padding-bottom:15px;text-align:left;padding-left:50px;font-size:14px;font-weight:500;color:#475569;line-height:22px;">
                                        وصول سريع للجلسات المجدولة خلال 7 أيام<br>
                                        يمكنك إضافة وحذف الجلسات من قسم الجدول الزمني
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td width="50%">
                                    <center>
                                    <div class="abc scroll" style="height:200px;">
                                    <table width="85%" class="sub-table scrolldown" border="0">
                                        <thead>
                                        <tr>
                                            <th class="table-headin" style="font-size:12px;">رقم الحجز</th>
                                            <th class="table-headin">اسم المريض</th>
                                            <th class="table-headin">مزود الخدمة</th>
                                            <th class="table-headin">الجلسة</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $nextweek=date("Y-m-d",strtotime("+1 week"));
                                            $sqlmain= "select appointment.appoid,schedule.scheduleid,schedule.title,doctor.docname,patient.pname,schedule.scheduledate,schedule.scheduletime,appointment.apponum,appointment.appodate from schedule inner join appointment on schedule.scheduleid=appointment.scheduleid inner join patient on patient.pid=appointment.pid inner join doctor on schedule.docid=doctor.docid where schedule.scheduledate>='$today' and schedule.scheduledate<='$nextweek' order by schedule.scheduledate desc";
                                            $result= $database->query($sqlmain);
                                            if($result->num_rows==0){
                                                echo '<tr><td colspan="4"><br><br><center>
                                                <img src="../img/notfound.svg" width="25%"><br>
                                                <p class="heading-main12" style="font-size:18px;color:#475569">لا توجد حجوزات قادمة</p>
                                                <a class="non-style-link" href="appointment.php"><button class="login-btn btn-primary-soft btn" style="display:flex;justify-content:center;align-items:center;margin-right:20px;">&nbsp; عرض كل الحجوزات &nbsp;</button></a>
                                                </center><br><br></td></tr>';
                                            }else{
                                                for($x=0;$x<$result->num_rows;$x++){
                                                    $row=$result->fetch_assoc();
                                                    echo '<tr>
                                                        <td style="text-align:center;font-size:22px;font-weight:600;color:var(--btnnicetext);padding:18px;">'.$row["apponum"].'</td>
                                                        <td style="font-weight:600;">&nbsp;'.substr($row["pname"],0,25).'</td>
                                                        <td style="font-weight:600;">&nbsp;'.substr($row["docname"],0,25).'</td>
                                                        <td>'.substr($row["title"],0,15).'</td>
                                                    </tr>';
                                                }
                                            }
                                        ?>
                                        </tbody>
                                    </table>
                                    </div>
                                    </center>
                                </td>
                                <td width="50%" style="padding:0;">
                                    <center>
                                    <div class="abc scroll" style="height:200px;padding:0;margin:0;">
                                    <table width="85%" class="sub-table scrolldown" border="0">
                                        <thead>
                                        <tr>
                                            <th class="table-headin">عنوان الجلسة</th>
                                            <th class="table-headin">مزود الخدمة</th>
                                            <th class="table-headin">التاريخ والوقت</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                            $sqlmain= "select schedule.scheduleid,schedule.title,doctor.docname,schedule.scheduledate,schedule.scheduletime,schedule.nop from schedule inner join doctor on schedule.docid=doctor.docid where schedule.scheduledate>='$today' and schedule.scheduledate<='$nextweek' order by schedule.scheduledate desc"; 
                                            $result= $database->query($sqlmain);
                                            if($result->num_rows==0){
                                                echo '<tr><td colspan="3"><br><br><center>
                                                <img src="../img/notfound.svg" width="25%"><br>
                                                <p class="heading-main12" style="font-size:18px;color:#475569">لا توجد جلسات قادمة</p>
                                                <a class="non-style-link" href="schedule.php"><button class="login-btn btn-primary-soft btn" style="display:flex;justify-content:center;align-items:center;margin-right:20px;">&nbsp; عرض كل الجلسات &nbsp;</button></a>
                                                </center><br><br></td></tr>';
                                            }else{
                                                for($x=0;$x<$result->num_rows;$x++){
                                                    $row=$result->fetch_assoc();
                                                    echo '<tr>
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
                            <tr>
                                <td>
                                    <center>
                                        <a href="appointment.php" class="non-style-link"><button class="btn-primary btn" style="width:85%">عرض كل الحجوزات</button></a>
                                    </center>
                                </td>
                                <td>
                                    <center>
                                        <a href="schedule.php" class="non-style-link"><button class="btn-primary btn" style="width:85%">عرض كل الجلسات</button></a>
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