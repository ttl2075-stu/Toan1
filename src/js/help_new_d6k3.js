const btnHelp = document.querySelector('#help')
const divHelp = document.querySelector('.help-container')
const showHelp = document.querySelector('.show-help')
btnHelp.addEventListener('click', help);
let hasAnsweredOnce = false;
// let lesson = JSON.parse(localStorage.getItem('d6k3_baiDien')) || []

const divbtnHelps = document.querySelector('#nuthotro')

let index = 0
let arrSo = arrCalculateFromString(lesson[index].bieuThuc);
let dap_an = lesson[index].dapAn

let arrHelp = convertStringToTriplets(btnHelp.value)
let mySetKHT = new Set();
arrHelp.forEach(u => {
    mySetKHT.add(u.kieuHoTro);
})

let loai_hien_thi = JSON.parse(localStorage.getItem('loai_hien_thi')) || []
// Duyệt qua từng phần tử trong mySetKHT
mySetKHT.forEach((u) => {
    console.log(u)
    var buttonLabel = '';
    var buttonImage = '';

    // Xác định label và text cho từng button dựa trên giá trị của u
    switch (u) {
        case 22:
            buttonLabel = "Hỗ trợ đọc hiểu đề";
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
            if(loai_hien_thi == 3){
                buttonLabel = "Hỗ trợ bằng tia số/bảng số";
                buttonImage = "./icon/toanhoc.png"; // Đường dẫn đến ảnh cho hỗ trợ này
                break;
            }else if(loai_hien_thi == 6){
                buttonLabel = "Hỗ trợ bằng hình ảnh trực quan";
                buttonImage = "./icon/toanhoc.png"; // Đường dẫn đến ảnh cho hỗ trợ này
                break;
            }
        case 25:
            buttonLabel = "Hỗ trợ đọc kết quả";
            buttonImage = "./icon/ketqua.png"; // Đường dẫn đến ảnh cho hỗ trợ này
            break;
        case 12:
            buttonLabel = "Hỗ trợ hiểu đề";
            buttonImage = "./icon/hotro.png"; // Đường dẫn đến ảnh cho hỗ trợ này
            break;
       case 15:
            buttonLabel = "Hỗ trợ đọc kết quả - giải bài";
            buttonImage = "./icon/ketqua.png"; // Đường dẫn đến ảnh cho hỗ trợ này
            break;
        case 26:
            buttonLabel = "Giai thích yêu cầu đề";
            buttonImage = "./icon/hotro.png"; // Đường dẫn đến ảnh cho hỗ trợ này
            break;
        default:
            break;
    }

    var buttonHTML = `<button type="button" style="width: 450px; height=50px;" class="btn kht hinhThucHelp" id="btn-kieuhotro${u}" onclick='daSuDung(${u})'>
                      <img src="${buttonImage}" alt="Image" style="width: 30px; height: 30px;">
                      ${buttonLabel} 
                  </button>`;

    // var speakerHTML = `<button type="button" class="speaker" onclick="readButtonContent('btn-kieuhotro${u}')"><img src="./icon/listen.png" alt="Image" style="width: 30px; height: 30px;"></button>`;
    var speakerHTML = `<button type="button" class="speaker" onclick="readButtonContent('btn-kieuhotro${u}')"><i class="fa-solid fa-hand-point-right"></i><i class="fa-solid fa-volume-high"></i></button>`;

    // Thêm button và loa vào divbtnHelps
    divbtnHelps.innerHTML += buttonHTML + " "+speakerHTML + "<br>";
});

function hiddenHelpdiv() {
    divHelp.classList.add('hidden')
    divHelp.classList.remove('show')
}


function daSuDung(u) {
    console.log("hỗ trợ:"+u);
    
    let nuthelp = document.querySelector(`#btn-kieuhotro${u}`);
    const showHelp = document.querySelector('.show-help')
    nuthelp.classList.add('tungSuDung');
    nuthelp.style.background = 'rgb(0, 229, 255)'
    lesson[index].suDungTroGiupMuc++
    bieuthuc = lesson[index].bieuThuc
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
            
                // document.getElementById('contain_1').style.paddingTop="100px";
        }
    }else if (u == 26) {
        console.log("u"+u);
        // them_lu_vet("luu_vet", 3)
        if(result[0].kieuHoTroChiTiet == 20){ 
            if(localStorage.getItem('mucdo') < 2){
                localStorage.setItem('mucdo', 2);
            }
            if(loai_hien_thi == 8){
                ho_tro_d4k2()
            }else{
                dochieuyeucaude()
            }
            if (lesson[index].mucHelp < 2) lesson[index].mucHelp = 2
            hiddenHelpdiv()
            // document.getElementById('contain_1').style.paddingTop="100px";
        }
    } else if (u == 23) {
        them_lu_vet("luu_vet", 3)
        // console.log("24: "+u);
        if(result[0].kieuHoTroChiTiet == 17){
            if(loai_hien_thi == 3){
                showdochinhanh();
            }else if(loai_hien_thi == 6){
                giaithichde_phepsosanh()
            }
            if(localStorage.getItem('mucdo') < 2){
                localStorage.setItem('mucdo', 2);
            }
            if (lesson[index].mucHelp < 2) lesson[index].mucHelp = 2
            hiddenHelpdiv()
            // document.getElementById('contain_1').style.paddingTop="100px";
        }
    }else if (u == 24) {
        them_lu_vet("luu_vet", 4)
        
        
        if(result[0].kieuHoTroChiTiet == 18){
            if(loai_hien_thi == 3){
                showhiennoidung();
            }else if(loai_hien_thi == 6){
                showhiennoidung_phepsosanh()
            }
            if(localStorage.getItem('mucdo') < 3){
                localStorage.setItem('mucdo', 3);
            }
            if (lesson[index].mucHelp < 3) lesson[index].mucHelp = 3
            hiddenHelpdiv()
                // document.getElementById('contain_1').style.paddingTop="100px";
        }
    }else if (u == 25) {
        them_lu_vet("luu_vet", 7)
        if(result[0].kieuHoTroChiTiet == 19){
            if(loai_hien_thi == 3){
                docketqua()
                if(localStorage.getItem('mucdo') < 5){
                    localStorage.setItem('mucdo', 5);
                }
            }else if(loai_hien_thi == 6){
                docketqua_phepsosanh()
                if(localStorage.getItem('mucdo') < 5){
                    localStorage.setItem('mucdo', 5);
                }
            }else if(loai_hien_thi == 8 || loai_hien_thi == 7 || loai_hien_thi == 20 || loai_hien_thi == 12){
                doc_cach_lam()
                if(localStorage.getItem('mucdo') < 3){
                    localStorage.setItem('mucdo', 3);
                }
            }
            if (lesson[index].mucHelp < 5) lesson[index].mucHelp = 5
            hiddenHelpdiv()
            // document.getElementById('contain_1').style.paddingTop="100px";
        }
    } else if (u == 19) {
        var shos = document.getElementsByClassName('show-help');
        for (var i = 0; i < shos.length; i++) {
            shos[i].style.display = 'block';
        }
        if(localStorage.getItem('mucdo') < 4){
            localStorage.setItem('mucdo', 4);
        }
        showHelp.innerHTML = '';
        result.forEach(i => {
            if(loai_hien_thi == 3){
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
                }else if (i.kieuHoTroChiTiet == 14) {
                    showHelp.innerHTML += `<button type="button" style="width: 400px" class="btn hinhThucHelp" id="help${u}" onclick="helpTiaSo('${bieuthuc}')">
                    <img src="./icon/tiaso.png" alt="TiaSo Image" style="width: 50px; height: 50px;">
                    Tia số
                    </button><br>`;
                }
            }else if(loai_hien_thi = 6){
                if (i.kieuHoTroChiTiet == 23) {
                    showHelp.innerHTML += `<button type="button" style="width: 400px" class="btn hinhThucHelp" id="help${u}" onclick="helpCasau(${arrSo[0]}, ${arrSo[2]}, '${arrSo[1]}')">
                    <img src="./icon/tiaso.png" alt="TiaSo Image" style="width: 50px; height: 50px;">
                    Cá sấu
                    </button><br>`;
                }else if (i.kieuHoTroChiTiet == 25) {
                    showHelp.innerHTML += `<button type="button" style="width: 400px" class="btn hinhThucHelp" id="help${u}" onclick="ghep_anh(${arrSo[0]}, ${arrSo[2]}, '${arrSo[1]}')">
                    <img src="./icon/tiaso.png" alt="TiaSo Image" style="width: 50px; height: 50px;">
                    Ghép số
                    </button><br>`;
                }
            }
        })
        divbtnHelps.style.display = 'none'
    }
    if (loaihienthi == 3) upLocalStorage("d6k3_baiDien", lesson);
    if(loaihienthi == 4)  upLocalStorage("d4k1_baiDien", lesson);
}


function docketqua_phepsosanh() {
    text = "Phép tinh:" + arrSo[0] + arrSo[1] + arrSo[2] ;
    speakVietnamese(text);
}


function giaithichde_phepsosanh(){
    text = "Bên trái có số lượng hình là" + arrSo[0] +"và bên phải có số lượng hình là" + arrSo[1];
    speakVietnamese(text);
}

function showhiennoidung_phepsosanh() {
    document.getElementById('inputt1').value = arrSo[0];
    document.getElementById('inputt3').value = arrSo[2];
    // em thêm 3 dòng dưới
    document.getElementById('inputt1').style.boxShadow = "0 0 10px 10px pink";
    document.getElementById('inputt1').style.background = "pink";
    document.getElementById('inputt3').style.boxShadow = "0 0 10px 10px skyblue";
    document.getElementById('inputt3').style.background = "skyblue";

    var msg_3 = new SpeechSynthesisUtterance();
    msg_3.text = "Phép tính đã được điền. Hãy điền phép so sánh";
    msg_3.lang = 'vi-VN';
    msg_3.volume = 1;
    msg_3.rate = 0.75;
    msg_3.pitch = 1.5;
    window.speechSynthesis.speak(msg_3);
}

function help(){
    // var shos = document.getElementsByClassName('show-help');
    // for (var i = 0; i < shos.length; i++) {
    //     shos[i].style.display = 'none';
    // }

    // document.getElementById('tableContainer').style.display = 'none';
    // document.getElementById('support').style.display = 'none';
    
    // document.getElementById('helpcontain').style.position = 'fixed';
    // document.getElementById('helpcontain').style.top = '13%'; // Điều chỉnh kích thước của top ở đây
    // document.getElementById('helpcontain').style.display = 'block';

    // document.getElementById('basket').style.display="none";
    // document.getElementById('plate').style.display="none";
    // document.getElementById('basket_plate').style.display="none";
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
    if (arrSo[1] === "+") { 
        text = "Trên hình, có hai đồ vật. Đồ vật thứ nhất có số lượng là" + arrSo[0] + "hình. Ta lấy thêm đồ vật thứ hai có số lượng là" + arrSo[2] + "hình. Vậy có tất cả là bao nhiêu";
        speakVietnamese(text);
    } else if (arrSo[1] === "-") { 
        text = "Ở ô màu hồng phía bên trái, có " + arrSo[0] + " hình. Ta bỏ bớt " + arrSo[2] + " hình ở ô màu xanh phía bên phải. Vậy còn lại bao nhiêu hình";
        speakVietnamese(text);
    }
}

function dochieuyeucaude(){
    text = "Hãy quan sát bức ảnh, và đếm số lượng con vật trong bức ảnh nhé."
    speakVietnamese(text)
}
function docketqua() {
    text = "Phép tinh:" + arrSo[0] + arrSo[1] + arrSo[2] + "bằng" + dap_an[0];
    speakVietnamese(text);
}

var dap_an_loai_7 = JSON.parse(localStorage.getItem('dap_an')) || [];
function doc_cach_lam(){
    upLocalStorage('multiple_choices',"");
    var multi = [];
    for(var i = 0; i < dap_an_loai_7.length; i++){
        var element = document.getElementById(i);
        console.log(element)
        if(dap_an_loai_7[i] == 1){
            element.style.backgroundColor = 'lightpink';
            element.classList.add('clicked');
            multi.push(i);
        }else{
            element.style.backgroundColor = '';
            element.classList.remove('clicked');
        }
    }
    upLocalStorage('multiple_choices',multi);
}

function showhiennoidung() {
    document.getElementById('inputt1').value = arrSo[0];
    document.getElementById('inputt2').value = arrSo[1];
    document.getElementById('inputt3').value = arrSo[2];
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
    window.speechSynthesis.speak(msg_3);
}

function arrCalculateFromString(expression) {
    return expression.split(/([()+\-*/><=])/).filter(function(e) { return e.trim().length > 0; });
}

function upLocalStorage(key, value) {
    localStorage.setItem(key, JSON.stringify(value))
}

// Hàm tia số
function helpTiaSo(bieuthuc) {
    // var shos = document.getElementsByClassName('show-help');
    // for (var i = 0; i < shos.length; i++) {
    //     shos[i].style.display = 'block';
    // }
    // document.getElementById('support').style.display = 'block';
    // document.getElementById('contain_1').style.paddingTop = '33px';
    // var elements = document.getElementsByClassName('help-container');
    // for (var i = 0; i < elements.length; i++) {
    //     elements[i].style.position = 'fixed';
    //     elements[i].style.top = '35%'; // Điều chỉnh kích thước của top ở đây
    // }
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
function ghep_anh(firstNumber, secondNumber, operation){
    them_lu_vet("luu_vet", 9)
    showHelp.innerHTML = '';
    var quanh_ham = document.createElement('div');
    quanh_ham.id = "quanh_ham";
    var so1 = document.createElement('div');
    so1.id = "so1";
    so1.textContent = firstNumber;
    var container = document.getElementById('tableContainer');
    container.innerHTML = "";
    var table = document.createElement('table');
    var u = 1;

    var thresholdOne = parseInt(firstNumber / 10);
    var chia_du_so_1 = parseInt(firstNumber % 10) + thresholdOne
    console.log(thresholdOne)
    console.log(chia_du_so_1)
    var thresholdTwo = parseInt(secondNumber / 10);
    console.log(thresholdTwo)
    var chia_du_so_2 = parseInt(secondNumber % 10) + thresholdTwo;
    var z = 1;
    for (var i = 0; i < 2; i++) {
        var row = document.createElement('tr');
        for (var j = 0; j < 10; j++) {
                var cell = document.createElement('td');
                cell.className = u;
                var div = document.createElement('div');
                div.className = 'bocso';
                if(firstNumber > 10 || secondNumber > 10){
                    if(firstNumber > 10 && u <= thresholdOne && i == 0){
                        var image = document.createElement('img');
                        image.className = 'img-above-number anh_hong';
                        image.src = 'uploads/boque.png';
                        div.appendChild(image);
                    }else if(firstNumber > 10 && i == 0 && u <= chia_du_so_1){
                        var image = document.createElement('img');
                        image.className = 'img-above-number_1 anh_hong';
                        image.src = 'uploads/motque.png';
                        div.appendChild(image);
                    }else if(firstNumber < 10 && u <= firstNumber && i == 0){
                        var image = document.createElement('img');
                        image.className = 'img-above-number_1 anh_hong';
                        image.src = 'uploads/motque.png';
                        div.appendChild(image);
                    }else if(secondNumber > 10 && z <= thresholdTwo && i == 1){
                        var image = document.createElement('img');
                        image.className = 'img-above-number anh_xanh';
                        image.src = 'uploads/boque.png';
                        div.appendChild(image);
                        z++;
                    }else if(secondNumber > 10 && z <= chia_du_so_2 && i == 1){
                        var image = document.createElement('img');
                        image.className = 'img-above-number_1 anh_xanh';
                        image.src = 'uploads/motque.png';
                        div.appendChild(image);
                        z++;
                    }else if(secondNumber < 10 && z <= secondNumber && i == 1){
                        var image = document.createElement('img');
                        image.className = 'img-above-number_1 anh_xanh';
                        image.src = 'uploads/motque.png';
                        div.appendChild(image);
                        z++;
                    }
                }else{
                    if(u <= firstNumber && i == 0){
                        var image = document.createElement('img');
                        image.className = 'img-above-number_1 anh_hong';
                        image.src = 'uploads/motque.png';
                        div.appendChild(image);
                    }else if(z <= secondNumber && i == 1){
                        var image = document.createElement('img');
                        image.className = 'img-above-number_1 anh_xanh';
                        image.src = 'uploads/motque.png';
                        div.appendChild(image);
                        z++;
                    }
                }
                cell.appendChild(div);
                row.appendChild(cell);    
                u++;
        }
        table.appendChild(row);
    }
    quanh_ham.appendChild(so1);
    quanh_ham.appendChild(table);
    var so2 = document.createElement('div');
    so2.id = "so2";
    so2.textContent = secondNumber;
    quanh_ham.appendChild(so2);
    container.appendChild(quanh_ham)
    // draw_picture(firstNumber, secondNumber, operation);
}


// Hàm tạo bảng
function drawTable(firstNumber, secondNumber, operation) {
    // them_lu_vet("luu_vet", 13)
    // console.log(firstNumber)
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

function ho_tro_d4k2(){
    text = "Hãy đếm số lượng đồ vật ở một bức ảnh";
    speakVietnamese(text);
}
// Hàm tạo hiệu ứng
function animateColor(one, two, operation) {
    them_lu_vet("luu_vet", 13)
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
                }, delay * counter * 1.5);
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
function readButtonContent(buttonId) {
    var button = document.getElementById(buttonId);
    var buttonText = button.innerText;
    speakVietnamese(buttonText);
}
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

function helpCasau(sohangmot, sohanghai, phepsosanh) {
    them_lu_vet("luu_vet", 8)
    console.log(sohangmot, phepsosanh, sohanghai)
    var casau;
    showHelp.innerHTML = '';
    var container = document.getElementById('tableContainer');
    container.innerHTML = "";
   
    if (phepsosanh == "=") {
        casau = "uploads/bangnhau.png";
    } else if (phepsosanh == ">") {
        casau = "uploads/lonhon.png";
    } else if (phepsosanh == "<") {
        casau = "uploads/nhohon.png";
    }

    // Tạo phần tử hình ảnh cho số hạng thứ nhất
    var so1 = document.createElement("span");
    so1.textContent = sohangmot;
    so1.className = "so";

    // Tạo phần tử hình ảnh cho dấu so sánh
    var image = document.createElement("img");
    image.src = casau;
    image.className = "anhsosanh";
    // Tạo phần tử hình ảnh cho số hạng thứ hai
    var so2 = document.createElement("span");
    so2.textContent = sohanghai;
    so2.className = "so";

    // Tạo phần tử div chứa tất cả các phần tử trên
    var div = document.createElement("div");
    div.appendChild(so1);
    div.appendChild(image);
    div.appendChild(so2);
    div.className = "boccasau";
    // Thêm div vào một phần tử có ID là "ketqua"
    container.appendChild(div);
}
// function show(){
//     document.getElementById('helpcontain').style.display = 'none';
//     if(arrSo[1] === "-"){
//         document.getElementById('basket').style.display="block";
//         document.getElementById('plate').style.display="block";
//     }else{
//         document.getElementById('basket_plate').style.display="block";
//     }
// }