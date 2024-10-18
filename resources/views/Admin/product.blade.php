@extends('Admin/layout_admin')
@section('title')
    Product
@endsection
@section('body')
  
    
   <div class="content flex-grow-1">
    <div class="header">
     <div style="padding-right: 729px;">
      <h4>
       <b>
        Quản lý sản phẩm
       </b>
      </h4>
     </div>
     <div class="user-info">
      <i class="fas fa-bell" style="margin-right: 20px;">
      </i>
      <i class="fas fa-cog" style="margin-right: 20px;">
      </i>
      <img alt="User Avatar" height="40" src="../../../img/avatar-gt1.jpg" width="40"/>
      <span>
       Nguyễn Văn A
      </span>
     </div>
    </div>
    <div class="search-bar-container">
     <div class="search-bar">
      <input class="form-control" placeholder="Tìm mã sản phẩm" type="text"/>
      <button class="btn btn-dark">
       <i class="fas fa-search">
       </i>
      </button>
      <select class="form-select mx-2">
       <option selected="">
        Danh mục
       </option>
      </select>
      <select class="form-select mx-2">
       <option selected="">
        Giá
       </option>
      </select>
      <select class="form-select mx-2">
       <option selected="">
        Sản phẩm
       </option>
      </select>
      <button class="btn btn-outline-secondary">
       Lọc
      </button>
     </div>
    </div>
    <form class="form-inline">
     <input class="form-control" placeholder="Tên sản phẩm" type="text"/>
     <input class="form-control" placeholder="Giá" type="text"/>
     <select class="form-select">
      <option selected="">
       Danh mục
      </option>
     </select>
     <button class="btn btn-primary">
     <a href="{{  route('admin.product.add')  }}">Them</a>
     </button>
    </form>
    <div class="status-indicators">
     <div>
      <span class="badge bg-success">
      </span>
      <span>
       Còn hàng
      </span>
     </div>
     <div>
      <span class="badge bg-danger">
      </span>
      <span>
       Hết hàng
      </span>
     </div>
     <div>
      <span class="badge bg-warning">
      </span>
      <span>
       Đang nhập
      </span>
     </div>
    </div>
    <div class="table-container">
     <table class="table table-bordered">
      <thead>
       <tr>
        <th>
         STT
        </th>
        <th>
         Ảnh
        </th>
        <th>
         Tên
        </th>
        <th>
         Kho
        </th>
        <th>
         Giá
        </th>
        <th>
        Giá sale
        </th>
        <th>
         Danh Mục
        </th>
       
        <th>
         Sửa
        </th>
        <th>
         Xóa
        </th>
       </tr>
      </thead>
      <tbody>
         @foreach ($dsSP as $sp)
       <tr>
        <td>{{$sp->id}}</td>
        <td>
         <img alt="Product Image 1" height="50" src="{{ asset('images/products/' . $sp->image) }}" width="50"/>
        </td>
        <td>
         {{$sp->name}}
        </td>
        <td>
         <span class="status-dot green"> {{ $sp->stock_ins_sum_quantity }}
         </span>
        </td>
        <td>
         {{$sp->price}}
        </td>
        <td>
         {{$sp->sale_price}}
        </td>
        <td>
         {{$sp->category->name}}
        </td>
        <td>
         <i class="fas fa-edit text-success">
         </i>
        </td>
        <td>
         <i class="fas fa-trash-alt text-danger">
         </i>
        </td>
       </tr>
  @endforeach
      </tbody>
     </table>
     {{$dsSP->links()}}
    </div>
   </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+3i5q5Yl5o5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5"></script>
  @endsection