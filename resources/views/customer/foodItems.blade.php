<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('FoodHaven List') }}
        </h2>
    </x-slot>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Ingredients</th>
                                <th>Image</th>
                                <th>Quantity</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody >
                            @foreach ($foodItems as $food)
                            <tr>
                                <td>{{ $food->name }}</td>
                                <td>{{ $food->description }}</td>
                                <td>Rs. {{ $food->price }}</td>
                                <td>{{ $food->ingredients }}</td>
                                <td>
                                    <img src="{{ asset($food->image) }}" alt="{{ $food->name }}">
                                </td>
                                <form method="POST" action="{{ route('customer/addToCart') }}">
                                    @csrf
                                    <td>
                                        <input type="number" name="quantity" value="1" min="1" max="100">
                                    </td>
                                    <td>
                                        <input type="hidden" name="food_id" value="{{ $food->id }}">
                                        <input type="hidden" name="customer_id" value="{{ Auth::user()->id }}">
                                        <x-primary-button class="ml-4">
                                            {{ __('Add to Cart') }}
                                        </x-primary-button>
                                    </td>
                                </form>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

</x-app-layout>

<style>
    tr {
        display: grid;
        grid-template-columns: repeat(7, 1fr);
        align-items: center;
        justify-items: center;
    }

    img {
        width: 100px;
        height: 100px;
    }

    input {
        width: 50px;
        height: 50px;
    }
</style>