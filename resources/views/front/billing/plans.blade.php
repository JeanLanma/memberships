<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Planes disponibles
        </h2>
    </x-slot>

    <div class="py-12">
        <section class="text-gray-600 body-font overflow-hidden">
            <div class="container px-5 mx-auto">
                <div class="flex flex-wrap -m-4">
                    @foreach($plans as $plan)
                        <div class="p-4 xl:w-1/3 md:w-1/3 w-full">
                            <div class="h-full p-6 rounded-lg border-2 border-main  flex flex-col relative overflow-hidden">
                                @if($plan->interval_count === 1)
                                    <span class="bg-main text-white px-3 py-1 tracking-widest text-xs absolute right-0 top-0 rounded-bl">
                                        POPULAR
                                    </span>
                                @endif
                                <h2 class="text-sm tracking-widest title-font mb-1 font-medium">
                                    {{ getPlanNameByStripePlan($plan) }}
                                </h2>
                                <h1 class="text-5xl text-gray-900 leading-none flex items-center pb-4 mb-4 border-b border-gray-200">
                                    <span>{{ formatCurrency($plan->amount / 100) }}</span>
                                </h1>
                                <p class="flex items-center text-gray-600 mb-2">
                                    <span class="w-4 h-4 mr-2 inline-flex items-center justify-center bg-gray-400 text-white rounded-full flex-shrink-0">
                                      <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                           stroke-width="2.5" class="w-3 h-3" viewBox="0 0 24 24">
                                        <path d="M20 6L9 17l-5-5"></path>
                                      </svg>
                                    </span>
                                    Acceso completo a la plataforma
                                </p>

                                <form method="post" action="{{ route('billing.process_subscription') }}">
                                    @csrf
                                    <input type="hidden" name="price_id" value="{{ $plan->id }}" />
                                    <button type="submit" class="flex items-center mt-auto text-white bg-main  border-0 py-2 px-4 w-full focus:outline-none hover:bg-main/50 rounded">
                                        Apuntarme
                                        <svg fill="none" stroke="currentColor" stroke-linecap="round"
                                             stroke-linejoin="round" stroke-width="2" class="w-4 h-4 ml-auto"
                                             viewBox="0 0 24 24">
                                            <path d="M5 12h14M12 5l7 7-7 7"></path>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    </div>
</x-app-layout>