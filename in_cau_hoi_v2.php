<?php
session_start();

  include 'connectdb.php';
  if(!isset($_SESSION['id_user'])){
      header('Location: index.php');
      die();
  }
    
date_default_timezone_set('Asia/Ho_Chi_Minh');
  $role=$_SESSION['quyen'];
  $id_user = $_SESSION['id_user'];

//   $id_bai_hoc=$_GET['id_bai_hoc'];
  // $id_user = $_GET['id_user'];
  // $role = $_GET['role'];
  $id_bai_tap_user = $_GET['id_bai_tap_user'];
    $id_cau_hoi = $_GET['id_cau_hoi'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài tập Dạng D6.K2</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400&display=swap" rel="stylesheet">
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
    <link rel="stylesheet" href="./src/css/d6k2.css">
    <link rel="stylesheet" href="./src/css/root.css">
    <script src="./src/js/function.js"></script>
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

/* .canh_dieu_item .item img{
    width: 300px;
    height: 300px;
} */

.canh_dieu_item .item input[type="number"] {
    width: fit-content;
    top: 15%;
    /* Điều chỉnh vị trí cho cánh diều */
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
    /* opacity: 0.5; */
}
#debai{
    font-size: 30px;
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

            <input type="submit" name="btn" value="Nộp bài">
    </form>

<?php

        } elseif ($row1['id_loai_hien_thi'] == 2) {
?>
    <div>
        <h1>Câu hỏi: <?= $row1['ten_cau_hoi'] ?></h1>
    </div>
    <div class="container">
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
                            <img src="./anh/convat/<?= $row['url_anh'] ?>" alt="Con vật <?= $row['id_dap_d6k2'] ?>">
                            <input readonly="true" value="<?= $row['ten_dap_an'] ?>" type="text" placeholder="?">
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
                                <div class="item " draggable="true" id="box-<?= $row['id_dap_d6k2'] ?>">
                                    <img src="./anh/canhdieu/<?= $row['url_anh'] ?>" alt="Cánh diều <?= $row['id_dap_d6k2'] ?>">
                                    <input readonly="true" type="number" value="<?= $row['ten_dap_an'] ?>" placeholder="?">
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="show-check-value-box">
                    <button class="close-check-value-box-btn" type="button"><i class="fa-solid fa-xmark"></i></button>
                    <img src="./anh/incorrect.png" alt="" class="show-check-value-box-error">
                    <img src="./anh/correct.png" alt="" class="show-check-value-box-success">
                </div>
                <div class="canhdieu_2">
                    <?php
                    for ($i = $rowSeparateCountDapAn; $i < mysqli_num_rows($resultDapAn); $i++) {
                        $row = $rowsDapAn[$i];
                    ?>
                        <div class="canh_dieu_box" id="canh_dieu_box-<?= $row['id_dap_d6k2'] ?>">
                            <div class="canh_dieu_item" data-id="<?= $row['id_dap_d6k2'] ?>">
                                <div class="item " draggable="true" id="box-<?= $row['id_dap_d6k2'] ?>">
                                    <img src="./anh/canhdieu/<?= $row['url_anh'] ?>" alt="Cánh diều <?= $row['id_dap_d6k2'] ?>">
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
                            <img src="./anh/convat/<?= $row['url_anh'] ?>" alt="Con vật <?= $row['id_dap_d6k2'] ?>">
                            <input readonly="true" value="<?= $row['ten_dap_an'] ?>" type="text" placeholder="?">
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
    <button style="margin-bottom: 50%;" type="button" id="submit-btn"><i class="fa-solid fa-check-to-slot"></i>Kiểm tra bài tập</button>
    <!-- <span>Số lần sai: <span class="countFalse">0</span></span> -->
    <!-- <input type="button" name="btn" id="btnSubmitSendAns" value="Nộp bài"> -->

    <div class="active-convat-container">
        <div class="active-convat-package">
            <button class="close-active-box-btn" type="button"><i class="fa-solid fa-xmark"></i></button>
            <div class="active-convat-box">
            </div>
        </div>
        <button class="btn-support" value="
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
        " type="button"><i class="fa-solid fa-lightbulb"></i>Hỗ trợ</button>
    </div>

    <span id="notice0" style="color:#999999; font-size: 25px; font-weight: bold;"><span>
        </span></span>
    <audio src="./audio/correct.mp3" id="correct-audio"></audio>
    <audio src="./audio/incorrect.mp3" id="incorrect-audio"></audio>

    <div class="help-container">
    <div class="cauhoi">Câu hỏi:  
                <span id="debai"> 
                        <?php 
                            $sql ="SELECT ten_cau_hoi FROM `cau_hoi` WHERE cau_hoi.id_cau_hoi = $id_cau_hoi";
                            $a = mysqli_query($conn, $sql);
                            while($row = mysqli_fetch_assoc($a)){
                                echo $row['ten_cau_hoi'];

                            };
                        ?>
                </span>           
            </div>
        <center>
            <div class="show-help"></div>
            <div id="tableContainer"></div>
            <div id="legoContainer"></div>
            <div id="support"></div>
        </center>
        <div class='div-btn'>
            <button type="button" class="back-button"><i class="fa-solid fa-backward"></i>Trở về</button>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.help-container button').click(function() {
                $(this).closest('.help-container').removeClass('show');
                $('#tableContainer').empty();
                $('#legoContainer').empty();
                $('#support').empty();
                $('.show-help').empty();
            });
        });
    </script>
    <script src="./src/js/d6k2.js"></script>
    <script src="./src/js/help.js"></script>
    <script src="./src/js/function_help.js"></script>
    <script src="./src/js/the.js"></script>

    <script>
        const convats = document.querySelectorAll('.con_vat_item')
        const canh_dieus = document.querySelectorAll('.canh_dieu_item')
        const convatActiveContainer = document.querySelector('.active-convat-container')
        const convatActiveBox = document.querySelector('.active-convat-box')
        const closeActiveBoxBtn = document.querySelector('.close-active-box-btn')
        const supportBtn = document.querySelector('.btn-support')
        const urlGuiCauTraLoi = 'nhan_cau_tra_loi_d6k2.php'
        let prevConVatActive = null
        const correctAudioEle = document.getElementById('correct-audio')
        const incorrectAudioEle = document.getElementById('incorrect-audio')
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
                convatActiveBox.appendChild(convat.querySelector('.item').cloneNode(true))
                convatActiveContainer.style = "display: flex"
                prevConVatActive = convat.dataset.id

                // thêm vào localstorage
                let lesson = localStorage.getItem(`d6k2_baiDien-${prevConVatActive}`)
                const bieuThuc = convat.querySelector('input[type="text"]').value
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

        supportBtn.onclick = () => {
            helpD6k2(prevConVatActive)
        }
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

        document.getElementById('submit-btn').addEventListener('click', function() {
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
            console.log('check');
            const cauTraLoi = {}
            for (const convatItem of convats) {
                const inputPhepTinh = convatItem.querySelector('input[type="text"]')
                const inputKetQuaTemp = convatItem.querySelector('input[type="number"]')
                if (!inputKetQuaTemp) {
                    alert("Bạn chưa điền hết các kết quả.")
                    return
                }
                const canhDieuItem = convatItem.querySelector('.canh_dieu_item')
                const valuesLs = localStorage.getItem(`d6k2_baiDien-${convatItem.dataset.id}`)
                cauTraLoi[convatItem.dataset.id] = {
                    dapAn: canhDieuItem.dataset.id,
                    stt: valuesLs ? JSON.parse(valuesLs)[0].suDungTroGiupMuc : 0
                }
            }
            // id_bai_tap_user
            const formData = new FormData()
            formData.append('cauTraLoi', JSON.stringify(cauTraLoi));
            formData.append('idCauHoi', "<?= $row1['id_cau_hoi'] ?>");
            formData.append('id_user', "<?= $id_user  ?>");
            const response = await fetch(urlGuiCauTraLoi, {
                method: 'POST',
                body: formData
            })
            const message = await response.json()
            alert(message)
        }

        const btnSubmitSendAns = document.getElementById('btnSubmitSendAns')
        btnSubmitSendAns.onclick = sendCauTraLoi
    </script>
    <?php
    ?>

    </form>
<?php

        }
?>


<!-- <h1>Liệt kê list hướng dẫn</h1> -->

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
if (isset($_GET['btn_hd'])) {
    $id_kieu_ho_tro_chi_tiet = $_GET['loai'];

    $vt = tim_id($id_kieu_ho_tro_chi_tiet, $_SESSION['luu']) + 1;
    if ($vt < count($_SESSION['luu'])) {
        if (!in_array($_SESSION['luu'][$vt], $_SESSION['sl'])) {
            $_SESSION['sl'][] = $_SESSION['luu'][$vt];
        }
    }

    // test case
    if ($id_kieu_ho_tro_chi_tiet == 1) {
        echo "Dạng: Hỗ trợ học sinh hiểu đề";
    } elseif ($id_kieu_ho_tro_chi_tiet == 2) {
        echo "Dạng: Thực hiện thao tác tính toán với các hàng";
    } elseif ($id_kieu_ho_tro_chi_tiet == 3) {
        echo "Dạng: Bảng số";
    } elseif ($id_kieu_ho_tro_chi_tiet == 4) {
        echo "Dạng: Tia số";
    } elseif ($id_kieu_ho_tro_chi_tiet == 5) {
        echo "Dạng: Que tính";
    } elseif ($id_kieu_ho_tro_chi_tiet == 6) {
        echo "Dạng: Lego";
    } elseif ($id_kieu_ho_tro_chi_tiet == 7) {
        echo "Dạng: Hỗ trợ đọc kết quả";
    } elseif ($id_kieu_ho_tro_chi_tiet == 8) {
        echo "Dạng: Lược bỏ dữ loại một phép tính để tập chung thao tác tính";
    } elseif ($id_kieu_ho_tro_chi_tiet == 9) {
        echo "Dạng: Thực hiện hỗ trợ đặt tính";
    } elseif ($id_kieu_ho_tro_chi_tiet == 10) {
        echo "Dạng: Đọc yêu cầu đề bài ";
    } else {
        echo "Chưa chọn hỗ trợ";
    }
}
?>


</body>

</html>