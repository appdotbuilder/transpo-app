import React from 'react';
import { Head, Link, router } from '@inertiajs/react';
import { Button } from '@/components/ui/button';

interface ServiceCategory {
    id: number;
    name: string;
    slug: string;
    icon: string | null;
    description: string | null;
    base_fare: number;
    price_per_km: number;
    is_active: boolean;
}

interface VehicleType {
    id: number;
    name: string;
    slug: string;
    icon: string | null;
    description: string | null;
    capacity: number;
    price_multiplier: number;
    is_active: boolean;
}

interface Stats {
    total_orders: number;
    active_drivers: number;
    total_merchants: number;
    service_categories: number;
}

interface Props {
    auth?: {
        user: {
            id: number;
            name: string;
            email: string;
        } | null;
    };
    serviceCategories: ServiceCategory[];
    vehicleTypes: VehicleType[];
    stats: Stats;
    [key: string]: unknown;
}

const serviceIcons: Record<string, string> = {
    taxi: '🚗',
    send: '📦',
    rent: '🚙',
    food: '🍔',
    shop: '🛍️',
};

const vehicleIcons: Record<string, string> = {
    car: '🚗',
    motorcycle: '🏍️',
    truck: '🚚',
    bicycle: '🚴',
};

export default function Welcome({ auth, serviceCategories, vehicleTypes, stats }: Props) {
    const handleGetStarted = () => {
        if (auth?.user) {
            router.get('/dashboard');
        } else {
            router.get('/register');
        }
    };

    const handleBookNow = () => {
        if (auth?.user) {
            router.get('/order/create');
        } else {
            router.get('/login');
        }
    };

    return (
        <>
            <Head title="TransGo - Your Complete Transportation Solution" />
            
            <div className="min-h-screen bg-gradient-to-br from-blue-50 via-white to-green-50">
                {/* Header */}
                <header className="bg-white/80 backdrop-blur-sm border-b border-gray-200/50 sticky top-0 z-50">
                    <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div className="flex justify-between items-center h-16">
                            <div className="flex items-center space-x-2">
                                <div className="text-2xl">🚀</div>
                                <h1 className="text-xl font-bold text-gray-900">TransGo</h1>
                            </div>
                            <div className="flex items-center space-x-4">
                                {auth?.user ? (
                                    <>
                                        <Link href="/dashboard" className="text-gray-700 hover:text-blue-600 font-medium">
                                            Dashboard
                                        </Link>
                                        <Link href="/profile" className="text-gray-700 hover:text-blue-600 font-medium">
                                            Profile
                                        </Link>
                                    </>
                                ) : (
                                    <>
                                        <Link href="/login" className="text-gray-700 hover:text-blue-600 font-medium">
                                            Login
                                        </Link>
                                        <Link href="/register">
                                            <Button className="bg-blue-600 hover:bg-blue-700">
                                                Sign Up
                                            </Button>
                                        </Link>
                                    </>
                                )}
                            </div>
                        </div>
                    </div>
                </header>

                {/* Hero Section */}
                <section className="py-20 px-4 sm:px-6 lg:px-8">
                    <div className="max-w-7xl mx-auto">
                        <div className="text-center mb-16">
                            <h1 className="text-5xl sm:text-6xl font-bold text-gray-900 mb-6">
                                🚗 Your Complete
                                <span className="text-blue-600 block">Transportation Solution</span>
                            </h1>
                            <p className="text-xl text-gray-600 mb-8 max-w-3xl mx-auto">
                                From taxi rides to food delivery, package sending to vehicle rentals - 
                                all your transportation needs in one powerful platform with real-time tracking 
                                and flexible pricing.
                            </p>
                            <div className="flex flex-col sm:flex-row gap-4 justify-center">
                                <Button 
                                    onClick={handleBookNow}
                                    size="lg" 
                                    className="bg-blue-600 hover:bg-blue-700 text-lg px-8 py-4"
                                >
                                    📱 Book a Ride Now
                                </Button>
                                <Button 
                                    onClick={handleGetStarted}
                                    variant="outline" 
                                    size="lg" 
                                    className="text-lg px-8 py-4"
                                >
                                    🚀 Get Started
                                </Button>
                            </div>
                        </div>

                        {/* Stats */}
                        <div className="grid grid-cols-2 md:grid-cols-4 gap-6 mb-16">
                            <div className="bg-white/70 backdrop-blur-sm rounded-xl p-6 text-center border border-gray-200/50">
                                <div className="text-3xl font-bold text-blue-600 mb-2">{stats.total_orders.toLocaleString()}</div>
                                <div className="text-gray-600">📊 Total Orders</div>
                            </div>
                            <div className="bg-white/70 backdrop-blur-sm rounded-xl p-6 text-center border border-gray-200/50">
                                <div className="text-3xl font-bold text-green-600 mb-2">{stats.active_drivers.toLocaleString()}</div>
                                <div className="text-gray-600">👥 Active Drivers</div>
                            </div>
                            <div className="bg-white/70 backdrop-blur-sm rounded-xl p-6 text-center border border-gray-200/50">
                                <div className="text-3xl font-bold text-purple-600 mb-2">{stats.total_merchants.toLocaleString()}</div>
                                <div className="text-gray-600">🏪 Partner Merchants</div>
                            </div>
                            <div className="bg-white/70 backdrop-blur-sm rounded-xl p-6 text-center border border-gray-200/50">
                                <div className="text-3xl font-bold text-orange-600 mb-2">{stats.service_categories}</div>
                                <div className="text-gray-600">🎯 Service Types</div>
                            </div>
                        </div>
                    </div>
                </section>

                {/* Services Section */}
                <section className="py-16 px-4 sm:px-6 lg:px-8 bg-white/50 backdrop-blur-sm">
                    <div className="max-w-7xl mx-auto">
                        <div className="text-center mb-12">
                            <h2 className="text-4xl font-bold text-gray-900 mb-4">
                                🎯 Our Services
                            </h2>
                            <p className="text-xl text-gray-600">
                                Choose from our comprehensive range of transportation and delivery services
                            </p>
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            {serviceCategories.map((category) => (
                                <div 
                                    key={category.id}
                                    className="group bg-white rounded-xl p-8 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-blue-200"
                                >
                                    <div className="text-center">
                                        <div className="text-6xl mb-4">
                                            {serviceIcons[category.slug] || '🚀'}
                                        </div>
                                        <h3 className="text-2xl font-bold text-gray-900 mb-2 capitalize">
                                            {category.name}
                                        </h3>
                                        <p className="text-gray-600 mb-4">
                                            {category.description || `Professional ${category.name} service with real-time tracking`}
                                        </p>
                                        <div className="bg-gray-50 rounded-lg p-3 mb-4">
                                            <div className="text-sm text-gray-500 mb-1">Starting from</div>
                                            <div className="text-2xl font-bold text-blue-600">
                                                Rp {category.base_fare.toLocaleString()}
                                            </div>
                                            <div className="text-sm text-gray-500">
                                                + Rp {category.price_per_km.toLocaleString()}/km
                                            </div>
                                        </div>
                                        <Button 
                                            onClick={handleBookNow}
                                            className="w-full group-hover:bg-blue-700"
                                        >
                                            Book {category.name}
                                        </Button>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </section>

                {/* Vehicle Types Section */}
                <section className="py-16 px-4 sm:px-6 lg:px-8">
                    <div className="max-w-7xl mx-auto">
                        <div className="text-center mb-12">
                            <h2 className="text-4xl font-bold text-gray-900 mb-4">
                                🚗 Vehicle Options
                            </h2>
                            <p className="text-xl text-gray-600">
                                Multiple vehicle types to suit your needs and budget
                            </p>
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            {vehicleTypes.map((vehicle) => (
                                <div 
                                    key={vehicle.id}
                                    className="bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 border border-gray-100 hover:border-blue-200 text-center"
                                >
                                    <div className="text-5xl mb-4">
                                        {vehicleIcons[vehicle.slug] || '🚗'}
                                    </div>
                                    <h3 className="text-xl font-bold text-gray-900 mb-2">
                                        {vehicle.name}
                                    </h3>
                                    <p className="text-gray-600 mb-3">
                                        Capacity: {vehicle.capacity} {vehicle.capacity === 1 ? 'person' : 'people'}
                                    </p>
                                    <div className="bg-blue-50 rounded-lg p-2">
                                        <div className="text-sm text-blue-600 font-medium">
                                            {vehicle.price_multiplier}x multiplier
                                        </div>
                                    </div>
                                </div>
                            ))}
                        </div>
                    </div>
                </section>

                {/* Features Section */}
                <section className="py-16 px-4 sm:px-6 lg:px-8 bg-gray-50">
                    <div className="max-w-7xl mx-auto">
                        <div className="text-center mb-12">
                            <h2 className="text-4xl font-bold text-gray-900 mb-4">
                                ✨ Why Choose TransGo?
                            </h2>
                        </div>

                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                            <div className="text-center">
                                <div className="text-5xl mb-4">📍</div>
                                <h3 className="text-xl font-bold text-gray-900 mb-2">Real-time Tracking</h3>
                                <p className="text-gray-600">Track your driver's location in real-time with accurate ETA updates</p>
                            </div>
                            <div className="text-center">
                                <div className="text-5xl mb-4">💳</div>
                                <h3 className="text-xl font-bold text-gray-900 mb-2">Digital Wallet</h3>
                                <p className="text-gray-600">Secure cashless payments with built-in wallet and transaction history</p>
                            </div>
                            <div className="text-center">
                                <div className="text-5xl mb-4">⭐</div>
                                <h3 className="text-xl font-bold text-gray-900 mb-2">Rating System</h3>
                                <p className="text-gray-600">Rate and review drivers and merchants to maintain quality service</p>
                            </div>
                            <div className="text-center">
                                <div className="text-5xl mb-4">🔔</div>
                                <h3 className="text-xl font-bold text-gray-900 mb-2">Push Notifications</h3>
                                <p className="text-gray-600">Stay informed with instant notifications about order updates</p>
                            </div>
                            <div className="text-center">
                                <div className="text-5xl mb-4">🎟️</div>
                                <h3 className="text-xl font-bold text-gray-900 mb-2">Promotions & Vouchers</h3>
                                <p className="text-gray-600">Save money with regular promotions and discount vouchers</p>
                            </div>
                            <div className="text-center">
                                <div className="text-5xl mb-4">🛡️</div>
                                <h3 className="text-xl font-bold text-gray-900 mb-2">Verified Partners</h3>
                                <p className="text-gray-600">All drivers and merchants are verified with proper documentation</p>
                            </div>
                        </div>
                    </div>
                </section>

                {/* CTA Section */}
                <section className="py-16 px-4 sm:px-6 lg:px-8 bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                    <div className="max-w-4xl mx-auto text-center">
                        <h2 className="text-4xl font-bold mb-6">
                            🚀 Ready to Get Started?
                        </h2>
                        <p className="text-xl mb-8 opacity-90">
                            Join thousands of satisfied customers and experience the future of transportation
                        </p>
                        <div className="flex flex-col sm:flex-row gap-4 justify-center">
                            <Button 
                                onClick={handleGetStarted}
                                size="lg" 
                                className="bg-white text-blue-600 hover:bg-gray-100 text-lg px-8 py-4"
                            >
                                🎯 Start Your Journey
                            </Button>
                            {!auth?.user && (
                                <Link href="/login">
                                    <Button 
                                        variant="outline" 
                                        size="lg" 
                                        className="border-white text-white hover:bg-white/10 text-lg px-8 py-4"
                                    >
                                        📱 Sign In
                                    </Button>
                                </Link>
                            )}
                        </div>
                    </div>
                </section>

                {/* Footer */}
                <footer className="bg-gray-900 text-white py-12 px-4 sm:px-6 lg:px-8">
                    <div className="max-w-7xl mx-auto">
                        <div className="grid grid-cols-1 md:grid-cols-4 gap-8">
                            <div>
                                <div className="flex items-center space-x-2 mb-4">
                                    <div className="text-2xl">🚀</div>
                                    <h3 className="text-xl font-bold">TransGo</h3>
                                </div>
                                <p className="text-gray-400">
                                    Your complete transportation solution with real-time tracking and flexible services.
                                </p>
                            </div>
                            <div>
                                <h4 className="text-lg font-semibold mb-4">Services</h4>
                                <ul className="space-y-2 text-gray-400">
                                    <li>🚗 Taxi Service</li>
                                    <li>📦 Package Delivery</li>
                                    <li>🍔 Food Delivery</li>
                                    <li>🚙 Vehicle Rental</li>
                                </ul>
                            </div>
                            <div>
                                <h4 className="text-lg font-semibold mb-4">For Partners</h4>
                                <ul className="space-y-2 text-gray-400">
                                    <li>👨‍✈️ Become a Driver</li>
                                    <li>🏪 Merchant Partnership</li>
                                    <li>📊 Admin Dashboard</li>
                                    <li>💰 Earn More</li>
                                </ul>
                            </div>
                            <div>
                                <h4 className="text-lg font-semibold mb-4">Support</h4>
                                <ul className="space-y-2 text-gray-400">
                                    <li>📞 24/7 Help Center</li>
                                    <li>❓ FAQ</li>
                                    <li>🔒 Safety</li>
                                    <li>📋 Terms & Privacy</li>
                                </ul>
                            </div>
                        </div>
                        <div className="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                            <p>&copy; 2024 TransGo. All rights reserved. Built with ❤️ for seamless transportation.</p>
                        </div>
                    </div>
                </footer>
            </div>
        </>
    );
}