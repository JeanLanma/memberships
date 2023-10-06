<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mi suscripción
        </h2>
    </x-slot>

    <div class="py-12">

        @if(isSubscribed())
            
        <section class="text-gray-600 body-font max-w-7xl mx-auto">
            <div class="container px-5 py-12 md:py-12 mx-auto">
                <div class="bg-white shadow-sm sm:rounded-lg p-3 sm:p-6 flex flex-col md:flex-row sm:items-center items-start mx-auto">
                    <h1 class="flex-grow sm:pr-16 text-2xl font-medium title-font text-gray-900">Te agradecemos por ser parte de <span class="text-main font-bold">Projobi</span>. Disfruta de tu <span class="text-main font-bold">Plan {{ $subscription }}</span>. <br> <span class="text-xl font-normal">Puedes administrar tu subscripción desde el portal de facturación.</span></h1>
                    <a href="{{ route('billing.portal') }}" class="flex-shrink-0">
                        <button class="text-white border-0 py-2 px-8 focus:outline-none bg-main hover:bg-main/50 rounded text-lg mt-10 md:mt-0 uppercase font-bold transition-all duration-300">Administrar mi subscripción</button>
                    </a>
                </div>
            </div>
        </section>

        @else
            
        <section class="text-gray-600 body-font max-w-7xl mx-auto">
            <div class="container px-5 sm:px-8 py-12 mx-auto">
                <div class="flex flex-col sm:flex-row sm:items-center items-start mx-auto">
                    <h1 class="flex-grow sm:pr-16 text-2xl font-medium title-font text-gray-900">Felicidades por unirte a <span class="text-main font-bold">Projobi</span>. Comienza a disfrutar de todos los beneficios que tenemos para ti ahora!</h1>
                </div>
                <div class="flex flex-col sm:flex-row justify-center gap-8 mt-8 sm:mt-16">

                    <div class="group bg-gray-50 shadow-lg rounded flex p-4 h-full items-center hover:shadow-2xl transition-shadow duration-200 cursor-pointer">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="text-indigo-500 w-6 h-6 flex-shrink-0 mr-4" viewBox="0 0 24 24">
                            <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                            <path d="M22 4L12 14.01l-3-3"></path>
                        </svg>
                        <p class="text-xl font-bold group-hover:text-main transition-colors duration-150">Agrega un metodo de pago</p>
                    </div>

                    <div class="group bg-gray-50 shadow-lg rounded flex p-4 h-full items-center hover:shadow-2xl transition-shadow duration-200 cursor-pointer">
                        <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" class="text-indigo-500 w-6 h-6 flex-shrink-0 mr-4" viewBox="0 0 24 24">
                            <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                            <path d="M22 4L12 14.01l-3-3"></path>
                        </svg>
                        <p class="text-xl font-bold group-hover:text-main transition-colors duration-150">Elige el mejor plan para ti</p>
                    </div>
                    
                </div>
            </div>
        </section>

        @endif

        <div class="hidden max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="-my-8 divide-y-2 divide-gray-100 bg-gray-400 p-4">
                <div class="py-8 flex flex-wrap md:flex-nowrap">
                    <div class="md:w-64 md:mb-0 mb-6 flex-shrink-0 flex flex-col">
                        <span class="font-semibold title-font text-white">Plan contratado: {{ $subscription }}</span>
                    </div>
                    <div class="md:flex-grow">
                        <a href="{{ route('billing.portal') }}" class="text-white bg-main border-0 py-2 px-4 focus:outline-none hover:bg-main/50 rounded">Ver mi facturación</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>