@props(['product', 'type' => 'card'])

@if ($type === 'card')
    <!-- Card Version -->
    <div
        {{ $attributes->merge(['class' => 'bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-2xl transition-all duration-300 flex flex-col transform hover:-translate-y-1']) }}>

        <div class="w-full h-56 bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center">
            {!! App\Helpers\CategoryIconHelper::getIcon($product->category->name ?? 'default', 'w-16 h-16 text-black') !!}
        </div>
        <div class="p-4 flex flex-col flex-grow">
            <div class="flex items-center mb-3">
                <span
                    class="text-xs font-light text-gray-500 tracking-wide">{{ $product->category->name ?? 'N/A' }}</span>
            </div>
            <h4 class="text-lg font-bold text-gray-800 mb-3 leading-tight">{{ $product->name }}</h4>
            <p class="text-gray-600 text-sm mb-4 flex-grow line-clamp-2 leading-relaxed">
                {{ Str::limit($product->description, 80) }}
            </p>
            <div class="flex justify-between items-center mb-4">
                <span class="text-xl font-bold text-gray-900">Kshs {{ number_format($product->price, 2) }}</span>
                <span
                    class="text-xs px-3 py-1.5 rounded-full font-medium {{ $product->stock > 10 ? 'bg-green-100 text-green-800' : ($product->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                    {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                </span>
            </div>
            <a href="{{ route('catalog.show', $product->id) }}"
                class="w-full block text-center bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-4 py-3 rounded-lg text-sm font-semibold hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 transform hover:scale-105">
                View Details
            </a>
        </div>
    </div>
@elseif($type === 'tile')
    <!-- Tile Version (List Layout) -->
    <div
        {{ $attributes->merge(['class' => 'bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition-all duration-300 group']) }}>
        <div class="flex items-center p-4 gap-4">
            <!-- Icon on the left -->
            <div class="flex-shrink-0">
                <div
                    class="w-16 h-16 bg-gradient-to-br from-gray-50 to-gray-100 rounded-lg flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    {!! App\Helpers\CategoryIconHelper::getIcon(
                        $product->category->name ?? 'default',
                        'w-8 h-8 text-black group-hover:text-blue-600',
                    ) !!}
                </div>
            </div>

            <!-- Product info in the middle -->
            <div class="flex-grow min-w-0">
                <div class="flex items-center gap-3 mb-1">
                    <span
                        class="text-xs font-semibold text-blue-600 uppercase tracking-wide bg-blue-50 px-2 py-1 rounded">
                        {{ $product->category->name ?? 'N/A' }}
                    </span>
                    <span
                        class="text-xs px-2 py-1 rounded-full font-medium {{ $product->stock > 10 ? 'bg-green-100 text-green-800' : ($product->stock > 0 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                        {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
                    </span>
                </div>
                <h4 class="text-lg font-bold text-gray-800 mb-1 truncate">{{ $product->name }}</h4>
                <p class="text-gray-600 text-sm mb-2 line-clamp-2 leading-relaxed">
                    {{ Str::limit($product->description, 80) }}
                </p>
                <div class="flex items-center gap-4">
                    <span class="text-xl font-bold text-gray-900">Kshs {{ number_format($product->price, 2) }}</span>
                </div>
            </div>

            <!-- Action link on the right -->
            <div class="flex-shrink-0">
                <a href="{{ route('catalog.show', $product->id) }}"
                    class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white px-6 py-3 rounded-lg text-sm font-semibold hover:from-blue-700 hover:to-indigo-700 transition-all duration-300 transform hover:scale-105 whitespace-nowrap">
                    View Details
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        </div>
    </div>
@endif
