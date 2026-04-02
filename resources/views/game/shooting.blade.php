// Tambahkan di dalam script Phaser kamu, bagian create()
create() {
    scene = this;
    this.aliens = this.physics.add.group();
    this.bullets = this.physics.add.group(); // Grup untuk peluru
    
    this.generateNewQuestion();
    
    // Spawn Alien setiap 2.5 detik
    this.time.addEvent({ 
        delay: 2500, 
        callback: this.spawnAlien, 
        callbackScope: this, 
        loop: true 
    });

    // Input Keyboard untuk Enter
    this.input.keyboard.on('keydown-ENTER', () => {
        fireLaser(); 
    });
}

// Fungsi Visual Tembakan
function fireLaser() {
    let input = document.getElementById('manual-answer');
    let userVal = parseInt(input.value);

    if (userVal === currentAns) {
        // Cari alien yang punya jawaban benar
        let targetAlien = null;
        scene.aliens.getChildren().forEach(alien => {
            if (alien.getData('value') === currentAns) {
                targetAlien = alien;
            }
        });

        if (targetAlien) {
            // Buat Peluru Laser dari bawah ke arah Alien
            let laser = scene.add.rectangle(400, 450, 5, 20, 0x00ff00);
            scene.physics.add.existing(laser);
            
            // Gerakkan laser ke alien
            scene.physics.moveToObject(laser, targetAlien, 600);

            // Cek tabrakan laser & alien
            scene.physics.add.overlap(laser, targetAlien, () => {
                laser.destroy();
                explodeAlien(targetAlien); // Efek ledakan
                updateScore(10);
                input.value = '';
                scene.generateNewQuestion();
            });
        }
    } else {
        // Efek Getar Layar kalau salah
        scene.cameras.main.shake(200, 0.02);
        input.value = '';
    }
}

function explodeAlien(alien) {
    // Partikel ledakan sederhana
    for(let i=0; i<8; i++) {
        let p = scene.add.circle(alien.x, alien.y, 5, 0xffff00);
        scene.physics.add.existing(p);
        p.body.setVelocity(Math.random()*200-100, Math.random()*200-100);
        scene.tweens.add({ targets: p, alpha: 0, duration: 500, onComplete: () => p.destroy() });
    }
    alien.destroy();
}