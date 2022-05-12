const b1 = document.getElementById("b1");
const b2 = document.getElementById("b2");
const b3 = document.getElementById("b3");

const a1 = document.getElementById("a1");
const a2 = document.getElementById("a2");
const a3 = document.getElementById("a3");

const bg = document.getElementById("bg");

function show1() {
    a1.classList.remove("d-none");
    a2.classList.add("d-none");
    a3.classList.add("d-none");

    bg.classList.add("pessimisticBg");
    bg.classList.remove("realisticBg");
    bg.classList.remove("optimisticBg");
}

function show2() {
    a1.classList.add("d-none");
    a2.classList.remove("d-none");
    a3.classList.add("d-none");

    bg.classList.remove("pessimisticBg");
    bg.classList.add("realisticBg");
    bg.classList.remove("optimisticBg");
}

function show3() {
    a1.classList.add("d-none");
    a2.classList.add("d-none");
    a3.classList.remove("d-none");

    bg.classList.remove("pessimisticBg");
    bg.classList.remove("realisticBg");
    bg.classList.add("optimisticBg");
}
