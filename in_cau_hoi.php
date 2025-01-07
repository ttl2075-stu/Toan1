<?php
session_start();

include 'connectdb.php';
if (!isset($_SESSION['id_user'])) {
    header('Location: index.php');
    die();
}
$id_bai_tap_user = $_GET['id_bai_tap_user'];
echo $id_bai_tap_user;
cap_nhat_tg($id_bai_tap_user, 1);
$role = $_SESSION['quyen'];
$id_user = $_SESSION['id_user'];

//   $id_bai_hoc=$_GET['id_bai_hoc'];
// $id_user = $_GET['id_user'];
// $role = $_GET['role'];
$id_cau_hoi = $_GET['id_cau_hoi'];
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
    <title>Bài tập Dạng D6.K2</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./src/css/form.css">
    <link rel="stylesheet" href="./src/css/setting.css">
    <link rel="stylesheet" href="./src/css/button.css">
    <link rel="stylesheet" href="./src/css/d6k1_show.css">
    <link rel="stylesheet" href="./src/css/help.css">
    <link rel="stylesheet" href="./src/css/the.css">
    <link rel="stylesheet" href="./src/css/tia_so.css">
    <link rel="stylesheet" href="./src/css/help_bang.css">
    <link rel="stylesheet" href="./src/css/lego.css">
    <link rel="stylesheet" href="./src/css/d6k2.css">
    <link rel="stylesheet" href="./src/css/root.css">
    <link rel="stylesheet" href="./assets/css_v2/style.css">
    <link rel="stylesheet" href="./assets/css_v2/InCauHoi_php.css">
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
    <!-- <script>
        // Loại bỏ sự kiện beforeunload
        window.removeEventListener('beforeunload', function (e) {
            // Không làm gì cả sẽ ngăn chặn thông báo
        });

        // Đảm bảo rằng không có sự kiện beforeunload nào được thêm mới
        window.onbeforeunload = null;
    </script> -->
</head>
<style>
.con_vat_item .item input[type="text"],
.active-convat-box .item input[type="text"] {
    width: fit-content;
    width: 100px;
    height: 70px;
    border-radius: 5px;
    border: none;
    background-color: #f2f2f2;
    color: blue;
    font-weight: bolder;
    font-size: 35px;
}

.canh_dieu_item .item input[type="number"] {
    width: fit-content;
    top: 15%;
    left: 40%;
    transform: translateX(-50%);
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: none;
    background-color: rgba(255, 255, 255, 0.5);
    text-align: center;
    font-weight: bolder;
    font-size: 35px !important;
    color: black;
}

#debai {
    font-size: 30px;
}

#debais {
    font-size: 30px;
}

.div_btn {
    position: fixed;
    top: 70px;
    right: 45%;
    display: block;
}

.div_btn button {
    position: fixed;
    display: block;
    margin: 0 10px;
    /* Căn lề giữa các button */
    top: 70px;
    left: 10%;
}

.div_btn .back_button {
    position: fixed;
    display: block;
    margin: 0 10px;
    /* Căn lề giữa các button */
    top: 70px;
    left: 10%;
}

.div_btn .back_button {
    display: block;
    background-color: #007bff;
    color: white;
    padding: 12px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: transform 0.5s ease-in-out;
    font-weight: bold;
    font-size: 25px;
    margin-bottom: 10px;
}

.div_btn .back_button:hover {
    /* background-color: #0056b3;  */
    background-color: orangered;
    transform: translateY(-5px);
}

.container {
    display: flex;
    justify-content: space-around;
    align-items: center;
    position: relative;
    top: 100px;
    max-width: 100%;
    overflow-x: hidden;
}

#notice-container {
    position: fixed;
    top: 7%;
    left: 50%;
    transform: translateX(-50%);
    background-color: white;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0px 2px 8px 0px #1E97F3;
    /* display: none; */
    text-align: center;
    width: 100%;
    min-height: 550px;
    display: none;
}

.showNotice {
    display: block;
    position: absolute;
    width: 100%;
    background: white;
}

div.btn-div-notice {
    flex-direction: column;
    display: flex;
    justify-content: space-evenly;
    margin: 20% 10%;
    align-items: center;
}

div.btn-div-notice button {
    margin: 20px 0;
    max-width: 50%;
    min-width: 50%;
}

#trangthai1 {
    display: flex;
    top: 15px;
    flex-direction: row;
    justify-content: space-around;
    position: relative;
    background: #ffffff;
}


.special img {
    margin-top: 200px;
}

.pheptinh {
    font-size: 35px;
    color: blue;
    font-weight: bold;
    position: absolute;
    top: 140px;
    margin-left: 70px;
}

.dapan {
    font-size: 35px;
    color: black;
    font-weight: bold;
    position: absolute;
    top: 250px;
    margin-left: 70px;

}

#help {
    padding: 0px;
}

#help img {
    width: 50px;
    height: 50px;
}

.btn {
    /* background-color: #2da0fa;
    /* Màu nền */
    /* border: none;
    color: white; */
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
    /* width: 50px; */
}

#help img {
    width: 50px;
    /* Độ rộng của hình ảnh */
    margin-left: 5px;
    /* Khoảng cách giữa hình ảnh và văn bản */
}

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

<body>
    <?php
    // role=2&id_user=2&id_cau_hoi=35
    // $role = $_GET['role'];
    // $id_user = $_GET['id_user'];
    // echo "<a href='nhap_cau_hoi.php?role=$role&id_user=$id_user'>Trở về</a>";
    ?>

    <form action="" method="get">
        <?php
        // $conn = mysqli_connect('localhost', 'root', '', 'nckh_2024');

        // Kiểm tra kết nối
        if (!$conn) {
            die("Kết nối thất bại: " . mysqli_connect_error());
        }
        // Câu SQL lấy danh sách
        $sql = "SELECT * FROM `cau_hoi` WHERE `cau_hoi`.`id_cau_hoi`='$id_cau_hoi' ";
        $result1 = mysqli_query($conn, $sql);
        $row1 = mysqli_fetch_assoc($result1);

        // echo $row1['id_loai_hien_thi'];
        if ($row1['id_loai_hien_thi'] == 1) {
            $sql1 = "SELECT * FROM `dap_an_d6k1` WHERE `id_cau_hoi`='$id_cau_hoi'";
            // Thực thi câu truy vấn và gán vào $result
            $result1 = mysqli_query($conn, $sql);
            $row1 = mysqli_fetch_assoc($result1);
            echo "<div>
        <h1>Câu hỏi:  " . $row1['ten_cau_hoi'] . "</h1></div>";
            // echo "<br>";
            // echo "<img src='anh/".$row1['anh']."' alt='Ảnh bị lỗi'>"."<br>";
            // // Kiểm tra số lượng record trả về có lơn hơn 0
            // // Nếu lớn hơn tức là có kết quả, ngược lại sẽ không có kết quả
            $result2 = mysqli_query($conn, $sql1);
            if (mysqli_num_rows($result2) > 0) {
                // Sử dụng vòng lặp while để lặp kết quả
                while ($row2 = mysqli_fetch_assoc($result2)) {
                    // print_r($row2);
                    // echo "<br>";
                    if ($row2['flag'] == 1) {
                        echo "<input type='text' name='" . $row2['id_dap_an_multichoice'] . "' id=''>";
                    } else {
                        echo "<input type='text' name='" . $row2['id_dap_an_multichoice'] . "' value='" . $row2["ten_dap_an"] . "' id=''>";
                    }
                }
            } else {
                echo "Không có record nào";
            }
            echo "<input type='hidden' name='id_cau_hoi' value='$id_cau_hoi'>";
        ?>

        <!-- <input type="submit" name="btn" value="Nộp bài"> -->
    </form>

    <?php

        } elseif ($row1['id_loai_hien_thi'] == 2 || $row1['id_loai_hien_thi'] == 8) {
?>
    <div class="cauhoi">Câu hỏi:
        <span id="debais"> <?= $row1['ten_cau_hoi'] ?></span>
    </div>
    <div id="container">
        <?php
            $sqlCauHoi = "SELECT * FROM `dap_an_d6k2` WHERE `id_cau_hoi`='$id_cau_hoi' and `cot` = 0";
            // Thực thi câu truy vấn và gán vào $result
            $resultCauHoi = mysqli_query($conn, $sqlCauHoi);

            if (mysqli_num_rows($resultCauHoi) > 0) {
        ?>
        <div class="convat_1">
            <?php
                $rowSeparateCountCauHoi = ceil(mysqli_num_rows($resultCauHoi) / 2);
                // Lấy toàn bộ kết quả vào một mảng
                $rowsCauhoi = mysqli_fetch_all($resultCauHoi, MYSQLI_ASSOC);
                for ($i = 0; $i < $rowSeparateCountCauHoi; $i++) {
                    $row = $rowsCauhoi[$i];
                ?>
            <div class="con_vat_item" data-id="<?= $row['id_dap_d6k2'] ?>">
                <div class="item" id="id-<?= $row['id_dap_d6k2'] ?>">
                    <?php if ($row1['id_loai_hien_thi'] == 2) {
                            ?>
                    <img src="./anh/convat/<?= $row['url_anh'] ?>" alt="Con vật <?= $row['id_dap_d6k2'] ?>">
                    <input readonly="true" value="<?= $row['ten_dap_an'] ?>" type="text" placeholder="?">
                    <?php
                                                                                                                    } else {
                                                                                                                        ?>
                    <?php for ($i = 0; $i < $row['ten_dap_an']; $i++) {
                                ?><img src="./anh/convat/<?= $row['url_anh'] ?>"
                        alt="Con vật <?= $row['id_dap_d6k2'] ?>"><?php
                                                                                                                            } ?>

                    <input hidden readonly="true" value="<?= $row['ten_dap_an'] ?>" type="text" placeholder="?">
                    <?php
                                                                                                                            } ?>


                </div>
            </div>
            <?php
                }
                ?>
        </div>
        <?php
                $sqlDapAn = "SELECT * FROM `dap_an_d6k2` WHERE `id_cau_hoi`='$id_cau_hoi' and `cot` = 1";
                // Thực thi câu truy vấn và gán vào $result
                $resultDapAn = mysqli_query($conn, $sqlDapAn);

                if (mysqli_num_rows($resultDapAn) > 0) {
                    $rowSeparateCountDapAn = ceil(mysqli_num_rows($resultDapAn) / 2);
            ?>
        <div class="canhdieu_1">
            <?php
                    // Lấy toàn bộ kết quả vào một mảng
                    $rowsDapAn = mysqli_fetch_all($resultDapAn, MYSQLI_ASSOC);
                    for ($i = 0; $i < $rowSeparateCountDapAn; $i++) {
                        $row = $rowsDapAn[$i];
                    ?>
            <div class="canh_dieu_box" id="canh_dieu_box-<?= $row['id_dap_d6k2'] ?>">
                <div class="canh_dieu_item" data-id="<?= $row['id_dap_d6k2'] ?>">
                    <div class="item hh" draggable="true" id="box-<?= $row['id_dap_d6k2'] ?>">
                        <?php if ($row1['id_loai_hien_thi'] == 2) {
                                    ?><img src="./anh/canhdieu/<?= $row['url_anh'] ?>"
                            alt="Cánh diều <?= $row['id_dap_d6k2'] ?>"><?php
                                                                                                                                    } ?>

                        <input readonly="true" type="number" value="<?= $row['ten_dap_an'] ?>" placeholder="?">
                    </div>
                </div>
            </div>
            <?php
                    }
                    ?>
        </div>
        <div class="show-check-value-box">
            <input class="close-check-value-box-btn" type="button"></input>
            <img src="./icon/sai.png" alt="" class="show-check-value-box-error">
            <img src="./icon/dung.png" alt="" class="show-check-value-box-success">
        </div>
        <div class="canhdieu_2">
            <?php
                    for ($i = $rowSeparateCountDapAn; $i < mysqli_num_rows($resultDapAn); $i++) {
                        $row = $rowsDapAn[$i];
                    ?>
            <div class="canh_dieu_box" id="canh_dieu_box-<?= $row['id_dap_d6k2'] ?>">
                <div class="canh_dieu_item" data-id="<?= $row['id_dap_d6k2'] ?>">
                    <div class="item " draggable="true" id="box-<?= $row['id_dap_d6k2'] ?>">
                        <?php if ($row1['id_loai_hien_thi'] == 2) {
                                    ?><img src="./anh/canhdieu/<?= $row['url_anh'] ?>"
                            alt="Cánh diều <?= $row['id_dap_d6k2'] ?>">

                        <?php
                                    } ?>

                        <input readonly="true" type="number" value="<?= $row['ten_dap_an'] ?>" placeholder="?">
                    </div>
                </div>
            </div>
            <?php
                    } ?>
        </div>
        <?php
                } else {
                    echo "Không có record nào";
                }
            ?>
        <div class="convat_2">

            <?php
                for ($i = $rowSeparateCountCauHoi; $i < mysqli_num_rows($resultCauHoi); $i++) {
                    $row = $rowsCauhoi[$i];
                ?>
            <div class="con_vat_item" data-id="<?= $row['id_dap_d6k2'] ?>">
                <div class="item" id="id-<?= $row['id_dap_d6k2'] ?>">
                    <?php if ($row1['id_loai_hien_thi'] == 2) {
                            ?><img src="./anh/convat/<?= $row['url_anh'] ?>" alt="Con vật <?= $row['id_dap_d6k2'] ?>">
                    <input readonly="true" value="<?= $row['ten_dap_an'] ?>" type="text"
                        placeholder="?"><?php
                                                                                                                    } else {
                                                                                                                        for ($i = 0; $i < $row['ten_dap_an']; $i++) { ?>
                    <img src="./anh/convat/<?= $row['url_anh'] ?>"
                        alt="Con vật <?= $row['id_dap_d6k2'] ?>"><?php
                                                                                                                        }
                                                                                                                            ?>

                    <input hidden readonly="true" value="<?= $row['ten_dap_an'] ?>" type="text"
                        placeholder="?"><?php
                                                                                                                        } ?>

                </div>
            </div>

            <?php
                }
                ?>
        </div>
        <?php
            } else {
                echo "Không có record nào";
            }
        ?>
    </div>
    <!-- <button type="button" id="submit-btn"><i class="fa-solid fa-check-to-slot"></i>Kiểm tra bài tập</button> -->
    <!-- <span>Số lần sai: <span class="countFalse">0</span></span> -->
    <!-- <input type="button" name="btn" id="btnSubmitSendAns" value="Nộp bài"> -->
    <!-- <button type="button" class="back_button"><i class="fa-solid fa-backward"></i>Trở về</button> -->
    <div class="div_btn">
        <input type="button" name="btn button-red button-1" id="btnSubmitSendAns" value="Nộp bài">
    </div>

    <div class="active-convat-container">
        <div class="active-convat-package">
            <button class="close-active-box-btn" type="button"><i class="fa-solid fa-xmark"></i></button>
            <div class="active-convat-box">
            </div>
        </div>
        <button class="btn-support" type="button" id="help" value="
        <?php
            $sql = " SELECT * FROM `kieu_ho_tro_chi_tiet`
                INNER JOIN `ho_tro_hien_thi`
                WHERE `kieu_ho_tro_chi_tiet`.`id_kieu_ho_tro` = `ho_tro_hien_thi`.`id_kieu_ho_tro`
                AND `ho_tro_hien_thi`.`id_loai_hien_thi`= 2";
            $kq = mysqli_query($conn, $sql);
            while ($row = mysqli_fetch_assoc($kq)) {
                print_r($row['id_kieu_ho_tro_chi_tiet']);
                echo '-';
                print_r($row['id_kieu_ho_tro']);
                echo '-';
                print_r($row['stt']);
                echo '/';
            }

        ?>
        " type="button"><img src="./icon/support.png" style="margin-right: 10px;">Hỗ trợ</button>
    </div>

    <span id="notice0" style="color:#999999; font-size: 25px; font-weight: bold;"><span>
        </span></span>
    <audio src="./mp4/True.mp4" id="correct-audio"></audio>
    <audio src="./mp4/False.mp4" id="incorrect-audio"></audio>


    <div class="help-container">
        <div class="cauhoi">Câu hỏi:
            <span id="debai">
                <?php
                $sql = "SELECT ten_cau_hoi FROM `cau_hoi`  WHERE cau_hoi.id_cau_hoi = $id_cau_hoi";

                $a = mysqli_query($conn, $sql);

                while ($row = mysqli_fetch_assoc($a)) {
                    echo $row['ten_cau_hoi'];
                }
                ?>
            </span>
        </div>
        <center>
            <div class="nuthotro"></div>
            <div class="show-help"></div>
            <div id="tableContainer"></div>
            <div id="legoContainer"></div>
            <div id="support"></div>
        </center>
        <div class='div-btn'>
            <button type="button" class="back-button"><img src="./icon/trove.png"
                    style="width:30px; height:30px; margin-right: 5px; ">Trở về</button>
        </div>
    </div>
    <div id="notice-container">
        <div class='btn-div-notice'>
            <button type="button" id="tieptuclam" onclick="tieptuclam()"><i class="fa-solid fa-pen-to-square"></i>Tiếp
                tục làm</button>
            <button type="button" id="xemdapan-button" onclick="xemdapan()"><i class="fa-solid fa-eye"></i>Xem lại đáp
                án đúng</button>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
    const correctAudioEle = document.getElementById('correct-audio');
    const incorrectAudioEle = document.getElementById('incorrect-audio');
    const correctImgEle = document.querySelector('.show-check-value-box-success');
    const incorrectImgEle = document.querySelector('.show-check-value-box-error');

    // Bắt sự kiện khi âm thanh kết thúc
    correctAudioEle.addEventListener('ended', function() {
        // Ẩn thẻ <img> hiển thị kết quả đúng
        correctImgEle.classList.remove('active');
    });

    incorrectAudioEle.addEventListener('ended', function() {
        // Ẩn thẻ <img> hiển thị kết quả sai
        incorrectImgEle.classList.remove('active');
    });
    </script>
    <script>
    function goBack() {
        window.location.href = 'nhap_cau_hoi.php'; // Điều hướng trở về trang nhap_cau_hoi.php
    }
    localStorage.removeItem("selectedButtons");
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
    </script>
    <script src="./src/js/d6k2.js"></script>
    <!-- <script src="./src/js/help.js"></script>
    <script src="./src/js/function_help.js"></script> -->
    <!-- <script src="./src/js/the.js"></script> -->

    <script>
    const convats = document.querySelectorAll('.con_vat_item')
    const canh_dieus = document.querySelectorAll('.canh_dieu_item')
    const convatActiveContainer = document.querySelector('.active-convat-container')
    const convatActiveBox = document.querySelector('.active-convat-box')
    const closeActiveBoxBtn = document.querySelector('.close-active-box-btn')
    const supportBtn = document.querySelector('.btn-support')
    const urlGuiCauTraLoi = 'nhan_cau_tra_loi_d6k2.php'
    let prevConVatActive = null
    const showCheckValueBox = document.querySelector('.show-check-value-box')
    const closeCheckValueBoxBtn = document.querySelector('.close-check-value-box-btn')

    // reset localstorage
    Object.keys(localStorage).forEach(keyStorage => {
        if (keyStorage.includes('d6k2_baiDien')) {
            localStorage.removeItem(keyStorage)
        }
    })
    </script>

    <script>
    convats.forEach(convat => {
        convat.onclick = (e) => {
            convatActiveBox.innerHTML = ''
            prevConVatActive = convat.dataset.id

            // thêm vào localstorage
            let lessons = JSON.parse(localStorage.getItem('d6k2_baiDien')) || [];
            const bieuThuc = convat.querySelector('input[type="text"]').value
            if (lessons) {
                lessons = [{
                    bieuThuc: bieuThuc,
                    dapAn: "1",
                    mucHelp: 0,
                    suDungTroGiupMuc: 0
                }]
                localStorage.setItem('d6k2_baiDien', JSON.stringify(lessons))
                localStorage.setItem("idCauHoi", prevConVatActive);
            }
            convatActiveBox.appendChild(convat.querySelector('.item').cloneNode(true))
            convatActiveContainer.style = "display: flex"

            // thêm vào localstorage
            let lesson = localStorage.getItem(`d6k2_baiDien-${prevConVatActive}`)
            if (!lesson) {
                lesson = [{
                    bieuThuc: bieuThuc,
                    dapAn: "1",
                    mucHelp: 0,
                    suDungTroGiupMuc: 0
                }]
                localStorage.setItem(`d6k2_baiDien-${prevConVatActive}`, JSON.stringify(lesson))
            }
        }
    })
    closeActiveBoxBtn.onclick = () => {
        convatActiveContainer.style = "display: none"
        convats.forEach(convat => {
            if (convat.classList.contains('active')) {
                convat.classList.remove('active')
            }
        })
        document.querySelector(`.con_vat_item[data-id="${prevConVatActive}"]`)?.classList?.add('active')
    }
    // supportBtn.onclick = () => {
    //     helpD6k2(prevConVatActive)
    // }
    </script>
    <script>
    convats.forEach(convat => {
        convat.ondragover = allowDrop
        convat.ondrop = drop
    })

    canh_dieus.forEach(canhdieu => {
        canhdieu.ondragstart = drag
    })

    function allowDrop(ev) {
        ev.preventDefault();
    }

    function drag(ev) {
        ev.dataTransfer.setData("elemenetId", ev.currentTarget.querySelector('.item').id);
    }

    function drop(ev) {
        ev.preventDefault();
        var elemenetId = ev.dataTransfer.getData("elemenetId");

        const elemenetExist = ev.currentTarget.querySelector('.canh_dieu_item .item ')
        if (elemenetExist) {
            const canhDieuBox = document.querySelector(`.canh_dieu_box#canh_dieu_${elemenetExist.id}`)
            canhDieuBox.appendChild(elemenetExist.parentNode)
        }
        ev.currentTarget.appendChild(document.getElementById(elemenetId).parentNode);
    }

    document.getElementById('btnSubmitSendAns').addEventListener('click', function() {
        let isFalsed = false
        for (const convatItem of convats) {
            convatItem.style = "border: 1px solid #333"
            const inputPhepTinh = convatItem.querySelector('input[type="text"]')
            const inputKetQuaTemp = convatItem.querySelector('input[type="number"]')
            if (!inputKetQuaTemp) {
                alert("Bạn chưa điền hết các kết quả.")
                return
            }
            const calculateExpression = new Function(`return ${inputPhepTinh.value};`);
            const ketQua = calculateExpression();

            if (ketQua !== +inputKetQuaTemp.value) {
                if (!isFalsed) {
                    isFalsed = true
                }

                convatItem.style = "border: 5px solid red"
                continue
            }
            convatItem.style = "border: 5px solid green"
            convatItem.querySelector('.canh_dieu_item').ondragstart = (e) => {
                e.preventDefault()
            }
        }
        // nếu muốn gửi lên database
        // sendCauTraLoi()
        if (isFalsed) {
            incorrectAudioEle.play()
            showCheckValueBox.classList.add('active')
            showCheckValueBox.querySelector('.show-check-value-box-error').classList.add('active')
            showCheckValueBox.querySelector('.show-check-value-box-success').classList.remove('active')
        } else {
            correctAudioEle.play()
            showCheckValueBox.classList.add('active')
            showCheckValueBox.querySelector('.show-check-value-box-success').classList.add('active')
            showCheckValueBox.querySelector('.show-check-value-box-error').classList.remove('active')
        }
    });

    closeCheckValueBoxBtn.onclick = () => {
        showCheckValueBox.classList.remove('active')
    }

    const sendCauTraLoi = async () => {
        const cauTraLoi = {}; // Tạo object chứa các câu trả lời
        // Lặp qua từng phần tử convat để lấy câu trả lời và id của câu hỏi
        for (const convatItem of convats) {
            const inputPhepTinh = convatItem.querySelector('input[type="text"]');
            const inputKetQuaTemp = convatItem.querySelector('input[type="number"]');
            const canhDieuItem = convatItem.querySelector('.canh_dieu_item');
            // Lấy thông tin câu trả lời và id của câu hỏi
            const valuesLs = localStorage.getItem(`d6k2_baiDien-${convatItem.dataset.id}`);

            // Thêm dữ liệu vào object cauTraLoi
            cauTraLoi[convatItem.dataset.id] = {
                dapAn: canhDieuItem.dataset.id,
                stt: valuesLs ? JSON.parse(valuesLs)[0].suDungTroGiupMuc : 0
            };
        }

        // Lấy id_user từ phiên
        const id_user = "<?php echo $id_user ?>"; // Thay đổi cách lấy id_user tùy theo cách bạn đang sử dụng

        // Gửi dữ liệu lên server bằng Fetch API
        const muc_do = localStorage.getItem('mucdo_2');
        var luu_vet1 = localStorage.getItem('luu_vet');
        const formData = new FormData();
        formData.append('id_user', id_user); // Thêm id_user vào FormData
        formData.append('cauTraLoi', JSON.stringify(
            cauTraLoi)); // Chuyển object cauTraLoi thành chuỗi JSON và gửi lên server
        formData.append('idCauHoi', "<?php echo $row1['id_cau_hoi']; ?>"); // Gửi ID của câu hỏi
        formData.append('mucdo', muc_do)
        formData.append('luu_vet1', luu_vet1)
        const response = await fetch(
            'nhan_cau_tra_loi_d6k2.php', { // Gửi request POST đến nhan_cau_tra_loi_d6k2.php
                method: 'POST',
                body: formData, // Gửi dữ liệu form
            });
        const message = await response.json(); // Nhận kết quả từ server (ví dụ: thông báo lưu thành công)
        alert(message); // Hiển thị thông báo từ server
    };

    // Gán sự kiện click cho nút "Nộp bài"
    const btnSubmitSendAns = document.getElementById('btnSubmitSendAns');
    btnSubmitSendAns.onclick =
        sendCauTraLoi; // Khi click vào nút "Nộp bài", gọi hàm sendCauTraLoi để gửi dữ liệu lên server
    </script>

    <?php
    ?>

    </form>
    <?php

        }
?>

    <?php
// Lấy id loại hiển thị
$sql = "SELECT * FROM `cau_hoi` WHERE `id_cau_hoi`=$id_cau_hoi";
$kq = mysqli_query($conn, $sql);
$id_loai_hien_thi = mysqli_fetch_assoc($kq);
$id_loai_hien_thi = $id_loai_hien_thi['id_loai_hien_thi'];
// echo "Loại hiển thị:". $id_loai_hien_thi;


$sql = "SELECT * FROM `kieu_ho_tro_chi_tiet` INNER JOIN `ho_tro_hien_thi`  WHERE  `kieu_ho_tro_chi_tiet`.`id_kieu_ho_tro` = `ho_tro_hien_thi`.`id_kieu_ho_tro` AND `ho_tro_hien_thi`.`id_loai_hien_thi`=1 ORDER BY `stt`";
// $sql="SELECT * FROM `kieu_ho_tro_chi_tiet` INNER JOIN `ho_tro_hien_thi` WHERE `kieu_ho_tro_chi_tiet`.`id_kieu_ho_tro` = `ho_tro_hien_thi`.`id_kieu_ho_tro` AND `ho_tro_hien_thi`.`id_loai_hien_thi`=$id_loai_hien_thi ORDER BY `ho_tro_chi_tiet`.`stt`" ;
$kq = mysqli_query($conn, $sql);
// while ($row = mysqli_fetch_assoc($kq)) {
//     print_r($row['ten_kieu_ho_tro_chi_tiet']);
//     echo '<br>';
// }

$sql = " SELECT * FROM `kieu_ho_tro_chi_tiet` INNER JOIN `ho_tro_hien_thi` WHERE `kieu_ho_tro_chi_tiet`.`id_kieu_ho_tro` = `ho_tro_hien_thi`.`id_kieu_ho_tro` AND `ho_tro_hien_thi`.`id_loai_hien_thi`=$id_loai_hien_thi";
$kq = mysqli_query($conn, $sql);
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
if (isset($_GET['btn-support'])) {
    $id_kieu_ho_tro_chi_tiet = $_GET['loai'];

    $vt = tim_id($id_kieu_ho_tro_chi_tiet, $_SESSION['luu']) + 1;
    if ($vt < count($_SESSION['luu'])) {
        if (!in_array($_SESSION['luu'][$vt], $_SESSION['sl'])) {
            $_SESSION['sl'][] = $_SESSION['luu'][$vt];
        }
    }
}
?>

    <?php
$id_btuser = $_GET['id_bai_tap_user'];
$kiem_tra = "SELECT * FROM `bai_tap_user` WHERE `id_bai_tap_user`=$id_btuser ORDER BY trang_thai DESC LIMIT 1;";
$trangthai = mysqli_query($conn, $kiem_tra);
$row = mysqli_fetch_assoc($trangthai);

$kiem_tra_s = "SELECT * FROM `dap_an_nguoi_dung_d6k2` WHERE `id_bai_tap_user`= '$id_btuser' ORDER BY id_dap_an_nguoi_dung DESC";
$trangthai_s = mysqli_query($conn, $kiem_tra_s);
$rows = mysqli_fetch_assoc($trangthai_s);
if (isset($rows)) {
    if ($row['trang_thai'] == "1") {
        echo "<script>
            document.getElementById('tieptuclam').style.display = 'none'
            document.getElementById('notice-container').style.display = 'block'
            document.getElementById('notice-container').classList.add('showNotice')
            document.getElementById('container').style.display = 'none'
            document.getElementById('btnSubmitSendAns').style.display = 'none'
        </script>";

        echo "<style>
        
        </style>"
?>
    <div id="trangthai1">
        <?php

            $sql = "SELECT ten_dap_an, url_anh, flag, cot FROM dap_an_d6k2 WHERE id_cau_hoi = $id_cau_hoi";
            $result = $conn->query($sql);

            $answers_by_flag = [];
            $flag_counts = []; // Đếm số lần xuất hiện của mỗi flag

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $flag = $row["flag"];
                    $cot = $row["cot"];

                    // Đếm số lần xuất hiện của mỗi flag
                    if (!isset($flag_counts[$flag])) {
                        $flag_counts[$flag] = 1;
                    } else {
                        $flag_counts[$flag]++;
                    }

                    // Tạo một mảng kết hợp chứa câu trả lời và URL hình ảnh, tổ chức theo flag và cot
                    $answers_by_flag[$flag][$cot][] = array(
                        'ten_dap_an' => $row["ten_dap_an"],
                        'url_anh' => $row["url_anh"]
                    );
                }
            }

            foreach ($answers_by_flag as $flag => $answers) {
                // Kiểm tra xem flag xuất hiện chỉ một lần không
                $is_single_flag = ($flag_counts[$flag] === 1);

                // Tạo style cho div chứa các câu trả lời
                $div_style = "";
                if (!$is_single_flag) {
                    $div_style = "background: #b3e3f7; margin-left: 20px; border: 7px solid green; border-radius: 20px;";
                }

                echo "<div class='flag_$flag' style='$div_style'>";
                foreach ($answers as $cot => $answers_of_cot) {
                    foreach ($answers_of_cot as $answer) {
                        if ($cot == 0) {
                            echo "<div class='anh1'>";
                            // Áp dụng margin-top cho img nếu flag xuất hiện chỉ một lần
                            $img_style = $is_single_flag ? "style='margin-top: 200px !important;'" : "";
                            echo "<img width='200px' height='200px' src='./anh/convat/{$answer['url_anh']}' alt='Ảnh' $img_style>";
                            echo "<div class='pheptinh'>{$answer['ten_dap_an']}</div>";
                            echo "</div>";
                        } else {
                            echo "<div class='anh2'>";
                            echo "<div class='dapan'>{$answer['ten_dap_an']}</div>";
                            echo "<img width='200px' height='200px' src='./anh/canhdieu/{$answer['url_anh']}' alt='Ảnh'>";
                            echo "</div>";
                        }
                    }
                }
                echo "</div>";
            }

            // Nhúng đoạn mã JavaScript chỉ khi flag xuất hiện đúng một lần
            foreach ($flag_counts as $flag => $count) {
                if ($count == 1) {
                    echo "<script>
            document.querySelectorAll('.flag_$flag').forEach(element => {
                element.classList.add('special');
            });
        </script>";
                }
            }

            ?>

    </div>
    <?php
        echo "<script>
    document.getElementById('trangthai1').style.display = 'none';
</script>";
    } else if ($row['trang_thai'] == "0") {
        // echo $row['trang_thai'];

        echo "<script>
            
            // document.getElementById('notice-container').classList.add('showNotice')
        </script>";

        $kiem_tra_s1 = "SELECT * FROM `dap_an_nguoi_dung_d6k2` WHERE `id_bai_tap_user`= '$id_btuser' ORDER BY `dap_an_nguoi_dung_d6k2`.`stt_huong_dan` DESC;";
        $trangthai_s1 = mysqli_query($conn, $kiem_tra_s1);
        $mucdo1 = [];
        while ($row4s = mysqli_fetch_assoc($trangthai_s1)) {
            array_push($mucdo1, $row4s['stt_huong_dan']);
        }
        echo "<script>
            localStorage.setItem('mucdo_2', '{$mucdo1[0]}');
        </script>";
        // print_r($mucdo1);

    }
}
?>
    <script>
    document.getElementById('xemdapan-button').addEventListener('click', function xemdapan() {
        document.getElementById('notice-container').style.display = 'none'
        document.getElementById('trangthai1').style.display = 'block'
        document.getElementById('trangthai1').style.display = 'flex';
    })

    document.getElementById('tieptuclam').addEventListener('click', function tieptuclam() {
        document.getElementById('notice-container').style.display = 'none'
    })
    </script>

</body>

</html>