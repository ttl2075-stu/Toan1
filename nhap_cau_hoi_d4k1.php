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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="src/css/test.css">
    <link rel="stylesheet" href="src/css/root.css">
    <link rel="stylesheet" href="src/css/button.css">
    <link rel="stylesheet" href="assets/css_v2/nhap_cau_hoi.css">
    <title>Nhập câu hỏi D6.K3</title>
    <style>
    .centered-text {
        font-size: 30px;
        text-align: center;
        color: var(--color);
        margin-bottom: 10px;
        font-weight: bold;
    }

    #bai_hoc {
        width: 100%;
        font-weight: bold;
        color: black;
        background-color: bisque;
        padding: 10px;
        border-radius: 5px;
        text-align: center;
        box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);
        margin-bottom: 15px;
    }

    form label,
    form input[type="number"],
    form input[type="submit"],
    form input[type="file"] {
        display: block;
        margin-bottom: 10px;
    }

    form input[type="number"],
    form input[type="password"],
    form input[type="file"],
    form select {
        width: 100%;
        padding: 10px;
        border: 2px solid var(--color);
        border-radius: 8px;
        margin-top: 5px;
        margin-bottom: 10px;
    }

    form input[type="number"]:hover,
    form input[type="password"]:hover,
    form input[type="file"]:hover,
    form select:hover {
        border: 3px solid var(--color);
        cursor: pointer;
    }

    form input[type="number"]:focus,
    form input[type="password"]:focus,
    form input[type="file"]:focus,
    form select:focus {
        border: 3px solid var(--boder);
        outline: none;
    }

    p {
        color: red;
        font-style: italic;
        margin-bottom: 10px;
    }

    .check {
        border: 2px solid #0071f9;
        height: 50px;
        width: 50px;
        /* border: 2px solid #ccc; */
        border-radius: 8px;
        margin-left: 20px;
        position: relative;
        transition: all 0.2s ease-in-out;
    }

    .check:focus {
        border: 3px solid var(--boder);
        outline: none;
        cursor: pointer;
    }

    .check:checked {
        background-color: #007bff;
        border-color: green;
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
    <div id="bai_hoc">
        <h2>Bài học: <?php echo get_ten_bai($id_bai_hoc); ?></h2>
    </div>
    <?php
        $sql ="SELECT * FROM `loai_hien_thi` WHERE `id_loai_hien_thi`=$id_loai_cau";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) 
        {
            $row = mysqli_fetch_assoc($result);
            echo "<div class='centered-text'>Loại câu: ".$row['ten_loai_hien_thi']."</div>";               
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
        <label for="so_thu_nhat" style="margin-right: 10px;">Số thứ nhất</label>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
            <input required type="number" name="so_thu_nhat" id="so_thu_nhat" style="margin-right: 5px;">
            <input type="checkbox" name="check_so_thu_nhat" class="check">
        </div>

        <!-- Biểu thức so sánh -->
        <label for="bieu_thuc" style="margin-right: 10px;">Biểu thức so sánh</label>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
            <select name="expression" id="bieu_thuc" style="margin-right: 5px;">
                <option value="Bigger">Lớn hơn</option>
                <option value="Biggerorequal">Lớn hơn hoặc bằng</option>
                <option value="Less">Nhỏ hơn</option>
                <option value="Lessorequal">Nhỏ hơn hoặc bằng</option>
                <option value="Equal">Bằng nhau</option>
            </select>
            <input type="checkbox" name="check_expression" class="check">
        </div>

        <!-- số thứ hai -->
        <label for="so_thu_hai" style="margin-right: 10px;">Số thứ hai</label>
        <div style="display: flex; align-items: center; margin-bottom: 10px;">
            <input required type="number" name="so_thu_hai" id="so_thu_hai" style="margin-right: 5px;">
            <input type="checkbox" name="check_so_thu_hai" class="check">
        </div>
        <?php $duong_dan = 'anh/convat/';
            $url_anh = get_duong_dan_ngau_nhien($duong_dan);
            echo "<input type='hidden' name='anh0' value='$url_anh'>"; ?>
        <img width='50px' src='<?php echo $url_anh; ?>'>
        <label for="dt1">Ảnh đối tượng thứ 1</label><br>
        <input type='file' name='dt1' id='dt1'><br>
        <?php $duong_dan = 'anh/convat/';
            $url_anh = get_duong_dan_ngau_nhien($duong_dan);
            echo "<input type='hidden' name='anh1' value='$url_anh'>"; ?>
        <img width='50px' src='<?php echo $url_anh; ?>'>
        <label for="dt2">Ảnh đối tượng thứ 2</label><br>
        <input type='file' name='dt2' id='dt2'><br><br><br>

        <?php echo "<input type='hidden' name='role' value='$role'>" ?>
        <?php echo "<input type='hidden' name='id_user' value='$id_user'>" ?>
        <?php echo "<input type='hidden' name='id_khoa_hoc' value='$id_khoa_hoc'>" ?>
        <p>*Note: Nhấn vào ô nếu muốn hiện phần tử cùng hàng</p>
        <input class="btn-submit" type="submit" name="btn" value="Thêm câu hỏi">
    </form>

    <?php
        if(isset($_POST['btn'])){
            $so1 = trim($_POST['so_thu_nhat']);
            $so2 = trim($_POST['so_thu_hai']);
            $expression = $_POST['expression'];
            $id_khoa_hoc = $_POST['id_khoa_hoc'];
            
            $bieu_thuc = '';
            switch ($expression) {
                case "Bigger":
                    $bieu_thuc = ">";
                    break;
                case "Biggerorequal":
                    $bieu_thuc = ">=";
                    break;
                case "Less":
                    $bieu_thuc = "<";
                    break;
                case "Lessorequal":
                    $bieu_thuc = "<=";
                    break;
                case "Equal":
                default:
                    $bieu_thuc = "=";
            }
            $id_user = $_POST['id_user'];
            $role = $_POST['role'];
             // Đường dẫn lưu trữ tệp
            $target_dir = "uploads/";
            $i=0;
            // Lặp qua từng tệp được tải lên
            foreach($_FILES as $file) {
                // Lấy thông tin về tên tệp
                if($file['name']==""){
                    $anh="anh$i";
                    $duong_dan = $_POST[$anh];
                    $ten_file=basename($duong_dan);
                    $target_dir = "uploads/";
                    $target_file = $target_dir . $ten_file;
                    if($i==0){
                        $sql="UPDATE `cau_hoi` SET  `url_doi_tuong`='$ten_file' WHERE `id_cau_hoi`=$id_cau_hoi";
                                        
                    }elseif($i==1){
                        $sql="UPDATE `cau_hoi` SET `url_dung_do`='$ten_file' WHERE `id_cau_hoi`=$id_cau_hoi";
                    }
                    mysqli_query($conn, $sql);
                    // echo $duong_dan;
                    // echo $target_file;
                    if (copy($duong_dan, $target_file)) {
                        echo "Tệp đã được tải lên thành công!";
                    } else {
                        echo "Đã xảy ra lỗi khi tải lên tệp";
                    }
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
                // print_r($file);
               
            
            }
        
            $number1 = 0;
            $number2 = 0;
            $bieuthuc = 0;
            if(isset($_POST['check_so_thu_nhat'])){
                $number1 = 1;
            }
            if(isset($_POST['check_so_thu_hai'])){
                $number2 = 1;
            }
            if(isset($_POST['check_expression'])){
                $bieuthuc = 1;
            }
            $last_id = $id_cau_hoi;
            $sql="INSERT INTO `dap_an_d6k3`(`id_dap_an_d6k3`, `ten_dap_an`, `trang_thai`, `stt`, `id_cau_hoi`) VALUES (null,'$so1','$number1','1','$last_id'), (null,'$bieu_thuc','$bieuthuc','2','$last_id'), (null,'$so2','$number2','3','$last_id')";
            // echo "<script>
            //     alert('Thêm câu hỏi thành công');
            // </script>";

            if(mysqli_query($conn, $sql)){
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