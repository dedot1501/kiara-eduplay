<x-app-layout>
    {{-- Navbar Mini --}}
    <nav class="bg-white border-b border-gray-100 shadow-sm px-4 py-2 flex justify-between items-center">
        <div class="flex items-center gap-2">
            <div class="bg-blue-500 p-1.5 rounded-lg shadow-sm">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
            </div>
            <span class="font-black text-gray-700 tracking-tight text-sm sm:text-base uppercase">Race Math</span>
        </div>
        <a href="{{ route('dashboard') }}" class="text-xs font-bold text-gray-400 hover:text-red-500 transition-colors">KELUAR</a>
    </nav>

    <div class="py-2 bg-[#F0F4F8] min-h-[calc(100vh-52px)] font-fredoka overflow-hidden">
        <div class="max-w-5xl mx-auto px-2">
            
            {{-- Header Skor --}}
            <div class="flex justify-between items-center mb-2 px-2">
                <div class="bg-white px-3 py-1 rounded-xl shadow-sm border-b-2 border-yellow-400">
                    <span class="text-yellow-600 font-black text-xs sm:text-sm uppercase">Soal <span id="question-number">1</span>/10</span>
                </div>
                <div class="flex gap-2">
                    <div class="bg-white px-3 py-1 rounded-xl shadow-sm border-b-2 border-blue-400">
                        <span class="text-blue-600 font-black text-xs sm:text-sm uppercase">Kamu: <span id="player-score">0</span></span>
                    </div>
                    <div class="bg-white px-3 py-1 rounded-xl shadow-sm border-b-2 border-red-400">
                        <span class="text-red-600 font-black text-xs sm:text-sm uppercase">Lawan: <span id="bot-score-ui">0</span></span>
                    </div>
                </div>
            </div>

            <div id="game-arena" class="flex flex-col lg:flex-row gap-2">
                {{-- Canvas Balapan --}}
                <div class="w-full lg:w-2/3 relative">
                    <div class="relative bg-gray-900 rounded-[30px] overflow-hidden border-4 border-white shadow-xl h-[280px] sm:h-[450px] lg:h-[600px]">
                        <canvas id="raceCanvas" width="600" height="700" class="w-full h-full object-fill"></canvas>
                    </div>
                </div>

                {{-- Area Soal --}}
                <div class="w-full lg:w-1/3 flex flex-col gap-2">
                    <div class="bg-white p-3 sm:p-5 rounded-[30px] shadow-lg border-b-4 border-blue-400">
                        <div id="quiz-content" class="text-center">
                            <div class="bg-blue-50 rounded-2xl py-3 mb-3 border-2 border-dashed border-blue-200">
                                <h2 class="text-3xl sm:text-5xl font-black text-gray-800" id="math-question">2 x 2 = ?</h2>
                            </div>
                            <div class="flex justify-center gap-2 sm:gap-4" id="answer-options">
                                {{-- Tombol Lingkaran --}}
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-2 rounded-2xl shadow-sm">
                        <div class="w-full bg-gray-100 h-2 rounded-full overflow-hidden shadow-inner">
                            <div id="progress-bar" class="bg-blue-500 h-full transition-all duration-500 w-0"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const canvas = document.getElementById('raceCanvas');
        const ctx = canvas.getContext('2d');

        const imgTrack = new Image(); imgTrack.src = "{{ asset('assets/game/track.png') }}";
        const imgPlayer = new Image(); imgPlayer.src = "{{ asset('assets/game/1.png') }}";
        const imgBot1 = new Image(); imgBot1.src = "{{ asset('assets/game/2.png') }}";
        const imgBot2 = new Image(); imgBot2.src = "{{ asset('assets/game/3.png') }}";
        const imgBot3 = new Image(); imgBot3.src = "{{ asset('assets/game/4.png') }}";

        let difficulty = "{{ $difficulty ?? 'easy' }}";
        let questionsFromDB = @json($questions ?? []);
        let currentSoalIndex = 0;
        let currentSoalNumber = 1;
        let playerScore = 0;
        let botScore = 0;
        let gameActive = true;
        let trackY = 0;

        // Posisi Mobil
        const laneX = [145, 255, 365, 475]; 
        let playerY = 550;
        let botY = [550, 550, 550]; 
        let targetPlayerY = 550;
        let targetBotY = [550, 550, 550];

        // LOGIKA BOT (Randomized)
        let botWinSteps = [];
        function setupBotDifficulty() {
            let winCount = difficulty === 'easy' ? 5 : (difficulty === 'normal' ? 6 : 8);
            let pool = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
            // Acak urutan soal mana saja yang bot akan jawab benar
            botWinSteps = pool.sort(() => 0.5 - Math.random()).slice(0, winCount);
        }

        window.onload = () => { 
            if("{{ isset($difficulty) }}") { 
                setupBotDifficulty();
                generateQuestion(); 
                animate(); 
            } 
        };

        function generateQuestion() {
            if (currentSoalNumber > 10) { endGame(); return; }

            document.getElementById('question-number').innerText = currentSoalNumber;
            document.getElementById('progress-bar').style.width = (currentSoalNumber * 10) + "%";
            
            let a, b, correct;
            if (questionsFromDB.length > currentSoalIndex) {
                let qData = questionsFromDB[currentSoalIndex];
                let qText = qData.question.toLowerCase().replace('×', 'x');
                let parts = qText.split('x');
                a = parseInt(parts[0]); b = parseInt(parts[1]);
                correct = a * b;
            } else {
                a = Math.floor(Math.random() * 10) + 1; b = Math.floor(Math.random() * 10) + 1;
                correct = a * b;
            }
            
            document.getElementById('math-question').innerText = `${a} x ${b} = ?`;
            
            let options = [correct];
            while(options.length < 3) {
                let wrong = correct + (Math.floor(Math.random() * 10) - 5);
                if (wrong < 0 || options.includes(wrong) || wrong === correct) wrong = Math.floor(Math.random() * 50);
                if(!options.includes(wrong)) options.push(wrong);
            }
            options.sort(() => Math.random() - 0.5);

            const btnContainer = document.getElementById('answer-options');
            btnContainer.innerHTML = '';
            
            options.forEach(opt => {
                const btn = document.createElement('button');
                btn.className = "w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-yellow-400 border-b-4 border-yellow-600 text-white font-black text-xl sm:text-2xl shadow-md transition-all active:translate-y-1 active:border-b-0 flex items-center justify-center";
                btn.innerText = opt;
                btn.onclick = (e) => handleChoice(e.currentTarget, opt, correct);
                btnContainer.appendChild(btn);
            });
        }

        function handleChoice(element, chosen, correct) {
            if (!gameActive) return;
            const buttons = document.querySelectorAll('#answer-options button');
            buttons.forEach(b => b.disabled = true);

            // Cek Jawaban Player
            if (chosen === correct) {
                element.style.backgroundColor = "#22c55e"; 
                element.style.borderColor = "#16a34a";
                playerScore++;
                targetPlayerY -= 55;
            } else {
                element.style.backgroundColor = "#ef4444"; 
                element.style.borderColor = "#b91c1c";
            }

            // Cek Jawaban Bot berdasarkan urutan acak yang sudah diset di awal
            if (botWinSteps.includes(currentSoalNumber)) {
                botScore++;
                // Ketiga bot maju bersamaan
                targetBotY[0] -= 55; targetBotY[1] -= 55; targetBotY[2] -= 55;
                document.getElementById('bot-score-ui').innerText = botScore;
            }

            setTimeout(() => {
                document.getElementById('player-score').innerText = playerScore;
                currentSoalNumber++;
                currentSoalIndex++;
                generateQuestion();
            }, 500);
        }

        function animate() {
            ctx.clearRect(0, 0, canvas.width, canvas.height);
            ctx.drawImage(imgTrack, 0, trackY, canvas.width, canvas.height);
            ctx.drawImage(imgTrack, 0, trackY - canvas.height, canvas.width, canvas.height);
            
            if (gameActive) {
                trackY += 5; 
                if (trackY >= canvas.height) trackY = 0;
            }

            playerY += (targetPlayerY - playerY) * 0.1;
            for(let i=0; i<3; i++) botY[i] += (targetBotY[i] - botY[i]) * 0.1;

            const carW = 85; const carH = 120;
            if(imgPlayer.complete) ctx.drawImage(imgPlayer, laneX[0] - carW/2, playerY, carW, carH);
            if(imgBot1.complete) ctx.drawImage(imgBot1, laneX[1] - carW/2, botY[0], carW, carH);
            if(imgBot2.complete) ctx.drawImage(imgBot2, laneX[2] - carW/2, botY[1], carW, carH);
            if(imgBot3.complete) ctx.drawImage(imgBot3, laneX[3] - carW/2, botY[2], carW, carH);

            if (gameActive || playerY > -200) requestAnimationFrame(animate);
        }

        function endGame() {
            gameActive = false;
            // Syarat Menang: Skor player harus lebih besar dari skor bot
            let isWin = playerScore > botScore;
            let status = isWin ? 'win' : 'lose';
            let title = isWin ? "FINISH! KAMU MENANG! 🏆" : "FINISH! KAMU KALAH! 🏁";
            let color = isWin ? "text-green-500" : "text-red-500";

            fetch("{{ route('game.save-score') }}", {
                method: "POST",
                headers: { "Content-Type": "application/json", "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                body: JSON.stringify({ points: playerScore * 10, difficulty: difficulty, status: status })
            });

            document.getElementById('quiz-content').innerHTML = `
                <div class="py-4 animate-bounce">
                    <h2 class="text-2xl sm:text-3xl font-black ${color}">${title}</h2>
                    <div class="flex justify-center gap-4 mt-2">
                        <p class="font-bold text-gray-600">Skor Kamu: ${playerScore}</p>
                        <p class="font-bold text-gray-600">Skor Bot: ${botScore}</p>
                    </div>
                    <button onclick="location.reload()" class="mt-4 w-full bg-blue-500 text-white py-3 rounded-xl font-black shadow-md uppercase">Coba Lagi</button>
                </div>
            `;
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fredoka:wght@700&display=swap');
        .font-fredoka { font-family: 'Fredoka', sans-serif; }
        body { touch-action: manipulation; overflow: hidden; }
    </style>
</x-app-layout>