<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>حجوزاتي | منصة أمان</title>
    <style>
        .popup{
            animation: scaleIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }
        .sub-table{
            animation: slideUp 0.6s ease forwards;
        }
        .search-items {
            transition: all 0.3s ease;
        }
        .search-items:hover {
            transform: translateY(-5px);
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

    $sqlmain= "select appointment.appoid,schedule.scheduleid,schedule.title,doctor.docname,patient.pname,schedule.scheduledate,schedule.scheduletime,appointment.apponum,appointment.appodate from schedule inner join appointment on schedule.scheduleid=appointment.scheduleid inner join patient on patient.pid=appointment.pid inner join doctor on schedule.docid=doctor.docid  where  patient.pid=$userid ";

    if($_POST){
        if(!empty($_POST["sheduledate"])){
            $sheduledate=$_POST["sheduledate"];
            $sqlmain.=" and schedule.scheduledate='$sheduledate' ";
        };
    }

    $sqlmain.="order by appointment.appodate asc";
    $result= $database->query($sqlmain);
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
                                    <p class="profile-title"><?php echo substr($username,0,13)  ?>..</p>
                                    <p class="profile-subtitle"><?php echo substr($useremail,0,22)  ?></p>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="../logout.php" ><input type="button" value="تسجيل خروج" class="logout-btn btn-primary-soft btn"></a>
                                </td>
                            </tr>
                    </table>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-home" >
                        <a href="index.php" class="non-style-link-menu "><div><p class="menu-text">الرئيسية</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor">
                        <a href="doctors.php" class="non-style-link-menu"><div><p class="menu-text">مزودي الخدمات</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session">
                        <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">الجلسات المتاحة</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-appoinment  menu-active menu-icon-appoinment-active">
                        <a href="appointment.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">حجوزاتي</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-settings">
                        <a href="settings.php" class="non-style-link-menu"><div><p class="menu-text">الإعدادات</p></a></div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="dash-body">
            <table border="0" width="100%" style=" border-spacing: 0;margin:0;padding:0;margin-top:25px; ">
                <tr >
                    <td width="13%" >
                    <a href="appointment.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-right:20px;width:125px"><font class="tn-in-text">العودة</font></button></a>
                    </td>
                    <td>
                        <p style="font-size: 23px;padding-right:12px;font-weight: 600;">سجل حجوزاتي</p>
                    </td>
                    <td width="15%">
                        <p style="font-size: 14px;color: #64748b;padding: 0;margin: 0;text-align: left;">التاريخ</p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php 
                            date_default_timezone_set('Asia/Aden');
                            $today = date('Y-m-d');
                            echo $today;
                            ?>
                        </p>
                    </td>
                    <td width="10%">
                        <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:10px;width: 100%;" >
                        <p class="heading-main12" style="margin-right: 45px;font-size:18px;color:rgb(49, 49, 49)">حجوزاتي (<?php echo $result->num_rows; ?>)</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:0px;width: 100%;" >
                        <center>
                        <table class="filter-container" border="0" >
                        <tr>
                           <td width="10%"></td> 
                        <td width="5%" style="text-align: center;">التاريخ:</td>
                        <td width="30%">
                        <form action="" method="post">
                            <input type="date" name="sheduledate" id="date" class="input-text filter-container-items" style="margin: 0;width: 95%;">
                        </td>
                    <td width="12%">
                        <input type="submit"  name="filter" value="تصفية" class=" btn-primary-soft btn button-icon btn-filter"  style="padding: 15px; margin :0;width:100%">
                        </form>
                    </td>
                    </tr>
                            </table>
                        </center>
                    </td>
                </tr>
                <tr>
                   <td colspan="4">
                       <center>
                        <div class="abc scroll">
                        <table width="93%" class="sub-table scrolldown" border="0" style="border:none">
                        <tbody>
                            <?php
                                if($result->num_rows==0){
                                    echo '<tr>
                                    <td colspan="7">
                                    <br><br><br><br>
                                    <center>
                                    <img src="../img/notfound.svg" width="25%">
                                    <br>
                                    <p class="heading-main12" style="margin-right: 45px;font-size:20px;color:rgb(49, 49, 49)">لم نجد أي حجز متعلق بالبحث!</p>
                                    <a class="non-style-link" href="appointment.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-right:20px;">&nbsp; عرض جميع الحجوزات &nbsp;</button>
                                    </a>
                                    </center>
                                    <br><br><br><br>
                                    </td>
                                    </tr>';
                                }
                                else{
                                    for ( $x=0; $x<($result->num_rows);$x++){
                                        echo "<tr>";
                                        for($q=0;$q<3;$q++){
                                            $row=$result->fetch_assoc();
                                            if (!isset($row)){
                                            break;
                                            };
                                            $scheduleid=$row["scheduleid"];
                                            $title=$row["title"];
                                            $docname=$row["docname"];
                                            $scheduledate=$row["scheduledate"];
                                            $scheduletime=$row["scheduletime"];
                                            $apponum=$row["apponum"];
                                            $appodate=$row["appodate"];
                                            $appoid=$row["appoid"];
                                            if($scheduleid==""){
                                                break;
                                            }
                                            echo '
                                            <td style="width: 25%;">
                                                    <div  class="dashboard-items search-items"  >
                                                        <div style="width:100%;">
                                                        <div class="h3-search">
                                                                    تاريخ الحجز: '.substr($appodate,0,30).'<br>
                                                                    رقم مرجعي: AMN-000-'.$appoid.'
                                                                </div>
                                                                <div class="h1-search">
                                                                    '.substr($title,0,21).'<br>
                                                                </div>
                                                                <div class="h3-search">
                                                                    رقم الموعد:<div class="h1-search">0'.$apponum.'</div>
                                                                </div>
                                                                <div class="h3-search">
                                                                    '.substr($docname,0,30).'
                                                                </div>
                                                                <div class="h4-search">
                                                                    التاريخ المجدول: '.$scheduledate.'<br>يبدأ: <b>@'.substr($scheduletime,0,5).'</b> (24 س)
                                                                </div>
                                                                <br>';
                                                                
                                                                if($scheduledate < $today){
                                                                    echo '<a href="?action=rate&id='.$appoid.'&doc='.$docname.'&title='.$title.'" ><button class="login-btn btn-primary btn" style="padding-top:11px;padding-bottom:11px;width:100%">تقييم الخدمة ⭐</button></a>';
                                                                } else {
                                                                    echo '<a href="?action=drop&id='.$appoid.'&title='.$title.'&doc='.$docname.'" ><button class="login-btn btn-primary-soft btn" style="padding-top:11px;padding-bottom:11px;width:100%"><font class="tn-in-text">إلغاء الحجز</font></button></a>';
                                                                }
                                                                
                                            echo '       </div>
                                                    </div>
                                                </td>';
                                        }
                                        echo "</tr>";
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
        </div>
    </div>
    <?php
    if($_GET){
        $id=$_GET["id"];
        $action=$_GET["action"];
        if($action=='booking-added'){
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                    <br><br>
                        <h2>تم الحجز بنجاح.</h2>
                        <a class="close" href="appointment.php">&times;</a>
                        <div class="content">
                        رقم موعدك هو '.$id.'.<br><br>
                        </div>
                        <div style="display: flex;justify-content: center;">
                        <a href="appointment.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;حسناً&nbsp;&nbsp;</font></button></a>
                        <br><br><br><br>
                        </div>
                    </center>
            </div>
            </div>
            ';
        }elseif($action=='drop'){
            $title=$_GET["title"];
            $docname=$_GET["doc"];
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <h2>هل أنت متأكد؟</h2>
                        <a class="close" href="appointment.php">&times;</a>
                        <div class="content">
                            هل تريد فعلاً إلغاء هذا الموعد؟<br><br>
                            اسم الجلسة: &nbsp;<b>'.substr($title,0,40).'</b><br>
                            اسم المزود&nbsp; : <b>'.substr($docname,0,40).'</b><br><br>
                        </div>
                        <div style="display: flex;justify-content: center;">
                        <a href="delete-appointment.php?id='.$id.'" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"<font class="tn-in-text">&nbsp;نعم&nbsp;</font></button></a>&nbsp;&nbsp;&nbsp;
                        <a href="appointment.php" class="non-style-link"><button  class="btn-primary btn"  style="display: flex;justify-content: center;align-items: center;margin:10px;padding:10px;"><font class="tn-in-text">&nbsp;&nbsp;لا&nbsp;&nbsp;</font></button></a>
                        </div>
                    </center>
            </div>
            </div>
            '; 
        }elseif($action=='rate'){
            $title=$_GET["title"];
            $docname=$_GET["doc"];
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup animate-scale-in">
                    <center>
                    <a class="close" href="appointment.php">&times;</a>
                    <div style="padding:20px; text-align:right;">
                        <h2 style="color:var(--primary);">تقييم الخدمة الممتازة</h2>
                        <p>نحن نقدر رأيك في <b>'.$docname.'</b> بخصوص جلسة <b>'.$title.'</b>.</p>
                        <form action="submit-review.php" method="post">
                            <input type="hidden" name="appoid" value="'.$id.'">
                            <label class="form-label">التقييم:</label>
                            <select name="rating" class="input-text" style="margin-bottom:15px;">
                                <option value="5">⭐⭐⭐⭐⭐ ممتاز</option>
                                <option value="4">⭐⭐⭐⭐ جيد جداً</option>
                                <option value="3">⭐⭐⭐ جيد</option>
                                <option value="2">⭐⭐ مقبول</option>
                                <option value="1">⭐ ضعيف</option>
                            </select>
                            <label class="form-label">رأيك بالتفصيل:</label>
                            <textarea name="comment" class="input-text" rows="4" style="height:auto; margin-bottom:20px;" placeholder="اكتب ملاحظاتك هنا..."></textarea>
                            <div style="display:flex; justify-content:center; gap:10px;">
                                <input type="submit" value="إرسال التقييم" class="login-btn btn-primary btn">
                                <a href="appointment.php"><input type="button" value="إلغاء" class="login-btn btn-primary-soft btn"></a>
                            </div>
                        </form>
                    </div>
                    </center>
            </div>
            </div>
            '; 
        }
    }
?>
    </div>
</body>
</html>
