<?php
    session_start();
    include 'connectdb.php';
    if(!isset($_SESSION['id_user'])){
        header('Location: index.php');
        die();
    }
    
    $role=$_SESSION['quyen'];
    $id_user = $_SESSION['id_user'];
    $id_user1 = $_GET['id_user'];
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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="src/css/nhap_de_thi.css?v=1">
	<link rel="stylesheet" href="src/css/root.css">
    <link rel="stylesheet" href="src/css/button.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./assets/css_v2/danh_sach_giao_bt_1.css">
    <title>Giao bài tập chi tiết</title>
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
        tr,td{
            font-weight: bold;
            font-size: 25px;
        } 
    </style>
</head>
<body>

    <?php 
        $sql = "SELECT * FROM `user` WHERE `id_user`='$id_user1'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $ten = $row['ten'];
    ?>
    
    <!-- <h1>Nhập bài tập</h1> -->

    <a href="danh_sach_giao_bt.php?id_khoa_hoc=<?php echo $id_khoa_hoc; ?>" class="btn_tro_ve">Trở về</a>
    <form action="" method="post">
        <!-- <select name="user" id=""> -->
        <h1>Tiến độ làm bài tập theo từng chủ đề của <?php echo $ten; ?></h1>
      
        <!-- <select name="user" id="a"> -->
            <?php
            
            
            //  $sql ="SELECT * FROM `bai_tap_user` WHERE `id_user`='$id_user1' AND `id_khoa_hoc`='$id_khoa_hoc'";
            $sql ="SELECT * FROM `bai_hoc`";
             $result = mysqli_query($conn, $sql);
             if (mysqli_num_rows($result) > 0) 
             {  
                $stt=1;
                echo "<table>";
                echo "<tr class='th'>
                    <td><b>STT</b></td>
                    <td><b>Chủ đề</b></td>
                    <td><b>Trạng thái</b></td>
                    <td><b>Mức độ hoàn thành</b></td>
                   
                    <td><b>Xem chi tiết</b></td>
                </tr>";
                while($row = mysqli_fetch_assoc($result)) {
                    // echo "<option value='".$row['id_user']."'>".$row['ten'] ."</option>";
                    echo "<tr><td>". $stt."</td>";
                    // $id_cau_hoi = $row['id_cau_hoi'];
                    // $row1 = get_ten_cau_hoi($id_cau_hoi);
                    // $huong_dan_toi_da =$row['huong_dan_toi_da'];
                    // print_r($row1);
                    // $k=(empty($row1['ten_cau_hoi'])) ? "Câu hỏi đã bị xóa" : $row1['ten_cau_hoi'];
                    // echo "<td>".$k."</td>";
                    // $tt = ($row['trang_thai']==1) ? "<i class='fa-solid fa-circle-check' style='color: #63E6BE;'></i>" : "<i class='fa-regular fa-rectangle-xmark' style='color: #d26565;'></i>";
                    // echo "<td>".$tt."</td>";
                    // if($row['trang_thai']==1){
                    //     $ti_le = 100/(sl_huong_dan($id_cau_hoi,$id_user1) +1);
                    //     $phan_tram = 100 - ($ti_le*$huong_dan_toi_da);
                    //     echo "<td>
                    //         ".
                    //         round($phan_tram)."
                    //     </td>";
                    // }else{
                    //     echo "<td>
                    //     0
                    //     </td>";
                    // }
                    $ten_chu_de=$row['ten_bai_hoc'];
                    $id_bai_hoc=$row['ma_bai_hoc'];
                    $sl_cau=so_luong_cau_hoi_trong_chu_de($id_user1,$id_khoa_hoc,$id_bai_hoc);
                    $sl_cau_hoan_thanh =so_luong_cau_hoi_trong_chu_de_hoan_thanh($id_user1,$id_khoa_hoc,$id_bai_hoc);
                   
                    echo "<td>$ten_chu_de</td>";
                    if($sl_cau>0){
                        
                        if($sl_cau-$sl_cau_hoan_thanh==0){
                            echo "<td><i class='fa-solid fa-circle-check' style='color: #63E6BE;'></i></td>";
                            echo "<td>100%</td>";
                        }else{
                            echo "<td><i class='fa-regular fa-rectangle-xmark' style='color: #d26565;'></i></td>";
                            if($sl_cau_hoan_thanh==0){
                                echo "<td>0%</td>";
                            }else{
                                 $phan_tram = round(($sl_cau_hoan_thanh/$sl_cau)*100);
                                echo "<td>$phan_tram%</td>";
                            }
                        }
                        
                    }else{
                      
                        echo "<td>Chưa giao bài tập</td>";
                        echo "<td>0</td>";
                    }
                    echo "<td> <a href='danh_sach_giao_bt_chi_tiet_2.php?id_bai_hoc=$id_bai_hoc&id_khoa_hoc=$id_khoa_hoc&id_user=".$id_user1."' class='btn_xem_ct'><i class='fa-solid fa-eye'></i></a></td>";
                  
                    
                    echo "</tr>";
                    
                    $stt++;
                
                }
                
                // echo "</select>";
                echo "</table>";
             }  
             function so_luong_cau_hoi_trong_chu_de($id_user1,$id_khoa_hoc,$id_bai_hoc){
                global $conn;
                $sql ="SELECT COUNT(*) as sl FROM `bai_hoc` INNER JOIN `cau_hoi` INNER JOIN `bai_tap_user` WHERE `bai_hoc`.`ma_bai_hoc` =`cau_hoi`.`id_bai_hoc` AND `cau_hoi`.`id_cau_hoi` = `bai_tap_user`.`id_cau_hoi` AND `bai_tap_user`.`id_user`='$id_user1' AND `bai_tap_user`.`id_khoa_hoc`='$id_khoa_hoc'AND `cau_hoi`.`id_bai_hoc`='$id_bai_hoc'";
                $result = mysqli_query($conn, $sql);
                $kq=0;
                if (mysqli_num_rows($result) > 0){
                    $row = mysqli_fetch_assoc($result);
                    $kq= $row['sl'];
                }
                $kq = (int)$kq;
                return $kq;
                
            }
            function so_luong_cau_hoi_trong_chu_de_hoan_thanh($id_user1,$id_khoa_hoc,$id_bai_hoc){
                global $conn;
                $kq=0;
                $sql ="SELECT COUNT(*) as sl FROM `bai_hoc` INNER JOIN `cau_hoi` INNER JOIN `bai_tap_user` WHERE `bai_hoc`.`ma_bai_hoc` =`cau_hoi`.`id_bai_hoc` AND `cau_hoi`.`id_cau_hoi` = `bai_tap_user`.`id_cau_hoi` AND `bai_tap_user`.`id_user`='$id_user1' AND `bai_tap_user`.`id_khoa_hoc`='$id_khoa_hoc'AND `cau_hoi`.`id_bai_hoc`='$id_bai_hoc' AND `bai_tap_user`.`trang_thai`=1";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0){
                    $row = mysqli_fetch_assoc($result);
                    $kq= $row['sl'];

                }
                $kq = (int)$kq;
                return $kq;
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
             function sl_huong_dan($id_cau_hoi,$id_user1){
                global $conn;
                $sql = "SELECT COUNT(`ho_tro_hien_thi`.`stt`) as sl FROM `bai_tap_user` INNER JOIN `cau_hoi` INNER JOIN `ho_tro_hien_thi` WHERE `bai_tap_user`.`id_cau_hoi` = `cau_hoi`.`id_cau_hoi` AND `bai_tap_user`.`id_cau_hoi`='134' AND `cau_hoi`.`id_loai_hien_thi` = `ho_tro_hien_thi`.`id_loai_hien_thi` AND `bai_tap_user`.`id_user`='$id_user1'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                return $row['sl'];
             }
            ?>
    
</body>
</html>
