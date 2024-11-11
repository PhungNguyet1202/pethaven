<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Comment;
use App\Models\servicebooking;
use App\Models\Stockin;
use App\Models\Category;
use App\Models\CategoryNew;
use App\Models\News;
use App\Models\Pet;
use App\Models\Service;
use App\Models\inventory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function getAnnualRevenue($year)
    {
        try {
            // Kiểm tra giá trị của $year
            if (!$year) {
                return response()->json(['error' => 'Year is required'], 400);
            }
    
            // Tính tổng doanh thu của cả năm, chỉ bao gồm các đơn hàng có trạng thái 'success'
            $totalAnnualRevenue = Order::whereYear('created_at', $year)
                ->where('status', 'success')
                ->sum('total_money');
            
            // Ghi nhận tổng doanh thu để kiểm tra
            Log::info("Total Annual Revenue for year {$year} (status: success): {$totalAnnualRevenue}");
    
            // Tạo mảng doanh thu cho từng tháng
            $monthlyRevenue = [];
    
            // Tính doanh thu cho từng tháng, chỉ bao gồm các đơn hàng có trạng thái 'success'
            $monthlyOrders = Order::select(
                    DB::raw('MONTH(created_at) as month'),
                    DB::raw('SUM(total_money) as total_revenue')
                )
                ->whereYear('created_at', $year)
                ->where('status', 'success')
                ->groupBy(DB::raw('MONTH(created_at)'))
                ->get();
    
            // Ghi nhận doanh thu hàng tháng để kiểm tra
            Log::info("Monthly Orders for year {$year} (status: success): ", $monthlyOrders->toArray());
    
            // Gán doanh thu vào mảng theo từng tháng
            for ($month = 1; $month <= 12; $month++) {
                // Tìm doanh thu của tháng hiện tại, nếu không có thì gán 0
                $revenue = $monthlyOrders->firstWhere('month', $month);
                $monthlyRevenue[$month] = $revenue ? $revenue->total_revenue : 0;
            }
    
            // Trả về tổng doanh thu năm và doanh thu theo từng tháng dưới dạng JSON
            return response()->json([
                'total_annual_revenue' => $totalAnnualRevenue,
                'monthly_revenue' => $monthlyRevenue,
            ]);
        } catch (\Exception $e) {
            // Ghi nhận lỗi nếu có
            Log::error("Error fetching annual revenue: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function getMonthlyRevenue($year, $month)
{
    try {
        // Kiểm tra giá trị của $year và $month
        if (!$year || !$month) {
            return response()->json(['error' => 'Year and month are required'], 400);
        }

        // Kiểm tra tính hợp lệ của $month
        if ($month < 1 || $month > 12) {
            return response()->json(['error' => 'Invalid month'], 400);
        }

        // Tính tổng doanh thu của tháng và doanh thu theo từng ngày, chỉ bao gồm các đơn hàng có trạng thái 'success'
        $dailyRevenue = Order::select(
                DB::raw('DAY(created_at) as day'),
                DB::raw('SUM(total_money) as total_revenue')
            )
            ->whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->where('status', 'success')
            ->groupBy(DB::raw('DAY(created_at)'))
            ->get();

        // Tạo mảng doanh thu theo từng ngày trong tháng, mặc định là 0 cho tất cả các ngày
        $dailyRevenueArray = array_fill(1, 30, 0);

        // Gán giá trị doanh thu vào mảng tương ứng với từng ngày có doanh thu
        foreach ($dailyRevenue as $revenue) {
            $dailyRevenueArray[$revenue->day] = $revenue->total_revenue;
        }

        // Tính tổng doanh thu của tháng
        $totalMonthlyRevenue = array_sum($dailyRevenueArray);

        // Trả về tổng doanh thu tháng và doanh thu theo từng ngày dưới dạng JSON
        return response()->json([
            'total_monthly_revenue' => $totalMonthlyRevenue,
            'daily_revenue' => $dailyRevenueArray,
            'year' => $year,
            'month' => $month,
        ]);
    } catch (\Exception $e) {
        // Ghi nhận lỗi nếu có
        Log::error("Error fetching monthly revenue: " . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

   
public function getRevenueLast7Days()
{
    try {
        // Lấy ngày hôm nay và 6 ngày trước đó để tạo khoảng thời gian 7 ngày gần nhất
        $today = Carbon::today();
        $startDate = $today->copy()->subDays(6); // Ngày bắt đầu của 7 ngày gần nhất

        // Tính tổng doanh thu trong 7 ngày gần nhất, chỉ bao gồm các đơn hàng có trạng thái 'success'
        $totalWeeklyRevenue = Order::whereBetween('created_at', [$startDate, $today])
            ->where('status', 'success')
            ->sum('total_money');

        // Ghi nhận tổng doanh thu của 7 ngày để kiểm tra
        Log::info("Total Revenue for the last 7 days (status: success): {$totalWeeklyRevenue}");

        // Tạo mảng doanh thu cho từng ngày trong 7 ngày gần nhất
        $dailyRevenue = [];

        // Tính doanh thu cho từng ngày, chỉ bao gồm các đơn hàng có trạng thái 'success'
        $dailyOrders = Order::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_money) as total_revenue')
            )
            ->whereBetween('created_at', [$startDate, $today])
            ->where('status', 'success')
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('date', 'asc')
            ->get();

        // Ghi nhận doanh thu hàng ngày để kiểm tra
        Log::info("Daily Orders for the last 7 days (status: success): ", $dailyOrders->toArray());

        // Gán doanh thu vào mảng theo từng ngày
        for ($day = 0; $day < 7; $day++) {
            // Ngày hiện tại trong vòng lặp
            $currentDate = $startDate->copy()->addDays($day)->toDateString();

            // Tìm doanh thu của ngày hiện tại, nếu không có thì gán 0
            $revenue = $dailyOrders->firstWhere('date', $currentDate);
            $dailyRevenue[$currentDate] = $revenue ? $revenue->total_revenue : 0;
        }

        // Trả về tổng doanh thu 7 ngày và doanh thu theo từng ngày dưới dạng JSON
        return response()->json([
            'total_weekly_revenue' => $totalWeeklyRevenue,
            'daily_revenue' => $dailyRevenue,
        ]);
    } catch (\Exception $e) {
        // Ghi nhận lỗi nếu có
        Log::error("Error fetching weekly revenue: " . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
        //service 
        public function getAnnualServiceRevenue($year)
{
    try {
        if (!$year) {
            return response()->json(['error' => 'Year is required'], 400);
        }

        $totalAnnualRevenue = ServiceBooking::whereYear('booking_date', $year)
            ->where('status', 'success')
            ->sum('total_price');

        Log::info("Total Annual Service Revenue for year {$year} (status: success): {$totalAnnualRevenue}");

        $monthlyRevenue = [];

        $monthlyBookings = ServiceBooking::select(
                DB::raw('MONTH(booking_date) as month'),
                DB::raw('SUM(total_price) as total_revenue')
            )
            ->whereYear('booking_date', $year)
            ->where('status', 'success')
            ->groupBy(DB::raw('MONTH(booking_date)'))
            ->get();

        Log::info("Monthly Bookings for year {$year} (status: success): ", $monthlyBookings->toArray());

        for ($month = 1; $month <= 12; $month++) {
            $revenue = $monthlyBookings->firstWhere('month', $month);
            $monthlyRevenue[$month] = $revenue ? $revenue->total_revenue : 0;
        }

        return response()->json([
            'total_annual_service_revenue' => $totalAnnualRevenue,
            'monthly_revenue' => $monthlyRevenue,
        ]);
    } catch (\Exception $e) {
        Log::error("Error fetching annual service revenue: " . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

public function getMonthlyServiceRevenue($year, $month)
{
    try {
        if (!$year || !$month) {
            return response()->json(['error' => 'Year and month are required'], 400);
        }

        if ($month < 1 || $month > 12) {
            return response()->json(['error' => 'Invalid month'], 400);
        }

        $dailyRevenue = ServiceBooking::select(
                DB::raw('DAY(booking_date) as day'),
                DB::raw('SUM(total_price) as total_revenue')
            )
            ->whereYear('booking_date', $year)
            ->whereMonth('booking_date', $month)
            ->where('status', 'success')
            ->groupBy(DB::raw('DAY(booking_date)'))
            ->get();

        $dailyRevenueArray = array_fill(1, 30, 0);

        foreach ($dailyRevenue as $revenue) {
            $dailyRevenueArray[$revenue->day] = $revenue->total_revenue;
        }

        $totalMonthlyRevenue = array_sum($dailyRevenueArray);

        return response()->json([
            'total_monthly_service_revenue' => $totalMonthlyRevenue,
            'daily_revenue' => $dailyRevenueArray,
            'year' => $year,
            'month' => $month,
        ]);
    } catch (\Exception $e) {
        Log::error("Error fetching monthly service revenue: " . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

public function getServiceRevenueLast7Days()
{
    try {
        $today = Carbon::today();
        $startDate = $today->copy()->subDays(6);

        $totalWeeklyRevenue = ServiceBooking::whereBetween('booking_date', [$startDate, $today])
            ->where('status', 'success')
            ->sum('total_price');

        Log::info("Total Service Revenue for the last 7 days (status: success): {$totalWeeklyRevenue}");

        $dailyRevenue = [];

        $dailyBookings = ServiceBooking::select(
                DB::raw('DATE(booking_date) as date'),
                DB::raw('SUM(total_price) as total_revenue')
            )
            ->whereBetween('booking_date', [$startDate, $today])
            ->where('status', 'success')
            ->groupBy(DB::raw('DATE(booking_date)'))
            ->orderBy('date', 'asc')
            ->get();

        Log::info("Daily Bookings for the last 7 days (status: success): ", $dailyBookings->toArray());

        for ($day = 0; $day < 7; $day++) {
            $currentDate = $startDate->copy()->addDays($day)->toDateString();

            $revenue = $dailyBookings->firstWhere('date', $currentDate);
            $dailyRevenue[$currentDate] = $revenue ? $revenue->total_revenue : 0;
        }

        return response()->json([
            'total_weekly_service_revenue' => $totalWeeklyRevenue,
            'daily_revenue' => $dailyRevenue,
        ]);
    } catch (\Exception $e) {
        Log::error("Error fetching weekly service revenue: " . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
// tổng 
public function getTotalRevenueLast7Days()
{
    try {
        $today = Carbon::today();
        $startDate = $today->copy()->subDays(6);
        
        // Doanh thu từng ngày trong 7 ngày gần nhất
        $dailyRevenue = [];

        for ($date = $startDate; $date <= $today; $date->addDay()) {
            $orderRevenue = Order::whereDate('created_at', $date)
                ->where('status', 'success')
                ->sum('total_money');

            $serviceRevenue = ServiceBooking::whereDate('booking_date', $date)
                ->where('status', 'success')
                ->sum('total_price');

            $totalRevenue = $orderRevenue + $serviceRevenue;

            $dailyRevenue[$date->toDateString()] = $totalRevenue;
        }

        return response()->json([
            'daily_revenue_last_7_days' => $dailyRevenue,
        ]);
    } catch (\Exception $e) {
        Log::error("Error fetching daily revenue for the last 7 days: " . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

public function getTotalRevenueByDayInMonth($year, $month)
{
    try {
        if (!$year || !$month) {
            return response()->json(['error' => 'Year and month are required'], 400);
        }

        $daysInMonth = Carbon::create($year, $month)->daysInMonth;
        $dailyRevenue = [];

        for ($day = 1; $day <= $daysInMonth; $day++) {
            $date = Carbon::create($year, $month, $day);

            $orderRevenue = Order::whereDate('created_at', $date)
                ->where('status', 'success')
                ->sum('total_money');

            $serviceRevenue = ServiceBooking::whereDate('booking_date', $date)
                ->where('status', 'success')
                ->sum('total_price');

            $totalRevenue = $orderRevenue + $serviceRevenue;

            $dailyRevenue[$date->toDateString()] = $totalRevenue;
        }

        return response()->json([
            'daily_revenue_by_day_in_month' => $dailyRevenue,
        ]);
    } catch (\Exception $e) {
        Log::error("Error fetching daily revenue by day in month: " . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
}

public function getTotalRevenueByMonthInYear($year)
{
    try {
        if (!$year) {
            return response()->json(['error' => 'Year is required'], 400);
        }

        $monthlyRevenue = [];

        for ($month = 1; $month <= 12; $month++) {
            $orderRevenue = Order::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->where('status', 'success')
                ->sum('total_money');

            $serviceRevenue = ServiceBooking::whereYear('booking_date', $year)
                ->whereMonth('booking_date', $month)
                ->where('status', 'success')
                ->sum('total_price');

            $totalRevenue = $orderRevenue + $serviceRevenue;

            $monthlyRevenue[$month] = $totalRevenue;
        }

        return response()->json([
            'monthly_revenue_by_month_in_year' => $monthlyRevenue,
        ]);
    } catch (\Exception $e) {
        Log::error("Error fetching monthly revenue by month in year: " . $e->getMessage());
        return response()->json(['error' => $e->getMessage()], 500);
    }
}



    public function getTopSellingProducts()
    {
        try {
            // Truy vấn để lấy danh sách sản phẩm bán chạy cùng với tổng doanh thu, giới hạn 10 sản phẩm
            $topSellingProducts = DB::table('orderdetail')
                ->join('orders', 'orderdetail.order_id', '=', 'orders.id')
                ->join('products', 'orderdetail.product_id', '=', 'products.id')
                ->select(
                    'orderdetail.product_id',
                    'products.name',
                    DB::raw('SUM(orderdetail.quantity) as total_quantity'),
                    DB::raw('SUM(orderdetail.quantity * orderdetail.price) as total_revenue')
                )
                ->where('orders.status', 'success')
                ->groupBy('orderdetail.product_id', 'products.name')
                ->orderByDesc('total_revenue')
                ->limit(10)
                ->get();
    
            // Ghi nhận danh sách sản phẩm bán chạy để kiểm tra
            Log::info("Top Selling Products: ", $topSellingProducts->toArray());
    
            // Trả về danh sách sản phẩm bán chạy dưới dạng JSON
            return response()->json([
                'top_selling_products' => $topSellingProducts,
            ]);
        } catch (\Exception $e) {
            // Ghi nhận lỗi nếu có
            Log::error("Error fetching top selling products: " . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
    
    
}