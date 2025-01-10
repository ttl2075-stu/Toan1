let hasAnsweredOnce = false;
let lesson = JSON.parse(localStorage.getItem('d7k1_baiDien')) || []
let quizShow = ''

const divShow = document.querySelector('.show')
const btnCheck = document.querySelector('#check')
const divLesson = document.querySelector('.lesson')
const divPoint = document.querySelector('#diem')
const divNotice = document.querySelector('.notice')
show()
document.querySelector('#traloidien').classList.add('hidden')
if (lesson[0].kiemTra == 'chonmotlan') divNotice.innerHTML = 'Trả lời một lần duy nhất'
else if (lesson[0].kiemTra == 'cotrudiem') divNotice.innerHTML = 'Trả lời nhiều lần, trả nời sai sẽ trừ 20% số điểm của câu đấy, tối đa 4 lần sai'
else divNotice.innerHTML = 'Trả lời nhiều lần, tối đa 4 lần sai'

function show() {
    lesson.forEach((e, index) => {
        divLesson.innerHTML += `
        <button type="button" class="btn-quiz" id="btnQuiz${index}" onclick="showQuiz(${index})">${index + 1}</button>
        `
        let arrNum = arrCalculateFromString(e.bieuThuc)
        divShow.innerHTML += `
                            <div class="boxQuiz" id="box-quiz${index}">
                                <h1><deBai>${lesson[index].cauHoi}</deBai></h1>
                                    <center>
                                    <div class="box" style="display: flex; justify-content: center; align-items: center; margin: 50px 0;">
                                        <div class="box-phepTinh">
                                                    <div  class="box-num" id="box-num1">${arrNum[0]}</div>
                                                    <div  class="box-num" id="box-pheptinh">${arrNum[1]}</div>
                                                    <div  class="box-num" id="box-num2">${arrNum[2]}</div>
                                                    <div  class="box-num" id="box-num2">=</div>                                         
                                            </div>
                                            <div class="dien" id="dien${index}">
                                                <button id="incrementButton">&nbsp;<i class="fa-solid fa-angle-up"></i></button>
                                                <input type="number" name="checkA" id="checkA${index}" class="checkA inputStyle1">
                                                <button id="decrementButton">&nbsp;<i class="fa-solid fa-angle-down"></i></button>
                                            </div>
                                    </div>
                                        <div class="tags" id="tags${index}"></div>
                                        <div class="thuAm" id="thuAm${index}">
                                            <button id="recordButton" class="hidden"><i class="fa-solid fa-microphone"></i> Bắt đầu thu âm</button>
                                            <p id="result"></p>
                                        </div>
                                    </center>
                                <span id="notice${index}" style="color:#999999; font-size: 25px; font-weight: bold;"><span>
                            </div>
                            `
        if (lesson[index].dapAnTraLoiGanNhat != '') document.querySelector(`#checkA${index}`).value = lesson[index].dapAnTraLoiGanNhat
        console.log(lesson[index].dapAnTraLoiGanNhat)
        let tags = document.querySelector(`#tags${index}`)
        let Tags = document.querySelectorAll(`#tags${index} .tag`)
        let ranNum = Math.floor(Math.random() * 4);
        let arrTags = [e.dapAn]
        if (Tags.length != 4) {
            for (let i = 0; i < 4; i++) {
                let str = (i == ranNum) ? `<div class="tag" id="the${index}_${i}" draggable="true" ondragstart="drag(event)">${e.dapAn}</div>` :
                    `<div class="tag" id="the${index}_${i}" draggable="true" ondragstart="drag(event)">${getRandomNumberNotInArray(arrTags)}</div>`
                tags.innerHTML += str
            }
        }
    });
    showQuiz(0)
    showDiem()
}
if (lesson[quizShow].trangthai == 'Đã hoàn thành') {
    // document.querySelector(`#checkA${quizShow}`).value = lesson[quizShow].dapAnTraLoiGanNhat
    document.querySelector('.notice-container').classList.add('showNotice')

}
function Xemdapan() {
    document.querySelector(`#checkA${quizShow}`).value = lesson[quizShow].dapAn
    trangthaixem()
    showDiem()
}
function trangthaixem() {
    const inputs = document.querySelectorAll('.checkA');

    console.log(quizShow)
    inputs.forEach((input, index) => {
        console.log(index)
        if (index == quizShow) {
            const inputValue = input.value;
            let btnQuiz = document.querySelector(`#btnQuiz${index}`)
            if (inputValue == lesson[index].dapAn) {
                lesson[index].diem = 100 - (lesson[index].kiemTra == 'cotrudiem' ? 20 * lesson[index].soLanTraLoiSai : 0);
                khoaInput(input, index)
                btnQuiz.classList.add('btn-quiz-true')
                btnQuiz.classList.remove('btn-quiz-false')
            } else {
                lesson[index].soLanTraLoiSai++
                btnQuiz.classList.add('btn-quiz-false')
            }
            if (lesson[index].soLanTraLoiSai == 5 && lesson[index].kiemTra == 'cotrudiem') {
                lesson[index].diem = 0
                khoaInput(input, index)
            }
            lesson[index].dapAnTraLoiGanNhat = inputValue
            if (lesson[index].kiemTra == 'chonmotlan') khoaInput(input, index)
            lesson[index].diem -= (lesson[index].suDungTroGiupMuc >= 2 ? (lesson[index].suDungTroGiupMuc - 1) * 5 : 0)
            if (lesson[index].diem < 0) lesson[index].diem = 0
        }
    });
    document.querySelector('.dien').classList.add('hidden')
    document.querySelector('#traloikeotha').classList.add('hidden')
    document.querySelector('#traloithuam').classList.add('hidden')
    document.querySelector('#traloidien').classList.add('hidden')
    showDiem()
    upLocalStorage("d6k1_baiDien", lesson);
}
function showQuiz(index) {
    document.querySelectorAll('.boxQuiz').forEach(e => {
        e.classList.add('hidden')
        if (laySoTuChuoi(e.id)[0] == index) {
            e.classList.toggle('hidden')
        }
    })

    document.querySelectorAll('.btn-quiz').forEach(e => {
        if (e.classList.contains('isSelect-btn-quiz')) e.classList.remove('isSelect-btn-quiz')
        if (laySoTuChuoi(e.id)[0] == index) {
            e.classList.add('isSelect-btn-quiz')
            // console.log(quizShow = index)
            document.querySelector('#cauSo').innerHTML = `Đang làm câu ${index + 1}`
            return quizShow = index
        }
    })
}
// sua lai ham check
function checkAnswer() {
    const inputs = document.querySelectorAll('.checkA');
    console.log(quizShow)
    inputs.forEach((input, index) => {
        console.log(index)
        if (index == quizShow) {

            const inputValue = input.value;
            let btnQuiz = document.querySelector(`#btnQuiz${index}`)
            if (inputValue == lesson[index].dapAn) {
                lesson[index].diem = 100 - (lesson[index].kiemTra == 'cotrudiem' ? 20 * lesson[index].soLanTraLoiSai : 0);
                khoaInput(input, index)
                btnQuiz.classList.add('btn-quiz-true')
                btnQuiz.classList.remove('btn-quiz-false')
                playAndHideVideoTrue()
                document.querySelector('.dien').classList.add('hidden')
                document.querySelector('#traloikeotha').classList.add('hidden')
                document.querySelector('#traloithuam').classList.add('hidden')
                document.querySelector('#traloidien').classList.add('hidden')
            } else {
                lesson[index].soLanTraLoiSai++
                btnQuiz.classList.add('btn-quiz-false')
                playAndHideVideoFalse()
            }
            if (lesson[index].soLanTraLoiSai == 5 && lesson[index].kiemTra == 'cotrudiem') {
                lesson[index].diem = 0
                khoaInput(input, index)
            }
            lesson[index].dapAnTraLoiGanNhat = inputValue
            if (lesson[index].kiemTra == 'chonmotlan') khoaInput(input, index)
            lesson[index].diem -= (lesson[index].suDungTroGiupMuc >= 2 ? (lesson[index].suDungTroGiupMuc - 1) * 5 : 0)
            if (lesson[index].diem < 0) lesson[index].diem = 0
        }
    });
    showDiem()
    upLocalStorage("d7k1_baiDien", lesson);
}

function khoaInput(input, index) {
    input.addEventListener('mousedown', (event) => {
        event.preventDefault();
    })
    input.addEventListener('click', (event) => {
        event.preventDefault();
    })
    document.querySelector(`#notice${index}`).textContent = 'Kết thúc, đáp án là ' + lesson[index].dapAn
    if (lesson[index].soLanTraLoiSai == 3) document.querySelector(`#notice${index}`).textContent = 'Bạn đã trả lời sai 4 lần, đáp án là ' + lesson[index].dapAn
}

function showDiem() {
    let sum = 0
    lesson.forEach(e => {
        sum += e.diem
    })
    divPoint.innerHTML = parseInt(sum / lesson.length)
}

function showThe() {
    document.querySelector('.checkA').value = '';
    if (document.querySelector('.input-container-hep')) document.querySelector('.input-container-hep').style.display = 'none'
    document.querySelector('.checkA').style.display = 'block'
    document.querySelectorAll('.boxQuiz input').forEach(input => {
        input.setAttribute('readonly', true);
    });
    document.querySelectorAll('.tag').forEach(u => {
        u.classList.remove('hiddenThe');
    });
    document.querySelectorAll('.tags').forEach(u => {
        u.classList.add('showtags');
    });
    document.querySelectorAll('.thuAm button').forEach(u => {
        u.classList.add('hidden');
    });
    document.querySelector('#incrementButton').classList.add('hidden')
    document.querySelector('#decrementButton').classList.add('hidden')
    document.querySelector('#traloikeotha').classList.add('hidden')
    document.querySelector('#traloithuam').classList.remove('hidden')
    document.querySelector('#traloidien').classList.remove('hidden')
}

function showDien() {
    document.querySelector('.checkA').value = '';
    if (document.querySelector('.input-container-hep')) {
        document.querySelector('.input-container-hep').style.display = 'flex'
    }
    if (lesson[quizShow].mucHelp > 1) document.querySelector('.checkA').style.display = 'none'
    document.querySelectorAll('.boxQuiz input').forEach(input => {
        input.removeAttribute('readonly');
    });
    document.querySelectorAll('.tag').forEach(u => {
        u.classList.remove('hiddenThe');
    });
    document.querySelectorAll('.tags').forEach(u => {
        u.classList.remove('showtags');
    });
    document.querySelectorAll('.thuAm button').forEach(u => {
        u.classList.add('hidden');
    });
    document.querySelector('#incrementButton').classList.remove('hidden')
    document.querySelector('#decrementButton').classList.remove('hidden')
    document.querySelector('#traloikeotha').classList.remove('hidden')
    document.querySelector('#traloithuam').classList.remove('hidden')
    document.querySelector('#traloidien').classList.add('hidden')
}

function showThuAM() {
    document.querySelector('.checkA').value = '';
    if (document.querySelector('.input-container-hep')) document.querySelector('.input-container-hep').style.display = 'none'
    document.querySelector('.checkA').style.display = 'block'
    document.querySelectorAll('.boxQuiz input').forEach(input => {
        input.setAttribute('readonly', true);
    });
    // document.querySelector('.dien').classList.add('hidden')
    document.querySelectorAll('.thuAm button').forEach(u => {
        u.classList.remove('hidden')
    });
    document.querySelectorAll('.tag').forEach(u => {
        u.classList.add('hiddenThe');
    });
    document.querySelector('#incrementButton').classList.add('hidden')
    document.querySelector('#decrementButton').classList.add('hidden')
    document.querySelector('#traloikeotha').classList.remove('hidden')
    document.querySelector('#traloithuam').classList.add('hidden')
    document.querySelector('#traloidien').classList.remove('hidden')
}


const recordButton = document.getElementById('recordButton');
const inputNumber = document.getElementById(`checkA${quizShow}`);

let recordedChunks = [];

recordButton.addEventListener('click', startRecording);

let isRecording = false;

function startRecording() {
    if (!isRecording) {
        recognition = new webkitSpeechRecognition();
        recognition.lang = 'vi-VN';
        recognition.onstart = function () {
            document.getElementById("recordButton").innerHTML = "Đang thu âm...";
            isRecording = true;
        };
        recognition.onresult = function (event) {
            const recordedSpeech = event.results[0][0].transcript;
            console.log(recordedSpeech)
            console.log("so la" + findNumbersInString(recordedSpeech))
            inputNumber.value = findNumbersInString(recordedSpeech)[0];
            stopRecording();
        };
        recognition.onerror = function (event) {
            console.error('Error occurred while recognizing speech:', event.error);
            stopRecording();
        };
        recognition.onend = function () {
            stopRecording();
        };
        recognition.start();
    }
}

function stopRecording() {
    recognition.stop();
    document.getElementById("recordButton").innerHTML = "Bắt đầu thu âm";
    isRecording = false;
}
function findNumbersInString(str) {
    let numbersArray = str.match(/\d+/g) || [];
    let resultArray = numbersArray.map(num => {
        return parseInt(num, 10);
    })
    return resultArray;
}

const incrementButton = document.getElementById("incrementButton");
const decrementButton = document.getElementById("decrementButton");

// Thiết lập sự kiện click cho nút tăng
incrementButton.addEventListener("click", function () {
    // Tăng giá trị trong ô input
    if (inputNumber.value === '') {
        inputNumber.value = 0;
    }
    inputNumber.value = parseInt(inputNumber.value) + 1;
});


// Thiết lập sự kiện click cho nút giảm
decrementButton.addEventListener("click", function () {
    // Giảm giá trị trong ô input, nhưng không thể nhỏ hơn 0
    if (inputNumber.value === '') {
        inputNumber.value = 0;
    }
    const newValue = parseInt(inputNumber.value) - 1;
    inputNumber.value = newValue >= 0 ? newValue : 0;
});