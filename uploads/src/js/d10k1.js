let hasAnsweredOnce = false;
let lesson = JSON.parse(localStorage.getItem('d10k1_baiTinhHuong')) || []
let quizShow = ''

const divShow = document.querySelector('.show')
const btnCheck = document.querySelector('#check')
const divLesson = document.querySelector('.lesson')
const divPoint = document.querySelector('#diem')
const divNotice = document.querySelector('.notice')
show()

if (lesson[0].kiemTra == 'chonmotlan') divNotice.innerHTML = 'Trả lời một lần duy nhất'
else if (lesson[0].kiemTra == 'cotrudiem') divNotice.innerHTML = 'Trả lời nhiều lần, trả nời sai sẽ trừ 20% số điểm của câu đấy, tối đa 5 lần sai'
else divNotice.innerHTML = 'Trả lời nhiều lần, tối đa 5 lần sai'

function show() {
    lesson.forEach((e, index) => {
        divLesson.innerHTML += `
        <button type="button" class="btn-quiz" id="btnQuiz${index}" onclick="showQuiz(${index})">${index + 1}</button>
        `
        divShow.innerHTML += `
                            <div class="boxQuiz" id="box-quiz${index}">
                                <h1>Câu hỏi thứ ${index + 1}: <deBai>${lesson[index].noiDung}</deBai></h1>
                                <label>Nhập đáp án (Một số): </label>
                                <input type="number" name="checkA" id="checkA${index}" class="checkA inputStyle1"><br>
                                <span id="notice${index}" style="color:rgb(185, 185, 185);"><span>
                            </div>
                            `
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
            return quizShow = index
        }
    })
}

function checkAnswer() {
    const inputs = document.querySelectorAll('.checkA');
    inputs.forEach((input, index) => {
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
        lesson[index].diem -= (lesson[index].suDungTroGiupMuc >= 3 ? lesson[index].suDungTroGiupMuc*5 : 0)
        if(lesson[index].diem < 0) lesson[index].diem = 0
    });
    showDiem()
    upLocalStorage("d10k1_baiTinhHuong", lesson);
}

function khoaInput(input, index) {
    input.addEventListener('mousedown', (event) => {
        event.preventDefault();
    })
    input.addEventListener('click', (event) => {
        event.preventDefault();
    })
    document.querySelector(`#notice${index}`).textContent = 'Kết thúc, đáp án là ' + lesson[index].dapAn 
    if(lesson[index].soLanTraLoiSai == 5) document.querySelector(`#notice${index}`).textContent = 'Bạn đã trả lời sai 5 lần, đáp án là ' + lesson[index].dapAn 
}

function showDiem() {
    let sum = 0
    lesson.forEach(e => {
        sum += e.diem
    })
    divPoint.innerHTML = parseInt(sum / lesson.length)
}