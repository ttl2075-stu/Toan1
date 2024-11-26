<?php
    session_start();
    include 'connectdb.php';
    if(!isset($_SESSION['id_user'])){
        header('Location: index.php');
        die();
    }
    
    $role=$_SESSION['quyen'];
    $id_user = $_SESSION['id_user'];
    $id_bai_hoc = $_GET['id_bai_hoc'];
    $id_khoa_hoc = $_GET['id_khoa_hoc'];
    // $id_cau_hoi = $_GET['id_cau_hoi'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="src/css/nhap_cau_hoi.css?v=2">
	<link rel="stylesheet" href="src/css/root.css">
    <link rel="stylesheet" href="src/css/button.css">
    <title>Nhập câu hỏi dạng game chọn cặp</title>
    <style>
        .center-text{
            font-size: 30px;
            text-align: center;
            color: var(--color);
            font-weight: bold;
        }
        #bai_hoc{
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body>
<?php
    function get_ten_bai($ma_bai_hoc){
      global $conn;
      $sql ="SELECT * FROM `bai_hoc` WHERE `ma_bai_hoc`='$ma_bai_hoc'";
      $result=mysqli_query($conn,$sql);
      if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['ten_bai_hoc'];
      }
      return 0;
    }
  
  ?>
    <?php 
        $id_loai_cau = $_GET['id_loai_cau_hoi'];
        $id_cau_hoi= $_GET['id_cau_hoi']; 
        // echo $id_cau_hoi;
        // echo $id_loai_cau;
        // in loại câu hỏi
        // $conn = mysqli_connect('localhost', 'root','', 'nckh_2024');
        $sql ="SELECT * FROM `loai_hien_thi` WHERE `id_loai_hien_thi`=$id_loai_cau";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) 
        {
            $row = mysqli_fetch_assoc($result);
            ?>
                <div id="bai_hoc">
                <h2>Bài học: <?php echo get_ten_bai($id_bai_hoc); ?></h2>
                </div>
            <?php
            echo "<div class='center-text'>LOẠI CÂU: " . $row['ten_loai_hien_thi'] . "</div>";
           
        }  
        // Danh sách hàm
        function get_loai_hien_thi($conn,$ten_bang){
            $a=[];
            $sql = "SELECT * FROM $ten_bang";
            $kq=mysqli_query($conn, $sql);
            while($row = mysqli_fetch_assoc($kq)) {
                $a[] = $row;
                
            }
            return $a;
        }
    
    ?>
    <form id="frmInputQues" action="" method="POST" enctype="multipart/form-data">
        <?php 
            echo "<input type='hidden' name='role' value='$role'>";
            echo "<input type='hidden' name='id_user' value='$id_user'>"
        ?>
        <!-- số lớn nhất-->
        <label for="">Số lớn nhất</label>
        <input required type="number" name="so_max" id="">
        <!-- số hàng -->
        <label for="">Số hàng :</label>
        <input required type="number" name="so_cot" id="">
        <!--số cột -->
        <label for="">Số cột:</label>
        <input required type="number" name="so_hang" id=""> 
         <!--Tổng số -->
         <label for="">Tổng số:</label>
        <input required type="number" name="tong" id=""> 
        <input type="submit" name="btn" value="Thêm câu hỏi">
    </form>
    <?php 
        if(isset($_POST['btn'])){
          
            $so_max = trim($_POST['so_max']);
            $so_cot = trim($_POST['so_cot']);
            $so_hang = trim($_POST['so_hang']);
            $tong = trim($_POST['tong']);
        
            $last_id = $id_cau_hoi;
            // echo "id_cau_hoi"."$last_id";
            // $sql2="INSERT INTO `dap_an_d6k1` (`id_dap_an_multichoice`, `ten_dap_an`, `flag`, `id_cau_hoi`) VALUES (NULL, '$so1', '1', '$last_id'),(NULL, '$bieu_thuc', '1', '$last_id'),(NULL, '$so2', '1', '$last_id'),(NULL, '=', '0', '$last_id'),(NULL, '$da', '1', '$last_id')";
            $sql2="INSERT INTO `dap_an_game_1`(`id_dap_an_game_1`, `so_lon_nhat`, `so_co`, `so_hang`, `tong`,`id_cau_hoi`) VALUES 
            (null,'$so_max','$so_cot','$so_hang','$tong','$last_id')";
            
          
            if(mysqli_query($conn, $sql2)){
                echo "Chèn thành công";
                header("Location: thong_bao.php?id_khoa_hoc=$id_khoa_hoc&id_cau_hoi=$id_cau_hoi");
            }
            
           
        }
    ?>
</body>
</html>