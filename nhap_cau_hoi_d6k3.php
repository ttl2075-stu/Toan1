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
    $id_bai_hoc = $_GET['id_bai_hoc'];
    $id_khoa_hoc = $_GET['id_khoa_hoc'];
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
    <title>Nhập câu hỏi D6.K3</title>
    <style>
        .centered-text {
            font-size: 30px;
            text-align: center;
            color: var(--color);
            margin-bottom: 10px;
            font-weight: bold;
        }
        #bieu_thuc{
            width: 100%;
            padding: 10px;
            border: 1px solid var(--primary);
            border-radius: 8px;
            margin-top: 5px;
            margin-bottom: 10px;
            outline: 2px solid var(--primary);
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
        //  $role=$_GET['role'];
        //  $id_user = $_GET['id_user'];
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
    <form action="" method="POST" enctype="multipart/form-data">
        <!-- số thứ nhất -->
        <label for="">Số thứ nhất:</label>
        <input required  type="text" name="so_thu_nhat" id=""><br>
         <!-- biểu thức -->
        <!-- <label for="">Biểu thức:</label>
        <input required  type="text" name="bieu_thuc" id=""><br> -->
        <select name="expression" id="bieu_thuc">
          <option value="addition">Phép cộng</option>
          <option value="subtraction">Phép trừ</option>
        </select>
        <!-- số thứ hai -->
        <label for="">Số thứ hai:</label>
        <input required  type="text" name="so_thu_hai" id=""><br>
       
        <?php $duong_dan = 'anh/convat/';
            $url_anh = get_duong_dan_ngau_nhien($duong_dan);
            echo "<input type='hidden' name='anh0' value='$url_anh'>"; ?>
        <img width='50px' src='<?php echo $url_anh; ?>'>
        <label for="">Ảnh đối tượng</label><br>
        <input   type='file' name='dt1' ><br>

        <?php $duong_dan = 'anh/convat/';
            $url_anh = get_duong_dan_ngau_nhien($duong_dan);
            echo "<input type='hidden' name='anh1' value='$url_anh'>"; ?>
        <img width='50px' src='<?php echo $url_anh; ?>'>
        <label for="">Ảnh đối tượng thứ 2(nếu là phép cộng)</label><br>
        <input   type='file' name='dt2' ><br><br><br>
        <?php echo "<input type='hidden' name='role' value='$role'>" ?>
        <?php echo "<input type='hidden' name='id_user' value='$id_user'>" ?>
        <?php echo "<input type='hidden' name='id_khoa_hoc' value='$id_khoa_hoc'>" ?>
        <input type="submit" name="btn" value="Thêm câu hỏi">
    </form>
    <?php
        
        if(isset($_POST['btn'])){
            $so1 = trim($_POST['so_thu_nhat']);
            $so2 = trim($_POST['so_thu_hai']);
            $expression = $_POST['expression'];
            $id_khoa_hoc = $_POST['id_khoa_hoc'];
            // $cau_hoi = $_POST['cau_hoi'];
            // $so1 = $_POST['so_thu_nhat'];
            // $so2 = $_POST['so_thu_hai'];
            // $bieu_thuc = $_POST['bieu_thuc'];
            // $da = $_POST['da'];
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
            $id_user = $_POST['id_user'];
            $role = $_POST['role'];
             // Đường dẫn lưu trữ tệp
            $target_dir = "uploads/";
            $i=0;
            // Lặp qua từng tệp được tải lên
            foreach($_FILES as $file) {
                // Lấy thông tin về tên tệp
                print_r($file);

                if($file['name']==""){
                    $anh= "anh".$i;
                    $duong_dan = $_POST[$anh];
                    $ten_file=basename($duong_dan);
                    $target_dir = "uploads/";
                    $target_file = $target_dir . $ten_file;
                    // $sql="UPDATE `cau_hoi` SET  `url_doi_tuong`='$ten_file' WHERE `id_cau_hoi`=$id_cau_hoi";
                    if($i==0){
                        $sql="UPDATE `cau_hoi` SET  `url_doi_tuong`='$ten_file' WHERE `id_cau_hoi`=$id_cau_hoi";
                                        
                    }elseif($i==1){
                        $sql="UPDATE `cau_hoi` SET `url_dung_do`='$ten_file' WHERE `id_cau_hoi`=$id_cau_hoi";
                    }
                    mysqli_query($conn, $sql);
                    echo $duong_dan;
                    echo $target_file;
                    if (copy($duong_dan, $target_file)) {
                        echo "Tệp đã được tải lên thành công!";
                    } else {
                        echo "Đã xảy ra lỗi khi tải lên tệp";
                    }
                    // if (move_uploaded_file($fil["tmp_name"], $target_file)) {
                    //     echo "Tệp đã được tải lên thành công.";
                    // } else {
                    //     echo "Đã xảy ra lỗi khi tải lên tệp.";
                    // }
                }else{
                    $target_file = $target_dir . basename($file["name"]);
                    $ten_file=basename($file["name"]);

                    if($i==0){
                        $sql="UPDATE `cau_hoi` SET  `url_doi_tuong`='$ten_file' WHERE `id_cau_hoi`=$id_cau_hoi";
                                        
                    }elseif($i==1){
                        $sql="UPDATE `cau_hoi` SET `url_dung_do`='$ten_file' WHERE `id_cau_hoi`=$id_cau_hoi";
                    }
                    mysqli_query($conn, $sql);
                    // Di chuyển tệp tải lên vào thư mục lưu trữ
                    if (move_uploaded_file($file["tmp_name"], $target_file)) {
                        echo "Tệp " . htmlspecialchars(basename($file["name"])) . " đã được tải lên thành công.";
                    } else {
                        echo "Đã xảy ra lỗi khi tải lên tệp.";
                    }
                }
                
                $i++;
            
            }
            // chèn đáp án vào csld
        
            // id câu hỏi vừa chèn
            $last_id = $id_cau_hoi;
            $sql="INSERT INTO `dap_an_d6k3`(`id_dap_an_d6k3`, `ten_dap_an`, `trang_thai`, `stt`, `id_cau_hoi`) VALUES (null,'$so1','0','1','$last_id'), (null,'$bieu_thuc','0','2','$last_id'), (null,'$so2','0','3','$last_id'),(null,'=','1','4','$last_id'),(null,'$da','0','5','$last_id')";
            // $sql="INSERT INTO `dap_an_d6k1` (`id_dap_an_multichoice`, `ten_dap_an`, `flag`, `id_cau_hoi`) VALUES (NULL, '$so1', '1', '$last_id'),(NULL, '$bieu_thuc', '1', '$last_id'),(NULL, '$so2', '1', '$last_id'),(NULL, '=', '0', '$last_id'),(NULL, '$da', '1', '$last_id')";
            echo "<script>
                alert('Thêm câu hỏi thành công');
            </script>";
            if(mysqli_query($conn, $sql)){
                // echo "Chèn thành công";
                
                // header("Location: nhap_cau_hoi.php");
                header("Location: thong_bao.php?id_khoa_hoc=$id_khoa_hoc&id_cau_hoi=$id_cau_hoi");
            }
            
           
        }
        function get_duong_dan_ngau_nhien($duong_dan){
            

            // Liệt kê tất cả các tệp trong thư mục
            $files = scandir($duong_dan);

            // Lọc ra các tệp ảnh từ danh sách các tệp
            $imageFiles = array_filter($files, function($file) {
                $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
                $fileExtension = pathinfo($file, PATHINFO_EXTENSION);
                return in_array(strtolower($fileExtension), $allowedExtensions);
            });

            // Chọn một tệp ảnh ngẫu nhiên từ danh sách các tệp ảnh
            $randomImage = $duong_dan . $imageFiles[array_rand($imageFiles)];

            // Hiển thị tệp ảnh ngẫu nhiên
            // echo '<img src="' . $randomImage . '" alt="Random Image">';
            return $randomImage;
        }
    ?>
   
</body>
</html>