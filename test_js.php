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
    $id_bai_hoc=1;
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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="src/css/nhap_de_thi.css?v=1">
	<link rel="stylesheet" href="src/css/root.css">
    <link rel="stylesheet" href="src/css/button.css">
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
        <h1>Lựa chọn học sinh</h1>
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
        <h1>Lựa chọn bài học</h1>
        <table>
            <?php
                echo "<select name='bai_hoc'>";
                //seleect bài học
                $sql ="SELECT * FROM `bai_hoc`";
                $result = mysqli_query($conn, $sql);
                 if (mysqli_num_rows($result) > 0) 
                 {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='".$row['ma_bai_hoc']."'>".$row['ten_bai_hoc'] ."</option>";
                    }
                    echo "</select>";
                 } 
                echo "<input type='submit' name='btn_bh' value='CHọn bài học'>";
                
                 if(isset($_POST['btn_bh'])){
                    // echo "Bài học:". $_POST['bai_hoc'];
                    $id_bai_hoc=$_POST['bai_hoc'];
                 }
                $sql1 ="SELECT * FROM `cau_hoi`  WHERE `id_bai_hoc`='$id_bai_hoc' AND `id_user`='$id_user' ORDER BY `cau_hoi`.`thoi_gian` DESC";
                $result = mysqli_query($conn, $sql1);
                
                // Kiểm tra số lượng record trả về có lơn hơn 0
                // Nếu lớn hơn tức là có kết quả, ngược lại sẽ không có kết quả
                echo "<table>";
                echo "<tr>
                    <th>STT</th>
                    <th>Chọn câu</th>
                    <th>Tên câu hỏi</th>
                    <th>Người thêm câu hỏi</th>
                    <th>Thời gian</th>
                    <th>Xem chi tiết</th>
                   
                </tr>";
                if (mysqli_num_rows($result) > 0) 
                {
                    $stt=1;
                    // Sử dụng vòng lặp while để lặp kết quả
                    while($row = mysqli_fetch_assoc($result)) {
                        $userRow = get_user($row["id_user"]);
                        echo "<tr>";
                        echo "<td>$stt</td>";
                        $id_cau_hoi= $row["id_cau_hoi"];
                        $id_loai_hien_thi= $row["id_loai_hien_thi"];
                        // $id_bai_tap_user = $row['id_bai_tap_user'];
                        echo "<td><input type='checkbox' name='chon[]' value='".$row['id_cau_hoi']."'></td>";
                        echo "<td>".$row["ten_cau_hoi"]."</td>";
                        echo "<td>".$userRow['tk']." - ".$userRow['ten']."</td>";
                        echo "<td>".(strtotime($row['thoi_gian']) <= 0 ? "-" : format_date($row["thoi_gian"]))."</td>";
                        // echo "<td><a class= 'btn_xem_chi_tiet' href=' in_cau_hoi.php?id_cau_hoi=".$row['id_cau_hoi']."'><i class='fa-solid fa-eye'></i>Xem chi tiết</a></td>";
                        // echo "</tr>";
                        if ($row["id_loai_hien_thi"] == 1){
                            echo "<td><a class= 'btn_xem_chi_tiet' href='in_cau_hoi_d6k1.php?id_bai_tap_user=0&id_cau_hoi=$id_cau_hoi&id_loai_hien_thi=$id_loai_hien_thi'><i class='fa-solid fa-eye'></i>Xem chi tiết</a></td>";
                            // echo "<li><a href='../../in_cau_hoi_d6k1.php?id_cau_hoi=$id_cau_hoi&id_loai_hien_thi=$id_loai_hien_thi' target='ndung1'>";
                            // echo $row['ten_cau_hoi'];
                            // echo "</a></li>";
                          }
                          elseif ($row["id_loai_hien_thi"] == 3){
                            //  e thêm onclick
                            echo "<td><a class= 'btn_xem_chi_tiet'  onclick='luubien()'  href='in_cau_hoi_d6k3.php?id_bai_tap_user=0&id_cau_hoi=$id_cau_hoi&id_loai_hien_thi=$id_loai_hien_thi'><i class='fa-solid fa-eye'></i>Xem chi tiết</a></td>";
                            //   echo "<li><a href='../../in_cau_hoi_d6k3.php?&id_cau_hoi=$id_cau_hoi&id_loai_hien_thi=$id_loai_hien_thi' onclick='luubien()' target='ndung1'>";
                            //   echo $row['ten_cau_hoi'];
                            //   echo "</a></li>";
                          }
                          elseif ($row["id_loai_hien_thi"] == 2){
                            echo "<td><a class= 'btn_xem_chi_tiet' onclick='luubien_2()' href='in_cau_hoi.php?id_bai_tap_user=0&id_cau_hoi=$id_cau_hoi&id_loai_hien_thi=$id_loai_hien_thi'><i class='fa-solid fa-eye'></i>Xem chi tiết</a></td>";
                           
                            // echo "<li><a href='../../in_cau_hoi.php?&id_cau_hoi=$id_cau_hoi&id_loai_hien_thi=$id_loai_hien_thi' target='ndung1'>";
                            // echo $row['ten_cau_hoi'];
                            // echo "</a></li>";
                        }
                          elseif ($row["id_loai_hien_thi"] == 4){
                              // $in = "in_cau_hoi_d7k1";
                              echo "<td><a class= 'btn_xem_chi_tiet' href='in_cau_hoi_d7k1.php?id_bai_tap_user=0&id_cau_hoi=$id_cau_hoi&id_loai_hien_thi=$id_loai_hien_thi'><i class='fa-solid fa-eye'></i>Xem chi tiết</a></td>";
                           
                            //   echo "<li><a href='../../in_cau_hoi_d7k1.php?&id_cau_hoi=$id_cau_hoi&id_loai_hien_thi=$id_loai_hien_thi' target='ndung1'>";
                            //   echo $row['ten_cau_hoi'];
                            //   echo "</a></li>";
                        } 
                        echo "</tr>";
                        $stt++;
                    }
                } 
                else {
                    echo "<tr><td colspan='3'>Không có bài tập nào</td></tr>";
                }
                echo "<table>";
            ?>
        </table>
        <input type="submit" name="btn_de" value="Giao bài tập">
    </form>
    <?php
        if(isset($_POST['btn_de'])){
            $user= isset($_POST['user'])? $_POST['user']:"";
            // echo $u/ser;
            
            $check = isset($_POST['chon']) ?$_POST['chon']:"" ;
            if($user =="" || $check ==""){
                // echo "Giao bài tập không thành công";
                echo "<script>alert('Giao bài tập không thành công');</script>";
            }
            else{
                // mysqli_query($conn,$sql);
                // $last_id = mysqli_insert_id($conn);
                foreach($check as $id_cau_hoi ){
                    // echo $value;
                    $sql ="SELECT * FROM `bai_tap_user` WHERE `id_user`='$id_user' AND `id_cau_hoi`='$id_cau_hoi'";
                    $kt=mysqli_query($conn,$sql);
                    if (mysqli_num_rows($kt) > 0) 
                    {
                       continue;
                    }else{
                        $sql="INSERT INTO `bai_tap_user`(`id_bai_tap_user`, `id_cau_hoi`, `id_user`) VALUES (null,'$id_cau_hoi','$user')";
                        // $sql = "INSERT INTO `bai_tap_user` (`id_de_thi_chi_tiet`, `id_cau_hoi`, `id_de_thi`) VALUES (NULL, '$id_cau_hoi', '$last_id')";
                        mysqli_query($conn,$sql);
                    }
                    
                    
                }
                echo "<script>alert('Giao bài tập thành công');</script>";
            }
            // print_r($check);
            // $sql = "INSERT INTO `de_thi` (`id_de_thi`, `ten_de_thi`, `id_bai_hoc`) VALUES (NULL, '$ten_de', '$id_bai_hoc')";
           
           
        }
    ?>
   <script>
    function luubien(){
        localStorage.setItem('mucdo', 0);
    }

    function luubien_2(){
        localStorage.setItem('mucdo_2', 0);
    }
   </script>
</body>
</html>
