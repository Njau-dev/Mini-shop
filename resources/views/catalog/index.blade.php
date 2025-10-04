<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Catalogue') }}
        </h2>

        <x-admin.breadcrumbs :items="[['label' => 'Catalog']]" />
    </x-slot>

    <div class="py-8 sm:py-12 px-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Header Section with Product Count and Filters -->
            <div class="bg-white shadow-lg sm:rounded-2xl mb-8">
                <div class="p-6">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">

                        <!-- Product Count -->
                        <div class="text-center lg:text-left">
                            <h3 class="text-xl font-bold text-gray-900">
                                All Products
                                <span class="text-sm font-semibold text-blue-600 ml-2">
                                    ({{ number_format($totalProducts) }} items)
                                </span>
                            </h3>
                        </div>

                        <!-- Search and Filters -->
                        <div class="flex flex-col sm:flex-row gap-4 flex-1 lg:max-w-2xl">
                            <!-- Search Bar -->
                            <form method="GET" action="{{ route('catalog.index') }}" class="flex-1">
                                <input type="hidden" name="category" value="{{ request('category') }}">
                                <input type="hidden" name="sort" value="{{ request('sort') }}">
                                <input type="hidden" name="view" value="{{ request('view') }}">
                                <div class="relative">
                                    <input type="text" name="search" value="{{ request('search') }}"
                                        placeholder="Search products..."
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm sm:text-base">
                                    <button type="submit"
                                        class="absolute right-3 top-3 text-gray-400 hover:text-blue-600 transition-colors duration-200">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </form>

                            <!-- Category Filter -->
                            <form method="GET" action="{{ route('catalog.index') }}" id="categoryForm"
                                class="w-full sm:w-auto">
                                <input type="hidden" name="search" value="{{ request('search') }}">
                                <input type="hidden" name="sort" value="{{ request('sort') }}">
                                <input type="hidden" name="view" value="{{ request('view') }}">
                                <select name="category" onchange="document.getElementById('categoryForm').submit()"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm sm:text-base">
                                    <option value="">All Categories</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}"
                                            {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }} ({{ $category->products_count }})
                                        </option>
                                    @endforeach
                                </select>
                            </form>
                        </div>
                    </div>

                    <!-- Sorting and View Toggle -->
                    <div
                        class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mt-6 pt-6 border-t border-gray-200">
                        <!-- Sort Options -->
                        <form method="GET" action="{{ route('catalog.index') }}" id="sortForm"
                            class="w-full sm:w-auto">
                            <input type="hidden" name="search" value="{{ request('search') }}">
                            <input type="hidden" name="category" value="{{ request('category') }}">
                            <input type="hidden" name="view" value="{{ request('view') }}">
                            <div class="flex items-center gap-3">
                                <label class="text-sm font-medium text-gray-700">Sort by:</label>
                                <select name="sort" onchange="document.getElementById('sortForm').submit()"
                                    class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full sm:w-auto">
                                    <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name (A-Z)
                                    </option>
                                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>
                                        Price (Low to High)</option>
                                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>
                                        Price (High to Low)</option>
                                    <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest
                                        First</option>
                                </select>
                            </div>
                        </form>

                        <!-- View Toggle -->
                        <div class="flex items-center gap-3 w-full sm:w-auto justify-between sm:justify-start">
                            <span class="text-sm font-medium text-gray-700">View:</span>
                            <div class="flex border border-gray-300 rounded-lg overflow-hidden">
                                <a href="{{ route('catalog.index', array_merge(request()->except('view'), ['view' => 'grid'])) }}"
                                    class="px-4 py-2.5 transition-all duration-200 {{ $viewMode == 'grid' ? 'bg-blue-500 text-white' : 'bg-white text-gray-600 hover:bg-gray-50' }}">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                    </svg>
                                </a>
                                <a href="{{ route('catalog.index', array_merge(request()->except('view'), ['view' => 'list'])) }}"
                                    class="px-4 py-2.5 transition-all duration-200 {{ $viewMode == 'list' ? 'bg-blue-500 text-white' : 'bg-white text-gray-600 hover:bg-gray-50' }}">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Products Display -->
            @if ($products->count() > 0)
                @if ($viewMode == 'grid')
                    <!-- Grid View using Product Card Component -->
                    <div
                        class="grid grid-cols-1 xs:grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
                        @foreach ($products as $product)
                            <x-product-card :product="$product" type="card" />
                        @endforeach
                    </div>
                @else
                    <!-- List View using Product Tile Component -->
                    <div class="space-y-6">
                        @foreach ($products as $product)
                            <x-product-card :product="$product" type="tile"
                                class="transform hover:-translate-y-0.5 transition-all duration-200" />
                        @endforeach
                    </div>
                @endif

                <!-- Pagination -->
                <div class="mt-8 sm:mt-12">
                    {{ $products->links() }}
                </div>
            @else
                <!-- No Products Found -->
                <div class="bg-white shadow-lg sm:rounded-2xl overflow-hidden">
                    <div class="p-8 sm:p-12 md:p-16 text-center">
                        <div
                            class="mx-auto w-24 h-24 bg-gradient-to-br from-blue-50 to-indigo-100 rounded-full flex items-center justify-center mb-6">
                            <svg class="h-12 w-12 text-blue-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-3">No products found</h3>
                        <p class="text-gray-600 mb-6 max-w-md mx-auto">Try adjusting your search or filter to find what
                            you're looking for.</p>
                        <div class="flex flex-col sm:flex-row gap-3 justify-center">
                            <a href="{{ route('catalog.index') }}"
                                class="inline-flex items-center justify-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium rounded-xl transition-all duration-200 transform hover:scale-105 shadow-lg hover:shadow-xl">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                </svg>
                                Clear Filters
                            </a>
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-all duration-200">
                                <svg class="h-5 w-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
