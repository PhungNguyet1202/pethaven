@extends('layout')
@section('title')
    {{$sp->name}}
@endsection
@section('body')

<div class="banner-service">
    <div class="banner-service-text">
        <h1 class="main-title">Sản phẩm</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Trang Chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page">Chi tiết sản phẩm</li>
            </ol>
        </nav>
    </div>
</div>
<div class="container">

<div class="row justify-content-lg-around product-details">
  
    <div class="col-md-5">
        <img src="{{ asset('images/products/' . $sp->image) }}" alt="" class="product-image">
    </div>
   
    <div class="col-md-5">
        <h3 class="spring-h3">{{$sp->name}}</h3>
        <p class="product-price">50.000đ</p>
        <p class="custom-description-cart-item "><span class="star-rating">★★★★★</span> (1 Khách hàng đánh giá)</p>
        <p class="custom-description-cart-item ">{{$sp->description}}</p>

      
        <div class="quantity-wrapper mt-3 custom-description-cart-item ">
            <label for="quantity">Chọn số lượng</label>
            <div class="quantity-control">
                <button class="btn-quantity" id="decrease-qty">-</button>
                <input type="number" id="quantity" name="quantity" value="1" min="1" readonly>
                <button class="btn-quantity" id="increase-qty">+</button>
            </div>
        </div>

      
        <button class="btn add-to-cart-btn">Thêm vào giỏ hàng</button>
    </div>
</div>

<div class="description-product-review">

<div class="product-description mt-4">
    <h4 class="content-service">Mô tả</h4>
    <p class="custom-description-cart-item">Lorem ipsum dolor sit amet consectetur adipiscing elit...</p>
</div>


<div class="reviews mt-5">
    <h4 class="content-service">Đánh giá</h4>
    <div class="review">
        <h5 class="user-review">Kevin Martin</h5>
        <p class="custom-description-cart-item"><span class="text-muted">16 Tháng Năm, 2023</span></p>
        <p class="custom-description-cart-item">Aliquam et facilisis arcu ut molestie augue. Suspendisse sodales tortor nunc quis auctor ligula posuere cursus.</p>
        <p class="custom-description-cart-item"><span class="star-rating">★★★☆☆</span></p>
    </div>
</div>

<div class="review-form">
    <h4 class="content-service">Thêm đánh giá</h4>
    <form action="#" method="post">
        <input type="text" name="name" placeholder="Họ tên" required>
        <input type="email" name="email" placeholder="Địa chỉ Email" required>
        <label for="rating">Đánh giá của bạn:</label>
        <input type="number" id="rating" name="rating" max="5" min="1" required>
        <textarea name="review" placeholder="Đánh giá của bạn..." required></textarea>
        <button class="btn add-review">Gửi đánh giá</button>
    </form>
</div>
</div>
</div>

    
@endsection