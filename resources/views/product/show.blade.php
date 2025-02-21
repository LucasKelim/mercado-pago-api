<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight my-2">
                {{ __('Products') }}
            </h2>
            <div class="flex justify-end">
                <a href="{{ route('products.edit', $product->id) }}">
                    <x-secondary-button>
                        Edit
                    </x-secondary-button>
                </a>
                <x-primary-button
                    class="ms-3"
                    x-data=""
                    x-on:click.prevent="$dispatch('open-modal', 'confirm-product-deletion')">
                    Delete
                </x-primary-button>
                <x-modal name="confirm-product-deletion" focusable>
                    <form method="post" action="{{ route('products.destroy', $product->id) }}" class="p-6">
                        @csrf
                        @method('delete')
            
                        <h2 class="text-lg font-medium text-gray-900">
                            {{ __('Are you sure you want to delete this product?') }}
                        </h2>
            
                        <p class="mt-1 text-sm text-gray-600">
                            {{ __('Once this product is deleted, all of its resources and data will be permanently deleted.') }}
                        </p>
            
                        <div class="mt-6 flex justify-end">
                            <x-secondary-button x-on:click="$dispatch('close')">
                                {{ __('Cancel') }}
                            </x-secondary-button>
            
                            <x-danger-button class="ms-3">
                                {{ __('Delete Product') }}
                            </x-danger-button>
                        </div>
                    </form>
                </x-modal>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-lg font-semibold">{{ $product->name }}</h2>
                    <p class="text-sm text-gray-600">R$ {{ $product->price }}</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>