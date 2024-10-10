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
        {{-- <p class="product-price">
            @if ( isset($sp->sale_price))
            {{number_format($sp->sale_price)}} VND
            <span>{{number_format($sp->price)}} VND</span>
                @else
                {{number_format($sp->price)}} VND
                
            @endif
            </p> --}}
            <p class="product-price">
                @if (isset($sp->sale_price) && $sp->sale_price > 0)
                    <span class="sale-price">{{ number_format($sp->sale_price) }} VND</span>
                    <span class="old-price">{{ number_format($sp->price) }} VND</span>
                @else
                    <span>{{ number_format($sp->price) }} VND</span>
                @endif
            </p>
            
            
            
        
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
        <p class="custom-description-cart-item ">{{$sp->description}}</p>

      
        <div class="quantity-wrapper mt-3 custom-description-cart-item ">
            <label for="quantity">Chọn số lượng</label>
            <div class="quantity-control">
                <button class="btn-quantity" id="decrease-qty">-</button>
                <input type="number" id="quantity" name="quantity" value="1" min="1" readonly>
                <button class="btn-quantity" id="increase-qty">+</button>
            </div>
        </div>

      
        <button class="btn add-to-cart-btn" ng-click="addToCart({{$sp->id}})">Thêm vào giỏ hàng</button>
    </div>
</div>

<div class="description-product-review">

<div class="product-description mt-4">
    <h4 class="content-service">Mô tả</h4>
    <p class="custom-description-cart-item">{{$sp->description}}</p>
</div>


<div class="reviews mt-5">
    <h4 class="content-service">Đánh giá</h4>
    <div ng-repeat="bl in dsBL" class="review">
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
</div>

<div class="review-form">
    <h4 class="content-service">Thêm đánh giá</h4>

    @auth
        <!-- This section is for authenticated users -->
        <p>Welcome back, {{ Auth::user()->name }}!</p>
        <!-- You can place any other content for authenticated users here -->
    @endauth

    @guest
        <div class="alert alert-info">
            Bạn cần <a href="{{ route('login') }}">đăng nhập</a> để đánh giá
        </div>
    @endguest

    <form action="/api/comments" method="post">
        @csrf
        <label for="rating">Đánh giá của bạn:</label>
        <select ng-model="rating" class="form-control" id="rating">
            <option value="5">5 Sao</option>
            <option value="4">4 Sao</option>
            <option value="3">3 Sao</option>
            <option value="2">2 Sao</option>
            <option value="1">1 Sao</option>
        </select>
        <textarea ng-model="content" name="review" placeholder="Đánh giá của bạn..." required></textarea>
        <button ng-click="sendComment()" class="btn add-review">Gửi đánh giá</button>
    </form>
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
        'product_id': {{$sp->id}}, // Ensure this is set correctly
        'content': $scope.content,
        'rating': $scope.rating,
    }).then(
        function(res) {
            $scope.content = '';
            $scope.rating = 5;
            $scope.getComment(); // load lại dsbl
        }
    );
}

            // $scope.sendComment = function(){
            //     $http.post('/api/comments',{
            //         'product_id':{{$sp->id}},
            //         'content':$scope.content,
            //         'rating':$scope.rating,
            //     }).then(
            //         function(res){
            //             $scope.content ='';
            //             $scope.rating=5;
            //             $scope.getComment();// load lại dsbl
            //         }
                  

            //     )
            // }
        }
    </script>
@endsection
