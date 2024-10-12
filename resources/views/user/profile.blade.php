@extends('layout')

@section('title')
Hồ Sơ Của Tôi
@endsection

@section('body')
<div class="container">
    <div class="profile-container">
        <div class="col-md-12">
            <h4>Hồ Sơ Của Tôi</h4>
            <p>Quản lý thông tin hồ sơ để bảo mật tài khoản</p>
            <div class="row">
                <div class="col-md-8 profile-info">
                    <form id="profile-form" method="POST" action="{{ route('update.profile') }}">
                        @csrf
                    
                        <div class="form-group">
                            <label for="name">Tên</label>
                            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                        </div>
                        <div class="form-group">
                            <label for="phone">Số điện thoại</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">
                        </div>
                        <div class="form-group">
                            <label>Giới tính</label>
                            <div>
                                <input type="radio" name="gender" id="male" value="Nam" {{ $user->gender == 'Nam' ? 'checked' : '' }}> Nam
                                <input type="radio" name="gender" id="female" value="Nữ" {{ $user->gender == 'Nữ' ? 'checked' : '' }} class="ml-3"> Nữ
                                <input type="radio" name="gender" id="other" value="Khác" {{ $user->gender == 'Khác' ? 'checked' : '' }} class="ml-3"> Khác
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="birthdate">Ngày sinh</label>
                            <input type="date" class="form-control" id="birthdate" name="birthdate" value="{{ $user->birthdate }}">
                        </div>
                        <button type="submit" class="btn btn-danger">Lưu</button>
                    </form>
                    
                </div>
                <div class="col-md-4 text-center">
                    <img id="profile-image" width="150px" height="150px" src="https://via.placeholder.com/120" alt="Profile Picture" class="profile-picture">
                    <input type="file" id="upload-image" class="d-none" accept="image/*">
                    <button class="btn btn-secondary btn-upload" onclick="document.getElementById('upload-image').click()">Chọn Ảnh</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
// Xử lý chọn và hiển thị ảnh sau khi upload
document.getElementById('upload-image').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file && file.size <= 1048576) { // Kiểm tra dung lượng file <= 1MB
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('profile-image').src = e.target.result;
        }
        reader.readAsDataURL(file);
    } else {
        alert('Dung lượng file quá lớn, vui lòng chọn file dưới 1MB.');
    }
});

// Xử lý lưu thông tin người dùng
// document.getElementById('profile-form').addEventListener('submit', function(event) {
//     event.preventDefault();

//     const email = document.getElementById('email').value;
//     const phone = document.getElementById('phone').value;

//     // Regex kiểm tra email hợp lệ
//     const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
//     if (!emailPattern.test(email)) {
//         alert('Email không đúng định dạng.');
//         return;
//     }

//     // Regex kiểm tra số điện thoại hợp lệ (10-11 số)
//     const phonePattern = /^\d{10,11}$/;
//     if (!phonePattern.test(phone)) {
//         alert('Số điện thoại phải có 10-11 chữ số.');
//         return;
//     }

//     alert('Thông tin đã được lưu thành công!');
// });
document.getElementById('profile-form').addEventListener('submit', function(event) {
    event.preventDefault();

    const formData = new FormData(this); // Lấy dữ liệu từ form

    fetch('{{ route("update.profile") }}', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest' // Đảm bảo đây là yêu cầu AJAX
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.message) {
            alert(data.message); // Hiển thị thông báo thành công
        }
    })
    .catch(error => console.error('Error:', error));
});

</script>
@endsection
