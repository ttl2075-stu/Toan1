<?php
session_start();
$id_cau_hoi = $_GET['id_cau_hoi'];

// $_SESSION['sl_hd']=0;
// Xóa hết session

// if(!isset($_SESSION['sl'])){
//     //session_start();
//     $_SESSION['sl'][]=0;
// }

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .container {
      display: flex;
      justify-content: space-around;
      align-items: center;
      position: relative;
    }

    .convat {
      display: flex;
      justify-content: space-between;
      width: 40%;
      /* Điều chỉnh độ rộng của phần con vật */
    }

    .canh_dieu {
      display: flex;
      justify-content: space-between;
      width: 40%;
      /* Điều chỉnh độ rộng của phần cánh diều */
    }

    .item {
      margin: 10px;
      position: relative;
    }

    .item img {
      width: 350px;
      height: 350px;
      /* max-width: 100%; */
    }

    .item input[type="number"],
    .item input[type="text"] {
      position: absolute;
      top: 60%;
      /* Điều chỉnh vị trí cho con vật */
      left: 50%;
      transform: translateX(-50%);
      font-weight: bold;
      text-align: center;
    }

    .convat_1 .item input[type="text"],
    .convat_2 .item input[type="text"] {
      width: 185px;
      height: 100px;
      border-radius: 5px;
      border: none;
      background-color: #f2f2f2;
      color: blue;
      font-weight: bolder;
      font-size: 60px;
    }



    .canh_dieu_item .item input[type="number"] {
        top: 15%;
        /* Điều chỉnh vị trí cho cánh diều */
        left: 40%;
        transform: translateX(-50%);
        width: 80px;
        height: 80px;
        border-radius: 50%;
        border: none;
        background-color: rgba(255, 255, 255, 0.5);
        text-align: center;
        font-weight: bolder;
        font-size: 60px;
        color: black;
        /* opacity: 0.5; */
    }

    .con_vat_item {
      border: 1px solid gray;
      margin-top: 4px;
    }

    #submit-btn {
      margin-top: 20px;
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
      background-color: #4CAF50;
      color: white;
      border: none;
      border-radius: 5px;
    }
    
    </style>
</head>

<body>
    <a href="1.php">Trở về</a>
    <form action="" method="get">
        <?php
        $conn = mysqli_connect('localhost', 'root', '', 'nckh_2024');

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
            echo "<br>";
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
    <!-- <h1>Liệt kê list hướng dẫn</h1> -->
    <!-- Liệt kê danh sách hướng dẫn -->

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
                } 
                else {
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
            } 
            else {
                echo "Không có record nào";
            }
        ?>
    </div>
    <button type="button" id="submit-btn">OK</button>
    <!-- <span>Số lần sai: <span class="countFalse">0</span></span> -->
    <input type="button" name="btn" id="btnSubmitSendAns" value="Nộp bài">
    <script>
        const convats = document.querySelectorAll('.con_vat_item')
        const canh_dieus = document.querySelectorAll('.canh_dieu_item')
        const countFalseEle = document.querySelector('.countFalse')
        const urlGuiCauTraLoi = 'nhan_cau_tra_loi_d6k2.php'

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
            console.log(document.getElementById(elemenetId).parentNode);
            const elemenetExist = ev.currentTarget.querySelector('.canh_dieu_item .item ')
            if (elemenetExist) {
                const canhDieuBox = document.querySelector(`.canh_dieu_box#canh_dieu_${elemenetExist.id}`)
                canhDieuBox.appendChild(elemenetExist.parentNode)
            }
            ev.currentTarget.appendChild(document.getElementById(elemenetId).parentNode);
        }

        document.getElementById('submit-btn').addEventListener('click', function() {
            let countFalse = localStorage.getItem('CountFalse') ?? 0
            let isFalsed = false
            for (const convatItem of convats) {
                const inputPhepTinh = convatItem.querySelector('input[type="text"]')
                const inputKetQuaTemp = convatItem.querySelector('input[type="number"]')
                if (!inputKetQuaTemp) {
                    alert("Bạn chưa điền hết các kết quả.")
                    return
                }
                const calculateExpression = new Function(`return ${inputPhepTinh.value};`);
                const ketQua = calculateExpression();
                console.log("is", isFalsed);
                if (ketQua !== +inputKetQuaTemp.value) {
                    if (!isFalsed) {
                        isFalsed = true
                    }

                    convatItem.style = "border: 5px solid red"
                    continue
                }
                convatItem.style = "border: 5px solid green"
            }
            // nếu muốn gửi lên database
            // sendCauTraLoi()
            if (isFalsed) {
                countFalse++
                alert("Bạn tính chưa đúng");
            } else {
                countFalse = 0
                alert("Bạn đã tính đúng");
            }
            localStorage.setItem('CountFalse', countFalse)
            countFalseEle.innerText = countFalse
        });

        const sendCauTraLoi = async () => {
            const cauTraLoi = {}
            for (const convatItem of convats) {
                const inputPhepTinh = convatItem.querySelector('input[type="text"]')
                const inputKetQuaTemp = convatItem.querySelector('input[type="number"]')
                if (!inputKetQuaTemp) {
                    alert("Bạn chưa điền hết các kết quả.")
                    return
                }
                const canhDieuItem = convatItem.querySelector('.canh_dieu_item')
                cauTraLoi[convatItem.dataset.id] = canhDieuItem.dataset.id
            }
            const formData = new FormData()
            formData.append('cauTraLoi', JSON.stringify(cauTraLoi));
            formData.append('idCauHoi', "<?= $row1['id_cau_hoi'] ?>");
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

<!-- Liệt kê danh sách hướng dẫn -->
<h1>Liệt kê list hướng dẫn</h1>

<?php
// Lấy id loại hiển thị
$sql = "SELECT * FROM `cau_hoi` WHERE `id_cau_hoi`=$id_cau_hoi";
$kq = mysqli_query($conn, $sql);
$id_loai_hien_thi = mysqli_fetch_assoc($kq);
$id_loai_hien_thi = $id_loai_hien_thi['id_loai_hien_thi'];
// echo "Loại hiển thị:". $id_loai_hien_thi;

// $sql="SELECT * FROM `kieu_ho_tro_chi_tiet` INNER JOIN `ho_tro_hien_thi` WHERE `kieu_ho_tro_chi_tiet`.`id_kieu_ho_tro` = `ho_tro_hien_thi`.`id_kieu_ho_tro` AND `ho_tro_hien_thi`.`id_loai_hien_thi`=$id_loai_hien_thi";
// $kq=mysqli_query($conn,$sql);
// $row=mysqli_fetch_assoc($kq);
$sql = "SELECT * FROM `kieu_ho_tro_chi_tiet` INNER JOIN `ho_tro_hien_thi`  WHERE  `kieu_ho_tro_chi_tiet`.`id_kieu_ho_tro` = `ho_tro_hien_thi`.`id_kieu_ho_tro` AND `ho_tro_hien_thi`.`id_loai_hien_thi`=1 ORDER BY `stt`";
// $sql="SELECT * FROM `kieu_ho_tro_chi_tiet` INNER JOIN `ho_tro_hien_thi` WHERE `kieu_ho_tro_chi_tiet`.`id_kieu_ho_tro` = `ho_tro_hien_thi`.`id_kieu_ho_tro` AND `ho_tro_hien_thi`.`id_loai_hien_thi`=$id_loai_hien_thi ORDER BY `ho_tro_chi_tiet`.`stt`" ;
$kq = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($kq)) {
    print_r($row['ten_kieu_ho_tro_chi_tiet']);
    echo '<br>';
}
// if(!isset($_SESSION['luu'])){
//     while( $row=mysqli_fetch_assoc($kq)){
//         $_SESSION['luu'][]=$row['id_kieu_ho_tro_chi_tiet'];
//     }
// }
// if(!isset($_SESSION['sl'])){
//     $_SESSION['sl'][]=$_SESSION['luu'][0];
// }
// 
// $sql="SELECT * FROM `ho_tro_hien_thi` WHERE `id_loai_hien_thi`=$id_loai_hien_thi";
$sql = " SELECT * FROM `kieu_ho_tro_chi_tiet` INNER JOIN `ho_tro_hien_thi` WHERE `kieu_ho_tro_chi_tiet`.`id_kieu_ho_tro` = `ho_tro_hien_thi`.`id_kieu_ho_tro` AND `ho_tro_hien_thi`.`id_loai_hien_thi`=$id_loai_hien_thi";
$kq = mysqli_query($conn, $sql);

//    echo "test";
//    print_r($_SESSION['luu']);
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
// $_SESSION['sl'][]=2;
// print_r($_SESSION['sl']);
// echo "Chọn loại hướng dẫn:";
// echo " <form action='' method='get'><div id='khoi'>";
// echo "<input type='hidden' name='id_cau_hoi' value='$id_cau_hoi'>";
// echo "<select name='loai'>";
// echo "<option value=''>-----------------</option>";
// while($row=mysqli_fetch_assoc($kq)){
//         if(in_array($row['id_kieu_ho_tro_chi_tiet'],$_SESSION['sl'])){
//             // $row['id_kieu_ho_tro_chi_tiet'];
//             // echo "<div class='cap$i'>".$row['ten_kieu_ho_tro_chi_tiet']."<input type='hidden' name='id_kieu_ho_tro_chi_tiet' value='".$row['id_kieu_ho_tro_chi_tiet']."'>"."<input type='submit' class='caphd' name='cap' value='Hướng dẫn cấp $i'></div>";
//             echo "<option value='".$row['id_kieu_ho_tro_chi_tiet']."'>".$row['ten_kieu_ho_tro_chi_tiet']."</option>";
//         }
//     $i++;   
//     // echo "<br>";
// }
// echo "</select>";
// echo "<input type='submit' class='' name='btn_hd' value='Gửi'>";
// echo "</div> </form>";
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

    // load lại trang
    // header("Location:in_cau_hoi.php?id_cau_hoi=$id_cau_hoi&loai=$id_kieu_ho_tro_chi_tiet&btn_hd=Gửi");
    // d_cau_hoi=5&loai=10&btn_hd=Gửi

}
?>


</body>

</html>