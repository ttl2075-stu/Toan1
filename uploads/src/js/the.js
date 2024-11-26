function drag(ev) {
  ev.dataTransfer.setData("text", ev.target.innerText);
  ev.dataTransfer.setData("id", ev.target.id);
}

document.querySelectorAll('.tag').forEach(item => {
  item.addEventListener('dragstart', drag);
});

document.querySelectorAll('.checkA').forEach(u => {
  u.addEventListener("dragover", function (ev) {
    ev.preventDefault();
  });
})

document.querySelectorAll('.checkA').forEach(u => {
  u.addEventListener("drop", function (ev) {
    ev.preventDefault();
    let data = ev.dataTransfer.getData("text");
    let id = ev.dataTransfer.getData("id")
    let the = document.getElementById(id)
    console.log(id)
    // if (ev.target.value == '') {
    ev.target.value = data;
    document.querySelectorAll(`#box-quiz${quizShow} .tag`).forEach(u => {
      u.classList.remove('hiddenThe');
    });
    the.classList.add('hiddenThe')
    // } else {
    //   let temp = ev.target.value
    //   ev.target.value = data;
    //   the.textContent = temp
    // }
  });
})