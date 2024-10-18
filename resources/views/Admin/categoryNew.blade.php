@extends('Admin/layout_admin')
@section('title')
    Product
@endsection
@section('body')
<div class="main-content">
    <header>
        <div class="search-bar">
            <input type="text" placeholder="Tìm Thể Loại Tin Tức">
            <button type="submit"><i class="fa fa-search"></i></button>
        </div>
        <div class="user-info">
            <span>Nguyen Thu Phuong</span>
            <img src="../../../img/avt admin.jpg" alt="User Avatar">
        </div>
    </header>

   
    <section class="table-section">
        <h1>Danh sách loại tin tức</h1>
        <table>
            <thead>
                <tr>
                  
                    <th>Mã</th>
                    <th>Thể Loại Tin Tức</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dsCTN as $cate)
                <tr>
                    <td> {{$cate->id}}</td>
                    <td>{{$cate->name}}</td>
                    <td>
                        <a href="#"><i class="fa fa-pencil"></i></a>
                        <a href="#"><i class="fa fa-trash"></i></a>
                    </td>
                </tr>
                @endforeach
             
            </tbody>
        </table>
        {{$dsCTN->links()}}
    </section>
</div>
@endsection