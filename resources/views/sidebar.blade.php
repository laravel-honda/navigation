<div x-data="{ open: false }">
    <div class="min-h-screen h-full flex">
        <div
            class="fixed inset-y-0 left-0 w-full flex justify-between flex-col max-w-xs bg-gray-800 lg:static lg:inset-auto lg:translate-x-0 transform transition duration-300 z-40 ease-in"
            x-bind:class="{ '-translate-x-full': !open, '-translate-x-0': open }">
            <div>
                <div class="flex items-center justify-between bg-gray-900 p-4">
                    <div class="flex-1">
                        <div class="mx-2 my-3">
                            <x-application-logo context="sidebar"/>
                        </div>
                    </div>
                </div>
                <button @click="open = false"
                        x-show="open"
                        class="absolute top-0 right-0 -mr-12 text-white mt-2 p-2 lg:hidden focus:outline-none">
                    <x-ui-icon name="x" size="6"/>
                </button>
                <nav>
                    <div class="px-3 mt-4 space-y-2 lg:space-y-3">
                        @foreach($items as $item)
                            @if ($item instanceof \Honda\Navigation\Item)
                                <a href="{{ $item->href }}"
                                   class="transition duration-100 flex items-center px-4 @if ($item->icon) py-3 @else py-3.5 @endif rounded-lg @if ($item->isActive()) bg-gray-900 @else hover:bg-gray-900 @endif"
                                   @if ($item->isActive()) aria-current="page" @endif>
                                    @if ($item->icon)
                                        <x-ui-icon name="{{ $item->icon }}" size="5" class="text-gray-500"
                                                   icon-set="{{ $item->iconSet }}"/>
                                    @endif
                                    <span
                                        class="font-medium leading-none text-gray-300 inline-block @if ($item->icon) ml-3 @endif">{{ $item->name }}</span>
                                </a>
                            @else
                                <div class="space-y-2 lg:space-y-3">
                                    @if ($item->name)
                                        <span
                                            class="inline-block mt-4 px-1 text-gray-500 uppercase font-bold text-xs tracking-widest">{{ $item->name}}</span>
                                    @endif
                                    @foreach($item->tree() as $child)
                                        <a href="{{ $child->href }}"
                                           class="transition duration-100 flex items-center px-4 @if ($child->icon) py-3 @else py-3.5 @endif rounded-lg @if ($child->isActive()) bg-gray-900 @else hover:bg-gray-900 @endif"
                                           @if ($child->isActive()) aria-current="page" @endif>
                                            @if ($child->icon)
                                                <x-ui-icon name="{{ $child->icon }}" size="5" class="text-gray-500"
                                                           icon-set="{{ $child->iconSet }}"/>
                                            @endif
                                            <span
                                                class="font-medium leading-none text-gray-300 inline-block @if ($child->icon) ml-3 @endif">{{ $child->name }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        @endforeach
                    </div>
                </nav>
            </div>

            {{ $footer ?? '' }}
        </div>
        <button x-show="open" @click="open = false" class="bg-gray-900 bg-opacity-50 w-full h-full fixed z-30"></button>
        <div class="flex-1 min-w-0 flex flex-col bg-gray-50 pb-10">
            <div class="flex-shrink-0">
                <header class="fixed top-0 inset-x-0 lg:static flex items-center bg-white shadow lg:h-20 z-20">
                    <button
                        @click="open = true"
                        class="text-gray-500 focus:outline-none hover:bg-gray-100 lg:hidden p-4 border-r border-gray-200">
                        <svg fill="none" viewbox="0 0 24 24" class="h-6 w-6">
                            <path d="M4 6h16M4 12h16M4 18h7" stroke-linecap="round" stroke-width="2"
                                  stroke="currentColor"></path>
                        </svg>
                    </button>

                    <div class="ml-4">
                        @if (isset($header))
                            {{ $header }}
                        @else
                            <x-application-logo context="sidebar"/>
                        @endif
                    </div>
                </header>
            </div>
            {{ $slot }}
        </div>
    </div>
</div>
