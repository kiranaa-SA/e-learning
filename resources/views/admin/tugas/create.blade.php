@extends('layouts.backend')
@section('content')
    <section class="tab-components">
        <div class="container-fluid">
            <!-- ========== title-wrapper start ========== -->
            <div class="title-wrapper pt-30">
                <div class="row align-items-center">
                    <div class="col-md-6">
                        <div class="title">
                            <h2>Tambah Data Tugas</h2>
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
                                    <li class="breadcrumb-item"><a href="#0">Tambah</a></li>
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
                            @if (isset($_GET['next']))
                                @php
                                    $judul = $_GET['judul'];
                                    $mapel = $_GET['id_mapel'];
                                    $jumlah_soal = $_GET['jumlah_soal'];
                                @endphp
                                @for ($i = 1; $i <= $jumlah_soal; $i++)
                                    <div class="card-style mb-30">
                                        <div class="input-style-1">
                                            <label>Soal {{ $i }}</label>
                                            <input type="text" placeholder="Masukkan Soal" name="soal" />
                                        </div>
                                        <input type="checkbox" name="" id="">A
                                        <br>
                                        <input type="checkbox" name="" id="">B
                                        <br>
                                        <input type="checkbox" name="" id="">C
                                        <br>
                                        <input type="checkbox" name="" id="">D
                                        <div class="input-style-1">
                                            <label>Jawaban</label>
                                            <select name="jawaban" id="">
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                            </select>
                                        </div>
                                    </div>
                                @endfor
                            @else
                                <div class="card-style mb-30">
                                    <h6 class="mb-25">Masukan Data</h6>
                                    <form action="" method="get">
                                      @csrf
                                    <div class="input-style-1">
                                        <label>Judul</label>
                                        <input type="text" name="judul" placeholder="Masukan Judul" />
                                    </div>
                                    <!-- end input -->
                                    <div class="input-style-2">
                                        <div class="select-style-1">
                                            <label>Mapel</label>
                                            <div class="select-position">
                                                <select name="id_mapel">
                                                    @foreach ($mapel as $data)
                                                        <option value="{{ $data->id }}">{{ $data->nama_mapel }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end input -->
                                    <div class="input-style-3">
                                        <label>Jumlah Soal</label>
                                        <input type="number" name="jumlah_soal"
                                        placeholder="Masukan jumlah Soal" />
                                    </div>

                                    <button type="submit" class="btn btn-primary" name="next">Submit</button>
                                    <a href="{{ route('tugas.index') }}" class="btn btn-primary">Kembali</a>
                                    <!-- end input -->
                                </div>
                              </form>
                                @endif
                                <!-- end card -->
                                <!-- ======= input style end ======= -->
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
