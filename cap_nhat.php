<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload CSV to Database</title>
</head>
<body>
    <h2>Upload CSV File</h2>
    <form action="" method="post" enctype="multipart/form-data">
        Chọn tệp CSV để tải lên:
        <input type="file" name="csvFile" id="csvFile" accept=".csv">
        <input type="submit" value="Upload and Import" name="submit">
    </form>
</body>
</html>

<?php
if (isset($_POST['submit'])) {
    // Thư mục lưu trữ tệp tải lên
    $targetDirectory = "uploads/";
    $uploadOk = 1;
    $csvFilePath = $targetDirectory . basename($_FILES["csvFile"]["name"]);

    // Kiểm tra nếu thư mục uploads tồn tại
    if (!is_dir($targetDirectory)) {
        echo "Thư mục lưu trữ không tồn tại.";
        $uploadOk = 0;
    }

    // Kiểm tra nếu tệp là CSV
    $fileType = strtolower(pathinfo($csvFilePath, PATHINFO_EXTENSION));
    if ($fileType != "csv") {
        echo "Chỉ cho phép tệp CSV.";
        $uploadOk = 0;
    }

    if ($uploadOk == 1) {
        // Di chuyển tệp tải lên vào thư mục uploads
        if (move_uploaded_file($_FILES["csvFile"]["tmp_name"], $csvFilePath)) {
            echo "Tệp ". htmlspecialchars(basename($_FILES["csvFile"]["name"])). " đã được tải lên thành công.<br>";

            // trên local
            // $servername = "localhost";
            // $username = "root";
            // $password = ""; // Mật khẩu cho MySQL, nếu có
            // $dbname = "toan1_v13"; // Thay bằng tên CSDL của bạn
            
            // trên hosst
 
            $servername = 'localhost';
            $username = 'bikvyzpx_nckh_2024';
            $password = 'F^)U6M#CW{o3';
            $dbname = 'bikvyzpx_nckh_2024'; //tên database
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Kiểm tra kết nối
            if ($conn->connect_error) {
                die("Kết nối thất bại: " . $conn->connect_error);
            }

            // Đặt mã hóa ký tự của kết nối
            $conn->set_charset("utf8mb4");

            // Xử lý tệp CSV
            if (($handle = fopen($csvFilePath, 'r')) !== FALSE) {
                // Bỏ qua dòng đầu tiên nếu là tiêu đề
                fgetcsv($handle);

                // Đọc từng dòng trong tệp CSV
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    // Đảm bảo dữ liệu được mã hóa đúng UTF-8
                    foreach ($data as &$field) {
                        $field = mb_convert_encoding($field, 'UTF-8', 'auto');
                    }

                    // Lấy dữ liệu từ dòng hiện tại
                    $ten = $conn->real_escape_string($data[0]);
                    $tk = $conn->real_escape_string($data[1]);
                    $mk = $conn->real_escape_string($data[2]);
                    $quyen = $conn->real_escape_string($data[3]);
                    $idAnhPhanThuong = $conn->real_escape_string($data[4]);
                    $giong = $conn->real_escape_string($data[5]);
                    $tocDo = $conn->real_escape_string($data[6]);
                    $tocDoHoTroBang = $conn->real_escape_string($data[7]);
                    $tocDoHoTroTiaSo = $conn->real_escape_string($data[8]);

                    // Mã hóa mật khẩu bằng md5 hoặc một phương pháp mã hóa khác
                    $hashedPassword = $mk;

                    // Kiểm tra xem tài khoản đã tồn tại chưa
                    $checkSql = "SELECT id_user FROM user WHERE tk = '$tk'";
                    $result = $conn->query($checkSql);
                    if (!$result) {
                        die("Lỗi truy vấn kiểm tra tài khoản: " . $conn->error);
                    }

                    if ($result->num_rows > 0) {
                        // Nếu tài khoản đã tồn tại, cập nhật dữ liệu
                        $sql = "UPDATE user
                                SET ten = '$ten', mk = '$hashedPassword', quyen = '$quyen', 
                                    id_anh_phan_thuong = '$idAnhPhanThuong', giong = '$giong', 
                                    toc_do = '$tocDo', toc_do_ho_tro_bang = '$tocDoHoTroBang', 
                                    toc_do_ho_tro_tia_so = '$tocDoHoTroTiaSo' 
                                WHERE tk = '$tk'";
                        if ($conn->query($sql) === TRUE) {
                            echo "Dữ liệu được cập nhật thành công cho người dùng: " . $tk . "<br>";
                        } else {
                            echo "Lỗi: " . $sql . "<br>" . $conn->error;
                        }
                    } else {
                        // Nếu tài khoản không tồn tại, chèn dữ liệu mới
                        $sql = "INSERT INTO user (ten, tk, mk, quyen, id_anh_phan_thuong, giong, toc_do, toc_do_ho_tro_bang, toc_do_ho_tro_tia_so) 
                                VALUES ('$ten', '$tk', '$hashedPassword', '$quyen', '$idAnhPhanThuong', '$giong', '$tocDo', '$tocDoHoTroBang', '$tocDoHoTroTiaSo')";
                        if ($conn->query($sql) === TRUE) {
                            echo "Dữ liệu được nhập thành công cho người dùng: " . $tk . "<br>";
                        } else {
                            echo "Lỗi: " . $sql . "<br>" . $conn->error;
                        }
                    }
                }

                // Đóng tệp CSV
                fclose($handle);
            } else {
                echo "Không thể mở tệp CSV.";
            }

            // Đóng kết nối đến CSDL
            $conn->close();
        } else {
            echo "Có lỗi xảy ra khi tải lên tệp của bạn.";
        }
    }
}
?>
