<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <?php $id_cau_hoi=$_GET['id_cau_hoi']; ?>
    <form action="" method="get">
        <label for="">Nhập số lượng cặp</label>
        <input type="text" name="sl_cap" id="">
        <input type="submit" name="btncap" value="Nhập">
    </form>
    
   <?php 
    if(isset($_GET['btncap'])){
        $sl_cap=$_GET['sl_cap'];
        header("Location:nhap_cau_hoi_d6_k2.php?sl_cap=$sl_cap&id_cau_hoi=$id_cau_hoi");
        
    }
    ?>
</body>
</html>