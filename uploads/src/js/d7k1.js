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
else if (lesson[0].kiemTra == 'cotrudiem') divNotice.innerHTML = 'Trả lời nhiều lần, trả nời sai sẽ trừ 20% số điểm của câu đấy, tối đa 5 lần sai'
else divNotice.innerHTML = 'Trả lời nhiều lần, tối đa 5 lần sai'

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
                                        <div class="box-phepTinh">
                                                <div  class="box-num" id="box-num1">${arrNum[0]}</div>
                                                <div  class="box-num" id="box-pheptinh">${arrNum[1]}</div>
                                                <div  class="box-num" id="box-num2">${arrNum[2]}</div>
                                                <div  class="box-num" id="box-num2">=</div>
                                                <input type="number" name="checkA" id="checkA${index}" class="checkA inputStyle1">
                                                
                                        </div>
                                        <div class="tags" id="tags${index}"></div>
                                    </center>
                                <span id="notice${index}" style="color:#999999; font-size: 25px; font-weight: bold;"><span>
                            </div>
                            `
        let tags = document.querySelector(`#tags${index}`)
        let Tags = document.querySelectorAll(`#tags${index} .tag`)
        let ranNum = Math.floor(Math.random() * 6);
        let arrTags = [e.dapAn]
        if (Tags.length != 6) {
            for (let i = 0; i < 6; i++) {
                let str = (i == ranNum) ? `<div class="tag" id="the${index}_${i}" draggable="true" ondragstart="drag(event)">${e.dapAn}</div>` :
                    `<div class="tag" id="the${index}_${i}" draggable="true" ondragstart="drag(event)">${getRandomNumberNotInArray(arrTags)}</div>`
                tags.innerHTML += str
            }
        }
    });
    showQuiz(0)
    showDiem()
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
        if(index == quizShow){
    
            const inputValue = input.value;
            let btnQuiz = document.querySelector(`#btnQuiz${index}`)
            if (inputValue == lesson[index].dapAn) {
                lesson[index].diem = 100 - (lesson[index].kiemTra == 'cotrudiem' ? 20 * lesson[index].soLanTraLoiSai : 0);
                khoaInput(input, index)
                btnQuiz.classList.add('btn-quiz-true')
                btnQuiz.classList.remove('btn-quiz-false')
                playAndHideVideoTrue()
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
    if (lesson[index].soLanTraLoiSai == 5) document.querySelector(`#notice${index}`).textContent = 'Bạn đã trả lời sai 5 lần, đáp án là ' + lesson[index].dapAn
}

function showDiem() {
    let sum = 0
    lesson.forEach(e => {
        sum += e.diem
    })
    divPoint.innerHTML = parseInt(sum / lesson.length)
}

function showThe() {
    document.querySelectorAll('.boxQuiz input').forEach(input => {
        input.setAttribute('readonly', true);
    });
    document.querySelectorAll('.tag').forEach(u => {
        u.classList.remove('hiddenThe');
    });
    document.querySelectorAll('.tags').forEach(u => {
        u.classList.add('showtags');
    });
    document.querySelector('#traloikeotha').classList.add('hidden')
    document.querySelector('#traloithuam').classList.remove('hidden')
    document.querySelector('#traloidien').classList.remove('hidden')
}

function showDien() {
    document.querySelectorAll('.boxQuiz input').forEach(input => {
        input.removeAttribute('readonly');
    });
    document.querySelectorAll('.tag').forEach(u => {
        u.classList.remove('hiddenThe');
    });
    document.querySelectorAll('.tags').forEach(u => {
        u.classList.remove('showtags');
    });
    document.querySelector('#traloikeotha').classList.remove('hidden')
    document.querySelector('#traloithuam').classList.remove('hidden')
    document.querySelector('#traloidien').classList.add('hidden')
}

