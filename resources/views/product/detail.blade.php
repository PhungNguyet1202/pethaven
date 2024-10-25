
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
            <!-- <p class="product-price">50.000đ</p> -->
            <p class="product-price">
                @if (isset($sp->sale_price) && $sp->sale_price > 0)
                    <span class="sale-price">{{ number_format($sp->sale_price) }} VND</span>
                    <span class="old-price">{{ number_format($sp->price) }} VND</span>
                @else
                    <span style="color: red; font-weight: bold;">{{ number_format($sp->price) }} VND</span>
                @endif
            </p>
            <!-- <p class="custom-description-cart-item "><span class="star-rating">★★★★★</span> (1 Khách hàng đánh giá)</p> -->
            <p class="custom-description-cart-item ">
                @php
                $rating = round($sp->rating); // Làm tròn giá trị đánh giá nếu cần thiết
            @endphp
        
            <span class="star-rating">
                @for ($i = 1; $i <= 5; $i++)
                    @if ($i <= $rating)
                        ★
                    @else
                        ☆
                    @endif
                @endfor
            </span>
            ({{ $sp->rating }} / 5 từ {{ $sp->review_count }} đánh giá)</p>
            
            <!-- <p class="custom-description-cart-item ">Áo len thời trang cho thú cưng, giữ ấm và làm đẹp cho thú cưng của bạn!</p> -->
            <div class="quantity-wrapper mt-3 custom-description-cart-item ">
                <label for="quantity">Chọn số lượng</label>
                <div class="quantity-control">
                    <button class="btn-quantity" id="decrease-qty">-</button>
                    <input type="number" id="quantity" name="quantity" value="1" min="1" readonly>
                    <button class="btn-quantity" id="increase-qty">+</button>
                </div>
            </div>
            <button class="btn add-to-cart-btn"  ng-click="addToCart({{$sp->id}})">Thêm vào giỏ hàng</button>
        </div>
    </div>

    <!-- Nav tabs -->
    <ul class="nav nav-tabs mt-5" id="myTab" role="tablist">
        <li class="nav-item">
            <a class="nav-link active" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-selected="true">Mô tả</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="review-tab" data-toggle="tab" href="#review" role="tab" aria-controls="review" aria-selected="false">Đánh giá (2)</a>
        </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <!-- Mô tả -->
        <div class="tab-pane fade show active" id="description" role="tabpanel" aria-labelledby="description-tab">
            <div class="product-description mt-4">
                <h4 class="content-service">Mô tả</h4>
                <!-- <p class="custom-description-cart-item">
                    Lorem ipsum dolor sit amet consectetur adipiscing elit. Vivamus sed molestie sapien aliquam et facilisis arcu...
                </p> -->
                <p class="custom-description-cart-item">{{$sp->description}}</p>


                <!-- Sản phẩm liên quan -->
                {{-- <div class="related-products mt-5">
                    <h4 class="content-service">Sản phẩm liên quan</h4>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="product-card">
                                <img src="../img/sp1.jpg" alt="Product 1">
                                <div class="product-title"><a href="">Quần Áo Cho Chó 1</a></div>
                               
                                <div class="product-sale-price">500.000đ</div>
                                <div class="product-rating justify-content-center">
                                    <ul class="star-list ">
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star-half-alt"></i></li>
                                        <li><i class="fa-regular fa-star"></i></li>
                                    </ul>
                                    <span>(3.5)</span>
                                </div>
                                
                                <div class="product-stock">Còn hàng</div>
                                <div class="product-buttons">
                                    <a href="#" class="btn btn-add-cart">Thêm vào giỏ hàng</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="product-card">
                                <img src="../img/sp1.jpg" alt="Product 1">
                                <div class="product-title"><a href="">Quần Áo Cho Chó 1</a></div>
                               
                                <div class="product-sale-price">500.000đ</div>
                                <div class="product-rating justify-content-center">
                                    <ul class="star-list ">
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star-half-alt"></i></li>
                                        <li><i class="fa-regular fa-star"></i></li>
                                    </ul>
                                    <span>(3.5)</span>
                                </div>
                                
                                <div class="product-stock">Còn hàng</div>
                                <div class="product-buttons">
                                    <a href="#" class="btn btn-add-cart">Thêm vào giỏ hàng</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="product-card">
                                <img src="../img/sp1.jpg" alt="Product 1">
                                <div class="product-title"><a href="">Quần Áo Cho Chó 1</a></div>
                               
                                <div class="product-sale-price">500.000đ</div>
                                <div class="product-rating justify-content-center">
                                    <ul class="star-list ">
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star-half-alt"></i></li>
                                        <li><i class="fa-regular fa-star"></i></li>
                                    </ul>
                                    <span>(3.5)</span>
                                </div>
                                
                                <div class="product-stock">Còn hàng</div>
                                <div class="product-buttons">
                                    <a href="#" class="btn btn-add-cart">Thêm vào giỏ hàng</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="product-card">
                                <img src="../img/sp1.jpg" alt="Product 1">
                                <div class="product-title"><a href="">Quần Áo Cho Chó 1</a></div>
                               
                                <div class="product-sale-price">500.000đ</div>
                                <div class="product-rating justify-content-center">
                                    <ul class="star-list ">
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star"></i></li>
                                        <li><i class="fa-solid fa-star-half-alt"></i></li>
                                        <li><i class="fa-regular fa-star"></i></li>
                                    </ul>
                                    <span>(3.5)</span>
                                </div>
                                
                                <div class="product-stock">Còn hàng</div>
                                <div class="product-buttons">
                                    <a href="#" class="btn btn-add-cart">Thêm vào giỏ hàng</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> --}}
                <div class="related-products mt-5">
                    <h4 class="content-service">Sản phẩm liên quan</h4>
                    <div class="row" id="related-products-list">
                        <!-- Danh sách sản phẩm liên quan sẽ được thêm vào đây -->
                    </div>
                </div>
                
                <!-- Kết thúc sản phẩm liên quan -->
            </div>
        </div>

        <!-- Đánh giá -->
        <div class="tab-pane fade" id="review" role="tabpanel" aria-labelledby="review-tab">
            <div class="reviews mt-4">
                <h4 class="content-service">Bình luận</h4>
                <div class="review">
                    <!-- <h5 class="user-review">Kevin Martin</h5>
                    <p class="custom-description-cart-item"><span class="text-muted">16 Tháng Năm, 2023</span></p>
                    <p class="custom-description-cart-item">
                        Aliquam et facilisis arcu ut molestie augue. Suspendisse sodales tortor nunc quis auctor ligula posuere cursus.
                    </p> -->
                    <h5 class="user-review">@{{bl.user_fullname}}</h5>
                    <p class="custom-description-cart-item"><span class="text-muted">@{{bl.created_at | date:'dd/MM/yyyy HH:mm:ss'}}</span></p>
                    <p class="custom-description-cart-item">@{{bl.content}}</p>
                    <p  class="custom-description-cart-item">
                         <span ng-show="bl.rating>=1" class="star-rating"><i class="fa-solid fa-star"></i></span> 
                         <span ng-show="bl.rating>=2" class="star-rating"><i class="fa-solid fa-star"></i></span> 
                         <span ng-show="bl.rating>=3" class="star-rating"><i class="fa-solid fa-star"></i></span> 
                         <span ng-show="bl.rating>=4" class="star-rating"><i class="fa-solid fa-star"></i></span> 
                         <span ng-show="bl.rating==5" class="star-rating"><i class="fa-solid fa-star"></i></span> 
                         <span ng-show="bl.rating<5" class="star-rating"> <i class="fa-regular fa-star"></i></span> 
                         <span ng-show="bl.rating<4" class="star-rating"> <i class="fa-regular fa-star"></i></span> 
                         <span ng-show="bl.rating<3" class="star-rating"> <i class="fa-regular fa-star"></i></span> 
                         <span ng-show="bl.rating<2" class="star-rating"> <i class="fa-regular fa-star"></i></span> 
                         <span ng-show="bl.rating<1" class="star-rating"> <i class="fa-regular fa-star"></i></span> 
            
                        
                    </p>
                </div>

                <div class="review-form mt-4">
                    <h4 class="content-service">Thêm bình luận</h4>
                    <!-- <form action="#" method="post">
                        <input type="text" name="name" placeholder="Họ tên" required>
                        <input type="email" name="email" placeholder="Địa chỉ Email" required>
                        <textarea name="review" placeholder="Đánh giá của bạn..." required></textarea>
                        <button class="btn add-review mt-2">Gửi đánh giá</button>
                    </form> -->
                    <form action="/api/comments" method="post">
                        @csrf
                        
                        @auth
                            <p>Xin Chào, {{ Auth::user()->name }}!</p>
                        @endauth
                
                        @guest
                            <div class="alert alert-info">
                                Bạn cần <a href="{{ route('login') }}">đăng nhập</a> để đánh giá
                            </div>
                        @endguest
                
                        <label for="rating">Đánh giá của bạn:</label>
                        <select ng-model="rating" class="form-control" id="rating" required>
                            <option value="5">5 Sao</option>
                            <option value="4">4 Sao</option>
                            <option value="3">3 Sao</option>
                            <option value="2">2 Sao</option>
                            <option value="1">1 Sao</option>
                        </select>
                
                        <textarea ng-model="content" name="review" placeholder="Đánh giá của bạn..." required></textarea>
                        <button type="submit" class="btn add-review" ng-click="sendComment()">Gửi đánh giá</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('viewFunction')
<script>
    viewFunction = function($scope,$http){
        $scope.addToCart = function(id){
           console.log(`da them sp ${id} vao gio hang`);
            
        }
        $scope.dsBL=[];
        $scope.getComment = function(){
            $http.get('/api/comments/product/{{$sp->id}}').then(
            function(res){//thanh cong
                $scope.dsBL =res.data.data;
                console.log($scope.dsBL);
                

            },
            function(res){//that bai

            }
        );
        }
        $scope.getComment();
      

        $scope.sendComment = function() {
$http.post('/api/comments', {
    'product_id': {{$sp->id}},
    'content': $scope.content,
    'rating': $scope.rating,
}).then(
    function(res) {
        $scope.content = '';
        $scope.rating = 5;
        $scope.getComment(); // load lại dsbl
    }
);
}}
</script>

<script>
    $(document).ready(function() {
        $('#myTab a').on('click', function (e) {
            e.preventDefault();
            $(this).tab('show');
        });
    });
</script>
<script>document.addEventListener("DOMContentLoaded", function() {
    const productId = /* Lấy ID sản phẩm hiện tại từ URL hoặc nguồn khác */;
    fetch(`/product/${productId}/related`)
        .then(response => response.json())
        .then(data => {
            const relatedProductsContainer = document.getElementById('related-products-list');
            relatedProductsContainer.innerHTML = ''; // Xóa nội dung cũ

            data.forEach(product => {
                // Tạo phần tử HTML cho mỗi sản phẩm liên quan
                const productHtml = `
                    <div class="col-md-3">
                        <div class="product-card">
                            <img src="${product.image_url}" alt="${product.name}">
                            <div class="product-title"><a href="/product/${product.id}">${product.name}</a></div>
                            <div class="product-sale-price">${product.price}đ</div>
                            <div class="product-rating justify-content-center">
                                <ul class="star-list ">
                                    <!-- Xử lý hiển thị sao tại đây -->
                                </ul>
                                <span>(${product.rating})</span>
                            </div>
                            <div class="product-stock">${product.in_stock ? 'Còn hàng' : 'Hết hàng'}</div>
                            <div class="product-buttons">
                                <a href="#" class="btn btn-add-cart">Thêm vào giỏ hàng</a>
                            </div>
                        </div>
                    </div>
                `;
                relatedProductsContainer.insertAdjacentHTML('beforeend', productHtml);
            });
        })
        .catch(error => console.error('Lỗi khi tải sản phẩm liên quan:', error));
});
</script>
@endsection