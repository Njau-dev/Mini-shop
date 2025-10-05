<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-4">
            {{ __('Order Details') }}
        </h2>
        <x-admin.breadcrumbs :items="[['label' => 'Orders', 'href' => route('admin.orders.index')], ['label' => 'Order #' . $order->id]]" />
    </x-slot>

    <div class="py-12 px-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Success Message -->
            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-l-4 border-green-500 p-6 rounded-md shadow-sm">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm font-medium text-green-800">
                                {{ session('success') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <!-- Order Header -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Order Information</h3>
                            <dl class="grid grid-cols-1 gap-2">
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Order ID:</dt>
                                    <dd class="text-sm text-gray-900">#{{ $order->id }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Order Date:</dt>
                                    <dd class="text-sm text-gray-900">{{ $order->created_at->format('M d, Y H:i') }}
                                    </dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Total Amount:</dt>
                                    <dd class="text-sm font-medium text-gray-900">Kshs
                                        {{ number_format($order->total, 2) }}</dd>
                                </div>
                            </dl>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Customer Information</h3>
                            <dl class="grid grid-cols-1 gap-2">
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Name:</dt>
                                    <dd class="text-sm text-gray-900">{{ $order->user->name }}</dd>
                                </div>
                                <div class="flex justify-between">
                                    <dt class="text-sm font-medium text-gray-500">Email:</dt>
                                    <dd class="text-sm text-gray-900">{{ $order->user->email }}</dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <!-- Shipping Information -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Shipping Information</h3>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-sm text-gray-900"><strong>Name:</strong> {{ $order->shipping_name }}</p>
                            <p class="text-sm text-gray-900 mt-1"><strong>Address:</strong>
                                {{ $order->shipping_address }}</p>
                            <p class="text-sm text-gray-900 mt-1"><strong>City:</strong> {{ $order->shipping_city }}</p>
                            <p class="text-sm text-gray-900 mt-1"><strong>Phone:</strong> {{ $order->shipping_phone }}
                            </p>
                        </div>
                    </div>

                    <!-- Order Status Update -->
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Update Order Status</h3>
                        <form action="{{ route('admin.orders.update', $order) }}" method="POST"
                            class="flex items-center gap-4">
                            @csrf
                            @method('PUT')
                            <select name="status"
                                class="rounded-md border-gray-300 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending
                                </option>
                                <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>
                                    Completed</option>
                                <option value="failed" {{ $order->status === 'failed' ? 'selected' : '' }}>
                                    Failed</option>
                            </select>
                            <button type="submit"
                                class="px-4 py-2 bg-gray-800 text-white text-sm font-medium rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-300">
                                Update Status
                            </button>
                        </form>
                    </div>

                    <!-- Order Items -->
                    <div>
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Order Items</h3>
                        <div class="overflow-x-auto">
                            <table class="w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th
                                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Product</th>
                                        <th
                                            class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Quantity</th>
                                        <th
                                            class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Price</th>
                                        <th
                                            class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Total</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td class="px-4 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $item->product->name }}</div>
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                                {{ $item->quantity }}
                                            </td>
                                            <td class="px-4 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                                                Kshs {{ number_format($item->price, 2) }}
                                            </td>
                                            <td
                                                class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900">
                                                Kshs {{ number_format($item->quantity * $item->price, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-50">
                                    <tr>
                                        <td colspan="3"
                                            class="px-4 py-4 text-right text-sm font-medium text-gray-900">Total:</td>
                                        <td class="px-4 py-4 text-right text-sm font-medium text-gray-900">
                                            Kshs {{ number_format($order->total, 2) }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
