<div class="mb-4">
    <x-input-label for="name" :value="__('Name')" />
    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
        :value="$product->name ?? null" required autofocus />
    <x-input-error :messages="$errors->get('name')" class="mt-2" />
</div>
<div class="mb-4">
    <x-input-label for="price" :value="__('Price')" />
    <x-text-input id="price" class="block mt-1 w-full" type="number" step="any" name="price"
        :value="$product->price ?? ''" required autofocus />
    <x-input-error :messages="$errors->get('price')" class="mt-2" />
</div>
<div class="flex justify-center gap-4">
    <a href="{{ route('products.index') }}">
        <x-secondary-button type="button">
            Voltar
        </x-secondary-button>
    </a>
    <x-primary-button>
        Salvar
    </x-primary-button>
</div>