@extends('Admin/layout_admin')
@section('title')
    Category
@endsection
@section('body')
<div class="content flex-grow-1">
    <div class="header">
     <h4>
      <b style="display: block;">
       Quản lý danh mục
      </b>
     </h4>
     <div class="d-flex align-items-center">
      <div class="search-bar">
       <input placeholder="Tìm tên hoặc mã danh mục" type="text"/>
       <button>
        <i class="fas fa-search">
        </i>
       </button>
      </div>
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
    <div class="table-container mt-4">
     <table>
      <thead>
       <tr>
        <th>
         STT
        </th>
        <th>
         Tên
        </th>
        <th class="actions">
         Actions
        </th>
       </tr>
      </thead>
      <tbody>
        @foreach ($dsCT as $cate)
       <tr>
        <td>
       {{$cate->id}}
        </td>
        <td>
            {{$cate->name}}
        </td>
        <td class="actions">
         <i class="fas fa-trash">
         </i>
         <i class="fas fa-edit" data-bs-toggle="modal" data-bs-target="#editModal" onclick="editCategory('Danh mục 1')">
         </i>
        </td>
       </tr>
        @endforeach
      </tbody>
     </table>
     {{$dsCT->links()}}
    </div>
 
   </div>
   @endsection