<?php 
    session_start();
    // print_r($_SESSION);
    include 'connectdb.php';
    if(isset($_SESSION['id_user'])){
		header("Location:mo_dau.php");
	}
	// else{
	// 	header("");
	// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="src/css/dangnhap.css">
	<link rel="stylesheet" href="src/css/root.css">
    <link rel="stylesheet" href="src/css/button.css">
    <link rel="shortcut icon" type="image/png" href="anh/logo.png"/>
    <title>Hệ thống hỗ trợ dạy học môn toán lớp 1 cho học sinh khuyết tật học tập</title>
    
</head>
<body>
   
    <form action="" method="get">
        <h1>ĐĂNG NHẬP</h1>
        <label for=""><i class="fa-solid fa-user"></i>Tài khoản</label>
        <input type="text" name="tk" id="">
        <label for=""><i class="fa-solid fa-lock"></i>Mật khẩu</label>
        <input type="password" name="mk" id="">
        <input class="abc" type="submit" name="btn" value="Đăng nhập">
    </form>
    <?php
        if(isset($_GET['btn'])){
            $tk=$_GET['tk'];
            $mk=$_GET['mk'];

            $sql="SELECT * FROM `user` WHERE `tk`='$tk' AND `mk`='$mk'";
            $result = mysqli_query($conn, $sql);
           
            // Kiểm tra số lượng record trả về có lơn hơn 0
            // Nếu lớn hơn tức là có kết quả, ngược lại sẽ không có kết quả
            if (mysqli_num_rows($result) > 0) 
            {
                $row = mysqli_fetch_assoc($result);
                $role=$row['quyen'];
                $id_user = $row['id_user'];
                // echo $id_user;   
                $_SESSION['ten'] = $row['ten'];
                $_SESSION['id_user'] = $id_user;
                $_SESSION['quyen'] = $role;
                $_SESSION['toc_do']=$row['toc_do'];
                $_SESSION['giong']=$row['giong'];
                $_SESSION['toc_do_ho_tro_bang']=$row['toc_do_ho_tro_bang'];
                $_SESSION['toc_do_ho_tro_tia_so']=$row['toc_do_ho_tro_tia_so'];
                header("Location:khoa_hoc.php");
            }else{
                echo "<script>
                alert('Tài khoản hoặc mật khẩu nhập không chính xác');
                
            </script>";
            }
        }
    ?>
</body>
</html>