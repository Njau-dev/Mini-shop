<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Shopping Cart') }}
                </h2>
            </div>
            @if (count($cart) > 0)
                <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                    {{ count($cart) }} item{{ count($cart) > 1 ? 's' : '' }}
                </span>
            @endif
        </div>

        <x-admin.breadcrumbs :items="[['label' => 'Cart']]" />
    </x-slot>

    <div class="py-8 px-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative shadow-sm"
                    role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative shadow-sm"
                    role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            @if (count($cart) > 0)
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 lg:gap-8">
                    <!-- Cart Items -->
                    <div class="lg:col-span-2">
                        <div class="bg-white shadow-xl sm:rounded-2xl overflow-hidden">
                            <div class="p-6 sm:p-8">
                                <div class="flex items-center justify-between mb-6">
                                    <h3 class="text-2xl font-bold text-gray-900">
                                        Your Cart Items
                                    </h3>
                                    <span class="text-sm text-gray-500 bg-gray-100 px-3 py-1 rounded-full">
                                        {{ count($cart) }} item{{ count($cart) > 1 ? 's' : '' }}
                                    </span>
                                </div>

                                <div class="space-y-4">
                                    @foreach ($cart as $id => $item)
                                        <div
                                            class="flex flex-col sm:flex-row gap-4 p-6 border border-gray-200 rounded-xl hover:shadow-lg transition-all duration-300 bg-white group">
                                            <!-- Product Icon -->
                                            <div
                                                class="w-20 h-20 bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl flex-shrink-0 flex items-center justify-center group-hover:scale-105 transition-transform duration-300">
                                                {!! App\Helpers\CategoryIconHelper::getIcon(
                                                    $item['category'] ?? 'default',
                                                    'w-10 h-10 text-gray-500 group-hover:text-blue-600',
                                                ) !!}
                                            </div>

                                            <div class="flex-1 min-w-0">
                                                <div
                                                    class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                                                    <div class="flex-1">
                                                        <div class="flex items-start justify-between">
                                                            <div>
                                                                <h4 class="text-lg font-semibold text-gray-900 mb-1">
                                                                    {{ $item['name'] }}</h4>
                                                                <div class="flex items-center gap-2 mb-2">
                                                                    <div class="text-blue-500">
                                                                        {!! App\Helpers\CategoryIconHelper::getIcon($item['category'] ?? 'default', 'w-4 h-4') !!}
                                                                    </div>
                                                                    <span
                                                                        class="text-sm text-gray-500 capitalize">{{ $item['category'] }}</span>
                                                                </div>
                                                            </div>
                                                            <form method="POST"
                                                                action="{{ route('cart.remove', $id) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="text-gray-400 hover:text-red-600 transition-colors duration-200 p-1 rounded-lg hover:bg-red-50"
                                                                    title="Remove item">
                                                                    <svg class="h-5 w-5" fill="none"
                                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round"
                                                                            stroke-linejoin="round" stroke-width="2"
                                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                    </svg>
                                                                </button>
                                                            </form>
                                                        </div>

                                                        <div
                                                            class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mt-4">
                                                            <!-- Quantity Update Form -->
                                                            <form method="POST"
                                                                action="{{ route('cart.update', $id) }}"
                                                                class="flex items-center gap-3">
                                                                @csrf
                                                                @method('PATCH')
                                                                <label
                                                                    class="text-sm font-medium text-gray-700">Quantity:</label>
                                                                <div class="flex items-center gap-2">
                                                                    <input type="number" name="quantity"
                                                                        value="{{ $item['quantity'] }}" min="1"
                                                                        class="w-20 px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-center">
                                                                    <button type="submit"
                                                                        class="text-sm bg-blue-600 text-white px-3 py-2 rounded-lg hover:bg-blue-700 transition-colors duration-200 font-medium">
                                                                        Update
                                                                    </button>
                                                                </div>
                                                            </form>

                                                            <!-- Price Information -->
                                                            <div class="text-right">
                                                                <p class="text-sm text-gray-500">KSh
                                                                    {{ number_format($item['price'], 2) }} each</p>
                                                                <p class="text-xl font-bold text-gray-900">
                                                                    KSh
                                                                    {{ number_format($item['price'] * $item['quantity'], 2) }}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Cart Actions -->
                                <div
                                    class="mt-8 flex flex-col sm:flex-row justify-between items-center gap-4 pt-6 border-t border-gray-200">
                                    <a href="{{ route('catalog.index') }}"
                                        class="flex items-center gap-3 text-blue-600 hover:text-blue-800 font-semibold transition-colors duration-200 group">
                                        <svg class="h-5 w-5 transform group-hover:-translate-x-1 transition-transform duration-200"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 19l-7-7 7-7" />
                                        </svg>
                                        Continue Shopping
                                    </a>

                                    <form method="POST" action="{{ route('cart.clear') }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="flex items-center gap-2 text-red-600 hover:text-red-800 font-semibold transition-colors duration-200 group"
                                            onclick="return confirm('Are you sure you want to clear your cart?')">
                                            <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Clear Cart
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="lg:col-span-1">
                        <div class="bg-white shadow-xl sm:rounded-2xl overflow-hidden sticky top-6">
                            <div class="p-6 sm:p-8">
                                <h3 class="text-2xl font-bold text-gray-900 mb-6">Order Summary</h3>

                                <div class="space-y-4 mb-6">
                                    <div
                                        class="flex justify-between items-center text-gray-600 pb-3 border-b border-gray-200">
                                        <span class="font-medium">Subtotal</span>
                                        <span class="font-semibold">KShs {{ number_format($total, 2) }}</span>
                                    </div>
                                    <div class="flex justify-between items-center text-lg font-bold text-gray-900 pt-2">
                                        <span>Total</span>
                                        <span class="text-2xl text-blue-600">KShs {{ number_format($total, 2) }}</span>
                                    </div>
                                </div>

                                <a href="{{ route('checkout.index') }}"
                                    class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl text-center block">
                                    Proceed to Checkout
                                </a>

                                <div class="mt-4 flex items-center justify-center gap-2 text-xs text-gray-500">
                                    <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                    Secure checkout powered by our payment gateway
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Empty Cart -->
                <div class="bg-white shadow-xl sm:rounded-2xl overflow-hidden">
                    <div class="p-12 sm:p-16 text-center">
                        <div
                            class="mx-auto w-32 h-32 bg-gradient-to-br from-gray-50 to-blue-50 rounded-full flex items-center justify-center mb-6">
                            {!! App\Helpers\CategoryIconHelper::getIcon('default', 'w-16 h-16 text-gray-400') !!}
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Your cart is empty</h3>
                        <p class="text-gray-500 mb-8 max-w-md mx-auto">Looks like you haven't added any items to your
                            cart yet. Start shopping to discover amazing products!</p>
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
