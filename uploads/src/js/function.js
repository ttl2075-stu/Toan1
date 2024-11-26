function upLocalStorage(key, value) {
    localStorage.setItem(key, JSON.stringify(value))
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
function laySoTuChuoi(chuoi) {
    const so = chuoi.match(/\d+/g); // Sử dụng biểu thức chính quy để lấy ra các số từ chuỗi
    if (so) {
        return so.map(Number); // Chuyển đổi mảng chuỗi số thành mảng số nguyên
    } else {
        return []; // Trả về mảng rỗng nếu không tìm thấy số trong chuỗi
    }
}

const pathObj = [
    "../src/uploads/obj1_1.png",
    "../src/uploads/obj2_1.png",
    "../src/uploads/obj2_2.png"
]

function getRandomElement(arr) {
    const randomIndex = Math.floor(Math.random() * arr.length);
    return arr[randomIndex];
}

function calculateFromString(expression) {
    const operators = ['+', '-', '*', '/'];
    let operatorFound = '';

    for (let operator of operators) {
        if (expression.includes(operator)) {
            operatorFound = operator;
            break;
        }
    }

    const operands = expression.split(operatorFound).map(Number);

    if (operands.some(isNaN)) {
        throw new Error("Invalid operands");
    }

    switch (operatorFound) {
        case '+':
            return operands[0] + operands[1];
        case '-':
            return operands[0] - operands[1];
        case '*':
            return operands[0] * operands[1];
        case '/':
            if (operands[1] === 0) throw new Error("Cannot divide by zero");
            return operands[0] / operands[1];
        default:
            throw new Error("Operator not supported");
    }
}

function arrCalculateFromString(expression) {
    // Sử dụng biểu thức chính quy để chia nhỏ biểu thức thành các phần tử
    // Chia nhỏ theo dấu +, -, *, /, (, và )
    return expression.split(/([()+\-*/])/).filter(function(e) { return e.trim().length > 0; });
}

// sap xep mang ngau nhien
function shuffleArray(array) {
    return array.sort(() => Math.random() - 0.5);
}

window.onbeforeunload = function () {
    return "Trang này sắp được tải lại. Bạn có chắc chắn muốn rời khỏi trang?";
};

function returnToForm() {
    if (hasAnsweredOnce) {
        const confirmation = confirm(
            "Bạn đã bắt đầu làm bài kiểm tra và sẽ mất toàn bộ kết quả nếu quay lại. Bạn có chắc chắn muốn tiếp tục không?"
        );
        if (confirmation) {
            window.location.href = "nhap_cau_hoi.php";
        }
    }
    else {
        window.location.href = "nhap_cau_hoi.php";
    }
}

// function speakVietnamese(randomNum) {
//     return new Promise((resolve, reject) => {
//         let msg = new SpeechSynthesisUtterance();
//         msg.text = randomNum;
//         msg.lang = 'vi-VN';

//         msg.onend = function(event) {
//             resolve(); // Khi giọng nói kết thúc, giải quyết promise
//         };

//         window.speechSynthesis.speak(msg);
//     });
// }

function speakVietnamese(randomNum) {
    return new Promise((resolve, reject) => {
        let msg = new SpeechSynthesisUtterance();
        msg.text = randomNum;
        msg.lang = 'vi-VN';

        // Thay đổi giọng nói và tốc độ
        msg.voice = speechSynthesis.getVoices().find(voice => voice.lang === 'vi-VN');
        msg.rate = 0.8; // Tốc độ mặc định là 1, giảm xuống để chậm hơn

        msg.onend = function (event) {
            resolve(); // Khi giọng nói kết thúc, giải quyết promise
        };

        window.speechSynthesis.speak(msg);
    });
}


function emphasizeNumbers(text) {
    // Sử dụng regex để tìm các số trong đoạn văn bản
    var regex = /\d+/g;

    // Thay thế mỗi số bằng phiên bản được nhấn mạnh
    return text.replace(regex, function (match) {
        return '<strong style="color: green; font-size: 20px">' + match + '</strong>';
    });
}

function tachSoThanhPhan10(number) {
    const parts = [];

    while (number > 10) {
        parts.push(10);
        number -= 10;
    }

    if (number > 0) {
        parts.push(number);
    }

    return parts;
}
// chi rand nhung phan tu ko co trong mang
function getRandomNumberNotInArray(arr) {
    let randomNumber;
    do {
        randomNumber = Math.floor(Math.random() * 101);
    } while (arr.includes(randomNumber));

    arr.push(randomNumber); // Thêm số ngẫu nhiên vào mảng truyền tham chiếu

    return randomNumber;
}
// doi mau tung ki tu trong the
function colorText(id) {
    const container = document.getElementById(id);
    if (!container) return;

    const text = container.innerText; // Lấy nội dung của phần tử

    const colors = ['red', 'blue', 'green', 'orange', 'purple', 'cyan', 'magenta', 'yellow', 'gray', 'brown', 'pink'];
    // Mảng chứa các màu

    let coloredHTML = ''; // Chuỗi để chứa HTML với màu được áp dụng cho mỗi kí tự

    // Chia nhỏ nội dung thành từng kí tự và áp dụng màu cho từng kí tự
    for (let i = text.length - 1; i >= 0; i--) {
        const color = colors[i % colors.length];
        const char = text[text.length - 1 - i];
        coloredHTML += `<span style="color: ${color};">${char}</span>`;
    }

    container.innerHTML = coloredHTML;
}
// cân bằng phần tử 2 mảng
function adjustArrays(arr1, arr2) {
    // Kiểm tra kích thước của hai mảng
    const diff = Math.abs(arr1.length - arr2.length);

    // Nếu mảng 1 ngắn hơn mảng 2, thêm giá trị rỗng vào đầu của mảng 1
    if (arr1.length < arr2.length) {
        for (let i = 0; i < diff; i++) {
            arr1.unshift('');
        }
    } 
    // Ngược lại, nếu mảng 2 ngắn hơn mảng 1, thêm giá trị rỗng vào đầu của mảng 2
    else if (arr2.length < arr1.length) {
        for (let i = 0; i < diff; i++) {
            arr2.unshift('');
        }
    }

    // Trả về cả hai mảng đã điều chỉnh
    return [arr1, arr2];
}

function playAndHideVideoTrue() {
    var noticeTrue = document.querySelector('.Notice_True');
    var trueVideo = noticeTrue.querySelector('.trueVideo');
    
    // Hiển thị phần tử chứa video
    noticeTrue.style.display = 'block';
    
    // Phát video
    trueVideo.play();
    
    // Ẩn video khi kết thúc
    trueVideo.addEventListener('ended', function() {
        noticeTrue.style.display = 'none';
    });
}



function playAndHideVideoFalse() {
    var noticeTrue = document.querySelector('.Notice_False');
    var trueVideo = noticeTrue.querySelector('.falseVideo');
    
    // Hiển thị phần tử chứa video
    noticeTrue.style.display = 'block';
    
    // Phát video
    trueVideo.play();
    
    // Ẩn video khi kết thúc
    trueVideo.addEventListener('ended', function() {
        noticeTrue.style.display = 'none';
    });
}

document.addEventListener('DOMContentLoaded', function() {
    var videos = document.querySelectorAll('video');
    videos.forEach(function(video) {
        video.addEventListener('loadedmetadata', function() {
            this.controls = false;
        });
    });
});
