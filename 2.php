<?php include 'connectdb.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
   <?php
    $sql = "SELECT * FROM `dap_an_nguoi_dung_d6k1` WHERE `id_dap_an_nguoi_dung_d6k1`=269";
    $kq = mysqli_query($conn,$sql);
    while($row = mysqli_fetch_array($kq)){
        // print_r($row['luu_vet']);
        $arrayData = json_decode($row['luu_vet'], true);
        print_r($arrayData);
        
    }
   ?>
</body>
</html>