@extends('Admin/layout_admin')
@section('title')
Tổng quan
@endsection
@section('body')
<div class="w-100">

    <nav class="navbar navbar-expand-md text-bg-primary" data-bs-theme="dark">
      <div class="container-fluid ps-0">
        <div class="d-flex justify-content-between w-100">
          <form class="d-flex w-100" role="search" data-bs-theme="light">
            <div class="input-group">
              <button type="submit" class="btn btn-primary rounded-0 border-white">
                <i class="far fa-search"></i>
              </button>
              <input class="form-control me-2 rounded-0 border-white" type="search" placeholder="Search">
            </div>
          </form>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        </div>
        <div class="collapse navbar-collapse w-100" id="navbarSupportedContent">
          <ul class="navbar-nav ms-auto" data-bs-theme="light">
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <strong><i class="fas fa-bell"></i></strong>
              </a>
              <ul class="dropdown-menu rounded-0 dropdown-menu-md-end">
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li><a class="dropdown-item" href="#">Settings action</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">Sign out</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="https://github.com/mdo.png" alt="" width="32" height="32" class="rounded-circle me-2">
                <strong>CuongPN11</strong>
              </a>
              <ul class="dropdown-menu rounded-0 dropdown-menu-md-end">
                <li><a class="dropdown-item" href="#">Profile</a></li>
                <li><a class="dropdown-item" href="#">Settings action</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#">Sign out</a></li>
              </ul>
            </li>
          </ul>
          
        </div>
      </div>
    </nav>
    <div class="container-fluid p-4">
      <div class="d-flex justify-content-between">
        <h3 class="mb-4">Dashboard</h3>
      </div>
      <div class="row">
        <div class="col-md-3 mb-4">
          <div class="card border-0 rounded-0 bg-primary-subtle text-primary">
            <div class="card-body text-end">
              <div class="display-6 d-flex justify-content-between">
                <i class="fal fa-file-invoice-dollar"></i>
                {{$soDonHang}}
              </div>
              ORDERS
            </div>
          </div>
        </div>
        <div class="col-md-3 mb-4">
          <div class="card border-0 rounded-0 bg-warning-subtle text-warning">
            <div class="card-body text-end">
              <div class="display-6 d-flex justify-content-between">
                <i class="fal fa-boxes"></i>
                {{$soSanPham}}
              </div>
              PRODUCTS
            </div>
          </div>
        </div>
        <div class="col-md-3 mb-4">
          <div class="card border-0 rounded-0 bg-danger-subtle text-danger">
            <div class="card-body text-end">
              <div class="display-6 d-flex justify-content-between">
                <i class="fal fa-users"></i>
                {{ $soKhachHang }} 
              </div>
              CUSTOMERS
            </div>
          </div>
        </div>
        <div class="col-md-3 mb-4">
          <div class="card border-0 rounded-0 bg-success-subtle text-success">
            <div class="card-body text-end">
              <div class="display-6 d-flex justify-content-between">
                <i class="fal fa-chart-line"></i>
                {{number_format($doanhThu)}}
              </div>
              INCOMES
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-4 mb-3">
          <div class="card rounded-0 border-0 shadow-sm">
            <div class="card-body">
              <div class="d-flex border-bottom pb-2 justify-content-between">
                <h6 class="mb-0">
                  <i class="fal fa-file-invoice-dollar fa-lg"></i>
                  Recent Orders
                </h6>
                <small>
                  <a href="#" class="text-decoration-none">All Orders</a>
                </small>
              </div>
              <div class="d-flex text-body-secondary pt-3">
                <div class="p-2 me-2 bg-warning text-white">
                  <i class="fal fa-receipt"></i>
                </div>
                <a href="#" class="py-2 mb-0 small lh-sm border-bottom w-100 text-decoration-none text-body-secondary">
                  <strong class="d-flex justify-content-between">
                    Đơn #122
                    <div>
                      <span class="badge text-bg-warning">
                        <i class="far fa-box"></i> 20
                      </span>
                      <span class="badge bg-success-subtle text-success"><i class="far fa-money-bill-wave"></i> 100,000,000</span>
                    </div>
                  </strong>
                  Đặt bởi <i>Khách vãng lai</i> lúc 18:00 04/06/2024
                </a>
              </div>
              <div class="d-flex text-body-secondary pt-3">
                <div class="p-2 me-2 bg-success text-white">
                  <i class="fal fa-receipt"></i>
                </div>
                <a href="#" class="py-2 mb-0 small lh-sm border-bottom w-100 text-decoration-none text-body-secondary">
                  <strong class="d-flex justify-content-between">
                    Đơn #122
                    <div>
                      <span class="badge text-bg-warning">
                        <i class="far fa-box"></i> 5
                      </span>
                      <span class="badge bg-success-subtle text-success"><i class="far fa-money-bill-wave"></i> 10,000,000</span>
                    </div>
                  </strong>
                  Đặt bởi <i>Khách vãng lai</i> lúc 18:00 04/06/2024
                </a>
              </div>
              <div class="d-flex text-body-secondary pt-3">
                <div class="p-2 me-2 bg-danger text-white">
                  <i class="fal fa-receipt"></i>
                </div>
                <a href="#" class="py-2 mb-0 small lh-sm border-bottom w-100 text-decoration-none text-body-secondary">
                  <strong class="d-flex justify-content-between">
                    Đơn #121
                    <div>
                      <span class="badge text-bg-warning">
                        <i class="far fa-box"></i> 5
                      </span>
                      <span class="badge bg-success-subtle text-success"><i class="far fa-money-bill-wave"></i> 10,000,000</span>
                    </div>
                  </strong>
                  Đặt bởi <i>Khách vãng lai</i> lúc 18:00 04/06/2024
                </a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4 mb-3">
          <div class="card rounded-0 border-0 shadow-sm">
            <div class="card-body">
              <div class="d-flex border-bottom pb-2 justify-content-between">
                <h6 class="mb-0">
                  <i class="fal fa-stars fa-lg"></i>
                  Recent Ratings
                </h6>
                <small>
                  <a href="#" class="text-decoration-none">All Ratings</a>
                </small>
              </div>
              <div class="d-flex text-body-secondary pt-3">
                <i class="far fa-comment-alt-smile"></i>
                <a href="#" class="py-2 mb-0 small lh-sm border-bottom w-100 text-decoration-none text-body-secondary">
                  <strong class="d-flex justify-content-between">
                    iPhone 15 Pro Max 256GB Gold Rose
                    <div class="text-warning">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                    </div>
                  </strong>
                  Sản phẩm xịn, giá tốt!
                </a>
              </div>
              <div class="d-flex text-body-secondary pt-3">
                <i class="far fa-comment-alt-smile"></i>
                <a href="#" class="py-2 mb-0 small lh-sm border-bottom w-100 text-decoration-none text-body-secondary">
                  <strong class="d-flex justify-content-between">
                    Samsung Galaxy S23 Ultra
                    <div class="text-warning">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                    </div>
                  </strong>
                  Giá mắc, chất lượng tầm trung!
                </a>
              </div>
              <div class="d-flex text-body-secondary pt-3">
                <i class="far fa-comment-alt-smile"></i>
                <a href="#" class="py-2 mb-0 small lh-sm border-bottom w-100 text-decoration-none text-body-secondary">
                  <strong class="d-flex justify-content-between">
                    Samsung Galaxy S23 Ultra
                    <div class="text-warning">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                    </div>
                  </strong>
                  Giá mắc, chất lượng tầm trung!
                </a>
              </div>
              <div class="d-flex text-body-secondary pt-3">
                <i class="far fa-comment-alt-smile"></i>
                <a href="#" class="py-2 mb-0 small lh-sm border-bottom w-100 text-decoration-none text-body-secondary">
                  <strong class="d-flex justify-content-between">
                    Samsung Galaxy S23 Ultra
                    <div class="text-warning">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                    </div>
                  </strong>
                  Giá mắc, chất lượng tầm trung!
                </a>
              </div>
              <div class="d-flex text-body-secondary pt-3">
                <i class="far fa-comment-alt-smile"></i>
                <a href="#" class="py-2 mb-0 small lh-sm border-bottom w-100 text-decoration-none text-body-secondary">
                  <strong class="d-flex justify-content-between">
                    Samsung Galaxy S23 Ultra
                    <div class="text-warning">
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                      <i class="fas fa-star"></i>
                    </div>
                  </strong>
                  Giá mắc, chất lượng tầm trung!
                </a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4 mb-3">
          <div class="card rounded-0 border-0 shadow-sm">
            <div class="card-body">
              <div class="d-flex border-bottom pb-2 justify-content-between">
                <h6 class="mb-0">
                  <i class="fal fa-chart-pie fa-lg"></i>
                  Statistics</h6>
              </div>


              <div id="curve_chart" style="width:100%;height: 300px"></div>
              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endsection