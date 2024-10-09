
const orders = [
    { id: 1, price: '5.000.000đ', date: '04/11/2023', status: 'Đang chuẩn bị', statusClass: 'status-preparing' },
    { id: 2, price: '5.000.000đ', date: '04/11/2023', status: 'Đang giao hàng', statusClass: 'status-shipping' },
    { id: 3, price: '5.000.000đ', date: '04/11/2023', status: 'Đã nhận hàng', statusClass: 'status-delivered' }
];

function populateOrderHistory() {
    const orderHistory = document.getElementById('order-history');
    orders.forEach(order => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${order.id}</td>
            <td>${order.price}</td>
            <td>${order.date}</td>
            <td class="${order.statusClass}">${order.status}</td>
            <td><a href="#">Xem chi tiết</a></td>
        `;
        orderHistory.appendChild(row);
    });
}

window.onload = populateOrderHistory;
