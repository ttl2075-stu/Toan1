<?php
    session_start();
    include 'connectdb.php';
    if(!isset($_SESSION['id_user'])){
        header('Location: index.php');
        die();
    }
    
    $role=$_SESSION['quyen'];
    $id_user = $_SESSION['id_user'];
    // $id_cau_hoi = $_GET['id_cau_hoi'];
    // $id_bai_hoc = $_GET['id_bai_hoc'];
    $id_khoa_hoc = $_GET['id_khoa_hoc'];
    
    // ndthien bổ sung hàm get info user 
    function get_user($id_user){
        GLOBAL $conn;
        $sql = "SELECT * FROM user where id_user = '$id_user'";
        $result = mysqli_query($conn, $sql);
        return mysqli_fetch_assoc($result);
    }
    
    function format_date($date){
        return date_format(date_create($date),"d/m/Y H:i:s");
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="src/css/nhap_de_thi.css?v=1">
    <link rel="stylesheet" href="src/css/root.css">
    <link rel="stylesheet" href="src/css/button.css">
    <link rel="stylesheet" href="./assets/css_v2/danh_sach_giao_bai_tap.css">
    <title>Danh sách học sinh được giao bài tập</title>
    <style>
    select {
        width: 200px;
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #61b1ee;
        color: #333;
    }

    option {
        background-color: #f8f8f8;
        color: #333;
    }

    tr,
    td {
        font-weight: bold;
        font-size: 25px;
    }
    </style>
</head>

<body>

    <?php 
        // $conn = mysqli_connect('localhost', 'root','', 'nckh_2024');
        // $role = $_GET['role'];
        // $id_user=$_GET['id_user'];
        // echo "<a href='nhap_cau_hoi.php?role=$role&id_user=$id_user'><i class='fa-solid fa-backward'></i>Trở về</a>";
        // echo " <a href='nhap_cau_hoi.php?role=$role'>Trở về</a>"; 
    ?>

    <!-- <h1>Nhập bài tập</h1> -->

    <form action="" method="post">
        <!-- <select name="user" id=""> -->
        <h1>Danh sách học sinh được giao bài tập</h1>
        <!-- <select name="user" id="a"> -->
        <?php
            
            
            //  $sql ="SELECT * FROM `user` WHERE `quyen`=2";
            if($role==3){
                $sql ="SELECT * FROM `thanh_vien_khoa_hoc` INNER JOIN `user` INNER JOIN `phu_huynh_hoc_sinh` WHERE `id_khoa_hoc`='1' AND `thanh_vien_khoa_hoc`.`id_user` = `user`.`id_user` AND `user`.`quyen`=2 AND `user`.`id_user` =`phu_huynh_hoc_sinh`.`id_user_hoc_sinh` AND `phu_huynh_hoc_sinh`.`id_user_phu_huynh`='$id_user'";
            }elseif($role==1){
                $sql ="SELECT * FROM `thanh_vien_khoa_hoc` INNER JOIN `user` WHERE `id_khoa_hoc`='$id_khoa_hoc' AND `thanh_vien_khoa_hoc`.`id_user` = `user`.`id_user` AND `user`.`quyen`=2";
            
            }
             $result = mysqli_query($conn, $sql);
             if (mysqli_num_rows($result) > 0) 
             {  
                $stt=1;
                echo "<table>";
                echo "<tr class='th'><td style='text-align:center;'><b>STT</b></td><td style='text-align:center;'><b>Họ tên</b></td><td style='text-align:center;'><b>Xem tiến độ</b></td></tr>";
                while($row = mysqli_fetch_assoc($result)) {
                    // echo "<option value='".$row['id_user']."'>".$row['ten'] ."</option>";
                    echo "<tr ><td style='font-weight: bold;font-size: 25px; text-align:center;'>". $stt."</td>";
                    echo "<td style='font-weight: bold;font-size: 25px;'>".$row['ten'] ."</td>";
                    echo "<td style='text-align:center;'> <a href='danh_sach_giao_bt_chi_tiet_1.php?id_khoa_hoc=$id_khoa_hoc&id_user=".$row['id_user']."' class = 'btn_tien_do button-1 button-blue'><i class='fa-solid fa-eye'></i></a></td>";
                    // echo "<td>".$row['ten'] ."</td></tr>";
                    $stt++;
                }
                // echo "</select>";
                echo "</table>";
             }  
             
            ?>

</body>

</html>