document.getElementById('user-icon').addEventListener('click', function(event) {
    event.preventDefault();  
    var dropdown = document.getElementById('login-dropdown');
    if (dropdown.style.display === 'none' || dropdown.style.display === '') {
        dropdown.style.display = 'block';
    } else {
        dropdown.style.display = 'none';
    }
});
document.getElementById('search-icon').addEventListener('click', function(e) {
    e.preventDefault();  // Ngăn chặn việc chuyển trang khi click vào icon
    var searchOverlay = document.querySelector('.search-overlay');
    searchOverlay.style.display = 'flex';
});

document.querySelector('.search-overlay').addEventListener('click', function(e) {
    if (e.target === this) {  // Đảm bảo người dùng click ra ngoài search box mới đóng
        this.style.display = 'none';
    }
});

