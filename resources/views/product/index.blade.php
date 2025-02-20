<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight my-2">
                {{ __('Products') }}
            </h2>
            <a href="{{ route('product.create') }}">
                <x-primary-button>
                    Create
                </x-primary-button>
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @forelse ($products as $product)
                        <div class="flex pb-3 items-center justify-between odd:border-b-2">
                            <div>
                                <a href="{{ route('product.show', $product->id) }}">
                                    <h2 class="text-lg font-semibold">{{ $product->name }}</h2>
                                </a>
                                <p class="text-sm text-gray-600">R$ {{ $product->price }}</p>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('product.buy', $product->id) }}">
                                    <x-primary-button>
                                        Comprar
                                    </x-primary-button>
                                </a>
                            </div>
                        </div>
                    @empty
                        <h2>Any product found</h2>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>