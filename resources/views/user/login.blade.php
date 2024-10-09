@extends('layout')
@section('title')
    Login
@endsection
@section('body')
<div class="container" style="padding: 20px">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="row">
            
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Đăng nhập
                        </div>
                        <div class="card-body">
                            <form action="" method="post">
                                @csrf
                                <div class="form-group">
                                    <label
                                        for="loginEmail">Email</label>
                                    <input type="email"
                                        class="form-control"
                                        id="loginEmail"name="email"
                                        placeholder="Nhập email của bạn"
                                        required>
                                </div>
                                <div class="form-group">
                                    <label for="loginPassword">Mật
                                        khẩu</label>
                                    <input type="password"
                                        class="form-control"
                                        id="loginPassword"name="password"
                                        placeholder="Nhập mật khẩu của bạn"
                                        required>
                                </div>
                                @if (Session::has('message'))
                                <div class="alert alert-danger">
                                    {{Session::get('message')}}
                                </div>
                                @php
                                    Session::forget('message');
                                @endphp
                                @endif
                                <div class="quenPass">
                                    <a href=""><span>Quên mật khẩu ?</span></a>
                                </div>
                                <button type="submit"
                                    class="btn btn-primary">Đăng
                                    nhập</button>
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
                <div class="col-md-6 image-containerdn">
                    <img
                        src="{{ asset('assets/public/img/anhnendangnhap.jpg')}}"
                        alt="Dog Image">
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://accounts.google.com/gsi/client" async
    defer></script>
@endsection