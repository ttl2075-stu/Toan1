<?php
    session_start();
    include 'connectdb.php';
    if(!isset($_SESSION['id_user'])){
        header('Location: index.php');
        die();
    }
    
    $role=$_SESSION['quyen'];
    $id_user = $_SESSION['id_user'];
    // $role=$_SESSION['quyen'];
    // $id_user = $_SESSION['id_user'];
    // $id_cau_hoi = $_GET['id_cau_hoi'];
    // $id_bai_hoc = $_GET['id_bai_hoc'];
    $id_khoa_hoc = $_GET['id_khoa_hoc'];
    $id_user1= $_GET['id_user'];
    
    
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
    <link rel="stylesheet" href="./assets/css_v2/chinh_phan_thuong_ct.css">
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
<a href="chinh_phan_thuong.php?id_khoa_hoc=<?php echo $id_khoa_hoc?>" class="btn_tro_ve">Trở về</a>
    <?php 
        $sql = "SELECT * FROM `user` WHERE `id_user`='$id_user'";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $ten = $row['ten'];
        $src_anh=get_url_anh($row['id_anh_phan_thuong']);
        // $src_anh= $row['url_anh'];
    ?>
    
    <!-- <h1>Nhập bài tập</h1> -->

    <!-- <a href="danh_sach_giao_bt.php">Trở về</a> -->
    <h1>Thay đổi phần thưởng</h1>
    <a href="upload_phan_thuong.php?id_khoa_hoc=<?php echo $id_khoa_hoc?>" class="btn_upload">Upload ảnh</a>
    <!-- <button>Up load ảnh</button> -->
        <!-- <select name="user" id="a"> -->
            <?php
            
            
             $sql ="SELECT * FROM `thanh_vien_khoa_hoc` INNER JOIN `user` WHERE `id_khoa_hoc`='$id_khoa_hoc' AND `thanh_vien_khoa_hoc`.`id_user` = `user`.`id_user` AND `user`.`quyen`=2 AND `user`.`id_user`='$id_user1'";
             $result = mysqli_query($conn, $sql);
             echo "<form  method='post'>";
             if (mysqli_num_rows($result) > 0) 
             {  
                $tong_phan_thuong = 0;
                $stt=1;
                echo "<table>";
                echo "<tr class='th'>
                    <td><b>STT</b></td>
                    <td style='min-width: 300px;'><b>Họ tên</b></td>
              
                    <td><b>Phần thưởng hiện tại</b></td>
                    <td><b>Lựa chọn ảnh</b></td>
                    <td><b>Thay đổi</b></td>
                   
                </tr>";
                $url ="";
                $anh=get_all_url_anh();
                $i=0;
                while($row = mysqli_fetch_assoc($result)) {
                    $id_user = $row['id_user'];
                    // echo "<option value='".$row['id_user']."'>".$row['ten'] ."</option>";
                    echo "<tr><td>". $stt."</td>";
                    echo "<td>".$row['ten']."</td>";
                    // $tt = ($row['trang_thai']==1) ? "<i class='fa-solid fa-circle-check' style='color: #63E6BE;'></i>" : "<i class='fa-regular fa-rectangle-xmark' style='color: #d26565;'></i>";
                    // echo "<td>".$tt."</td>";
                    $url="./anh/phan_thuong/".get_anh_user($id_user);
                    echo "<td><img style='width:7%' src='$url' ></td>";
                    // lựa chọn ảnh
                    // $anh=get_all_url_anh();
                    // print_r($anh);
                    
                    
                    
                    
                    //  $sql ="SELECT * FROM `user` WHERE `quyen`=2";
                    $sql1 ="SELECT * FROM `anh_phan_thuong`";
                    $result1 = mysqli_query($conn, $sql1);
                     if (mysqli_num_rows($result1) > 0) 
                     {  
                        echo "<td><select name='anh' id='a'>";
                        echo "<option value=''></option>";
                        while($row1 = mysqli_fetch_assoc($result1)) {
                            if($row1['ten_anh_phan_thuong']!=get_anh_user($id_user)){
                                echo "<option value='".$row1['id_anh_phan_thuong']."'>".$row1['ten_anh_phan_thuong'] ."</option>";
                            }
                            
                        }
                        echo "</select></td>";
                     }  
                    //  echo "<input type='hidden' name='test$i' value='$id_user'>";
                     echo "<td><input type='submit' name='thay_doi' value='Thay đổi' class='btn_thay_doi'></td>";
                   
                    $stt++;
                    $i++;
                }
                echo "</tr>";
                echo "</table>";
             }  
             echo "</form>";
             
             if(isset($_POST['thay_doi'])){
                if($_POST['anh']==""){
                    echo "<script>
                    alert('Vui lòng chọn ảnh!');
                </script>";
                }else{
                    $id_anh_cap_nhat=$_POST['anh'];
                    $sql = "UPDATE `user` SET `id_anh_phan_thuong`='$id_anh_cap_nhat' WHERE `id_user`='$id_user'";
                    mysqli_query($conn, $sql);
                    echo "<script>
                alert('Thay đổi thành công!');
            </script>";
                }
               
                // echo "$id_user";
             }







            //  danh sách hàm
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
             function sl_huong_dan($id_cau_hoi,$id_user){
                global $conn;
                $sql = "SELECT COUNT(`ho_tro_hien_thi`.`stt`) as sl FROM `bai_tap_user` INNER JOIN `cau_hoi` INNER JOIN `ho_tro_hien_thi` WHERE `bai_tap_user`.`id_cau_hoi` = `cau_hoi`.`id_cau_hoi` AND `bai_tap_user`.`id_cau_hoi`='134' AND `cau_hoi`.`id_loai_hien_thi` = `ho_tro_hien_thi`.`id_loai_hien_thi` AND `bai_tap_user`.`id_user`='$id_user'";
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
            function get_all_url_anh(){
                global $conn;
                $sql = "SELECT * FROM `anh_phan_thuong`";
                $list=[];
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($result)){
                    $list[]=$row;
                }
                // $row = mysqli_fetch_assoc($result);
                return $list;
            }
            function get_anh_user($id_user){
                global $conn;
                $sql = "SELECT * FROM `user` INNER JOIN `anh_phan_thuong` WHERE `user`.`id_anh_phan_thuong` = `anh_phan_thuong`.`id_anh_phan_thuong` AND `user`.`id_user`='$id_user'";
                $result = mysqli_query($conn, $sql);
                $row = mysqli_fetch_assoc($result);
                return $row['ten_anh_phan_thuong'];
            }
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
