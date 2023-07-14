<x-guest-layout>

    <form method="POST" action="{{ route('addRole') }}">
        @csrf

        <div class="py-12">
            <div class="mt-4">

                <text-input @disabled(true)>Google</text-input>

                <input type="hidden" name="id" value="{{ $user->id }}">

                <input type="text" value="{{ $user->name }}" readonly class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-center" />
                <input type="text" value="{{ $user->email }}" readonly class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 text-center" />

                <br>

                <x-input-label for="role" :value="__('Role')" />

                <select id="role" name="role" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                    <option value="customer">Customer</option>
                    <option value="driver">Driver</option>
                    <option value="cook">Cook</option>
                </select>

                <x-input-error :messages="$errors->get('role')" class="mt-2" />
            </div>
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ml-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
        
    </form>
</x-guest-layout>