<?php
    ob_start();
    session_start();
    include 'connectdb.php';
    if(!isset($_SESSION['id_user'])){
        header('Location: index.php');
        die();
    }
    
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $role=$_SESSION['quyen'];
    $id_user = $_SESSION['id_user'];
    $id_bai_tap_user = $_GET['id_bai_tap_user'];
    $_SESSION['id_bai_tap_user'] = $_GET['id_bai_tap_user'];
    $id_cau_hoi = $_GET['id_cau_hoi'];
    cap_nhat_tg($id_bai_tap_user,1);
    function cap_nhat_tg($id_bai_tap_user,$i){
        global $conn;
        $current_time = date('Y-m-d H:i:s');
        if($i==1){
            $sql = "UPDATE `bai_tap_user` SET `tg_bd`='$current_time' WHERE `id_bai_tap_user`='$id_bai_tap_user'";
        }else{
            $sql = "UPDATE `bai_tap_user` SET `tg_kt`='$current_time' WHERE `id_bai_tap_user`='$id_bai_tap_user'";
        }
        mysqli_query($conn,$sql);
    }
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
        // print_r($_SESSION['dang_bai']);
        $_SESSION['id_bai'] = $id_mang;
        // print_r($_SESSION['id_bai']);
       
        $max = $_SESSION['dang_bai'][0]; 
        $url ="uploads/".$_SESSION['anh']['url_doi_tuong'];   
        $da =$_SESSION['dang_bai'][1];
    

    // begin 28/07/2024
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
    
     $arrBieuThuc = explode("=", $bieuThuc);
     $bieuThuc = $arrBieuThuc[0];
    //  $ketQua = $arrBieuThuc[1];
     $cau = [
         "cauHoi" => $noiDungQuiz,
         "bieuThuc" => $bieuThuc,
        //  "dapAn" => $ketQua,
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
    // end 28/07/2024
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./src/css/d6_k3.css">
    <script src="./src/js/function.js"></script>
    <script>
        // Loại bỏ sự kiện beforeunload
        window.removeEventListener('beforeunload', function (e) {
            // Không làm gì cả sẽ ngăn chặn thông báo
        });
        localStorage.setItem("luu_vet", JSON.stringify([]));
        // Đảm bảo rằng không có sự kiện beforeunload nào được thêm mới
        window.onbeforeunload = null;

        function upLocalStorage(key, value) {
            localStorage.setItem(key, JSON.stringify(value))
        }
    </script>
    <script>
        // common.js

        // // Loại bỏ sự kiện beforeunload
        // window.removeEventListener('beforeunload', function (e) {
        //     // Không làm gì cả sẽ ngăn chặn thông báo
        // });

        // // Đảm bảo rằng không có sự kiện beforeunload nào được thêm mới
        // window.onbeforeunload = null;

    </script>
      <script>
        let loaihienthi = <?php echo $id_loai_hien_thi; ?>;
        let sessionData = <?php echo $sessionDataJSON; ?>;
        console.log(sessionData);
        let quizs = JSON.parse(sessionData);
       
        upLocalStorage("d6k3_baiDien", quizs);
    </script>
    <style>
        #help{
            padding: 0px;
        }
        #help img{
            width: 50px;
            height: 50px;
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

        .btn i{
            color:white;
        }
        .btn:hover {
            background-color: yellow;
            transform: translateY(-5px);
            color: black;
        }

        #help{
            padding: 0 10px;
            margin-top: 10px;
        }
        #help img {
            width: 50px; 
            margin-left: 5px; 
        }
        .contain{
            display: flex;
            /* border: 1px solid black; */
            flex-direction: row;
            justify-content: space-between;
            min-height: 200px;
            margin-top: 100px;
            margin-left: 15px;
            margin-right: 15px;
        }
        .trai{
            width: 45%;
            height: 100%;
            background-color: lightblue;
            text-align: left;
        }
        .phai{
            width: 45%;
            height: 100%;
            background-color: lightcoral;
            text-align: left;
        }
        #objCount{
            display: block;
        }
    </style>
    <script>
        // let loaihienthi = 3;
        // let sessionData = "[{\"cauHoi\":\"1\",\"bieuThuc\":\"1+2\",\"dapAn\":\"3\",\"kiemTra\":\"khongtrudiem\",\"soLanTraLoiSai\":0,\"diem\":0,\"dapAnTraLoiGanNhat\":\"\",\"suDungTroGiupMuc\":0,\"id_user\":3,\"mucHelp\":0}]";
        // let quizs = JSON.parse(sessionData);
        // upLocalStorage("d6k3_baiDien", quizs);
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
            <div class="contain"style="display: flex;">
                    <div  ondrop="drop(event)" ondragover="allowDrop(event)" class="trai">
                    <?php
                        for ($i=0; $i <$max ; $i++) { 
                        echo "<img src='$url' draggable='true' class='anh'   ondragstart='drag(event)' id='drag$i' width='100' height='100'>";
                        }
                    ?>
                    </div>
                    <div  ondrop="drop(event)" ondragover="allowDrop(event)" class="phai"></div>
            </div>

            <div id="contain_1">
                <div id="contain_2">
                        <span id="objCount" style="font-size: 40px;">0</span>
                        <button style="margin-bottom: 50%;" type="button" class="btn" id="check" name="btn_check" onclick="checkAnswer()"><img src="./icon/check.png" style="width:30px; height:30px;">Kiểm tra</button>
                        <button type="button" class="btn" id="help" name='btn_hd' value="16-22-1/17-23-2/18-24-3/13-19-4/14-19-4/19-25-5/"><img src="./icon/support.png" style="margin-right: 10px;">Hỗ trợ</button>
                </div>
            </div>
        </div>

        <script>
            function allowDrop(ev) {
                ev.preventDefault();
            }

            function drag(ev) {
                ev.dataTransfer.setData("text", ev.target.id);
                // console.log(x);
            }
            // hàm drop cũ bị lỗi đè ảnh khi kéo
            // function drop(ev) {
            //     ev.preventDefault();
            //     var data = ev.dataTransfer.getData("text");
            //     ev.target.appendChild(document.getElementById(data));
            //     let dem = document.querySelectorAll('.phai>.anh')
            //     console.log(dem.length);
            //     document.getElementById('objCount').innerHTML=dem.length
            // }
            // hàm drop mới cập nhật lại lỗi bị đè ảnh khi kéo thả
            function drop(ev) {
                ev.preventDefault();
                var data = ev.dataTransfer.getData("text");
                var img = document.getElementById(data);
                let dem = document.querySelectorAll('.phai>.anh')
                if (ev.target.classList.contains('phai') || ev.target.classList.contains('trai')) {
                    ev.target.appendChild(img);
                } else if (ev.target.tagName === 'IMG') {
                    var parentDiv = ev.target.parentElement;
                    if (parentDiv.classList.contains('phai') || parentDiv.classList.contains('trai')) {
                        parentDiv.appendChild(img);
                    }
                } else if (ev.target.tagName !== 'IMG') {
                    ev.target.appendChild(img);
                }
                // document.getElementById('objCount').innerHTML=dem.length
            }
        </script>
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
        <button type="button" id="tieptuclam" onclick="tieptuclam()"><i class="fa-solid fa-pen-to-square"></i>Tiếp tục làm</button>
        <button type="button" id="xemdapan-button" onclick="xemdapan()"><i class="fa-solid fa-eye"></i>Xem lại đáp án đúng</button>
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
                                ">Tính: 1+2</div>
        <center>
            <div id="tableContainer"></div>
            <div id="support"></div>
            <div class="show-help"></div>
            <div id="legoContainer"></div>
            <div id="nuthotro"></div>
        </center>
            <div class='div-btn' id="backbutton">
                <button type="button" class="back-button" style="width:150px; height:50px;"><img src="./icon/trove.png" style="width:30px; height:30px; margin-right: 5px; ">Trở về</button>
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
                if('+' == "-"){
                    document.getElementById('basket').style.display="block";
                    document.getElementById('plate').style.display="block";
                }else if('+' == "+"){
                    document.getElementById('basket_plate').style.display="block";
                }
                document.getElementById('contain_1').style.paddingTop="100px";
            });
            $('.notice-container button').click(function() {
                $(this).closest('.notice-container').removeClass('showNotice');
            });
        });
        console.log(3)
    </script>
    </div>
    </div>
</form>
<script>
document.getElementById('xemdapan-button').addEventListener('click', function xemdapan() {
    });

    document.getElementById('tieptuclam').addEventListener('click', function tieptuclam(){
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
    var speakerHTML = `<button class="speaker" onclick="readButtonContent('btn-kieuhotro${u}')"><i class="fa-solid fa-volume-high"></i></button>`;
    if(u!=19){
         // Thêm button và loa vào divbtnHelps
        divbtnHelps.innerHTML += buttonHTML + " "+speakerHTML + "<br>";
    }
   
});

function hiddenHelpdiv() {
    divHelp.classList.add('hidden')
    divHelp.classList.remove('show')
}

document.getElementById('backbutton').addEventListener('click', function back(){
    show();
})

function show(){
    document.getElementById('helpcontain').style.display = 'none';
    if("+" === "-"){
        document.getElementById('basket').style.display="block";
        document.getElementById('plate').style.display="block";
    }else{
        document.getElementById('basket_plate').style.display="block";
    }
}
function daSuDung(u) {
    let index = 0
    console.log('vào');
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
        if(result[0].kieuHoTroChiTiet == 16){
            showdocde();
            if(localStorage.getItem('mucdo') < 1){
                localStorage.setItem('mucdo', 1);
            }
            if (lesson[index].mucHelp < 1) lesson[index].mucHelp = 1
            hiddenHelpdiv()
            show();
                document.getElementById('contain_1').style.paddingTop="100px";
        }
    } else if (u == 23) {
        them_lu_vet("luu_vet", 3)
        if(result[0].kieuHoTroChiTiet == 17){
            showdochinhanh();
            if(localStorage.getItem('mucdo') < 2){
                localStorage.setItem('mucdo', 2);
            }
            if (lesson[index].mucHelp < 2) lesson[index].mucHelp = 2
            hiddenHelpdiv()
            show();
            document.getElementById('contain_1').style.paddingTop="100px";
        }
    }else if (u == 24) {
        them_lu_vet("luu_vet", 4)
        if(result[0].kieuHoTroChiTiet == 18){
            showhiennoidung();
            if(localStorage.getItem('mucdo') < 3){
                localStorage.setItem('mucdo', 3);
            }
            if (lesson[index].mucHelp < 3) lesson[index].mucHelp = 3
            hiddenHelpdiv()
            show();
                document.getElementById('contain_1').style.paddingTop="100px";
        }
    }else if (u == 25) {
        them_lu_vet("luu_vet", 7)
        if(result[0].kieuHoTroChiTiet == 19){
            docketqua()
            if(localStorage.getItem('mucdo') < 5){
                localStorage.setItem('mucdo', 5);
            }
            if (lesson[index].mucHelp < 5) lesson[index].mucHelp = 5
            hiddenHelpdiv()
            show()
            document.getElementById('contain_1').style.paddingTop="100px";
        }
    } 
    else if (u == 19) {
        var shos = document.getElementsByClassName('show-help');
        for (var i = 0; i < shos.length; i++) {
            shos[i].style.display = 'block';
        }
        if(localStorage.getItem('mucdo') < 4){
            localStorage.setItem('mucdo', 4);
        }
        showHelp.innerHTML = '';
        result.forEach(i => {
            if (i.kieuHoTroChiTiet == 11) {
                showHelp.innerHTML += `<button type="button" style="width: 400px" class="btn hinhThucHelp" id="help${u}" onclick="helpQuetinh('${bieuthuc}', ${index})">
                <img src="./icon/quetinh.png" alt="QueTinh Image" style="width: 50px; height: 50px;">
                Que tính
                </button><br>`;
            } else if (i.kieuHoTroChiTiet == 12) {
                // showHelp.innerHTML += `<button type="button" style="width: 400px" class="btn hinhThucHelp" id="help${u}" onclick="generateLEGO('${bieuthuc}')">Lego</button><br>`;
                showHelp.innerHTML += `<button type="button" class="btn hinhThucHelp custom-button" id="help${u}" onclick="generateLEGO('${bieuthuc}')" style="width: 400px">
                        <img src="./icon/lego.png" alt="LEGO Image" style="width: 50px; height: 50px;">
                        Lego
                      </button><br>`;


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

function help(){
    var shos = document.getElementsByClassName('show-help');
    for (var i = 0; i < shos.length; i++) {
        shos[i].style.display = 'none';
    }

    document.getElementById('tableContainer').style.display = 'none';
    document.getElementById('support').style.display = 'none';
    
    document.getElementById('helpcontain').style.position = 'fixed';
    document.getElementById('helpcontain').style.top = '13%'; // Điều chỉnh kích thước của top ở đây
    document.getElementById('helpcontain').style.display = 'block';

    document.getElementById('basket').style.display="none";
    document.getElementById('plate').style.display="none";
    document.getElementById('basket_plate').style.display="none";
    
    console.log(2)
    divHelp.classList.add('show')
    divbtnHelps.style.display = 'block'
    showHelp.innerHTML = ''
}

function showdocde() {
    let deBai = document.querySelector('#debai').textContent; 
    text = "Câu hỏi là " + deBai;
    speakVietnamese(text);
}

function showdochinhanh() {
    text = "Trên hình, có một đồ vật. Đồ vật có số lượng là" + <?php echo $_SESSION['dang_bai'][0]; ?> ;
    speakVietnamese(text);
    // if ("+" === "+") { 
    //     text = "Trên hình, có hai đồ vật. Đồ vật thứ nhất có số lượng là" + 1 + "hình. Ta lấy thêm đồ vật thứ hai có số lượng là" + 2 + "hình. Vậy có tất cả là bao nhiêu";
    //     speakVietnamese(text);
    // } else if ("+" === "-") { 
    //     text = "Ở ô màu hồng phía bên trái, có " + 1 + " hình. Ta bỏ bớt " + 2 + " hình ở ô màu xanh phía bên phải. Vậy còn lại bao nhiêu hình";
    //     speakVietnamese(text);
    // }
}

function docketqua() {
        text = "Số lượng đồ vật là:" + <?php echo $_SESSION['dang_bai'][0]; ?> ;
        speakVietnamese(text);
}


function showhiennoidung() {
    var dang_bai = <?php echo json_encode($_SESSION['dang_bai']); ?>; // Chuyển đổi PHP array sang JavaScript array
    // document.getElementById('inputt1').value = dang_bai[0];
    // document.getElementById('inputt2').value = dang_bai[1];
    // document.getElementById('inputt3').value = dang_bai[2];
    // em thêm 3 dòng dưới
    document.getElementById('inputt1').style.boxShadow = "0 0 10px 10px lightgreen";
    // document.getElementById('inputt2').style.boxShadow = "0 0 10px 10px lightgreen";
    // document.getElementById('inputt3').style.boxShadow = "0 0 10px 10px lightgreen";
    document.getElementById('inputt1').style.border = "lightgreen";
    // document.getElementById('inputt2').style.border = "lightgreen";
    // document.getElementById('inputt3').style.border = "lightgreen";
    var msg_3 = new SpeechSynthesisUtterance();
    msg_3.text = "Nơi điền kết quả ở phía dưới. Hãy đếm số lượng đối tượng và điền vào đấy nhé";
    msg_3.lang = 'vi-VN';
    msg_3.volume = 1;
    msg_3.rate = 0.75;
    msg_3.pitch = 1.5;
    window.speechSynthesis.speak(msg_3);
}

function arrCalculateFromString(expression) {
    
    return expression.split(/([()+\-*/])/).filter(function(e) { return e.trim().length > 0; });
}
function upLocalStorage(key, value) {
    localStorage.setItem(key, JSON.stringify(value))
}


// Hàm tia số
function helpTiaSo(bieuthuc) {
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
            setTimeout(function () {
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
            setTimeout(function () {
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
            setTimeout(function () {
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
            setTimeout(function () {
                showArrow(index + 1); // Gọi đệ quy với index tăng lên
            }); // Thời gian delay giữa mỗi lần hiển thị hình ảnh (miliseconds)
        }

        showArrow(1); // Bắt đầu đệ quy từ index 1
    }
}

// Hàm tạo bảng
function drawTable(firstNumber, secondNumber, operation) {
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
        cells.forEach(function (cell) {
            var id = parseInt(cell.textContent);
            if (id === one) {
                cell.style.backgroundColor = 'lightpink';
                cell.style.boxShadow = '0 0 10px 10px lightblue';
            }
            if (id > one && id <= sum) {
                setTimeout(function () {
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
                }, delay * counter *1.5);
                counter++;
            }
        });
    } else if (operation === "-") {
        var reversedCells = Array.from(cells).reverse();
        var sub = one - two;

        reversedCells.forEach(function (cell) {
            var id = parseInt(cell.textContent);
            if (id === one) {
                cell.style.backgroundColor = 'lightpink';
                cell.style.boxShadow = '0 0 10px 10px lightblue';
                cell.style.border = '5px solid lightpink';
            }

            if (id >= sub && id < one) {
                setTimeout(function () {
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
                }, delay * counter*1.5);
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

<!-- 
<script>
     function drag(){
            console.log("o111ke");
        }
    var container = document.getElementById("basket_plate");
    var an_1 = document.getElementById("basket");
    var an_2 = document.getElementById("plate");
    an_1.style.display = "none";
    an_2.style.display = "none";
    var an = document.getElementById("arrow");
    an.style.display = "none";
    var width = container.clientWidth;
    var height = container.clientHeight;
    var imagesHtml = "";
    for (var i = 0; i < <?php echo $_SESSION["dang_bai"][0]; ?>; i++) {    
        var img = document.createElement("img");    
        img.className = "";    
        img.src = "uploads/logo.png";    
        var newWidth = 100;    
        var newHeight = 80;    
        img.style.width = newWidth + "px";    
        img.style.height = newHeight + "px";    
        var centerX = width / 2;    
        var centerY = height / 2;    
        var radiusX = width / 2 - 100;    
        var radiusY = height / 2 - 100;    
        var angle = Math.random() * 2 * Math.PI;    
        var x = centerX + radiusX * Math.cos(angle);    
        var y = centerY + radiusY * Math.sin(angle);    
        img.style.left = (x - (newWidth / 2)) + "px";    
        img.style.top = (y - (newHeight / 2)) + "px";   
        img.addEventListener('click', drag);
        imagesHtml += img.outerHTML;}
        container.innerHTML = imagesHtml;
        // imagesHtml += "<br>";
        // for (var i = 0; i < 2; i++) {
        //     var img = document.createElement("img");    
        //     img.className = "ngoi_sao.png";    
        //     img.src = "uploads/ngoi_sao.png";    
        //     var newWidth = 100;    var newHeight = 80;    
        //     img.style.width = newWidth + "px";    img.style.height = newHeight + "px";    var centerX = width / 2;    var centerY = height / 2;    var radiusX = width / 2 - 100;    var radiusY = height / 2 - 100;    var angle = Math.random() * 2 * Math.PI;    var x = centerX + radiusX * Math.cos(angle);    var y = centerY + radiusY * Math.sin(angle);    img.style.left = (x - (newWidth / 2)) + "px";    img.style.top = (y - (newHeight / 2)) + "px";    imagesHtml += img.outerHTML;}
        //     container.innerHTML = imagesHtml;
       
</script>  -->
<script>
    function checkAnswer(){
        var dang_bai = <?php echo json_encode($_SESSION['dang_bai']); ?>;
        // console.log(dang_bai);
        check(dang_bai[1]);
        // console.log(dang_bai);
        function check(x){
            // let da_nguoi_daung=document.getElementById('objCount').innerHTML
            
            var inputt1_value = document.querySelectorAll('.phai>.anh').length;
            // var inputt2_value = document.getElementById('inputt2').value;
            // var inputt3_value = document.getElementById('inputt3').value;
            // var inputt5_value = document.getElementById('inputt5').value;

            var dataToSend = {
                dapanmot: inputt1_value,
                // pheptinh: inputt2_value,
                // dapanhai: inputt3_value,
                // ketqua:inputt5_value
            };

            localStorage.setItem('dulieu', JSON.stringify(dataToSend));

            var dung_input1 = false;
            // var dung_input2 = false;
            // var dung_input3 = false;
            // var dung_input5 = false;

            if (inputt1_value !== "" && x == inputt1_value) {
            dung_input1 = true;
            }

            // if (inputt3_value !== "" && z == inputt3_value) {
            // dung_input3 = true;
            // }

            // if (inputt2_value !== "" && y == inputt2_value) {
            // dung_input2 = true;
            // }

            // if (inputt5_value !== "" && o == inputt5_value) {
            // dung_input5 = true;
            // }

            // Hàm tô màu
            // function toMauDapAn(id, dung) {
            //     if (dung) {
            //         document.getElementById(id).style.border = "2px solid lightgreen";
            //         document.getElementById(id).style.boxShadow = "0 0 10px 10px lightgreen";
            //     } else {
            //         document.getElementById(id).style.border = "2px solid lightcoral";
            //         document.getElementById(id).style.boxShadow = "0 0 10px 10px lightcoral";
            //     }
            // }

            // Gọi hàm tô màu
            // toMauDapAn("inputt1", dung_input1);
            // toMauDapAn("inputt2", dung_input2);
            // toMauDapAn("inputt3", dung_input3);
            // toMauDapAn("inputt5", dung_input5);

            // Phát âm thanh
            var audioUrl;
            if (inputt1_value === "" ) {
                playAndHideVideoFalse();
            } else if (x == inputt1_value) {
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
    var local =localStorage.getItem('mucdo');
    var luu_vet1 = localStorage.getItem('luu_vet');
    $.ajax({
        url: 'file_database_d1.php',
        type: 'post',
        data: {
            hai: dataToSend,
            mucdo: local,
            luu_vet1 : luu_vet1
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





