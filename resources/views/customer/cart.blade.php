<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Cart') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                <table>
                    <thead>
                        <tr>
                            <th>Product Name</th>
                            <th>Product Image</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        {{-- If there are no cartItems --}}
                        @if (Cart::count() == 0)
                            <tr>
                                <td colspan="5">No items in cart.</td>
                            </tr>
                        @else
                            @foreach ($cartItems as $cartItem) 
                                <tr>
                                    <td>{{ $cartItem->name }}</td>
                                    <td>
                                        <img src="{{ asset($cartItem->options->image) }}" alt="{{ $cartItem->name }}">
                                    </td>
                                    <td>{{ $cartItem->qty }}</td>
                                    <td>{{ $cartItem->price }}</td>
                                    <td>
                                        <form method="POST" action="{{ route('customer/removeCartItem') }}">
                                            @csrf
                                            <input type="hidden" name="rowId" value="{{ $cartItem->rowId }}">
                                            <x-primary-button class="ml-4">
                                                {{ __('Remove') }}
                                            </x-primary-button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            
                            <tr class="Checkout">
                                <th>SubTotal:</th>
                                <td>{{ Cart::subtotal() }}</td>
                            </tr>

                            <tr class="Checkout">
                                <th>Tax:</th>
                                <td>{{ Cart::tax() }}</td>

                            </tr>

                            <tr class="Checkout">
                                <th>Total:</th>
                                <td>{{ Cart::total() }}</td>
                            </tr>

                            <tr class="Checkout">
                                <td>
                                    <form method="GET" action=" {{ route('customer/payment') }}">
                                        @csrf
                                        <x-primary-button class="ml-4">
                                            {{ __('Checkout') }}
                                        </x-primary-button>
                                    </form>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>

<style>
    tr {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        padding-left: 2em;
        padding-bottom: 2em;
        column-gap: 8em;
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
    thead tr {
        padding-top: 2em;
    }
    .Checkout {
        display: flex;
        justify-content: flex-end;
    }
</style>