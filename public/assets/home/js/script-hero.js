
const text = "SUCRE";
const speed = 100;
const el = document.getElementById("typewriter");
let index = 0;

function write() {
    if (el && index < text.length) {
        if (index === 0) el.textContent = ""; // Limpiar antes de empezar
        el.textContent += text.charAt(index);
        index++;
        setTimeout(write, speed);
    }
}

document.addEventListener("DOMContentLoaded", write);

