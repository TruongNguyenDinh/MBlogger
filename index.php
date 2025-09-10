<?php
    //Kiểm tra 
    session_start();
    // Nếu đã đăng nhập
    if(isset($_SESSION['user_id'])){
        header("Location: dashboard.php");
        exit();
    }
    // Nếu chưa đăng nhập
    header("Location: ./views/form.php");
    exit();
?>