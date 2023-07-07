<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold leading-tight text-gray-800">
            {{ __('Payment Succesful...') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <iframe src="https://embed.lottiefiles.com/animation/34109"></iframe>
        </div>
    </div>

</x-app-layout>

<style>
    iframe {
        /* Centre the iframe */
        position: absolute;
        top: 60%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 500px;
        height: 500px;
    }
</style>