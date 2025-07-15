<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <title>Scholar - Online School HTML5 Template</title>

  <!-- Bootstrap core CSS -->
  <link href="{{ asset('frontend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

  <!-- Additional CSS Files -->
  <link rel="stylesheet" href="{{ asset('frontend/assets/css/fontawesome.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/assets/css/templatemo-scholar.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/assets/css/owl.css') }}">
  <link rel="stylesheet" href="{{ asset('frontend/assets/css/animate.css') }}">
  <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css">
  
  @yield('styles')
</head>

<body>

  <div class="contact-us section" id="contact">
    <div class="container">
      <div class="row">
        <!-- Kiri: Detail Materi -->
        <div class="col-lg-6 align-self-center">
          <div class="section-heading">
            <h6>{{ $materi->kelas->kelas }}</h6>
            <h2>{{ $materi->mapel->nama_mapel }}</h2>
            <h5>{{ $materi->judul }}</h5>
            <p>{{ $materi->isi_materi }}</p>
          </div>
        </div>

        <!-- Kanan: Gambar -->
        <div class="col-lg-6">
          <div class="contact-us-content">
            <div class="row">
              <div class="col-lg-12">
                <img src="{{ asset('storage/materi/' . $materi->foto) }}" alt="Gambar Materi" class="main-image img-fluid" style="width: 100%;" />
              </div>
            </div>
          </div>
        </div>
        
      </div>
    </div>
  </div>

  @include('layouts.component-frontend.footer')

  <!-- Scripts -->
  <script src="{{ asset('frontend/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('frontend/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
  <script src="{{ asset('frontend/assets/js/isotope.min.js') }}"></script>
  <script src="{{ asset('frontend/assets/js/owl-carousel.js') }}"></script>
  <script src="{{ asset('frontend/assets/js/counter.js') }}"></script>
  <script src="{{ asset('frontend/assets/js/custom.js') }}"></script>
  @stack('scripts')

</body>
</html>