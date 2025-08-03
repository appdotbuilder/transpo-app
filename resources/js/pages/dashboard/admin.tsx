import React from 'react';
import { Head } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import { Button } from '@/components/ui/button';

interface Stats {
    total_orders: number;
    pending_orders: number;
    total_users: number;
    active_drivers: number;
}

interface Props {
    stats: Stats;
    [key: string]: unknown;
}

export default function AdminDashboard({ stats }: Props) {
    return (
        <AppShell>
            <Head title="Admin Dashboard - TransGo" />
            
            <div className="max-w-6xl mx-auto p-6">
                <div className="mb-8">
                    <h1 className="text-3xl font-bold text-gray-900 mb-2">
                        🛡️ Admin Dashboard
                    </h1>
                    <p className="text-gray-600">
                        Manage the transportation platform and monitor system health
                    </p>
                </div>

                {/* Stats Cards */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <div className="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm text-gray-600 mb-1">Total Orders</p>
                                <p className="text-2xl font-bold text-gray-900">{stats.total_orders.toLocaleString()}</p>
                            </div>
                            <div className="text-3xl">📊</div>
                        </div>
                    </div>
                    
                    <div className="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm text-gray-600 mb-1">Pending Orders</p>
                                <p className="text-2xl font-bold text-yellow-600">{stats.pending_orders}</p>
                            </div>
                            <div className="text-3xl">⏳</div>
                        </div>
                    </div>
                    
                    <div className="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm text-gray-600 mb-1">Total Users</p>
                                <p className="text-2xl font-bold text-blue-600">{stats.total_users.toLocaleString()}</p>
                            </div>
                            <div className="text-3xl">👥</div>
                        </div>
                    </div>
                    
                    <div className="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                        <div className="flex items-center justify-between">
                            <div>
                                <p className="text-sm text-gray-600 mb-1">Active Drivers</p>
                                <p className="text-2xl font-bold text-green-600">{stats.active_drivers}</p>
                            </div>
                            <div className="text-3xl">🚗</div>
                        </div>
                    </div>
                </div>

                {/* Quick Actions */}
                <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
                    <Button className="w-full h-16 text-lg bg-blue-600 hover:bg-blue-700">
                        👥 User Management
                    </Button>
                    <Button variant="outline" className="w-full h-16 text-lg">
                        📋 Order Management
                    </Button>
                    <Button variant="outline" className="w-full h-16 text-lg">
                        🎯 Service Config
                    </Button>
                    <Button variant="outline" className="w-full h-16 text-lg">
                        📊 Reports
                    </Button>
                </div>

                {/* Management Sections */}
                <div className="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div className="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                        <h2 className="text-xl font-semibold text-gray-900 mb-4">
                            🎯 Service Management
                        </h2>
                        <div className="space-y-3">
                            <Button variant="outline" className="w-full justify-start">
                                🚗 Service Categories
                            </Button>
                            <Button variant="outline" className="w-full justify-start">
                                🚙 Vehicle Types
                            </Button>
                            <Button variant="outline" className="w-full justify-start">
                                💰 Pricing Config
                            </Button>
                            <Button variant="outline" className="w-full justify-start">
                                📍 Service Areas
                            </Button>
                        </div>
                    </div>

                    <div className="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                        <h2 className="text-xl font-semibold text-gray-900 mb-4">
                            👥 User Management
                        </h2>
                        <div className="space-y-3">
                            <Button variant="outline" className="w-full justify-start">
                                👤 Customers
                            </Button>
                            <Button variant="outline" className="w-full justify-start">
                                👨‍✈️ Drivers
                            </Button>
                            <Button variant="outline" className="w-full justify-start">
                                🏪 Merchants
                            </Button>
                            <Button variant="outline" className="w-full justify-start">
                                🛡️ Admins
                            </Button>
                        </div>
                    </div>

                    <div className="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                        <h2 className="text-xl font-semibold text-gray-900 mb-4">
                            💳 Financial Management
                        </h2>
                        <div className="space-y-3">
                            <Button variant="outline" className="w-full justify-start">
                                💰 Wallet Management
                            </Button>
                            <Button variant="outline" className="w-full justify-start">
                                📊 Revenue Reports
                            </Button>
                            <Button variant="outline" className="w-full justify-start">
                                🎟️ Promotions
                            </Button>
                            <Button variant="outline" className="w-full justify-start">
                                💸 Commissions
                            </Button>
                        </div>
                    </div>

                    <div className="bg-white rounded-xl shadow-md p-6 border border-gray-100">
                        <h2 className="text-xl font-semibold text-gray-900 mb-4">
                            ⚙️ System Settings
                        </h2>
                        <div className="space-y-3">
                            <Button variant="outline" className="w-full justify-start">
                                📱 App Settings
                            </Button>
                            <Button variant="outline" className="w-full justify-start">
                                🔔 Notifications
                            </Button>
                            <Button variant="outline" className="w-full justify-start">
                                📄 Document Verification
                            </Button>
                            <Button variant="outline" className="w-full justify-start">
                                📋 System Logs
                            </Button>
                        </div>
                    </div>
                </div>
            </div>
        </AppShell>
    );
}