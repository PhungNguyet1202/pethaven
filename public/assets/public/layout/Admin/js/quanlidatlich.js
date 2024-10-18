function updateStatus(button) {
    
    const row = button.closest('tr');
    const statusCell = row.cells[4]; 

   
    const currentStatus = statusCell.innerText.trim();

  
    if (currentStatus === 'Chưa nhận') {
        statusCell.innerText = 'Đang làm';
    } else if (currentStatus === 'Đang làm') {
        statusCell.innerText = 'Hoàn thành';
    }
}