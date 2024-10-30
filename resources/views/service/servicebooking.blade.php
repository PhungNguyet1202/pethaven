@extends('layout')
@section('title')
    ServiceBooking
@endsection

@section('body')
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="row">
        <!-- Image Section -->
        <div class="col-md-6 image-section">
            <img src="../img/Let’s make.png" alt="Pet Image">
        </div>

        <!-- Form Section -->
        <div class="col-md-6">
            <div class="form-box">
                <h2 class="form-title">Đặt lịch</h2>
                <form id="quote-form">
                    <!-- Pet Select -->
                    <div class="mb-3">
                        <label for="pet-select" class="form-label">Chọn thú cưng</label>
                        <select id="pet-select" class="form-select">
                            <option>Chó</option>
                            <option>Mèo</option>
                            <option>Khác</option>
                        </select>
                    </div>

                    <!-- Service Select -->
                    <div class="mb-3">
                        <label for="service-select" class="form-label">Chọn dịch vụ</label>
                        <select id="service-select" class="form-select">
                            <option value="0">Chọn một dịch vụ</option>
                            <option value="200000">Tắm rửa </option>
                            <option value="300000">Cắt tỉa lông</option>
                            <option value="100000">Khác </option>
                        </select>
                    </div>

                    <!-- Price Display -->
                    <p id="service-price" class="mt-2"></p>


                    <!-- Phone -->
                    <div class="mb-3">
                        <label for="phone" class="form-label">Số điện thoại *</label>
                        <input type="text" id="phone" class="form-control" placeholder="Nhập số điện thoại">
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" id="email" class="form-control" placeholder="Nhập email của bạn">
                    </div>

                    <!-- Birthdate -->
                    <div class="mb-3">
                        <label for="birthdate" class="form-label">Chọn ngày</label>
                        <input type="date" class="form-control" id="birthdate" placeholder="Chọn ngày">
                    </div>

                    <!-- Formatted Date (Hidden) -->
                    <p id="formatted-date" class="d-none"></p>

                    <!-- Submit Button -->
                    <button type="submit" class="submit-btn">Gửi</button>
                </form>
            </div>
        </div>
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
  
    document.getElementById('service-select').addEventListener('change', function () {
        const priceElement = document.getElementById('service-price');
        const selectedValue = this.value;

        if (selectedValue === "0") {
            priceElement.textContent = ""; 
        } else {
            priceElement.textContent = `Giá: ${parseInt(selectedValue).toLocaleString('vi-VN')} VND`;
        }
    });
</script>
@endsection