const btnSupport = document.querySelector(".btn-support");

function hotrodocdeD6K2(id) {
    let deBai = document.querySelector(
        `.con_vat_item[data-id="${id}"] input[type="text"]`
    ).value;
    deBai = deBai
        .split("")
        .map((char) => {
            if (char === "+") {
                return "cộng";
            }
            if (char === "-") {
                return "trừ";
            }
            return char;
        })
        .join(" ");
    let message = "câu hỏi là " + deBai + " bằng mấy";
    speakVietnamese(message);
}

function helpD6k2(id) {
    let lesson = JSON.parse(localStorage.getItem(`d6k2_baiDien-${id}`)) || [];
    let quizShow = 0;
    let index = quizShow;
    let arrHelp = convertStringToTriplets(btnSupport.value);
    let checkKetThuc = document.querySelector(`#notice${index}`);
    let arrSo = arrCalculateFromString(lesson[index].bieuThuc);
    console.log(arrHelp);
    lesson[index].suDungTroGiupMuc++;
    lesson[index].mucHelp++;
    if (lesson[index].mucHelp > arrHelp[arrHelp.length - 1].stt) {
        lesson[index].mucHelp = arrHelp[arrHelp.length - 1].stt;
    }
    let bieuthuc = lesson[index].bieuThuc;
    upLocalStorage(`d6k2_baiDien-${id}`, lesson);
    if (
        lesson[index].dapAnTraLoiGanNhat != lesson[index].dapAn &&
        checkKetThuc.textContent.trim() === ""
    ) {
        let resultArray = findKieuHoTroChiTietByStt(
            arrHelp,
            lesson[index].suDungTroGiupMuc
        );
        console.log(resultArray);
        if (resultArray.length == 1) {
            if (resultArray[0] == 1) {
                hotrodocdeD6K2(id);
            } else if (resultArray[0] == 2) {
                hotrohightline(lesson[index].bieuThuc, index, loaihienthi);
                // speakVietnamese(`Tính lần lượt theo các hàng, hàng đơn vị, hàng chục nếu có`)
            } else if (resultArray[0] == 7) {
                console.log(arrSo);
                let msg3 = huongDanTinh(arrSo[0], arrSo[2], arrSo[1]);
                console.log(msg3);
                speakVietnamese(msg3);
            }
        } else if (resultArray.length > 1) {
            divHelp.classList.add("show");
            showHelp.innerHTML = "";
            resultArray.forEach((u) => {
                if (u == 11) {
                    showHelp.innerHTML += `<button type="button" style="width: 400px" class="btn hinhThucHelp" id="help${u}" onclick="helpQuetinh('${bieuthuc}', ${index})">Que tính</button><br>`;
                } else if (u == 12) {
                    showHelp.innerHTML += `<button type="button" style="width: 400px" class="btn hinhThucHelp" id="help${u}" onclick="generateLEGO('${bieuthuc}')">Lego</button><br>`;
                } else if (u == 13) {
                    showHelp.innerHTML += `<button type="button" style="width: 400px" class="btn hinhThucHelp" id="help${u}" onclick="drawTable(${arrSo[0]}, ${arrSo[2]}, '${arrSo[1]}')">Bảng số</button><br>`;
                } else if (u == 14) {
                    showHelp.innerHTML += `<button type="button" style="width: 400px" class="btn hinhThucHelp" id="help${u}" onclick="helpTiaSo('${bieuthuc}')">Tia số</button><br>`;
                }
            });
        }
        if (lesson[index].suDungTroGiupMuc > arrHelp[arrHelp.length - 1].stt) {
            if (arrHelp[arrHelp.length - 1].kieuHoTroChiTiet == 7) {
                let msg3 = huongDanTinh(arrSo[0], arrSo[2], arrSo[1]);
                speakVietnamese(msg3);
            }
        }
    }
}
