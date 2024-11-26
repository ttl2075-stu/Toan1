<?php
session_start(); // Start PHP session
include 'connectdb.php';
// $conn = mysqli_connect('localhost', 'root', '', 'nckh_2024');

if (isset($_POST['hai'])) {
    // Store data into session variables
    $id_cau_hoi = $_SESSION['id_cau_hoi'];
    $id_dap_an = $_SESSION['id_dap_an_multichoice'];
    $_SESSION['data_from_js'] = $_POST['hai'];
    echo "Data has been saved into session variables.";

    // Decode JSON data from session
    $arr = json_decode($_SESSION['data_from_js'], true);

    foreach ($arr as $key => $value) {
        // Extract user ID from the array
        $id_user = $value['id_user'];

        // Query to get the corresponding id_bai_tap_user
        $sql_select = "SELECT * FROM `bai_tap_user` WHERE `id_user`= $id_user AND `id_cau_hoi`='$id_cau_hoi'";
        $result = mysqli_query($conn, $sql_select);

        if ($result && mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $id_bai_tap_user = $row['id_bai_tap_user'];
             
            // Insert data into dap_an_nguoi_dung_d6k1 table
            $sql_insert = "INSERT INTO `dap_an_nguoi_dung_d6k1`(`id_dap_an_nguoi_dung_d6k1`, `id_dap_an`, `dap_an`, `stt_huong_dan`, `id_bai_tap_user`) VALUES 
                (null, $id_dap_an, '{$value['dapAnTraLoiGanNhat']}', '{$value['mucHelp']}', $id_bai_tap_user)";

            if (mysqli_query($conn, $sql_insert)) {
                echo "Data has been successfully inserted into the database.";
                // $last_id = mysqli_insert_id($conn);
                // check_d6k1($last_id);
            } else {
                echo "Error: " . $sql_insert . "<br>" . mysqli_error($conn);
            }
        } else {
            echo "No matching record found for user ID: $id_user and cau hoi ID: $id_cau_hoi";
        }
    }
} else {
    echo "No data received from JavaScript.";
}

// hàm check đáp án người dùng làm đã đúng chưa
// kiểm tra người dùng đã hoàn thành chưa, nếu rồi thì không cần check
function check_trang_thai_hoan_thanh($id_bai_tap_user){
    // nếu bài tập đã hoàn thành thì sẽ trả về 1 còn 0 là chưa hoàn thành
    global $conn;
    $kq=0;
    // $sql = "SELECT * FROM `bai_tap_user` WHERE `id_bai_tap_user`='$id_bai_tap_user'";
    $sql="SELECT * FROM `bai_tap_user` WHERE `id_bai_tap_user`='$id_bai_tap_user' AND `trang_thai`=1;";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0){
        $kq=1;
    } 
    else {
        $kq=0;
    }
    return $kq;
}
// hàm lấy đáp án d6k1
function get_dap_an_d6k1($id_dap_an,$dap_an){
    global $conn;
    $sql = "SELECT * FROM `dap_an_d6k1` WHERE `id_dap_an_multichoice`='$id_dap_an' AND `ten_dap_an`='$dap_an'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        return 1; 
    } 
    else {
        return 0;
    }
}
function check_d6k1($last_id){
    global $conn;
    $sql="SELECT * FROM `dap_an_nguoi_dung_d6k1` WHERE `id_dap_an_nguoi_dung_d6k1`='$last_id'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $id_bai_tap_user = $row['id_bai_tap_user'];
        if(check_trang_thai_hoan_thanh($id_bai_tap_user)==0){
            $id_dap_an = $row['id_dap_an'];
            $dap_an = $row['dap_an'];
            if(get_dap_an_d6k1($id_dap_an,$dap_an)==1){
                $sql1 = "UPDATE `bai_tap_user` SET `trang_thai`='$dap_an' WHERE `id_bai_tap_user`='$id_bai_tap_user'";
                mysqli_query($conn, $sql1);
            }

        }
        
    } 
    else {
        echo "Không có record nào";
    }
    // kiểm tra xem câu đó đã hoàn thành chưa nếu rồi thì không cần làm gì


}
?>
