@extends('Admin/layout_admin')
@section('title')
    Product
@endsection
@section('body')
<main class="col-md-10 ms-sm-auto col-lg-10 px-md-4">
    <div class="header" style="margin-bottom: 40px;">
      <div class="text-left">
       <h4>Danh sách tin tức</h4>    
      
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

    
    <section class="table-section">
       
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Hình ảnh</th>
                    <th>Tên Tin Tức</th>
                    <th>Thể Loại</th>
                    <th>Hành Động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dsNew as $news)
                <tr>
                    <td>  {{$news->id}}</td>
                    <td>
                        <img alt="Product Image 1" height="50" src="{{ asset('images/products/' . $news->image) }}" width="50"/>
                       </td>
                    <td>  {{$news->title}}</td>
                    <td>  {{$news->categoryNew->name}}</td>
                    <td>
                        <a href=""><i class="fas fa-edit text-success"></i></a>  | <a href=""><i class="fas fa-trash"></i></a>
                     </td>
                </tr>
             @endforeach
            </tbody>
        </table>
        {{$dsNew->links()}}
    </section>
  
  </main>
</div>
@endsection