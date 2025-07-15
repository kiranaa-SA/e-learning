@extends('layouts.backend')
@section('content')

<section class="table-components">
    <div class="container-fluid">
        <!-- Judul dan breadcrumb -->
        <div class="title-wrapper pt-30">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="title">
                        <h2>Profil</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="breadcrumb-wrapper text-right">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Profil</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card Profil -->
        <div class="tables-wrapper">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="card-style mb-30 text-center p-4 shadow-sm">
                        <!-- Foto Profil -->
                        <div class="mb-4">
                            <img src="{{ asset('backend/assets/images/profile/profile-image.png') }}"
                                 alt="Foto Profil"
                                 style="width: 150px; height: 150px; object-fit: cover;"
                                 class="rounded-circle shadow" />
                        </div>

                        <!-- Info Profil -->
                        <h4 class="mb-1">{{ $user->name }}</h4>
                        <p class="text-muted mb-2">{{ $user->email }}</p>

                        <div class="row justify-content-center mt-4">
                            <div class="col-md-6 text-start">
                                <p><strong>Kelas:</strong> {{ $user->kelas->nama ?? '-' }}</p>
                                <p><strong>Status:</strong> {{ ucfirst($user->role) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection