<x-guest-layout>
    <form method="POST" action="{{ route('AddFood') }}" enctype="multipart/form-data">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block w-full mt-1" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Description -->
        <div class="mt-4">
            <x-input-label for="description" :value="__('Description')" />
            <x-text-input id="description" class="block w-full mt-1" type="text" name="description" :value="old('description')" required />
            <x-input-error :messages="$errors->get('description')" class="mt-2" />
        </div>

        <!-- Price -->
        <div class="mt-4">
            <x-input-label for="price" :value="__('Price')" />
            <x-text-input id="price" class="block w-full mt-1" type="text" name="price" :value="old('price')" required />
            <x-input-error :messages="$errors->get('price')" class="mt-2" />
        </div>

        <!-- Category -->
        <div class="mt-4">
            <x-input-label for="category" :value="__('Category')" />
            <x-text-input id="category" class="block w-full mt-1" type="text" name="category" :value="old('category')" required />
            <x-input-error :messages="$errors->get('category')" class="mt-2" />
        </div>

        <!-- Ingredients -->
        <div class="mt-4">
            <x-input-label for="ingredients" :value="__('Ingredients')" />
            <x-text-input id="ingredients" class="block w-full mt-1" type="text" name="ingredients" :value="old('ingredients')" required />
            <x-input-error :messages="$errors->get('ingredients')" class="mt-2" />
        </div>

        <!-- Image (File Upload) -->
        <div class="mt-4">
            <x-input-label for="image" :value="__('Image')" />
            <x-file-input id="image" class="block w-full mt-1" type="file" name="image" :value="old('image')" required />
            <x-input-error :messages="$errors->get('image')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ml-4">
                {{ __('AddFoodItem') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>