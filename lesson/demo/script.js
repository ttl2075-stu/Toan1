// Create Img
function getFileNameFromUrl(url) {
    let urlParts = url.split('/');
    let fileName = urlParts[urlParts.length - 1];
    fileName = fileName.split('_')[0];
    return fileName;
}
function addObj(obj) {
    let zoneshow = document.querySelector('#zoneshow');
    let imgObj = document.createElement('img');
    imgObj.src = `${obj}.png`;
    imgObj.classList.add('imgObj');
    imgObj.classList.add(getFileNameFromUrl(imgObj.src));
    let ranNumX = Math.floor(Math.random() * 659) + 1;
    let ranNumY = Math.floor(Math.random() * 409) + 1;
    imgObj.style.left = ranNumX + 'px';
    imgObj.style.top = ranNumY + 'px';
    zoneshow.appendChild(imgObj);
}

function appearedObj(isAppeared, obj) {
    if (!isAppeared) addObj(obj);
}

function show() {
    const selectObj = document.querySelector('#selectObj')
    selectObj.style.display = 'none';
    const objCountElement = document.getElementById('objCount');
    objCountElement.textContent = '0';
    let zoneshow = document.querySelector('#zoneshow');
    zoneshow.innerHTML = '';
    let basket = document.getElementById('basket');
    basket.innerHTML = '';
    let randomNum = Math.floor(Math.random() * 20) + 1;
    while(randomNum<8){
        randomNum = Math.floor(Math.random() * 20) + 1;
    }
    let rangeLeve = parseInt(document.querySelector('#rangeLeve').value);
    let obj1_2Appeared = false;
    let obj1_1Appeared = false;
    let obj2_2Appeared = false;
    let obj2_1Appeared = false;
    let require = document.querySelector('.require');
    let selectObj2 = document.querySelector('#selectObj2');
    for (let i = 0; i < randomNum; i++) {
        let imgObj = document.createElement('img');

        if (rangeLeve === 0) {
            imgObj.src = 'obj2_2.png';
            require.textContent = 'Chọn đồ vật';
        } else if (rangeLeve === 1) {
            let randomImg = Math.floor(Math.random() * 20) + 1;
            if (randomImg <= 10) {
                imgObj.src = 'obj2_2.png';
                obj2_2Appeared = true;
            } else {
                imgObj.src = 'obj1_2.png';
                obj1_2Appeared = true;
            }
        }
        else{
            let randomImg = Math.floor(Math.random() * 20) + 1;
            if (randomImg <= 5) {
                imgObj.src = 'obj2_2.png';
                obj2_2Appeared = true;
            } else if (randomImg <= 10){
                imgObj.src = 'obj2_1.png';
                obj2_1Appeared = true;
            } else if (randomImg <= 15){
                imgObj.src = 'obj1_1.png';
                obj1_1Appeared = true;
            } else {
                imgObj.src = 'obj1_2.png';
                obj1_2Appeared = true;
            }
        }
        imgObj.classList.add(getFileNameFromUrl(imgObj.src));
        imgObj.classList.add('imgObj');
        let ranNumX = Math.floor(Math.random() * 599) + 1;
        let ranNumY = Math.floor(Math.random() * 409) + 1;
        imgObj.style.left = ranNumX + 'px';
        imgObj.style.top = ranNumY + 'px';
        zoneshow.appendChild(imgObj);
    }

    if (rangeLeve === 1) {
        selectObj.style.display = 'block';
        appearedObj(obj2_2Appeared, 'obj2_2');
        appearedObj(obj1_2Appeared, 'obj1_2');
        if(selectObj2.checked){
            require.textContent = 'Chọn đồ vật';
        } else{
            require.textContent = 'Chọn con vật';
        }
    }
    if (rangeLeve === 2) {
        selectObj.style.display = 'block';
        appearedObj(obj2_2Appeared, 'obj2_2');
        appearedObj(obj2_1Appeared, 'obj2_1');
        appearedObj(obj1_2Appeared, 'obj1_2');
        appearedObj(obj1_1Appeared, 'obj1_1');
        if(selectObj2.checked){
            require.textContent = 'Chọn đồ vật';
        } else{
            require.textContent = 'Chọn con vật';
        }
    }
    if (rangeLeve === 0){
        require.textContent = 'Chọn đồ vật';
    }

}

show();


// drop/drap
function allowDrop(event) {
    event.preventDefault();
}

function drop(event) {
    event.preventDefault();
    const objCountElement = document.getElementById('objCount');
    const basket = document.getElementById('basket');
    const zoneshow = document.getElementById('zoneshow');
    let require = document.querySelector('.require');

    // Lấy tọa độ chuột khi thả
    const mouseX = event.clientX;
    const mouseY = event.clientY;

    // Lấy tọa độ
    const basketRect = basket.getBoundingClientRect();
    const basketX = basketRect.left;
    const basketY = basketRect.top;

    const zoneshowRect = zoneshow.getBoundingClientRect();
    const zoneshowX = zoneshowRect.left;
    const zoneshowY = zoneshowRect.top;

    // Tìm phần tử quả táo được kéo
    const draggedobj = document.querySelector('.dragging');
    if (draggedobj) {
        // Tính toán vị trí tuyệt đối của quả táo trong rổ
        if (basket.contains(document.elementFromPoint(mouseX, mouseY))) {
            const objX = mouseX - basketX - draggedobj.offsetWidth / 2;
            const objY = mouseY - basketY - draggedobj.offsetHeight / 2;
            draggedobj.style.left = objX + 'px';
            draggedobj.style.top = objY + 'px';
            basket.appendChild(draggedobj);
        }

        if (zoneshow.contains(document.elementFromPoint(mouseX, mouseY))) {
            const objX = mouseX - zoneshowX - draggedobj.offsetWidth / 2;
            const objY = mouseY - zoneshowY - draggedobj.offsetHeight / 2;
            draggedobj.style.left = objX + 'px';
            draggedobj.style.top = objY + 'px';
            zoneshow.appendChild(draggedobj);

        }
        draggedobj.classList.remove('dragging');
        if(require.textContent == "Chọn đồ vật"){
            objCountElement.textContent = document.querySelectorAll("#basket > .obj2").length;
            if(draggedobj.classList.contains("obj1")){
                draggedobj.classList.add('error');
            }
        }
        if(require.textContent == "Chọn con vật"){
            objCountElement.textContent = document.querySelectorAll("#basket > .obj1").length;
            if(draggedobj.classList.contains("obj2")){
                draggedobj.classList.add('error');
            }
        }
    }
    let checkobj = document.querySelectorAll("#zoneshow > .imgObj");
    checkobj.forEach(e => {
        e.classList.remove('error');
    })
    let checkListen = document.querySelector('#rangeInput');
    if (checkListen.value == 1) {
        speakVietnamese(objCountElement.textContent);
    }
}

document.addEventListener('dragstart', function (event) {
    // Thêm class 'dragging' khi bắt đầu kéo
    if (event.target.classList.contains('imgObj')) {
        event.target.classList.add('dragging');
    }
});

function speakVietnamese(num) {
    let msg = new SpeechSynthesisUtterance();
    msg.text = num;
    msg.lang = 'vi-VN';
    window.speechSynthesis.speak(msg);
}

function display(event){
    let require = document.querySelector('.require');
    show();
    if(event.target.value == 'obj2'){
        require.textContent = 'Chọn đồ vật'
        document.querySelector('#dovat').classList.toggle('showNotice')
        setTimeout(() => {
            document.querySelector('#dovat').classList.toggle('showNotice')
        }, 2500);
    }
    else {
        require.textContent = 'Chọn con vật';
        document.querySelector('#convat').classList.toggle('showNotice')
        setTimeout(() => {
            document.querySelector('#convat').classList.toggle('showNotice')
        }, 2500);
    }
}
