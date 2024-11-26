<?php
include('connectdb.php');
session_start();

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if(isset($_POST['doimatkhau'])){
    $taikhoan = $_POST['tk'];
    $matkhau_cu = $_POST['mk_cu'];
    $matkhau_moi = $_POST['mk_moi'];

    if(empty($taikhoan) || empty($matkhau_cu) || empty($matkhau_moi)) {
        echo "<p class='error-message'>Vui lòng điền đầy đủ thông tin tài khoản và mật khẩu.</p>";
    } else {
        $sql_update = mysqli_query($conn, "UPDATE user SET mk='$matkhau_moi' WHERE tk='$taikhoan' AND mk='$matkhau_cu'");

        if ($sql_update) {
            $affected_rows = mysqli_affected_rows($conn);

            if ($affected_rows > 0) {
                echo "<p class='success-message'>Mật khẩu đã được thay đổi thành công!</p>";
                // Thực hiện chuyển hướng sau 5 phút
                echo "<script>
                        setTimeout(function(){
                            window.location.href = 'mo_dau.php';
                        }, 5000);
                      </script>";
            } else {
                echo "<p class='error-message'>Mật khẩu cũ không đúng. Vui lòng thử lại.</p>";
            }
        } else {
            echo "<p class='error-message'>Có lỗi xảy ra khi cập nhật mật khẩu: " . mysqli_error($conn) . "</p>";
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Đổi mật khẩu</title>
    <link rel="shortcut icon" type="image/png" href="anh/logo.png"/>
    <link rel="stylesheet" href="./src/css/dangnhap.css">
    <link rel="stylesheet" href="./src/css/root.css">
    <style>
        /* CSS cho thông báo thành công */
        .success-message {
            color: green;
            font-weight: bold;
            background-color: antiquewhite;
            text-align: center;
            position: relative;
            top: 50px;
            padding: 15px 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Thêm hiệu ứng box-shadow */
        }

        /* CSS cho thông báo lỗi */
        .error-message {
            color: red;
            font-weight: bold;
            background-color: antiquewhite;
            text-align: center;
            position: relative;
            top: 50px;
            padding: 15px 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Thêm hiệu ứng box-shadow */
        }
    </style>
</head>
<body>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
    <h1>Thay đổi mật khẩu</h1>
        <div>        
            <label for="tk">Tài khoản:</label>
            <input type="text" id="tk" name="tk" required>
        </div>
        <div>
            <label for="mk_cu">Mật khẩu cũ:</label>
            <input type="password" id="password_cu" name="mk_cu" required>
        </div>
        <div>
            <label for="mk_moi">Mật khẩu mới:</label>
            <input type="password" id="password_moi" name="mk_moi" required>
        </div>
        <div>
            <input type="submit" value="Thay đổi mật khẩu" name="doimatkhau">
        </div>
    </form>
</body>
</html>
