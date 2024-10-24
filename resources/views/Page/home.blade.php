@extends('layout')
@section('title')
    Home
@endsection
@section('body')
    
<main>
    <div class="container custom-section">
        <div class="row align-items-center">
            
            <div class="col-md-6">
                <h2 class="custom-title">Chăm sóc<br> thú cưng.</h2>
                <p class="custom-description">Pethaven cung cấp các sản phẩm và dịch vụ chất lượng cho thú cưng như thức ăn, đồ chơi, phụ kiện, và dịch vụ chăm sóc thú cưng chuyên nghiệp như spa, grooming, và khám sức khỏe. Khách hàng có thể dễ dàng mua sắm trực tuyến với giao hàng tận nơi, đồng thời đặt lịch các dịch vụ chăm sóc trực tiếp cho thú cưng của mình.</p>
                <button class="custom-button">Khám phá</button>
            </div>
    
            
            <div class="col-md-6">
                <img src="{{ asset('assets/public/img/slide-1.jpg')}}" alt="Pet Care"  class="img-fluid custom-rounded">
            </div>
        </div>
    </div>

   
<section class="pet-services py-5">
    <div class="container">
        <h5 class="text-center highlight"><i class="fa-solid fa-dog" style="color: #FF642F;"></i> DỊCH VỤ TẬN TÂM</h5>
        <h2 class="text-center mb-5 main-heading">Cung cấp dịch vụ<br> tốt nhất cho thú cưng</h2>
        <div class="row">
           
            <div class="col-md-3 ">
                <div class="service-card text-center p-3">
                    <img src="{{ asset('assets/public/img/service-01.jpg')}}" class="rounded-circle mb-3" alt="Chăm sóc y tế"> <!-- Thay bằng link hình ảnh của bạn -->
                    <h4 class="content-service">Chăm sóc<br> y tế</h4>
                    <p class="content-description">Cung cấp kiểm tra sức khỏe định kỳ, tiêm phòng, điều trị bệnh, và các dịch vụ y tế khác cho thú cưng của bạn.</p>
                </div>
            </div>

            
            <div class="col-md-3 service">
                <div class="service-card text-center p-3">
                    <img src="{{ asset('assets/public/img/service-02.jpg')}}" class="rounded-circle mb-3" alt="Chăm sóc và huấn luyện"> <!-- Thay bằng link hình ảnh của bạn -->
                    <h4 class="content-service">Chăm sóc<br> và huấn luyện</h4>
                    <p class="content-description">Cung cấp kiểm tra sức khỏe định kỳ, tiêm phòng, điều trị bệnh, và các dịch vụ y tế khác cho thú cưng của bạn.</p>
                </div>
            </div>
   
   <div class="col-md-3 service">
    <div class="service-card text-center p-3">
        <img src="{{ asset('assets/public/img/service-04.jpg')}}" class="rounded-circle mb-3" alt="Chăm sóc và huấn luyện"> <!-- Thay bằng link hình ảnh của bạn -->
        <h4 class="content-service">Thức ăn<br> và đồ chơi</h4>
        <p class="content-description">Cung cấp kiểm tra sức khỏe định kỳ, tiêm phòng, điều trị bệnh, và các dịch vụ y tế khác cho thú cưng của bạn.</p>
    </div>
</div>
           
            <div class="col-md-3 service">
                <div class="service-card text-center p-3">
                    <img src="{{ asset('assets/public/img/service-03.jpg')}}" class="rounded-circle mb-3" alt="Nơi ở và bảo mẫu"> <!-- Thay bằng link hình ảnh của bạn -->
                    <h4 class="content-service">Nơi ở<br> và bảo mẫu</h4>
                    <p class="content-description">Cung cấp kiểm tra sức khỏe định kỳ, tiêm phòng, điều trị bệnh, và các dịch vụ y tế khác cho thú cưng của bạn.</p>
                </div>
            </div>
            
        </div>

       
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="stat-card d-flex align-items-center p-3">
                    <i class="fas fa-thumbs-up fa-2x text-white"></i>
                    <div class="ml-3">
                        <h4 class="text-white">180</h4>
                        <p class="text-white">Đánh giá tích cực</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="start-card d-flex align-items-center p-3">
                    <i class="fas fa-cat fa-2x text-white"></i>
                    <div class="ml-3">
                        <h4 class="text-white">68+</h4>
                        <p class="text-white">Sản phẩm</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="container-fluid banner">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6">
          <img src="{{ asset('assets/public/img/banner-duoi.png')}}" alt="Pet Care Image">
        </div>
        <div class="col-md-6 banner-content">
          <h5 class="highlight"><i class="fa-solid fa-dog" style="color: #FF642F;"></i> GIỚI THIỆU</h5>
          <h2 class="main-heading">Chăm sóc thú cưng an toàn và chất lượng</h2>
          <p class="content-description">Mauris vehicula sem sed mi semper, ut vestibulum elit porttitor. Cras varius elit maximus sodales bibendum.</p>
          <blockquote class="content-description">
            “Các thành phần được sử dụng dựa trên chất lượng dinh dưỡng mà chúng cung cấp và lợi nhuận của chúng.”
          </blockquote>
          <div class="row">
            <div class="col-6">
              <p class="content-service"><strong>Hơn 25 năm kinh nghiệm</strong></p>
              <p class="content-description">Lorem ipsum dolor sit amet not is consectetur notted.</p>
            </div>
            <div class="col-6">
              <p class="content-service"><strong>Chứng nhận & chuyên gia</strong></p>
              <p class="content-description">Lorem ipsum dolor sit amet not is consectetur notted.</p>
            </div>
          </div>
          <button class="cta-btn mt-3">Khám phá</button>
          <div class="dashed-border"></div>
        </div>
      </div>
    </div>
  </div>
  <div class="container my-5">
    <div class="row">
      <div class="col-md-3">
        <div class="gallery-item" onclick="xemChiTiet('{{ asset('assets/public/img/pet1.jpg')}}')">
          <img src="{{ asset('assets/public/img/pet1.jpg')}}" alt="Ảnh thú cưng">
          <div class="overlay">
            <div class="plus-circle">+</div>
          </div>
        </div>
      </div>
     
      <div class="col-md-3">
        <div class="gallery-item" onclick="xemChiTiet('{{ asset('assets/public/img/pet2.jpg')}}')">
          <img src="{{ asset('assets/public/img/pet2.jpg')}}" alt="Ảnh thú cưng">
          <div class="overlay">
            <div class="plus-circle">+</div>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="gallery-item" onclick="xemChiTiet('{{ asset('assets/public/img/pet4.jpg')}}')">
          <img src="{{ asset('assets/public/img/pet4.jpg')}}" alt="Ảnh thú cưng">
          <div class="overlay">
            <div class="plus-circle">+</div>
          </div>
        </div>
      </div>

      <div class="col-md-3">
        <div class="gallery-item" onclick="xemChiTiet('{{ asset('assets/public/img/pet3.jpg')}}')">
          <img src="{{ asset('assets/public/img/pet3.jpg')}}" alt="Ảnh thú cưng">
          <div class="overlay">
            <div class="plus-circle">+</div>
          </div>
        </div>
      </div>

      
    </div>
  </div>
  

  <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-body">
          <img id="modalImage" src="" alt="Ảnh chi tiết" class="img-fluid" width="100%">
        </div>
      </div>
    </div>
  </div>
  <div class="container comment-service ">
    <div class="row">
        
        <div class="col-md-6">
            <h5 class="highlight"><i class="fa-solid fa-dog" style="color: #FF642F;"></i> KHÁCH HÀNG PHẢN HỒI</h5>
        <h2 class="main-heading">Khác hàng đánh giá<br> về dịch vụ </h2>
            <div id="customerCarousel" class="carousel slide" data-bs-ride="carousel">
              
                <div class="carousel-indicators">
                    <button type="button"  data-bs-target="#customerCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#customerCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button"  data-bs-target="#customerCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                </div>            
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="customer-review text-start">
                            <div class="d-flex align-items-center justify-content-start mb-4">
                                <img src="{{ asset('assets/public/img/anh-comment.jpg')}}" alt="Customer Image" class="customer-img me-3">
                                <div>
                                    <h5 class="customer-name">Christine Eve</h5>
                                    <p class="review-role">Khách hàng</p>
                                    <div class="stars">
                                        ★★★★★
                                    </div>
                                </div>
                            </div>
                            <div class="quote-mark mb-3">“</div>
                            <p class="review-text">
                                Trang web có rất nhiều dịch vụ hữu ích và đa dạng cho thú cưng. Tôi đã sử dụng dịch vụ chăm sóc và huấn luyện và nhận được hỗ trợ tốt từ nhân viên.
                            </p>
                        </div>
                    </div>

        
                    <div class="carousel-item">
                        <div class="customer-review text-start">
                            <div class="d-flex align-items-center justify-content-start mb-4">
                                <img src="{{ asset('assets/public/img/anh-comment.jpg')}}" alt="Customer Image" class="customer-img me-3">
                                <div>
                                    <h5 class="customer-name">John Doe</h5>
                                    <p class="review-role">Chủ thú cưng</p>
                                    <div class="stars">
                                        ★★★★☆
                                    </div>
                                </div>
                            </div>
                            <div class="quote-mark mb-3">“</div>
                            <p class="review-text">
                                Dịch vụ khá tốt, nhưng giao diện web có thể dễ sử dụng hơn. Tuy nhiên, thú cưng của tôi rất thích nơi này!
                            </p>
                        </div>
                    </div>

                 
                    <div class="carousel-item">
                        <div class="customer-review text-start">
                            <div class="d-flex align-items-center justify-content-start mb-4">
                                <img src="{{ asset('assets/public/img/anh-comment.jpg')}}" alt="Customer Image" class="customer-img me-3">
                                <div>
                                    <h5 class="customer-name">Emily Jane</h5>
                                    <p class="review-role">Người yêu thú cưng</p>
                                    <div class="stars">
                                        ★★★★★
                                    </div>
                                </div>
                            </div>
                            <div class="quote-mark mb-3">“</div>
                            <p class="review-text">
                                Tôi đã tìm thấy dịch vụ huấn luyện chó tuyệt vời qua trang web này. Giao diện thân thiện và dễ dùng.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

       
        <div class="col-md-6 side-img">
            <img src="{{ asset('assets/public/img/slide-1.jpg')}}" alt="Side Image" class="img-fluid">
        </div>
    </div>
</div>

<div class="container expert-container">
    <h5 class="text-center highlight"><i class="fa-solid fa-dog" style="color: #FF642F;"></i> GẶP GỠ CÁC CHUYÊN GIA </h5>
    <h2 class="text-center mb-5 main-heading">Gặp gỡ các chuyên gia<br> được chứng nhận</h2>
    <div class="row justify-content-around">
      <div class="col-lg-3 col-md-6 mb-4">
        <div class="expert-card bg-light">
          <img src="{{ asset('assets/public/img/nv1.jpg')}}" alt="Thùy Dương">
          <h3 class="expert-title">Thùy Dương</h3>
          <p class="expert-role">Nhân viên chăm sóc</p>
          <div class="social-icons">
            <a href="#"><i class="fa-brands fa-facebook"></i></a>
            <a href="#"><i class="fa-brands fa-instagram"></i></a>
            <a href="#"><i class="fa-brands fa-twitter"></i></a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4">
        <div class="expert-card bg-light">
          <img src="{{ asset('assets/public/img/nv1.jpg')}}" alt="Văn Long">
          <h3 class="expert-title">Văn Long</h3>
          <p class="expert-role">Nhân viên chăm sóc</p>
          <div class="social-icons">
            <a href="#"><i class="fa-brands fa-facebook"></i></a>
            <a href="#"><i class="fa-brands fa-instagram"></i></a>
            <a href="#"><i class="fa-brands fa-twitter"></i></a>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 mb-4">
        <div class="expert-card bg-light">
          <img src="{{ asset('assets/public/img/nv1.jpg')}}" alt="Linh Min">
          <h3 class="expert-title">Linh Min</h3>
          <p class="expert-role">Nhân viên chăm sóc</p>
          <div class="social-icons">
            <a href="#"><i class="fa-brands fa-facebook"></i></a>
            <a href="#"><i class="fa-brands fa-instagram"></i></a>
            <a href="#"><i class="fa-brands fa-twitter"></i></a>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container my-5">
    <h5 class="highlight"><i class="fa-solid fa-dog" style="color: #FF642F;"></i> TIN TỨC </h5>
    <h2 class=" main-heading mb-5">Tin tức mới nhất</h2>
    <div class="row">
     
      <div class="col-lg-4 col-md-6 mb-4">
        <div class="card news-card position-relative">
          <img src="{{ asset('assets/public/img/tt1.jpg')}}" alt="news image">
          <span class="badge">04 TH5</span>
          <div class="card-body">
            <p class="news-meta">
              <i class="fa-solid fa-tag" style="color: #008BA7;"></i> Health Care 
              <i class="fa-solid fa-comments" style="color: #008BA7;"></i> 0 Bình luận
            </p>
            <h5 class="content-service">Watch how its heart out while playing piano</h5>
            <p class="content-description">Lorem ipsum dolor sit amet, cibo mundi ea duo, vim exerci phaedrum.</p>
            <a href="#" class="read-more-btn">Đọc thêm</a>
          </div>
        </div>
      </div>


      <div class="col-lg-4 col-md-6 mb-4">
        <div class="card news-card position-relative">
          <img src="{{ asset('assets/public/img/tt2.jpg')}}" alt="news image">
          <span class="badge">04 TH5</span>
          <div class="card-body">
            <p class="news-meta">
              <i class="fa-solid fa-tag" style="color: #008BA7;"></i> Health Care 
              <i class="fa-solid fa-comments" style="color: #008BA7;"></i> 0 Bình luận
            </p>
            <h5 class="content-service">The importance of playtime for cats</h5>
            <p class="content-description">Lorem ipsum dolor sit amet, cibo mundi ea duo, vim exerci phaedrum.</p>
            <a href="#" class="read-more-btn">Đọc thêm</a>
          </div>
        </div>
      </div>

    
      <div class="col-lg-4 col-md-6 mb-4">
        <div class="card news-card position-relative">
          <img src="{{ asset('assets/public/img/tt3.jpg')}}" alt="news image">
          <span class="badge">04 TH5</span>
          <div class="card-body">
            <p class="news-meta">
              <i class="fa-solid fa-tag" style="color: #008BA7;"></i> Health Care 
              <i class="fa-solid fa-comments" style="color: #008BA7;"></i> 0 Bình luận
            </p>
            <h5 class="content-service">How to work from home with pet</h5>
            <p class="content-description">Lorem ipsum dolor sit amet, cibo mundi ea duo, vim exerci phaedrum.</p>
            <a href="#" class="read-more-btn">Đọc thêm</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>

@endsection