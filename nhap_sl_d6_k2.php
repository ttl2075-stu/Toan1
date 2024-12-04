<?php
    session_start();
    include 'connectdb.php';
    if(!isset($_SESSION['id_user'])){
        header('Location: index.php');
        die();
    }
    
    $role=$_SESSION['quyen'];
    $id_user = $_SESSION['id_user'];
    $id_cau_hoi=$_GET['id_cau_hoi']; 
    $id_loai_cau = $_GET['id_loai_cau_hoi'];
    $id_khoa_hoc = $_GET['id_khoa_hoc'];
    // $id_cau_hoi = $_GET['id_cau_hoi'];
    $id_bai_hoc=$_GET['id_bai_hoc'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nhập số lượng biểu thức và đáp án</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="src/css/nhap_cau_hoi.css">
    <link rel="stylesheet" href="src/css/root.css">
    <link rel="stylesheet" href="src/css/button.css">
    <link rel="stylesheet" href="assets/css_v2/nhap_cau_hoi.css">
    <style>
    .centered-text {
        font-size: 30px;
        text-align: center;
        color: var(--color);
        font-weight: bold;
    }
    </style>
</head>

<body>
    <?php 
        // $conn = mysqli_connect('localhost', 'root','', 'nckh_2024');
       
        // $role= $_GET['role'];
        // $id_user=$_GET['id_user'];
    //    echo $id_cau_hoi;
    //    echo $id_loai_cau;
       // in loại câu hỏi
      
       $sql ="SELECT * FROM `loai_hien_thi` WHERE `id_loai_hien_thi`=$id_loai_cau";
       $result = mysqli_query($conn, $sql);
       if (mysqli_num_rows($result) > 0) 
       {
            $row = mysqli_fetch_assoc($result);?>
    <div id="bai_hoc">
        <h2>Bài học: <?php echo get_ten_bai($id_bai_hoc); ?></h2>
    </div><?php
            echo "<div class='centered-text'>LOẠI CÂU: ".$row['ten_loai_hien_thi']."</div>";
          
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
    <form action="" method="get">
        <?php echo "<input type='hidden' name='id_cau_hoi' value='$id_cau_hoi'>" ?>
        <?php echo "<input type='hidden' name='id_loai_cau_hoi' value='$id_loai_cau'>" ?>
        <?php echo "<input type='hidden' name='role' value='$role'>" ?>
        <?php echo "<input type='hidden' name='id_user' value='$id_user'>" ?>
        <?php echo "<input type='hidden' name='id_bai_hoc' value='$id_bai_hoc'>" ?>
        <?php echo "<input type='hidden' name='id_khoa_hoc' value='$id_khoa_hoc'>" ?>
        <label for="">Nhập số lượng biểu thức</label>
        <input required type="text" name="sl_bt" id="">
        <label for="">Nhập số lượng đáp án</label>
        <input required type="text" name="sl_da" id="">
        <input class="btn-submit" type="submit" name="btn" value="Xác nhận">
    </form>

    <?php 
    if(isset($_GET['btn'])){
        $sl_bt=$_GET['sl_bt'];
        $sl_da=$_GET['sl_da'];
        // echo "vào";
        // header("Location: nhap_cau_hoi_d6k2.php?id_cau_hoi=$id_cau_hoi&id_loai_cau_hoi=$id_loai_cau&sl_capa=$sl_capa");
        header("Location: test.php?id_khoa_hoc=$id_khoa_hoc&id_bai_hoc=$id_bai_hoc&id_cau_hoi=$id_cau_hoi&id_loai_cau_hoi=$id_loai_cau&sl_bt=$sl_bt&sl_da=$sl_da");

    }
   
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
</body>

</html>