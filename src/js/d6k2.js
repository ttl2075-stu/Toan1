const btnHelp = document.querySelector('#help')
const divHelp = document.querySelector('.help-container')
const showHelp = document.querySelector('.show-help')
btnHelp.addEventListener('click', help);
let hasAnsweredOnce = false;
let lesson = JSON.parse(localStorage.getItem('d6k2_baiDien')) || []
const divbtnHelps = document.querySelector('.nuthotro')
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
// function speakVietnamese(randomNum) {
//     return new Promise((resolve, reject) => {
//         let msg = new SpeechSynthesisUtterance();
//         msg.text = randomNum;
//         msg.lang = 'vi-VN';

//         // Thay đổi giọng nói và tốc độ
//         msg.voice = speechSynthesis.getVoices().find(voice => voice.lang === 'vi-VN');
//         msg.rate = 0.6; // Tốc độ mặc định là 1, giảm xuống để chậm hơn

//         msg.onend = function (event) {
//             resolve(); // Khi giọng nói kết thúc, giải quyết promise
//         };
//         window.speechSynthesis.speak(msg);
//     });
// }
//begin 27/07/2024
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

// Duyệt qua từng phần tử trong mySetKHT
mySetKHT.forEach((u) => {
    var buttonLabel = '';
    var buttonText = '';
    
   
    
    // Xác định label và text cho từng button dựa trên giá trị của u
    switch (u) {
        case 15:
            buttonLabel = "Hỗ trợ đọc kết quả";
            buttonImage = "./icon/ketqua.png"; // Đường dẫn đến ảnh cho hỗ trợ này
            break;
        case 21:
            return;
            buttonLabel = "Hỗ trợ cộng các số theo từng hàng";
        case 19:
            buttonLabel = "Hỗ trợ bằng tia số/bảng số";
            buttonImage = "./icon/toanhoc.png"; // Đường dẫn đến ảnh cho hỗ trợ này
            break;
        case 20:
            buttonLabel = "Hỗ trợ bằng hình ảnh/đồ dùng";
            buttonImage = "./icon/dovat.png"; // Đường dẫn đến ảnh cho hỗ trợ này
            break;
        case 17:
            return;
            buttonLabel = "Thực hiện hỗ trợ đặt tính";
        case 16:
            buttonLabel = "Hỗ trợ đọc phép tính";
            buttonImage = "./icon/dem.png"; // Đường dẫn đến ảnh cho hỗ trợ này
            break;
        case 18:
            buttonLabel = "Hỗ trợ đọc đề bài";
            buttonImage = "./icon/hotro.png"; // Đường dẫn đến ảnh cho hỗ trợ này
            break;
        default:
            return;
    }

    // Tạo HTML cho button và loa
    var buttonHTML = `<button type="button" style="width: 450px; height=50px;" class="btn kht hinhThucHelp" id="btn-kieuhotro${u}" onclick='daSuDung(${u})'>
                      <img src="${buttonImage}" alt="Image" style="width: 30px; height: 30px;">
                      ${buttonLabel} 
                  </button>`;
    // var speakerHTML = `<button class="speaker" type="button" onclick="readButtonContent('btn-kieuhotro${u}')"><img src="./icon/listen.png" alt="Image" style="width: 40px; height: 40px;"></button>`;
    var speakerHTML = `<button type="button" class="speaker" onclick="readButtonContent('btn-kieuhotro${u}')"><i class="fa-solid fa-hand-point-right"></i><i class="fa-solid fa-volume-high"></i></button>`;
    // Thêm button và loa vào divbtnHelps
    divbtnHelps.innerHTML += buttonHTML + " "+speakerHTML + "<br>";
});

function hiddenHelpdiv() {
    divHelp.classList.add('hidden')
    divHelp.classList.remove('show')
}

function daSuDung(u) {
    // console.log("a:"+u);
    let index = 0
    let lesson = JSON.parse(localStorage.getItem('d6k2_baiDien')) || []
    let arrSo = arrCalculateFromString(lesson[index].bieuThuc)
    // console.log(arrSo);
    let nuthelp = document.querySelector(`#btn-kieuhotro${u}`);
    nuthelp.classList.add('tungSuDung');
    nuthelp.style.background = 'rgb(0, 229, 255)'
    lesson[index].suDungTroGiupMuc++
    bieuthuc = lesson[index].bieuThuc
    const result = arrHelp.filter(item => item.kieuHoTro === u);
   
    if (u == 18) {
        them_lu_vet("luu_vet", 1)
        if(result[0].kieuHoTroChiTiet == 10){
            console.log(2)
            if(localStorage.getItem('mucdo_2') < 1){
                localStorage.setItem('mucdo_2', 1);
            }
            showdocde()
            if (lesson[index].mucHelp < 1) lesson[index].mucHelp = 1
            hiddenHelpdiv()
        }
    } else if (u == 16) {
        them_lu_vet("luu_vet", 3)
        if(result[0].kieuHoTroChiTiet == 8){
            if(localStorage.getItem('mucdo_2') < 2){
                localStorage.setItem('mucdo_2', 2);
            }
            hotrodocdeD6K2_1()
            if (lesson[index].mucHelp < 2) lesson[index].mucHelp = 2
            hiddenHelpdiv()
        }
    } else if (u == 17) {
        if(result[0].kieuHoTroChiTiet == 9){
            if(localStorage.getItem('mucdo_2') < 3){
                localStorage.setItem('mucdo_2', 3);
            }
            hotrodocde(index)
            if (lesson[index].mucHelp < 3) lesson[index].mucHelp = 3
            hiddenHelpdiv()
        }
    } else if (u == 21) {
        if(result[0].kieuHoTroChiTiet == 15){
            if(localStorage.getItem('mucdo_2') < 4){
                localStorage.setItem('mucdo_2', 4);
            }
            hotrodocde(index)
            if (lesson[index].mucHelp < 4) lesson[index].mucHelp = 4
            hiddenHelpdiv()
        }
    } else if (u == 19 || u == 20) {
        console.log(result)
        showHelp.innerHTML = ''
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
        if (lesson[index].mucHelp < 5 && u == 19) {
            lesson[index].mucHelp = 5
            if(localStorage.getItem('mucdo_2') < 5){
                localStorage.setItem('mucdo_2', 5);
            }
        }
        if (lesson[index].mucHelp < 6 && u == 20) {
            lesson[index].mucHelp = 6
            if(localStorage.getItem('mucdo_2') < 6){
                localStorage.setItem('mucdo_2', 6);
            }
        }
    } else if (u == 15){
        them_lu_vet("luu_vet", 7)
        if(result[0].kieuHoTroChiTiet == 7){
            if(localStorage.getItem('mucdo_2') < 7){
                localStorage.setItem('mucdo_2', 7);
            }
            docketqua()
            if (lesson[index].mucHelp < 7) lesson[index].mucHelp = 7
            hiddenHelpdiv()
        }
    }
}

function help(){
    let index = 0
    let lesson = JSON.parse(localStorage.getItem('d6k2_baiDien')) || []
    if (lesson[index].dapAnTraLoiGanNhat != lesson[index].dapAn) {
        divHelp.classList.add('show')
        divbtnHelps.style.display = 'block'
        showHelp.innerHTML = ''
    }
}
function convertStringToTriplets(inputString) {
    // Tạo một mảng để lưu trữ các mảng con
    var triplets = [];
    // Tách chuỗi thành các cặp số
    var tripletsStr = inputString.split('/');
    // Lặp qua từng cặp số
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

function convertStringToTriplets(inputString) {
    // Tạo một mảng để lưu trữ các mảng con
    var triplets = [];
    // Tách chuỗi thành các cặp số
    var tripletsStr = inputString.split('/');
    // Lặp qua từng cặp số
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

function hotrodocdeD6K2_1() {
    let cau_hoi = localStorage.getItem('d6k2_baiDien')
    cau_hoi = JSON.parse(cau_hoi);
    console.log(cau_hoi)
    let bieuthuc = "Phép tính" + cau_hoi[0]['bieuThuc'] + "bằng bao nhiêu";
    speakVietnamese(bieuthuc);
}


function showdocde() {
    let deBai = document.querySelector('#debais').textContent; 
    let text = "Câu hỏi là " + deBai;
    speakVietnamese(text);
}

function docketqua(){
    let cau_hoi = localStorage.getItem('d6k2_baiDien')
    cau_hoi = JSON.parse(cau_hoi);
    let bieuthuc = "Phép tính" + cau_hoi[0]['bieuThuc'] + "bằng" + eval(cau_hoi[0]['bieuThuc']);
    speakVietnamese(bieuthuc);
}

// Hàm tia số
function helpTiaSo(bieuthuc) {
    them_lu_vet("luu_vet", 14)
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

function addObj(id, num) {
    let zoneshow = document.querySelector(`#${id}`);
    let imgObj = document.createElement('img');
    let obj;
    if (num == 10) {
        obj = "./src/image/boque.png";
        imgObj.style.width = `50px`;
        imgObj.style.height = `100px`;
    } else {
        obj = "./src/image/motque.png";
        imgObj.style.width = `30px`;
        imgObj.style.height = `100px`;

    }
    imgObj.src = `${obj}`;
    imgObj.classList.add('imgObj');
    zoneshow.appendChild(imgObj); // Thêm divObj vào zoneshow thay vì imgObj
    const elements = document.querySelectorAll('[src*="./src/image/motque.png"]');
    if (elements.length >= 10) {
        for (let i = 0; i < 10; i++) {
            xoaAnh(1);
        }
        // speakVietnamese("Có 10 quả táo trên màn hình vì thế cho vào 1 giỏ táo").then(() => {
        addObj("num1", 10);
        // }).catch(error => {
        //     console.error('Đã xảy ra lỗi khi nói:', error);
        // });
    }
}

function helpQuetinh(bieuthuc, index) {
    them_lu_vet("luu_vet", 11)
    let arrSo = arrCalculateFromString(bieuthuc)
    let num1 = tachSoThanhPhan10(arrSo[0])
    let num2 = tachSoThanhPhan10(arrSo[2])
    showHelp.innerHTML = ''
    showHelp.innerHTML = `
        <div id="huongDanTinh"  class="box-phepTinh">
            <div style="display:flex; ">
                <div id="num1" style="display:flex; flex-direction: column;">
                    <div id="num1_10"></div>
                    <div id="num2_10"></div>
                    
                </div>
                <div id="num2" style="display:flex; flex-direction: column;">
                    <div id="num1_1"></div>
                    <div id="num2_1"></div>
                </div>
            </div>
            <div class="box-phepTinh strong-help-box"><span>${arrSo[0]}</span> <span>${arrSo[1]}</span> <span>${arrSo[2]}</span> <span>=</span> <span>?</span><div>
        </div>
        `

    num1.forEach((u) => {
        if (u == 10) {
            addObj("num1_10", 10)
        } else {
            for (let i = 0; i < u; i++) {
                addObj("num1_1", 1)
            }
        }
    })

    num2.forEach((u) => {
        if (u == 10) {
            addObj("num2_10", 10)
        } else {
            for (let i = 0; i < u; i++) {
                addObj("num2_1", 1)
            }
        }
    })


}


// lego
function generateLEGO(bieuthuc) {
    them_lu_vet("luu_vet", 12)
    showHelp.innerHTML = ''
    const legoContainer = document.getElementById("legoContainer");
    legoContainer.innerHTML = '';
    const math = bieuthuc.match(/[+\-*/]/g);
    const numbers = bieuthuc.match(/\d+/g);

    if (numbers) {
        let i = 0;
        numbers.forEach(number => {
            let legoDots = '';
            let legoCount = parseInt(number);

            while (legoCount > 0) {
                if (i === 0) {
                    legoDots += '<img src="./src/image/lego_1.png" width="50px">';
                }
                else {
                    legoDots += '<img src="./src/image/lego_2.png" width="50px">';
                }
                legoCount -= 1;
            }

            const legoImage = document.createElement("div");
            legoImage.innerHTML = legoDots;
            legoImage.classList.add("lego");
            legoContainer.appendChild(legoImage);

            if (i < math.length) {
                const mathImage = document.createElement("div");
                let mathDots = '';
                switch (math[i]) {
                    case '+':
                        mathDots += '<img src="./src/image/daucong.png" width="50px">';
                        break;
                    case '-':
                        mathDots += '<img src="./src/image/dautru.png" width="50px">';
                        break;
                }
                mathImage.innerHTML = mathDots;
                mathImage.style.display = "flex";
                mathImage.style.alignItems = "center";
                legoContainer.appendChild(mathImage);
            }

            i++;
        });

        // Thêm dấu bằng vào giữa hai cột lego
        const equalsImage = document.createElement("div");
        equalsImage.innerHTML = '<img src="./src/image/daubang.png" width="50px">';
        equalsImage.style.display = "flex";
        equalsImage.style.alignItems = "center";
        legoContainer.appendChild(equalsImage);

        // Thêm ô input kết quả vào giữa hai cột lego
        const answerInput = document.createElement("div");
        answerInput.innerHTML = '<input type="number" id="mathAnswer" placeholder="?">';
        answerInput.style.display = "flex";
        answerInput.style.alignItems = "center";
        legoContainer.appendChild(answerInput);
    }
}

// Hàm tạo bảng
function drawTable(firstNumber, secondNumber, operation) {
    them_lu_vet("luu_vet", 13)
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
                    // window.speechSynthesis.speak(speech);
                    speakVietnamese(speech.text);

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
                    // window.speechSynthesis.speak(speech);
                    speakVietnamese(speech.text);

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