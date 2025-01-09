<?php
// trên host
$DB_HOST1 = 'cpanel.learning2ne1.com';
$DB_USER1 = 'bikvyzpx_nckh_2024';
$DB_PASS1 = 'F^)U6M#CW{o3';
$DB_NAME1 = 'bikvyzpx_nckh_2024'; //tên database

// trên local
$DB_HOST = 'nvme.h2cloud.vn';
$DB_USER = 'longitco_root';
$DB_PASS = 'Long@2005';
$DB_NAME = 'longitco_toan1'; //tên database
$conn=mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die("Không thể kết nối tới cơ sở dữ liệu");
// $conn=mysqli_connect($DB_HOST1, $DB_USER1, $DB_PASS1, $DB_NAME1) or die("Không thể kết nối tới cơ sở dữ liệu");
if($conn){
    mysqli_query($conn,"SET NAMES 'utf8'");
}
?>