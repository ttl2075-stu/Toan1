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
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="src/css/nhap_de_thi.css?v=1">
	<link rel="stylesheet" href="src/css/root.css">
    <link rel="stylesheet" href="src/css/button.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="./assets/css_v2/upload_phan_thuong.css">
</head>
<body>
<a href="chinh_phan_thuong.php?id_khoa_hoc=<?php echo $id_khoa_hoc?>" class="btn_tro_ve">Trở về</a>

        <!-- <select name="user" id=""> -->
       
    <form action="" method="POST" enctype="multipart/form-data">
        <!-- số thứ nhất -->
        <label for="">Ảnh phần thưởng</label><br>
        <input   type='file' name='dt1' ><br>
        
        
        <input type="submit" name="btn" value="Thêm phần thưởng" class="btn_them_phan_thuong">
    </form>
    <?php
        if(isset($_POST['btn'])){
           
            if(isset($_FILES['dt1'])){
                if ($_FILES['dt1']['error'] > 0)
                {
                    // echo 'File Upload Bị Lỗi';
                    echo "<script>
                alert('File Upload Bị Lỗi!');
            </script>";
                }
                else{
                    // Upload file
                    move_uploaded_file($_FILES['dt1']['tmp_name'], './anh/phan_thuong/'.$_FILES['dt1']['name']);
                    // echo 'File Uploaded';
                    $ten_file=$_FILES['dt1']['name'];
                    $sql ="INSERT INTO `anh_phan_thuong`(`id_anh_phan_thuong`, `ten_anh_phan_thuong`) VALUES (null,'$ten_file')";
                    mysqli_query($conn, $sql);
                    echo "<script>
                alert('Upload thành công!');
            </script>";
                }
            }
            else{
                // echo 'Bạn chưa chọn file upload';
                echo "<script>
                alert('Bạn chưa chọn file upload!');
            </script>";
            }
            
            // $target_dir = "uploads/";
            // $i=0;
            // // Lặp qua từng tệp được tải lên
                
            //     $target_file = $target_dir . basename($file["name"]);
            //     $ten_file=basename($file["name"]);

                
            //     // Di chuyển tệp tải lên vào thư mục lưu trữ
            //     if (move_uploaded_file($file["tmp_name"], $target_file)) {
            //         echo "Tệp " . htmlspecialchars(basename($file["name"])) . " đã được tải lên thành công.";
            //     } else {
            //         echo "Đã xảy ra lỗi khi tải lên tệp.";
            //     }
            //     $i++;
            
            }
    
        
    ?>
</body>
</html>
