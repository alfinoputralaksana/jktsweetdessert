<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ForecastingController extends Controller
{
    public function index()
    {
        $products = Product::where('is_active', true)->get();
        $forecasts = [];

        foreach ($products as $product) {
            // Get sales data for last 12 months
            $salesData = OrderItem::where('product_id', $product->id)
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->where('orders.payment_status', 'paid')
                ->select(
                    DB::raw('MONTH(orders.created_at) as month'),
                    DB::raw('YEAR(orders.created_at) as year'),
                    DB::raw('SUM(order_items.quantity) as total_sold')
                )
                ->groupBy('year', 'month')
                ->orderBy('year', 'asc')
                ->orderBy('month', 'asc')
                ->limit(12)
                ->get();

            // Check if there's any sales data
            if ($salesData->count() > 0) {
                $salesValues = $salesData->pluck('total_sold')->toArray();
                
                // Use period based on available data (minimum 1, maximum 3)
                $period = min($salesData->count(), 3);
                $forecast = $this->calculateSMA($salesValues, $period);
                
                // If forecast is 0 but we have sales data, use average of all available data
                if ($forecast == 0 && count($salesValues) > 0) {
                    $forecast = round(array_sum($salesValues) / count($salesValues), 2);
                }
                
                $forecasts[] = [
                    'product' => $product,
                    'current_sales' => $salesData->last()->total_sold ?? 0,
                    'forecast' => $forecast,
                    'trend' => $forecast > ($salesData->last()->total_sold ?? 0) ? 'up' : 'down',
                    'sales_data' => $salesData,
                    'data_months' => $salesData->count(),
                    'is_accurate' => $salesData->count() >= 3, // Flag to show if forecast is accurate
                ];
            }
        }

        // Sort by forecast value descending
        usort($forecasts, function($a, $b) {
            return $b['forecast'] <=> $a['forecast'];
        });

        return view('forecasting.index', compact('forecasts'));
    }

    private function calculateSMA($values, $period)
    {
        if (count($values) < $period) {
            return 0;
        }

        $sum = 0;
        for ($i = count($values) - $period; $i < count($values); $i++) {
            $sum += $values[$i];
        }

        return round($sum / $period, 2);
    }

    public function show($id)
    {
        $product = Product::findOrFail($id);

        // Get sales data for last 12 months
        $salesData = OrderItem::where('product_id', $product->id)
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.payment_status', 'paid')
            ->select(
                DB::raw('MONTH(orders.created_at) as month'),
                DB::raw('YEAR(orders.created_at) as year'),
                DB::raw('SUM(order_items.quantity) as total_sold')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->limit(12)
            ->get();

        $salesValues = $salesData->pluck('total_sold')->toArray();
        
        // Use period based on available data (minimum 1, maximum 3)
        $period = min($salesData->count(), 3);
        $forecast = $this->calculateSMA($salesValues, $period);
        
        // If forecast is 0 but we have sales data, use average of all available data
        if ($forecast == 0 && count($salesValues) > 0) {
            $forecast = round(array_sum($salesValues) / count($salesValues), 2);
        }
        
        $isAccurate = $salesData->count() >= 3;

        return view('forecasting.show', compact('product', 'salesData', 'forecast', 'isAccurate'));
    }

    /**
     * Get top products based on forecasting (for public display)
     * Returns top products sorted by total sales
     */
    public static function getTopProducts($limit = 6)
    {
        $products = Product::where('is_active', true)->get();
        $topProducts = [];

        foreach ($products as $product) {
            // Get total sold count
            $totalSold = OrderItem::where('product_id', $product->id)
                ->join('orders', 'order_items.order_id', '=', 'orders.id')
                ->where('orders.payment_status', 'paid')
                ->sum('order_items.quantity');

            if ($totalSold > 0) {
                $topProducts[] = [
                    'product' => $product,
                    'total_sold' => $totalSold,
                ];
            }
        }

        // Sort by total sold descending
        usort($topProducts, function($a, $b) {
            return $b['total_sold'] <=> $a['total_sold'];
        });

        // Return top N products
        return array_slice($topProducts, 0, $limit);
    }
}
