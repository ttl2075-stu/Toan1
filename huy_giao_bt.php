<?php
    session_start();
    include 'connectdb.php';
    if(!isset($_SESSION['id_user'])){
        header('Location: index.php');
        die();
    }
    $id_bai_tap_user=$_GET['id_bai_tap_user'];
    $id_bai_hoc = $_GET['id_bai_hoc'];
    $id_khoa_hoc = $_GET['id_khoa_hoc'];
    $id_user1 = $_GET['id_user'];
    function huy_giao($id_bai_tap_user){
        global $conn;
        $sql = "DELETE FROM `bai_tap_user` WHERE `id_bai_tap_user`='$id_bai_tap_user'";
        $result = mysqli_query($conn, $sql);
        return $result;
     }
    huy_giao($id_bai_tap_user);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
	<link rel="stylesheet" href="src/css/nhap_de_thi.css?v=1">
	<link rel="stylesheet" href="src/css/root.css">
    <link rel="stylesheet" href="src/css/button.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Giao bài tập chi tiết</title>
    <style>
        select {
            width: 200px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #61b1ee;
            color: #333;
            }
        option {
            background-color: #f8f8f8;
            color: #333;
        }
        .fa-solid{
            font-size:30px;
        }
        .fa-regular{
            font-size:30px;
        }
        tr,td{
            font-weight: bold;
            font-size: 25px;
        } 
    </style>
</head>
<body>

   


    <a href="danh_sach_giao_bt_chi_tiet_2.php?id_user=<?php echo $id_user1?>&id_khoa_hoc=<?php echo $id_khoa_hoc;?>&id_bai_hoc=<?php echo $id_bai_hoc; ?>">Trở về</a>
    <h1>Hủy giao bài tập thành công</h1>

</body>
</html>
<?php

?>