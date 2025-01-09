function hotrodocde(index) {
  let deBai = document.querySelector(`#box-quiz${index} deBai`).textContent;
  let phep_tinh = document.querySelector('#bieuThuc').textContent.toString();

  let phep_tinh_new = phep_tinh.replace('+', ' + ');
  console.log(phep_tinh_new);

  let message = 'câu hỏi là ' + deBai + phep_tinh_new;
  speakVietnamese(message);
}

function hotrohightline(bieuthuc, index, loaihienthi) {
  document.querySelectorAll('.box-phepTinh').forEach((e, i) => {
    if (index == i) {
      e.classList.add('strong-help-box');
      e.querySelectorAll('.box-num').forEach((u) => {
        u.classList.add('strong-help');
      });
    }
  });
  if (loaihienthi == 1) {
    document.querySelectorAll('.box-phepTinh').forEach((e, i) => {
      if (index == i) {
        e.classList.add('strong-help-box');
        e.querySelectorAll('.box-num').forEach((u) => {
          u.remove();
        });

        let arrSo = arrCalculateFromString(bieuthuc);
        let so1 = arrSo[0].toString().split('').map(Number);
        let so2 = arrSo[2].toString().split('').map(Number);
        adjustArrays(so1, so2);
        let len = Math.max(so1.length, so2.length);
        let box = document.createElement('div');
        box.classList.add('boxStrong');
        box.classList.add('box-num');
        box.classList.add('strong-help');
        let div3 = document.createElement('div');
        let div4 = document.createElement('div');
        div3.classList.add('divStrong-phepTinh');
        div4.classList.add('divStrong-phepTinh1');
        div4.innerHTML = arrSo[1];
        div3.appendChild(div4);
        box.appendChild(div3);

        for (let a = 0; a < len; a++) {
          let div = document.createElement('div');
          let div1 = document.createElement('div');
          let div2 = document.createElement('div');
          div.classList.add('divStrong');
          div.id = `divStrong${a}`;

          div1.innerHTML = so1[a];
          div2.innerHTML = so2[a];
          div.appendChild(div1);
          div.appendChild(div2);
          box.appendChild(div);
        }
        const firstChild = e.firstChild;
        e.insertBefore(box, firstChild);
        let key = lesson[index].dapAn.toString().split('').map(Number);
        let inputContain = document.createElement('div');
        inputContain.classList.add('input-container-hep');

        for (let i = 0; i < key.length; i++) {
          let inputA = document.createElement('input');
          inputA.setAttribute('type', 'text');
          inputA.classList.add('input-box');
          inputA.setAttribute('maxlength', '1');
          inputA.id = `input-box${i}`;
          inputContain.appendChild(inputA);
        }
        e.appendChild(inputContain);
      }
    });
  } else {
    document.querySelectorAll('.box-phepTinh').forEach((e, i) => {
      if (index == i) {
        e.classList.add('strong-help-box');
        e.querySelectorAll('.box-num').forEach((u) => {
          u.remove();
        });

        let arrSo = arrCalculateFromString(bieuthuc);
        let so1 = arrSo[0].toString().split('').map(Number);
        let so2 = arrSo[2].toString().split('').map(Number);
        adjustArrays(so1, so2);
        let len = Math.max(so1.length, so2.length);
        let box = document.createElement('div');
        box.classList.add('boxStrong');
        box.classList.add('box-num');
        box.classList.add('strong-help');

        for (let a = 0; a < len; a++) {
          let div = document.createElement('div');
          let div1 = document.createElement('div');
          div.classList.add('divStrong');
          div.id = `divStrong${a}`;
          div1.innerHTML = so1[a];
          div.appendChild(div1);
          box.appendChild(div);
        }
        let div3 = document.createElement('div');
        let div4 = document.createElement('div');
        div3.classList.add('divStrong-phepTinh');
        div4.classList.add('divStrong-phepTinh1');
        div4.innerHTML = arrSo[1];
        div3.appendChild(div4);
        box.appendChild(div3);
        for (let a = 0; a < len; a++) {
          let div = document.createElement('div');
          let div2 = document.createElement('div');
          div.classList.add('divStrong');
          div.id = `divStrong${a}`;
          div2.innerHTML = so2[a];
          div.appendChild(div2);
          box.appendChild(div);
        }
        let div5 = document.createElement('div');
        let div6 = document.createElement('div');
        div5.classList.add('divStrong-phepTinh');
        div6.classList.add('divStrong-phepTinh1');
        div6.innerHTML = '=';
        div5.appendChild(div6);
        box.appendChild(div5);
        const firstChild = e.firstChild;
        e.insertBefore(box, firstChild);
        let key = lesson[index].dapAn.toString().split('').map(Number);
        let inputContain = document.createElement('div');
        inputContain.classList.add('input-container-hep');

        for (let i = 0; i < key.length; i++) {
          let inputA = document.createElement('input');
          inputA.setAttribute('type', 'text');
          inputA.classList.add('input-box');
          inputA.setAttribute('maxlength', '1');
          inputA.id = `input-box${i}`;
          inputContain.appendChild(inputA);
        }
        e.appendChild(inputContain);
      }
    });
  }
  const firstInput = document.querySelector('#input-box0');
  const secondInput = document.querySelector('#input-box1');
  const outputBox = document.querySelector('.checkA');
  outputBox.value = '';
  document.querySelector('.dien').classList.add('hidden');
  outputBox.style.display = 'none';
  let arrSo = arrCalculateFromString(bieuthuc);
  let so1 = arrSo[0].toString().split('').map(Number);
  let so2 = arrSo[2].toString().split('').map(Number);

  if (firstInput && secondInput && arrSo[0].length == 1 && arrSo[2].length == 1) {
    secondInput.style.backgroundColor = '#1e97f3';
    firstInput.style.backgroundColor = '#c81010';
    console.log('doi');
  }
  if (firstInput && !secondInput && arrSo[0].length == 2 && arrSo[2].length == 1) {
    // secondInput.style.backgroundColor = '#1e97f3'
    firstInput.style.backgroundColor = '#c81010';
    console.log('doi');
  }
  if (firstInput && secondInput) {
    firstInput.addEventListener('input', function () {
      if (this.value.length === this.maxLength) {
        if (secondInput.value === '') {
          secondInput.focus();
          // secondInput.value = '';
        }
      }
      updateOutput();
    });

    secondInput.addEventListener('input', function () {
      if (this.value.length === this.maxLength) {
        // Check if the current input field is empty before moving focus
        if (firstInput.value === '') {
          firstInput.focus();
          // firstInput.value = '';
        }
      }
      updateOutput();
    });
  } else {
    firstInput.addEventListener('input', function () {
      if (this.value.length === this.maxLength) {
        // Xử lý khi chỉ có một ô input
        updateOutput();
      }
    });
  }

  function updateOutput() {
    if (firstInput && secondInput) {
      outputBox.value = firstInput.value + secondInput.value;
    } else {
      outputBox.value = firstInput.value;
    }
  }

  console.log(document.querySelector('#traloithuam'));
  console.log(window.getComputedStyle(document.querySelector('#traloithuam')).display);

  if (
    window.getComputedStyle(document.querySelector('#traloithuam')).display === 'none' ||
    window.getComputedStyle(document.querySelector('#traloikeotha')).display === 'none'
  ) {
    document.querySelector('.input-container-hep').style.display = 'none';
    document.querySelector('.checkA').style.display = 'block';
  }
}

const Input = document.querySelectorAll('.input-box');

Input.forEach((e) => {
  e.addEventListener('input', function () {
    // Kiểm tra nếu độ dài của giá trị nhập vào lớn hơn 1, cắt chuỗi chỉ lấy ký tự đầu tiên
    if (e.value.length > 1) {
      e.value = e.value.slice(0, 1);
    }

    // Thực hiện các thao tác khác ở đây nếu cần
  });
});

function huongDanTinh(num1, num2, pheptinh) {
  // Chuyển hai số thành mảng các chữ số
  let arr1 = num1.toString().split('').map(Number);
  let arr2 = num2.toString().split('').map(Number);
  let numA1;
  let numA2;

  let nho = 0;
  let muon = 0;
  let ghi;
  let temp = 0;
  let max;
  let min;
  arr1.reverse();
  arr2.reverse();

  numA1 = arr1;
  numA2 = arr2;
  max = parseInt(num1);
  min = parseInt(num2);

  len1 = numA1.lenght;
  len2 = numA2.lenght;
  console.log(numA1);
  console.log(numA2);
  let bieuthuc = 'phép tính ' + max + (pheptinh == '-' ? ' trừ ' : ' cộng ') + min;
  let result = 'phép tính ' + max + (pheptinh == '-' ? ' trừ ' : ' cộng ') + min + ' được tính như sau. ';
  result += 'lấy hàng đơn vị của số thứ nhất là ' + numA1[0] + (pheptinh == '-' ? ' trừ ' : ' cộng ') + 'hàng đơn vị của số thứ hai là ' + numA2[0];
  if (!(parseInt(numA1[0]) - parseInt(numA2[0]) < 0 && pheptinh == '-')) {
    result += '. Ta được kết quả là: ' + (pheptinh == '-' ? parseInt(numA1[0]) - parseInt(numA2[0]) : parseInt(numA1[0]) + parseInt(numA2[0]));
  }

  if (numA1[1] && !numA2[1]) {
    if (pheptinh == '+') {
      if (parseInt(numA1[0]) + parseInt(numA2[0]) >= 10) {
        nho = 1;
        result += `, ghi ${(max + min) % 10} vào hàng đơn vị và nhớ một vào hàng chục. Sau đó, lấy hàng chục của số thứ nhất là ${
          numA1[1]
        } cộng thêm nhớ một ta được ${numA1[1] + 1} ghi lại vào hàng chục của kết quả`;
      } else {
        result += `, ghi lại vào hàng đơn vị. Sau đó, lấy hàng chục của số thứ nhất là ${numA1[1]} ghi lại vào hàng chục của kết quả.`;
      }
    } else {
      if (parseInt(numA1[0]) - parseInt(numA2[0]) < 0 && pheptinh == '-') {
        nho = 1;
        result += `, ta thấy hàng dơn vị số thứ nhất nhỏ hơn hàng đơn vị số thứ 2, nên ta mượn 10 vào hàng đơn vị số thứ nhất được ${
          numA1[0] + 10
        } trừ đi hàng đơn vị của số thứ 2 là ${numA2[0]}. Ta được kết quả là ${numA1[0] + 10 - numA2[0]}. 
                ghi vào hàng đơn vị của kết quả và mượn ở 1 vào hàng chục số thứ nhất. lấy hàng chục số thứ nhất là ${numA1[1]} trừ đi mượn 1 ta được ${
          numA1[1] - 1
        } và ghi lại vào hàng chục của kết quả`;
      } else {
        result += `, ghi lại vào hàng đơn vị. Sau đó, lấy hàng chục của số thứ nhất là ${numA1[1]} ghi lại vào hàng chục của kết quả`;
      }
    }
  } else if (!numA1[1] && numA2[1]) {
    if (pheptinh == '+') {
      if (parseInt(numA1[0]) + parseInt(numA2[0]) >= 10) {
        nho = 1;
        result += `, ghi ${(max + min) % 10} vào hàng đơn vị và nhớ một vào hàng chục. Sau đó, lấy hàng chục của số thứ hai là ${
          numA2[1]
        } cộng thêm nhớ một ta được ${numA2[1] + 1} ghi lại vào hàng chục của kết quả`;
      } else {
        result += `, ghi lại vào hàng đơn vị. Sau đó, lấy hàng chục của số thứ hai là ${numA1[1]} ghi lại vào hàng chục của kết quả.`;
      }
    }
  } else if (numA1[1] && numA2[1]) {
    if (pheptinh == '+') {
      if (parseInt(numA1[0]) + parseInt(numA2[0]) >= 10) {
        nho = 1;
        result += `, ghi ${(max + min) % 10} vào hàng đơn vị và nhớ một vào hàng chục. Sau đó, lấy hàng chục của số thứ nhất là ${
          numA1[1]
        } cộng thêm nhớ một ta được ${numA1[1] + 1}. rồi cộng với hàng chục của số thứ hai
                , là ${numA2[1]}. ta được ${numA1[1] + 1 + numA2[1]}, rồi ghi lại vào hàng chục của kết quả`;
      } else {
        result += `, ghi lại vào hàng đơn vị. Sau đó, lấy hàng chục của số thứ nhất là ${numA1[1]}, cộng với hàng chục của số thứ hai, là ${numA2[1]}. 
                ta được ${numA1[1] + numA2[1]}, rồi ghi lại vào hàng chục của kết quả`;
      }
    } else {
      if (parseInt(numA1[0]) - parseInt(numA2[0]) < 0 && pheptinh == '-') {
        nho = 1;
        result += `, ta thấy hàng dơn vị số thứ nhất nhỏ hơn hàng đơn vị số thứ 2, nên ta mượn 10 vào hàng đơn vị số thứ nhất được ${
          numA1[0] + 10
        } trừ đi hàng đơn vị của số thứ 2 là ${numA2[0]}. Ta được kết quả là ${numA1[0] + 10 - numA2[0]}. 
                ghi vào hàng đơn vị của kết quả và mượn 1 ở vào hàng chục số thứ nhất. lấy hàng chục số thứ nhất là ${numA1[1]} trừ đi mượn 1 ta được ${
          numA1[1] - 1
        }. rồi trừ đi hàng chục của số thứ hai 
                là ${numA2[1]}. ta thu được kết quả là ${numA1[1] - numA2[1] - 1} và ghi lại vào hàng chục của kết quả`;
      } else {
        result += `, ghi lại vào hàng đơn vị. Sau đó, lấy hàng chục số thứ nhất là ${numA1[1]}. rồi trừ đi hàng chục của số thứ hai 
                là ${numA2[1]}. ta thu được kết quả là ${numA1[1] - numA2[1]} và ghi lại vào hàng chục của kết quả`;
      }
    }
  }
  result += `. Vậy kết quả của biểu thức là ${pheptinh == '-' ? parseInt(num1) - parseInt(num2) : parseInt(num1) + parseInt(num2)}`;
  console.log(result);
  return result;
}

function addObj(id, num, phep_tinh) {
  let zoneshow = document.querySelector(`#${id}`);
  let imgObj = document.createElement('img');
  let obj;
  if (phep_tinh == '+') {
    if (num == 10) {
      obj = './src/image/boque.png';
      imgObj.style.width = `62.5px`;
      imgObj.style.height = `125px`;
    } else {
      obj = './src/image/motque.png';
      imgObj.style.width = `25px`;
      imgObj.style.height = `100px`;
    }
    imgObj.src = `${obj}`;
    imgObj.classList.add('imgObj');
    zoneshow.appendChild(imgObj); // Thêm divObj vào zoneshow thay vì imgObj
    const elements = document.querySelectorAll('[src*="./src/image/motque.png"]');
    if (elements.length >= 10) {
      for (let i = 0; i < 10; i++) {
        xoaAnh(1);
      }
      // speakVietnamese("Có 10 quả táo trên màn hình vì thế cho vào 1 giỏ táo").then(() => {
      addObj('num1', 10, '+');
      // }).catch(error => {
      //     console.error('Đã xảy ra lỗi khi nói:', error);
      // });
    }
  } else {
    if (num == 10) {
      obj = './src/image/boque_tru.png';
      imgObj.style.width = `50px`;
      imgObj.style.height = `100px`;
    } else {
      obj = './src/image/motque_tru.png';
      imgObj.style.width = `30px`;
      imgObj.style.height = `100px`;
    }
    imgObj.src = `${obj}`;
    imgObj.classList.add('imgObj');
    zoneshow.appendChild(imgObj); // Thêm divObj vào zoneshow thay vì imgObj
    const elements = document.querySelectorAll('[src*="./src/image/motque_tru.png"]');
    if (elements.length >= 10) {
      for (let i = 0; i < 10; i++) {
        xoaAnh(1);
      }
      // speakVietnamese("Có 10 quả táo trên màn hình vì thế cho vào 1 giỏ táo").then(() => {
      addObj('num1', 10, '-');
      // }).catch(error => {
      //     console.error('Đã xảy ra lỗi khi nói:', error);
      // });
    }
  }
}

// function xoaAnh(num) {
//     let obj
//     if (num == 10) {
//         obj = "./src/image/boque.png"
//     } else {
//         obj = "./src/image/motque.png"
//     }
//     const image = document.querySelector('img[src="' + obj + '"]');
//     if (image) {
//         image.remove(); // Xóa ảnh khỏi DOM
//         console.log("Đã xóa ảnh có đường dẫn: " + obj);
//     } else {
//         if (num == 1) {
//             obj = "./src/image/boque.png"
//             const image = document.querySelector('img[src="' + obj + '"]');
//             if (image) {
//                 image.remove(); // Xóa ảnh khỏi DOM
//                 console.log("Đã xóa ảnh có đường dẫn: " + obj);
//             }
//             for (let i = 0; i < 9; i++) {
//                 addObj("num1", 1);
//             }
//         }
//     }
// }

function helpQuetinh(bieuthuc, index) {
  them_lu_vet('luu_vet', 11);
  let arrSo = arrCalculateFromString(bieuthuc);
  let num1 = tachSoThanhPhan10(arrSo[0]);
  let num2 = tachSoThanhPhan10(arrSo[2]);
  console.log(arrSo[1]);
  if (arrSo[1] == '-') {
    showHelp.innerHTML = '';
    showHelp.innerHTML = `
            <div id="huongDanTinh"  class="box-phepTinh">
                <div style="display:flex; ">
                    <div id="num1" style="display:flex; flex-direction: column;">
                        <div id="num1_10"></div>
                        <div id="num2_10"></div>
                        
                    </div>
                    <div id="num2" style="display:flex; flex-direction: column;">
                    <div id="num1_1" style="min-height: 125px; align-items: center;"></div>
                    <div id="num2_1" style="min-height: 125px; align-items: center;"></div>
                    </div>
                </div>
                <div class="box-phepTinh strong-help-box"><span>${arrSo[0]}</span> <span>${arrSo[1]}</span> <span>${arrSo[2]}</span> <span>=</span> <span>?</span><div>
            </div>
            `;

    num1.forEach((u) => {
      if (u == 10) {
        addObj('num1_10', 10, '+');
      } else {
        for (let i = 0; i < u - num2; i++) {
          addObj('num1_1', 1, '+');
        }
      }
    });

    num2.forEach((u) => {
      if (u == 10) {
        addObj('num1_10', 10, '-');
      } else {
        for (let i = 0; i < u; i++) {
          addObj('num1_1', 1, '-');
        }
      }
    });
  } else {
    showHelp.innerHTML = '';
    showHelp.innerHTML = `
            <div id="huongDanTinh"  class="box-phepTinh">
                <div style="display:flex; ">
                    <div id="num1" style="display:flex; flex-direction: column;">
                        <div id="num1_10"></div>
                        <div id="num2_10"></div>
                        
                    </div>
                    <div id="num2" style="display:flex; flex-direction: column;">
                        <div id="num1_1" style="min-height: 125px; align-items: center; "></div>
                        <div id="num2_1" style="min-height: 125px; align-items: center; "></div>
                    </div>
                </div>
                <div class="box-phepTinh strong-help-box"><span>${arrSo[0]}</span> <span>${arrSo[1]}</span> <span>${arrSo[2]}</span> <span>=</span> <span>?</span><div>
            </div>
            `;

    num1.forEach((u) => {
      if (u == 10) {
        addObj('num1_10', 10, '+');
      } else {
        for (let i = 0; i < u; i++) {
          addObj('num1_1', 1, '+');
        }
      }
    });

    num2.forEach((u) => {
      if (u == 10) {
        addObj('num2_10', 10, '+');
      } else {
        for (let i = 0; i < u; i++) {
          addObj('num2_1', 1, '+');
        }
      }
    });
  }
}

// Hàm tia số
function helpTiaSo(bieuthuc) {
  them_lu_vet('luu_vet', 14);
  function tachBieuThuc(bieuThuc) {
    let phanTu = [];
    let soTam = '';
    for (let char of bieuThuc) {
      if (!isNaN(char)) {
        soTam += char;
      } else {
        if (soTam !== '') {
          phanTu.push(soTam);
          soTam = '';
        }
        phanTu.push(char);
      }
    }
    if (soTam !== '') {
      phanTu.push(soTam);
    }
    return phanTu;
  }

  showHelp.innerHTML = '';

  var support = document.getElementById('support');
  support.innerHTML = '';
  var arrSo = tachBieuThuc(bieuthuc);
  var firstNumber = parseInt(arrSo[0]);
  var dau = arrSo[1];
  var secondNumber = parseInt(arrSo[2]); //

  var ti_le = 1000;
  // var toc_do_ho_tro_tia_so =3;
  var toc_do_ho_tro_tia_so = localStorage.getItem('toc_do_ho_tro_tia_so');
  var toc_do_ho_tro_tia_so_v2 = toc_do_ho_tro_tia_so + 0.5;
  var toc_do_xyz = 1000 * toc_do_ho_tro_tia_so;
  // const toc_do_ho_tro_bang = localStorage.getItem('toc_do_ho_tro_tia_so');
  // console.log(firstNumber);
  // console.log(dau);
  // console.log(secondNumber);
  if (dau == '+') {
    var min = firstNumber;
    var max = firstNumber + secondNumber;

    // Tạo phần tử tia số
    var tiaSo = document.createElement('div');
    tiaSo.className = 'tia-so';
    tiaSo.style.maxWidth = 90 + '%';
    support.appendChild(tiaSo);

    // mũi tên đầu tia số
    var arrow = document.createElement('div');
    arrow.className = 'arrow';
    tiaSo.appendChild(arrow);

    // Hiển thị các vạch và số trên tia số
    var step = 1; // Bước mặc định là 1
    for (var i = min; i <= max; i += step) {
      var tick = document.createElement('div');
      tick.className = 'tick';
      tick.style.left = ((i - min) / (max - min)) * 70 + 10 + '%';
      tiaSo.appendChild(tick);
    }
    var number = document.createElement('div');
    number.className = 'number';
    number.style.left = '10%'; // Vị trí bắt đầu
    number.textContent = min;
    tiaSo.appendChild(number);

    var i = min + step; // Bắt đầu từ số thứ 2
    var interval = setInterval(function () {
      if (i <= max) {
        var number = document.createElement('div');
        number.className = 'number';
        number.style.left = ((i - min) / (max - min)) * 70 + 10 + '%';
        number.textContent = '?';
        tiaSo.appendChild(number);
        i += step;
      } else {
        clearInterval(interval); // Dừng setInterval khi đã hiển thị hết các số
      }
    }, toc_do_xyz);

    var count = max - min;

    // Tạo và hiển thị hình quả táo
    var tiaSoWidth = tiaSo.offsetWidth;
    var tickWidth = tiaSoWidth / (count + 1);

    function showApple(index) {
      if (index > count) return; // Điều kiện dừng đệ quy
      setTimeout(function () {
        var apple = document.createElement('img');
        apple.src = './src/image/1.png';
        apple.className = 'apple';
        // apple.style.left = index * tickWidth - 80 + "px";
        apple.style.left = index * 33 + '%';
        tiaSo.appendChild(apple);

        showApple(index + 1); // Gọi đệ quy với index tăng lên
      }, toc_do_xyz); // Thời gian delay giữa mỗi lần hiển thị hình ảnh (miliseconds)
    }
    showApple(1); // Bắt đầu đệ quy từ index 1 sau 5 giây

    // Tạo và hiển thị hình mũi tên
    var arrowWidth = arrow.offsetWidth;
    var arrowWidth = arrowWidth / (count + 1);
    function showArrow(index) {
      if (index > count) return; // Điều kiện dừng đệ quy
      setTimeout(function () {
        var arrow = document.createElement('img');
        arrow.src = './src/image/arrow_curve.png';
        arrow.className = 'muiten';
        // arrow.style.left = index * tickWidth + 50 + "px";
        arrow.style.left = index * 35 + '%';
        tiaSo.appendChild(arrow);

        showArrow(index + 1); // Gọi đệ quy với index tăng lên
      }, toc_do_xyz); // Thời gian delay giữa mỗi lần hiển thị hình ảnh (miliseconds)
    }

    showArrow(1); // Bắt đầu đệ quy từ index 1
  } else {
    var max = firstNumber;
    var min = firstNumber - secondNumber;

    var tiaSo = document.createElement('div');
    tiaSo.className = 'tia-so';
    // tiaSo.style.width = 800 + "px";
    support.appendChild(tiaSo);

    // mũi tên đầu tia số
    var arrow = document.createElement('div');
    arrow.className = 'arrow';
    tiaSo.appendChild(arrow);

    // Hiển thị các vạch và số trên tia số
    var step = 1; // Bước mặc định là 1
    for (var i = min; i <= max; i += step) {
      // Bắt đầu từ max và giảm dần cho đến min
      var tick = document.createElement('div');
      tick.className = 'tick';
      tick.style.left = ((max - i) / (max - min)) * 70 + 10 + '%'; // Thay đổi cách tính toán vị trí
      tiaSo.appendChild(tick);
      if (i == max) {
        var number = document.createElement('div');
        number.className = 'number';
        number.className = 'number';
        number.style.left = ((i - min) / (max - min)) * 70 + 10 + '%'; // Tính toán vị trí dựa trên min và max
        number.textContent = i;
        tiaSo.appendChild(number);
      }

      // Tạo và hiển thị số
      // var number = document.createElement("div");
      // number.className = "number";
      // number.style.left = ((i - min) / (max - min) * 70 + 10) + "%"; // Tính toán vị trí dựa trên min và max
      // if (i === max) {
      //     number.textContent = i;
      // } else {
      //     number.textContent = '?';
      // }
      // tiaSo.appendChild(number);
    }
    // var number = document.createElement("div");
    // number.className = "number";
    // number.className = "number";
    // number.style.left = ((2 - min) / (max - min) * 70 + 10) + "%"; // Tính toán vị trí dựa trên min và max
    // number.textContent = 999;
    // tiaSo.appendChild(number);
    // // for (var i = max-1; i >=min; i -= 1) {

    // // }
    // Bắt đầu từ số thứ 2
    let j = max - 1;
    var interval = setInterval(function () {
      if (j >= min) {
        var number = document.createElement('div');
        number.className = 'number';
        number.className = 'number';
        number.style.left = ((j - min) / (max - min)) * 70 + 10 + '%'; // Tính toán vị trí dựa trên min và max
        number.textContent = j;
        tiaSo.appendChild(number);
        j--;
      } else {
        clearInterval(interval); // Dừng setInterval khi đã hiển thị hết các số
      }
    }, toc_do_xyz);

    var count = max - min;
    var tiaSoWidth = tiaSo.offsetWidth;
    var tickWidth = tiaSoWidth / (count + 1);

    function showApple(index) {
      if (index > count) return; // Điều kiện dừng đệ quy
      setTimeout(function () {
        var apple = document.createElement('img');
        apple.src = './src/image/tru1.png';
        apple.className = 'apple';
        // apple.style.left = index * tickWidth - 80 + "px";
        apple.style.left = (tiaSoWidth - (index + 1) * tickWidth + 180) / 12 + '%';
        tiaSo.appendChild(apple);

        showApple(index + 1); // Gọi đệ quy với index tăng lên
      }, toc_do_xyz); // Thời gian delay giữa mỗi lần hiển thị hình ảnh (miliseconds)
    }

    showApple(1); // Bắt đầu đệ quy từ index 1
    var arrowWidth = arrow.offsetWidth;
    var arrowWidth = arrowWidth / (count + 1);
    function showArrow(index) {
      if (index > count) return; // Điều kiện dừng đệ quy
      setTimeout(function () {
        var arrow2 = document.createElement('img');
        arrow2.src = './src/image/giam.png';
        arrow2.className = 'muiten2';
        // arrow2.style.left = (index * tickWidth + 50) + "px";
        arrow2.style.left = (tiaSoWidth - index * tickWidth + 50) / 11 + '%';
        tiaSo.appendChild(arrow2);

        showArrow(index + 1); // Gọi đệ quy với index tăng lên
      }, toc_do_xyz); // Thời gian delay giữa mỗi lần hiển thị hình ảnh (miliseconds)
    }

    showArrow(1); // Bắt đầu đệ quy từ index 1
  }
}

// Hàm tạo bảng

// Hàm tạo bảng
function drawTable(firstNumber, secondNumber, operation) {
  them_lu_vet('luu_vet', 13);
  // console.log(firstNumber)
  showHelp.innerHTML = '';
  var container = document.getElementById('tableContainer');
  container.innerHTML = '';
  var table = document.createElement('table');
  var one = firstNumber;
  var two = secondNumber;
  var delta = firstNumber % 10;
  var tinh = one - delta;
  var tru = firstNumber;
  var so = 1;
  var tong = firstNumber + secondNumber;
  var sub = firstNumber - secondNumber;
  var sub_delta = sub % 10;
  var tinh_tru = sub - sub_delta;
  var tru_2 = secondNumber;

  for (var i = 0; i < 3; i++) {
    var row = document.createElement('tr');
    for (var j = 0; j < 10; j++) {
      if (operation == '+') {
        var cell = document.createElement('td');
        cell.className = tinh;
        var div = document.createElement('div');
        div.className = 'bocso';
        div.id = tinh;
        div.textContent = tinh;
        cell.appendChild(div);
        row.appendChild(cell);

        so++;
        tru++;

        tinh++;
      } else {
        var cell = document.createElement('td');
        cell.className = tinh;
        var div = document.createElement('div');
        div.className = 'bocso';
        div.id = tinh_tru;
        div.textContent = tinh_tru;
        cell.appendChild(div);
        row.appendChild(cell);

        tinh_tru++;
      }
    }
    table.appendChild(row);
  }
  container.appendChild(table);
  animateColor(one, two, operation);
}

// Hàm tạo hiệu ứng
function animateColor(one, two, operation) {
  var cells = document.querySelectorAll('.bocso');
  var delay = 1000;
  var delayDecreaseFactor = 0.9;
  var counter = 1;
  var sum = one + two;
  var index = 1;
  var tru_2 = two;
  // min 1.5
  //max 5
  // const toc_do_ho_tro_bang =2.5

  const toc_do_ho_tro_bang = localStorage.getItem('toc_do_ho_tro_bang');
  if (operation === '+') {
    cells.forEach(function (cell) {
      var id = parseInt(cell.textContent);
      if (id === one) {
        cell.style.backgroundColor = 'lightpink';
        cell.style.boxShadow = '0 0 10px 10px lightblue';
      }
      if (id > one && id <= sum) {
        setTimeout(function () {
          var speech = new SpeechSynthesisUtterance();
          speech.lang = 'vi-VN';
          speech.volume = 1;
          speech.rate = 1;
          speech.pitch = 1;
          speech.text = 'Cộng' + index;
          $a = 'Cộng' + index;
          speakVietnamese_help($a);
          cell.style.boxShadow = '-15px 0px 10px 5px lightblue';
          cell.style.transform = 'translateX(4px)';
          cell.style.transition = 'transform 0.3s ease';
          cell.style.animation = 'moveRight 0.3s ease';
          // window.speechSynthesis.speak(speech);

          var smallElement = document.createElement('div');
          smallElement.className = 'small-element';
          smallElement.textContent = '+' + index;
          cell.appendChild(smallElement);

          if (id === sum) {
            // var speech_2 = new SpeechSynthesisUtterance();
            // speech_2.lang = 'vi-VN';
            // speech_2.volume = 1;
            // speech_2.rate = 1;
            // speech_2.pitch = 1;
            // speech_2.text = "Đáp án là" + id;
            cell.style.backgroundColor = 'red';
            cell.style.border = '5px solid red';
            // window.speechSynthesis.speak(speech_2);
          } else {
            var image = document.createElement('img');
            image.className = 'img-above-number';
            image.src = 'src/image/chan_gau.png';
            image.style.transform = 'rotate(90deg)';
            cell.appendChild(image);
          }
          index++;
        }, delay * counter * toc_do_ho_tro_bang);
        counter++;
      }
    });
  } else if (operation === '-') {
    var reversedCells = Array.from(cells).reverse();
    var sub = one - two;

    reversedCells.forEach(function (cell) {
      var id = parseInt(cell.textContent);
      if (id === one) {
        cell.style.backgroundColor = 'lightpink';
        cell.style.boxShadow = '0 0 10px 10px lightblue';
        cell.style.border = '5px solid lightpink';
      }

      if (id >= sub && id < one) {
        setTimeout(function () {
          var speech = new SpeechSynthesisUtterance();
          speech.lang = 'vi-VN';
          speech.volume = 1;
          speech.rate = 1;
          speech.pitch = 1;
          speech.text = 'Trừ' + index;
          // window.speechSynthesis.speak(speech);
          $a = 'Trừ' + index;
          speakVietnamese_help($a);

          cell.style.boxShadow = '15px 0px 10px 5px lightblue';
          cell.style.transform = 'translateX(-4px)';
          cell.style.transition = 'transform 0.3s ease';
          cell.style.animation = 'moveLeft 0.3s ease';

          var smallElement = document.createElement('div');
          smallElement.className = 'small-element';
          smallElement.textContent = '-' + index;
          cell.appendChild(smallElement);

          if (id === sub) {
            // var speech_2 = new SpeechSynthesisUtterance();
            // speech_2.lang = 'vi-VN';
            // speech_2.volume = 1;
            // speech_2.rate = 1;
            // speech_2.pitch = 1;
            // speech_2.text = "Đáp án là" + id;
            cell.style.backgroundColor = 'red';
            cell.style.border = '5px solid red';
            // window.speechSynthesis.speak(speech_2);
          } else {
            var image = document.createElement('img');
            image.className = 'img-above-number';
            image.src = 'src/image/chan_gau.png';
            image.style.transform = 'rotate(-90deg)';
            cell.appendChild(image);
          }
          index++;
        }, delay * counter * toc_do_ho_tro_bang);
        counter++;
      }
    });
  }
}
async function speakVietnamese_help(text) {
  const apiUrl = 'https://api.fpt.ai/hmi/tts/v5';
  const apiKey = 'VDQwLGIpyKGagN0XwGPAM3p8R8QAVUsJ';
  const voice = localStorage.getItem('giong');
  const speed = localStorage.getItem('toc_do');

  console.log('giong:' + voice);
  console.log('td:' + speed);
  try {
    const response = await fetch(apiUrl, {
      method: 'POST',
      headers: {
        'api-key': apiKey,
        speed: speed,
        voice: voice,
        'Content-Type': 'application/x-www-form-urlencoded',
      },
      body: text,
    });

    if (!response.ok) {
      throw new Error('Network response was not ok ' + response.statusText);
    }

    const data = await response.json();
    const audioUrl = data.async;
    console.log('Audio URL:', audioUrl);

    const audio = new Audio(audioUrl);
    await audio.play();
    console.log('Đang phát âm thanh.');
  } catch (error) {
    console.error('Có lỗi xảy ra khi phát âm thanh:', error);
  }
}

// lego
function generateLEGO(bieuthuc) {
  them_lu_vet('luu_vet', 12);
  showHelp.innerHTML = '';
  const legoContainer = document.getElementById('legoContainer');
  legoContainer.innerHTML = '';
  const math = bieuthuc.match(/[+\-*/]/g);
  const numbers = bieuthuc.match(/\d+/g);

  if (numbers) {
    let i = 0;
    numbers.forEach((number) => {
      let legoDots = '';
      let legoCount = parseInt(number);

      while (legoCount > 0) {
        if (i === 0) {
          legoDots += '<img src="./src/image/lego_1.png" width="50px">';
        } else {
          legoDots += '<img src="./src/image/lego_2.png" width="50px">';
        }
        legoCount -= 1;
      }

      const legoImage = document.createElement('div');
      legoImage.innerHTML = legoDots;
      legoImage.classList.add('lego');
      legoContainer.appendChild(legoImage);

      if (i < math.length) {
        const mathImage = document.createElement('div');
        let mathDots = '';
        switch (math[i]) {
          case '+':
            mathDots += '<img src="./src/image/daucong.png" width="50px">';
            break;
          case '-':
            mathDots += '<img src="./src/image/dautru.png" width="50px">';
            break;
        }
        mathImage.innerHTML = mathDots;
        mathImage.style.display = 'flex';
        mathImage.style.alignItems = 'center';
        legoContainer.appendChild(mathImage);
      }

      i++;
    });

    // Thêm dấu bằng vào giữa hai cột lego
    const equalsImage = document.createElement('div');
    equalsImage.innerHTML = '<img src="./src/image/daubang.png" width="50px">';
    equalsImage.style.display = 'flex';
    equalsImage.style.alignItems = 'center';
    legoContainer.appendChild(equalsImage);

    // Thêm ô input kết quả vào giữa hai cột lego
    const answerInput = document.createElement('div');
    answerInput.innerHTML = '<input type="number" id="mathAnswer" placeholder="?">';
    answerInput.style.display = 'flex';
    answerInput.style.alignItems = 'center';
    legoContainer.appendChild(answerInput);
  }
}

function them_lu_vet(key, newValue) {
  // Bước 1: Lấy mảng hiện tại từ localStorage
  let currentArray = JSON.parse(localStorage.getItem(key));

  // Bước 2: Nếu mảng chưa tồn tại, tạo mảng mới
  if (!currentArray) {
    currentArray = [];
  }

  // Bước 3: Thêm giá trị mới vào mảng
  currentArray.push(newValue);

  // Bước 4: Lưu lại mảng đã cập nhật vào localStorage
  localStorage.setItem(key, JSON.stringify(currentArray));
}
