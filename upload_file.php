<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="" method="post" enctype="multipart/form-data">
        <?php
            echo "<input type='file' name='nam1' >
            <input type='file' name='nam2' >";
        ?>
        
        <input type="submit" name="file" value="Upload file">
    </form>
</body>
</html>

<?php
// Kiểm tra nếu form đã được gửi đi
if(isset($_POST['file'])) {
    // Đường dẫn lưu trữ tệp
    $target_dir = "uploads/";

    // Lặp qua từng tệp được tải lên
    foreach($_FILES as $file) {
        // Lấy thông tin về tên tệp
        $target_file = $target_dir . basename($file["name"]);
        
        // Kiểm tra xem tệp đã tồn tại chưa
        if (file_exists($target_file)) {
            echo "Tệp đã tồn tại.";
        } else {
            // Di chuyển tệp tải lên vào thư mục lưu trữ
            if (move_uploaded_file($file["tmp_name"], $target_file)) {
                echo "Tệp " . htmlspecialchars(basename($file["name"])) . " đã được tải lên thành công.";
            } else {
                echo "Đã xảy ra lỗi khi tải lên tệp.";
            }
        }
    }
}
?>

