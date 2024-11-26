function obj_a_1(a, pop) {
    let element = document.querySelector(`#img${a}_${pop}`)
    element.style.position = ''
}

function obj_2_2(a, pop) {
    let element = document.querySelector(`#img${a}_${pop}`)
    element.style.position = 'absolute'
    if (pop == 0) element.style.top = "5%";
    if (pop == 1) element.style.bottom = "5%";
}


function obj_3_2(a, pop) { 
    let element = document.querySelector(`#img${a}_${pop}`)
    element.style.position = 'absolute'
    if (pop == 0 || (pop == 3 && a == 6)) {
        element.style.left = "5%"
        element.style.top = "0px"
    }
    if (pop == 1 || (pop == 4 && a == 6)) {
        element.style.bottom = `0px`
    }
    if (pop == 2 || (pop == 5 && a == 6)) {
        element.style.right = "5%"
        element.style.top = "0px"
    }
}

function obj_3_3(a, pop) {
    let element = document.querySelector(`#img${a}_${pop}`)
    element.style.position = 'absolute'
    if (pop == 0 || (pop == 3 && a == 6)) {
        element.style.left = "5%"
        element.style.bottom = "0px"
    }
    if (pop == 1 || (pop == 4 && a == 6)) {
        element.style.top = `0px`
    }
    if (pop == 2 || (pop == 5 && a == 6)) {
        element.style.right = "5%"
        element.style.bottom = "0px"
    }
}

function obj_4_2(a, pop){
    let element = document.querySelector(`#img${a}_${pop}`)
    element.style.position = 'absolute'
    if (((a == 4 || a == 8 || a == 9) && pop == 0) || (a == 7 && pop == 3) || (a == 8 && pop == 4) || (a == 9 && pop == 5)) {
        element.style.bottom = `0%`
        element.style.left = `5%`
    }
    if (((a == 4 || a == 8 || a == 9) && pop == 1) || (a == 7 && pop == 4) || (a == 7 && pop == 0) || (a == 8 && pop == 5) || (a == 9 && pop == 6)) {
        element.style.top = `0px`
        element.style.left = "5%"
    }
    if (((a == 4 || a == 8 || a == 9) && pop == 2) || (a == 7 && pop == 5) || (a == 7 && pop == 1) || (a == 8 && pop == 6) || (a == 9 && pop == 7)) {
        element.style.right = "5%"
        element.style.bottom = "0px"
    }
    if (((a == 4 || a == 8 || a == 9) && pop == 3) || (a == 7 && pop == 6) || (a == 7 && pop == 2) || (a == 8 && pop == 7) || (a == 9 && pop == 8)){
        element.style.top = `0px`
        element.style.right = "5%"
    }
}

function obj_5_2(a, pop){
    let element = document.querySelector(`#img${a}_${pop}`)
    element.style.position = 'absolute'
    if (((a == 5 || a == 9 || a== 10) && pop == 0 ) || (a== 10 && pop==5)) {
        element.style.top = "0px"
    }
    if (((a == 5 || a == 9 || a== 10) && pop == 1) || (a== 10 && pop==6)) {
        element.style.top = `25%`
        element.style.left = "5%"
    }
    if (((a == 5 || a == 9 || a== 10) && pop == 2) || (a== 10 && pop==7)) {
        element.style.right = "20%"
        element.style.bottom = "0px"
    }
    if (((a == 5 || a == 9 || a== 10) && pop == 3) || (a== 10 && pop==8)){
        element.style.top = `25%`
        element.style.right = "5%"
    }
    if(((a == 5 || a == 9 || a== 10) && pop == 4) || (a== 10 && pop==9)){
        element.style.left = "20%"
        element.style.bottom = "0px"
    }
}