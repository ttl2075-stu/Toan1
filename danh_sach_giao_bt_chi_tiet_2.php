<?php
    ob_start();
    session_start();
    include 'connectdb.php';
    if(!isset($_SESSION['id_user'])){
        header('Location: index.php');
        die();
    }
    
    $role=$_SESSION['quyen'];
    $id_user = $_SESSION['id_user'];
    $id_user1 = $_GET['id_user'];
    $id_bai_hoc = $_GET['id_bai_hoc'];
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
        #hiddenInput{
            display: none;
        }
        .huy_giao{
            background-color: #dc3545;
        }
        .lich_su{
            background-color: #198754;
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

    <a href="danh_sach_giao_bt_chi_tiet_1.php?id_user=<?php echo $id_user1?>&id_khoa_hoc=<?php echo $id_khoa_hoc; ?>">Trở về</a>
    <form id="deleteForm" action="" method="post">
        <!-- <select name="user" id=""> -->
        <h1>Tiến độ làm bài tập của <?php echo $ten; ?></h1>
      
        <!-- <select name="user" id="a"> -->
            <?php
            
            
             $sql ="SELECT * FROM `bai_hoc` INNER JOIN `cau_hoi` INNER JOIN `bai_tap_user` WHERE `bai_hoc`.`ma_bai_hoc` =`cau_hoi`.`id_bai_hoc` AND `cau_hoi`.`id_cau_hoi` = `bai_tap_user`.`id_cau_hoi` AND `bai_tap_user`.`id_user`='$id_user1' AND `bai_tap_user`.`id_khoa_hoc`='$id_khoa_hoc' AND `cau_hoi`.`id_bai_hoc`='$id_bai_hoc'";
             $result = mysqli_query($conn, $sql);
             if (mysqli_num_rows($result) > 0) 
             {  
                $stt=1;
                echo "<table>";
                echo "<tr>
                    <td><b>STT</b></td>
                    <td><b>Câu hỏi</b></td>
                    <td><b>Trạng thái</b></td>
                  
                    <td><b>Mức độ hoàn thành</b></td>
                    <td><b>Chức năng</b></td>
                </tr>";
                while($row = mysqli_fetch_assoc($result)) {
                    // echo "<option value='".$row['id_user']."'>".$row['ten'] ."</option>";
                    
                    echo "<tr><td>". $stt."</td>";
                    $id_cau_hoi = $row['id_cau_hoi'];
                    $id_bai_tap_user=$row['id_bai_tap_user'];
                    $row1 = get_ten_cau_hoi($id_cau_hoi);
                    $huong_dan_toi_da =$row['huong_dan_toi_da'];
                    $id_loai_hien_thi=$row['id_loai_hien_thi'];
                    $sl_hd_toi_da=sl_huong_dan_toi_da($id_loai_hien_thi);
                    // print_r($row1);
                    $k=(empty($row1['ten_cau_hoi'])) ? "Câu hỏi đã bị xóa" : $row1['ten_cau_hoi'];
                    echo "<td>".$k."</td>";
                    $tt = ($row['trang_thai']==1) ? "<i class='fa-solid fa-circle-check' style='color: #63E6BE;'></i>" : "<i class='fa-regular fa-rectangle-xmark' style='color: #d26565;'></i>";
                    echo "<td>".$tt."</td>";
                    if($row['trang_thai']==1){
                        $ti_le = 100/($sl_hd_toi_da +1);
                        $phan_tram = 100 - ($ti_le*$huong_dan_toi_da);
                        // if($row['tg_bd']!="" &&$row['tg_kt'] ){
                        //     echo "<td>".$row['tg_bd']."</td>";
                        //     echo "<td>".$row['tg_kt']."</td>";
                        // }else{
                        //     echo "<td>-</td>";
                        //     echo "<td>-</td>";
                        // }
                        echo "<td>
                            ".
                            round($phan_tram)."
                        </td>";
                    }else{
                        // echo "<td>-</td>";
                        // echo "<td>-</td>";
                        echo "<td>
                        0
                        </td>";
                    }
                    echo "<td><a class='huy_giao' href='huy_giao_bt.php?id_bai_tap_user=$id_bai_tap_user&id_bai_hoc=$id_bai_hoc&id_khoa_hoc=$id_khoa_hoc&id_user=$id_user1'>Hủy giao bài tập</a>
                        <a class='lich_su' href='lich_su_lam_bai.php?id_bai_tap_user=$id_bai_tap_user&id_bai_hoc=$id_bai_hoc&id_khoa_hoc=$id_khoa_hoc&id_user=$id_user1''>Xem lịch sử làm bài</a>
                    </td>";
                   
                    $stt++;
                
                }
                echo " <input  type='text' id='hiddenInput' name='id_bai_tap_user' value=''>";
                // echo "</select>";
                echo "</table>";
             }  
             
             ?>
               <script>
                    var buttons = document.querySelectorAll('.nut');
                    buttons.forEach(function(button) {
                        button.onclick = function() {
                            var confirmAction = confirm("Bạn muốn hủy bài tập không?");
                            if (confirmAction) {
                                var id = this.value;
                                console.log(id);
                                document.getElementById('hiddenInput').value = id;
                                document.getElementById('deleteForm').submit();
                            }
                        }
                    });
                </script>
             <?php
             if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id_bai_tap_user'])) {
                $id_bai_tap_user = $_POST['id_bai_tap_user'];
        
                // Hàm xóa bài tập (ví dụ)
               
        
                huy_giao($id_bai_tap_user);
                header("Location: danh_sach_giao_bt_chi_tiet_2.php?id_bai_hoc=$id_bai_hoc&id_khoa_hoc=$id_khoa_hoc&id_user1=$id_user1");
                exit();
                
            }
           
            
             function huy_giao($id_bai_tap_user){
                global $conn;
                $sql = "DELETE FROM `bai_tap_user` WHERE `id_bai_tap_user`='$id_bai_tap_user'";
                $result = mysqli_query($conn, $sql);
                return $result;
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
             function sl_huong_dan_toi_da($id_loai_hien_thi){
                global $conn;
                // $sql = "SELECT COUNT(`ho_tro_hien_thi`.`stt`) as sl FROM `bai_tap_user` INNER JOIN `cau_hoi` INNER JOIN `ho_tro_hien_thi` WHERE `bai_tap_user`.`id_cau_hoi` = `cau_hoi`.`id_cau_hoi` AND `bai_tap_user`.`id_cau_hoi`='134' AND `cau_hoi`.`id_loai_hien_thi` = `ho_tro_hien_thi`.`id_loai_hien_thi` AND `bai_tap_user`.`id_user`='$id_user1'";
                $sql = "SELECT COUNT(*) as sl FROM `ho_tro_hien_thi` WHERE `id_loai_hien_thi`='$id_loai_hien_thi'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                return $row['sl'];
             }
            //  function sl_huong_dan_v2($id_cau_hoi){
            //     global $conn;
            //     $sql = "SELECT COUNT(`ho_tro_hien_thi`.`stt`) as sl FROM `bai_tap_user` INNER JOIN `cau_hoi` INNER JOIN `ho_tro_hien_thi` WHERE `bai_tap_user`.`id_cau_hoi` = `cau_hoi`.`id_cau_hoi` AND `bai_tap_user`.`id_cau_hoi`='$id_cau_hoi' AND `cau_hoi`.`id_loai_hien_thi` = `ho_tro_hien_thi`.`id_loai_hien_thi`";
            //     $result = mysqli_query($conn, $sql);
            //     $row = mysqli_fetch_assoc($result);
            //     return $row['sl'];
            //  }
            ?>
    </form>
</body>
</html>
<?php
// Tắt bộ đệm đầu ra và gửi kết quả tới trình duyệt
ob_end_flush();
?>