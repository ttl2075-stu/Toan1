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
    $_SESSION['id_bai_tap_user'] = $_GET['id_bai_tap_user'];
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
        // print_r($_SESSION['dang_bai']);
        $_SESSION['id_bai'] = $id_mang;
        // print_r($_SESSION['id_bai']);
        echo $id_cau_hoi;
        $sql = "SELECT * FROM `dap_an_game_1` WHERE `id_cau_hoi`='$id_cau_hoi'";
        $kq = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($kq);
        $so_hang = $row['so_hang'];
        $so_cot = $row['so_co'];
        $so_max = $row['so_lon_nhat'];
        $tong = $row['tong'];
    
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
    <!-- Chuyen session php sang localstorage -->
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
        td{
            padding: 0px;
        }
        .matrix-table button{
            margin: 0px;
        }
        .matrix-table {
            border-collapse: collapse;
            /* background: darkcyan; */
            color: whitesmoke;
            border-radius: 10px;
           
            border:1px solid whitesmoke;
            --shadow:rgba(17, 17, 26, 0.1) 0px 8px 24px, rgba(17, 17, 26, 0.1) 0px 16px 56px, rgba(17, 17, 26, 0.1) 0px 24px 80px;
        }
       
        .matrix-button.clicked {
            /* background-color: #ffffff; */
            background-color: darkorange;
        }
        .matrix-button:hover{
            /* border: 1px solid lightcoral; */
            box-shadow: 0 0 0 2px rgba(218,102,123,1), 8px 8px 0 0 rgba(218,102,123,1);
        }
        .matrix-button.hidden {
            visibility: hidden;
        }
        .ket_qua{
            text-align: left;
            /* font-size: 34px; */
            /* padding-left: 100px; */
        }
        .gio_hang{
            width: 100%;
            height: auto;
            border: 1px lightcoral solid;
            text-align: center;
            font-size: 34px;
        }
        #objCount1{
            display: none;
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
<!-- <form action="" method="post" id="form_ban_dau"> -->
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
            <div class="result">
                
                <?php
                
                    
                    if($so_hang !="" && $so_cot !="" && $so_max!="" && $tong!=""){
                        echo "<table width='100%' cellpadding='5' cellspacing='5px'  class='matrix-table'>";
                        for ($i=0; $i < $so_hang; $i++) { 
                            echo "<tr>";
                            for ($j=0; $j < $so_cot; $j++) { 
                                $random_value = rand(1, $so_max);
                                echo "<td><button class='matrix-button' data-value='$random_value'>$random_value</button></td>";
                            }
                            echo "</tr>";
                        }
                        echo "</table>";
                    }else{
                        echo "Vui lòng nhập đầy đủ các trường";
                    }
                
            ?>

               
            </div>
            <div class="ket_qua" style="display: none;">
        
            </div>
            <div class="gio_hang" style="display: none;">
                <h3>Các cặp đã chọn</h3>
            </div>
            </div>
<!-- mới thêm -->
<script>
    function dem_so_lan_xuat_hien(){
            let matrixButtons = document.querySelectorAll('.matrix-button');
            let countOccurrences = {};

            // Đếm số lần xuất hiện của từng số
            matrixButtons.forEach(button => {
                let value = button.getAttribute('data-value');
               
                if(!button.classList.contains('clicked') && !button.classList.contains('hidden')){
                    if (countOccurrences[value]) {
                    countOccurrences[value]++;
                    } else {
                        countOccurrences[value] = 1;
                    }
                }
                
            });
            return countOccurrences
        }
    function chuyen_dt_sang_mang(obj){
        let result = [];
            // Duyệt qua các cặp key-value của đối tượng obj
        for (let key in obj) {
            if (obj.hasOwnProperty(key)) {
                let value = obj[key];
                // Thêm key vào mảng value lần
                for (let i = 0; i < value; i++) {
                    result.push(parseInt(key)); // Chuyển key về kiểu số nếu cần
                }
            }
        }
        return result 
    }
    function thong_ke_cac_cap(arr, target) {
        let result = [];
        let map = {};

        for (let i = 0; i < arr.length; i++) {
            let complement = target - arr[i];
            if (map[complement]) {
                result.push([complement, arr[i]]);
            }
            map[arr[i]] = true;
        }

        return result;
    }
   
    // hiển thị dữ liệu
    function hien_thi(a,b){
        let occurrence = {};

        // Duyệt từng key trong đối tượng a
        for (let key in a) {
            if (a.hasOwnProperty(key)) {
                let numKey = parseInt(key);
                let count = a[key];
                
                // Nếu key chưa tồn tại trong đối tượng occurrence, khởi tạo
                if (!occurrence[numKey]) {
                    occurrence[numKey] = {
                        count: count,
                        pairs: []
                    };
                }

                // Duyệt từng mảng con trong mảng b
                for (let i = 0; i < b.length; i++) {
                    // Kiểm tra xem numKey có trong mảng con b[i] không
                    if (b[i].includes(numKey)) {
                        // Thêm mảng con b[i] vào mảng pairs của numKey
                        occurrence[numKey].pairs.push(b[i]);
                    }
                }
            }
        }

        // Hiển thị thông tin vào thẻ div
        let ketQuaDiv = document.querySelector('.ket_qua');
        ketQuaDiv.innerHTML=""
        for (let key in occurrence) {
            if (occurrence.hasOwnProperty(key)) {
                let info = `Số ${key} xuất hiện ${occurrence[key].count} lần`;
                if (occurrence[key].count > 0) {
                    info += ` .Có ${occurrence[key].pairs.length} cặp là ${JSON.stringify(occurrence[key].pairs)}`;
                } else {
                    info += ` không có cặp`;
                }
                let p = document.createElement('p');
                p.textContent = info;
                ketQuaDiv.appendChild(p);
            }
        }

    }
    function hien_thi_gio_hang(a){
        let ketQuaDiv = document.querySelector('.gio_hang');
       
        let p = document.createElement('p');
        p.textContent = a;
        ketQuaDiv.appendChild(p);
       
    }
    let gio_hang = []
    let objCount=0
    document.addEventListener('DOMContentLoaded', function() {
        
        let selectedButtons = [];
        let tong = <?php echo $tong; ?>;
        let sl_xh=dem_so_lan_xuat_hien()
        let sl_xl_new = chuyen_dt_sang_mang(sl_xh)
        let sl_cac_cap=thong_ke_cac_cap(sl_xl_new, tong)
        // console.log(sl_xh);
        
        document.getElementById('objCount1').innerHTML=sl_cac_cap.length
        hien_thi(sl_xh,sl_cac_cap)
        document.querySelectorAll('.matrix-button').forEach(button => {
            button.addEventListener('click', function() {
                if (!button.classList.contains('clicked') && !button.classList.contains('hidden')) {
                    button.classList.add('clicked');
                    selectedButtons.push(button);
                    
                    if (selectedButtons.length === 2) {
                        let sum = 0;
                        selectedButtons.forEach(btn => {
                            sum += parseInt(btn.dataset.value);
                        });

                        if (sum === tong) {
                            let a=[]
                            selectedButtons.forEach(btn => {
                                a.push( parseInt(btn.dataset.value))
                                btn.classList.add('hidden');
                                
                            });
                            objCount++
                            // gio_hang.push(a)
                            hien_thi_gio_hang(a)
                            document.getElementById('objCount').innerHTML=objCount
                            
                            
                        } else {
                            selectedButtons.forEach(btn => {
                                btn.classList.remove('clicked');
                            });
                        }
                        
                        selectedButtons = [];
                        sl_xh=dem_so_lan_xuat_hien()
                        sl_xl_new = chuyen_dt_sang_mang(sl_xh)
                        sl_cac_cap=thong_ke_cac_cap(sl_xl_new, tong)
                        document.getElementById('objCount1').innerHTML=sl_cac_cap.length
                        // console.log(sl_cac_cap);
                        // document.getElementById('objCount1').innerHTML=sl_cac_cap
                        // console.log(sl_xh);
                        // console.log(sl_cac_cap);
                        hien_thi(sl_xh,sl_cac_cap)  
                        // console.log(gio_hang);
                        // hien_thi_gio_hang(gio_hang)
                    }
                }
            });
        });
        
    });
   
</script>
    

<!-- end đoạn mới thêm -->
            <div id="contain_1">
                <div id="contain_2">
                        <button onclick="hien_len()"><span id="objCount" style="font-size: 40px;">0</span></button>
                        <span id="objCount1" style="font-size: 40px;">0</span>
                        <button type="button" class="btn" id="check" name="btn_check" onclick="checkAnswer()"><img src="./icon/check.png" style="width:30px; height:30px;">Kiểm tra</button>
                        <button type="button" class="btn" id="help" name='btn_hd' value="16-22-1/17-23-2/18-24-3/13-19-4/14-19-4/19-25-5/"><img src="./icon/support.png" style="margin-right: 10px;">Hỗ trợ</button>
                
                    </div>
            </div>
        </div>

        <script>
            function hien_len(){
                let tt =  document.querySelector(".gio_hang").style.display
                if(tt=='none'){
                    document.querySelector(".gio_hang").style.display="block"
                }else{
                    document.querySelector(".gio_hang").style.display="none"
                    
                }
                
            }
            function allowDrop(ev) {
                ev.preventDefault();
            }

            function drag(ev) {
                ev.dataTransfer.setData("text", ev.target.id);
                // console.log(x);
            }

            function drop(ev) {
                ev.preventDefault();
                var data = ev.dataTransfer.getData("text");
                ev.target.appendChild(document.getElementById(data));
                let dem = document.querySelectorAll('.phai>.anh')
                console.log(dem.length);
                document.getElementById('objCount').innerHTML=dem.length
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
<!-- </form> -->
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
function speakVietnamese(randomNum) {
    return new Promise((resolve, reject) => {
        let msg = new SpeechSynthesisUtterance();
        msg.text = randomNum;
        msg.lang = 'vi-VN';

        // Thay đổi giọng nói và tốc độ
        msg.voice = speechSynthesis.getVoices().find(voice => voice.lang === 'vi-VN');
        msg.rate = 0.8; // Tốc độ mặc định là 1, giảm xuống để chậm hơn

        msg.onend = function (event) {
            resolve(); // Khi giọng nói kết thúc, giải quyết promise
        };

        window.speechSynthesis.speak(msg);
    });
}

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
    var speakerHTML = `<button class="speaker" onclick="readButtonContent('btn-kieuhotro${u}')"><i class="fa-solid fa-hand-point-right"></i><i class="fa-solid fa-volume-high"></i></button>`;
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
    let arrSo = arrCalculateFromString(lesson[index].bieuThuc)
    let nuthelp = document.querySelector(`#btn-kieuhotro${u}`);
    const showHelp = document.querySelector('.show-help')
    nuthelp.classList.add('tungSuDung');
    nuthelp.style.background = 'rgb(0, 229, 255)'
    lesson[index].suDungTroGiupMuc++
    bieuthuc = lesson[index].bieuThuc
    const result = arrHelp.filter(item => item.kieuHoTro === u);
    if (u == 22) {
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
        let objCount1= document.getElementById('objCount1').innerHTML
        console.log(objCount1);
        if(objCount1==0){
            playAndHideVideoTrue();
        }else{
            playAndHideVideoFalse();
        }
        
        
            // // Phát âm thanh
            // var audioUrl;
            // if (inputt1_value === "" ) {
            //     playAndHideVideoFalse();
            // } else if (x == 0) {
            //     playAndHideVideoTrue();
            // } else {
            //     playAndHideVideoFalse();
            // }
        
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

// $('#check').click(function() {
//     var dataToSend = localStorage.getItem('dulieu');
//     var local =localStorage.getItem('mucdo');
//     $.ajax({
//         url: 'file_database_d1.php',
//         type: 'post',
//         data: {
//             hai: dataToSend,
//             mucdo: local
//         },
//         success: function(response) {
//             alert("Đã nộp bài");
//         },
//         error: function(xhr, status, error) {
//             console.error(error);
//         }
//     });
// });
</script>

</body>
</html>





