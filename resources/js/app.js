import "./bootstrap";

let currentSize = 100; // percentage

const applySize = () => {
    document.documentElement.style.fontSize = currentSize + "%";
};

document.getElementById("increaseFont").addEventListener("click", () => {
    currentSize = Math.min(150, currentSize + 10);
    applySize();
});

document.getElementById("decreaseFont").addEventListener("click", () => {
    currentSize = Math.max(70, currentSize - 10);
    applySize();
});

document.getElementById("resetFont").addEventListener("click", () => {
    currentSize = 100;
    applySize();
});
