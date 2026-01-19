<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mini-Shop') }}
        </h2>
    </x-slot>

    <div class="py-12 px-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-12">
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
                <!-- Hero Section with Gradient Background -->
                <div
                    class="bg-gradient-to-r from-blue-600 via-purple-600 to-indigo-700 rounded-2xl overflow-hidden shadow-2xl">
                    <div class="px-6 py-24 sm:px-8 lg:px-12 text-center">
                        <h2 class="text-5xl md:text-6xl font-bold mb-8 text-white drop-shadow-lg">Welcome to Mini Shop
                        </h2>
                        <p class="text-xl md:text-2xl mb-10 text-blue-100 font-medium">
                            Discover quality products at amazing prices
                        </p>
                        <a href="{{ route('catalog.index') }}"
                            class="inline-block bg-white text-gray-800 px-10 py-4 rounded-xl text-lg font-bold hover:bg-gray-50 transition-all duration-300 transform hover:scale-105 shadow-lg hover:shadow-xl">
                            Shop Now
                        </a>
                    </div>
                </div>

                <!-- Categories Section -->
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h3 class="text-3xl font-bold text-gray-800 mb-12 text-center">Shop by Category</h3>

                    <!-- Categories Grid -->
                    <div class="grid grid-cols-2 lg:grid-cols-3 gap-2 sm:gap-4 lg:gap-6">
                        @foreach ($categories as $category)
                            <a href="{{ route('catalog.index', ['category' => $category->id]) }}"
                                class="bg-white border-2 border-gray-100 rounded-xl hover:border-blue-300 hover:shadow-xl transition-all duration-300 p-8 flex flex-col items-center justify-center group transform hover:-translate-y-1">
                                <div class="mb-6 transform group-hover:scale-110 transition duration-300">
                                    {!! App\Helpers\CategoryIconHelper::getIcon($category->name, 'w-20 h-20') !!}
                                </div>
                                <h4 class="text-xl font-bold text-gray-800 capitalize mb-3">{{ $category->name }}</h4>
                                <p class="text-sm text-gray-600 bg-gray-50 px-3 py-1 rounded-full">
                                    {{ $category->products_count }} items</p>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Best Selling Products -->
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h3 class="text-3xl font-bold text-gray-800 mb-12 text-center">Best Selling Products</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @forelse($bestSellingProducts as $product)
                            <x-product-card :product="$product" type="card" />
                        @empty
                            <div class="col-span-full text-center text-gray-500 py-16">
                                <div class="text-6xl mb-4">📦</div>
                                <p class="text-xl">No products available yet.</p>
                            </div>
                        @endforelse
                    </div>

                    <div class="text-center mt-8">
                        <a href="{{ route('catalog.index') }}"
                            class="inline-block bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-12 py-4 rounded-xl text-lg font-bold hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 transform hover:scale-105 shadow-lg">
                            View Catalog
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
