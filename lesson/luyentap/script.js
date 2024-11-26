const word = document.getElementById('word');
const timer = document.getElementById('timer');
const text = document.getElementById('text');
const scoreEl = document.getElementById('score');
const timeEl = document.getElementById('time');
const endgameEl = document.getElementById('end-game-container');
const settingsBtn = document.getElementById('settings-btn');
const settings = document.getElementById('settings');
const settingsForm = document.getElementById('settings-form');
const difficultySelect = document.getElementById('difficulty');

// List of words for game
const words = [
  'quả táo',
  'quả bóng',
  'cái áo',
  'lá cờ',
  'lá cây',
  'bóng tròn',
  'ông nội',
  'bà nội',
  'mẹ',
  'cô giáo',
  'thầy giáo',
  'học sinh',
  'xào xạc',
  'màu xanh',
  'viên bi',
  'phép cộng',
  'xếp hàng',
  'quả cam',
  'cái thìa',
  'cái bàn'
];

// Init word
let randomWord;

// Init score
let score = 0;

// Init time
//let time = 60;

// Set difficulty to value in ls or medium
let difficulty =
  localStorage.getItem('difficulty') !== null
    ? localStorage.getItem('difficulty')
    : 'none';
 //time = 45;
    if (difficulty != 'none') {
      if (difficulty === 'hard') {
        time = 60;
      } else if (difficulty === 'medium') {
        time = 45;
      } else if(difficulty === 'easy'){
        time = 30;
      }
      updateTime();
    timer.innerHTML = "Time left: "+ time + " s";
    }else{
     
      document.getElementById("text").readOnly = true;
      time = "none";
    }
     
// Set difficulty select value
difficultySelect.value =
  localStorage.getItem('difficulty') !== null
    ? localStorage.getItem('difficulty')
    : 'none';

// Focus on text on start
text.focus();

// Start counting down
const timeInterval = setInterval(updateTime, 1000);

// Generate random word from array
function getRandomWord() {
  return words[Math.floor(Math.random() * words.length)];
}

// Add word to DOM
function addWordToDOM() {
  randomWord = getRandomWord();
  word.innerHTML = randomWord;
}

// Update score
function updateScore() {
  score++;
  scoreEl.innerHTML = score;
}

// Update time
function updateTime() {
  if (time === "none") {
    timer.innerHTML = "Time left: "+ 0 + " s";
  }else{
    time--;
    timer.innerHTML = "Time left: "+ time + " s";

    if (time === 0) {
      clearInterval(timeInterval);
      // end game
      gameOver();
    }
  }
  
}

// Game over, show end screen
function gameOver() {
  endgameEl.innerHTML = `
    <h1>Time ran out</h1>
    <p>Your final score is ${score}</p>
    <button onclick="location.reload()">Reload</button>
  `;

  endgameEl.style.display = 'flex';
}

addWordToDOM();

// Event listeners

// Typing
text.addEventListener('input', e => {
  const insertedText = e.target.value;

  if (insertedText === randomWord) {
    addWordToDOM();
    updateScore();

    // Clear
    e.target.value = '';

   
    timeL.innerHTML = randomWord;
    updateTime();
  }
});

// Settings btn click
settingsBtn.addEventListener('click', () => settings.classList.toggle('hide'));

// Settings select
settingsForm.addEventListener('change', e => {
  difficulty = e.target.value;
  localStorage.setItem('difficulty', difficulty);
    if (difficulty != "none") {
      if (difficulty === 'hard') {
        document.getElementById("text").readOnly = false;
        time = 30;
      } else if (difficulty === 'medium') {
        document.getElementById("text").readOnly = false;
        time = 45;
      } else {
        document.getElementById("text").readOnly = false;
        time = 60;
      }
      addWordToDOM();
      // while(time!=0){
      //    updateTime();
      // timer.innerHTML = "Time left: "+ time + " s";
      // }
     
    }else {
      document.getElementById("text").readOnly = true;
      time = "none";
      timer.innerHTML = "Time left: "+ 0 + " s";
    }
  
    
});
