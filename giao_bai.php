<?php
include 'connectdb.php';

$id_user = $_POST['user'];
$id_bai_hoc = $_POST['bai_hoc'];
$id_khoa_hoc = $_POST['id_khoa_hoc'];
$id_nguoi_giao = $_POST['id_nguoi_giao'];
$questions = json_decode($_POST['questions'], true);

if (!empty($questions)) {
    foreach ($questions as $question_id) {
        // Kiểm tra xem bài tập đã được giao chưa
        // $sql_check = "SELECT * FROM `bai_tap_user` WHERE `id_user`='$id_user' AND `id_cau_hoi`='$question_id' AND `id_khoa_hoc`='$id_bai_hoc'";
        // $result_check = mysqli_query($conn, $sql_check);

        // if (mysqli_num_rows($result_check) == 0) {
        // Giao bài mới
        $sql_insert = "INSERT INTO `bai_tap_user` (`id_bai_tap_user`,`id_user`, `id_cau_hoi`,`trang_thai`,`huong_dan_toi_da`, `id_khoa_hoc`) VALUES (null,'$id_user', '$question_id','0','0', '$id_khoa_hoc')";
        mysqli_query($conn, $sql_insert);
        $sql1 = "INSERT INTO `thong_bao`(`id_thong_bao`, `id_nguoi_nhan`, `id_nguoi_gui`, `id_bai_hoc`, `id_khoa_hoc`) VALUES (null,'$id_nguoi_giao','$id_user','$id_bai_hoc','$id_khoa_hoc')";
        mysqli_query($conn, $sql1);
        // }
    }
    // $sql="INSERT INTO `bai_tap_user`(`id_bai_tap_user`, `id_user`, `id_cau_hoi`, `trang_thai`, `huong_dan_toi_da`, `id_khoa_hoc`) VALUES (null,'$user','$id_cau_hoi','0','0','$id_khoa_hoc')";
    // mysqli_query($conn,$sql);

    echo "Giao bài thành công!";
} else {
    echo "Không có câu hỏi nào được chọn.";
}
