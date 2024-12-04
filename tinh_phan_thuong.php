<?php
    session_start();
    include 'connectdb.php';
    if(!isset($_SESSION['id_user'])){
        header('Location: index.php');
        die();
    }
    
    $role=$_SESSION['quyen'];
    $id_user = $_SESSION['id_user'];
    $id_khoa_hoc=$_GET['id_khoa_hoc'];
    // $id_user1 = $_GET['id_user'];
    // $id_bai_hoc = $_GET['id_bai_hoc'];
    
    
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./assets/css_v2/tinh_phan_thuong.css">
    <title>Tính phần thưởng</title>
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
        .fa-solid{
            font-size:30px;
        }
        .fa-regular{
            font-size:30px;
        }
    </style>
</head>
<body>
    <!-- 25/07/2024 -->
        

    <!-- end 25/07/2024 -->
    <?php 
        $sql = "SELECT * FROM `user` WHERE `id_user`='$id_user'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $ten = $row['ten'];
        $src_anh=get_url_anh($row['id_anh_phan_thuong']);
        // $src_anh= $row['url_anh'];
    ?>
    
    <!-- <h1>Nhập bài tập</h1> -->

    <a href="doimatkhau.php" class="btn_doi_mat_khau">Đổi mật khẩu</a>
    <form action="" method="post">
        <!-- <select name="user" id=""> -->
        <h1>Tiến độ làm bài tập của <?php echo $ten; ?></h1>
      
        <!-- <select name="user" id="a"> -->
            <?php
            
            
            //  $sql ="SELECT * FROM `bai_tap_user` WHERE `id_user`='$id_user' AND `id_khoa_hoc`=$id_khoa_hoc";
             $sql ="SELECT * FROM `bai_hoc` INNER JOIN `cau_hoi` INNER JOIN `bai_tap_user` WHERE `bai_hoc`.`ma_bai_hoc` =`cau_hoi`.`id_bai_hoc` AND `cau_hoi`.`id_cau_hoi` = `bai_tap_user`.`id_cau_hoi` AND `bai_tap_user`.`id_user`='$id_user' AND `bai_tap_user`.`id_khoa_hoc`='$id_khoa_hoc'";
            $result = mysqli_query($conn, $sql);
             if (mysqli_num_rows($result) > 0) 
             {  
                $tong_phan_thuong = 0;
                $stt=1;
                echo "<table>";
                echo "<tr class='th'>
                    <td><b>STT</b></td>
                    <td style='min-width: 300px;'><b>Câu hỏi</b></td>
                    <td style='min-width: 300px;'><b>Bài học</b></td>
                    <td><b>Trạng thái</b></td>
                   
                    <td><b>Phần thưởng cho bạn</b></td>
                </tr>";
                $url ="";
                while($row = mysqli_fetch_assoc($result)) {
                    // echo "<option value='".$row['id_user']."'>".$row['ten'] ."</option>";
                    echo "<tr><td>". $stt."</td>";
                    $id_cau_hoi = $row['id_cau_hoi'];
                    $row1 = get_ten_cau_hoi($id_cau_hoi);
                    $huong_dan_toi_da =$row['huong_dan_toi_da'];
                    // print_r($row1);
                    $ten_bai_hoc=get_ten_bai_hoc($id_cau_hoi);
                    $k=(empty($row1['ten_cau_hoi'])) ? "Câu hỏi đã bị xóa" : $row1['ten_cau_hoi'];
                    echo "<td>".$k."</td>";
                    echo "<td>".$ten_bai_hoc['ten_bai_hoc']."</td>";
                    $tt = ($row['trang_thai']==1) ? "<i class='fa-solid fa-circle-check' style='color: #63E6BE;'></i>" : "<i class='fa-regular fa-rectangle-xmark' style='color: #d26565;'></i>";
                    echo "<td>".$tt."</td>";
                    
                    if($row['trang_thai']==1){
                        // $ti_le = 100/(sl_huong_dan($id_cau_hoi,$id_user) +1);
                        // $phan_tram = 100 - ($ti_le*$huong_dan_toi_da);
                        $so_luong_phan_thuong_toi_da =  sl_huong_dan($id_cau_hoi,$id_user,$id_khoa_hoc)+1;
                        $so_luong_phan_thuong = $so_luong_phan_thuong_toi_da- $huong_dan_toi_da;
                        $url ="./anh/phan_thuong/".$src_anh['ten_anh_phan_thuong'];
                        echo "<td>".in_so_sao($so_luong_phan_thuong_toi_da,$so_luong_phan_thuong,$url)."</td>";
                        $tong_phan_thuong=$tong_phan_thuong+$so_luong_phan_thuong;
                    }else{
                        $so_luong_phan_thuong_toi_da =  sl_huong_dan($id_cau_hoi,$id_user,$id_khoa_hoc)+1;
                        // echo "<td>
                        // 0
                        // </td>";
                        echo "<td>".
                        in_so_sao($so_luong_phan_thuong_toi_da,0,$url)."
                        </td>";
                    }
                    
                    $stt++;
                
                }
                echo "<tr>
                    <td  colspan='5'>tong_phan_thuong:".in_so_sao($tong_phan_thuong,$tong_phan_thuong,$url,"3%") ."($tong_phan_thuong) </td>
                </tr>";
                // echo "</select>";
                echo "</table>";
             }  
             function get_ten_bai_hoc($id_cau_hoi){
                global $conn;
                $sql = "SELECT * FROM `cau_hoi` INNER JOIN `bai_hoc` WHERE `id_cau_hoi`='$id_cau_hoi' AND `cau_hoi`.`id_bai_hoc` = `bai_hoc`.`ma_bai_hoc`";
                // $sql = "SELECT * FROM `cau_hoi` WHERE `id_cau_hoi`='$id_cau_hoi'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                return $row;
            }
             
             function get_ten_cau_hoi($id_cau_hoi){
                global $conn;
                $sql = "SELECT * FROM `cau_hoi` WHERE `id_cau_hoi`='$id_cau_hoi'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                return $row;
                
             }
             function get_ten_loai_hien_thi($id_loai_hien_thi){
                global $conn;
                $sql = "SELECT * FROM `loai_hien_thi` WHERE `id_loai_hien_thi`='$id_loai_hien_thi'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                return $row;
                
             }
             function sl_huong_dan($id_cau_hoi,$id_user,$id_khoa_hoc){
                global $conn;
                $sql = "SELECT COUNT(`ho_tro_hien_thi`.`stt`) as sl FROM `bai_tap_user` INNER JOIN `cau_hoi` INNER JOIN `ho_tro_hien_thi` WHERE `bai_tap_user`.`id_cau_hoi` = `cau_hoi`.`id_cau_hoi` AND `bai_tap_user`.`id_cau_hoi`='$id_cau_hoi' AND `cau_hoi`.`id_loai_hien_thi` = `ho_tro_hien_thi`.`id_loai_hien_thi` AND `bai_tap_user`.`id_user`='$id_user' AND `id_khoa_hoc`='$id_khoa_hoc';";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                return $row['sl'];
             }

            function get_url_anh($id_anh_phan_thuong){
                global $conn;
                $sql = "SELECT * FROM `anh_phan_thuong` WHERE `id_anh_phan_thuong`='$id_anh_phan_thuong'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                return $row;
            }
            //  function sl_huong_dan_v2($id_cau_hoi){
            //     global $conn;
            //     $sql = "SELECT COUNT(`ho_tro_hien_thi`.`stt`) as sl FROM `bai_tap_user` INNER JOIN `cau_hoi` INNER JOIN `ho_tro_hien_thi` WHERE `bai_tap_user`.`id_cau_hoi` = `cau_hoi`.`id_cau_hoi` AND `bai_tap_user`.`id_cau_hoi`='$id_cau_hoi' AND `cau_hoi`.`id_loai_hien_thi` = `ho_tro_hien_thi`.`id_loai_hien_thi`";
            //     $result = mysqli_query($conn, $sql);
            //     $row = mysqli_fetch_assoc($result);
            //     return $row['sl'];
            //  }
            function in_so_sao($pt_toi_da, $pt_dat_duoc,$url,$width="7%"){
                global $conn;
                $kq="";
                
                for ($i=0; $i < $pt_dat_duoc; $i++) { 
                    // echo "<i class='fa-solid fa-star' style='color: #FFD43B;'></i>";
                    // $kq.="<i class='$url' style='color: #FFD43B;'></i>";
                    $kq.="<img style='width:$width' src='$url' >";
                }
                // for ($i=0; $i <$pt_toi_da -  $pt_dat_duoc; $i++) { 
                //     // echo "<i class='fa-regular fa-star' style='color: #FFD43B;'></i>";
                //     $kq.="<i class='fa-regular fa-star' style='color: #FFD43B;'></i>";
                // }
                return $kq;
            }
            ?>
    
</body>
</html>
