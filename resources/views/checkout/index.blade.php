<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    {{ __('Checkout') }}
                </h2>
            </div>
            <span class="bg-blue-100 text-blue-800 text-sm font-medium px-3 py-1 rounded-full">
                {{ $itemCount }} item{{ $itemCount > 1 ? 's' : '' }}
            </span>
        </div>

        <x-admin.breadcrumbs :items="[['href' => route('cart.index'), 'label' => 'Cart'], ['label' => 'Checkout']]" />
    </x-slot>

    <div class="py-8 px-4">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="mb-6 bg-red-50 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative shadow-sm"">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <!-- Validation Errors -->
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-500 p-4 rounded-md shadow-sm">
                    <div class="flex flex-col">
                            <h3 class="text-sm font-medium text-red-800">
                                There were {{ $errors->count() }} errors with your submission
                            </h3>
                            <div class="mt-2 text-sm text-red-700">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                    </div>
                </div>
            @endif

            <form method="POST" action="{{ route('checkout.process') }}" id="checkout-form">
                @csrf

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12">
                    <!-- Checkout Form -->
                    <div class="space-y-8">
                        <!-- Shipping Information -->
                        <div class="bg-white shadow-xl sm:rounded-2xl overflow-hidden">
                            <div class="p-6 sm:p-8">
                                <h3 class="text-2xl font-bold text-gray-900 mb-6">Shipping Information</h3>

                                <div class="space-y-4">
                                    <!-- Full Name -->
                                    <div>
                                        <label for="shipping_name" class="block text-sm font-medium text-gray-700 mb-2">
                                            Full Name *
                                        </label>
                                        <input type="text" id="shipping_name" name="shipping_name"
                                            value="{{ Auth::user()->name }}"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                            required>
                                    </div>

                                    <!-- Address -->
                                    <div>
                                        <label for="shipping_address"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            Shipping Address *
                                        </label>
                                        <textarea id="shipping_address" name="shipping_address" rows="3"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                            placeholder="Enter your complete shipping address" required></textarea>
                                    </div>

                                    <!-- City -->
                                    <div>
                                        <label for="shipping_city" class="block text-sm font-medium text-gray-700 mb-2">
                                            City *
                                        </label>
                                        <input type="text" id="shipping_city" name="shipping_city"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                            placeholder="Enter your city" required>
                                    </div>

                                    <!-- Phone -->
                                    <div>
                                        <label for="shipping_phone"
                                            class="block text-sm font-medium text-gray-700 mb-2">
                                            Phone Number *
                                        </label>
                                        <input type="tel" id="shipping_phone" name="shipping_phone"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition duration-200"
                                            placeholder="Enter your phone number" required>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Summary -->
                    <div class="space-y-6">
                        <!-- Order Items -->
                        <div class="bg-white shadow-xl sm:rounded-2xl overflow-hidden sticky top-6">
                            <div class="p-6 sm:p-8">
                                <h3 class="text-2xl font-bold text-gray-900 mb-6">Order Summary</h3>

                                <!-- Cart Items -->
                                <div class="space-y-4 mb-6 max-h-96 overflow-y-auto">
                                    @foreach ($cart as $id => $item)
                                        <div class="flex items-center gap-4 p-4 border border-gray-200 rounded-xl">
                                            <div
                                                class="w-16 h-16 bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                                {!! App\Helpers\CategoryIconHelper::getIcon($item['category'] ?? 'default', 'w-8 h-8 text-gray-500') !!}
                                            </div>
                                            <div class="flex-1 min-w-0">
                                                <h4 class="font-semibold text-gray-900 text-sm mb-1 truncate">
                                                    {{ $item['name'] }}</h4>
                                                <p class="text-xs text-gray-500 mb-2">Qty: {{ $item['quantity'] }}</p>
                                                <p class="text-sm font-semibold text-gray-900">
                                                    KShs {{ number_format($item['price'] * $item['quantity'], 2) }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Price Breakdown -->
                                <div class="space-y-3 border-t border-gray-200 pt-4">
                                    <div class="flex justify-between text-gray-600">
                                        <span>Subtotal</span>
                                        <span>KShs {{ number_format($total, 2) }}</span>
                                    </div>
                                    <div
                                        class="flex justify-between text-lg font-bold text-gray-900 border-t border-gray-200 pt-3">
                                        <span>Total</span>
                                        <span class="text-2xl text-blue-600">KSh {{ number_format($total, 2) }}</span>
                                    </div>
                                </div>

                                <!-- Place Order Button -->
                                <div class="mt-6 space-y-4">
                                    <button type="submit"
                                        class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold py-4 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                                        id="place-order-btn">
                                        Place Order
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Form validation and submission handling
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('checkout-form');
            const placeOrderBtn = document.getElementById('place-order-btn');

            form.addEventListener('submit', function(e) {

                // Disable button to prevent multiple submissions
                placeOrderBtn.disabled = true;
                placeOrderBtn.innerHTML = 'Processing Order...';
            });
        });
    </script>
</x-app-layout>
