<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/animations.css">  
    <link rel="stylesheet" href="../css/main.css">  
    <link rel="stylesheet" href="../css/admin.css">
        
    <title>مزودي الخدمات | منصة أمان</title>
    <style>
        .popup{
            animation: scaleIn 0.4s cubic-bezier(0.34, 1.56, 0.64, 1) forwards;
        }
        .sub-table{
            animation: slideUp 0.6s ease forwards;
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
    $userrow = $database->query("select * from patient where pemail='$useremail'");
    $userfetch=$userrow->fetch_assoc();
    $userid= $userfetch["pid"];
    $username=$userfetch["pname"];
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
                    <td class="menu-btn menu-icon-home " >
                        <a href="index.php" class="non-style-link-menu "><div><p class="menu-text">الرئيسية</p></a></div></a>
                    </td>
                </tr>
                <tr class="menu-row">
                    <td class="menu-btn menu-icon-doctor menu-active menu-icon-doctor-active">
                        <a href="doctors.php" class="non-style-link-menu non-style-link-menu-active"><div><p class="menu-text">مزودي الخدمات</p></a></div>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-session">
                        <a href="schedule.php" class="non-style-link-menu"><div><p class="menu-text">الجلسات المتاحة</p></div></a>
                    </td>
                </tr>
                <tr class="menu-row" >
                    <td class="menu-btn menu-icon-appoinment">
                        <a href="appointment.php" class="non-style-link-menu"><div><p class="menu-text">حجوزاتي</p></a></div>
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
                    <td width="13%">
                        <a href="doctors.php" ><button  class="login-btn btn-primary-soft btn btn-icon-back"  style="padding-top:11px;padding-bottom:11px;margin-right:20px;width:125px"><font class="tn-in-text">العودة</font></button></a>
                    </td>
                    <td>
                        <form action="" method="post" class="header-search">
                            <input type="search" name="search" class="input-text header-searchbar" placeholder="ابحث عن مزود خدمة بالاسم أو البريد الإلكتروني" list="doctors">&nbsp;&nbsp;
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
                                echo ' </datalist>';
                            ?>
                            <input type="Submit" value="بحث" class="login-btn btn-primary btn" style="padding-left: 25px;padding-right: 25px;padding-top: 10px;padding-bottom: 10px;">
                        </form>
                    </td>
                    <td width="15%">
                        <p style="font-size: 14px;color: #64748b;padding: 0;margin: 0;text-align: left;">التاريخ</p>
                        <p class="heading-sub12" style="padding: 0;margin: 0;">
                            <?php 
                            date_default_timezone_set('Asia/Aden');
                            $date = date('Y-m-d');
                            echo $date;
                            ?>
                        </p>
                    </td>
                    <td width="10%">
                        <button  class="btn-label"  style="display: flex;justify-content: center;align-items: center;"><img src="../img/calendar.svg" width="100%"></button>
                    </td>
                </tr>
                <tr>
                    <td colspan="4" style="padding-top:10px;">
                        <p class="heading-main12" style="margin-right: 45px;font-size:18px;color:rgb(49, 49, 49)">جميع مزودي الخدمات (<?php echo $list11->num_rows; ?>)</p>
                    </td>
                </tr>
                <?php
                    if($_POST){
                        $keyword=$_POST["search"];
                        $sqlmain= "select * from doctor where docemail='$keyword' or docname='$keyword' or docname like '$keyword%' or docname like '%$keyword' or docname like '%$keyword%'";
                    }else{
                        $sqlmain= "select * from doctor order by docid desc";
                    }
                ?>
                <tr>
                   <td colspan="4">
                       <center>
                        <div class="abc scroll">
                        <table width="93%" class="sub-table scrolldown" border="0">
                        <thead>
                        <tr>
                            <th class="table-headin">اسم مزود الخدمة</th>
                            <th class="table-headin">البريد الإلكتروني</th>
                            <th class="table-headin">التخصص</th>
                            <th class="table-headin">العمليات</th>
                        </tr>
                        </thead>
                        <tbody>
                            <?php
                                $result= $database->query($sqlmain);
                                if($result->num_rows==0){
                                    echo '<tr>
                                    <td colspan="4">
                                    <br><br><br><br>
                                    <center>
                                    <img src="../img/notfound.svg" width="25%">
                                    <br>
                                    <p class="heading-main12" style="margin-right: 45px;font-size:20px;color:rgb(49, 49, 49)">لم نجد أي مزود خدمة متعلق بالبحث!</p>
                                    <a class="non-style-link" href="doctors.php"><button  class="login-btn btn-primary-soft btn"  style="display: flex;justify-content: center;align-items: center;margin-right:20px;">&nbsp; عرض الكل &nbsp;</button>
                                    </a>
                                    </center>
                                    <br><br><br><br>
                                    </td>
                                    </tr>';
                                }
                                else{
                                for ( $x=0; $x<$result->num_rows;$x++){
                                    $row=$result->fetch_assoc();
                                    $docid=$row["docid"];
                                    $name=$row["docname"];
                                    $email=$row["docemail"];
                                    $spe=$row["specialties"];
                                    $spcil_res= $database->query("select sname from specialties where id='$spe'");
                                    $spcil_array= $spcil_res->fetch_assoc();
                                    $spcil_name=$spcil_array["sname"];
                                    echo '<tr>
                                        <td> &nbsp;'.substr($name,0,30).'</td>
                                        <td>'.substr($email,0,20).'</td>
                                        <td>'.substr($spcil_name,0,20).'</td>
                                        <td>
                                        <div style="display:flex;justify-content: center;">
                                        <a href="?action=view&id='.$docid.'" class="non-style-link"><button  class="btn-primary-soft btn button-icon btn-view"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">عرض</font></button></a>
                                       &nbsp;&nbsp;&nbsp;
                                       <a href="?action=session&id='.$docid.'&name='.$name.'"  class="non-style-link"><button  class="btn-primary-soft btn button-icon menu-icon-session-active"  style="padding-left: 40px;padding-top: 12px;padding-bottom: 12px;margin-top: 10px;"><font class="tn-in-text">الجلسات</font></button></a>
                                        </div>
                                        </td>
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
        </div>
    </div>
    <?php 
    if($_GET){
        $id=$_GET["id"];
        $action=$_GET["action"];
        if($action=='view'){
            $sqlmain = "SELECT * FROM doctor WHERE docid=?";
            $stmt = $database->prepare($sqlmain);
            $stmt->bind_param("i",$id);
            $stmt->execute();
            $result = $stmt->get_result();
            $row = $result->fetch_assoc();
            $name=$row["docname"];
            $email=$row["docemail"];
            $spe=$row["specialties"];
            $stmt = $database->prepare("select sname from specialties where id=?");
            $stmt->bind_param("s",$spe);
            $stmt->execute();
            $spcil_res = $stmt->get_result();
            $spcil_array= $spcil_res->fetch_assoc();
            $spcil_name=$spcil_array["sname"];
            $nic=$row['docnic'];
            $tele=$row['doctel'];
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <a class="close" href="doctors.php">&times;</a>
                        <div style="display: flex;justify-content: center;">
                        <table width="80%" class="sub-table scrolldown add-doc-form-container" border="0">
                            <tr>
                                <td>
                                    <p style="padding: 0;margin: 0;text-align: right;font-size: 25px;font-weight: 500;">تفاصيل المزود</p><br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="name" class="form-label">الاسم: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    '.$name.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Email" class="form-label">البريد الإلكتروني: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                '.$email.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="nic" class="form-label">رقم الهوية: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                '.$nic.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="Tele" class="form-label">رقم الهاتف: </label>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                '.$tele.'<br><br>
                                </td>
                            </tr>
                            <tr>
                                <td class="label-td" colspan="2">
                                    <label for="spec" class="form-label">التخصص: </label>
                                </td>
                            </tr>
                            <tr>
                            <td class="label-td" colspan="2">
                            '.$spcil_name.'<br><br>
                            </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <a href="doctors.php"><input type="button" value="حسناً" class="login-btn btn-primary-soft btn" ></a>
                                </td>
                            </tr>
                        </table>
                        </div>
                    </center>
                    <br><br>
            </div>
            </div>
            ';
        }elseif($action=='session'){
            $name=$_GET["name"];
            echo '
            <div id="popup1" class="overlay">
                    <div class="popup">
                    <center>
                        <h2>هل تريد عرض جلسات المزود؟</h2>
                        <a class="close" href="doctors.php">&times;</a>
                        <div class="content">عرض جميع الجلسات المتاحة بواسطة <br>('.substr($name,0,40).').</div>
                        <form action="schedule.php" method="post" style="display: flex">
                        <input type="hidden" name="search" value="'.$name.'">
                        <div style="display: flex;justify-content:center;margin-top:20px;width:100%">
                        <input type="submit"  value="نعم" class="btn-primary btn" style="padding:10px 40px"  >
                        </div>
                        </form>
                    </center>
            </div>
            </div>
            ';
        }
    };
?>
</div>
</body>
</html>