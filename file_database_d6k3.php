<?php
session_start();
include 'connectdb.php';

date_default_timezone_set('Asia/Ho_Chi_Minh');
$id_user = $_SESSION['id_bai_tap_user'];

// Check if form data with name 'hai' is submitted
if (isset($_POST['hai'])) {
    // Store form data in session
    $_SESSION['data_from_js'] = $_POST['hai'];
    $arr = json_decode($_SESSION['data_from_js'], true);

    $_SESSION['data2_from_js'] = $_POST['mucdo'];
    $arr2 = json_decode($_SESSION['data2_from_js'], true);

    // Assigning values from session to variables
    $id_dap_an1 = $_SESSION['id_bai'][0];
    $id_dap_an2 = $_SESSION['id_bai'][1];
    $id_dap_an3 = $_SESSION['id_bai'][2];
    $id_dap_an4 = $_SESSION['id_bai'][4];
    $inputt1_value = $arr['dapanmot'];
    $inputt2_value = $arr['pheptinh'];
    $inputt3_value = $arr['dapanhai'];
    $ket_qua =$arr['ketqua'];
    $luu_vet1 = $_POST['luu_vet1'];
    // $luu_vet1 = json_encode($luu_vet1);
    // Prepare SQL statement
    $sql = "INSERT INTO `dap_an_nguoi_dung_d6k3`(`id_dap_an_nguoi_dung_d6k3`, `id_dap_an`, `dap_an`, `stt_huong_dan`, `id_bai_tap_user`,`luu_vet`)
            VALUES 
            (null, '$id_dap_an1', '$inputt1_value', '$arr2', '$id_user','$luu_vet1'),
            (null, '$id_dap_an2', '$inputt2_value', '$arr2', '$id_user','$luu_vet1'),
            (null, '$id_dap_an3', '$inputt3_value', '$arr2', '$id_user','$luu_vet1'),
            (null, '$id_dap_an4', '$ket_qua', '$arr2', '$id_user','$luu_vet1')";     
    // // check xem bài đấy đã hoàn thành chưa
    if(check_trang_thai_hoan_thanh($id_user)==0){
        
        if(check_dap_an_d6k3($id_dap_an1,$inputt1_value)==1&&check_dap_an_d6k3($id_dap_an2,$inputt2_value)==1&&check_dap_an_d6k3($id_dap_an3,$inputt3_value)==1&&check_dap_an_d6k3($id_dap_an4,$ket_qua)==1){
            
            $sql1 = "UPDATE `bai_tap_user` SET `trang_thai`='1',`huong_dan_toi_da`='$arr2' WHERE `id_bai_tap_user`='$id_user'";
            cap_nhat_tg($id_user,2);
            mysqli_query($conn, $sql1);
            
        }
    }
    // else{
    //     if($arr2<stt_huong_dan($id_user)&&check_dap_an_d6k3($id_dap_an1,$inputt1_value)==1&&check_dap_an_d6k3($id_dap_an2,$inputt2_value)==1&&check_dap_an_d6k3($id_dap_an3,$inputt3_value)==1&&check_dap_an_d6k3($id_dap_an4,$ket_qua)==1){
    //         $sql1 = "UPDATE `bai_tap_user` SET `huong_dan_toi_da`='$arr2' WHERE `id_bai_tap_user`='$id_user'";
    //         mysqli_query($conn, $sql1);
    //     }
    // }

    // Execute SQL statement
    if(mysqli_query($conn, $sql)) {
        echo "Data inserted successfully.";
        
    } else {
        echo "Error: " . mysqli_error($conn);
    }
} else {
    echo "Error: No data received from JavaScript.";
}
    function cap_nhat_tg($id_bai_tap_user,$i){
        global $conn;
        $current_time = date('Y-m-d H:i:s');
        if($i==1){
            $sql = "UPDATE `bai_tap_user` SET `tg_bd`='$current_time' WHERE `id_bai_tap_user`='$id_bai_tap_user'";
        }
        elseif($i==2){
            $sql = "UPDATE `bai_tap_user` SET `tg_kt`='$current_time' WHERE `id_bai_tap_user`='$id_bai_tap_user'";
     
        }
        mysqli_query($conn,$sql);
    }

    function stt_huong_dan($id_bai_tap_user){
        global $conn;
        $sql ="SELECT * FROM `bai_tap_user` WHERE `id_bai_tap_user`='$id_bai_tap_user'";
        $result=mysqli_query($conn,$sql);
        $row = mysqli_fetch_assoc($result);
        return $row['huong_dan_toi_da'];
    }


    function check_dap_an_d6k3($id_dap_an,$dap_an_nguoi_dung){
        global $conn;
        $sql = "SELECT * FROM `dap_an_d6k3` WHERE `id_dap_an_d6k3`='$id_dap_an' AND `ten_dap_an`='$dap_an_nguoi_dung'";
        $kq=0;
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0){
            $kq=1;
        } 
        else {
            $kq=0;
        }
        return $kq;
    }
    
    function check_trang_thai_hoan_thanh($id_bai_tap_user){
        // nếu bài tập đã hoàn thành thì sẽ trả về 1 còn 0 là chưa hoàn thành
        global $conn;
        $kq=0;
        // $sql = "SELECT * FROM `bai_tap_user` WHERE `id_bai_tap_user`='$id_bai_tap_user'";
        $sql="SELECT * FROM `bai_tap_user` WHERE `id_bai_tap_user`='$id_bai_tap_user' AND `trang_thai`=1";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0){
            $kq=1;
        } 
        else {
            $kq=0;
        }
        return $kq;
    }
?>