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
                <li class="breadcrumb-item"><a href="#">Trang Chủ</a></li>
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
                        <img src="{{ asset('images/services/' . $service->img) }}" class="rounded-circle mb-3" alt="{{ $service->name }}">
                    </div>
                    <h4 class="content-service">{{ $service->name }}</h4>
                    <p class="content-description">{{ $service->description }}</p>
                    <div class="hover-text">
                        <a href="#" class="read-more">Đọc thêm</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
