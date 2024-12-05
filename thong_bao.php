<?php
    session_start();
    include 'connectdb.php';
    if(!isset($_SESSION['id_user'])){
        header('Location: index.php');
        die();
    }
    
    $role=$_SESSION['quyen'];
    $id_user = $_SESSION['id_user'];
    $id_cau_hoi = $_GET['id_cau_hoi'];
    $id_khoa_hoc = $_GET['id_khoa_hoc'];
    // $id_bai_hoc = $_GET['id_bai_hoc'];
    // echo $id_cau_hoi;
    
    // ndthien bổ sung hàm get info user 
    function get_user($id_user){
        GLOBAL $conn;
        // $sql ="SELECT * FROM `thanh_vien_khoa_hoc` INNER JOIN `user` WHERE `id_khoa_hoc`='$id_khoa_hoc' AND `thanh_vien_khoa_hoc`.`id_user` = `user`.`id_user` AND `user`.`quyen`=2";
            
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
    <link rel="stylesheet" href="assets/css_v2/nhap_cau_hoi.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Nhập đề thi</title>
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
    </style>
</head>

<body>

    <h1>Giao bài tập vừa rồi cho học sinh</h1>
    <form action="" method="post">
        <!-- <select name="user" id=""> -->
        <h4>Chọn học sinh</h4>
        <select name="user" id="a">
            <?php
            
            
            //  $sql ="SELECT * FROM `user` WHERE `quyen`=2";
             $sql ="SELECT * FROM `thanh_vien_khoa_hoc` INNER JOIN `user` WHERE `id_khoa_hoc`='$id_khoa_hoc' AND `thanh_vien_khoa_hoc`.`id_user` = `user`.`id_user` AND `user`.`quyen`=2";
            
             $result = mysqli_query($conn, $sql);
             if (mysqli_num_rows($result) > 0) 
             {  
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<option value='".$row['id_user']."'>".$row['ten'] ."</option>";
                }
                echo "</select>";
             }  
             
            ?>

            <!-- </select> -->

            <input class="btn-submit" type="submit" name="btn_de" value="Giao bài tập">
            <input class="btn-submit" type="submit" name="btn_tro_ve" value="Trở về">
    </form>
    <?php
        if(isset($_POST['btn_de'])){
            $user= $_POST['user'];
            // echo $u/ser;
            // echo "oke";
            // $check = $_POST['chon'];
            // print_r($check);
            // $sql = "INSERT INTO `de_thi` (`id_de_thi`, `ten_de_thi`, `id_bai_hoc`) VALUES (NULL, '$ten_de', '$id_bai_hoc')";
           
            // mysqli_query($conn,$sql);
            // $last_id = mysqli_insert_id($conn);
            // $sql = "INSERT INTO `bai_tap_user`(`id_bai_tap_user`, `id_user`, `id_cau_hoi`, `trang_thai`, `huong_dan_toi_da`, `id_khoa_hoc`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]')";
            $sql="INSERT INTO `bai_tap_user`(`id_bai_tap_user`, `id_user`,`id_cau_hoi`,`trang_thai` ,`huong_dan_toi_da`,`id_khoa_hoc`) VALUES 
                                                (null,'$user','$id_cau_hoi','0','0','$id_khoa_hoc')";
            if(mysqli_query($conn,$sql)){
                echo " <div class='alert alert-success'>
                <strong>Chúc mừng!</strong> Bạn đã giao bài tập thành công cho học sinh.
              </div>";
            }
            
        }
        if(isset($_POST['btn_tro_ve'])){
           
            header("Location: nhap_cau_hoi.php?id_khoa_hoc=$id_khoa_hoc");
        }
    ?>

</body>

</html>