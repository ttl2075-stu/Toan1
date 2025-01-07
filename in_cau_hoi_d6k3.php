<?php
ob_start();
session_start();
include 'connectdb.php';
if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    die();
}

date_default_timezone_set('Asia/Ho_Chi_Minh');
$role = $_SESSION['quyen'];
$id_user = $_SESSION['id_user'];
$id_bai_tap_user = $_GET['id_bai_tap_user'];
cap_nhat_tg($id_bai_tap_user, 1);
$id_cau_hoi = $_GET['id_cau_hoi'];

$ham = $_GET['id_cau_hoi'];
$sql = "SELECT * FROM `dap_an_d6k3` 
        WHERE id_cau_hoi = '$ham'";

$a = mysqli_query($conn, $sql);
$mang_rong = [];
$id_mang = [];
while ($row = mysqli_fetch_assoc($a)) {
    array_push($mang_rong, $row["ten_dap_an"]);
    array_push($id_mang, $row["id_dap_an_d6k3"]);
}
$sql_cau_hoi = "SELECT url_doi_tuong, url_dung_do FROM `cau_hoi`
    WHERE id_cau_hoi = '$ham';
    ";
$result =  mysqli_query($conn, $sql_cau_hoi);
$_SESSION['anh'] = mysqli_fetch_assoc($result);

$_SESSION['dang_bai'] = $mang_rong;
// printf($_SESSION['dang_bai']);
// print_r($_SESSION['dang_bai'])
$_SESSION['id_bai'] = $id_mang;

$id_cau_hoi = $ham;
$_SESSION['id_cau_hoi'] = $id_cau_hoi;
$_SESSION['id_dap_an_d6k3'] = '';
// echo $_SESSION['quiz'];
// print_r(json_decode($_SESSION['quiz'], true));

// Lấy id loại hiển thị
$bieuThuc = '';
$noiDungQuiz = '';
$loaiKiemTra = 'khongtrudiem';
// $conn = mysqli_connect('localhost', 'root', '', 'nckh_2024');
if (!$conn) {
    die("Kết nối thất bại: " . mysqli_connect_error());
}
$sql = "SELECT * FROM `cau_hoi` WHERE `cau_hoi`.`id_cau_hoi`='$id_cau_hoi' ";
$result1 = mysqli_query($conn, $sql);
$row1 = mysqli_fetch_assoc($result1);
// echo $row1['id_loai_hien_thi'];
if ($row1['id_loai_hien_thi'] == 3) {
    $sql1 = "SELECT * FROM `dap_an_d6k3` WHERE `id_cau_hoi`='$id_cau_hoi' order by `stt`";
    // Thực thi câu truy vấn và gán vào $result
    $result1 = mysqli_query($conn, $sql);
    $row1 = mysqli_fetch_assoc($result1);
    // print_r($row1);
    $noiDungQuiz = $row1['ten_cau_hoi'];
    $result2 = mysqli_query($conn, $sql1);
    if (mysqli_num_rows($result2) > 0) {
        while ($row2 = mysqli_fetch_assoc($result2)) {
            $bieuThuc .= $row2["ten_dap_an"];
            $_SESSION['id_dap_an_d6k3'] = $row2['id_dap_an_d6k3'];
        }
    } else {
        echo "Không có record nào";
    }
}
$id_user = 3;
$role = 4;
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
    "mucHelp" => 0
];
$quiz = [];
$quiz[] = $cau;
$_SESSION['quiz'] = json_encode($quiz);
$sessionDataJSON = json_encode($_SESSION['quiz']);

$sql = "SELECT * FROM `cau_hoi` WHERE `id_cau_hoi`=$id_cau_hoi";
$kq = mysqli_query($conn, $sql);
$id_loai_hien_thi = mysqli_fetch_assoc($kq);
$id_loai_hien_thi = $id_loai_hien_thi['id_loai_hien_thi'];

$_SESSION['id_bai_tap_user'] = $_GET['id_bai_tap_user'];
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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./src/css/d6_k3.css">
    <link rel="stylesheet" href="./assets/css_v2/style.css">
    <link rel="stylesheet" href="./assets/css_v2/InCauHoi_d6k3.css">
    <script src="./src/js/function.js"></script>
    <script>
    // Loại bỏ sự kiện beforeunload
    window.removeEventListener('beforeunload', function(e) {
        // Không làm gì cả sẽ ngăn chặn thông báo
    });
    localStorage.setItem("luu_vet", JSON.stringify([]));
    // Đảm bảo rằng không có sự kiện beforeunload nào được thêm mới
    window.onbeforeunload = null;

    function upLocalStorage(key, value) {
        localStorage.setItem(key, JSON.stringify(value))
    }
    </script>
    <!-- Chuyen session php sang localstorage -->
    <style>
    #help {
        padding: 0px;
    }

    #help img {
        width: 50px;
        height: 50px;
    }

    .btn {
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

    .button-red {
        background: #ff4742 !important;
        border: 1px solid #ff4742;
        color: #ffffff;
    }

    .button-1 {
        border-radius: 6px;
        box-shadow: rgba(0, 0, 0, 0.1) 1px 2px 4px;
        box-sizing: border-box;
        cursor: pointer;
        display: inline-block;
        font-weight: 800;
        min-height: 40px;
        outline: 0;
        padding: 15px;
        text-align: center;
        text-rendering: geometricprecision;
        text-transform: none;
        user-select: none;
        -webkit-user-select: none;
        touch-action: manipulation;
        vertical-align: middle;
    }

    .btn i {
        color: white;
    }

    .btn:hover {
        background-color: white !important;
        transform: translateY(-5px);
        color: red !important;
    }

    #help {
        padding: 0 10px;
        margin-top: 10px;
    }

    #help img {
        width: 50px;
        margin-left: 5px;
    }

    table {
        width: 100%;
        table-layout: fixed;
        /* Giảm kích thước chữ */
    }

    @media (max-width: 768px) {
        .bocso {
            font-size: 14px;
            height: 50px;
        }

        td,
        th {
            padding: 5px;
            /* font-size: 12px; */
            /* Giảm padding */
        }
    }

    @media (max-width: 500px) {
        .bocso {
            font-size: 14px;
            height: 25px;
        }

        td,
        th {
            padding: 5px;
            /* font-size: 12px; */
            /* Giảm padding */
        }
    }
    </style>
    <script>
    let loaihienthi = <?php echo $id_loai_hien_thi; ?>;
    let sessionData = <?php echo $sessionDataJSON; ?>;
    console.log(sessionData);
    let quizs = JSON.parse(sessionData);

    upLocalStorage("d6k3_baiDien", quizs);
    </script>
</head>

<body>
    <form action="" method="post" id="form_ban_dau">
        <div id="boc_tong" class="kiemtra">
            <!-- <button type="submit" name="quay_ve">Quay lại</button> -->
            <br>
            <!-- em thêm class -->
            <div class="cauhoi">Câu hỏi:
                <span id="debai">
                    <?php
                    $sql = "SELECT ten_cau_hoi FROM `cau_hoi` WHERE cau_hoi.id_cau_hoi = $ham";
                    $a = mysqli_query($conn, $sql);
                    while ($row = mysqli_fetch_assoc($a)) {
                        echo $row['ten_cau_hoi'];
                    };
                    ?>
                </span>
            </div>
            <div style="display: flex;">
                <div class="contain" style="display: flex;">
                    <div id="container">
                        <img class="arrow_2" src="uploads/arrow.png" id="arrow" alt="arrow">
                        <div style="display: flex; margin-top: 100px;">
                            <div class="basket" id="basket"></div>
                            <div class="plate" id="plate"></div>
                            <div class="basket_plate" id="basket_plate" style="margin-left:90px; margin-top: 0px"></div>
                        </div>
                    </div>
                    <!-- em sửa lại ô button -->
                    <div class="box-phepTinh">
                        <div class="square" id="square1"><input type="text" class="inputt" id='inputt1' name='inputt1'
                                placeholder="?" required value="<?php if (isset($_POST['inputt1']) && $_POST['inputt1'] == $mang_rong[0]) {
echo $_POST['inputt1'];
}
?>">
                        </div>
                        <div class="square" id="square2"><input type="text" class="inputt2" id='inputt2' name='inputt2'
                                placeholder="?" required
                                value="<?php
                                                                                                                                                        if (isset($_POST['inputt2']) && $_POST['inputt2'] == $mang_rong[1]) {
                                                                                                                                                            echo $_POST['inputt2'];
                                                                                                                                                        }
                                                                                                                                                        ?>">
                        </div>
                        <div class="square" id="square3"><input type="text" class="inputt" id='inputt3' name='inputt3'
                                placeholder="?" required
                                value="<?php
                                                                                                                                                        if (isset($_POST['inputt3']) && $_POST['inputt3'] == $mang_rong[2]) {
                                                                                                                                                            echo $_POST['inputt3'];
                                                                                                                                                        }
                                                                                                                                                        ?>">
                        </div>
                        <div class="square" id="square4"><input type="text" class="inputt2" id='inputt4' name='inputt4'
                                placeholder="=" readonly></div>
                        <div class="square" id="square5"><input type="text" class="inputt" id='inputt5' name='inputt5'
                                placeholder="?" required
                                value="<?php
                                                                                                                                                        if (isset($_POST['inputt5']) && $_POST['inputt5'] == $mang_rong[4]) {
                                                                                                                                                            echo $_POST['inputt5'];
                                                                                                                                                        }
                                                                                                                                                        ?>">
                        </div>
                    </div>
                </div>

                <div id="contain_1">
                    <div id="contain_2">
                        <button type="button" class="btn button-1 button-red" id="check" name="btn_check"
                            onclick="checkAnswer()"><img src="./icon/check.png" style="width:30px; height:30px;">Kiểm
                            tra</button>
                        <button type="button" class="btn button-1 button-red" id="help" name='btn_hd' value="
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
                    </div>
                </div>
            </div>
            <div class="checkdungsai">
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
            </div>
        </div>
        <div id="notice-container">
            <div class='btn-div-notice'>
                <button type="button" id="tieptuclam" onclick="tieptuclam()"><i
                        class="fa-solid fa-pen-to-square"></i>Tiếp tục làm</button>
                <button type="button" id="xemdapan-button" onclick="xemdapan()"><i class="fa-solid fa-eye"></i>Xem lại
                    đáp án đúng</button>
            </div>
        </div>
        <span class='notice'>
        </span>

        <div class="help-container" id="helpcontain">
            <div id="bieuThuc" style=" font-family: Arial, sans-serif;
                                margin: 0;
                                box-sizing: border-box;
                                margin-bottom: 20px;
                                font-size: 30px;
                                font-weight: bold;
                                color: black;
                                background-color: bisque;
                                padding: 10px;
                                border-radius: 5px;
                                text-align: center;
                                box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3);
                                ">Tính: <?php echo $bieuThuc ?></div>
            <center>
                <div id="tableContainer"></div>
                <div id="support"></div>
                <div class="show-help"></div>
                <div id="legoContainer"></div>
                <div id="nuthotro"></div>
            </center>
            <div class='div-btn' id="backbutton">
                <button type="button" class="back-button" style="width:150px; height:50px;"><img src="./icon/trove.png"
                        style="width:30px; height:30px; margin-right: 5px; ">Trở về</button>
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
                if ('<?php echo $_SESSION['dang_bai'][1] ?>' == "-") {
                    document.getElementById('basket').style.display = "block";
                    document.getElementById('plate').style.display = "block";
                } else if ('<?php echo $_SESSION['dang_bai'][1] ?>' == "+") {
                    document.getElementById('basket_plate').style.display = "block";
                }
                document.getElementById('contain_1').style.paddingTop = "100px";
            });
            $('.notice-container button').click(function() {
                $(this).closest('.notice-container').removeClass('showNotice');
            });
        });
        console.log(<?php echo $id_loai_hien_thi; ?>)
        </script>
        </div>
        </div>
    </form>
    <?php
    $id_btuser = $_GET['id_bai_tap_user'];
    $kiem_tra = "SELECT * FROM `bai_tap_user` WHERE `id_bai_tap_user`=$id_btuser ORDER BY trang_thai DESC LIMIT 1;";
    $trangthai = mysqli_query($conn, $kiem_tra);
    $row = mysqli_fetch_assoc($trangthai);

    $kiem_tra_s = "SELECT * FROM `dap_an_nguoi_dung_d6k3` WHERE `id_bai_tap_user`= '$id_btuser' ORDER BY `dap_an_nguoi_dung_d6k3`.id_dap_an_nguoi_dung_d6k3 DESC LIMIT 4;";
    $trangthai_s = mysqli_query($conn, $kiem_tra_s);
    $rows = mysqli_fetch_assoc($trangthai_s);
    if (isset($rows) && isset($row)) {
        if ($row['trang_thai'] == "1") {
            echo "<script>
        document.getElementById('notice-container').style.display = 'block'
        document.getElementById('tieptuclam').style.display = 'none'
        document.getElementById('notice-container').classList.add('showNotice')
        document.getElementById('contain_2').style.display = 'none'
        </script>";
            $kiem_tra_s = "SELECT * FROM `dap_an_nguoi_dung_d6k3` WHERE `id_bai_tap_user`= '$id_btuser' ORDER BY id_dap_an_nguoi_dung_d6k3 DESC LIMIT 4;";
            $trangthai_s = mysqli_query($conn, $kiem_tra_s);
            $ketqua = [];
            while ($rows = mysqli_fetch_assoc($trangthai_s)) {
                array_push($ketqua, $rows['dap_an']);
            }
            $_SESSION['ketquadapan'] = $ketqua;
        } else if ($row['trang_thai'] == "0") {
            echo "<script>
            document.getElementById('notice-container').style.display = 'block'
            document.getElementById('xemdapan-button').style.display = 'none'
            document.getElementById('notice-container').classList.add('showNotice')
        </script>";
            $kiem_tra_s1 = "SELECT * FROM `dap_an_nguoi_dung_d6k3` WHERE `id_bai_tap_user`= '$id_btuser' ORDER BY `dap_an_nguoi_dung_d6k3`.id_dap_an_nguoi_dung_d6k3 DESC LIMIT 4;";
            $trangthai_s1 = mysqli_query($conn, $kiem_tra_s1);
            $ketqua1 = [];
            $mucdo1 = [];
            while ($rows = mysqli_fetch_assoc($trangthai_s1)) {
                array_push($ketqua1, $rows['dap_an']);
                array_push($mucdo1, $rows['stt_huong_dan']);
            }
            echo "<script>
            localStorage.setItem('mucdo', '{$mucdo1[0]}');
        </script>";
            $_SESSION['ketquadapan'] = $ketqua1;
        }
    }
    ?>
    <script>
    document.getElementById('xemdapan-button').addEventListener('click', function xemdapan() {
        <?php if (isset($_SESSION['ketquadapan']) && !empty($_SESSION['ketquadapan'])) { ?>
        document.getElementById('notice-container').style.display = 'none';
        document.getElementById('inputt1').value = "<?php echo $_SESSION['ketquadapan'][3]; ?>";
        document.getElementById('inputt2').value = "<?php echo $_SESSION['ketquadapan'][2]; ?>";
        document.getElementById('inputt3').value = "<?php echo $_SESSION['ketquadapan'][1]; ?>";
        document.getElementById('inputt5').value = "<?php echo $_SESSION['ketquadapan'][0]; ?>";
        <?php } ?>
    });

    document.getElementById('tieptuclam').addEventListener('click', function tieptuclam() {
        <?php if (isset($_SESSION['ketquadapan']) && !empty($_SESSION['ketquadapan'])) { ?>
        document.getElementById('notice-container').style.display = 'none';
        document.getElementById('inputt1').value = "<?php echo $_SESSION['ketquadapan'][3]; ?>";
        document.getElementById('inputt2').value = "<?php echo $_SESSION['ketquadapan'][2]; ?>";
        document.getElementById('inputt3').value = "<?php echo $_SESSION['ketquadapan'][1]; ?>";
        document.getElementById('inputt5').value = "<?php echo $_SESSION['ketquadapan'][0]; ?>";
        <?php } ?>
    })


    const btnHelp = document.querySelector('#help')
    const divHelp = document.querySelector('.help-container')
    const showHelp = document.querySelector('.show-help')
    btnHelp.addEventListener('click', help);
    let hasAnsweredOnce = false;
    let lesson = JSON.parse(localStorage.getItem('d6k3_baiDien')) || []
    const divbtnHelps = document.querySelector('#nuthotro')
    let arrHelp = convertStringToTriplets(btnHelp.value)

    let mySetKHT = new Set();
    arrHelp.forEach(u => {
        mySetKHT.add(u.kieuHoTro);
    })
    console.log(mySetKHT)

    function readButtonContent(buttonId) {
        var button = document.getElementById(buttonId);
        var buttonText = button.innerText;
        speakVietnamese(buttonText);
    }
    // begin 27/07/2024
    function speakVietnamese(text) {
        const apiUrl = 'https://api.fpt.ai/hmi/tts/v5';
        const apiKey = 'VDQwLGIpyKGagN0XwGPAM3p8R8QAVUsJ';
        const voice = localStorage.getItem('giong');
        const speed = localStorage.getItem('toc_do');

        console.log('g2222iong:', voice);
        console.log('td:', speed);

        var xhr = new XMLHttpRequest();
        xhr.open('POST', apiUrl, false); // false để thực hiện đồng bộ
        xhr.setRequestHeader('api-key', apiKey);
        xhr.setRequestHeader('speed', speed);
        xhr.setRequestHeader('voice', voice);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    var data = JSON.parse(xhr.responseText);
                    var audioUrl = data.async;
                    console.log('Audio URL:', audioUrl);

                    var audio = new Audio(audioUrl);
                    audio.play();
                    console.log('Đang phát âm thanh.');
                } else {
                    console.error('Có lỗi xảy ra khi phát âm thanh:', xhr.statusText);
                }
            }
        };

        xhr.send(text);
    }
    // en 27/07/2024
    // function speakVietnamese(randomNum) {
    //     return new Promise((resolve, reject) => {
    //         let msg = new SpeechSynthesisUtterance();
    //         msg.text = randomNum;
    //         msg.lang = 'vi-VN';

    //         // Thay đổi giọng nói và tốc độ
    //         msg.voice = speechSynthesis.getVoices().find(voice => voice.lang === 'vi-VN');
    //         msg.rate = 0.8; // Tốc độ mặc định là 1, giảm xuống để chậm hơn

    //         msg.onend = function (event) {
    //             resolve(); // Khi giọng nói kết thúc, giải quyết promise
    //         };

    //         window.speechSynthesis.speak(msg);
    //     });
    // }

    // Duyệt qua từng phần tử trong mySetKHT
    mySetKHT.forEach((u) => {
        var buttonLabel = '';
        var buttonText = '';

        // Xác định label và text cho từng button dựa trên giá trị của u
        switch (u) {
            case 22:
                buttonLabel = "Hỗ trợ hiểu đề";
                buttonImage = "./icon/hotro.png"; // Đường dẫn đến ảnh cho hỗ trợ này
                break;
            case 23:
                buttonLabel = "Hỗ trợ đọc hiểu cách tính";
                buttonImage = "./icon/dem.png"; // Đường dẫn đến ảnh cho hỗ trợ này
                break;
            case 24:
                buttonLabel = "Hỗ trợ hiển thị phép tính";
                buttonImage = "./icon/hienthipheptinh.png"; // Đường dẫn đến ảnh cho hỗ trợ này
                break;
            case 19:
                buttonLabel = "Hỗ trợ bằng tia số/bảng số";
                buttonImage = "./icon/toanhoc.png"; // Đường dẫn đến ảnh cho hỗ trợ này
                break;
            case 25:
                buttonLabel = "Hỗ trợ đọc kết quả";
                buttonImage = "./icon/ketqua.png"; // Đường dẫn đến ảnh cho hỗ trợ này
                break;
            default:
                break;
        }

        var buttonHTML = `<button type="button" style="width: 450px; height=50px;" class="btn kht hinhThucHelp" id="btn-kieuhotro${u}" onclick='daSuDung(${u})'>
                      <img src="${buttonImage}" alt="Image" style="width: 30px; height: 30px;">
                      ${buttonLabel} 
                  </button>`;


        // var speakerHTML = `<button type="button" class="speaker" onclick="readButtonContent('btn-kieuhotro${u}')"><img src="./icon/listen.png" alt="Image" style="width: 30px; height: 30px;"></button>`;
        var speakerHTML =
            `<button class="speaker" onclick="readButtonContent('btn-kieuhotro${u}')"><i class="fa-solid fa-hand-point-right"></i><i class="fa-solid fa-volume-high"></i></button>`;

        // Thêm button và loa vào divbtnHelps
        divbtnHelps.innerHTML += buttonHTML + " " + speakerHTML + "<br>";
    });

    function hiddenHelpdiv() {
        divHelp.classList.add('hidden')
        divHelp.classList.remove('show')
    }

    document.getElementById('backbutton').addEventListener('click', function back() {
        show();
    })

    function show() {
        document.getElementById('helpcontain').style.display = 'none';
        if ("<?php echo $_SESSION['dang_bai'][1] ?>" === "-") {
            document.getElementById('basket').style.display = "block";
            document.getElementById('plate').style.display = "block";
        } else {
            document.getElementById('basket_plate').style.display = "block";
        }
    }

    function daSuDung(u) {
        let index = 0

        let arrSo = arrCalculateFromString(lesson[index].bieuThuc)
        let nuthelp = document.querySelector(`#btn-kieuhotro${u}`);
        const showHelp = document.querySelector('.show-help')
        nuthelp.classList.add('tungSuDung');
        nuthelp.style.background = 'rgb(0, 229, 255)'
        lesson[index].suDungTroGiupMuc++
        bieuthuc = lesson[index].bieuThuc
        console.log(lesson);
        const result = arrHelp.filter(item => item.kieuHoTro === u);
        if (u == 22) {

            them_lu_vet("luu_vet", 1)
            if (result[0].kieuHoTroChiTiet == 16) {
                showdocde();
                if (localStorage.getItem('mucdo') < 1) {
                    localStorage.setItem('mucdo', 1);
                }
                if (lesson[index].mucHelp < 1) lesson[index].mucHelp = 1
                hiddenHelpdiv()
                show();
                document.getElementById('contain_1').style.paddingTop = "100px";
            }
        } else if (u == 23) {

            them_lu_vet("luu_vet", 3)
            if (result[0].kieuHoTroChiTiet == 17) {
                showdochinhanh();
                if (localStorage.getItem('mucdo') < 2) {
                    localStorage.setItem('mucdo', 2);
                }
                if (lesson[index].mucHelp < 2) lesson[index].mucHelp = 2
                hiddenHelpdiv()
                show();
                document.getElementById('contain_1').style.paddingTop = "100px";
            }
        } else if (u == 24) {

            them_lu_vet("luu_vet", 4)
            if (result[0].kieuHoTroChiTiet == 18) {
                showhiennoidung();
                if (localStorage.getItem('mucdo') < 3) {
                    localStorage.setItem('mucdo', 3);
                }
                if (lesson[index].mucHelp < 3) lesson[index].mucHelp = 3
                hiddenHelpdiv()
                show();
                document.getElementById('contain_1').style.paddingTop = "100px";
            }
        } else if (u == 25) {
            // console.log("u"+u);
            them_lu_vet("luu_vet", 7)
            if (result[0].kieuHoTroChiTiet == 19) {
                docketqua()
                if (localStorage.getItem('mucdo') < 5) {
                    localStorage.setItem('mucdo', 5);
                }
                if (lesson[index].mucHelp < 5) lesson[index].mucHelp = 5
                hiddenHelpdiv()
                show()
                document.getElementById('contain_1').style.paddingTop = "100px";
            }
        } else if (u == 19) {
            var shos = document.getElementsByClassName('show-help');
            for (var i = 0; i < shos.length; i++) {
                shos[i].style.display = 'block';
            }
            if (localStorage.getItem('mucdo') < 4) {
                localStorage.setItem('mucdo', 4);
            }
            showHelp.innerHTML = '';
            result.forEach(i => {
                if (i.kieuHoTroChiTiet == 11) {
                    // showHelp.innerHTML += `<button type="button" style="width: 400px" class="btn hinhThucHelp" id="help${u}" onclick="helpQuetinh('${bieuthuc}', ${index})">
                    // <img src="./icon/quetinh.png" alt="QueTinh Image" style="width: 50px; height: 50px;">
                    // Que tính
                    // </button><br>`;
                } else if (i.kieuHoTroChiTiet == 12) {
                    // showHelp.innerHTML += `<button type="button" style="width: 400px" class="btn hinhThucHelp" id="help${u}" onclick="generateLEGO('${bieuthuc}')">Lego</button><br>`;
                    // showHelp.innerHTML += `<button type="button" class="btn hinhThucHelp custom-button" id="help${u}" onclick="generateLEGO('${bieuthuc}')" style="width: 400px">
                    //         <img src="./icon/lego.png" alt="LEGO Image" style="width: 50px; height: 50px;">
                    //         Lego
                    //       </button><br>`;


                } else if (i.kieuHoTroChiTiet == 13) {
                    showHelp.innerHTML += `<button type="button" style="width: 400px" class="btn hinhThucHelp" id="help${u}" onclick="drawTable(${arrSo[0]}, ${arrSo[2]}, '${arrSo[1]}')">
                <img src="./icon/bangso.png" alt="BangSo Image" style="width: 50px; height: 50px;">
                Bảng số
                </button><br>`;
                } else if (i.kieuHoTroChiTiet == 14) {
                    showHelp.innerHTML += `<button type="button" style="width: 400px" class="btn hinhThucHelp" id="help${u}" onclick="helpTiaSo('${bieuthuc}')">
                <img src="./icon/tiaso.png" alt="TiaSo Image" style="width: 50px; height: 50px;">
                Tia số
                </button><br>`;
                }
            })
            divbtnHelps.style.display = 'none'
            if (lesson[index].mucHelp < 4 && u == 19) {
                lesson[index].mucHelp = 4
            }
        }
        if (loaihienthi == 3) upLocalStorage("d6k3_baiDien", lesson);
    }

    function help() {
        var shos = document.getElementsByClassName('show-help');
        for (var i = 0; i < shos.length; i++) {
            shos[i].style.display = 'none';
        }

        document.getElementById('tableContainer').style.display = 'none';
        document.getElementById('support').style.display = 'none';

        document.getElementById('helpcontain').style.position = 'fixed';
        document.getElementById('helpcontain').style.top = '13%'; // Điều chỉnh kích thước của top ở đây
        document.getElementById('helpcontain').style.display = 'block';

        document.getElementById('basket').style.display = "none";
        document.getElementById('plate').style.display = "none";
        document.getElementById('basket_plate').style.display = "none";

        console.log(2)
        divHelp.classList.add('show')
        divbtnHelps.style.display = 'block'
        showHelp.innerHTML = ''
    }

    function showdocde() {
        // them_lu_vet("luu_vet", 1);
        let deBai = document.querySelector('#debai').textContent;
        text = "Câu hỏi là " + deBai;
        speakVietnamese(text);
    }

    function showdochinhanh() {
        // them_lu_vet("luu_vet", 3);
        if ("<?php echo $_SESSION['dang_bai'][1] ?>" === "+") {
            text = "Trên hình, có hai đồ vật. Đồ vật thứ nhất có số lượng là" +
                <?php echo $_SESSION['dang_bai'][0]; ?> + "hình. Ta lấy thêm đồ vật thứ hai có số lượng là" +
                <?php echo $_SESSION['dang_bai'][2]; ?> + "hình. Vậy có tất cả là bao nhiêu";
            speakVietnamese(text);
        } else if ("<?php echo $_SESSION['dang_bai'][1]; ?>" === "-") {
            text = "Ở ô màu hồng phía bên trái, có " + <?php echo $_SESSION['dang_bai'][0]; ?> + " hình. Ta bỏ bớt " +
                <?php echo $_SESSION['dang_bai'][2]; ?> +
                " hình ở ô màu xanh phía bên phải. Vậy còn lại bao nhiêu hình";
            speakVietnamese(text);
        }
    }

    function docketqua() {
        // them_lu_vet("luu_vet", 7);
        text = "Phép tinh:" + <?php echo $_SESSION['dang_bai'][0]; ?> + <?php echo $_SESSION['dang_bai'][1]; ?> +
            <?php echo $_SESSION['dang_bai'][2]; ?> + "bằng" + <?php echo $_SESSION['dang_bai'][4]; ?>;
        speakVietnamese(text);
    }


    function showhiennoidung() {
        // them_lu_vet("luu_vet", 4);
        var dang_bai = <?php echo json_encode($_SESSION['dang_bai']); ?>; // Chuyển đổi PHP array sang JavaScript array
        document.getElementById('inputt1').value = dang_bai[0];
        document.getElementById('inputt2').value = dang_bai[1];
        document.getElementById('inputt3').value = dang_bai[2];
        // em thêm 3 dòng dưới
        document.getElementById('inputt1').style.boxShadow = "0 0 10px 10px lightgreen";
        document.getElementById('inputt2').style.boxShadow = "0 0 10px 10px lightgreen";
        document.getElementById('inputt3').style.boxShadow = "0 0 10px 10px lightgreen";
        document.getElementById('inputt1').style.border = "lightgreen";
        document.getElementById('inputt2').style.border = "lightgreen";
        document.getElementById('inputt3').style.border = "lightgreen";
        var msg_3 = new SpeechSynthesisUtterance();
        msg_3.text = "Phép tính đã điền phía dưới. Hãy tính toán để ra kết quả nhé";
        msg_3.lang = 'vi-VN';
        msg_3.volume = 1;
        msg_3.rate = 0.75;
        msg_3.pitch = 1.5;
        speakVietnamese(msg_3.text)
        // window.speechSynthesis.speak(msg_3);
    }

    function arrCalculateFromString(expression) {

        return expression.split(/([()+\-*/])/).filter(function(e) {
            return e.trim().length > 0;
        });
    }

    function upLocalStorage(key, value) {
        localStorage.setItem(key, JSON.stringify(value))
    }


    // Hàm tia số
    function helpTiaSo(bieuthuc) {
        them_lu_vet("luu_vet", 14)
        var shos = document.getElementsByClassName('show-help');
        for (var i = 0; i < shos.length; i++) {
            shos[i].style.display = 'block';
        }
        document.getElementById('support').style.display = 'block';
        document.getElementById('contain_1').style.paddingTop = '33px';
        var elements = document.getElementsByClassName('help-container');
        for (var i = 0; i < elements.length; i++) {
            elements[i].style.position = 'fixed';
            elements[i].style.top = '35%'; // Điều chỉnh kích thước của top ở đây
        }

        function tachBieuThuc(bieuThuc) {
            let phanTu = [];
            let soTam = '';
            for (let char of bieuThuc) {
                if (!isNaN(char)) {
                    soTam += char;
                } else {
                    if (soTam !== '') {
                        phanTu.push(soTam);
                        soTam = '';
                    }
                    phanTu.push(char);
                }
            }
            if (soTam !== '') {
                phanTu.push(soTam);
            }
            return phanTu;
        }


        showHelp.innerHTML = '';

        var support = document.getElementById('support');
        support.innerHTML = '';
        var arrSo = tachBieuThuc(bieuthuc);
        var firstNumber = parseInt(arrSo[0]);
        var dau = arrSo[1];
        var secondNumber = parseInt(arrSo[2]); //

        // console.log(firstNumber);
        // console.log(dau);
        // console.log(secondNumber);
        if (dau == '+') {
            var min = firstNumber;
            var max = firstNumber + secondNumber;

            // Tạo phần tử tia số
            var tiaSo = document.createElement('div');
            tiaSo.className = 'tia-so';
            tiaSo.style.width = 800 + 'px';
            support.appendChild(tiaSo);

            // mũi tên đầu tia số
            var arrow = document.createElement('div');
            arrow.className = 'arrow';
            tiaSo.appendChild(arrow);

            // Hiển thị các vạch và số trên tia số
            var step = 1; // Bước mặc định là 1
            for (var i = min; i <= max; i += step) {
                var tick = document.createElement("div");
                tick.className = "tick";
                tick.style.left = ((i - min) / (max - min) * 70 + 10) + "%";
                tiaSo.appendChild(tick);


            }
            var number = document.createElement("div");
            number.className = "number";
            number.style.left = "10%"; // Vị trí bắt đầu
            number.textContent = min;
            tiaSo.appendChild(number);

            var i = min + step; // Bắt đầu từ số thứ 2
            var interval = setInterval(function() {
                if (i <= max) {
                    var number = document.createElement("div");
                    number.className = "number";
                    number.style.left = ((i - min) / (max - min) * 70 + 10) + "%";
                    number.textContent = "?";
                    tiaSo.appendChild(number);
                    i += step;
                } else {
                    clearInterval(interval); // Dừng setInterval khi đã hiển thị hết các số
                }
            }, 3000);

            var count = max - min;

            // Tạo và hiển thị hình quả táo
            var tiaSoWidth = tiaSo.offsetWidth;
            var tickWidth = tiaSoWidth / (count + 1);

            function showApple(index) {
                if (index > count) return; // Điều kiện dừng đệ quy
                var apple = document.createElement("img");
                apple.src = "./src/image/1.png";
                apple.className = "apple";
                apple.style.left = (index * tickWidth - 80) + "px";
                tiaSo.appendChild(apple);
                setTimeout(function() {
                    showApple(index + 1); // Gọi đệ quy với index tăng lên
                }, 4000); // Thời gian delay giữa mỗi lần hiển thị hình ảnh (miliseconds)
            }

            showApple(1); // Bắt đầu đệ quy từ index 1

            // Tạo và hiển thị hình mũi tên
            var arrowWidth = arrow.offsetWidth;
            var arrowWidth = arrowWidth / (count + 1);

            function showArrow(index) {
                if (index > count) return; // Điều kiện dừng đệ quy
                var arrow = document.createElement("img");
                arrow.src = "./src/image/arrow_curve.png";
                arrow.className = "muiten";
                arrow.style.left = (index * tickWidth + 50) + "px";
                tiaSo.appendChild(arrow);
                setTimeout(function() {
                    showArrow(index + 1); // Gọi đệ quy với index tăng lên
                }, 4000); // Thời gian delay giữa mỗi lần hiển thị hình ảnh (miliseconds)
            }

            showArrow(1); // Bắt đầu đệ quy từ index 1
        } else {


            var max = firstNumber;
            var min = firstNumber - secondNumber;

            var tiaSo = document.createElement('div');
            tiaSo.className = 'tia-so';
            tiaSo.style.width = 800 + 'px';
            support.appendChild(tiaSo);

            // mũi tên đầu tia số
            var arrow = document.createElement('div');
            arrow.className = 'arrow';
            tiaSo.appendChild(arrow);

            // Hiển thị các vạch và số trên tia số
            var step = 1; // Bước mặc định là 1
            for (var i = min; i <= max; i += step) { // Bắt đầu từ max và giảm dần cho đến min
                var tick = document.createElement("div");
                tick.className = "tick";
                tick.style.left = ((max - i) / (max - min) * 70 + 10) + "%"; // Thay đổi cách tính toán vị trí
                tiaSo.appendChild(tick);

                // Tạo và hiển thị số
                var number = document.createElement("div");
                number.className = "number";
                number.style.left = ((i - min) / (max - min) * 70 + 10) + "%"; // Tính toán vị trí dựa trên min và max
                if (i === max) {
                    number.textContent = i;
                } else {
                    number.textContent = '?';
                }
                tiaSo.appendChild(number);
            }

            var count = max - min;
            var tiaSoWidth = tiaSo.offsetWidth;
            var tickWidth = tiaSoWidth / (count + 1);

            function showApple(index) {
                if (index > count) return; // Điều kiện dừng đệ quy
                var apple = document.createElement("img");
                apple.src = "./src/image/tru1.png";
                apple.className = "apple";
                apple.style.left = (index * tickWidth - 80) + "px";
                tiaSo.appendChild(apple);
                setTimeout(function() {
                    showApple(index + 1); // Gọi đệ quy với index tăng lên
                }); // Thời gian delay giữa mỗi lần hiển thị hình ảnh (miliseconds)
            }

            showApple(1); // Bắt đầu đệ quy từ index 1
            var arrowWidth = arrow.offsetWidth;
            var arrowWidth = arrowWidth / (count + 1);

            function showArrow(index) {
                if (index > count) return; // Điều kiện dừng đệ quy
                var arrow2 = document.createElement("img");
                arrow2.src = "./src/image/giam.png";
                arrow2.className = "muiten2";
                arrow2.style.left = (index * tickWidth + 50) + "px";
                tiaSo.appendChild(arrow2);
                setTimeout(function() {
                    showArrow(index + 1); // Gọi đệ quy với index tăng lên
                }); // Thời gian delay giữa mỗi lần hiển thị hình ảnh (miliseconds)
            }

            showArrow(1); // Bắt đầu đệ quy từ index 1
        }
    }

    // Hàm tạo bảng
    function drawTable(firstNumber, secondNumber, operation) {
        them_lu_vet("luu_vet", 13)
        var shos = document.getElementsByClassName('show-help');
        for (var i = 0; i < shos.length; i++) {
            shos[i].style.display = 'block';
        }

        document.getElementById('tableContainer').style.display = 'block';
        document.getElementById('contain_1').style.paddingTop = '33px';
        var elements = document.getElementsByClassName('help-container');
        for (var i = 0; i < elements.length; i++) {
            elements[i].style.position = 'fixed';
            elements[i].style.top = '35%'; // Điều chỉnh kích thước của top ở đây
        }

        console.log(firstNumber)
        showHelp.innerHTML = '';
        var container = document.getElementById('tableContainer');
        container.innerHTML = "";
        var table = document.createElement('table');
        var one = firstNumber;
        var two = secondNumber;
        var delta = firstNumber % 10;
        var tinh = one - delta;
        var tru = firstNumber;
        var so = 1;
        var tong = firstNumber + secondNumber;
        var sub = firstNumber - secondNumber;
        var sub_delta = sub % 10;
        var tinh_tru = sub - sub_delta;
        var tru_2 = secondNumber;

        for (var i = 0; i < 3; i++) {
            var row = document.createElement('tr');
            for (var j = 0; j < 10; j++) {
                if (operation == "+") {
                    var cell = document.createElement('td');
                    cell.className = tinh;
                    var div = document.createElement('div');
                    div.className = "bocso";
                    div.id = tinh;
                    div.textContent = tinh;
                    cell.appendChild(div);
                    row.appendChild(cell);


                    so++;
                    tru++;

                    tinh++;
                } else {
                    var cell = document.createElement('td');
                    cell.className = tinh;
                    var div = document.createElement('div');
                    div.className = "bocso";
                    div.id = tinh_tru;
                    div.textContent = tinh_tru;
                    cell.appendChild(div);
                    row.appendChild(cell);

                    tinh_tru++;
                }
            }
            table.appendChild(row);
        }
        container.appendChild(table);
        animateColor(one, two, operation);
    }

    // Hàm tạo hiệu ứng
    function animateColor(one, two, operation) {
        var cells = document.querySelectorAll('.bocso');
        var delay = 1000;
        var delayDecreaseFactor = 0.9;
        var counter = 0;
        var sum = one + two;
        var index = 1;
        var tru_2 = two;

        if (operation === "+") {
            cells.forEach(function(cell) {
                var id = parseInt(cell.textContent);
                if (id === one) {
                    cell.style.backgroundColor = 'lightpink';
                    cell.style.boxShadow = '0 0 10px 10px lightblue';
                }
                if (id > one && id <= sum) {
                    setTimeout(function() {
                        var speech = new SpeechSynthesisUtterance();
                        speech.lang = 'vi-VN';
                        speech.volume = 1;
                        speech.rate = 1;
                        speech.pitch = 1;
                        speech.text = "Cộng" + index;
                        cell.style.boxShadow = '-15px 0px 10px 5px lightblue';
                        cell.style.transform = 'translateX(4px)';
                        cell.style.transition = 'transform 0.3s ease';
                        cell.style.animation = 'moveRight 0.3s ease';
                        window.speechSynthesis.speak(speech);

                        var smallElement = document.createElement('div');
                        smallElement.className = 'small-element';
                        smallElement.textContent = "+" + index;
                        cell.appendChild(smallElement);

                        if (id === sum) {
                            // var speech_2 = new SpeechSynthesisUtterance();
                            // speech_2.lang = 'vi-VN';
                            // speech_2.volume = 1;
                            // speech_2.rate = 1;
                            // speech_2.pitch = 1;
                            // speech_2.text = "Đáp án là" + id;
                            cell.style.backgroundColor = 'red';
                            cell.style.border = '5px solid red';
                            // window.speechSynthesis.speak(speech_2);
                        } else {
                            var image = document.createElement('img');
                            image.className = 'img-above-number';
                            image.src = 'src/image/chan_gau.png';
                            image.style.transform = 'rotate(90deg)';
                            cell.appendChild(image);
                        }
                        index++;
                    }, delay * counter * 1.5);
                    counter++;
                }
            });
        } else if (operation === "-") {
            var reversedCells = Array.from(cells).reverse();
            var sub = one - two;

            reversedCells.forEach(function(cell) {
                var id = parseInt(cell.textContent);
                if (id === one) {
                    cell.style.backgroundColor = 'lightpink';
                    cell.style.boxShadow = '0 0 10px 10px lightblue';
                    cell.style.border = '5px solid lightpink';
                }

                if (id >= sub && id < one) {
                    setTimeout(function() {
                        var speech = new SpeechSynthesisUtterance();
                        speech.lang = 'vi-VN';
                        speech.volume = 1;
                        speech.rate = 1;
                        speech.pitch = 1;
                        speech.text = "Trừ" + index;
                        window.speechSynthesis.speak(speech);

                        cell.style.boxShadow = '15px 0px 10px 5px lightblue';
                        cell.style.transform = 'translateX(-4px)';
                        cell.style.transition = 'transform 0.3s ease';
                        cell.style.animation = 'moveLeft 0.3s ease';

                        var smallElement = document.createElement('div');
                        smallElement.className = 'small-element';
                        smallElement.textContent = "-" + index;
                        cell.appendChild(smallElement);



                        if (id === sub) {
                            // var speech_2 = new SpeechSynthesisUtterance();
                            // speech_2.lang = 'vi-VN';
                            // speech_2.volume = 1;
                            // speech_2.rate = 1;
                            // speech_2.pitch = 1;
                            // speech_2.text = "Đáp án là" + id;
                            cell.style.backgroundColor = 'red';
                            cell.style.border = '5px solid red';
                            // window.speechSynthesis.speak(speech_2);
                        } else {
                            var image = document.createElement('img');
                            image.className = 'img-above-number';
                            image.src = 'src/image/chan_gau.png';
                            image.style.transform = 'rotate(-90deg)';
                            cell.appendChild(image);
                        }
                        index++;
                    }, delay * counter * 1.5);
                    counter++;
                }
            });
        }
    }



    function convertStringToTriplets(inputString) {
        var triplets = [];

        var tripletsStr = inputString.split('/');

        for (var i = 0; i < tripletsStr.length; i++) {
            // Tách cặp số thành mảng con
            var triplet = tripletsStr[i].split('-');

            // Chuyển đổi cặp số thành dạng mảng và thêm vào mảng chính
            var num1 = parseInt(triplet[0]);
            var num2 = parseInt(triplet[1]);
            var num3 = parseInt(triplet[2]);
            let check = false
            // Kiểm tra nếu không phải là NaN
            if (!isNaN(num1) && !isNaN(num2) && !isNaN(num3)) {
                let obj = {
                    kieuHoTroChiTiet: num1,
                    kieuHoTro: num2,
                    stt: num3,
                    isCheck: false
                }
                triplets.push(obj);
            }
        }


        // Trả về mảng kết quả
        return triplets;
    }

    function findKieuHoTroChiTietByStt(arr, sttValue) {
        // Khởi tạo mảng kết quả
        var result = [];

        // Lặp qua mảng đầu vào
        for (var i = 0; i < arr.length; i++) {
            // Kiểm tra nếu trường "stt" bằng giá trị mong muốn
            if (arr[i].stt === sttValue) {
                // Thêm giá trị của trường "kieuHoTroChiTiet" vào mảng kết quả
                result.push(arr[i].kieuHoTroChiTiet);
            }
        }
        return result;
    }
    </script>


    <?php
    function show_anh($count, $count_2, $operation)
    {
        if ($operation === "-") {
            echo displayObjects($count, $count_2);
        } else if ($operation === "+") {
            echo displayObjects_sub($count, $count_2);
        }
    }

    show_anh($_SESSION['dang_bai'][0], $_SESSION['dang_bai'][2], $_SESSION['dang_bai'][1]);

    if (isset($_POST["quay_ve"])) {
        header("Location: in_cau_hoi.php?id_cau_hoi=$ham");
    }

    function embedAudio_dung($audioUrl)
    {
        return '<audio id="audioPlayer" controls autoplay><source src="' . $audioUrl . '" type="audio/mpeg"></audio>';
    }
    function displayObjects($count, $count_2)
    {
        $result = '';
        $result .= '<script>';
        $result .= 'var container = document.getElementById("basket");';
        $result .= 'var an = document.getElementById("basket_plate");';
        $result .= 'an.style.display = "none";';
        $result .= 'var width = container.clientWidth;';
        $result .= 'var height = container.clientHeight;';
        $result .= 'container.innerHTML = "";';
        $result .= 'for (var i = 0; i < ' . $count . '; i++) {';
        $result .= '    var img = document.createElement("img");';
        $result .= '    img.className = "";';
        $result .= '    img.src = "uploads/' .  $_SESSION['anh']['url_doi_tuong'] . '";';
        $result .= '    var centerX = width / 2;';
        $result .= '    var centerY = height / 2;';
        $result .= '    var radiusX = width / 2 - 100;';
        $result .= '    var radiusY = height / 2 - 100;';
        $result .= '    var angle = Math.random() * 2 * Math.PI;';
        $result .= '    var x = centerX + radiusX * Math.cos(angle);';
        $result .= '    var y = centerY + radiusY * Math.sin(angle);';
        $result .= '    var scale = 1.2;';
        $result .= '    var scaledWidth = 60 * scale;';
        $result .= '    var scaledHeight = 50 * scale;';
        $result .= '    img.style.width = scaledWidth + "px";';
        $result .= '    img.style.height = scaledHeight + "px";';
        $result .= '    img.style.left = (x - (scaledWidth / 2)) + "px";';
        $result .= '    img.style.top = (y - (scaledHeight / 2)) + "px";';
        $result .= '    container.appendChild(img);';
        $result .= '}';
        $result .= 'var containers = document.getElementById("plate");';
        $result .= 'var widths = containers.clientWidth;';
        $result .= 'var heights = containers.clientHeight;';
        $result .= 'containers.innerHTML = "";';
        $result .= 'for (var i = 0; i < ' . $count_2 . '; i++) {';
        $result .= '    var img = document.createElement("img");';
        $result .= '    img.className = "' . $_SESSION['anh']['url_doi_tuong'] . '";';
        $result .= '    img.src = "uploads/' .  $_SESSION['anh']['url_doi_tuong'] . '";';
        $result .= '    var centerX = width / 2;';
        $result .= '    var centerY = height / 2;';
        $result .= '    var radiusX = width / 2 - 100;';
        $result .= '    var radiusY = height / 2 - 100;';
        $result .= '    var angle = Math.random() * 2 * Math.PI;';
        $result .= '    var x = centerX + radiusX * Math.cos(angle);';
        $result .= '    var y = centerY + radiusY * Math.sin(angle);';
        $result .= '    var scale = 1.2;';
        $result .= '    var scaledWidth = 60 * scale;';
        $result .= '    var scaledHeight = 50 * scale;';
        $result .= '    img.style.width = scaledWidth + "px";';
        $result .= '    img.style.height = scaledHeight + "px";';
        $result .= '    img.style.left = (x - (scaledWidth / 2)) + "px";';
        $result .= '    img.style.top = (y - (scaledHeight / 2)) + "px";';
        $result .= '    containers.appendChild(img);';
        $result .= '}';
        $result .= '</script>';
        return $result;
    }

    function displayObjects_sub($count, $count_2)
    {
        $result = '';
        $result .= '<script>';
        $result .= 'var container = document.getElementById("basket_plate");';
        $result .= 'var an_1 = document.getElementById("basket");';
        $result .= 'var an_2 = document.getElementById("plate");';
        $result .= 'an_1.style.display = "none";';
        $result .= 'an_2.style.display = "none";';
        $result .= 'var an = document.getElementById("arrow");';
        $result .= 'an.style.display = "none";';
        $result .= 'var width = container.clientWidth;';
        $result .= 'var height = container.clientHeight;';
        $result .= 'var imagesHtml = "";';
        $result .= 'for (var i = 0; i < ' . $count . '; i++) {';
        $result .= '    var img = document.createElement("img");';
        $result .= '    img.className = "";';
        $result .= '    img.src = "uploads/' .  $_SESSION['anh']['url_doi_tuong'] . '";';
        $result .= '    var newWidth = 100;';
        $result .= '    var newHeight = 80;';
        $result .= '    img.style.width = newWidth + "px";';
        $result .= '    img.style.height = newHeight + "px";';
        $result .= '    var centerX = width / 2;';
        $result .= '    var centerY = height / 2;';
        $result .= '    var radiusX = width / 2 - 100;';
        $result .= '    var radiusY = height / 2 - 100;';
        $result .= '    var angle = Math.random() * 2 * Math.PI;';
        $result .= '    var x = centerX + radiusX * Math.cos(angle);';
        $result .= '    var y = centerY + radiusY * Math.sin(angle);';
        $result .= '    img.style.left = (x - (newWidth / 2)) + "px";';
        $result .= '    img.style.top = (y - (newHeight / 2)) + "px";';
        $result .= '    imagesHtml += img.outerHTML;';
        $result .= '}';
        $result .= 'imagesHtml += "<br>";';
        $result .= 'for (var i = 0; i < ' . $count_2 . '; i++) {';
        $result .= '    var img = document.createElement("img");';
        $result .= '    img.className = "' . $_SESSION['anh']['url_dung_do'] . '";';
        $result .= '    img.src = "uploads/' .  $_SESSION['anh']['url_dung_do'] . '";';
        $result .= '    var newWidth = 100;';
        $result .= '    var newHeight = 80;';
        $result .= '    img.style.width = newWidth + "px";';
        $result .= '    img.style.height = newHeight + "px";';
        $result .= '    var centerX = width / 2;';
        $result .= '    var centerY = height / 2;';
        $result .= '    var radiusX = width / 2 - 100;';
        $result .= '    var radiusY = height / 2 - 100;';
        $result .= '    var angle = Math.random() * 2 * Math.PI;';
        $result .= '    var x = centerX + radiusX * Math.cos(angle);';
        $result .= '    var y = centerY + radiusY * Math.sin(angle);';
        $result .= '    img.style.left = (x - (newWidth / 2)) + "px";';
        $result .= '    img.style.top = (y - (newHeight / 2)) + "px";';
        $result .= '    imagesHtml += img.outerHTML;';
        $result .= '}';
        $result .= 'container.innerHTML = imagesHtml;';
        $result .= '</script>';
        return $result;
    }
    ?>
    <script>
    function checkAnswer() {
        var dang_bai = <?php echo json_encode($_SESSION['dang_bai']); ?>;
        check(dang_bai[0], dang_bai[1], dang_bai[2], dang_bai[4]);

        function check(x, y, z, o) {

            var inputt1_value = document.getElementById('inputt1').value;
            var inputt2_value = document.getElementById('inputt2').value;
            var inputt3_value = document.getElementById('inputt3').value;
            var inputt5_value = document.getElementById('inputt5').value;

            var dataToSend = {
                dapanmot: inputt1_value,
                pheptinh: inputt2_value,
                dapanhai: inputt3_value,
                ketqua: inputt5_value
            };

            localStorage.setItem('dulieu', JSON.stringify(dataToSend));

            var dung_input1 = false;
            var dung_input2 = false;
            var dung_input3 = false;
            var dung_input5 = false;

            if (inputt1_value !== "" && x == inputt1_value) {
                dung_input1 = true;
            }

            if (inputt3_value !== "" && z == inputt3_value) {
                dung_input3 = true;
            }

            if (inputt2_value !== "" && y == inputt2_value) {
                dung_input2 = true;
            }

            if (inputt5_value !== "" && o == inputt5_value) {
                dung_input5 = true;
            }

            // Hàm tô màu
            function toMauDapAn(id, dung) {
                if (dung) {
                    document.getElementById(id).style.border = "2px solid lightgreen";
                    document.getElementById(id).style.boxShadow = "0 0 10px 10px lightgreen";
                } else {
                    document.getElementById(id).style.border = "2px solid lightcoral";
                    document.getElementById(id).style.boxShadow = "0 0 10px 10px lightcoral";
                }
            }

            // Gọi hàm tô màu
            toMauDapAn("inputt1", dung_input1);
            toMauDapAn("inputt2", dung_input2);
            toMauDapAn("inputt3", dung_input3);
            toMauDapAn("inputt5", dung_input5);

            // Phát âm thanh
            var audioUrl;
            if (inputt1_value === "" || inputt3_value === "" || inputt5_value === "" || inputt2_value === "" ||
                inputt2_value === "") {
                playAndHideVideoFalse();
            } else if (x == inputt1_value && z == inputt3_value && o == inputt5_value && y == inputt2_value) {
                playAndHideVideoTrue();
            } else {
                playAndHideVideoFalse();
            }
        }
    }

    function playAndHideVideoTrue() {
        var noticeTrue = document.querySelector('.Notice_True');
        var trueVideo = noticeTrue.querySelector('.trueVideo');
        var trueAudio = noticeTrue.querySelector('.trueAudio');

        noticeTrue.style.display = 'block';

        trueVideo.style.display = 'block';
        trueAudio.play();
        trueAudio.addEventListener('ended', function() {
            noticeTrue.style.display = 'none';
        });
    }

    function playAndHideVideoFalse() {
        var noticeFalse = document.querySelector('.Notice_False');
        var falseVideo = noticeFalse.querySelector('.falseVideo');
        var falseAudio = noticeFalse.querySelector('.falseAudio');

        noticeFalse.style.display = 'block';

        falseVideo.style.display = 'block';
        falseAudio.play();
        // Hide video and notice when it ends
        falseAudio.addEventListener('ended', function() {
            noticeFalse.style.display = 'none';
        });
    }

    document.addEventListener('DOMContentLoaded', function() {
        var videos = document.querySelectorAll('video');
        videos.forEach(function(video) {
            video.addEventListener('loadedmetadata', function() {
                this.controls = false;
            });
        });
    });

    $('#check').click(function() {
        var dataToSend = localStorage.getItem('dulieu');
        var local = localStorage.getItem('mucdo');
        var luu_vet1 = localStorage.getItem('luu_vet');
        $.ajax({
            url: 'file_database_d6k3.php',
            type: 'post',
            data: {
                hai: dataToSend,
                mucdo: local,
                luu_vet1: luu_vet1
            },
            success: function(response) {
                alert("Đã nộp bài");
            },
            error: function(xhr, status, error) {
                console.error(error);
            }
        });
    });

    function them_lu_vet(key, newValue) {
        // Bước 1: Lấy mảng hiện tại từ localStorage
        let currentArray = JSON.parse(localStorage.getItem(key));

        // Bước 2: Nếu mảng chưa tồn tại, tạo mảng mới
        if (!currentArray) {
            currentArray = [];
        }

        // Bước 3: Thêm giá trị mới vào mảng
        currentArray.push(newValue);

        // Bước 4: Lưu lại mảng đã cập nhật vào localStorage
        localStorage.setItem(key, JSON.stringify(currentArray));
    }
    </script>

</body>

</html>