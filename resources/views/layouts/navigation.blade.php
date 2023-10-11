<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a id="parent-slide-top" href="{{ config('projobi.logout_redirect') }}" class="flex items-end">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800" />
                        <p class="font-bold text-2xl text-main flex items-center slide-top slide-right">
                            <svg id="use-slide-top" class="h-6 slide-top-out" fill="#0ec6d5" viewBox="-102.4 -102.4 1228.80 1228.80" xmlns="http://www.w3.org/2000/svg" stroke="#0ec6d5" transform="rotate(0)"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"><path d="M222.927 580.115l301.354 328.512c24.354 28.708 20.825 71.724-7.883 96.078s-71.724 20.825-96.078-7.883L19.576 559.963a67.846 67.846 0 01-13.784-20.022 68.03 68.03 0 01-5.977-29.488l.001-.063a68.343 68.343 0 017.265-29.134 68.28 68.28 0 011.384-2.6 67.59 67.59 0 0110.102-13.687L429.966 21.113c25.592-27.611 68.721-29.247 96.331-3.656s29.247 68.721 3.656 96.331L224.088 443.784h730.46c37.647 0 68.166 30.519 68.166 68.166s-30.519 68.166-68.166 68.166H222.927z"></path></g></svg>    
                            <span id="use-slide-right">
                                volver
                            </span>
                        </p>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('billing.payment_method_form')" :active="request()->routeIs('billing.payment_method_form')">
                        {{ __('Método de pago') }}
                    </x-nav-link>
                    @if (!isSubscribed())
                    <x-nav-link :href="route('billing.plans')" :active="request()->routeIs('billing.plans')">
                        {{ __('Planes') }}
                    </x-nav-link>
                    @endif
                    <x-nav-link :href="route('billing.my_subscription')" :active="request()->routeIs('billing.my_subscription')">
                        {{ __('Mi suscripción') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="hidden ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                    <div class="hidden">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>
                    </div>   
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Volver a projobi') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
        <div class="space-x-8 sm:-my-px sm:ml-10 sm:flex">
            <x-nav-link :href="route('billing.payment_method_form')" :active="request()->routeIs('billing.payment_method_form')">
                {{ __('Método de pago') }}
            </x-responsive-nav-link>
            @if (!isSubscribed())
            <x-nav-link :href="route('billing.plans')" :active="request()->routeIs('billing.plans')">
                {{ __('Planes') }}
            </x-responsive-nav-link>
            @endif
            <x-nav-link :href="route('billing.my_subscription')" :active="request()->routeIs('billing.my_subscription')">
                {{ __('Mi suscripción') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="hidden mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Volver a projobi') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>


@push('scripts')
    <script>
        const parentAniTopElement = document.querySelector('#parent-slide-top');
        const aniTopChildElement = document.querySelector('#use-slide-top');
        const aniRightChildElement = document.querySelector('#use-slide-right');

        parentAniTopElement.addEventListener('mouseover', () => {
            aniTopChildElement.classList.remove('slide-top-out');
            aniTopChildElement.classList.add('slide-top');

            aniRightChildElement.classList.remove('slide-right-out');
            aniRightChildElement.classList.add('slide-right');
        });
        parentAniTopElement.addEventListener('mouseout', () => {
            aniTopChildElement.classList.remove('slide-top');
            aniTopChildElement.classList.add('slide-top-out');

            aniRightChildElement.classList.remove('slide-right');
            aniRightChildElement.classList.add('slide-right-out');
        });
    </script>
@endpush