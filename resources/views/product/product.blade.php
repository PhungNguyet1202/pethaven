@extends('layout')
@section('title')
    Product
@endsection
@section('body')
<div class="banner-service">
    <div class="banner-service-text">
        <h1 class="main-title">Sản phẩm</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Trang Chủ</a></li>
                <li class="breadcrumb-item active" aria-current="page"><a href="{{route('product')}}">Sản phẩm</li>
            </ol>
        </nav>
    </div>
</div>
<div class="container mt-4">
   
    <div class="row">
        <div class="col-md-3">
            <div class="sidebar">
                <h5 class="group-h5">Tùy chọn</h5>
                <ul class="list-group mb-4" id="sortOptions">
                    <li class="list-group-item"><a href="#" data-sort="name_asc">Sắp xếp từ A - Z</a></li>
                    <li class="list-group-item"><a href="#" data-sort="name_desc">Sắp xếp từ Z - A</a></li>
                    <li class="list-group-item"><a href="#" data-sort="price_asc">Sắp xếp giá thấp dần</a></li>
                    <li class="list-group-item"><a href="#" data-sort="price_desc">Sắp xếp giá cao dần</a></li>
                </ul>

                <ul class="list-group mb-4">
                   
                    @foreach ($categories as $item)
                        <li class="list-group-item">
                            <a href="{{ route('category', ['slug' => $item->slug]) }}">{{ $item->name }}</a>
                        </li>
                    @endforeach
                </ul> --}}
                <ul class="list-group mb-4">
                    @foreach ($categories as $item)
                        <li class="list-group-item">
                            <a href="{{route('api.category')}}" class="category-link" data-slug="{{ $item->slug }}">{{ $item->name }}</a>
                        </li>
                    @endforeach
                </ul>

                {{-- <h5 class="group-h5">Giá</h5>
                <ul class="list-group mb-4">
                    <li class="list-group-item"><a href="#">100.000 - 1.000.000đ</a></li>
                    <li class="list-group-item"><a href="#">1.000.001 - 4.000.000đ</a></li>
                    <li class="list-group-item"><a href="#">4.000.001 - 6.000.000đ</a></li>
                    <li class="list-group-item"><a href="#">6.000.001 - 8.000.000đ</a></li>
                   
                </ul>
            </div>
        </div>

        <div class="col-md-9">
            <h5 class="group-h5">25 loại sản phẩm</h5>
            <div class="row">
                @foreach ($products as $sp)
                <div class="col-md-4">
                    <div class="product-card">
                        <img src="{{ asset('images/products/' . $sp->image) }}" alt="Product Image">

                    <div class="product-title" href=""><a href="#">{{$sp->name}}</a></div>
                    <div class="product-sale-price">
                        @if (isset($sp->sale_price) && $sp->sale_price > 0)
                        <span> {{number_format($sp->sale_price)}} VND</span>
                        <del> {{number_format($sp->price)}} VND</del>
                        @else
                        <span> {{number_format($sp->price)}} VND</span>
                        @endif
                        
                       

                    </div>
                    <div class="product-rating justify-content-center">
                        <ul class="star-list ">
                            @for ($i = 0; $i < floor($sp->rating); $i++)
                            <li><i class="fa-solid fa-star"></i></li>

                            @endfor
                            @for ($i = 0; $i <5- floor($sp->rating); $i++)
                                <li><i class="fa-regular fa-star"></i></li>

                            @endfor

                           <li><span>{{number_format($sp->rating,1)}} Review(s)</span></li>
                        </ul>
                        {{-- <span>(3.5)</span> --}}
                    </div>
                    <div class="product-stock">Còn hàng</div>
                    <div class="product-buttons">
                        <a href="#" class="btn btn-add-cart">Thêm vào giỏ hàng</a>
                    </div>
                </div>
            </div>

              @endforeach
               
           
            
            <nav aria-label="Page navigation example" class="mt-4">
                <ul class="pagination justify-content-right">
                  <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1" aria-disabled="true">1</a>
                  </li>
                  <li class="page-item"><a class="page-link" href="#">2</a></li>
                  <li class="page-item">
                    <a class="page-link" href="#">Next</a>
                  </li>
                </ul>
              </nav>
        </div>
    </div>
</div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // document.addEventListener('DOMContentLoaded', function() {
    //     const addToCartButtons = document.querySelectorAll('.add-to-cart-button');

    //     addToCartButtons.forEach(button => {
    //         button.addEventListener('click', function(event) {
    //             event.preventDefault(); // Ngăn chặn hành vi mặc định của liên kết
    //             const productId = this.getAttribute('data-product-id');

    //             fetch('/api/cart', {
    //                 method: 'POST',
    //                 headers: {
    //                     'Content-Type': 'application/json',
    //                     'X-CSRF-TOKEN': '{{ csrf_token() }}'
    //                 },
    //                 body: JSON.stringify({
    //                     product_id: productId,
    //                     quantity: 1
    //                 })
    //             })
    //             .then(response => response.json())
    //             .then(data => {
    //                 console.log(data);
    //                 if (data.status === 'success') {
    //                     alert('Sản phẩm đã được thêm vào giỏ hàng!');
    //                 } else {
    //                     alert('Có lỗi xảy ra: ' + data.message);
    //                 }
    //             })
    //             .catch(error => {
    //                 console.error('Lỗi khi thêm sản phẩm vào giỏ:', error);
    //             });
    //         });
    //     });
    // });
</script>


<script>
// Sắp xếp sản phẩm
document.getElementById('sortOptions').addEventListener('click', function(event) {
    event.preventDefault();
    if (event.target.tagName === 'A') {
        const sortOption = event.target.getAttribute('data-sort');

        fetch(`/api/products?sort=${sortOption}&perPage=9&page=1`)
            .then(response => response.json())
            .then(data => {
                updateProductList(data.data);
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
});

// Lọc sản phẩm theo danh mục
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.category-link').forEach(function (link) {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            let categorySlug = this.getAttribute('data-slug');

            fetch(`/api/category/${encodeURIComponent(categorySlug)}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        updateProductList(data.products);
                    } else {
                        console.error(data.message);
                        document.getElementById('product-list').innerHTML = '<li class="list-group-item">Category not found</li>';
                    }
                })
                .catch(error => {
                    console.error('Error fetching products:', error);
                    document.getElementById('product-list').innerHTML = '<li class="list-group-item">Error loading products</li>';
                });
        });
    });
});

// Hàm cập nhật danh sách sản phẩm
function updateProductList(products) {
    let productList = document.getElementById('product-list');
    productList.innerHTML = '';

    if (products.length > 0) {
        products.forEach(product => {
            let productItem = document.createElement('div');
            productItem.className = 'col-md-4';
            productItem.innerHTML = `
                <div class="product-card">
                    <img src="/images/products/${product.image}" alt="Product Image">
                    <div class="product-title"><a href="#">${product.name}</a></div>
                    <div class="product-sale-price">
                        <span>${product.price} VND</span>
                    </div>
                    <div class="product-rating">
                        <ul class="star-list">
                            ${generateStars(product.rating)}
                            <li><span>${product.rating} Review(s)</span></li>
                        </ul>
                    </div>
                    <div class="product-buttons">
                        <a href="#" class="btn btn-add-cart">Thêm vào giỏ hàng</a>
                    </div>
                </div>
            `;
            productList.appendChild(productItem);
        });
    } else {
        productList.innerHTML = '<li class="list-group-item">No products found</li>';
    }
}

// Hàm tạo sao đánh giá
function generateStars(rating) {
    let stars = '';
    for (let i = 0; i < Math.floor(rating); i++) {
        stars += '<li><i class="fa-solid fa-star"></i></li>';
    }
    for (let i = 0; i < 5 - Math.floor(rating); i++) {
        stars += '<li><i class="fa-regular fa-star"></i></li>';
    }
    return stars;
}
</script>

@endsection