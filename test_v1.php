<?php
    session_start();
    include 'connectdb.php';
    if(!isset($_SESSION['id_user'])){
        header('Location: index.php');
        die();
    }
    
    $role=$_SESSION['quyen'];
    $id_user = $_SESSION['id_user'];
    $sl_bt= $_GET['sl_bt'];
    $sl_da= $_GET['sl_da'];
    $id_cau_hoi=$_GET['id_cau_hoi'];
    // $id_cau_hoi = $_GET['id_cau_hoi'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="src/css/test.css">
	<link rel="stylesheet" href="src/css/root.css">
    <link rel="stylesheet" href="src/css/button.css">
    <title>Nhập đầu bài dạng D6.K2</title>
</head>
<body>   
    <?php 
    // echo "";
    // $conn = mysqli_connect('localhost', 'root','', 'nckh_2024');      
   
    // $role = $_GET['role'];
    // $id_user = $_GET['id_user'];
    // echo $id_cau_hoi;
    // ech_bt;
    // echo "<a href='nhap_cau_hoi.php?role=$role&id_user=$id_user'><i class='fa-solid fa-backward'></i>Trở về</a>";
    ?>
    
    <form action="" method="POST" enctype="multipart/form-data">
        <h1>NHẬP ĐỀ BÀI</h1>
    
    <?php
       echo "<input type='hidden' name='sl_bt' value='$sl_bt'>";
       echo "<input type='hidden' name='sl_da' value='$sl_da'>";
       echo "<input type='hidden' name='id_cau_hoi' value='$id_cau_hoi'>";
       echo "<input type='hidden' name='role' value='$role'>";
       echo "<input type='hidden' name='id_user' value='$id_user'>";
        
        // in ô nhập biểu mẫu
        for ($i=0; $i <$sl_bt ; $i++) { 
            echo "Phép tính $i"."<input required  type='text' name='ch$i' id=''>"."Flag$i"."<input type='text' name='flag$i' id=''>"."<input type='file' name='anh$i'><br>";
            
        }
        for ($i=$sl_bt; $i <$sl_da+$sl_bt; $i++) { 
            echo "Đáp án $i"."<input required  type='text' name='ch$i' id=''>"." Flag$i"."<input type='text' name='flag$i' id=''>"."<input type='file' name='anh$i'><br>";
        }
        echo "<input type='submit' name='nhap' value='Nhập câu hỏi'>";
    ?>
    </form>
    <?php
         
        if(isset($_POST['nhap'])){
            // echo "0ke";
            // $conn = mysqli_connect('localhost', 'root','', 'nckh_2024');
            $id_cau_hoi=$_GET['id_cau_hoi'];
            // $n=$_GET['sl_bt'] + $_GET['sl_da'];
            $target_dir = "uploads/";
            $i=0;
            // Lặp qua từng tệp được tải lên
            foreach($_FILES as $file) {
                 $ch="ch$i";
                 $f="flag$i";
                //  echo $i;
                
                 $da=$_POST[$ch];
                 $flag=$_POST[$f];
                // Lấy thông tin về tên tệp
                $target_file = $target_dir . basename($file["name"]);
                $url=basename($file["name"]);
                // echo $da. $target_file;
                if($i<$_GET['sl_bt']){
                    $sql="INSERT INTO `dap_an_d6k2` (`id_dap_d6k2`, `ten_dap_an`, `cot`, `flag`, `url_anh`, `id_cau_hoi`) VALUES (NULL, '$da', '0', '$flag', '$url', '$id_cau_hoi')";
                
                }else{
                    $sql="INSERT INTO `dap_an_d6k2` (`id_dap_d6k2`, `ten_dap_an`, `cot`, `flag`, `url_anh`, `id_cau_hoi`) VALUES (NULL, '$da', '1', '$flag', '$url', '$id_cau_hoi')";
                
                }
                // echo "Vào vòng 1";
                if(mysqli_query($conn, $sql)){
                    echo "Chèn thành công";
                }
                // Di chuyển tệp tải lên vào thư mục lưu trữ
                if (move_uploaded_file($file["tmp_name"], $target_file)) {
                    echo "Tệp " . htmlspecialchars(basename($file["name"])) . " đã được tải lên thành công.";
                } else {
                    // echo "Đã xảy ra lỗi khi tải lên tệp.";
                }
                $i++;
               
            }
            header("Location: nhap_cau_hoi.php");

           
                                

        }
    ?> 
</body>
</html>