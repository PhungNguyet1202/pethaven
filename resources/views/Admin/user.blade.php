@extends('Admin/layout_admin')
@section('title')
    User
@endsection
@section('body')
<div class="card">
    <div class="card-header font-weight-bold">
     <strong>Khách hàng</strong>
    </div>
    <div class="card-body">
     <table class="table table-bordered">
      <thead>
       <tr>
        <th>STT</th>
        <th>Tên</th>
        <th>Email</th>
        <th>SDT</th>
        <th>Vai trò</th>
        <th>Giới tính</th>
        <th>Địa chỉ</th>
        <th>Trạng thái</th>
        <th>Ngày tháng</th>
       </tr>
      </thead>
      <tbody>
        @foreach ($dsUS as $user)
       <tr>
        <td>{{$user->id}}</td>  
        <td>{{$user->name}}</td>
        <td>{{$user->email}}</td>
        <td>{{$user->phone}}</td>
        <td>{{$user->role}}</td>
        <td>{{$user->dob}}</td>
        <td>{{$user->address}}</td>
<td>
    @if($user->isaction == 0)
        <span class="text-success">Đang hoạt động</span>
    @elseif($user->isaction == 1)
        <span class="text-danger">Bị khóa</span>
    @else
        <span class="text-warning">Trạng thái không xác định</span>
    @endif
</td>
        <td>21/12/2003</td>
       </tr>
    @endforeach
      </tbody>
     </table>
     {{$dsUS->links()}}
     <div class="text-end">Có 3 thành viên</div>
    </div>
   </div>
   @endsection