<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parkinson Interactive Game</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://source.unsplash.com/jIeGcdO2Mco/1600x900');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            color: #fff;
            font-family: Arial, sans-serif;
        }
        #game-container {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 20px;
            margin: auto;
            max-width: 600px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        #game-area {
            position: relative;
            width: 100%;
            height: 400px;
            margin-top: 20px;
            border: 3px dashed #007bff;
            border-radius: 10px;
            overflow: hidden;
        }
        #target {
            width: 50px;
            height: 50px;
            background-color: #28a745;
            border-radius: 50%;
            position: absolute;
            cursor: pointer;
        }
        #score, #timer {
            font-size: 1.2rem;
            font-weight: bold;
            padding: 10px;
            margin: 5px;
            border-radius: 10px;
            display: inline-block;
            background-color: #007bff;
            color: #fff;
        }
        #start-btn {
            margin-top: 15px;
            font-size: 1.2rem;
            font-weight: bold;
        }
    </style>
</head>
<body>
<div class="container">
    <div id="game-container" class="container">
        <h1 class="mb-4 text-primary text-center">Parkinson Focus Game</h1>
        <p class="text-center text-dark">Click the green circle as many times as you can before the timer runs out!</p>
        <button id="start-btn" class="btn btn-success btn-lg d-block mx-auto">Start Game</button>
        <div class="d-flex justify-content-around mt-3">
            <div id="score" class="text-white bg-primary px-4 py-2 rounded">Score: 0</div>
            <div id="timer" class="text-white bg-primary px-4 py-2 rounded">Time: 30s</div>
        </div>
        <div id="game-area" class="mt-4">
            <div id="target"></div>
        </div>
    </div>

    <!-- Modal for Final Result -->
    <div class="modal fade" id="resultModal" tabindex="-1" aria-labelledby="resultModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="resultModalLabel">Game Analysis</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <h4 class="text-dark text-center">Your Score</h4>
                            <p id="final-score" class="fs-4 text-center fw-bold text-success"></p>
                        </div>
                        <div class="col-md-8">
                            <h4 class="text-dark text-center">Performance Feedback</h4>
                            <p id="performance-feedback" class="text-muted"></p>
                        </div>
                    </div>
                    <div class="row mt-4">
                        <div class="col-md-4">
                            <h5 class="text-dark text-center">Total Games Played</h5>
                            <p class="text-dark text-center fs-5" id="total-games"></p>
                        </div>
                        <div class="col-md-4">
                            <h5 class="text-dark text-center">Highest Score</h5>
                            <p id="highest-score" class="fs-5 text-warning text-center"></p>
                        </div>
                        <div class="col-md-4">
                            <h5 class="text-dark text-center">Average Score</h5>
                            <p id="average-score" class="fs-5 text-info text-center"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const target = document.getElementById('target');
    const startBtn = document.getElementById('start-btn');
    const scoreDisplay = document.getElementById('score');
    const timerDisplay = document.getElementById('timer');
    const gameArea = document.getElementById('game-area');
    const resultModal = new bootstrap.Modal(document.getElementById('resultModal'));

    const urlParams = new URLSearchParams(window.location.search);
    const patientId = urlParams.get('patient_id');

    let score = 0;
    let gameInterval;
    let countdown;
    let timeLeft = 30;

    function startGame() {
        score = 0;
        timeLeft = 30;
        updateScore();
        updateTimer();
        target.style.display = "block";
        startBtn.disabled = true;

        moveTarget();
        gameInterval = setInterval(moveTarget, 1000);
        countdown = setInterval(() => {
            timeLeft--;
            updateTimer();
            if (timeLeft <= 0) {
                endGame();
            }
        }, 1000);
    }

    function endGame() {
        clearInterval(gameInterval);
        clearInterval(countdown);
        target.style.display = "none";
        saveScore();
        showAnalysis();
        startBtn.disabled = false;
    }

    function moveTarget() {
        const maxX = gameArea.clientWidth - target.offsetWidth;
        const maxY = gameArea.clientHeight - target.offsetHeight;

        const randomX = Math.floor(Math.random() * maxX);
        const randomY = Math.floor(Math.random() * maxY);

        target.style.left = `${randomX}px`;
        target.style.top = `${randomY}px`;
    }

    function updateScore() {
        scoreDisplay.textContent = `Score: ${score}`;
    }

    function updateTimer() {
        timerDisplay.textContent = `Time: ${timeLeft}s`;
    }

    function saveScore() {
        if (!patientId) {
            alert('Patient ID is missing in the URL!');
            return;
        }

        const scores = JSON.parse(localStorage.getItem(`scores_${patientId}`)) || [];
        scores.push(score);
        localStorage.setItem(`scores_${patientId}`, JSON.stringify(scores));

        const totalGames = scores.length;
        const highestScore = Math.max(...scores, 0);
        const averageScore = scores.reduce((a, b) => a + b, 0) / totalGames;

        const feedback = document.getElementById('performance-feedback').textContent;

        // Save results via AJAX
        fetch('{{ route("patient.focus_game.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({
                patient_id: patientId,
                score: score,
                total_games: totalGames,
                highest_score: highestScore,
                average_score: averageScore,
                feedback: feedback,
            }),
        }).then(response => response.json()).then(data => {
                if (data.success) {
                    console.log('Results saved successfully!');
                } else {
                    console.error('Failed to save results:', data.message);
                }
            })
            .catch(error => {
                console.log(error, 'frrrrrrrrrrrrrrrrrrrr')
                console.error('Error saving results:', error);
            });
    }

    function showAnalysis() {
        const scores = JSON.parse(localStorage.getItem(`scores_${patientId}`)) || [];
        const totalGames = scores.length;
        const highestScore = Math.max(...scores, 0);
        const averageScore = scores.reduce((a, b) => a + b, 0) / totalGames;

        document.getElementById('final-score').textContent = score;
        document.getElementById('total-games').textContent = totalGames;
        document.getElementById('highest-score').textContent = highestScore;
        document.getElementById('average-score').textContent = averageScore.toFixed(2);

        // Performance Feedback
        let feedback = "";

        if (averageScore >= 20) {
            feedback = "Excellent performance! Your motor skills and reaction time appear to be well above average.";
        } else if (averageScore >= 10 && averageScore < 20) {
            feedback = "Good performance! Your reaction time is within the expected range.";
        } else {
            feedback = "Your score is below the typical range, which may suggest slower reaction times.";
        }

        if (score === highestScore && score > 10) {
            feedback += " Additionally, this is your highest score! Keep up the excellent work!";
        } else if (score > averageScore) {
            feedback += " You’re performing above your personal average!";
        } else if (score < averageScore) {
            feedback += " Your score is below your personal average. Practice to improve!";
        }

        document.getElementById('performance-feedback').textContent = feedback;

        resultModal.show();
    }

    target.addEventListener('click', () => {
        score++;
        updateScore();
    });

    startBtn.addEventListener('click', startGame);
</script>
</body>
</html>
