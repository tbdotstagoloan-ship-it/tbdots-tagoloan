const canvas = document.getElementById('snow');
const ctx = canvas.getContext('2d');

canvas.style.position = 'fixed';
canvas.style.top = 0;
canvas.style.left = 0;
canvas.style.pointerEvents = 'none';
canvas.style.zIndex = 9999;

function resizeCanvas() {
    canvas.width = window.innerWidth;
    canvas.height = window.innerHeight;
}

resizeCanvas();
window.addEventListener('resize', resizeCanvas);

let snowflakes = [];
for (let i = 0; i < 60; i++) {
    snowflakes.push({
        x: Math.random() * canvas.width,
        y: Math.random() * canvas.height,
        r: Math.random() * 4 + 1,
        d: Math.random()
    });
}

function drawSnow() {
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    ctx.fillStyle = "red";
    ctx.font = "20px Arial";
    ctx.textAlign = "center";
    
    snowflakes.forEach(flake => {
        ctx.fillText("*", flake.x, flake.y);
    });
    
    moveSnow();
}

function moveSnow() {
    snowflakes.forEach(flake => {
        flake.y += Math.pow(flake.d, 2) + 1;
        if (flake.y > canvas.height) {
            flake.y = 0;
            flake.x = Math.random() * canvas.width;
        }
    });
}

setInterval(drawSnow, 30);