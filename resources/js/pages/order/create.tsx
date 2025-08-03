import React, { useState } from 'react';
import { Head, useForm } from '@inertiajs/react';
import { AppShell } from '@/components/app-shell';
import { Button } from '@/components/ui/button';

interface ServiceCategory {
    id: number;
    name: string;
    slug: string;
    icon: string | null;
    description: string | null;
    base_fare: number;
    price_per_km: number;
    minimum_fare: number;
}

interface VehicleType {
    id: number;
    name: string;
    slug: string;
    icon: string | null;
    description: string | null;
    capacity: number;
    price_multiplier: number;
}

interface Props {
    serviceCategories: ServiceCategory[];
    vehicleTypes: VehicleType[];
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
    mpv: '🚐',
    truck: '🚚',
    bicycle: '🚴',
};

export default function CreateOrder({ serviceCategories, vehicleTypes }: Props) {
    const { data, setData, post, processing, errors } = useForm({
        service_category_id: '',
        vehicle_type_id: '',
        pickup_address: '',
        pickup_latitude: -6.2088,
        pickup_longitude: 106.8456,
        destination_address: '',
        destination_latitude: -6.1751,
        destination_longitude: 106.8650,
        notes: '',
    });

    const [selectedCategory, setSelectedCategory] = useState<ServiceCategory | null>(null);
    const [selectedVehicle, setSelectedVehicle] = useState<VehicleType | null>(null);
    const [estimatedFare, setEstimatedFare] = useState<number>(0);

    const handleCategorySelect = (category: ServiceCategory) => {
        setSelectedCategory(category);
        setData('service_category_id', category.id.toString());
        calculateEstimate(category, selectedVehicle);
    };

    const handleVehicleSelect = (vehicle: VehicleType) => {
        setSelectedVehicle(vehicle);
        setData('vehicle_type_id', vehicle.id.toString());
        calculateEstimate(selectedCategory, vehicle);
    };

    const calculateEstimate = (category: ServiceCategory | null, vehicle: VehicleType | null) => {
        if (!category || !vehicle) return;
        
        // Simple distance calculation (in real app, use Google Maps API)
        const distance = 5; // Assume 5km for demo
        
        const baseFare = category.base_fare;
        const distanceFare = distance * category.price_per_km * vehicle.price_multiplier;
        const total = Math.max(baseFare + distanceFare, category.minimum_fare);
        
        setEstimatedFare(total);
    };

    const handleSubmit = (e: React.FormEvent) => {
        e.preventDefault();
        post(route('order.store'));
    };

    return (
        <AppShell>
            <Head title="Book a Ride - TransGo" />
            
            <div className="max-w-4xl mx-auto p-6">
                <div className="mb-8">
                    <h1 className="text-3xl font-bold text-gray-900 mb-2">
                        📱 Book Your Ride
                    </h1>
                    <p className="text-gray-600">
                        Choose your service type, vehicle, and destination to get started
                    </p>
                </div>

                <form onSubmit={handleSubmit} className="space-y-8">
                    {/* Service Category Selection */}
                    <div>
                        <h2 className="text-xl font-semibold text-gray-900 mb-4">
                            🎯 Select Service Type
                        </h2>
                        <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            {serviceCategories.map((category) => (
                                <button
                                    key={category.id}
                                    type="button"
                                    onClick={() => handleCategorySelect(category)}
                                    className={`p-4 rounded-xl border-2 transition-all duration-200 ${
                                        selectedCategory?.id === category.id
                                            ? 'border-blue-500 bg-blue-50'
                                            : 'border-gray-200 hover:border-blue-300 hover:bg-gray-50'
                                    }`}
                                >
                                    <div className="text-center">
                                        <div className="text-4xl mb-2">
                                            {serviceIcons[category.slug] || '🚀'}
                                        </div>
                                        <h3 className="font-semibold text-gray-900 mb-1">
                                            {category.name}
                                        </h3>
                                        <p className="text-sm text-gray-600 mb-2">
                                            {category.description}
                                        </p>
                                        <div className="text-sm text-blue-600 font-medium">
                                            From Rp {category.base_fare.toLocaleString()}
                                        </div>
                                    </div>
                                </button>
                            ))}
                        </div>
                        {errors.service_category_id && (
                            <p className="mt-2 text-sm text-red-600">{errors.service_category_id}</p>
                        )}
                    </div>

                    {/* Vehicle Type Selection */}
                    {selectedCategory && (
                        <div>
                            <h2 className="text-xl font-semibold text-gray-900 mb-4">
                                🚗 Choose Vehicle Type
                            </h2>
                            <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                {vehicleTypes.map((vehicle) => (
                                    <button
                                        key={vehicle.id}
                                        type="button"
                                        onClick={() => handleVehicleSelect(vehicle)}
                                        className={`p-4 rounded-xl border-2 transition-all duration-200 ${
                                            selectedVehicle?.id === vehicle.id
                                                ? 'border-blue-500 bg-blue-50'
                                                : 'border-gray-200 hover:border-blue-300 hover:bg-gray-50'
                                        }`}
                                    >
                                        <div className="text-center">
                                            <div className="text-3xl mb-2">
                                                {vehicleIcons[vehicle.slug] || '🚗'}
                                            </div>
                                            <h3 className="font-semibold text-gray-900 mb-1">
                                                {vehicle.name}
                                            </h3>
                                            <p className="text-sm text-gray-600 mb-1">
                                                {vehicle.capacity} seats
                                            </p>
                                            <div className="text-sm text-blue-600 font-medium">
                                                {vehicle.price_multiplier}x rate
                                            </div>
                                        </div>
                                    </button>
                                ))}
                            </div>
                            {errors.vehicle_type_id && (
                                <p className="mt-2 text-sm text-red-600">{errors.vehicle_type_id}</p>
                            )}
                        </div>
                    )}

                    {/* Location Details */}
                    {selectedVehicle && (
                        <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-2">
                                    📍 Pickup Address
                                </label>
                                <input
                                    type="text"
                                    value={data.pickup_address}
                                    onChange={(e) => setData('pickup_address', e.target.value)}
                                    className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Enter pickup location"
                                />
                                {errors.pickup_address && (
                                    <p className="mt-1 text-sm text-red-600">{errors.pickup_address}</p>
                                )}
                            </div>

                            <div>
                                <label className="block text-sm font-medium text-gray-700 mb-2">
                                    🎯 Destination Address
                                </label>
                                <input
                                    type="text"
                                    value={data.destination_address}
                                    onChange={(e) => setData('destination_address', e.target.value)}
                                    className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Enter destination"
                                />
                                {errors.destination_address && (
                                    <p className="mt-1 text-sm text-red-600">{errors.destination_address}</p>
                                )}
                            </div>
                        </div>
                    )}

                    {/* Notes */}
                    {selectedVehicle && (
                        <div>
                            <label className="block text-sm font-medium text-gray-700 mb-2">
                                📝 Additional Notes (Optional)
                            </label>
                            <textarea
                                rows={3}
                                value={data.notes}
                                onChange={(e) => setData('notes', e.target.value)}
                                className="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Any special instructions or notes..."
                            />
                        </div>
                    )}

                    {/* Price Estimate */}
                    {estimatedFare > 0 && (
                        <div className="bg-blue-50 rounded-xl p-6 border border-blue-200">
                            <h3 className="text-lg font-semibold text-blue-900 mb-2">
                                💰 Estimated Fare
                            </h3>
                            <div className="text-3xl font-bold text-blue-600 mb-2">
                                Rp {estimatedFare.toLocaleString()}
                            </div>
                            <p className="text-sm text-blue-700">
                                *Final fare may vary based on actual distance and time
                            </p>
                        </div>
                    )}

                    {/* Submit Button */}
                    {selectedCategory && selectedVehicle && data.pickup_address && data.destination_address && (
                        <div className="flex justify-center">
                            <Button
                                type="submit"
                                disabled={processing}
                                size="lg"
                                className="px-12 py-4 text-lg"
                            >
                                {processing ? (
                                    '⏳ Processing...'
                                ) : (
                                    '🚀 Book Now'
                                )}
                            </Button>
                        </div>
                    )}
                </form>
            </div>
        </AppShell>
    );
}