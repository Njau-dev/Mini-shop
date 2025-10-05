<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Order #{{ $order->id }}
                </h2>
            </div>
            <span
                class="px-4 py-2 rounded-full text-sm font-medium capitalize
                    {{ $order->status === 'confirmed'
                        ? 'bg-green-100 text-green-800'
                        : ($order->status === 'failed'
                            ? 'bg-red-100 text-red-800'
                            : 'bg-yellow-100 text-yellow-800') }}">
                {{ str_replace('_', ' ', $order->status) }}
            </span>
        </div>

        <x-admin.breadcrumbs :items="[
            ['href' => route('orders.index'), 'label' => 'Orders'],
            ['label' => 'Order #' . $order->id . ' Details'],
        ]" />
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
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Order Details -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Order Items -->
                    <div class="bg-white shadow-xl sm:rounded-2xl overflow-hidden">
                        <div class="p-6 sm:p-8">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6">Order Items</h3>

                            <div class="space-y-4">
                                @foreach ($order->items as $item)
                                    <div
                                        class="flex items-center gap-4 p-4 border border-gray-200 rounded-xl hover:shadow-md transition-all duration-300">
                                        <div
                                            class="w-16 h-16 bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                            {!! App\Helpers\CategoryIconHelper::getIcon(
                                                $item->product->category->name ?? 'default',
                                                'w-8 h-8 text-gray-500',
                                            ) !!}
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="font-semibold text-gray-900 text-sm mb-1">
                                                {{ $item->product->name }}</h4>
                                            <div class="flex items-center gap-4 text-xs text-gray-500 mb-2">
                                                <span>Qty: {{ $item->quantity }}</span>
                                                <span>•</span>
                                                <span
                                                    class="capitalize">{{ $item->product->category->name ?? 'N/A' }}</span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <p class="text-sm font-semibold text-gray-900">
                                                    KShs {{ number_format($item->price * $item->quantity, 2) }}
                                                </p>
                                                <p class="text-xs text-gray-500">
                                                    KShs {{ number_format($item->price, 2) }} each
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Shipping Information -->
                    <div class="bg-white shadow-xl sm:rounded-2xl overflow-hidden">
                        <div class="p-6 sm:p-8">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6">Shipping Information</h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-3">Delivery Address</h4>
                                    <div class="space-y-2 text-sm text-gray-600">
                                        <p class="font-medium">{{ $order->shipping_name }}</p>
                                        <p>{{ $order->shipping_address }}</p>
                                        <p>{{ $order->shipping_city }}</p>
                                        <p class="mt-2">
                                            <span class="font-medium">Phone:</span> {{ $order->shipping_phone }}
                                        </p>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="font-semibold text-gray-900 mb-3">Order Details</h4>
                                    <div class="space-y-2 text-sm text-gray-600">
                                        <p>
                                            <span class="font-medium">Order Date:</span>
                                            {{ $order->created_at->format('M d, Y \a\t h:i A') }}
                                        </p>
                                        <p>
                                            <span class="font-medium">Last Updated:</span>
                                            {{ $order->updated_at->format('M d, Y \a\t h:i A') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div class="space-y-6">
                    <div class="bg-white shadow-xl sm:rounded-2xl overflow-hidden sticky top-6">
                        <div class="p-6 sm:p-8">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6">Order Summary</h3>

                            <div class="space-y-4 mb-6">
                                <div class="flex justify-between text-gray-600">
                                    <span>Subtotal</span>
                                    <span>KShs {{ number_format($order->total, 2) }}</span>
                                </div>
                                <div
                                    class="flex justify-between text-lg font-bold text-gray-900 border-t border-gray-200 pt-4">
                                    <span>Total</span>
                                    <span class="text-2xl text-blue-600">KSh
                                        {{ number_format($order->total, 2) }}</span>
                                </div>
                            </div>

                            <!-- Status Timeline -->
                            <div class="border-t border-gray-200 pt-6">
                                <h4 class="font-semibold text-gray-900 mb-4">Order Status</h4>
                                <div class="space-y-3">
                                    @php
                                        $statuses = [
                                            'pending' => ['icon' => '🕒', 'color' => 'text-yellow-500'],
                                            'completed' => ['icon' => '✅', 'color' => 'text-green-500'],
                                            'failed' => ['icon' => '❌', 'color' => 'text-red-500'],
                                        ];

                                        $currentStatusIndex = array_keys($statuses)[
                                            array_search($order->status, array_keys($statuses))
                                        ];
                                    @endphp

                                    @foreach ($statuses as $status => $data)
                                        @php
                                            $isCompleted =
                                                array_search($status, array_keys($statuses)) <=
                                                array_search($order->status, array_keys($statuses));
                                            $isCurrent = $status === $order->status;
                                        @endphp
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-8 h-8 rounded-full flex items-center justify-center flex-shrink-0
                                                {{ $isCompleted ? 'bg-green-100 text-green-600' : 'bg-gray-100 text-gray-400' }}">
                                                {{ $isCompleted ? '✓' : $data['icon'] }}
                                            </div>
                                            <span
                                                class="text-sm font-medium {{ $isCompleted ? 'text-gray-900' : 'text-gray-500' }} capitalize">
                                                {{ str_replace('_', ' ', $status) }}
                                                @if ($isCurrent)
                                                    <span class="text-xs text-blue-600 ml-1">(Current)</span>
                                                @endif
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="bg-white shadow-xl sm:rounded-2xl overflow-hidden">
                        <div class="p-6">
                            <div class="space-y-3">
                                <a href="{{ route('orders.index') }}"
                                    class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 px-6 rounded-xl text-center transition-all duration-300 transform hover:scale-105 block">
                                    Back to Orders
                                </a>
                                <a href="{{ route('catalog.index') }}"
                                    class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3 px-6 rounded-xl text-center transition-all duration-300 transform hover:scale-105 shadow-lg block">
                                    Continue Shopping
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
