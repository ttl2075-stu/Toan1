<style>
.block-bt {
    margin: 20px 0;
    padding: 10px;
    /* background: black; */
    border-color: blue;
    border-width: 1px;
    box-shadow: rgba(3, 102, 214, 0.3) 0px 0px 0px 3px;
}

.block-da {
    margin: 20px 0;
    padding: 10px;
    /* background: pink; */
    border-color: orange;
    border-width: 1px;
    box-shadow: orange 0px 0px 0px 3px;
}
</style>
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
    $id_bai_hoc=$_GET['id_bai_hoc'];
    $id_khoa_hoc = $_GET['id_khoa_hoc'];
    // echo $id_bai_hoc;
    // $id_cau_hoi = $_GET['id_cau_hoi'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="src/css/test.css">
    <link rel="stylesheet" href="src/css/root.css">
    <link rel="stylesheet" href="src/css/button.css">
    <link rel="stylesheet" href="assets/css_v2/nhap_cau_hoi.css">
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

    <div id="bai_hoc">
        <h2>Bài học: <?php echo get_ten_bai($id_bai_hoc); ?></h2>
    </div>
    <form action="" method="POST" enctype="multipart/form-data">
        <h1>NHẬP ĐỀ BÀI</h1>

        <?php
       echo "<input type='hidden' name='sl_bt' value='$sl_bt'>";
       echo "<input type='hidden' name='sl_da' value='$sl_da'>";
       echo "<input type='hidden' name='id_cau_hoi' value='$id_cau_hoi'>";
       echo "<input type='hidden' name='role' value='$role'>";
       echo "<input type='hidden' name='id_user' value='$id_user'>";
       echo "<input type='hidden' name='id_khoa_hoc' value='$id_khoa_hoc'>"; ?>
        <div class="block-bt">
            <?php
        // in ô nhập biểu mẫu
        $stt=1;
        for ($i=0; $i <$sl_bt ; $i++) { 
            $duong_dan = 'anh/convat/';
            $url_anh = get_duong_dan_ngau_nhien($duong_dan);
            echo "<input type='hidden' name='anh$i' value='$url_anh'>";
            echo "Phép tính $stt"."<input required  type='text' name='ch$i' id=''>"."Nối với đáp án"."<input type='text' name='flag$i' id=''>"."<img width='50px' src='$url_anh'>"."<input type='file' name='file_anh$i'><br>";
            $stt++;
        }
        ?>
        </div>
        <div class="block-da">
            <?php
        $stt=1;
        for ($i=$sl_bt; $i <$sl_da+$sl_bt; $i++) { 
            $duong_dan = 'anh/canhdieu/';
            $url_anh = get_duong_dan_ngau_nhien($duong_dan);
            echo "<input type='hidden' name='anh$i' value='$url_anh'>";
            echo "Đáp án $stt"."<input required  type='text' name='ch$i' id=''>"." Nối với đáp án"."<input type='text' name='flag$i' id=''>"."<img width='50px' src='$url_anh'>"."<input type='file' name='file_anh$i'><br>";
            $stt++;
        }
        echo "</div><input class='btn-submit' type='submit' name='nhap' value='Nhập câu hỏi'>";
    ?>

    </form>
    <?php
         
        if(isset($_POST['nhap'])){
            // echo "0ke";
            // $conn = mysqli_connect('localhost', 'root','', 'nckh_2024');
            $id_cau_hoi=$_GET['id_cau_hoi'];
            // $n=$_GET['sl_bt'] + $_GET['sl_da'];
            $id_khoa_hoc =$_POST['id_khoa_hoc'];
            $i=0;
            // Lặp qua từng tệp được tải lên
            foreach($_FILES as $file) {
                $ch="ch$i";
                $f="flag$i";
                $da=$_POST[$ch];
                $flag=$_POST[$f];
                $anh="anh$i";
                if($file['error']>0){
                    $url=get_ten_file($_POST[$anh]);
                }else{
                    $url=basename($file["name"]);
                }
            
                // Lấy thông tin về tên tệp
                
                
                // echo $da. $target_file;
                if($i<$_GET['sl_bt']){
                    $target_dir = "anh/convat/";
                    $target_file = $target_dir . basename($file["name"]);
                    $sql="INSERT INTO `dap_an_d6k2` (`id_dap_d6k2`, `ten_dap_an`, `cot`, `flag`, `url_anh`, `id_cau_hoi`) VALUES (NULL, '$da', '0', '$flag', '$url', '$id_cau_hoi')";
                
                }else{
                    $target_dir = "anh/canhdieu/";
                    $target_file = $target_dir . basename($file["name"]);
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
            // header("Location: nhap_cau_hoi.php");
            header("Location: thong_bao.php?id_khoa_hoc=$id_khoa_hoc&id_cau_hoi=$id_cau_hoi");

           
                                

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
        function get_ten_file($filePath){
            // Lấy phần mở rộng của tên tệp
            $fileExtension = pathinfo($filePath, PATHINFO_EXTENSION);

            // Lấy phần tên tệp không kèm phần mở rộng
            $fileNameWithoutExtension = pathinfo($filePath, PATHINFO_FILENAME);

            // Hiển thị phần tên tệp kèm phần mở rộng
            $fileNameWithExtension = $fileNameWithoutExtension . '.' . $fileExtension;

            // Hiển thị phần tên tệp kèm phần mở rộng
            return $fileNameWithExtension; // Kết quả sẽ là: anh.png
        }
       
    ?>
</body>

</html>