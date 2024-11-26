
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
            window.location.href = "nhap_de_thi.php";
        }
    }
    else {
        window.location.href = "nhap_de_thi.php";
    }
}

// begin 24/07/2024
// async function speakVietnamese(text) {
//     const apiUrl = 'https://api.fpt.ai/hmi/tts/v5';
//     const apiKey = 'VDQwLGIpyKGagN0XwGPAM3p8R8QAVUsJ';
//     const voice = 'leminh';

//     try {
//         const response = await fetch(apiUrl, {
//             method: 'POST',
//             headers: {
//                 'api-key': apiKey,
//                 'speed': '-0.5',
//                 'voice': voice,
//                 'Content-Type': 'application/x-www-form-urlencoded'
//             },
//             body: text
//         });

//         if (!response.ok) {
//             throw new Error('Network response was not ok ' + response.statusText);
//         }

//         const data = await response.json();
//         const audioUrl = data.async;
//         console.log('Audio URL:', audioUrl);

//         const audio = new Audio(audioUrl);
//         await audio.play();
//         console.log('Đang phát âm thanh.');
//     } catch (error) {
//         console.error('Có lỗi xảy ra khi phát âm thanh:', error);
//     }
// }
//end 24/07/2024

// function speakVietnamese(randomNum) {
//     return new Promise((resolve, reject) => {
//         let msg = new SpeechSynthesisUtterance();
//         msg.text = randomNum;
//         msg.lang = 'vi-VN';

//         // Đợi cho sự kiện voiceschanged trước khi lấy danh sách giọng nói
//         window.speechSynthesis.onvoiceschanged = function() {
//             // Lấy danh sách giọng nói sau khi đã được tải
//             let voices = window.speechSynthesis.getVoices();
            
//             // Tìm giọng nói tiếng Việt
//             let vietnameseVoice = voices.find(voice => voice.lang === 'vi-VN');
//             if(vietnameseVoice) {
//                 msg.voice = vietnameseVoice;
//                 msg.rate = 0.8; // Tốc độ mặc định là 1, giảm xuống để chậm hơn
//                 window.speechSynthesis.speak(msg);
//             } else {
//                 reject(new Error("Không tìm thấy giọng nói tiếng Việt."));
//             }
//         };

//         // Khi giọng nói kết thúc, giải quyết promise
//         msg.onend = function (event) {
//             resolve();
//         };
//     });
// }
// function speakVietnamese(text) {
//     const apiUrl = 'https://api.fpt.ai/hmi/tts/v5';
//     const apiKey = 'VDQwLGIpyKGagN0XwGPAM3p8R8QAVUsJ';
//     const voice = localStorage.getItem('giong');
//     const speed = localStorage.getItem('toc_do');

//     console.log('g2222iong:', voice);
//     console.log('td:', speed);

//     var xhr = new XMLHttpRequest();
//     xhr.open('POST', apiUrl, false); // false để thực hiện đồng bộ
//     xhr.setRequestHeader('api-key', apiKey);
//     xhr.setRequestHeader('speed', speed);
//     xhr.setRequestHeader('voice', voice);
//     xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    
//     xhr.onreadystatechange = function() {
//         if (xhr.readyState === 4) {
//             if (xhr.status === 200) {
//                 var data = JSON.parse(xhr.responseText);
//                 var audioUrl = data.async;
//                 console.log('Audio URL:', audioUrl);

//                 var audio = new Audio(audioUrl);
//                 audio.play();
//                 console.log('Đang phát âm thanh.');
//             } else {
//                 console.error('Có lỗi xảy ra khi phát âm thanh:', xhr.statusText);
//             }
//         }
//     };

//     xhr.send(text);
// }
// en 27/07/2024
// 22_08_2024
async function speakVietnamese(text) {
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
                'speed': speed,
                'voice': voice,
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: text
        });

        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }

        const data = await response.json();
        const audioUrl = data.async;
        console.log('Audio URL:', audioUrl);

        const audio = new Audio(audioUrl);

        // Chờ đến khi âm thanh có thể phát mà không bị gián đoạn
        audio.addEventListener('canplaythrough', function() {
            console.log('Âm thanh sẵn sàng để phát.');
            audio.play().then(() => {
                console.log('Đang phát âm thanh.');
            }).catch(error => {
                console.error('Có lỗi xảy ra khi phát âm thanh:', error);
            });
        });

        // Nếu có lỗi xảy ra, thử phát lại sau 3 giây
        audio.addEventListener('error', function() {
            console.error('Có lỗi xảy ra khi tải âm thanh. Thử lại sau 3 giây.');
            setTimeout(() => {
                audio.load(); // Tải lại file âm thanh
            }, 3000);
        });

    } catch (error) {
        console.error('Có lỗi xảy ra khi phát âm thanh:', error);
    }
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
        randomNumber = Math.floor(Math.random() * 10);
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
    var trueAudio = noticeTrue.querySelector('.trueAudio');

    noticeTrue.style.display = 'block';

    trueVideo.style.display = 'block';
    trueAudio.play();
    trueAudio.addEventListener('ended', function() {
        noticeTrue.style.display = 'none';
    });
}

function playAndHideVideoFalse() {
    var noticeFalse = document.querySelector('.Notice_False');
    var falseVideo = noticeFalse.querySelector('.falseVideo');
    var falseAudio = noticeFalse.querySelector('.falseAudio');

    noticeFalse.style.display = 'block';

    falseVideo.style.display = 'block';
    falseAudio.play();
    // Hide video and notice when it ends
    falseAudio.addEventListener('ended', function() {
        noticeFalse.style.display = 'none';
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