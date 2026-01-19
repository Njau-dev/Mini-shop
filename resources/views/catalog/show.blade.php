<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Product Details') }}
            </h2>

            <x-admin.breadcrumbs :items="[['label' => 'Catalog', 'href' => route('catalog.index')], ['label' => 'Product']]" />
        </div>
    </x-slot>

    <div class="py-8 sm:py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 px-4">
            @if (session('success'))
                <div class="mb-6 bg-green-50 border border-green-400 text-green-700 px-4 py-3 rounded-xl relative shadow-sm">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 bg-red-50 border border-red-400 text-red-700 px-4 py-3 rounded-xl relative shadow-sm">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif
            <!-- Product Details -->
            <div class="bg-white shadow-xl sm:rounded-2xl overflow-hidden mb-8 sm:mb-12">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-6 sm:p-8">
                    <!-- Product Image -->
                    <div
                        class="aspect-square bg-gradient-to-br from-gray-50 to-gray-100 rounded-2xl flex items-center justify-center p-8">
                        <div class="text-center">
                            <div class="mb-4">
                                {!! App\Helpers\CategoryIconHelper::getIcon($product->category->name ?? 'default', 'w-24 h-24 text-black') !!}
                            </div>
                            <span
                                class="text-sm text-gray-500 capitalize">{{ $product->category->name ?? 'Product' }}</span>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="flex flex-col">
                        <div class="mb-4">
                            <a href="{{ route('catalog.index', ['category' => $product->category_id]) }}"
                                class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-800 transition-colors duration-200 group">
                                <span class="text-sm font-medium capitalize">{{ $product->category->name }}</span>
                            </a>
                        </div>

                        <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 mb-4 leading-tight">
                            {{ $product->name }}
                        </h1>

                        <div class="flex items-center gap-4 mb-6">
                            <span class="text-4xl sm:text-5xl font-bold text-blue-600">
                                KSh {{ number_format($product->price, 2) }}
                            </span>
                        </div>

                        <div class="mb-6">
                            <div class="flex items-center gap-2">
                                <span class="text-sm font-medium text-gray-700">Availability:</span>
                                @if ($product->stock > 0)
                                    <span class="text-sm text-green-600 font-medium">
                                        In Stock ({{ $product->stock }} units)
                                    </span>
                                @else
                                    <span class="text-sm text-red-600 font-medium">
                                        Out of Stock
                                    </span>
                                @endif
                            </div>
                        </div>


                        <div class="border-t border-b border-gray-200 py-6 mb-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-3">Description</h3>
                            <p class="text-gray-600 leading-relaxed">
                                {{ $product->description ?: 'No description available for this product.' }}
                            </p>
                        </div>

                        <!-- Add to Cart Form -->
                        <form method="POST" action="{{ route('cart.add', ['id' => $product->id]) }}" class="mb-6">
                            @csrf
                            <div class="flex flex-col sm:flex-row gap-4">
                                <div class="flex items-center gap-3">
                                    <label class="text-sm font-medium text-gray-700">Quantity:</label>
                                    <input type="number" name="quantity" value="1" min="1"
                                        max="{{ $product->stock }}"
                                        class="w-20 px-3 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent text-center"
                                        {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                </div>
                                <button type="submit"
                                    class="flex-1 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold py-3.5 px-6 rounded-xl transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-3 shadow-lg hover:shadow-xl disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none"
                                    {{ $product->stock <= 0 ? 'disabled' : '' }}>
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    {{ $product->stock <= 0 ? 'Out of Stock' : 'Add to Cart' }}
                                </button>
                            </div>
                        </form>

                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ route('catalog.index') }}"
                                class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3.5 px-6 rounded-xl text-center transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 19l-7-7 7-7" />
                                </svg>
                                Continue Shopping
                            </a>
                            <a href="{{ route('cart.index') }}"
                                class="flex-1 bg-gradient-to-r from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-medium py-3.5 px-6 rounded-xl text-center transition-all duration-300 transform hover:scale-105 flex items-center justify-center gap-2">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                View Cart
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Related Products -->
            @if ($relatedProducts->count() > 0)
                <div class="bg-white shadow-xl sm:rounded-2xl overflow-hidden">
                    <div class="p-6 sm:p-8">
                        <div class="flex items-center justify-between mb-6 sm:mb-8">
                            <h3 class="text-2xl font-bold text-gray-900">Related Products</h3>
                            <a href="{{ route('catalog.index', ['category' => $product->category_id]) }}"
                                class="text-blue-600 hover:text-blue-800 font-medium text-sm flex items-center gap-2 transition-colors duration-200">
                                View All
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5l7 7-7 7" />
                                </svg>
                            </a>
                        </div>
                        <div class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                            @foreach ($relatedProducts as $related)
                                <x-product-card :product="$related" type="card"
                                    class="transform hover:-translate-y-1 transition-all duration-300" />
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
