let selectedImagePaths = [];
let correctA_K1 = JSON.parse(localStorage.getItem('correctA_K1')) || []
localStorage.setItem('correctA_K1', JSON.stringify(correctA_K1))

// for (let i = 0; i < 21; i++) {
localStorage.setItem('selectedImagePaths', JSON.stringify(selectedImagePaths))
// }
function show(event) {
    event.preventDefault()
    correctA_K1 = []
    document.querySelector('.form').style.display = 'none'
    document.querySelector('.container1').style.display = 'block'
    const showQ = document.querySelector('.showQ')
    let keys = [];
    let checks = [];
    let ids = [];
    let index = 0

    document.querySelectorAll('.selected-quiz').forEach(k => {
        keys.push(k.value);
        checks.push(0);
        let id = 'quiz' + index
        ids.push(id);
        index++
    });
    let uniqueValues = [...new Set(keys)];
    let obj = {
        ids: ids,
        correctKeys: keys,
        countQuestions: keys.length,
        point: 0,
        checkAnwer: checks,
        checkSimilar: (keys.length - uniqueValues.length)
    }
    for (let a = 0; a < keys.length; a++) {
        for (let k = a + 1; k < keys.length; k++) {
            if (keys[a] == keys[k]) {
                ids[k] = ids[a]
            }
        }
    }
    correctA_K1.push(obj);
    localStorage.setItem('correctA_K1', JSON.stringify(correctA_K1))



    for (let i = 0; i < keys.length; i++) {
        let question = `<div onclick="scaleObj(event, ${i})" class="${i == 0 ? "scaled" : ""}">
                                <div class="box" id="question${i}"><div class="noticeQuiz">Câu ${i}:</div></div>
                                <input type="number" name="checkA${i}" id="checkA${i}" class="checkA" onchange ="tinhdiem(event, ${i})">
                            </div>`
        showQ.innerHTML += question
        selectedImagePaths = JSON.parse(localStorage.getItem('selectedImagePaths'))
        let obj = `uploads\\obj1_1.png`
        if(selectedImagePaths.length != 0) obj = getRandomElement(selectedImagePaths);
        for (let a = 0; a < keys[i]; a++) {
            addObj(obj, i);
        }
    }
}
function toggleImageSelection(imagePath, index) {
    let image = document.getElementById('image-' + index);

    image.classList.toggle('selected');

    if (image.classList.contains('selected')) {
        selectedImagePaths.push(imagePath);
    } 
    else {
        selectedImagePaths = selectedImagePaths.filter(path => path !== imagePath);
    }
    localStorage.setItem('selectedImagePaths', JSON.stringify(selectedImagePaths))
}
function scaleObj(event, i) {
    const clickedDiv = event.currentTarget;

    if (!clickedDiv.classList.contains('khoa')) {
        document.querySelectorAll('.showQ > div').forEach(e => {
            e.classList.remove('scaled');
        });
        clickedDiv.classList.toggle('scaled');
    }
}
function tinhdiem(event, i) {
    const clickInput = event.currentTarget;
    const index = correctA_K1.length - 1
    let quiz = document.querySelectorAll('.showQ > div')
    let uniqueValues = [...new Set(correctA_K1[index].correctKeys)];
    if (correctA_K1[index].correctKeys[i] == clickInput.value) {
        speakVietnamese("Câu trả lời đúng")
        correctA_K1[index].checkAnwer[i] = 1
        let point = 0;
        correctA_K1[index].checkAnwer.forEach(e => {
            point += e;
        })
        correctA_K1[index].point = (point / uniqueValues.length) * 100
        localStorage.setItem('correctA_K1', JSON.stringify(correctA_K1))
        let notice = document.querySelector('.correctNotice');
        notice.classList.add('hidden');
        setTimeout(() => {
            notice.classList.remove('hidden');
        }, 2500);
        document.querySelector('#point').textContent = parseInt(correctA_K1[index].point)
        quiz[i].removeEventListener('onclick', scaleObj)
        quiz[i].querySelector('input').addEventListener('click', (event) => {
            event.preventDefault();
        })
        quiz[i].querySelector('input').addEventListener('input', (event) => {
            if (event.target.value !== correctA_K1[index].correctKeys[i]) {
                event.target.value = correctA_K1[index].correctKeys[i];
            }
        })
        quiz[i].querySelector('input').addEventListener('mousedown', event => {
            event.preventDefault();
        })
    }

    for (let a = 0; a < correctA_K1[index].countQuestions; a++) {
        if (a !== i && correctA_K1[index].correctKeys[a] == correctA_K1[index].correctKeys[i]) {
            quiz[a].classList.add('khoa')
            quiz[a].removeEventListener('onclick', scaleObj)
            quiz[a].querySelector('input').addEventListener('mousedown', event => {
                event.preventDefault();
            })
            quiz[a].querySelector('input').addEventListener('click', event => {
                event.preventDefault();
            })
            quiz[a].querySelector('input').addEventListener('input', event => {
                event.target.value = null;
            })
        }
    }
}

function addObj(obj, i) {
    let zoneshow = document.querySelector(`#question${i}`);
    let imgObj = document.createElement('img');
    imgObj.src = `${obj}`;
    imgObj.classList.add('imgObj');
    zoneshow.appendChild(imgObj);
}


function speakVietnamese(num) {
    let msg = new SpeechSynthesisUtterance();
    msg.text = num;
    msg.lang = 'vi-VN';
    window.speechSynthesis.speak(msg);
}
let quiz = document.querySelectorAll('.showQ > div')
quiz.forEach(u => {
    if (!u.classList.contains('scaled')) {
        u.querySelector('input').addEventListener('mousedown', event => {
            event.preventDefault();
        })
        u.querySelector('input').addEventListener('click', event => {
            event.preventDefault();
        })
        u.querySelector('input').addEventListener('input', event => {
            event.target.value = null;
        })
    }
})
function getRandomElement(arr) {
    if (arr.length == 0) {
        return null; // Trả về null nếu mảng rỗng
    }
    const randomIndex = Math.floor(Math.random() * arr.length);
    return arr[randomIndex];
}

function toggleQuizSelection(obj){
    let isSelect = document.getElementById(`numQ${obj}`);
    isSelect.classList.toggle('selected-quiz');
}