<?php
// trên host
// $DB_HOST = 'localhost';
// $DB_USER = 'bikvyzpx_nckh_2024';
// $DB_PASS = 'F^)U6M#CW{o3';
// $DB_NAME = 'bikvyzpx_nckh_2024'; //tên database

// trên local
$DB_HOST = 'nvme.h2cloud.vn';
$DB_USER = 'root';
$DB_PASS = 'Long@2005';
$DB_NAME = 'toan1'; //tên database
$conn=mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME) or die("Không thể kết nối tới cơ sở dữ liệu");
if($conn){
    mysqli_query($conn,"SET NAMES 'utf8'");
}