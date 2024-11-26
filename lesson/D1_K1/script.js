let selectedImagePaths = [];
let selectedImagePathsQuiz = []
let correctA_K1 = JSON.parse(localStorage.getItem('correctA_K1')) || []
localStorage.setItem('correctA_K1', JSON.stringify(correctA_K1))
localStorage.setItem('selectedImagePaths', JSON.stringify(selectedImagePaths))
localStorage.setItem('selectedImagePathsQuiz', JSON.stringify(selectedImagePathsQuiz))

function show() {
    event.preventDefault()
    correctA_K1 = []
    document.querySelector('.form').style.display = 'none'
    document.querySelector('.container1').style.display = 'block'
    document.querySelector('.container2').style.display = 'block'
    const showQ = document.querySelector('.showQ')
    showQ.innerHTML = ''
    let keys = [];
    let checks = [];
    let ids = [];
    let index = 0
    let kichban = [];
    let solantraloiSai = []
    document.querySelectorAll('.correctKey').forEach(k => {
        kichban.push(k.nextElementSibling.value);
        keys.push(k.value);
        checks.push(0);
        solantraloiSai.push(0)
        let id = 'quiz' + index
        ids.push(id);
        index++
    });
    let uniqueValues = [...new Set(keys)];
    let obj = {
        id: ids,
        correctKeys: keys,
        countQuestions: keys.length,
        point: 0,
        checkAnwer: checks,
        checkSimilar: (keys.length - uniqueValues.length),
        kichban: kichban,
        dang: getSelected_RadioValue("dang"),
        solantraloiSai: solantraloiSai
    }
    correctA_K1.push(obj);
    localStorage.setItem('correctA_K1', JSON.stringify(correctA_K1))



    for (let i = 0; i < keys.length; i++) {
        let question = `<div onclick="scaleObj(event, ${i})" class="${i == 0 ? "scaled" : ""}">
                                <div class="box" id="question${i}"><div class="noticeQuiz">Câu ${i + 1}:</div></div>
                                <input type="number" name="checkA${i}" id="checkA${i}" class="checkA" onchange ="tinhdiem(event, ${i})">
                            </div>`
        showQ.innerHTML += question
        let obj = 'uploads/obj1_1.png'
        selectedImagePathsQuiz = JSON.parse(localStorage.getItem('selectedImagePathsQuiz'))
        if (selectedImagePathsQuiz.length != 0) obj = selectedImagePathsQuiz[i]
        let pop = 0
        let zoneshow = document.querySelector(`#question${i}`)
        if (kichban[i] != 'Trường hợp 1' && keys[i] > 5) {

            let chiaKhoi1 = document.createElement('div')
            let chiaKhoi2 = document.createElement('div')
            chiaKhoi1.classList.add('itemDiv')
            chiaKhoi2.classList.add('itemDiv')
            chiaKhoi2.id = `itemDiv2${i}`
            chiaKhoi1.id = `itemDiv1${i}`
            zoneshow.appendChild(chiaKhoi1)
            zoneshow.appendChild(chiaKhoi2)

        }
        for (let a = 0; a < keys[i]; a++) {
            addObj(obj, i, keys[i], pop, kichban[i]);
            pop++
        }
        pop = 0
    }
    let noticeDang = document.querySelector('.container1 p')
    if(correctA_K1[0].dang == 'dang1'){
        noticeDang.textContent = 'Chỉ trả lời 1 lần'
    }
    if(correctA_K1[0].dang == 'dang2'){
        noticeDang.textContent = 'Mỗi lần trả lời sai sẽ trừ 5% số điểm của câu đó'
    }
    if(correctA_K1[0].dang == 'dang3'){
        noticeDang.textContent = 'Được phép trả lời nhiều lần'
    }
}

function toggleImageSelection(imagePath, index) {
    let image = document.getElementById('image-' + index);

    image.classList.toggle('selected');

    if (image.classList.contains('selected')) {
        selectedImagePaths.push(imagePath);
    } else {
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
    let zoneshow = document.querySelector(`#question${i}`)
    let quiz = document.querySelectorAll('.showQ > div')
    if (correctA_K1[0].correctKeys[i] == clickInput.value) {
        speakVietnamese("Câu trả lời đúng")
        correctA_K1[0].checkAnwer[i] = 1
        let point = 0;
        correctA_K1[0].checkAnwer.forEach(e => {
            point += e;
        })
        let tongsolantl = 0;
        correctA_K1[0].solantraloiSai.forEach(e => {
            tongsolantl += e;
        })
        console.log(tongsolantl)
        if(correctA_K1[0].dang == "dang3") 
            correctA_K1[0].point = (point/correctA_K1[0].correctKeys.length) * 100
        if(correctA_K1[0].dang == "dang2"){
            correctA_K1[0].point = (point/correctA_K1[0].correctKeys.length) * 100 - (point/correctA_K1[0].correctKeys.length) * 100 * 0.05 * tongsolantl
        }
        if(correctA_K1[0].dang == "dang1"){
            correctA_K1[0].point = (point/correctA_K1[0].correctKeys.length) * 100
        }
        let notice = document.querySelector('.correctNotice');
        notice.classList.add('hidden');
        setTimeout(() => {
            notice.classList.remove('hidden');
        }, 2500);
        let noticeCorrect = document.createElement('img')
        noticeCorrect.src = 'correct.png'
        noticeCorrect.classList.add('thongbaodung')
        zoneshow.appendChild(noticeCorrect)
        localStorage.setItem('correctA_K1', JSON.stringify(correctA_K1))
        quiz[i].removeEventListener('onclick', scaleObj)
        quiz[i].querySelector('input').addEventListener('click', (event) => {
            event.preventDefault();
        })
        quiz[i].querySelector('input').addEventListener('input', (event) => {
            if (event.target.value !== correctA_K1[0].correctKeys[i]) {
                event.target.value = correctA_K1[0].correctKeys[i];
            }
        })
        quiz[i].querySelector('input').addEventListener('mousedown', event => {
            event.preventDefault();
        })
    } else {
        speakVietnamese("Câu trả lời sai")
        correctA_K1[0].solantraloiSai[i] ++
        if(correctA_K1[0].dang == "dang1"){
            quiz[i].classList.add('khoa')
            quiz[i].removeEventListener('onclick', scaleObj)
            quiz[i].querySelector('input').addEventListener('mousedown', event => {
                event.preventDefault();
            })
            quiz[i].querySelector('input').addEventListener('click', event => {
                event.preventDefault();
            })
            quiz[i].querySelector('input').addEventListener('input', event => {
                event.target.value = null;
            })
        }
    }
    document.querySelector('#point').textContent = parseInt(correctA_K1[0].point)
}

function addObj(obj, i, a, pop, th) { // a la so doi tuong trong 1 o
    let zoneshow = document.querySelector(`#question${i}`)
    let imgObj = document.createElement('img')
    imgObj.src = `${obj}`;
    imgObj.classList.add('imgObj')
    imgObj.id = `img${a}_${pop}`
    let newPercentage
    if (a == 1) {
        newPercentage = 45
    } else if(a<=5){
        newPercentage = 90 / a
    } else{
        newPercentage = 150/a
    }

    imgObj.style.width = `${newPercentage}%`
    if (th == 'Trường hợp 1') {
        zoneshow.appendChild(imgObj)
        obj_a_1(a, pop)
    } else if (a <= 5) {
        zoneshow.appendChild(imgObj)
    }
    if (a == 2) {
        if (th == 'Trường hợp 2') {
            imgObj.style.width = `25%`
            obj_2_2(a, pop)
        }
    }
    if (a == 3) {
        if (th == 'Trường hợp 2') {
            imgObj.style.width = `25%`
            obj_3_2(a, pop)
        }
        if (th == 'Trường hợp 3') {
            imgObj.style.width = `25%`
            obj_3_3(a, pop)
        }
    }
    if (a == 4) {
        if (th == 'Trường hợp 2') {
            imgObj.style.width = `25%`
            obj_4_2(a, pop)
        }
    }
    if (a == 5) {
        if (th == 'Trường hợp 2') {
            imgObj.style.width = `20%`
            obj_5_2(a, pop)
        }
    }

    if (a > 5 && th != 'Trường hợp 1') {
        let chiaKhoi1 = document.querySelector(`#itemDiv1${i}`)
        let chiaKhoi2 = document.querySelector(`#itemDiv2${i}`)
        imgObj.style.width = `28%`
        if (a == 6) {
            if (pop <= 2) {
                chiaKhoi1.appendChild(imgObj)
            } else {
                chiaKhoi2.appendChild(imgObj)
            }
            if (th == 'Trường hợp 2') {
                obj_3_2(a, pop)
            }
            if (th == 'Trường hợp 3') {
                obj_3_3(a, pop)
            }
        }
        if(a == 7){
            if (th == 'Trường hợp 2') {
                if (pop <= 2) {
                    chiaKhoi1.appendChild(imgObj)
                    obj_3_2(a, pop)
                } else {
                    chiaKhoi2.appendChild(imgObj)
                    obj_4_2(a, pop)
                }
            }
            if (th == 'Trường hợp 3') {
                if (pop <= 2) {
                    chiaKhoi2.appendChild(imgObj)
                    obj_3_2(a, pop)
                } else {
                    chiaKhoi1.appendChild(imgObj)
                    obj_4_2(a, pop)
                }
            }
        }
        if (a == 8) {
            if (pop <= 3) {
                chiaKhoi1.appendChild(imgObj)
            } else {
                chiaKhoi2.appendChild(imgObj)
            }
            if (th == 'Trường hợp 2') {
                obj_4_2(a, pop)
            }
        }
        if (a==9){
            if (th == 'Trường hợp 2') {
                if (pop <= 4) {
                    chiaKhoi1.appendChild(imgObj)
                    obj_5_2(a, pop)
                } else {
                    chiaKhoi2.appendChild(imgObj)
                    obj_4_2(a, pop)
                }
            }
            if (th == 'Trường hợp 3') {
                if (pop <= 4) {
                    chiaKhoi2.appendChild(imgObj)
                    obj_5_2(a, pop)
                } else {
                    chiaKhoi1.appendChild(imgObj)
                    obj_4_2(a, pop)
                }
            }
        }
        if (a == 10) {
            if (pop <= 4) {
                chiaKhoi1.appendChild(imgObj)
            } else {
                chiaKhoi2.appendChild(imgObj)
            }
            if (th == 'Trường hợp 2') {
                obj_5_2(a, pop)
            }
        }
    }
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

    function showSelectObj() {
        let selectObj = document.querySelector('#selectObj');
        if (selectObj.style.display == "none") selectObj.style.display = "block"
        else selectObj.style.display = "none"
        let correctA_K1 = JSON.parse(localStorage.getItem('correctA_K1')) || [];
        if (selectObj.innerHTML == '') {
            str = `<span class="close" onclick="closeSelect()">&times;</span>`
            selectObj.innerHTML += str
            for (let i = 0; i < correctA_K1[0].correctKeys.length; i++) {
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
    }
    showSelectObj()
    function modifyImageIds(html, questionNumber) {
        let parser = new DOMParser();
        let doc = parser.parseFromString(html, 'text/html');
        doc.querySelectorAll('.selectable-image').forEach((image, index) => {
            let originalId = image.id;
            image.id = 'image' + questionNumber + '-' + index;
            image.classList.add('imageC' + questionNumber)
            if (index === 0) {
                image.classList.add('selected');
                selectedImagePathsQuiz = JSON.parse(localStorage.getItem('selectedImagePathsQuiz')) || [];
                selectedImagePathsQuiz.push(image.dataset.src);
                localStorage.setItem('selectedImagePathsQuiz', JSON.stringify(selectedImagePathsQuiz))
            }
            image.setAttribute('onclick', `toggleImageSelection1('${originalId}', ${index}, ${questionNumber});`);

        });
        return doc.body.innerHTML;
    }




    function toggleImageSelection1(imagePath, index, questionNumber) {

        let image = document.getElementById('image' + questionNumber + "-" + index);
        document.querySelectorAll(`.imageC` + questionNumber).forEach(u => {
            if (u.classList.contains('selected')) u.classList.remove('selected')
        })
        image.classList.toggle('selected');
        selectedImagePathsQuiz = JSON.parse(localStorage.getItem('selectedImagePathsQuiz')) || [];
        if (image.classList.contains('selected')) {
            selectedImagePathsQuiz[questionNumber - 1] = image.dataset.src
            localStorage.setItem('selectedImagePathsQuiz', JSON.stringify(selectedImagePathsQuiz))
        }
        show();
    }
    function closeSelect() {
        let selectObj = document.getElementById('selectObj');
        selectObj.style.display = 'none';
    }

    function getRandomInt(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }

    function getSelected_RadioValue(dang) {
        var radios = document.getElementsByName(`${dang}`);
        var selectedValue = "";
    
        for (var i = 0; i < radios.length; i++) {
            if (radios[i].checked) {
                selectedValue = radios[i].value;
                break;
            }
        }
        return selectedValue;
    }