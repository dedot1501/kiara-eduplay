document.addEventListener('DOMContentLoaded', function() {
    const messages = [
        "Ayo kita pecahkan tantangan hari ini!",
        "Level kamu hampir naik loh! Semangat!",
        "Kiara siap menemanimu belajar ✨",
        "Jangan lupa istirahat ya kalau capek!"
    ];

    const bubbleText = document.getElementById('kiara-message');
    
    // Ganti pesan Kiara setiap 7 detik
    setInterval(() => {
        const randomMsg = messages[Math.floor(Math.random() * messages.length)];
        if(bubbleText) {
            bubbleText.style.opacity = 0;
            setTimeout(() => {
                bubbleText.innerText = randomMsg;
                bubbleText.style.opacity = 1;
            }, 5000);
        }
    }, 7000);
});