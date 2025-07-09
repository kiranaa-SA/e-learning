@extends('layouts.backend')
@section('content')

<section class="tab-components">
    <div class="container-fluid">
      <!-- ========== title-wrapper start ========== -->
      <div class="title-wrapper pt-30">
        <div class="row align-items-center">
          <div class="col-md-6">
            <div class="title">
              <h2>Edit Data Tugas</h2>
            </div>
          </div>
          <!-- end col -->
          <div class="col-md-6">
            <div class="breadcrumb-wrapper">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                    <a href="#">Dashboard</a>
                  </li>
                  <li class="breadcrumb-item"><a href="#0">Edit</a></li>
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
            <form action="{{ Route('tugas.update', $tugas->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
          <div class="col-lg-12">
            <!-- input style start -->
            <div class="card-style mb-30">
              <h6 class="mb-25">Masukan Data</h6>
              <div class="input-style-1">
                <label>Judul</label>
                <input type="text" name="judul" value="{{ $tugas->judul }}" required class="@error('judul') is-invalid @enderror" />
              </div>
              <!-- end input -->
              <div class="input-style-2">
                <div class="select-style-1">
                    <label>Mapel</label>
                    <div class="select-position">
                      <select>
                        <option value="">Select category</option>
                        <option value="">Category one</option>
                        <option value="">Category two</option>
                        <option value="">Category three</option>
                      </select>
                    </div>
                  </div>
              </div>
              <!-- end input -->
              <div class="input-style-3">
                <label>Jumlah Soal</label>
                <input type="number" name="jumlah_soal" value="{{ $tugas->jumlah_soal }}" required class="@error('jumlah_soal') is-invalid @enderror" />
              </div>

              <button type="submit" class="btn btn-primary">Submit</button>
              <a href="{{route('tugas.index')}}" class="btn btn-primary">Kembali</a>
              <!-- end input -->
            </div>
            <!-- end card -->
            <!-- ======= input style end ======= -->
          </div>
          <!-- end col -->
        </form>
        </div>
        <!-- end row -->
      </div>
      <!-- ========== form-elements-wrapper end ========== -->
    </div>
    <!-- end container -->
  </section>

@endsection