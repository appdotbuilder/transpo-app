import React, { useState } from 'react';
import { Head, Link, useForm } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import { Button } from '@/components/ui/button';

interface ServiceCategory {
    id: number;
    name: string;
    slug: string;
}

interface VehicleType {
    id: number;
    name: string;
    slug: string;
}

interface User {
    id: number;
    name: string;
    email: string;
}

interface Product {
    id: number;
    name: string;
    price: number;
}

interface OrderItem {
    id: number;
    quantity: number;
    unit_price: number;
    total_price: number;
    product: Product;
}

interface Order {
    id: number;
    order_number: string;
    status: string;
    pickup_address: string;
    destination_address: string;
    pickup_latitude: number;
    pickup_longitude: number;
    destination_latitude: number;
    destination_longitude: number;
    distance_km: number | null;
    estimated_duration_minutes: number | null;
    base_fare: number;
    distance_fare: number;
    time_fare: number;
    subtotal: number;
    discount_amount: number;
    total_amount: number;
    notes: string | null;
    created_at: string;
    accepted_at: string | null;
    picked_up_at: string | null;
    delivered_at: string | null;
    completed_at: string | null;
    cancelled_at: string | null;
    cancellation_reason: string | null;
    service_category: ServiceCategory;
    vehicle_type: VehicleType;
    driver: User | null;
    merchant: User | null;
    items: OrderItem[];
}

interface Props {
    order: Order;
    [key: string]: unknown;
}

const statusColors: Record<string, string> = {
    pending: 'bg-yellow-100 text-yellow-800 border-yellow-200',
    accepted: 'bg-blue-100 text-blue-800 border-blue-200',
    picked_up: 'bg-indigo-100 text-indigo-800 border-indigo-200',
    in_transit: 'bg-purple-100 text-purple-800 border-purple-200',
    delivered: 'bg-green-100 text-green-800 border-green-200',
    completed: 'bg-green-100 text-green-800 border-green-200',
    cancelled: 'bg-red-100 text-red-800 border-red-200',
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

export default function OrderShow({ order }: Props) {
    const [showCancelForm, setShowCancelForm] = useState(false);
    
    const { data, setData, patch, processing } = useForm({
        status: 'cancelled',
        cancellation_reason: '',
    });

    const formatDate = (dateString: string | null) => {
        if (!dateString) return 'Not set';
        return new Date(dateString).toLocaleDateString('en-US', {
            year: 'numeric',
            month: 'short',
            day: 'numeric',
            hour: '2-digit',
            minute: '2-digit',
        });
    };

    const handleCancelOrder = (e: React.FormEvent) => {
        e.preventDefault();
        patch(route('orders.update', order.id), {
            onSuccess: () => {
                setShowCancelForm(false);
            }
        });
    };

    const canCancel = order.status === 'pending';

    return (
        <AppShell>
            <Head title={`Order ${order.order_number} - TransGo`} />
            
            <div className="max-w-4xl mx-auto p-6">
                <div className="flex justify-between items-start mb-8">
                    <div>
                        <Link 
                            href="/orders" 
                            className="text-blue-600 hover:text-blue-700 text-sm font-medium mb-2 inline-block"
                        >
                            ← Back to Orders
                        </Link>
                        <h1 className="text-3xl font-bold text-gray-900 mb-2">
                            Order {order.order_number}
                        </h1>
                        <div className={`inline-flex items-center gap-2 px-4 py-2 rounded-xl border-2 font-medium ${statusColors[order.status]}`}>
                            <span>{statusIcons[order.status]}</span>
                            <span className="capitalize">{order.status.replace('_', ' ')}</span>
                        </div>
                    </div>
                    
                    {canCancel && (
                        <Button
                            variant="outline"
                            onClick={() => setShowCancelForm(true)}
                            className="border-red-200 text-red-600 hover:bg-red-50"
                        >
                            ❌ Cancel Order
                        </Button>
                    )}
                </div>

                {/* Cancel Order Form */}
                {showCancelForm && (
                    <div className="bg-red-50 border border-red-200 rounded-xl p-6 mb-6">
                        <h3 className="text-lg font-semibold text-red-900 mb-4">
                            Cancel Order
                        </h3>
                        <form onSubmit={handleCancelOrder}>
                            <div className="mb-4">
                                <label className="block text-sm font-medium text-red-700 mb-2">
                                    Reason for cancellation
                                </label>
                                <textarea
                                    rows={3}
                                    value={data.cancellation_reason}
                                    onChange={(e) => setData('cancellation_reason', e.target.value)}
                                    className="w-full px-3 py-2 border border-red-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                    placeholder="Please provide a reason for cancellation..."
                                    required
                                />
                            </div>
                            <div className="flex gap-3">
                                <Button
                                    type="submit"
                                    disabled={processing}
                                    className="bg-red-600 hover:bg-red-700"
                                >
                                    {processing ? 'Cancelling...' : 'Confirm Cancellation'}
                                </Button>
                                <Button
                                    type="button"
                                    variant="outline"
                                    onClick={() => setShowCancelForm(false)}
                                >
                                    Keep Order
                                </Button>
                            </div>
                        </form>
                    </div>
                )}

                <div className="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    {/* Main Order Details */}
                    <div className="lg:col-span-2 space-y-6">
                        {/* Service Details */}
                        <div className="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                            <h2 className="text-xl font-semibold text-gray-900 mb-4">
                                🎯 Service Details
                            </h2>
                            <div className="flex items-center gap-4 mb-4">
                                <div className="text-4xl">
                                    {serviceIcons[order.service_category.slug] || '🚀'}
                                </div>
                                <div>
                                    <h3 className="font-semibold text-gray-900 capitalize">
                                        {order.service_category.name}
                                    </h3>
                                    <p className="text-gray-600 capitalize">
                                        {order.vehicle_type.name}
                                    </p>
                                </div>
                            </div>
                            {order.notes && (
                                <div className="bg-gray-50 rounded-lg p-3">
                                    <p className="text-sm text-gray-700">
                                        <strong>Notes:</strong> {order.notes}
                                    </p>
                                </div>
                            )}
                        </div>

                        {/* Location Details */}
                        <div className="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                            <h2 className="text-xl font-semibold text-gray-900 mb-4">
                                📍 Location Details
                            </h2>
                            <div className="space-y-4">
                                <div>
                                    <h4 className="font-medium text-gray-900 mb-1">Pickup Location</h4>
                                    <p className="text-gray-600">{order.pickup_address}</p>
                                </div>
                                <div className="border-l-4 border-blue-300 pl-4">
                                    <h4 className="font-medium text-gray-900 mb-1">Destination</h4>
                                    <p className="text-gray-600">{order.destination_address}</p>
                                </div>
                                {order.distance_km && (
                                    <div className="grid grid-cols-2 gap-4 bg-gray-50 rounded-lg p-3">
                                        <div>
                                            <p className="text-sm text-gray-500">Distance</p>
                                            <p className="font-medium text-gray-900">{order.distance_km} km</p>
                                        </div>
                                        {order.estimated_duration_minutes && (
                                            <div>
                                                <p className="text-sm text-gray-500">Duration</p>
                                                <p className="font-medium text-gray-900">{order.estimated_duration_minutes} min</p>
                                            </div>
                                        )}
                                    </div>
                                )}
                            </div>
                        </div>

                        {/* Driver/Merchant Info */}
                        {(order.driver || order.merchant) && (
                            <div className="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                                <h2 className="text-xl font-semibold text-gray-900 mb-4">
                                    👥 Service Provider
                                </h2>
                                <div className="space-y-3">
                                    {order.driver && (
                                        <div className="flex items-center gap-3">
                                            <div className="text-2xl">👨‍✈️</div>
                                            <div>
                                                <p className="font-medium text-gray-900">{order.driver.name}</p>
                                                <p className="text-sm text-gray-600">Driver</p>
                                            </div>
                                        </div>
                                    )}
                                    {order.merchant && (
                                        <div className="flex items-center gap-3">
                                            <div className="text-2xl">🏪</div>
                                            <div>
                                                <p className="font-medium text-gray-900">{order.merchant.name}</p>
                                                <p className="text-sm text-gray-600">Merchant</p>
                                            </div>
                                        </div>
                                    )}
                                </div>
                            </div>
                        )}

                        {/* Order Items (for food/shop orders) */}
                        {order.items.length > 0 && (
                            <div className="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                                <h2 className="text-xl font-semibold text-gray-900 mb-4">
                                    🛍️ Order Items
                                </h2>
                                <div className="space-y-3">
                                    {order.items.map((item) => (
                                        <div key={item.id} className="flex justify-between items-center py-2 border-b border-gray-100 last:border-b-0">
                                            <div>
                                                <p className="font-medium text-gray-900">{item.product.name}</p>
                                                <p className="text-sm text-gray-600">Qty: {item.quantity}</p>
                                            </div>
                                            <p className="font-medium text-gray-900">
                                                Rp {item.total_price.toLocaleString()}
                                            </p>
                                        </div>
                                    ))}
                                </div>
                            </div>
                        )}
                    </div>

                    {/* Sidebar */}
                    <div className="space-y-6">
                        {/* Fare Breakdown */}
                        <div className="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                            <h3 className="text-lg font-semibold text-gray-900 mb-4">
                                💰 Fare Breakdown
                            </h3>
                            <div className="space-y-3">
                                <div className="flex justify-between">
                                    <span className="text-gray-600">Base Fare</span>
                                    <span className="text-gray-900">Rp {order.base_fare.toLocaleString()}</span>
                                </div>
                                <div className="flex justify-between">
                                    <span className="text-gray-600">Distance Fare</span>
                                    <span className="text-gray-900">Rp {order.distance_fare.toLocaleString()}</span>
                                </div>
                                {order.time_fare > 0 && (
                                    <div className="flex justify-between">
                                        <span className="text-gray-600">Time Fare</span>
                                        <span className="text-gray-900">Rp {order.time_fare.toLocaleString()}</span>
                                    </div>
                                )}
                                <div className="flex justify-between">
                                    <span className="text-gray-600">Subtotal</span>
                                    <span className="text-gray-900">Rp {order.subtotal.toLocaleString()}</span>
                                </div>
                                {order.discount_amount > 0 && (
                                    <div className="flex justify-between text-green-600">
                                        <span>Discount</span>
                                        <span>-Rp {order.discount_amount.toLocaleString()}</span>
                                    </div>
                                )}
                                <div className="border-t pt-3">
                                    <div className="flex justify-between text-lg font-semibold">
                                        <span className="text-gray-900">Total</span>
                                        <span className="text-blue-600">Rp {order.total_amount.toLocaleString()}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {/* Timeline */}
                        <div className="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                            <h3 className="text-lg font-semibold text-gray-900 mb-4">
                                ⏰ Order Timeline
                            </h3>
                            <div className="space-y-4">
                                <div className="flex items-start gap-3">
                                    <div className="text-lg">📅</div>
                                    <div>
                                        <p className="font-medium text-gray-900">Order Created</p>
                                        <p className="text-sm text-gray-600">{formatDate(order.created_at)}</p>
                                    </div>
                                </div>
                                
                                {order.accepted_at && (
                                    <div className="flex items-start gap-3">
                                        <div className="text-lg">✅</div>
                                        <div>
                                            <p className="font-medium text-gray-900">Order Accepted</p>
                                            <p className="text-sm text-gray-600">{formatDate(order.accepted_at)}</p>
                                        </div>
                                    </div>
                                )}
                                
                                {order.picked_up_at && (
                                    <div className="flex items-start gap-3">
                                        <div className="text-lg">📦</div>
                                        <div>
                                            <p className="font-medium text-gray-900">Picked Up</p>
                                            <p className="text-sm text-gray-600">{formatDate(order.picked_up_at)}</p>
                                        </div>
                                    </div>
                                )}
                                
                                {order.delivered_at && (
                                    <div className="flex items-start gap-3">
                                        <div className="text-lg">🎯</div>
                                        <div>
                                            <p className="font-medium text-gray-900">Delivered</p>
                                            <p className="text-sm text-gray-600">{formatDate(order.delivered_at)}</p>
                                        </div>
                                    </div>
                                )}
                                
                                {order.completed_at && (
                                    <div className="flex items-start gap-3">
                                        <div className="text-lg">✨</div>
                                        <div>
                                            <p className="font-medium text-gray-900">Completed</p>
                                            <p className="text-sm text-gray-600">{formatDate(order.completed_at)}</p>
                                        </div>
                                    </div>
                                )}
                                
                                {order.cancelled_at && (
                                    <div className="flex items-start gap-3">
                                        <div className="text-lg">❌</div>
                                        <div>
                                            <p className="font-medium text-red-600">Cancelled</p>
                                            <p className="text-sm text-gray-600">{formatDate(order.cancelled_at)}</p>
                                            {order.cancellation_reason && (
                                                <p className="text-sm text-red-600 mt-1">
                                                    Reason: {order.cancellation_reason}
                                                </p>
                                            )}
                                        </div>
                                    </div>
                                )}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </AppShell>
    );
}