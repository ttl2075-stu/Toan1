<?php 
    ob_start();
    session_start();
    include 'connectdb.php';
    if(!isset($_SESSION['id_user'])){
        header('Location: index.php');
        die();
    }

    $role=$_SESSION['quyen'];
    $id_user = $_SESSION['id_user'];
    $id_bai_tap_user = $_GET['id_bai_tap_user'];

    $id_cau_hoi = $_GET['id_cau_hoi'];

$sql = "SELECT * FROM `dap_an_d6k3` 
        WHERE id_cau_hoi = '$id_cau_hoi'";

$a = mysqli_query($conn, $sql);
$mang_rong = [];
$id_mang = [];
$trang_thai = [];

while ($row = mysqli_fetch_assoc($a)) {
    array_push($mang_rong, $row["ten_dap_an"]);
    array_push($id_mang, $row["id_dap_an_d6k3"]);
    array_push($trang_thai, $row["trang_thai"]);
}
    $sql_cau_hoi = "SELECT url_doi_tuong, url_dung_do FROM `cau_hoi`
    WHERE id_cau_hoi = '$id_cau_hoi';
    ";
    $_SESSION['trang_thai'] = $trang_thai;
    $result =  mysqli_query($conn, $sql_cau_hoi);
    $_SESSION['anh'] = mysqli_fetch_assoc($result);
    $_SESSION['dang_bai'] = $mang_rong;

    $_SESSION['id_bai'] = $id_mang;
    $_SESSION['id_cau_hoi'] = $id_cau_hoi;
    $_SESSION['id_dap_an_d6k3'] = '';
     
    $bieuThuc = '';
    $noiDungQuiz = '';
    $loaiKiemTra = 'khongtrudiem';
   
    if (!$conn) {
        die("Kết nối thất bại: " . mysqli_connect_error());
    }
    $sql = "SELECT * FROM `cau_hoi` WHERE `cau_hoi`.`id_cau_hoi`='$id_cau_hoi' ";
    $result1 = mysqli_query($conn, $sql);
    $row1 = mysqli_fetch_assoc($result1);
    // echo $row1['id_loai_hien_thi'];
    if ($row1['id_loai_hien_thi'] == 6) {
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
    // $arrBieuThuc = explode("=", $bieuThuc);
    // $bieuThuc = $arrBieuThuc[0];
    $cau = [
        "cauHoi" => $noiDungQuiz,
        "bieuThuc" => $bieuThuc,
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
    <link rel="stylesheet" href="./src/css/root.css">
    <link rel="stylesheet" href="./assets/css_v2/style.css">
    <link rel="stylesheet" href="./assets/css_v2/InCauHoi_d4k1_php.css">
    <script src="./src/js/function.js"></script>
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
        /* background-color: #2da0fa;  */
        background-color: #bbded6;
        border: none;
        /* color: white;  */
        color: grey;
        padding: 10px 20px;
        font-size: 16px;
        cursor: pointer;
        border-radius: 5px;
        margin-right: 10px;
        transition: transform 0.5s ease-in-out;
        font-size: 25px;
    }

    .button-red {
        /* background: #ff4742 !important;
        border: 1px solid #ff4742; */
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
        /* background-color: white !important; */
        transform: translateY(-5px);
        /* color: red !important; */
    }

    #help {
        padding: 0 10px;
        margin-top: 10px;
    }

    #help img {
        width: 50px;
        margin-left: 5px;
    }

    /* CSS cho phần tử chứa số */
    .so,
    #so1,
    #so2 {
        display: inline-block;
        font-size: 90px;
        /* Kích thước chữ */
        width: 120px;
        /* Điều chỉnh chiều rộng của số */
        height: 120px;
        /* Điều chỉnh chiều cao của số */
        line-height: 120px;
        /* Căn giữa theo chiều cao */
        /* margin-left: 10px; */
        border: 2px solid black;
        border-radius: 20px;
        box-shadow: 0px 2px 8px 0px var(--secondary-light);
        font-weight: bold;
        /* margin-top: px;  */
    }

    #so2 {
        margin-top: 150px;
    }

    #so1 {
        color: orange;
    }

    #so2 {
        color: purple;
    }

    /* CSS cho phần tử hình ảnh */
    .anhsosanh {
        width: 200px;
        /* Điều chỉnh chiều rộng của ảnh */
        height: 200px;
        /* Điều chỉnh chiều cao của ảnh */
        vertical-align: middle;
        /* Căn giữa theo chiều dọc */
        margin-top: 0px;
    }

    #quanh_ham {
        display: flex;
        flex-wrap: wrap;
    }
    </style>
    <script>
    localStorage.setItem("luu_vet", JSON.stringify([]));
    let loaihienthi = <?php echo $id_loai_hien_thi; ?>;
    let sessionData = <?php echo $sessionDataJSON; ?>;
    let quizs = JSON.parse(sessionData);
    upLocalStorage("d4k1_baiDien", quizs);
    upLocalStorage("loai_hien_thi", loaihienthi)
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
                        $sql ="SELECT ten_cau_hoi FROM `cau_hoi` WHERE cau_hoi.id_cau_hoi = $id_cau_hoi";
                        $a = mysqli_query($conn, $sql);
                        while($row = mysqli_fetch_assoc($a)){
                            echo $row['ten_cau_hoi'];
                        };
                    ?>
                </span>
            </div>

            <div style="display: flex;">
                <div class="contain" style="display: flex;">
                    <div id="container">
                        <div style="display: flex; margin-top: 100px;">
                            <div class="basket" id="basket"></div>
                            <div class="plate" id="plate"></div>
                        </div>
                    </div>
                    <?php 
                $readonly1 = '';
                $readonly2 = '';
                $readonly3 = '';            
                ?>
                    <div class="box-phepTinh">
                        <div class="square" id="square1"><input type="text" class="inputt" id='inputt1' name='inputt1'
                                placeholder="?" required value="<?php 
                if((isset($_POST['inputt1']) && $_POST['inputt1'] == $mang_rong[0]) || $_SESSION['trang_thai'][0] == 1){
                    echo $mang_rong[0]; 
                    if($_SESSION['trang_thai'][0] == 1){
                        $readonly1 = 'readonly';
                    }
                }
                ?>" <?php echo $readonly1; ?>></div>
                        <div class="square" id="square2"><input type="text" class="inputt2" id='inputt2' name='inputt2'
                                placeholder="?" required value="<?php 
                if((isset($_POST['inputt2']) && $_POST['inputt2'] == $mang_rong[1]) || $_SESSION['trang_thai'][1] == 1){
                    echo $mang_rong[1]; 
                    if($_SESSION['trang_thai'][1] == 1){
                        $readonly2 = 'readonly';
                    }
                }   
                ?>" <?php echo $readonly2; ?>></div>
                        <div class="square" id="square3"><input type="text" class="inputt" id='inputt3' name='inputt3'
                                placeholder="?" required value="<?php 
                if((isset($_POST['inputt3']) && $_POST['inputt3'] == $mang_rong[2])  || $_SESSION['trang_thai'][2] == 1){
                    echo $mang_rong[2]; 
                    if($_SESSION['trang_thai'][2] == 1){
                        $readonly3 = 'readonly';
                    }
                }   
                ?>" <?php echo $readonly3; ?>></div>
                    </div>
                    <!-- <div class="dien" id="dien"><center>
                                <br>
                                    <button type='button' id="incrementButton">&nbsp;<i class="fa-solid fa-angle-up"></i></button>
                                    <button type='button' id="decrementButton">&nbsp;<i class="fa-solid fa-angle-down"></i></button>
                                </center>
                                </div> -->
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
            <span class='notice hidden'>
            </span>
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
            });
            $('.notice-container button').click(function() {
                $(this).closest('.notice-container').removeClass('showNotice');
            });
        });
        console.log(<?php echo $id_loai_hien_thi; ?>)
        </script>
    </form>

    <?php
$id_btuser = $_GET['id_bai_tap_user'];
$kiem_tra = "SELECT * FROM `bai_tap_user` WHERE `id_bai_tap_user`=$id_btuser ORDER BY trang_thai DESC LIMIT 1;";
$trangthai = mysqli_query($conn, $kiem_tra);
$row = mysqli_fetch_assoc($trangthai);

$kiem_tra_s = "SELECT * FROM `dap_an_nguoi_dung_d6k3` WHERE `id_bai_tap_user`= '$id_btuser' ORDER BY `dap_an_nguoi_dung_d6k3`.id_dap_an_nguoi_dung_d6k3 DESC LIMIT 4;";
$trangthai_s = mysqli_query($conn, $kiem_tra_s);
$rows = mysqli_fetch_assoc($trangthai_s);
if(isset($rows) &&isset($row)){
    if($row['trang_thai'] == "1"){
        echo "<script>
        document.getElementById('notice-container').style.display = 'block'
        document.getElementById('tieptuclam').style.display = 'none'
        document.getElementById('notice-container').classList.add('showNotice')
        </script>";
        $kiem_tra_s = "SELECT * FROM `dap_an_nguoi_dung_d6k3` WHERE `id_bai_tap_user`= '$id_btuser' ORDER BY id_dap_an_nguoi_dung_d6k3 DESC LIMIT 4;";
        $trangthai_s = mysqli_query($conn, $kiem_tra_s);
        $ketqua = [];
        while($rows = mysqli_fetch_assoc($trangthai_s)){
            array_push($ketqua, $rows['dap_an']);
        }
        $_SESSION['ketquadapan']=$ketqua;
    }else if($row['trang_thai'] == "0"){
        echo "<script>
            document.getElementById('notice-container').style.display = 'block'
            document.getElementById('xemdapan-button').style.display = 'none'
            document.getElementById('notice-container').classList.add('showNotice')
        </script>";
        $kiem_tra_s1 = "SELECT * FROM `dap_an_nguoi_dung_d6k3` WHERE `id_bai_tap_user`= '$id_btuser' ORDER BY `dap_an_nguoi_dung_d6k3`.id_dap_an_nguoi_dung_d6k3 DESC LIMIT 4;";
        $trangthai_s1 = mysqli_query($conn, $kiem_tra_s1);
        $ketqua1 = [];
        $mucdo1 = [];
        while($rows = mysqli_fetch_assoc($trangthai_s1)){
            array_push($ketqua1, $rows['dap_an']);
            array_push($mucdo1, $rows['stt_huong_dan']);
        }
        echo "<script>
            localStorage.setItem('mucdo', '{$mucdo1[0]}');
        </script>";
        $_SESSION['ketquadapan']=$ketqua1;
    }
}


        function show_anh($count, $count_2){
            if($count > 10 && $count_2 > 10){
                $lan = floor($count/10); 
                $lan_2 = floor($count_2/10);
              
                $conlai = $count%(10*$lan);
                $conlai_2 = $count_2%(10*$lan_2);

                echo displayObjects_trai($lan, "boque.png");
                echo displayObjects_phai($lan_2, "boque.png");
                
                echo displayObjects_trai($conlai, "motque.png");
                echo displayObjects_phai($conlai_2, "motque.png");

            }else if($count > 10){
                $lan = floor($count/10); 
                $conlai = $count%(10*$lan);

                echo displayObjects_trai($lan, "boque.png");
                echo displayObjects_trai($conlai, "motque.png");

                echo displayObjects_phai($count_2, "motque.png");
            }else if($count_2 > 10){
                $lan_2 = floor($count_2/10);
                $conlai_2 = $count_2%(10*$lan_2);
        
                
                echo displayObjects_phai($lan_2, "boque.png");
                echo displayObjects_phai($conlai_2, "motque.png");
                echo displayObjects_trai($count, "motque.png");
            }else{
                echo displayObjects($count, $count_2);
            }
        }

        if(isset($_SESSION['dang_bai'][0]) && isset($_SESSION['dang_bai'][2])){
            show_anh($_SESSION['dang_bai'][0],$_SESSION['dang_bai'][2]);
        }

        if(isset($_POST["quay_ve"])){
            header("Location: in_cau_hoi.php?id_cau_hoi=$id_cau_hoi");
        }

        function embedAudio_dung($audioUrl) {
            return '<audio id="audioPlayer" controls autoplay><source src="' . $audioUrl . '" type="audio/mpeg"></audio>';
        }
        
        
        function displayObjects_trai($count, $url)
        {
       
            $result = ''; 
            $result .= '<script>'; 
            $result .= 'var container = document.getElementById("basket");';
            $result .= 'var width = container.clientWidth;';
            $result .= 'var height = container.clientHeight;';
            $result .= 'var br = document.createElement("br");';
            $result .= 'container.appendChild(br);';
            $result .= 'for (var i = 0; i < ' . $count . '; i++) {';
            $result .= '    var img = document.createElement("img");';
            $result .= '    img.className = "anh";';
            $result .= '    img.src = "uploads/' .  $url . '";';
            $result .= '    var centerX = width / 2;';
            $result .= '    var centerY = height / 2;';
            $result .= '    var radiusX = width / 2 - 100;'; 
            $result .= '    var radiusY = height / 2 - 100;'; 
            $result .= '    var angle = Math.random() * 2 * Math.PI;';
            $result .= '    var x = centerX + radiusX * Math.cos(angle);';
            $result .= '    var y = centerY + radiusY * Math.sin(angle);';
            $result .= '    var scale = 1.2;';
            $result .= '    var scaledWidth = 50 * scale;'; 
            $result .= '    var scaledHeight = 80 * scale;'; 
            $result .= '    img.style.width = scaledWidth + "px";';
            $result .= '    img.style.height = scaledHeight + "px";'; 
            $result .= '    img.style.left = (x - (scaledWidth / 2)) + "px";'; 
            $result .= '    img.style.top = (y - (scaledHeight / 2)) + "px";'; 
            $result .= '    container.appendChild(img);';
            $result .= '}';
            $result .= '</script>'; 
            return $result;
        } 

        function displayObjects_phai($count, $url)
        {
            $result = ''; 
            $result .= '<script>'; 
            $result .= 'var container = document.getElementById("plate");';
            $result .= 'var width = container.clientWidth;';
            $result .= 'var height = container.clientHeight;';
            $result .= 'var br = document.createElement("br");';
            $result .= 'container.appendChild(br);';
            $result .= 'for (var i = 0; i < ' . $count . '; i++) {';
            $result .= '    var img = document.createElement("img");';
            $result .= '    img.className = "anh";';
            $result .= '    img.src = "uploads/' .  $url . '";';
            $result .= '    var centerX = width / 2;';
            $result .= '    var centerY = height / 2;';
            $result .= '    var radiusX = width / 2 - 100;'; 
            $result .= '    var radiusY = height / 2 - 100;'; 
            $result .= '    var angle = Math.random() * 2 * Math.PI;';
            $result .= '    var x = centerX + radiusX * Math.cos(angle);';
            $result .= '    var y = centerY + radiusY * Math.sin(angle);';
            $result .= '    var scale = 1.2;';
            $result .= '    var scaledWidth = 50 * scale;'; 
            $result .= '    var scaledHeight = 80 * scale;'; 
            $result .= '    img.style.width = scaledWidth + "px";';
            $result .= '    img.style.height = scaledHeight + "px";'; 
            $result .= '    img.style.left = (x - (scaledWidth / 2)) + "px";'; 
            $result .= '    img.style.top = (y - (scaledHeight / 2)) + "px";'; 
            $result .= '    container.appendChild(img);';
            $result .= '}';
            $result .= '</script>'; 
            return $result;
        } 

        function displayObjects($count, $count_2)
        {
            $result = ''; 
            $result .= '<script>'; 
            $result .= 'var container = document.getElementById("basket");';
            $result .= 'var width = container.clientWidth;';
            $result .= 'var height = container.clientHeight;'; 
            $result .= 'for (var i = 0; i < ' . $count . '; i++) {';
            $result .= '    var img = document.createElement("img");';
            $result .= '    img.className = "anh";';
            $result .= '    img.src = "uploads/' .  $_SESSION['anh']['url_doi_tuong'] . '";';
            $result .= '    var centerX = width / 2;';
            $result .= '    var centerY = height / 2;';
            $result .= '    var radiusX = width / 2 - 100;'; 
            $result .= '    var radiusY = height / 2 - 100;'; 
            $result .= '    var angle = Math.random() * 2 * Math.PI;';
            $result .= '    var x = centerX + radiusX * Math.cos(angle);';
            $result .= '    var y = centerY + radiusY * Math.sin(angle);';
            $result .= '    var scale = 1.2;';
            $result .= '    var scaledWidth = 65 * scale;'; 
            $result .= '    var scaledHeight = 70 * scale;'; 
            $result .= '    img.style.width = scaledWidth + "px";';
            $result .= '    img.style.height = scaledHeight + "px";'; 
            $result .= '    img.style.left = (x - (scaledWidth / 2)) + "px";'; 
            $result .= '    img.style.top = (y - (scaledHeight / 2)) + "px";'; 
            $result .= '    container.appendChild(img);';
            $result .= '}';
            $result .= 'var containers = document.getElementById("plate");';
            $result .= 'var widths = containers.clientWidth;';
            $result .= 'var heights = containers.clientHeight;';
            $result .= 'for (var i = 0; i < ' . $count_2 . '; i++) {';
            $result .= '    var img = document.createElement("img");';
            $result .= '    img.className = "anh";';
            $result .= '    img.src = "uploads/' .  $_SESSION['anh']['url_dung_do'] . '";';
            $result .= '    var centerX = width / 2;';
            $result .= '    var centerY = height / 2;';
            $result .= '    var radiusX = width / 2 - 100;'; 
            $result .= '    var radiusY = height / 2 - 100;'; 
            $result .= '    var angle = Math.random() * 2 * Math.PI;';
            $result .= '    var x = centerX + radiusX * Math.cos(angle);';
            $result .= '    var y = centerY + radiusY * Math.sin(angle);';
            $result .= '    var scale = 1.2;';
            $result .= '    var scaledWidth = 65 * scale;'; 
            $result .= '    var scaledHeight = 70 * scale;'; 
            $result .= '    img.style.width = scaledWidth + "px";';
            $result .= '    img.style.height = scaledHeight + "px";'; 
            $result .= '    img.style.left = (x - (scaledWidth / 2)) + "px";'; 
            $result .= '    img.style.top = (y - (scaledHeight / 2)) + "px";'; 
            $result .= '    containers.appendChild(img);';
            $result .= '}';
            $result .= '</script>'; 
            return $result;
        } 
      ?>

    <script>
    document.getElementById('xemdapan-button').addEventListener('click', function xemdapan() {
        <?php if(isset($_SESSION['ketquadapan']) && !empty($_SESSION['ketquadapan'])) { ?>
        document.getElementById('notice-container').style.display = 'none';
        document.getElementById('inputt1').value = "<?php echo $_SESSION['ketquadapan'][2]; ?>";
        document.getElementById('inputt2').value = "<?php echo $_SESSION['ketquadapan'][1]; ?>";
        document.getElementById('inputt3').value = "<?php echo $_SESSION['ketquadapan'][0]; ?>";
        document.getElementById('inputt1').readOnly = true;
        document.getElementById('inputt2').readOnly = true;
        document.getElementById('inputt3').readOnly = true;
        document.getElementById('check').disabled = true;
        document.getElementById('help').disabled = true;
        <?php } ?>
    });

    document.getElementById('tieptuclam').addEventListener('click', function tieptuclam() {
        <?php if(isset($_SESSION['ketquadapan']) && !empty($_SESSION['ketquadapan'])) { ?>
        document.getElementById('notice-container').style.display = 'none';
        document.getElementById('inputt1').value = "<?php echo $_SESSION['ketquadapan'][2]; ?>";
        document.getElementById('inputt2').value = "<?php echo $_SESSION['ketquadapan'][1]; ?>";
        document.getElementById('inputt3').value = "<?php echo $_SESSION['ketquadapan'][0]; ?>";
        <?php } ?>
    })

    $('#check').click(function() {
        var dataToSend = localStorage.getItem('dulieu');
        var local = localStorage.getItem('mucdo');
        var luu_vet1 = localStorage.getItem('luu_vet');
        $.ajax({
            url: 'file_database_d4k1.php',
            type: 'post',
            data: {
                hai: dataToSend,
                mucdo: local,
                luu_vet: luu_vet1
            },
            success: function(response) {
                // alert(data);
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
    <script src="./src/js/d4k1.js"></script>
    <script src="./src/js/help_new_d6k3.js"></script>
</body>

</html>