@extends('layout')
@section('title')
    Dịch Vụ
@endsection

@section('body')
<div class="banner-service">
    <div class="banner-service-text">
        <h1 class="main-title">Dịch vụ</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Trang Chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dịch Vụ</li>
            </ol>
        </nav>
    </div>
</div>

<div class="pet-dichvu">
    <div class="container">
        <div class="row">
            @foreach($services as $service)
            <div class="col-md-3">
                <div class="service-card text-center p-3">
                    <div class="image-wrapper">
                        <img src="{{ $service->img ? asset('images/services/' . $service->img) : asset('images/default-service.png') }}" 
                             class="rounded-circle mb-3" alt="{{ $service->name }}">
                    </div>
                    <h4 class="content-service">{{ $service->name }}</h4>
                    <p class="content-description">{{ \Illuminate\Support\Str::limit($service->description, 80) }}</p>
                    <div class="hover-text">
                        <a href="{{ route('services.show', $service->slug) }}" class="read-more">Đọc thêm</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $services->links() }}
        </div>
    </div>
</div>
@endsection
