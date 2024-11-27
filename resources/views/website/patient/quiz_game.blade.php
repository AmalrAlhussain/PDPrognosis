<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parkinson Typing Diagnosis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        #typing-container {
            background: #ffffff;
            border-radius: 10px;
            padding: 20px;
            margin: 20px auto;
            max-width: 800px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        textarea {
            width: 100%;
            height: 200px;
            font-size: 16px;
            padding: 10px;
            border: 2px solid #007bff;
            border-radius: 5px;
        }
        #results {
            margin-top: 20px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div id="typing-container" class="p-4 bg-white shadow rounded">
                <h2 class="text-primary">Typing and Mouse Sensitivity Test</h2>
                <p>Type the text below as accurately and quickly as possible:</p>
                <blockquote class="blockquote">
                    <p class="mb-0">"A journey of a thousand miles begins with a single step."</p>
                </blockquote>
                <textarea id="typing-area" placeholder="Start typing here..." class="form-control mb-3"></textarea>
                <button id="reset-btn" class="btn btn-secondary">Reset</button>
            </div>
        </div>
        <div class="col-md-6">
            <div id="results" class="mt-4">
                <h3 class="text-secondary">Results</h3>
                <canvas id="metrics-chart" width="400" height="200"></canvas>
                <div id="feedback" class="mt-3 text-dark"></div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <form id="typing-test-form" method="POST" action="{{ route('patient.typingTest.store') }}">
                @csrf
                <input type="hidden" name="visit_id" value="{{ $visit->id ?? '' }}">
                <input type="hidden" name="key_durations" id="key-durations-input">
                <input type="hidden" name="mouse_stability" id="mouse-stability-input">
                <input type="hidden" name="typing_accuracy" id="typing-accuracy-input">
                <input type="hidden" name="feedback" id="feedback-input">
                <button type="submit" class="btn btn-primary">Submit Results</button>
            </form>
        </div>
    </div>
</div>

<script>
    const typingArea = document.getElementById('typing-area');
    const resetBtn = document.getElementById('reset-btn');
    const feedback = document.getElementById('feedback');
    const ctx = document.getElementById('metrics-chart').getContext('2d');

    let keyTimings = [];
    let mouseMovements = [];
    let chartInstance = null;

    typingArea.addEventListener('keydown', (e) => {
        keyTimings.push({ key: e.key, event: 'down', time: performance.now() });
        updateResults();
    });

    typingArea.addEventListener('keyup', (e) => {
        keyTimings.push({ key: e.key, event: 'up', time: performance.now() });
        updateResults();
    });

    document.addEventListener('mousemove', (e) => {
        mouseMovements.push({ x: e.clientX, y: e.clientY, time: performance.now() });
        updateResults();
    });

    resetBtn.addEventListener('click', resetAll);

    document.getElementById('typing-test-form').addEventListener('submit', (e) => {
        document.getElementById('key-durations-input').value = JSON.stringify(calculateKeyDurations());
        document.getElementById('mouse-stability-input').value = calculateMouseStability();
        document.getElementById('typing-accuracy-input').value = calculateTypingAccuracy(typingArea.value.trim());
        document.getElementById('feedback-input').value = feedback.innerHTML;
    });

    function updateResults() {
        const keyDurations = calculateKeyDurations();
        const mouseStability = calculateMouseStability();
        const typingAccuracy = calculateTypingAccuracy(typingArea.value.trim());

        renderChart(keyDurations, mouseStability, typingAccuracy);
        analyzePerformance(keyDurations, mouseStability, typingAccuracy);
    }

    function calculateKeyDurations() {
        const durations = [];
        for (let i = 1; i < keyTimings.length; i++) {
            const prev = keyTimings[i - 1];
            const curr = keyTimings[i];
            if (curr.event === 'down' && prev.event === 'up' && prev.key === curr.key) {
                durations.push(curr.time - prev.time);
            }
        }
        return durations;
    }

    function calculateMouseStability() {
        let totalDistance = 0;
        for (let i = 1; i < mouseMovements.length; i++) {
            const dx = mouseMovements[i].x - mouseMovements[i - 1].x;
            const dy = mouseMovements[i].y - mouseMovements[i - 1].y;
            totalDistance += Math.sqrt(dx * dx + dy * dy);
        }
        return totalDistance / mouseMovements.length || 0;
    }

    function calculateTypingAccuracy(input) {
        const targetText = "A journey of a thousand miles begins with a single step.";
        const inputWords = input.split(' ');
        const targetWords = targetText.split(' ');
        let correctWords = 0;
        inputWords.forEach((word, i) => {
            if (word === targetWords[i]) correctWords++;
        });
        return (correctWords / targetWords.length) * 100;
    }

    function renderChart(keyDurations, mouseStability, typingAccuracy) {
        if (chartInstance) chartInstance.destroy();
        chartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Key Durations', 'Mouse Stability', 'Typing Accuracy'],
                datasets: [
                    {
                        label: 'Performance Metrics',
                        data: [average(keyDurations), mouseStability, typingAccuracy],
                        backgroundColor: ['rgba(0, 123, 255, 0.7)', 'rgba(40, 167, 69, 0.7)', 'rgba(255, 193, 7, 0.7)'],
                    },
                ],
            },
        });
    }

    function analyzePerformance(keyDurations, mouseStability, typingAccuracy) {
        const avgKeyDuration = average(keyDurations);
        const feedbackText = [];
        if (avgKeyDuration < 100) feedbackText.push('Key press durations are excellent.');
        if (mouseStability < 50) feedbackText.push('Mouse movements are stable.');
        if (typingAccuracy > 90) feedbackText.push('Typing accuracy is excellent.');
        feedback.innerHTML = feedbackText.join('<br>');
    }

    function resetAll() {
        keyTimings = [];
        mouseMovements = [];
        typingArea.value = '';
        feedback.innerHTML = '';
    }

    function average(array) {
        return array.reduce((a, b) => a + b, 0) / array.length || 0;
    }
</script>
</body>
</html>
