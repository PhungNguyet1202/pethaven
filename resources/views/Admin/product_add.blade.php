@extends('Admin/layout_admin')
@section('title')
  Them san pham
@endsection
@section('body')
<div class="content flex-grow-1">
    <div class="header">
     <div class="text-left">
      <h4> Thêm Sản Phẩm</h4>    
     
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
    <div class="container mt-4">
      <form class="row" action="" method="POST" enctype="multipart/form-data">
        @csrf
          <div class="mb-3">
              <label for="productName" class="form-label">Tên Sản Phẩm</label>
              <input type="text" name='name' class="form-control form-addsp" id="productName" placeholder="Nhập tên sản phẩm">
          </div>
          <div class="mb-3">
              <label for="productPrice" class="form-label">Hình Ảnh</label>
              <input type="file" class="form-control form-addsp" name="image" id="productPrice" placeholder="Hình ảnh">
          </div>
        
          <div class="mb-3">
              <label for="productCategory" class="form-label">Danh Mục</label>
              <select class="form-select form-addsp" name="category_id" id="productCategory">
                  <option selected>Chọn danh mục</option>
                  @foreach ($dsCT as $dm)
                  <option value="{{$dm->id}}">{{$dm->name}}</option>
                  @endforeach
              </select>
          </div>
          <div class="mb-3">
              <label for="productPrice" class="form-label">Giá</label>
              <input type="number" name="price" class="form-control form-addsp" id="productPrice" placeholder="Nhập giá sản phẩm">
          </div>
          <div class="mb-3">
              <label for="productDiscount" class="form-label">Giá Giảm</label>
              <input type="number" name="sale_price" class="form-control form-addsp" id="productDiscount" placeholder="Nhập giá giảm (nếu có)">
          </div>
          <div class="mb-3">
              <label for="productDescription1" class="form-label">Mô Tả 1</label>
              <textarea class="form-control form-addsp" name="description1" id="productDescription1" rows="3" placeholder="Nhập mô tả 1"></textarea>
          </div>
          <div class="mb-3">
              <label for="productDescription2" class="form-label">Mô Tả 2</label>
              <input type="number" name="instock" class="form-control form-addsp" id="productDiscount" placeholder="Nhập giá giảm (nếu có)">
          </div>
          <button type="submit" class="btn btn-primary">Thêm Sản Phẩm</button>
      </form>
  </div>
    
 
   </div>
   @endsection