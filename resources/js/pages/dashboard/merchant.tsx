import React from 'react';
import { Head } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import { Button } from '@/components/ui/button';

interface Order {
    id: number;
    order_number: string;
    status: string;
    total_amount: number;
    created_at: string;
    service_category: {
        name: string;
        slug: string;
    };
    customer: {
        name: string;
    };
}

interface Stats {
    total_orders: number;
    completed_orders: number;
    wallet_balance: number;
    rating: number;
}

interface Props {
    recentOrders: Order[];
    stats: Stats;
    [key: string]: unknown;
}

export default function MerchantDashboard({ recentOrders, stats }: Props) {
    return (
        <AppShell>
            <Head title="Merchant Dashboard - TransGo" />
            
            <div className="max-w-6xl mx-auto p-6">
                <div className="mb-8">
                    <h1 className="text-3xl font-bold text-gray-900 mb-2">
                        🏪 Merchant Dashboard
                    </h1>
                    <p className="text-gray-600">
                        Manage your products and track your sales
                    </p>
                </div>

                {/* Stats Cards */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div className="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm text-gray-600 mb-1">Total Orders</p>
                                <p className="text-2xl font-bold text-gray-900">{stats.total_orders}</p>
                            </div>
                            <div className="text-3xl">📊</div>
                        </div>
                    </div>
                    
                    <div className="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm text-gray-600 mb-1">Completed</p>
                                <p className="text-2xl font-bold text-green-600">{stats.completed_orders}</p>
                            </div>
                            <div className="text-3xl">✅</div>
                        </div>
                    </div>
                    
                    <div className="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm text-gray-600 mb-1">Rating</p>
                                <p className="text-2xl font-bold text-yellow-600">{stats.rating} ⭐</p>
                            </div>
                            <div className="text-3xl">⭐</div>
                        </div>
                    </div>
                    
                    <div className="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm text-gray-600 mb-1">Revenue</p>
                                <p className="text-2xl font-bold text-green-600">Rp {stats.wallet_balance.toLocaleString()}</p>
                            </div>
                            <div className="text-3xl">💰</div>
                        </div>
                    </div>
                </div>

                {/* Quick Actions */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <Button className="w-full h-16 text-lg bg-blue-600 hover:bg-blue-700">
                        📦 New Order
                    </Button>
                    <Button variant="outline" className="w-full h-16 text-lg">
                        🍔 Manage Menu
                    </Button>
                    <Button variant="outline" className="w-full h-16 text-lg">
                        💳 My Wallet
                    </Button>
                    <Button variant="outline" className="w-full h-16 text-lg">
                        ⭐ Reviews
                    </Button>
                </div>

                {/* Recent Orders */}
                <div className="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                    <h2 className="text-xl font-semibold text-gray-900 mb-6">
                        📋 Recent Orders
                    </h2>

                    {recentOrders.length === 0 ? (
                        <div className="text-center py-8">
                            <div className="text-4xl mb-4">📦</div>
                            <p className="text-gray-600">No recent orders</p>
                        </div>
                    ) : (
                        <div className="space-y-4">
                            {recentOrders.map((order) => (
                                <div key={order.id} className="border border-gray-200 rounded-lg p-4">
                                    <div className="flex justify-between items-center">
                                        <div>
                                            <h3 className="font-medium text-gray-900">{order.order_number}</h3>
                                            <p className="text-sm text-gray-600">
                                                Customer: {order.customer.name}
                                            </p>
                                            <p className="text-sm text-gray-600 capitalize">
                                                {order.service_category.name} • {order.status}
                                            </p>
                                        </div>
                                        <div className="text-right">
                                            <p className="font-medium text-gray-900">Rp {order.total_amount.toLocaleString()}</p>
                                            <p className="text-sm text-gray-600">
                                                {new Date(order.created_at).toLocaleDateString()}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    )}
                </div>
            </div>
        </AppShell>
    );
}