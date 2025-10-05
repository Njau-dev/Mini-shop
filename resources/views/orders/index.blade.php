<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('My Orders') }}
                </h2>
            </div>
            <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                {{ $orders->total() }} order{{ $orders->total() > 1 ? 's' : '' }}
            </span>
        </div>

        <x-admin.breadcrumbs :items="[['label' => 'Orders']]" />
    </x-slot>

    <div class="py-8 px-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div
                    class="mb-6 bg-green-50 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative shadow-sm">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif
            @if (session('error'))
                <div class="mb-6 bg-red-50 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative shadow-sm"
                    role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            @if ($orders->count() > 0)
                <div class="bg-white shadow-xl sm:rounded-2xl overflow-hidden">
                    <div class="p-6 sm:p-8">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Order History</h3>

                        <div class="space-y-6">
                            @foreach ($orders as $order)
                                <div
                                    class="border border-gray-200 rounded-xl hover:shadow-lg transition-all duration-300 bg-white group">
                                    <div class="p-6">
                                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                                            <!-- Order Info -->
                                            <div class="flex-1">
                                                <div
                                                    class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                                                    <div>
                                                        <h4 class="text-lg font-semibold text-gray-900 mb-1">
                                                            Order #{{ $order->id }}
                                                        </h4>
                                                        <p class="text-sm text-gray-500">
                                                            Placed on
                                                            {{ $order->created_at->format('M d, Y \a\t h:i A') }}
                                                        </p>
                                                    </div>
                                                    <div class="flex items-center gap-3">
                                                        <span class="text-sm font-medium text-gray-700">
                                                            {{ $order->items_count }}
                                                            item{{ $order->items_count > 1 ? 's' : '' }}
                                                        </span>
                                                        <span
                                                            class="px-3 py-1 rounded-full text-xs font-medium capitalize
                                                            {{ $order->status === 'completed'
                                                                ? 'bg-green-100 text-green-800'
                                                                : ($order->status === 'failed'
                                                                    ? 'bg-red-100 text-red-800'
                                                                    : 'bg-yellow-100 text-yellow-800') }}">
                                                            {{ str_replace('_', ' ', $order->status) }}
                                                        </span>
                                                    </div>
                                                </div>

                                                <!-- Order Details -->
                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                                                    <div>
                                                        <p class="text-gray-600 mb-1">
                                                            <span class="font-medium">Total:</span>
                                                            KSh {{ number_format($order->total, 2) }}
                                                        </p>
                                                    </div>
                                                    <div>
                                                        <p class="text-gray-600 mb-1">
                                                            <span class="font-medium">Shipped to:</span>
                                                            {{ $order->shipping_city }}
                                                        </p>
                                                        <p class="text-gray-600">
                                                            <span class="font-medium">Phone:</span>
                                                            {{ $order->shipping_phone }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Action Button -->
                                            <div class="flex-shrink-0">
                                                <a href="{{ route('orders.show', $order) }}"
                                                    class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg">
                                                    View Details
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M9 5l7 7-7 7" />
                                                    </svg>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-8">
                            {{ $orders->links() }}
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty Orders State -->
                <div class="bg-white shadow-xl sm:rounded-2xl overflow-hidden">
                    <div class="p-12 sm:p-16 text-center">
                        <div
                            class="mx-auto w-32 h-32 bg-gradient-to-br from-gray-50 to-blue-50 rounded-full flex items-center justify-center mb-6">
                            <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">No Orders Yet</h3>
                        <p class="text-gray-500 mb-8 max-w-md mx-auto">You haven't placed any orders yet. Start
                            shopping
                            to see your order history here!</p>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('catalog.index') }}"
                                class="inline-flex items-center justify-center gap-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-8 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                Browse Products
                            </a>
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex items-center justify-center gap-3 border border-gray-300 text-gray-700 font-medium py-3 px-8 rounded-xl hover:bg-gray-50 transition-all duration-300">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Back to Home
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
