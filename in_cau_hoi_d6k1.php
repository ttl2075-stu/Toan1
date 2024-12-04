<?php
session_start();

include 'connectdb.php';
if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    die();
}

// Thiết lập múi giờ mặc định nếu cần
date_default_timezone_set('Asia/Ho_Chi_Minh');

// Lấy thời gian hiện tại

function cap_nhat_tg($id_bai_tap_user, $i)
{
    global $conn;
    $current_time = date('Y-m-d H:i:s');
    if ($i == 1) {
        $sql = "UPDATE `bai_tap_user` SET `tg_bd`='$current_time' WHERE `id_bai_tap_user`='$id_bai_tap_user'";
    } else {
        $sql = "UPDATE `bai_tap_user` SET `tg_kt`='$current_time' WHERE `id_bai_tap_user`='$id_bai_tap_user'";
    }
    mysqli_query($conn, $sql);
}

$role = $_SESSION['quyen'];
$id_user = $_SESSION['id_user'];

//   $id_bai_hoc=$_GET['id_bai_hoc'];
// $id_user = $_GET['id_user'];
// $role = $_GET['role'];


$id_cau_hoi = $_GET['id_cau_hoi'];

$_SESSION['id_cau_hoi'] = $id_cau_hoi;
$_SESSION['id_dap_an_multichoice'] = '';
$id_bai_tap_user = $_GET['id_bai_tap_user'];
$_SESSION['id_bai_tap_user'] = $id_bai_tap_user;

cap_nhat_tg($id_bai_tap_user, 1);
// echo $_SESSION['quiz'];
// print_r(json_decode($_SESSION['quiz'], true));
// echo $id_bai_tap_user;
// Lấy id loại hiển thị
$bieuThuc = '';
$noiDungQuiz = '';
$loaiKiemTra = 'khongtrudiem';
$trangthai = '';
$sql = "SELECT * FROM `cau_hoi` WHERE `cau_hoi`.`id_cau_hoi`='$id_cau_hoi' ";
$result1 = mysqli_query($conn, $sql);
$row1 = mysqli_fetch_assoc($result1);
// echo $row1['id_loai_hien_thi'];
if ($row1['id_loai_hien_thi'] == 1) {
    $sql1 = "SELECT * FROM `dap_an_d6k1` WHERE `id_cau_hoi`='$id_cau_hoi' order by `stt`";
    // Thực thi câu truy vấn và gán vào $result
    $result1 = mysqli_query($conn, $sql);
    $row1 = mysqli_fetch_assoc($result1);
    // print_r($row1);
    $noiDungQuiz = $row1['ten_cau_hoi'];
    $result2 = mysqli_query($conn, $sql1);
    if (mysqli_num_rows($result2) > 0) {
        while ($row2 = mysqli_fetch_assoc($result2)) {
            $bieuThuc .= $row2["ten_dap_an"];
            $_SESSION['id_dap_an_multichoice'] = $row2['id_dap_an_multichoice'];
        }
    } else {
        echo "Không có record nào";
    }

    // $sql = "SELECT * FROM `dap_an_nguoi_dung_d6k1` AS d 
    // JOIN bai_tap_user AS b ON d.id_bai_tap_user = b.id_bai_tap_user 
    // JOIN dap_an_d6k1 AS d2 ON d2.id_cau_hoi = b.id_cau_hoi 
    // WHERE b.id_cau_hoi = ? AND d2.stt = 5 AND b.id_user = ? ";
    // $sql = "SELECT * FROM `bai_tap_user`
    // WHERE b.id_bai_tap_user = ? AND b.trang_thai = '1'";

    // // Chuẩn bị câu lệnh
    // $stmt = $conn->prepare($sql);

    // if ($stmt) {
    //     // $stmt->bind_param("ii", $id_cau_hoi, $id_user);
    //     $stmt->bind_param("i", $id_bai_tap_user);
    //     $stmt->execute();
    //     // Lấy kết quả
    //     $result = $stmt->get_result();
    //     // Xử lý kết quả
    //     if ($result->num_rows > 0) {
    //         // Duyệt qua từng hàng kết quả
    //         while ($row = $result->fetch_assoc()) {
    //             // if ($row['dap_an'] == $row['ten_dap_an']) {
    //             //     echo 'Đã làm đúng';
    //             //     $dapAnTraLoiGanNhat = $row['dap_an'];
    //             //     break;
    //             // } else {
    //             //     echo 'Chưa làm đúng';
    //             //     $dapAnTraLoiGanNhat = $row['dap_an'];
    //             // }
    //             // echo $row['dap_an'] . ' and ' . $row['ten_dap_an'] . '<br>';
    //             // if($row['trang_thai'] == 1) echo "da lam;";
    //             echo "da lam";
    //         }
    //     } else {
    //         echo "Không có dữ liệu.";
    //     }
    //     // Đóng câu lệnh
    //     $stmt->close();
    $sql = "SELECT * FROM `bai_tap_user`
    WHERE id_bai_tap_user = ? AND trang_thai = '1'";

    // Chuẩn bị câu lệnh
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        // $stmt->bind_param("ii", $id_cau_hoi, $id_user);
        $stmt->bind_param("i", $id_bai_tap_user);
        $stmt->execute();
        // Lấy kết quả
        $result = $stmt->get_result();
        // Xử lý kết quả
        if ($result->num_rows > 0) {
            // Duyệt qua từng hàng kết quả
            while ($row = $result->fetch_assoc()) {
                $trangthai = 'Đã hoàn thành';
            }
        } else {
            $trangthai = 'Chưa hoàn thành';
        }
        // Đóng câu lệnh
        $stmt->close();
    } else {
        echo "Lỗi trong quá trình chuẩn bị câu lệnh SQL.";
    }
}

$arrBieuThuc = explode("=", $bieuThuc);
$bieuThuc = $arrBieuThuc[0];
$ketQua = $arrBieuThuc[1];
$cau = [
    "cauHoi" => $noiDungQuiz,
    "bieuThuc" => $bieuThuc,
    "dapAn" => $ketQua,
    "kiemTra" => $loaiKiemTra,
    "soLanTraLoiSai" => 0,
    "diem" => 0,
    "dapAnTraLoiGanNhat" => "",
    "suDungTroGiupMuc" => 0,
    "id_user" => $id_user,
    "mucHelp" => 0,
    "trangthai" => $trangthai
];
$quiz = [];
$quiz[] = $cau;
$_SESSION['quiz'] = json_encode($quiz);
$sessionDataJSON = json_encode($_SESSION['quiz']);


$sql = "SELECT * FROM `cau_hoi` WHERE `id_cau_hoi`=$id_cau_hoi";
$kq = mysqli_query($conn, $sql);
$id_loai_hien_thi = mysqli_fetch_assoc($kq);
$id_loai_hien_thi = $id_loai_hien_thi['id_loai_hien_thi'];

// echo $sessionDataJSON;
// echo $trangthai;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D6K1 - Tổng Hiệu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./src/css/form.css">
    <link rel="stylesheet" href="./src/css/setting.css">
    <link rel="stylesheet" href="./src/css/button.css">
    <link rel="stylesheet" href="./src/css/d6k1_show.css">
    <link rel="stylesheet" href="./src/css/help.css">
    <link rel="stylesheet" href="./src/css/the.css">
    <link rel="stylesheet" href="./src/css/tia_so.css">
    <link rel="stylesheet" href="./src/css/help_bang.css">
    <link rel="stylesheet" href="./src/css/lego.css">
    <link rel="stylesheet" href="./assets/css_v2/style.css">
    <link rel="stylesheet" href="./assets/css_v2/InCauHoi_d6k1.css">
    <script src="./src/js/function.js"></script>
    <script>
        // Loại bỏ sự kiện beforeunload
        window.removeEventListener('beforeunload', function(e) {
            // Không làm gì cả sẽ ngăn chặn thông báo
        });

        // Đảm bảo rằng không có sự kiện beforeunload nào được thêm mới
        window.onbeforeunload = null;

        function upLocalStorage(key, value) {
            localStorage.setItem(key, JSON.stringify(value))
        }
    </script>
    <!-- Chuyen session php sang localstorage -->
    <script>
        let loaihienthi = <?php echo $id_loai_hien_thi; ?>;
        let sessionData = <?php echo $sessionDataJSON; ?>;
        let quizs = JSON.parse(sessionData);
        upLocalStorage("d6k1_baiDien", quizs);
    </script>
    <style>
        .cauhoi {
            font-size: 30px;
            font-weight: bold;
            color: black;
            background-color: bisque;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);
        }

        #help {
            padding: 0px;
        }

        #help img {
            width: 50px;
            height: 50px;
        }

        #incrementButton {
            margin: 3% 10% 0px 0px;
        }

        .btn {
            background-color: #2da0fa;
            border: none;
            color: white;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            margin-right: 10px;
            transition: transform 0.5s ease-in-out;
            font-size: 25px;
        }

        .btn i {
            color: white;
        }

        .btn:hover {
            background-color: yellow;
            transform: translateY(-5px);
            color: black;
        }

        #help {
            padding: 0 10px;
            margin-top: 10px;
            /* width: 50px; */
        }

        #help img {
            width: 50px;
            /* Độ rộng của hình ảnh */
            margin-left: 5px;
            /* Khoảng cách giữa hình ảnh và văn bản */
        }

        /* .help-container{
            height: 100px;
            position: relative;
        } */
        table {
            width: 100%;
            table-layout: fixed;
            /* Giảm kích thước chữ */
        }

        @media (max-width: 768px) {
            .bocso {
                font-size: 14px;
            }

            td,
            th {
                padding: 5px;
                /* font-size: 12px; */
                /* Giảm padding */
            }
        }
    </style>
</head>

<body>
    <div class="show">
        <div class="tags">
        </div>
    </div>

    <div class="button-container">
        <!-- <button type="button" class="return-button return-button-top-left" onclick="returnToForm()"><i class="fa-solid fa-backward"></i>Trở về</button> -->
        <button type="button" class="btn hinhthucTL" id="traloikeotha" onclick="showThe()"><img src="./icon/thedapan.png" style="width:30px; height:30px; margin-right: 10px">Hiện thẻ đáp án</button>
        <button type="button" class="btn hinhthucTL" id="traloithuam" onclick="showThuAM()"><img src="./icon/listen_1.png" style="width:30px; height:30px; margin-right: 10px">Thu âm để trả lời</button>
        <button type="button" class="btn hinhthucTL" id="traloidien" onclick="showDien()"><img src="./icon/thedapan.png" style="width:30px; height:30px; margin-right: 10px"></i>Trả lời bằng cách điền</button>
    </div>
    <div class="score-container box_flex_column">
        <label style="display:none;">ĐIỂM</label>
        <span id="diem" style="display:none;">0</span>
        <span id="cauSo" style='display:none;'></span>
        <div class="lesson" style='display:none;'></div>
        <form action="" method="post">


            <button style="margin-bottom: 50%;" type="button" class="btn" id="check" name="btn_check" onclick="checkAnswer()"><img src="./icon/check.png" style="width:30px; height:30px;">Kiểm tra</button>


            <button type="button" class="btn" id="help" name='btn_hd' value="
        <?php
        // $sql="SELECT * FROM `ho_tro_hien_thi` WHERE `id_loai_hien_thi`=$id_loai_hien_thi";
        $sql = " SELECT * FROM `kieu_ho_tro_chi_tiet` INNER JOIN `ho_tro_hien_thi` WHERE `kieu_ho_tro_chi_tiet`.`id_kieu_ho_tro` = `ho_tro_hien_thi`.`id_kieu_ho_tro` 
        AND `ho_tro_hien_thi`.`id_loai_hien_thi`=$id_loai_hien_thi";
        $kq = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($kq)) {
            print_r($row['id_kieu_ho_tro_chi_tiet']);
            echo '-';
            print_r($row['id_kieu_ho_tro']);
            echo '-';
            print_r($row['stt']);
            echo '/';
        }
        function tim_id($value, $a)
        {
            $i = 0;
            for ($i = 0; $i < count($a); $i++) {
                if ($a[$i] == $value) {
                    $vt = $i;
                    break;
                }
            }
            return $i;
        }
        $i = 0;
        ?>
        "><img src="./icon/support.png" style="margin-right: 10px;">Hỗ trợ</button>
        </form>
    </div>
    <span class='notice hidden'>
    </span>

    <div class="help-container">
        <div class="cauhoi">Câu hỏi:
            <span id="debai">
                <?php
                $sql = "SELECT ten_cau_hoi FROM `cau_hoi` WHERE cau_hoi.id_cau_hoi = $id_cau_hoi";
                $a = mysqli_query($conn, $sql);
                while ($row = mysqli_fetch_assoc($a)) {
                    echo $row['ten_cau_hoi'];
                };
                ?>
            </span>
            <div style="display: none;" id="bieuThuc">Tính: <?php echo $bieuThuc ?></div>

        </div>
        <div class='div-btn'>
            <button type="button" class="back-button"><img src="./icon/trove.png" style="width:30px; height:30px; margin-right: 5px; ">Trở về</button>
        </div>
        <center>
            <div id="nuthotro"></div>
            <div id="tableContainer"></div>
            <div id="support"></div>
            <div class="show-help"></div>
            <div id="legoContainer"></div>
        </center>

    </div>

    <!-- <audio src="./mp4/True.mp4" id="correct-audio"></audio>
        <audio src="./mp4/False.mp4" id="incorrect-audio"></audio> -->

    <div class="Notice_True" style="display: none;">
        <img src="./icon/dung.png" class="trueVideo">

        <audio class="trueAudio" src="mp4/True.mp4" type="audio/mp4">
            Your browser does not support the audio element.
        </audio>
    </div>

    <div class="Notice_False" style="display: none;">
        <img src="./icon/sai.png" class="falseVideo">

        <audio class="falseAudio" src="mp4/False.mp4" type="audio/mp4">
            Your browser does not support the audio element.
        </audio>
    </div>


    <!-- thong bao dung sai -->
    <!-- <div class="Notice_True" style="display: none;">
        <video class="trueVideo" width="320" height="240" controls>
            <source src="mp4/True.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <audio class="trueAudio" src="mp4/True.mp4" type="audio/mp4">
            Your browser does not support the audio element.
        </audio>
    </div>

    <div class="Notice_False" style="display: none;">
        <video class="falseVideo" width="320" height="240" controls>
            <source src="mp4/False.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>

        <audio class="falseAudio" src="mp4/False.mp4" type="audio/mp4">
            Your browser does not support the audio element.
        </audio>
    </div> -->

    <div class="notice-container">
        <h1>Bạn đã hoàn thành</h1>
        <div class='btn-div-notice'>
            <!-- <button type="button" class="back-button"><i class="fa-solid fa-pen-to-square"></i>Làm lại</button> -->
            <button type="button" class="xemdapan-button" onclick="Xemdapan()"><i class="fa-solid fa-eye"></i>Xem lại đáp án đúng</button>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.help-container .back-button').click(function() {
                $(this).closest('.help-container').removeClass('show');
                $('#tableContainer').empty();
                $('#legoContainer').empty();
                $('#support').empty();
                $('.show-help').empty();
            });
            $('.notice-container button').click(function() {
                $(this).closest('.notice-container').removeClass('showNotice');
            });
        });
        console.log(<?php echo $id_loai_hien_thi; ?>)
    </script>
    <script>
        // $('#check').click(function() {
        //     var hai = localStorage.getItem('d6k1_baiDien');
        //     $.ajax({
        //         url: 'file_php_xu_ly_du_lieu_d6k1.php',
        //         type: 'post',
        //         data: {
        //             hai: hai

        //         },
        //         success: function(response) {
        //             // alert(response);
        //         },
        //         error: function(xhr, status, error) {
        //             console.error(error);
        //         }
        //     });
        // });
        $('#check').click(function() {
            var hai = localStorage.getItem('d6k1_baiDien');
            var luu_vet1 = localStorage.getItem('luu_vet');
            $.ajax({
                url: 'file_php_xu_ly_du_lieu_d6k1.php',
                type: 'post',
                data: {
                    hai: hai,
                    luu_vet1: luu_vet1
                },
                success: function(response) {
                    // Check the result of the AJAX call and play the corresponding audio
                    if (isTrue) {
                        $('.Notice_True').show();
                        $('.Notice_False').hide();
                        playAudio('.trueAudio', hideImage);
                    } else {
                        $('.Notice_True').hide();
                        $('.Notice_False').show();
                        playAudio('.falseAudio', hideImage);
                    }
                },
                error: function(xhr, status, error) {
                    console.error(error);
                }
            });
        });

        function playAudio(audioSelector, callback) {
            // Select the audio element and play it
            var audio = $(audioSelector)[0];
            audio.play();

            // Add an event listener for the 'ended' event
            audio.addEventListener('ended', function() {
                // When the audio ends, call the callback function
                if (typeof callback === 'function') {
                    callback();
                }
            });
        }

        function hideImage() {
            // Hide the corresponding image
            $('.Notice_True').hide();
            $('.Notice_False').hide();
        }
        localStorage.setItem("luu_vet", JSON.stringify([]));
    </script>

    <script src="./src/js/d6k1.js"></script>
    <script src="./src/js/helpnew.js"></script>
    <script src="./src/js/function_help.js"></script>
    <script src="./src/js/the.js"></script>
</body>

</html>