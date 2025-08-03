<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\UserProfile;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the user dashboard based on their role.
     */
    public function index()
    {
        $user = auth()->user();
        $profile = UserProfile::where('user_id', $user->id)->first();
        
        if (!$profile) {
            // Create a default customer profile
            $profile = UserProfile::create([
                'user_id' => $user->id,
                'role' => 'customer',
                'is_verified' => false,
            ]);
        }

        $wallet = Wallet::where('user_id', $user->id)->first();

        switch ($profile->role) {
            case 'customer':
                return $this->customerDashboard($user, $wallet);
            case 'driver':
                return $this->driverDashboard($user, $profile, $wallet);
            case 'merchant':
                return $this->merchantDashboard($user, $wallet);
            case 'admin':
            case 'super_admin':
                return $this->adminDashboard();
            default:
                return $this->customerDashboard($user, $wallet);
        }
    }

    /**
     * Customer dashboard.
     */
    protected function customerDashboard($user, $wallet)
    {
        $recentOrders = Order::where('customer_id', $user->id)
            ->with(['serviceCategory', 'vehicleType'])
            ->latest()
            ->limit(5)
            ->get();

        $stats = [
            'total_orders' => Order::where('customer_id', $user->id)->count(),
            'completed_orders' => Order::where('customer_id', $user->id)->where('status', 'completed')->count(),
            'wallet_balance' => $wallet ? $wallet->balance : 0,
        ];

        return Inertia::render('dashboard/customer', [
            'recentOrders' => $recentOrders,
            'stats' => $stats,
        ]);
    }

    /**
     * Driver dashboard.
     */
    protected function driverDashboard($user, $profile, $wallet)
    {
        $recentOrders = Order::where('driver_id', $user->id)
            ->with(['serviceCategory', 'customer'])
            ->latest()
            ->limit(5)
            ->get();

        $stats = [
            'total_orders' => Order::where('driver_id', $user->id)->count(),
            'completed_orders' => Order::where('driver_id', $user->id)->where('status', 'completed')->count(),
            'wallet_balance' => $wallet ? $wallet->balance : 0,
            'is_online' => $profile->is_online,
            'rating' => 4.8, // TODO: Calculate from ratings
        ];

        return Inertia::render('dashboard/driver', [
            'recentOrders' => $recentOrders,
            'stats' => $stats,
        ]);
    }

    /**
     * Merchant dashboard.
     */
    protected function merchantDashboard($user, $wallet)
    {
        $recentOrders = Order::where('merchant_id', $user->id)
            ->with(['serviceCategory', 'customer'])
            ->latest()
            ->limit(5)
            ->get();

        $stats = [
            'total_orders' => Order::where('merchant_id', $user->id)->count(),
            'completed_orders' => Order::where('merchant_id', $user->id)->where('status', 'completed')->count(),
            'wallet_balance' => $wallet ? $wallet->balance : 0,
            'rating' => 4.7, // TODO: Calculate from ratings
        ];

        return Inertia::render('dashboard/merchant', [
            'recentOrders' => $recentOrders,
            'stats' => $stats,
        ]);
    }

    /**
     * Admin dashboard.
     */
    protected function adminDashboard()
    {
        $stats = [
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'total_users' => UserProfile::count(),
            'active_drivers' => UserProfile::whereRole('driver')->whereOnline()->count(),
        ];

        return Inertia::render('dashboard/admin', [
            'stats' => $stats,
        ]);
    }
}