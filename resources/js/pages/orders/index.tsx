import React from 'react';
import { Head, Link } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import { Button } from '@/components/ui/button';

interface ServiceCategory {
    id: number;
    name: string;
    slug: string;
    icon: string | null;
}

interface VehicleType {
    id: number;
    name: string;
    slug: string;
    icon: string | null;
}

interface User {
    id: number;
    name: string;
    email: string;
}

interface Order {
    id: number;
    order_number: string;
    status: string;
    pickup_address: string;
    destination_address: string;
    total_amount: number;
    created_at: string;
    service_category: ServiceCategory;
    vehicle_type: VehicleType;
    driver: User | null;
    merchant: User | null;
}

interface PaginatedOrders {
    data: Order[];
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
    next_page_url: string | null;
    prev_page_url: string | null;
}

interface Props {
    orders: PaginatedOrders;
    [key: string]: unknown;
}

const statusColors: Record<string, string> = {
    pending: 'bg-yellow-100 text-yellow-800',
    accepted: 'bg-blue-100 text-blue-800',
    picked_up: 'bg-indigo-100 text-indigo-800',
    in_transit: 'bg-purple-100 text-purple-800',
    delivered: 'bg-green-100 text-green-800',
    completed: 'bg-green-100 text-green-800',
    cancelled: 'bg-red-100 text-red-800',
};

const statusIcons: Record<string, string> = {
    pending: '⏳',
    accepted: '✅',
    picked_up: '📦',
    in_transit: '🚗',
    delivered: '🎯',
    completed: '✨',
    cancelled: '❌',
};

const serviceIcons: Record<string, string> = {
    taxi: '🚗',
    send: '📦',
    rent: '🚙',
    food: '🍔',
    shop: '🛍️',
};

export default function OrdersIndex({ orders }: Props) {
    const formatDate = (dateString: string) => {
        return new Date(dateString).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
        });
    };

    return (
        <AppShell>
            <Head title="My Orders - TransGo" />
            
            <div className="max-w-6xl mx-auto p-6">
                <div className="flex justify-between items-center mb-8">
                    <div>
                        <h1 className="text-3xl font-bold text-gray-900 mb-2">
                            📋 My Orders
                        </h1>
                        <p className="text-gray-600">
                            Track your transportation bookings and history
                        </p>
                    </div>
                    <Link href="/order/create">
                        <Button className="bg-blue-600 hover:bg-blue-700">
                            📱 Book New Ride
                        </Button>
                    </Link>
                </div>

                {orders.data.length === 0 ? (
                    <div className="text-center py-16">
                        <div className="text-6xl mb-4">🚗</div>
                        <h2 className="text-2xl font-bold text-gray-900 mb-2">
                            No orders yet
                        </h2>
                        <p className="text-gray-600 mb-6">
                            Start by booking your first ride with TransGo
                        </p>
                        <Link href="/order/create">
                            <Button size="lg" className="bg-blue-600 hover:bg-blue-700">
                                🚀 Book Your First Ride
                            </Button>
                        </Link>
                    </div>
                ) : (
                    <div className="space-y-4">
                        {orders.data.map((order) => (
                            <div
                                key={order.id}
                                className="bg-white rounded-xl shadow-md hover:shadow-lg transition-shadow duration-200 p-6 border border-gray-100"
                            >
                                <div className="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                                    <div className="flex-1">
                                        <div className="flex items-center gap-3 mb-3">
                                            <div className="text-2xl">
                                                {serviceIcons[order.service_category.slug] || '🚀'}
                                            </div>
                                            <div>
                                                <h3 className="font-semibold text-gray-900">
                                                    {order.order_number}
                                                </h3>
                                                <p className="text-sm text-gray-600 capitalize">
                                                    {order.service_category.name} • {order.vehicle_type.name}
                                                </p>
                                            </div>
                                            <span className={`px-3 py-1 rounded-full text-xs font-medium ${statusColors[order.status]}`}>
                                                {statusIcons[order.status]} {order.status.replace('_', ' ')}
                                            </span>
                                        </div>

                                        <div className="grid grid-cols-1 md:grid-cols-2 gap-4 mb-3">
                                            <div>
                                                <p className="text-sm text-gray-500 mb-1">📍 Pickup</p>
                                                <p className="text-sm text-gray-900 line-clamp-2">
                                                    {order.pickup_address}
                                                </p>
                                            </div>
                                            <div>
                                                <p className="text-sm text-gray-500 mb-1">🎯 Destination</p>
                                                <p className="text-sm text-gray-900 line-clamp-2">
                                                    {order.destination_address}
                                                </p>
                                            </div>
                                        </div>

                                        <div className="flex items-center gap-4 text-sm text-gray-600">
                                            <span>📅 {formatDate(order.created_at)}</span>
                                            {order.driver && (
                                                <span>👨‍✈️ {order.driver.name}</span>
                                            )}
                                            {order.merchant && (
                                                <span>🏪 {order.merchant.name}</span>
                                            )}
                                        </div>
                                    </div>

                                    <div className="flex items-center gap-4">
                                        <div className="text-right">
                                            <p className="text-sm text-gray-500 mb-1">Total Fare</p>
                                            <p className="text-2xl font-bold text-gray-900">
                                                Rp {order.total_amount.toLocaleString()}
                                            </p>
                                        </div>
                                        <Link href={`/orders/${order.id}`}>
                                            <Button variant="outline" size="sm">
                                                View Details
                                            </Button>
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        ))}

                        {/* Pagination */}
                        {orders.last_page > 1 && (
                            <div className="flex justify-center items-center gap-4 mt-8">
                                {orders.prev_page_url && (
                                    <Link href={orders.prev_page_url}>
                                        <Button variant="outline">← Previous</Button>
                                    </Link>
                                )}
                                
                                <span className="text-sm text-gray-600">
                                    Page {orders.current_page} of {orders.last_page}
                                </span>
                                
                                {orders.next_page_url && (
                                    <Link href={orders.next_page_url}>
                                        <Button variant="outline">Next →</Button>
                                    </Link>
                                )}
                            </div>
                        )}
                    </div>
                )}
            </div>
        </AppShell>
    );
}