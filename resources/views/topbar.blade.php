<nav x-data="{ open: false }" class="bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 xl:px-0">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <div class="flex-shrink-0">
                    <x-application-logo context="topbar"/>
                </div>
                <div class="hidden md:block">
                    <div class="ml-10 flex items-center space-x-4">
                        @foreach($items as $item)
                            @if ($item instanceof \Honda\Navigation\Item)
                                @if ($item->isActive())
                                    <a href="{{ $item->href }}"
                                       class="bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium">{{ $item->name }}</a>
                                @else
                                    <a href="{{ $item->href }}"
                                       class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">{{ $item->name }}</a>
                                @endif
                            @else
                                <div class="relative" x-data="{ open: false }">
                                    <button
                                        type="button"
                                        @click="open = !open"
                                        @click.away="open = false"
                                        class="flex items-center text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium focus:outline-none"
                                        aria-expanded="false" x-bind:aria-expanded="open">{{ $item->name }}
                                        <x-ui-icon name="chevron-down"
                                                   size="4"
                                                   class="ml-2"/>
                                    </button>
                                    <div
                                        x-show="open"
                                        x-transition:enter="transition ease-out duration-200"
                                        x-transition:enter-start="opacity-0 translate-y-1"
                                        x-transition:enter-end="opacity-100 translate-y-0"
                                        x-transition:leave="transition ease-in duration-150"
                                        x-transition:leave-start="opacity-100 translate-y-0"
                                        x-transition:leave-end="opacity-0 translate-y-1"
                                        class="absolute z-10 left-1/2 transform -translate-x-1/2 mt-3.5 px-2 w-screen max-w-md sm:px-0">
                                        <div
                                            class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
                                            <div class="relative grid gap-6 bg-white px-5 py-6 sm:gap-8 sm:p-8">
                                                @foreach($item->tree() as $child)
                                                    <a href="{{ $child->href }}"
                                                       class="-m-3 p-3 flex items-start rounded-lg hover:bg-gray-50">
                                                        <x-ui-icon name="{{ $child->icon }}" size="6"
                                                                   class="flex-shrink-0 text-indigo-600"/>
                                                        <div class="ml-4">
                                                            <p class="text-base font-medium text-gray-900">
                                                                {{ $child->name }}
                                                            </p>
                                                            @if (!empty($child->description))
                                                                <p class="mt-1 text-sm text-gray-500">
                                                                    {{ $child->description }}
                                                                </p>
                                                            @endif
                                                        </div>
                                                    </a>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            {{ $slot }}
            <div class="-mr-2 flex md:hidden">
                <!-- Mobile menu button -->
                <button @click="open = !open"
                        class="bg-gray-800 inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white"
                        x-bind:aria-expanded="open">
                    <span class="sr-only">Open main menu</span>
                    <svg x-state:on="Menu open" x-state:off="Menu closed"
                         :class="{ 'hidden': open, 'block': !open }"
                         class="block h-6 w-6" x-description="tabler name: outline/menu"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor"
                         aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                    <svg x-state:on="Menu open" x-state:off="Menu closed"
                         :class="{ 'hidden': !open, 'block': open }"
                         class="hidden h-6 w-6" x-description="tabler name: outline/x"
                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                         stroke="currentColor"
                         aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div x-state:on="Open" x-state:off="closed"
         :class="{ 'block': open, 'hidden': !open }" class="hidden md:hidden">
        <div class="px-2 pt-2 pb-3 space-y-1 sm:px-3">
            @foreach($items as $item)
                @if ($item instanceof \Honda\Navigation\Item)
                    @if ($item->isActive())
                        <a href="{{ $item->href }}"
                           class="bg-gray-900 text-white block px-3 py-2 rounded-md text-base font-medium">{{ $item->name }}</a>
                    @else
                        <a href="{{ $item->href }}"
                           class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">{{ $item->name }}</a>
                    @endif
                @else
                    Dropdoune
                @endif
            @endforeach
        </div>

        {{ $slot }}
    </div>
</nav>
