function editCustomer(name) {
    document.getElementById('editCustomerName').value = name;
}
const ctx = document.getElementById('myPieChart').getContext('2d');
const myPieChart = new Chart(ctx, {
    type: 'pie',
    data: {
        labels: ['Khách hàng 1', 'Khách hàng 2', 'Khách hàng 3', 'Khách hàng 4', 'Khách hàng 5', 'Khách hàng 6'],
        datasets: [{
            data: [10, 20, 30, 10, 15, 15],
            backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40']
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});