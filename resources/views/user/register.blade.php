@extends('layout')
@section('title')
    Register
@endsection
@section('body')

<main>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="row">
               
                <div class="col-md-6">
                    <div class="card" >
                        <div class="card-header">
                            Đăng Ký
                        </div>
                        <div class="card-body">
                            <form action="" method="post">
                                @csrf
                                <div class="form-group">
                                    <label
                                        for="userName">User Name</label>
                                    <input type="text"
                                        class="form-control"
                                        id="userName" name="name"
                                        placeholder="Nhập tên tài khoản của bạn"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label
                                        for="loginEmail">Email</label>
                                    <input type="email"
                                        class="form-control"
                                        id="email" name="email"
                                        placeholder="Nhập email của bạn"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label
                                        for="phone">Phone</label>
                                    <input type="phone"
                                        class="form-control"
                                        id="phone" name="phone"
                                         pattern="^0\d{9}$"
                                        placeholder="Nhập số điện thoai của bạn"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label
                                        for="adddress">Địa chỉ </label>
                                    <input type="text"
                                        class="form-control"
                                        id="address" name="address"
                                        placeholder="Nhập tên tài khoản của bạn"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="loginPassword">Mật
                                        khẩu</label>
                                    <input type="password"
                                        class="form-control"
                                        id="password"name="password"
                                        placeholder="Nhập mật khẩu của bạn"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="loginPassword">Xác nhận
                                        mật khẩu</label>
                                    <input type="password"
                                        class="form-control"
                                        id="confirmPassword" name="password_confirmation"
                                        placeholder="Nhập mật khẩu của bạn"
                                        required>

                                        @if (Session::has('message'))
                                        <div class="alert alert-danger">
                                            {{Session::get('message')}}
                                        </div>
                                        @php
                                            Session::forget('message');
                                        @endphp
                                        @endif
                                </div>
                            
                                <button type="submit"
                                    class="btn btn-primary">Đăng
                                    ký</button>
                                <button type="button" class="btn-google"
                                    id="googleSignInBtn">
                                    <img
                                        src="{{ asset('assets/public/img/google-icon.png')}}"
                                        alt="Google Logo">Đăng nhập với
                                    Google
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 image-containerdk">
                    <img
                        src="{{ asset('assets/public/img/anhnendangky.jpg')}}"
                        alt="Dog Image">
                </div>
            </div>
        </div>
    </div>
</div>
</main>

<script>
    document.getElementById('register-form').addEventListener('submit', function(event) {
        event.preventDefault();

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirmPassword').value;
        const phone = document.getElementById('phone').value;
     
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            alert('Email không đúng định dạng.');
            return;
        }

        // Regex kiểm tra mật khẩu ít nhất 6 ký tự, bao gồm ký tự đặc biệt, số và chữ hoa
        const passwordPattern = /^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{6,}$/;
        if (!passwordPattern.test(password)) {
            alert('Mật khẩu phải có ít nhất 6 ký tự, bao gồm ít nhất một ký tự đặc biệt, một chữ hoa và một số.');
            return;
        }

        // Kiểm tra xác nhận mật khẩu khớp
        if (password !== confirmPassword) {
            alert('Mật khẩu xác nhận không khớp.');
            return;
        }

        alert('Đăng ký thành công!');
    });
</script>
<!-- Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script
    src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script
    src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>


@endsection