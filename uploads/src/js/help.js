const btnHelp = document.querySelector('#help')
const divHelp = document.querySelector('.help-container')
const showHelp = document.querySelector('.show-help')
btnHelp.addEventListener('click', help);
const divbtnHelps = document.querySelector('#nuthotro')
let arrHelp = convertStringToTriplets(btnHelp.value)

let mySetKHT = new Set();
arrHelp.forEach(u => {
    mySetKHT.add(u.kieuHoTro);
})
console.log(mySetKHT)

mySetKHT.forEach((u) => {
    if (u == 12) {
        divbtnHelps.innerHTML += `<button type="button" style="width: 400px" class="btn kht hinhThucHelp" id="btn-kieuhotro${u}" onclick='daSuDung(${u})'>Hỗ trợ hiểu đề</button><br>`;
    } else if (u == 13) {
        divbtnHelps.innerHTML += `<button type="button" style="width: 400px" class="btn kht hinhThucHelp" id="btn-kieuhotro${u}" onclick='daSuDung(${u})'>Hỗ trợ đặt tính theo hàng</button><br>`;
    } else if (u == 19) {
        divbtnHelps.innerHTML += `<button type="button" style="width: 400px" class="btn kht hinhThucHelp" id="btn-kieuhotro${u}" onclick='daSuDung(${u})'>Hỗ trợ bằng hình thức toán học</button><br>`;
    } else if (u == 20) {
        divbtnHelps.innerHTML += `<button type="button" style="width: 400px" class="btn kht hinhThucHelp" id="btn-kieuhotro${u}" onclick='daSuDung(${u})'>Hỗ trợ bằng đồ vật</button><br>`;
    } else if (u == 15) {
        divbtnHelps.innerHTML += `<button type="button" style="width: 400px" class="btn kht hinhThucHelp" id="btn-kieuhotro${u}" onclick='daSuDung(${u})'>Hỗ trợ đọc kết quả - giải bài</button><br>`;
    }
})
function hiddenHelpdiv() {
    divHelp.classList.add('hidden')
    divHelp.classList.remove('show')
}
function daSuDung(u) {
    let index = quizShow
    let arrSo = arrCalculateFromString(lesson[index].bieuThuc)
    let nuthelp = document.querySelector(`#btn-kieuhotro${u}`);
    nuthelp.classList.add('tungSuDung');
    nuthelp.style.background = 'rgb(0, 229, 255)'
    lesson[index].suDungTroGiupMuc++
    bieuthuc = lesson[index].bieuThuc
    const result = arrHelp.filter(item => item.kieuHoTro === u);
    if (u == 12) {
        if(result[0].kieuHoTroChiTiet == 1){
            hotrodocde(index)
            if (lesson[index].mucHelp < 1) lesson[index].mucHelp = 1
            hiddenHelpdiv()
        }
    } else if (u == 13) {
        if(result[0].kieuHoTroChiTiet == 2){
            if (lesson[index].mucHelp < 2) {
                lesson[index].mucHelp = 2
            }
            if(!document.querySelector('.box-phepTinh.strong-help-box'))hotrohightline(lesson[index].bieuThuc, index, loaihienthi)
            hiddenHelpdiv()
        }
    } else if (u == 19 || u == 20) {
        console.log(result)
        showHelp.innerHTML = ''
        result.forEach(i => {
            if (i.kieuHoTroChiTiet == 11) {
                showHelp.innerHTML += `<button type="button" style="width: 400px" class="btn hinhThucHelp" id="help${u}" onclick="helpQuetinh('${bieuthuc}', ${index})">Que tính</button><br>`;
            } else if (i.kieuHoTroChiTiet == 12) {
                showHelp.innerHTML += `<button type="button" style="width: 400px" class="btn hinhThucHelp" id="help${u}" onclick="generateLEGO('${bieuthuc}')">Lego</button><br>`;
            } else if (i.kieuHoTroChiTiet == 13) {
                showHelp.innerHTML += `<button type="button" style="width: 400px" class="btn hinhThucHelp" id="help${u}" onclick="drawTable(${arrSo[0]}, ${arrSo[2]}, '${arrSo[1]}')">Bảng số</button><br>`;
            } else if (i.kieuHoTroChiTiet == 14) {
                showHelp.innerHTML += `<button type="button" style="width: 400px" class="btn hinhThucHelp" id="help${u}" onclick="helpTiaSo('${bieuthuc}')">Tia số</button><br>`;
            }
        })
        divbtnHelps.style.display = 'none'
        if (lesson[index].mucHelp < 3 && u == 19) {
            lesson[index].mucHelp = 3
        }
        if (lesson[index].mucHelp < 4 && u == 20) {
            lesson[index].mucHelp = 4
        }
    } else if (u == 15){
        if (lesson[index].mucHelp < 5) {
            if(result[0].kieuHoTroChiTiet == 7){
                lesson[index].mucHelp = 5
                let msg3 = huongDanTinh(arrSo[0], arrSo[2], arrSo[1])
                speakVietnamese(msg3)
            }
        }
    }
    if (loaihienthi == 1) upLocalStorage("d6k1_baiDien", lesson);
    if (loaihienthi == 4) upLocalStorage("d7k1_baiDien", lesson);
}
function help() {
    let index = quizShow
    let checkKetThuc = document.querySelector(`#notice${index}`)
    let arrSo = arrCalculateFromString(lesson[index].bieuThuc)
    console.log(arrHelp)
    // lesson[index].suDungTroGiupMuc++
    // lesson[index].mucHelp++
    // if(lesson[index].mucHelp > arrHelp[arrHelp.length - 1].stt){
    //     lesson[index].mucHelp = arrHelp[arrHelp.length - 1].stt
    // }
    // bieuthuc = lesson[index].bieuThuc
    // if (loaihienthi == 1) upLocalStorage("d6k1_baiDien", lesson);
    // if (loaihienthi == 4) upLocalStorage("d7k1_baiDien", lesson);
    if (lesson[index].dapAnTraLoiGanNhat != lesson[index].dapAn && checkKetThuc.textContent.trim() === "") {
        //     let resultArray = findKieuHoTroChiTietByStt(arrHelp, lesson[index].suDungTroGiupMuc);
        //     if (resultArray.length == 1) {
        //         if (resultArray[0] == 1) {
        //             hotrodocde(index)
        //         } else if (resultArray[0] == 2) {
        //             hotrohightline(lesson[index].bieuThuc, index, loaihienthi)
        //             // speakVietnamese(`Tính lần lượt theo các hàng, hàng đơn vị, hàng chục nếu có`)
        //         } else if (resultArray[0] == 7) {
        //             console.log(arrSo)
        //             let msg3 = huongDanTinh(arrSo[0], arrSo[2], arrSo[1])
        //             console.log(msg3)
        //             speakVietnamese(msg3)
        //         }
        //     }
        //     else if (resultArray.length > 1) {
        //         divHelp.classList.add('show')
        //         showHelp.innerHTML = ''
        //         resultArray.forEach(u => {
        //             if (u == 11) {
        //                 showHelp.innerHTML += `<button type="button" style="width: 400px" class="btn hinhThucHelp" id="help${u}" onclick="helpQuetinh('${bieuthuc}', ${index})">Que tính</button><br>`;
        //             } else if (u == 12) {
        //                 showHelp.innerHTML += `<button type="button" style="width: 400px" class="btn hinhThucHelp" id="help${u}" onclick="generateLEGO('${bieuthuc}')">Lego</button><br>`;
        //             } else if (u == 13) {
        //                 showHelp.innerHTML += `<button type="button" style="width: 400px" class="btn hinhThucHelp" id="help${u}" onclick="drawTable(${arrSo[0]}, ${arrSo[2]}, '${arrSo[1]}')">Bảng số</button><br>`;
        //             } else if (u == 14) {
        //                 showHelp.innerHTML += `<button type="button" style="width: 400px" class="btn hinhThucHelp" id="help${u}" onclick="helpTiaSo('${bieuthuc}')">Tia số</button><br>`;
        //             }
        //             console.log(u)

        //         })

        //     }
        //     if (lesson[index].suDungTroGiupMuc > arrHelp[arrHelp.length - 1].stt) {
        //         if (arrHelp[arrHelp.length - 1].kieuHoTroChiTiet == 7) {
        //             let msg3 = huongDanTinh(arrSo[0], arrSo[2], arrSo[1])
        //             speakVietnamese(msg3)
        //         }
        //     }
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