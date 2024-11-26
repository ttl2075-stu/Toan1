<?php

    session_start();
    include 'connectdb.php';
    if(!isset($_SESSION['id_user'])){
        header('Location: index.php');
        die();
    }
    
    $role=$_SESSION['quyen'];
    $id_user = $_SESSION['id_user'];
    $id_loai_cau = $_GET['id_loai_cau_hoi'];
    $id_cau_hoi= $_GET['id_cau_hoi']; 
    // $id_cau_hoi = $_GET['id_cau_hoi'];
    $id_bai_hoc = $_GET['id_bai_hoc'];
    $id_khoa_hoc =$_GET['id_khoa_hoc'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="src/css/nhap_cau_hoi.css?v=1">
	<link rel="stylesheet" href="src/css/root.css">
    <link rel="stylesheet" href="src/css/button.css">
    <title>Nhập câu câu hỏi D7.K1</title>
    <style>
        .center-text{
            font-size: 30px;
            text-align: center;
            color: var(--color);
            font-weight: bold;
        }
    </style>
</head>
<body>
<?php
        // role=2&id_user=2&id_cau_hoi=35
        // $role = $_GET['role'];
        // $id_user = $_GET['id_user'];
        // echo "<a href='nhap_cau_hoi.php?role=$role&id_user=$id_user'><i class='fa-solid fa-backward'></i>Trở về</a>";
        ?>
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
        // echo $id_cau_hoi;
        // echo $id_loai_cau;
        // in loại câu hỏi
        // $conn = mysqli_connect('localhost', 'root','', 'nckh_2024');
        ?>
            <div id="bai_hoc">
            <h2>Bài học: <?php echo get_ten_bai($id_bai_hoc); ?></h2>
            </div>
        <?php
        $sql ="SELECT * FROM `loai_hien_thi` WHERE `id_loai_hien_thi`=$id_loai_cau";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) 
        {
            $row = mysqli_fetch_assoc($result);
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
    <form action="" method="POST" enctype="multipart/form-data">
        <?php 
            echo "<input type='hidden' name='role' value='$role'>";
            echo "<input type='hidden' name='id_user' value='$id_user'>";
            echo "<input type='hidden' name='id_khoa_hoc' value='$id_khoa_hoc'>"
        ?>
        <!-- số thứ nhất -->
        <label for="">Số thứ nhất:</label>
        <input required type="number" name="so_thu_nhat" id="">
        <!-- số thứ hai -->
        <label for="">Số thứ hai:</label>
        <input required type="number" name="so_thu_hai" id="">
        <!-- biểu thức -->
        <label for="">Biểu thức:</label>
        <!--<input required type="text" name="bieu_thuc" id="">-->
         <select name="expression" id="bieu_thuc">
          <option value="addition">Phép cộng</option>
          <option value="subtraction">Phép trừ</option>
        </select>
        
        <!-- dấu -->
        <!-- <label for="">Dấu:</label>
        <input type="text" name="dau" id=""> -->
        <!-- ảnh upload -->
        <!-- <input type="file" name="anh" id=""> -->
        <!-- đáp án -->
        <!--<label for="">Đáp án</label>-->
        <!--<input required type="text" name="da" id="">-->
        
        <!-- <div>
            <select name="loai_ht" id="">
                
            
            <label for="">Slect cọn loại</label>
            <?php
            
            //  $conn = mysqli_connect('localhost', 'root','', 'nckh_2024');
            //  $sql ="SELECT * FROM `loai_hien_thi`";
            //  $result = mysqli_query($conn, $sql);
            //  if (mysqli_num_rows($result) > 0) 
            //  {
            //      while($row = mysqli_fetch_assoc($result)) {
            //         //  print_r($row);
            //          echo "<option value='".$row['id_loai_hien_thi']."'>".$row['ten_loai_hien_thi'] ."</option>";
                    
            //      }
            //      echo "</select>";
            //  }  
              
               
            ?>
           
        </div> -->
         
        <input type="submit" name="btn" value="Thêm câu hỏi">
    </form>
    <?php
        
        if(isset($_POST['btn'])){
            // $cau_hoi = $_POST['cau_hoi'];
            $so1 = $_POST['so_thu_nhat'];
            $so2 = $_POST['so_thu_hai'];
            $bieu_thuc = $_POST['bieu_thuc'];
            $expression = $_POST['expression'];
            $id_khoa_hoc = $_POST['id_khoa_hoc'];
            // Tính toán theo biểu thức
            $da = 0;
            switch ($expression) {
              case "addition":
                $da = $so1 + $so2;
                $bieu_thuc = "+";
                break;
              case "subtraction":
              default:
                $da = $so1 - $so2;
                $bieu_thuc = "-";
            }

            
            
            // Kiểm tra kết nối
            if (!$conn) {
                die("Kết nối thất bại: " . mysqli_connect_error());
            }
            if (mysqli_query($conn, $sql)) {
                // echo "Thêm record thành công";
                $last_id = $id_cau_hoi;
               
                // $sql2="INSERT INTO `dap_an_d6k1` (`id_dap_an_multichoice`, `ten_dap_an`, `flag`, `id_cau_hoi`) VALUES (NULL, '$so1', '1', '$last_id'),(NULL, '$bieu_thuc', '1', '$last_id'),(NULL, '$so2', '1', '$last_id'),(NULL, '=', '0', '$last_id'),(NULL, '$da', '1', '$last_id')";
                $sql2="INSERT INTO `dap_an_d7k1`(`id_dap_an_d7k1`, `ten_dap_an`, `stt`, `trang_thai`, `id_cau_hoi`) 
                VALUES (null,'$so1',1,1,'$last_id'),(null,'$bieu_thuc',2,1,'$last_id'),(null,'$so2',3,1,'$last_id'),(null,'=',4,1,'$last_id'),(null,'$da',5,0,'$last_id')";
                if(mysqli_query($conn, $sql2)){
                    // echo "Chèn thành công";
                   
                    // header("Location: nhap_cau_hoi.php");
                    header("Location: thong_bao.php?id_khoa_hoc=$id_khoa_hoc&id_cau_hoi=$id_cau_hoi");
                }
            } else {
                echo "Lỗi: " . $sql . "<br>" . mysqli_error($conn);
            }
            
           
        }
    ?>
   
</body>
</html>