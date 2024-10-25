@extends('layout')

@section('title')
    Giỏ hàng
@endsection

@section('body')
<body>
    <div class="banner-service">
        <div class="banner-service-text">
            <h1 class="main-title">Giỏ hàng</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="#">Trang Chủ</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Giỏ hàng</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="container mt-5">
        <h2 class="mb-4 main-heading">Giỏ hàng</h2>

        @if(session('message'))
            <div class="alert alert-success">{{ session('message') }}</div>
        @endif

        @if($cartItems->isEmpty())
            <div class="alert alert-info">Giỏ hàng của bạn hiện đang trống.</div>
        @else
            <table class="table table-bordered mt-4">
                <thead>
                    <tr class="content-cart">
                        <th>Sản phẩm</th>
                        <th>Giá</th>
                        <th>Số lượng</th>
                        <th>Tổng phụ</th>
                        <th>Xóa</th>
                    </tr>
                </thead>
                <tbody class="custom-description-cart-item">
                    @foreach($cartItems as $item)
                    <tr>
                        <td>
                            <img src="{{ $item->product->image_url }}" alt="{{ $item->product->name }}" width="50"> {{ $item->product->name }}
                        </td>
                        <td>{{ number_format($item->price, 0, ',', '.') }} đ</td>
                        <td>
                            <form action="{{ route('cart.update', $item->id) }}" method="POST">
                                @csrf
                                <input type="number" name="quantity" value="{{ $item->quantity }}" class="form-control" style="width: 60px;" min="1" placeholder="Số lượng">
                                <button type="submit" class="btn btn-primary mt-2">Cập nhật</button>
                            </form>
                        </td>
                        <td>{{ number_format($item->total_price, 0, ',', '.') }} đ</td>
                        <td>
                            <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger" aria-label="Xóa sản phẩm khỏi giỏ hàng"><i class="fa-solid fa-trash fa-xl"></i></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="row">
                <div class="col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control custom-description-cart-item" placeholder="Mã giảm giá">
                        <button class="btn custom-btn-warning-cart custom-description-cart-item">Áp dụng mã</button>
                    </div>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('cart.update') }}" class="btn custom-btn-cart">Cập nhật giỏ hàng</a>
                </div>
            </div>

            <div class="mt-4">
                <h4 class="content-cart">Tổng giỏ hàng</h4>
                <table class="table custom-description-cart-item">
                    <tr>
                        <td>Tổng phụ</td>
                        <td>{{ number_format($cartItems->sum('total_price'), 0, ',', '.') }} đ</td>
                    </tr>
                    <tr>
                        <td>Tổng</td>
                        <td>{{ number_format($cartItems->sum('total_price'), 0, ',', '.') }} đ</td>
                    </tr>
                </table>
                <div class="text-end">
                    <a href="{{ route('order.checkout') }}" class="btn custom-btn-pay">Tiến hành thanh toán</a>
                </div>
            </div>
        @endif
    </div>
</body>
@endsection
