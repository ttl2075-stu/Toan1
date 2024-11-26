const btnHelp = document.querySelector('#help')
const divHelp = document.querySelector('.help-container')
const showHelp = document.querySelector('.show-help')
btnHelp.addEventListener('click', help);

function help() {
    let index = quizShow
    let checkKetThuc = document.querySelector(`#notice${index}`)
    if (lesson[index].dapAnTraLoiGanNhat != lesson[index].dapAn && checkKetThuc.textContent.trim() === "") {
        if (lesson[index].suDungTroGiupMuc == 0) {
            let deBai = document.querySelector(`#box-quiz${index} deBai`).textContent
            let cachKiemTra = document.querySelector('span.notice').textContent
            let message = "câu hỏi là " + deBai 
            speakVietnamese(message)
        }
        else if (lesson[index].suDungTroGiupMuc >= 1) {
            divHelp.classList.add('show')

            if (lesson[index].suDungTroGiupMuc == 1) {
                showHelp.innerHTML = "Đề bài là: " 
            } else if (lesson[index].suDungTroGiupMuc == 2) {
                showHelp.innerHTML = "Biểu thức của bài toán là: <br><strong style=\"color: green; font-size: 20px\">" + lesson[index].bieuThuc + " = ?</strong>"
            } else if (lesson[index].suDungTroGiupMuc == 3) {
                showHelp.innerHTML = `
                <div id="huongDanTinh">
                <h4>Coi mỗi giỏ táo là 10, quả táo là 1</h4>
                    <div id="num1"></div>
                    <div id="num2"></div>
                </div>
    `
                let arrSo = arrCalculateFromString(lesson[index].bieuThuc)
                let num1 = tachSoThanhPhan10(arrSo[0])
                let num2 = tachSoThanhPhan10(arrSo[2])
                let msg1 = "Lúc đầu có " + arrSo[0] + " quả táo";
                speakVietnamese(msg1).then(() => {
                    num1.forEach(e => {
                        if (e == 10) {
                            addObj("num1", 10);
                        } else {
                            for (let i = 0; i < e; i++) {
                                addObj("num1", 1);
                            }
                        }
                    });
                }).catch(error => {
                    console.error('Đã xảy ra lỗi:', error);
                });
                if (arrSo[1] == '+') {
                    let dem = parseInt(arrSo[0])
                    num2.forEach(e => {
                        if (e == 10) {
                            dem += 10
                            msg1 = "Thêm 10 quả táo ta được" + dem + "quả táo"
                            speakVietnamese(msg1).then(() => {
                                addObj("num1", 10);
                            }).catch(error => {
                                console.error('Đã xảy ra lỗi:', error);
                            });
                        } else {
                            for (let i = 0; i < e; i++) {
                                dem += 1
                                msg1 = "Thêm 1 quả táo ta được" + dem + "quả táo"
                                speakVietnamese(msg1).then(() => {
                                    addObj("num1", 1);
                                }).catch(error => {
                                    console.error('Đã xảy ra lỗi:', error);
                                });
                            }
                        }
                    })
                    msg1 = "Vậy sau khi thêm " + arrSo[2] + "quả táo ta được tổng là " + lesson[index].dapAn + "quả táo"
                    speakVietnamese(msg1)
                } else if(arrSo[1] == '-'){
                    let dem = parseInt(arrSo[0])
                    num2.forEach(e => {
                        if (e == 10) {
                            dem -= 10
                            msg1 = "Lấy đi 10 quả táo ta còn" + dem + "quả táo"
                            speakVietnamese(msg1).then(() => {
                                xoaAnh(10)
                            }).catch(error => {
                                console.error('Đã xảy ra lỗi:', error);
                            });
                        } else {
                            for (let i = 0; i < e; i++) {
                                dem -= 1
                                msg1 = "Lấy đi 1 quả táo ta còn" + dem + "quả táo"
                                speakVietnamese(msg1).then(() => {
                                    xoaAnh(1)
                                }).catch(error => {
                                    console.error('Đã xảy ra lỗi:', error);
                                });
                            }
                        }
                    })
                    msg1 = "Vậy lúc đầu có " + arrSo[0] + "quả táo, sau khi lấy đi" +arrSo[2] + "quả táo, ta còn lại"+  lesson[index].dapAn + "quả táo"
                    speakVietnamese(msg1)
                }

            } else {
                let arrSo = arrCalculateFromString(lesson[index].bieuThuc)
                showHelp.innerHTML = "Biểu thức của bài toán là: <br><strong style=\"color: green; font-size: 20px\">" + lesson[index].bieuThuc + " = " + lesson[index].dapAn + "</strong>"
                let result = "Kết là của bài toán là kết quả của phép tính " + arrSo[0] + (arrSo[1] == '-' ? "trừ" : "cộng") + arrSo[2] + " bằng " + lesson[index].dapAn + ". Bạn hãy điền đáp án vào ô trống."
                speakVietnamese(result)
            }
        }
        // 


        // 
        lesson[index].suDungTroGiupMuc++
        upLocalStorage("d10k1_baiTinhHuong", lesson);
    }
}

function addObj(id, num) {
    let zoneshow = document.querySelector(`#${id}`)
    let imgObj = document.createElement('img')
    let obj
    if (num == 10) {
        obj = "../src/image/giotao.png"
    } else {
        obj = "../src/image/apple.png"
    }
    imgObj.src = `${obj}`;
    imgObj.classList.add('imgObj')
    imgObj.style.width = `50px`
    zoneshow.appendChild(imgObj)
    const elements = document.querySelectorAll('[src*="../src/image/apple.png"]');
    if(elements.length >= 10){
        for (let i = 0; i < 10; i++) {
            xoaAnh(1)
        }
        addObj("num1", 10)
    }
}
function xoaAnh(num) {
    let obj
    if (num == 10) {
        obj = "../src/image/giotao.png"
    } else {
        obj = "../src/image/apple.png"
    }
    const image = document.querySelector('img[src="' + obj + '"]');
    if (image) {
        image.remove(); // Xóa ảnh khỏi DOM
        console.log("Đã xóa ảnh có đường dẫn: " + obj);
    } else {
        if(num == 1){
            obj = "../src/image/giotao.png"
            const image = document.querySelector('img[src="' + obj + '"]');
            if (image) {
                image.remove(); // Xóa ảnh khỏi DOM
                console.log("Đã xóa ảnh có đường dẫn: " + obj);
            }
            for (let i = 0; i < 9; i++) {
                addObj("num1", 1);
            }
        }
    }
}

