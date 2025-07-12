<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <title>Scholar - Online School HTML5 Template</title>
    
    <!-- Bootstrap core CSS -->
    <link href="{{ asset('frontend/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    
    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/fontawesome.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/templatemo-scholar.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/owl.css')}}">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.css')}}">
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
    
    <style>
        body {
            background-color: #f3e8ff;
        }
        .container {
            background-color: #f3e5f5 !important;
            padding: 20px;
            border-radius: 10px;
        }
        .form-check {
            margin-bottom: 12px;
            padding: 8px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .form-check:hover {
            background-color: rgba(111, 66, 193, 0.1);
        }
        .form-check-input:checked {
            background-color: #6f42c1;
            border-color: #6f42c1;
        }
        .quiz-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .question-card {
            border: none;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s;
        }
        .question-card:hover {
            transform: translateY(-2px);
        }
        .submit-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s;
        }
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <div class="quiz-header text-center">
            <h2 class="mb-2">Mengerjakan Quiz</h2>
            <h4><strong>{{ $quiz->judul }}</strong></h4>
            @if($quiz->deskripsi)
                <p class="mb-0">{{ $quiz->deskripsi }}</p>
            @endif
        </div>
        
        <!-- Alert untuk error/success -->
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <!-- Form Quiz -->
        <form method="POST" action="{{ route('user.quiz.submit', $quiz->id) }}" id="quizForm">
            @csrf
            
            @foreach ($quiz->soal as $soal)
            <div class="card mb-4 question-card">
                <div class="card-body">
                    <h5 class="card-title text-primary">Soal {{ $loop->iteration }}</h5>
                    <p class="card-text fs-6">{{ $soal->pertanyaan }}</p>

                    @foreach (['A', 'B', 'C', 'D'] as $opt)
                        @php
                            $inputId = 'soal_' . $soal->id . '_' . $opt;
                            $pilihan = $soal->{'pilihan_' . strtolower($opt)};
                        @endphp
                        
                        @if($pilihan) <!-- Hanya tampilkan jika pilihan ada -->
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
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            @endforeach
            
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success submit-btn px-5">
                    <i class="fas fa-check-circle me-2"></i>Selesaikan Quiz
                </button>
            </div>
        </form>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('frontend/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('frontend/assets/js/isotope.min.js')}}"></script>
    <script src="{{ asset('frontend/assets/js/owl-carousel.js')}}"></script>
    <script src="{{ asset('frontend/assets/js/counter.js')}}"></script>
    <script src="{{ asset('frontend/assets/js/custom.js')}}"></script>

    <script>
        // Konfirmasi sebelum submit
        document.getElementById('quizForm').addEventListener('submit', function(e) {
            if (!confirm('Apakah Anda yakin ingin mengirim jawaban? Jawaban tidak dapat diubah setelah dikirim.')) {
                e.preventDefault();
            }
        });

        // Auto-save progress (optional)
        let answers = {};
        document.querySelectorAll('input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', function() {
                answers[this.name] = this.value;
                localStorage.setItem('quiz_' + {{ $quiz->id }}, JSON.stringify(answers));
            });
        });

        // Load saved answers on page load
        window.addEventListener('load', function() {
            const saved = localStorage.getItem('quiz_' + {{ $quiz->id }});
            if (saved) {
                const answers = JSON.parse(saved);
                Object.keys(answers).forEach(name => {
                    const radio = document.querySelector(`input[name="${name}"][value="${answers[name]}"]`);
                    if (radio) {
                        radio.checked = true;
                    }
                });
            }
        });

        // Clear saved answers when form is submitted
        document.getElementById('quizForm').addEventListener('submit', function() {
            localStorage.removeItem('quiz_' + {{ $quiz->id }});
        });
    </script>
</body>
</html>