<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Quiz | Scholar</title>

  <link href="{{ asset('frontend/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('frontend/assets/css/fontawesome.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/assets/css/templatemo-scholar.css') }}">
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

  @php $durationInSeconds = $quiz->durasi * 60; @endphp

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f5f5f5;
    }
    .container {
      background-color: #fff;
      border-radius: 15px;
      padding: 30px;
      box-shadow: 0 8px 20px rgba(0,0,0,0.1);
      margin-top: 40px;
    }
    .quiz-header {
      background: linear-gradient(135deg, #7e5bef, #a779e9);
      color: #fff;
      padding: 25px 30px;
      border-radius: 16px;
      margin-bottom: 30px;
      display: flex;
      flex-direction: column;
      gap: 10px;
      position: relative;
    }
    .quiz-header h2 {
      font-weight: 700;
      color: #fff;
      margin: 0;
      font-size: 24px;
    }
    .quiz-header h4 {
      margin: 0;
      color: #fff;
      font-size: 20px;
      font-weight: 600;
    }
    .quiz-header p {
      font-size: 14px;
      margin: 0;
      opacity: 0.95;
    }
    #countdown {
      position: absolute;
      top: 20px;
      right: 30px;
      font-size: 15px;
      background-color: #f3e8ff;
      color: #6f42c1;
      padding: 6px 14px;
      border-radius: 8px;
      font-weight: 600;
      box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.2);
    }
    .info-note {
      font-size: 14px;
      color: red;
      margin-top: 5px;
    }
    .card.question-card {
      border: none;
      border-left: 4px solid #7e5bef;
      margin-bottom: 25px;
      transition: all 0.3s ease;
    }
    .card.question-card:hover {
      box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    }
    .form-check {
      background-color: #f9f5ff;
      border: 1px solid #e0d4ff;
      border-radius: 6px;
      padding: 10px 15px;
      margin-bottom: 10px;
      cursor: pointer;
    }
    .form-check-input:checked {
      background-color: #7e5bef;
      border-color: #7e5bef;
    }
    .submit-btn {
      background: linear-gradient(135deg, #7e5bef, #a779e9);
      border: none;
      color: white;
      padding: 12px 40px;
      font-weight: 600;
      border-radius: 30px;
      transition: 0.3s;
    }
    .submit-btn:hover {
      transform: scale(1.03);
      box-shadow: 0 6px 15px rgba(0,0,0,0.15);
    }
    .quiz-note {
      font-size: 13px;
      color: #ffe6e6;
      margin-top: 10px;
      font-style: italic;
      opacity: 0.9;
      padding-top: 8px;
      border-top: 1px solid rgba(255, 255, 255, 0.2);
    }

  </style>
</head>
<body>

  <div class="container">
    <div class="quiz-header">
      <h2>Mengerjakan Quiz</h2>
      <h4>{{ $quiz->judul }}</h4>

      @if($quiz->deskripsi)
        <p>{{ $quiz->deskripsi }}</p>
      @endif

      <div id="countdown">Waktu Tersisa: <span id="time">--:--</span></div>

      <div class="quiz-note">
        * Quiz akan otomatis diselesaikan jika waktu habis.
      </div>
    </div>


    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('quizSubmit', $quiz->id) }}" id="quizForm">
      @csrf
      @foreach ($quiz->soal as $soal)
        <div class="card question-card">
          <div class="card-body">
            <h5 class="card-title text-primary">Soal {{ $loop->iteration }}</h5>
            <p class="card-text">{{ $soal->pertanyaan }}</p>

            @foreach (['A', 'B', 'C', 'D'] as $opt)
              @php
                $inputId = 'soal_' . $soal->id . '_' . $opt;
                $pilihan = $soal->{'pilihan_' . strtolower($opt)};
              @endphp

              @if($pilihan)
                <div class="form-check">
                  <input 
                    class="form-check-input" 
                    type="radio" 
                    name="jawaban[{{ $soal->id }}]" 
                    value="{{ $opt }}" 
                    id="{{ $inputId }}"
                    required
                  >
                  <label class="form-check-label" for="{{ $inputId }}">
                    <strong>{{ $opt }}.</strong> {{ $pilihan }}
                  </label>
                </div>
              @endif
            @endforeach

            @error("jawaban.{$soal->id}")
              <div class="text-danger mt-1">{{ $message }}</div>
            @enderror
          </div>
        </div>
      @endforeach

      <div class="text-center mt-4">
        <button type="submit" class="submit-btn">
          <i class="fas fa-paper-plane me-2"></i> Selesaikan Quiz
        </button>
      </div>
    </form>
  </div>

  <!-- JS & Countdown -->
  <script>
    const quizDuration = {{ $durationInSeconds }};
    let timeLeft = quizDuration;
    const countdownEl = document.getElementById('time');
    const quizForm = document.getElementById('quizForm');

    function formatTime(seconds) {
      const m = Math.floor(seconds / 60);
      const s = seconds % 60;
      return `${m.toString().padStart(2, '0')}:${s.toString().padStart(2, '0')}`;
    }

    function updateCountdown() {
      if (timeLeft <= 0) {
        countdownEl.textContent = "00:00";
        localStorage.removeItem('quiz_' + {{ $quiz->id }});
        quizForm.submit(); // otomatis submit saat habis
      } else {
        countdownEl.textContent = formatTime(timeLeft);
        timeLeft--;
      }
    }

    updateCountdown();
    setInterval(updateCountdown, 1000);

    // Simpan jawaban ke localStorage
    let answers = {};
    document.querySelectorAll('input[type="radio"]').forEach(radio => {
      radio.addEventListener('change', function() {
        answers[this.name] = this.value;
        localStorage.setItem('quiz_' + {{ $quiz->id }}, JSON.stringify(answers));
      });
    });

    // Load dari localStorage
    window.addEventListener('load', () => {
      const saved = localStorage.getItem('quiz_' + {{ $quiz->id }});
      if (saved) {
        const answers = JSON.parse(saved);
        for (let name in answers) {
          const radio = document.querySelector(`input[name="${name}"][value="${answers[name]}"]`);
          if (radio) radio.checked = true;
        }
      }
    });

    // Bersihkan localStorage saat submit
    quizForm.addEventListener('submit', () => {
      localStorage.removeItem('quiz_' + {{ $quiz->id }});
    });
  </script>

  <!-- Buat seluruh area form-check bisa diklik -->
  <script>
    document.querySelectorAll('.form-check').forEach(item => {
      item.addEventListener('click', function(e) {
        const radio = this.querySelector('input[type="radio"]');
        if (radio && !radio.checked) {
          radio.checked = true;
          radio.dispatchEvent(new Event('change'));
        }
      });
    });
  </script>

  <script src="{{ asset('frontend/vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

</body>
</html>
