let selectedImagePathsQuiz = []
let correctA_K1 = JSON.parse(localStorage.getItem('correctA_K1')) || []
localStorage.setItem('correctA_K1', JSON.stringify(correctA_K1))
localStorage.setItem('selectedImagePathsQuiz', JSON.stringify(selectedImagePathsQuiz))

function show() {
    event.preventDefault()
    correctA_K1 = []
    document.querySelector('.form').style.display = 'none'
    document.querySelector('.container1').style.display = 'block'
    const showQ = document.querySelector('.showQ')
    showQ.innerHTML = ''
    let keys = [];
    let checks = [];
    let ids = [];
    let index = 0
    // Lấy giá trị các phần tử có class là 'correctKey'
    document.querySelectorAll('.correctKey').forEach(k => {
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
    if (selectedImagePathsQuiz.length != keys.length) {
        selectedImagePathsQuiz = []
        for (let a = 0; a < keys.length; a++) {
            selectedImagePathsQuiz.push('uploads/obj1_1.png')
        }
        localStorage.setItem('selectedImagePathsQuiz', JSON.stringify(selectedImagePathsQuiz))
    }
    for (let i = 0; i < keys.length; i++) {
        let question = `<div onclick="scaleObj(event, ${i})" class="${i == 0 ? "scaled" : ""}">
                                <div class="box" id="question${i}"><div class="noticeQuiz">Câu ${i + 1}:</div></div>
                                <input type="number" name="checkA${i}" id="checkA${i}" class="checkA" onchange ="tinhdiem(event, ${i})">
                                <div class="container2">
                                    <input type="button" value="Lựa chọn đối tượng" onclick="showSelectObj(${i})">
                                </div>
                            </div>`
        showQ.innerHTML += question

        let path = 'uploads/obj1_1.png'
        if (selectedImagePathsQuiz.length != 0) path = selectedImagePathsQuiz[i]
        for (let a = 0; a < keys[i]; a++) {
            addObj(path, i, key[i]);
        }
    }
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
        quiz[i].querySelector('input').forEach.addEventListener('click', (event) => {
            event.preventDefault();
        })
        quiz[i].querySelector('input').addEventListener('input', (event) => {
            if (event.target.value !== correctA_K1[index].correctKeys[i]) 
                event.target.value = correctA_K1[index].correctKeys[i];
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

function addObj(obj, i, a) {
    let zoneshow = document.querySelector(`#question${i}`);
    let imgObj = document.createElement('img');
    imgObj.src = `${obj}`;
    imgObj.classList.add('imgObj');
    imgObj.style.width = `${Number(50/a)}%`;
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

function showSelectObj(i) {
    if(correctA_K1[0].checkAnwer[i] != 1 ){
        let selectObj = document.querySelector('#selectObj');
        if (selectObj.style.display == "none"){
            selectObj.style.display = "block"
            selectObj.innerHTML = ''
        }
        else selectObj.style.display = "none"
        console.log(i)
        // if (selectObj.innerHTML == '') {
            str = `<span class="close" onclick="closeSelect()">&times;</span>`
            selectObj.innerHTML += str
            let divSelectObj = document.createElement('div');
            divSelectObj.id = 'divSelectObj' + i;
            divSelectObj.innerHTML = '<h4>Câu ' + (i + 1) + '</h4>';
            fetch('get_images.php')
                .then(response => response.text())
                .then(html => {
                    divSelectObj.innerHTML += modifyImageIds(html, i + 1);
                    selectObj.appendChild(divSelectObj);
                })
                .catch(error => console.error('Error:', error));
    }
}


function modifyImageIds(html, questionNumber) {
    let parser = new DOMParser();
    let doc = parser.parseFromString(html, 'text/html');

    doc.querySelectorAll('.selectable-image').forEach((image, index) => {
        let originalId = image.id;
        image.id = 'image' + questionNumber + '-' + index;
        image.classList.add('imageC' + questionNumber)
        if (selectedImagePathsQuiz[index] == image.dataset.src) {
            image.classList.add('selected');
            // selectedImagePathsQuiz = JSON.parse(localStorage.getItem('selectedImagePathsQuiz')) || [];
            // selectedImagePathsQuiz[questionNumber-1] = image.dataset.src
            // localStorage.setItem('selectedImagePathsQuiz', JSON.stringify(selectedImagePathsQuiz))
        }
        image.setAttribute('onclick', `toggleImageSelection1('${originalId}', ${index}, ${questionNumber});`);

    });
    return doc.body.innerHTML;
}




function toggleImageSelection1(imagePath, index, questionNumber) {

    let image = document.getElementById('image' + questionNumber + "-" + index);
    document.querySelectorAll(`.imageC` + questionNumber).forEach(u => {
        if (u.classList.contains('selected') && u.id != image.id) u.classList.remove('selected')
    })
    image.classList.toggle('selected');
    selectedImagePathsQuiz = JSON.parse(localStorage.getItem('selectedImagePathsQuiz')) || [];
    if (image.classList.contains('selected')) {
        selectedImagePathsQuiz[questionNumber-1] = image.dataset.src
        localStorage.setItem('selectedImagePathsQuiz', JSON.stringify(selectedImagePathsQuiz))
    }

    show();
}
function closeSelect() {
    let selectObj = document.getElementById('selectObj');
    selectObj.style.display = 'none';
}


