<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use App\Models\VehicleType;
use App\Models\Order;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TransportationController extends Controller
{
    /**
     * Display the main transportation app homepage.
     */
    public function index()
    {
        $serviceCategories = ServiceCategory::active()->get();
        $vehicleTypes = VehicleType::active()->get();
        
        // Get some statistics for the homepage
        $stats = [
            'total_orders' => Order::count(),
            'active_drivers' => UserProfile::whereRole('driver')->whereOnline()->count(),
            'total_merchants' => UserProfile::whereRole('merchant')->whereVerified()->count(),
            'service_categories' => $serviceCategories->count(),
        ];

        return Inertia::render('welcome', [
            'serviceCategories' => $serviceCategories,
            'vehicleTypes' => $vehicleTypes,
            'stats' => $stats,
        ]);
    }

    /**
     * Display the order booking page.
     */
    public function create()
    {
        $serviceCategories = ServiceCategory::active()->get();
        $vehicleTypes = VehicleType::active()->get();

        return Inertia::render('order/create', [
            'serviceCategories' => $serviceCategories,
            'vehicleTypes' => $vehicleTypes,
        ]);
    }

    /**
     * Store a new order.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'service_category_id' => 'required|exists:service_categories,id',
            'vehicle_type_id' => 'required|exists:vehicle_types,id',
            'pickup_address' => 'required|string|max:255',
            'pickup_latitude' => 'required|numeric',
            'pickup_longitude' => 'required|numeric',
            'destination_address' => 'required|string|max:255',
            'destination_latitude' => 'required|numeric',
            'destination_longitude' => 'required|numeric',
            'notes' => 'nullable|string|max:500',
        ]);

        // Calculate pricing based on service category
        $serviceCategory = ServiceCategory::findOrFail($validated['service_category_id']);
        $vehicleType = VehicleType::findOrFail($validated['vehicle_type_id']);
        
        // Calculate distance (simplified - in real app use Google Maps API)
        $distance = $this->calculateDistance(
            $validated['pickup_latitude'], 
            $validated['pickup_longitude'],
            $validated['destination_latitude'], 
            $validated['destination_longitude']
        );

        $baseFare = $serviceCategory->base_fare;
        $distanceFare = $distance * $serviceCategory->price_per_km * $vehicleType->price_multiplier;
        $subtotal = $baseFare + $distanceFare;
        $total = max($subtotal, $serviceCategory->minimum_fare);

        $order = Order::create([
            'order_number' => 'TRX-' . strtoupper(uniqid()),
            'customer_id' => auth()->id(),
            'service_category_id' => $validated['service_category_id'],
            'vehicle_type_id' => $validated['vehicle_type_id'],
            'pickup_address' => $validated['pickup_address'],
            'pickup_latitude' => $validated['pickup_latitude'],
            'pickup_longitude' => $validated['pickup_longitude'],
            'destination_address' => $validated['destination_address'],
            'destination_latitude' => $validated['destination_latitude'],
            'destination_longitude' => $validated['destination_longitude'],
            'distance_km' => $distance,
            'base_fare' => $baseFare,
            'distance_fare' => $distanceFare,
            'subtotal' => $subtotal,
            'total_amount' => $total,
            'commission_amount' => $total * ($serviceCategory->commission_rate / 100),
            'notes' => $validated['notes'],
        ]);

        return redirect()->route('orders.show', $order)
            ->with('success', 'Order created successfully! Looking for available drivers...');
    }

    /**
     * Calculate distance between two coordinates (simplified Haversine formula).
     */
    protected function calculateDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // Earth radius in kilometers

        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLon/2) * sin($dLon/2);
        $c = 2 * asin(sqrt($a));

        return round($earthRadius * $c, 2);
    }
}