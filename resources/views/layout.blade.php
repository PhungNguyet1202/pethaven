<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> @yield('title') | PET HAVENT</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/public/css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/public/css/dangky.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/public/css/dangnhap.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/public/css/sanpham.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/public/css/chitiet.css') }}">
    
    <script src="{{ asset('js/angular.min.js') }}"></script>


</head>
<body ng-app="tcApp" ng-controller="tcCtrl">
  <header>
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <div class="logo">
                <a class="navbar-brand" href="#">
                    <img src="{{ asset('assets/public/img/Red & Orange Simple Petshop Logo.png')}}" alt="Pet Planet Logo">
                </a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="col-8 navbar-nav justify-content-around">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('home')}}">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Giới thiệu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('service')}}">Dịch vụ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('product')}}">Sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Tin tức</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Liên hệ</a>
                    </li>
                </ul>

                <ul class="col-3 navbar-nav ml-auto icons-nav justify-content-evenly">
                    {{-- <li class="nav-item">
                        <form class="search-container">
                            <a href="#" id="search-icon"><i class="fa-solid fa-magnifying-glass" style="color: #111212;"></i></a>
                            <div class="search-overlay" style="display: none;">
                                <div class="search-box">
                                    <input type="text" class="form-control" placeholder="Tìm kiếm...">
                                    <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </li> --}}
                    <li class="nav-item">
                      <form class="search-container" id="searchForm" method="GET" action="#">
                        @csrf
                          <a href="#" id="search-icon"><i class="fa-solid fa-magnifying-glass" style="color: #111212;"></i></a>
                          <div class="search-overlay" style="display: none;">
                              <div class="search-box">
                                  <input type="text" name="search" id="searchInput" class="form-control" placeholder="Tìm kiếm...">
                                  <input type="hidden" name="perPage" value="9">
                                  <input type="hidden" name="page" value="1">
                                  <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
                              </div>
                          </div>
                      </form>
                  </li>
                  >
                  
                  
                  <div id="searchResults"></div> 
                  
                    <li class="nav-item user-relavity">
                        <a href="{{ route('cart.show') }}" class="nav-link">
                            <i class="fas fa-shopping-cart fa-xl"></i>
                            <span class="shopping-cart-items-count">0</span>
                        </a>
                    </li>
                    @if (!Auth::check())
                    <li class="nav-item user-relavity">
                        <a href="#" id="user-icon" class="nav-link">
                            <i class="fas fa-user fa-xl"></i>
                        </a>
                        <div class="dropdown-menu" id="login-dropdown" style="display: none;">
                            <a class="dropdown-item" href="{{route('login')}}">Đăng nhập</a>
                            <a class="dropdown-item" href="{{route('register')}}">Đăng ký</a>
                          
                        </div>
                    </li>

                    @else
                    <li class="nav-item dropdown" style="padding-top: 15px">
                      <a class="dd-menu dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: black">
                        Xin chào,{{Auth::user()->name}}
                      </a>
                      <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                          <li>
                            <a class="dropdown-item" href="{{route('showProfile')}}">
                             Hồ sơ
                         </a>
                              <a class="dropdown-item" href="{{ route('logout') }}"
                                 onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                  Đăng xuất
                              </a>
                          </li> 
                          <!-- Add more links as needed -->
                      </ul>
                  </li>
              @endif

                </ul>
            </div>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
          </form> 
    </nav>
</header>

<div ng-controller="viewCtrl">
    @yield('body')
</div>



<footer class="footer pt-5 pb-4">
    <div class="container text-center text-md-left">
      <div class="row">
        
        <div class="col-md-4 col-lg-4 col-xl-4 mx-auto mt-3">
          <h5 class="mb-4 font-weight-bold">
            <img src="{{ asset('assets/public/img/Red & Orange Simple Petshop Logo.png')}}" alt="Pet Planet Logo" style="height: 40px;">
            PET HAVEN MEDIA
          </h5>
          <p>Họ tiêu diệt kẻ thù không bằng những mũi tên dễ dàng. Một cách khôn ngoan, bây giờ chúng ta sẽ phải chịu đau đớn.</p>
          <div>
            <a href="#"><i class="fab fa-twitter fa-lg text-white mr-3"></i></a>
            <a href="#"><i class="fab fa-facebook fa-lg text-white mr-3"></i></a>
            <a href="#"><i class="fab fa-pinterest fa-lg text-white mr-3"></i></a>
            <a href="#"><i class="fab fa-instagram fa-lg text-white"></i></a>
          </div>
        </div>
  
    
        <div class="col-md-2 col-lg-2 col-xl-2 mx-auto mt-3">
          <h5 class="text-uppercase mb-4 font-weight-bold">Danh mục</h5>
          <p><a href="#" class="text-white" style="text-decoration: none;">Giới thiệu</a></p>
          <p><a href="#" class="text-white" style="text-decoration: none;">Dịch vụ</a></p>
          <p><a href="#" class="text-white" style="text-decoration: none;">Sản phẩm</a></p>
          <p><a href="#" class="text-white" style="text-decoration: none;">Tin tức</a></p>
          <p><a href="#" class="text-white" style="text-decoration: none;">Liên hệ</a></p>
        </div>
  
     
        <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
          <h5 class="text-uppercase mb-4 font-weight-bold">Phòng trưng bày</h5>
          <div class="row">
            <div class="col-4 mb-3"><img src="{{ asset('assets/public/img/pet1.jpg')}}" class="img-fluid" alt=""></div>
            <div class="col-4 mb-3"><img src="{{ asset('assets/public/img/pet2.jpg')}}" class="img-fluid" alt=""></div>
            <div class="col-4 mb-3"><img src="{{ asset('assets/public/img/pet3.jpg')}}" class="img-fluid" alt=""></div>
            <div class="col-4 mb-3"><img src="{{ asset('assets/public/img/pet4.jpg')}}" class="img-fluid" alt=""></div>
            <div class="col-4 mb-3"><img src="{{ asset('assets/public/img/pet5.jpg')}}" class="img-fluid" alt=""></div>
           
          </div>
        </div>
  
        <div class="col-md-3 col-lg-3 col-xl-3 mx-auto mt-3">
          <h5 class="text-uppercase mb-4 font-weight-bold">Liên hệ</h5>
          <p><i class="fas fa-map-marker-alt mr-3"></i> 1073/23 Cách Mạng Tháng 8, P.7, Q.Tân Bình, TP.HCM</p>
          <p><i class="fas fa-phone mr-3"></i> (+84) 0313728397</p>
          <p><i class="fas fa-clock mr-3"></i> Thứ 2 - Thứ 6: 09:00 - 18:00</p>
          <p><i class="fas fa-envelope mr-3"></i> info@themona.global</p>
        </div>
      </div>
  
    
    </div>
  </footer>
  <script src="{{ asset('assets/public/js/app.js')}}"></script>
 <script>
    document.getElementById('searchForm').addEventListener('submit', function(event) {
    event.preventDefault();  // Ngăn chặn hành động mặc định của form
    
    // Lấy giá trị từ ô input và mã hóa nó để phù hợp với URL
    const searchValue = encodeURIComponent(document.getElementById('searchInput').value); 
    
    // Gửi yêu cầu tìm kiếm tới API với từ khóa đã mã hóa
    fetch(`/api/products?search=${searchValue}&perPage=9&page=1`)
        .then(response => response.json())
        .then(data => {
            // Xử lý kết quả trả về từ API
            const searchResults = document.getElementById('searchResults');
            searchResults.innerHTML = '';  // Xóa kết quả tìm kiếm cũ

            if (data.data.length > 0) {
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
            } else {
                searchResults.innerHTML = '<p>Không tìm thấy sản phẩm nào.</p>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
});
 </script>


  </body>
  <script>
        function xemChiTiet(imageUrl) {
    
        document.getElementById('modalImage').src = imageUrl;
        var myModal = new bootstrap.Modal(document.getElementById('imageModal'));
        myModal.show();
      }
  
     
  </script>
  <script>
    var app= angular.module('tcApp',[]);
    app.controller('tcCtrl',function($scope){

    });
    var viewFunction = function($scope){

    }
  </script>
  @yield('viewFunction')
  <script>
    app.controller('viewCtrl',viewFunction);
  </script>
  </html>