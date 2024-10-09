
flatpickr("#birthdate", {
    dateFormat: "d/m/Y",
    onChange: function(selectedDates, dateStr, instance) {
        formatDate(dateStr); 
    }
});


function formatDate(dateStr) {
    const formattedDateDisplay = document.getElementById("formatted-date");
    formattedDateDisplay.innerText = `Ngày bạn đã chọn làm dịch vụ là: ${dateStr}`;
    formattedDateDisplay.style.display = "block";
}


function validatePhone(phone) {
    const phoneRegex = /^[0-9]{10,11}$/;
    return phoneRegex.test(phone);
}


function validateEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

document.getElementById("quote-form").addEventListener("submit", function(event) {
    event.preventDefault(); 

    
    const phone = document.getElementById("phone").value;
    const email = document.getElementById("email").value;
    const pet = document.getElementById("pet-select").value;
    const service = document.getElementById("service-select").value;

    
    if (!validatePhone(phone)) {
        alert("Số điện thoại không hợp lệ! Vui lòng nhập đúng 10-11 số.");
        return;
    }

   
    if (!validateEmail(email)) {
        alert("Email không hợp lệ! Vui lòng nhập đúng định dạng email.");
        return;
    }

    
    alert(`Bạn đã chọn dịch vụ ${service} cho thú cưng ${pet}.`);
});
