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
                {{-- <h5 class="group-h5">Tùy chọn</h5>
                <ul class="list-group mb-4">
                    <li class="list-group-item"><a href="#">Sắp xếp từ A - Z</a></li>
                    <li class="list-group-item"><a href="#">Sắp xếp từ Z - A</a></li>
                    <li class="list-group-item"><a href="#">Sắp xếp giá cao dần</a></li>
                    <li class="list-group-item"><a href="#">Sắp xếp giá thấp dần</a></li>
                </ul> --}}
                <h5 class="group-h5">Tùy chọn</h5>
<ul class="list-group mb-4" id="sortOptions">
    <li class="list-group-item"><a href="#" data-sort="name_asc">Sắp xếp từ A - Z</a></li>
    <li class="list-group-item"><a href="#" data-sort="name_desc">Sắp xếp từ Z - A</a></li>
    <li class="list-group-item"><a href="#" data-sort="price_asc">Sắp xếp giá thấp dần</a></li>
    <li class="list-group-item"><a href="#" data-sort="price_desc">Sắp xếp giá cao dần</a></li>
</ul>

<div id="searchResults"></div>

                <ul class="list-group mb-4">
                   
                    @foreach ($categories as $item)
                        <li class="list-group-item">
                           
                            <a href="{{ route('category', ['slug' => $item->slug]) }}">{{ $item->name }}</a>
                        </li>
                    @endforeach
                </ul>
                

                {{-- <h5 class="group-h5">Giá</h5>
                <ul class="list-group mb-4">
                    <li class="list-group-item"><a href="#">100.000 - 1.000.000đ</a></li>
                    <li class="list-group-item"><a href="#">1.000.001 - 4.000.000đ</a></li>
                    <li class="list-group-item"><a href="#">4.000.001 - 6.000.000đ</a></li>
                    <li class="list-group-item"><a href="#">6.000.001 - 8.000.000đ</a></li>
                   
                </ul> --}}

                <h5 class="group-h5">Giá</h5>
<ul class="list-group mb-4" id="priceFilter">
    <li class="list-group-item"><a href="#" data-min="100000" data-max="1000000">100.000 - 1.000.000đ</a></li>
    <li class="list-group-item"><a href="#" data-min="1000001" data-max="4000000">1.000.001 - 4.000.000đ</a></li>
    <li class="list-group-item"><a href="#" data-min="4000001" data-max="6000000">4.000.001 - 6.000.000đ</a></li>
    <li class="list-group-item"><a href="#" data-min="6000001" data-max="8000000">6.000.001 - 8.000.000đ</a></li>
</ul>

<div id="searchResults"></div> <!-- Kết quả tìm kiếm sẽ hiển thị ở đây -->

            </div>
        </div>

        <div class="col-md-9">
            <h5 class="group-h5">25 loại sản phẩm</h5>
            <div class="row">
              @foreach ($products as $sp)
              <div class="col-md-4">
                <div class="product-card">
                    {{-- <img src="{{ asset('images/products/{{$sp->image}}') }}"> --}}
                    <img src="{{ asset('images/products/' . $sp->image) }}" alt="Product Image">

                    <div class="product-title">
                        <a href="{{ route('product.detail', ['id' => $sp->id]) }}">{{ $sp->name }}</a>
                    </div>
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
    document.getElementById('priceFilter').addEventListener('click', function(event) {
    event.preventDefault();  // Ngăn chặn hành động mặc định khi nhấn vào link
    
    if (event.target.tagName === 'A') {
        const minPrice = event.target.getAttribute('data-min');
        const maxPrice = event.target.getAttribute('data-max');

        // Gửi yêu cầu lọc sản phẩm theo khoảng giá tới API
        fetch(`/api/products?min_price=${minPrice}&max_price=${maxPrice}&perPage=9&page=1`)
            .then(response => response.json())
            .then(data => {
                // Xử lý dữ liệu trả về từ API
                console.log(data);
                const searchResults = document.getElementById('searchResults');
                searchResults.innerHTML = ''; // Xóa kết quả cũ

                // Hiển thị sản phẩm được trả về
                data.data.forEach(product => {
                    const productItem = `
                        <div class="product-item">
                            <h3>${product.name}</h3>
                            <p>Price: ${product.price}</p>
                            <p>Stock: ${product.stock_sum_quantity}</p>
                            <p>Category: ${product.category.name}</p>
                        </div>
                    `;
                    searchResults.innerHTML += productItem;
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
});

</script>
<script>
    document.getElementById('sortOptions').addEventListener('click', function(event) {
    event.preventDefault();  // Ngăn chặn hành động mặc định khi nhấn vào link
    
    if (event.target.tagName === 'A') {
        const sortOption = event.target.getAttribute('data-sort');

        // Gửi yêu cầu sắp xếp sản phẩm tới API
        fetch(`/api/products?sort=${sortOption}&perPage=9&page=1`)
            .then(response => response.json())
            .then(data => {
                // Xử lý dữ liệu trả về từ API
                console.log(data);
                const searchResults = document.getElementById('searchResults');
                searchResults.innerHTML = ''; // Xóa kết quả cũ

                // Hiển thị sản phẩm được trả về
                data.data.forEach(product => {
                    const productItem = `
                        <div class="product-item">
                            <h3>${product.name}</h3>
                            <p>Price: ${product.price}</p>
                            <p>Stock: ${product.stock_sum_quantity}</p>
                            <p>Category: ${product.category.name}</p>
                        </div>
                    `;
                    searchResults.innerHTML += productItem;
                });
            })
            .catch(error => {
                console.error('Error:', error);
            });
    }
});

</script>
@endsection