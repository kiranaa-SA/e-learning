@extends('layouts.backend')
@section('content')


<section class="tab-components">
        <div class="container-fluid">
          <!-- ========== title-wrapper start ========== -->
          <div class="title-wrapper pt-30">
            <div class="row align-items-center">
              <div class="col-md-6">
                <div class="title">
                  <h2>Form Elements</h2>
                </div>
              </div>
              <!-- end col -->
              <div class="col-md-6">
                <div class="breadcrumb-wrapper">
                  <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item">
                        <a href="#0">Dashboard</a>
                      </li>
                      <li class="breadcrumb-item"><a href="#0">Forms</a></li>
                      <li class="breadcrumb-item active" aria-current="page">
                        Form Elements
                      </li>
                    </ol>
                  </nav>
                </div>
              </div>
              <!-- end col -->
            </div>
            <!-- end row -->
          </div>
          <!-- ========== title-wrapper end ========== -->

          <!-- ========== form-elements-wrapper start ========== -->
          <div class="form-elements-wrapper">
            <div class="row">
              <div class="col-lg-12">
                <!-- input style start -->
@if(isset($_GET['next']))
@php 
    $judul = $_GET['judul'];
    $mapel = $_GET['mapel'];
    $jumlah_soal = $_GET['jumlah_soal'];
    $waktu_pengerjaan = $_GET['waktu_pengerjaan'];
    $tenggat_waktu = $_GET['tenggat_waktu'];
@endphp

<form action="{{ route('quiz.store') }}" method="POST">
    @csrf
    <input type="hidden" name="judul" value="{{ $judul }}">
    <input type="hidden" name="mapel" value="{{ $mapel }}">
    <input type="hidden" name="jumlah_soal" value="{{ $jumlah_soal }}">
    <input type="hidden" name="waktu_pengerjaan" value="{{ $waktu_pengerjaan }}">
    <input type="hidden" name="tenggat_waktu" value="{{ $tenggat_waktu }}">

    @for($i = 0; $i < $jumlah_soal; $i++)
    <div class="card-style mb-30">
        <div class="input-style-1">
            <label>Soal {{ $i+1 }}</label>
            <input type="text" name="soal[{{ $i }}]" placeholder="Masukkan Soal" required>
        </div>

        <label>Pilihan Jawaban</label><br>
        @foreach(['A', 'B', 'C', 'D'] as $option)
            <div>
                <input type="radio" name="jawaban_benar[{{ $i }}]" value="{{ $option }}" required>
                {{ $option }} <input type="text" name="opsi[{{ $i }}][{{ $option }}]" placeholder="Jawaban {{ $option }}" required>
            </div>
        @endforeach
    </div>
    @endfor

                <div class="col-12">
                   <button type="submit" class="btn btn-primary" name="submit">Submit Soal</buttton>
                </div>
                </form>
                 @else
                <div class="card-style mb-30">
                  <h6 class="mb-25">Quiz</h6>
                  <form action="" method="get">
                  <div class="input-style-1">
                    <label>Judul</label>
                    <input type="text" placeholder="Judul" name="judul"/>
                  </div>
                  <!-- end input -->
                  <div class="input-style-1">
                    <div class="select-style-1">
                    <label>Mapel</label>
                    <div class="select-position">
                      <select name="mapel">
                        <option value="">MTK</option>
                        <option value="">B indo</option>
                        <option value="">B inggris</option>
                        <option value="">PAI</option>
                      </select>
                    </div>
                  </div>
                  </div>
                  <!-- end input -->
                  <div class="input-style-1">
                    <label>Jumlah soal</label>
                    <input type="number" placeholder="Jumlah soal" name="jumlah_soal" />
                  </div>
                  <!-- end input -->
                  <div class="input-style-1">
                    <label>Waktu pengerjaan</label>
                    <input type="number" placeholder="Waktu pengerjaan" name="waktu_pengerjaan" />
                  </div>
                  <!--  end input -->
                  <div class="input-style-1">
                    <label>Tenggeat waktu</label>
                    <input type="date" placeholder="Waktu pengerjaan" name="tenggat_waktu" />
                  </div>
                  <div class="col-12">
                     <button type="submit" class="btn btn-primary" name="next">Next</buttton>
                  </div>
                  </form>
                  <!-- end input -->
                </div>
                @endif
                <!-- end card -->
                <!-- ======= input style end ======= -->

                <!-- ======= select style start ======= -->

                <!-- end card -->
                <!-- ======= select style end ======= -->

                <!-- ======= select style start ======= -->

                <!-- end card -->
                <!-- ======= input style end ======= -->

                <!-- ======= input switch style start ======= -->

                <!-- ======= input switch style end ======= -->
              </div>
              <!-- end col -->
              <div class="col-lg-6">
                <!-- ======= textarea style start ======= -->

                <!-- ======= textarea style end ======= -->

                <!-- ======= checkbox style start ======= -->

                <!-- ======= checkbox style end ======= -->

                <!-- ======= radio style start ======= -->

                <!-- ======= radio style end ======= -->
              </div>
              <!-- end col -->
            </div>
            <!-- end row -->
          </div>
          <!-- ========== form-elements-wrapper end ========== -->
        </div>
        <!-- end container -->
      </section>

@endsection
