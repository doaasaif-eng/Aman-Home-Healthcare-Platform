<?php
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

    if($_POST){
        $appoid = $_POST["appoid"];
        $rating = $_POST["rating"];
        $comment = $_POST["comment"];

        // Get pid and docid from appointment
        $sql = "select appointment.pid, schedule.docid from appointment 
                inner join schedule on appointment.scheduleid = schedule.scheduleid 
                where appointment.appoid = ?";
        $stmt = $database->prepare($sql);
        $stmt->bind_param("i", $appoid);
        $stmt->execute();
        $row = $stmt->get_result()->fetch_assoc();
        $pid = $row["pid"];
        $docid = $row["docid"];

        // Insert review
        $sql_rev = "insert into reviews (appoid, pid, docid, rating, comment, review_date) values (?, ?, ?, ?, ?, NOW())";
        $stmt_rev = $database->prepare($sql_rev);
        $stmt_rev->bind_param("iiiis", $appoid, $pid, $docid, $rating, $comment);
        $stmt_rev->execute();

        header("location: appointment.php?success=review-added");
    }
?>
