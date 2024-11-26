<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phân quyền</title>
</head>
<body>
    <h1>Lựa chọn quyền</h1>
    <form action="" method="get ">
        <select name="role" id="">
            <option value="1">Giáo viên</option>
            <option value="2">Học sinh</option>
        </select>
        <input type="submit" name="btn_quyen" value="Xác nhận">
        <!-- <input type="submit" name="quyen" value="Học sinh"> -->
    </form>
    <?php
        if(isset($_GET['btn_quyen'])){
            $quyen= $_GET['role'];
            // echo $quyen;
            header("Location:nhap_cau_hoi.php?role=$quyen");
        }
    ?>
</body>
</html>