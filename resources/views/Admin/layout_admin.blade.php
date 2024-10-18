<html lang="en">
 <head>
  <meta charset="utf-8"/>
  <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
  <title>
@yield('title') | Admin Board of TechChain
  </title>
  <link crossorigin="anonymous" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/><link rel="stylesheet">
  <link rel="stylesheet" href="{{asset('/')}}layout/Admin/css/quanlysanpham.css">
  <link rel="stylesheet" href="{{ asset('assets/public/layout/Admin/css/quanlysanpham.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/public/layout/Admin/css/quanlydanhmuc.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/public/layout/Admin/css/quanlykhachhang.css') }}">
</head>
</head>
 <body>
  <div class="d-flex">
    <div class="sidebar">
     <div class="text-center mb-4">
      <img alt="" height="200" src="../../../img/Red & Orange Simple Petshop Logo.png" width="200"/>
      <h4>PET HEAVEN</h4>
     </div>
     <a href="{{ route('admin.dashboard') }}" class=" ">

      <i class="fas fa-users"></i>Dashboard
     </a>
     <a href="{{ route('admin.category') }}" class="   ">

      <i class="fas fa-users"></i>quan ly danh muc
     </a>
     <a href="{{ route('admin.user') }}" class="  {{ (Request::routeIs('admin.user'))?'active':'text-white' }}">
         <i class="fas fa-shopping-cart"></i> Quản lý khách hàng
        </a>
        <a href="{{route('admin.product') }}" class="  {{ (Request::routeIs('admin.product'))?'active':'text-white' }}">

          <i class="fas fa-users"></i>Quan ly san pham
         </a>
        <a href="../layout/thongkesanphamban.html">
         <i class="fas fa-chart-bar"></i> Thống kê sản phẩm bán
        </a>
        <a href="../layout/baocaodoanhthu.html">
         <i class="fas fa-envelope"></i> Báo cáo doanh thu
        </a>
    </div>
   
    @yield('body')

</div>
</body>
</html>
  <script type="text/javascript" src="{{asset('/')}}/layout/Adminjs/google.chart.js"></script>
<script type="text/javascript">
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

function drawChart() {
  var data = google.visualization.arrayToDataTable([
    ['Year', 'Sales', 'Expenses'],
    ['2004',  1000,      400],
    ['2005',  1170,      460],
    ['2006',  660,       1120],
    ['2007',  1030,      540]
  ]);

  var options = {
    title: 'Company Performance',
    curveType: 'function',
    legend: { position: 'bottom' }
  };

  var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

  chart.draw(data, options);
}
</script>
<script src="{{asset('/')}}/layout/Adminjs/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+3i5q5Yl5o5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e5I5e