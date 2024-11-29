@props(['name' => '', 'settingsUrl' => '', 'initials' => '', 'logoUrl' => ''])
<x-cms::layouts.app>
    <x-lb::partials.main max-width="full" :name="$name" :settings-url="$settingsUrl" :initials="$initials" :logo-url="$logoUrl">

        @section('page_title')
            @yield('page_title')
        @endsection

        <x-slot:heading>
            {{ $heading }}
        </x-slot>

        <x-slot:navigation>
            @if (View::hasSection('top'))
                @yield('top')
            @else
                <x-dynamic-component :component="config('cms.navigation.top')" />
            @endif
            <x-lb::navigate.divider>CMS</x-lb::navigate.divider>
            <x-lb::navigate.item :route="route(config('cms.route_prefix') . '.menus.index')" :is_active="request()->is(config('cms.route_prefix') . '/menus')" no-navigate>
                <x-slot:icon>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 14 14">
                        <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                            d="M12.25 1.81V.5M11 5.31c0 .66.53.88 1.25.88s1.25 0 1.25-.88C13.5 4 11 4 11 2.69c0-.88.53-.88 1.25-.88s1.25.33 1.25.88m-1.25 3.5V7.5m-9.75-4h-1a1 1 0 0 0-1 1V9a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V4.5a1 1 0 0 0-1-1M2 10v1.5m0-8v-3m6 7H7a1 1 0 0 0-1 1V10a1 1 0 0 0 1 1h1a1 1 0 0 0 1-1V8.5a1 1 0 0 0-1-1M7.5 11v2.5m0-6V4" />
                    </svg>
                </x-slot:icon>
                Menus
            </x-lb::navigate.item>
            <x-lb::navigate.item title="Pages" path="{{ config('cms.route_prefix') }}/pages*" hierarchy no-navigate>
                <x-slot:icon>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-3" viewBox="0 0 2048 2048">
                        <path fill="currentColor"
                            d="m960 120l832 416v1040l-832 415l-832-415V536zm625 456L960 264L719 384l621 314zM960 888l238-118l-622-314l-241 120zM256 680v816l640 320v-816zm768 1136l640-320V680l-640 320z" />
                    </svg>
                </x-slot:icon>
                <x-lb::navigate.item :route="route(config('cms.route_prefix') . '.pages.index')" :is_active="request()->is(config('cms.route_prefix') . '/pages') ||
                    request()->is(config('cms.route_prefix') . '/pages/*/edit')" no-navigate>
                    <x-slot:icon>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24">
                            <path fill="currentColor" fill-rule="evenodd"
                                d="M7.099 1.25H16.9c1.017 0 1.717 0 2.306.204a3.796 3.796 0 0 1 2.348 2.412l-.713.234l.713-.234c.196.597.195 1.307.195 2.36v14.148c0 1.466-1.727 2.338-2.864 1.297a.196.196 0 0 0-.271 0l-.484.442c-.928.85-2.334.85-3.262 0a.907.907 0 0 0-1.238 0c-.928.85-2.334.85-3.262 0a.907.907 0 0 0-1.238 0c-.928.85-2.334.85-3.262 0l-.483-.442a.196.196 0 0 0-.272 0c-1.137 1.04-2.864.169-2.864-1.297V6.227c0-1.054 0-1.764.195-2.361a3.795 3.795 0 0 1 2.348-2.412c.59-.205 1.289-.204 2.306-.204m.146 1.5c-1.221 0-1.642.01-1.96.121A2.296 2.296 0 0 0 3.87 4.334c-.111.338-.12.784-.12 2.036v14.004c0 .12.059.192.134.227a.2.2 0 0 0 .11.018a.194.194 0 0 0 .107-.055a1.695 1.695 0 0 1 2.296 0l.483.442a.907.907 0 0 0 1.238 0a2.407 2.407 0 0 1 3.262 0a.907.907 0 0 0 1.238 0a2.407 2.407 0 0 1 3.262 0a.907.907 0 0 0 1.238 0l.483-.442a1.695 1.695 0 0 1 2.296 0c.043.04.08.052.108.055a.2.2 0 0 0 .109-.018c.075-.035.135-.108.135-.227V6.37c0-1.252-.01-1.698-.12-2.037a2.296 2.296 0 0 0-1.416-1.462c-.317-.11-.738-.12-1.959-.12zM6.25 7.5A.75.75 0 0 1 7 6.75h.5a.75.75 0 0 1 0 1.5H7a.75.75 0 0 1-.75-.75m3.5 0a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-6.5a.75.75 0 0 1-.75-.75M6.25 11a.75.75 0 0 1 .75-.75h.5a.75.75 0 0 1 0 1.5H7a.75.75 0 0 1-.75-.75m3.5 0a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-6.5a.75.75 0 0 1-.75-.75m-3.5 3.5a.75.75 0 0 1 .75-.75h.5a.75.75 0 0 1 0 1.5H7a.75.75 0 0 1-.75-.75m3.5 0a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-6.5a.75.75 0 0 1-.75-.75"
                                clip-rule="evenodd" />
                        </svg>
                    </x-slot:icon>
                    Pages List
                </x-lb::navigate.item>
                <x-lb::navigate.item :route="route(config('cms.route_prefix') . '.pages.create')" :is_active="request()->is(config('cms.route_prefix') . '/pages/create')" no-navigate>
                    <x-slot:icon>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                            <path
                                d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                        </svg>
                    </x-slot:icon>
                    New Page
                </x-lb::navigate.item>
            </x-lb::navigate.item>
            <x-lb::navigate.item title="Themes" path="{{ config('cms.route_prefix') }}/themes*" hierarchy no-navigate>
                <x-slot:icon>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-3" viewBox="0 0 2048 2048">
                        <path fill="currentColor"
                            d="m960 120l832 416v1040l-832 415l-832-415V536zm625 456L960 264L719 384l621 314zM960 888l238-118l-622-314l-241 120zM256 680v816l640 320v-816zm768 1136l640-320V680l-640 320z" />
                    </svg>
                </x-slot:icon>
                <x-lb::navigate.item :route="route(config('cms.route_prefix') . '.themes.index')" :is_active="request()->is(config('cms.route_prefix') . '/themes')" no-navigate>
                    <x-slot:icon>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24">
                            <path fill="currentColor" fill-rule="evenodd"
                                d="M7.099 1.25H16.9c1.017 0 1.717 0 2.306.204a3.796 3.796 0 0 1 2.348 2.412l-.713.234l.713-.234c.196.597.195 1.307.195 2.36v14.148c0 1.466-1.727 2.338-2.864 1.297a.196.196 0 0 0-.271 0l-.484.442c-.928.85-2.334.85-3.262 0a.907.907 0 0 0-1.238 0c-.928.85-2.334.85-3.262 0a.907.907 0 0 0-1.238 0c-.928.85-2.334.85-3.262 0l-.483-.442a.196.196 0 0 0-.272 0c-1.137 1.04-2.864.169-2.864-1.297V6.227c0-1.054 0-1.764.195-2.361a3.795 3.795 0 0 1 2.348-2.412c.59-.205 1.289-.204 2.306-.204m.146 1.5c-1.221 0-1.642.01-1.96.121A2.296 2.296 0 0 0 3.87 4.334c-.111.338-.12.784-.12 2.036v14.004c0 .12.059.192.134.227a.2.2 0 0 0 .11.018a.194.194 0 0 0 .107-.055a1.695 1.695 0 0 1 2.296 0l.483.442a.907.907 0 0 0 1.238 0a2.407 2.407 0 0 1 3.262 0a.907.907 0 0 0 1.238 0a2.407 2.407 0 0 1 3.262 0a.907.907 0 0 0 1.238 0l.483-.442a1.695 1.695 0 0 1 2.296 0c.043.04.08.052.108.055a.2.2 0 0 0 .109-.018c.075-.035.135-.108.135-.227V6.37c0-1.252-.01-1.698-.12-2.037a2.296 2.296 0 0 0-1.416-1.462c-.317-.11-.738-.12-1.959-.12zM6.25 7.5A.75.75 0 0 1 7 6.75h.5a.75.75 0 0 1 0 1.5H7a.75.75 0 0 1-.75-.75m3.5 0a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-6.5a.75.75 0 0 1-.75-.75M6.25 11a.75.75 0 0 1 .75-.75h.5a.75.75 0 0 1 0 1.5H7a.75.75 0 0 1-.75-.75m3.5 0a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-6.5a.75.75 0 0 1-.75-.75m-3.5 3.5a.75.75 0 0 1 .75-.75h.5a.75.75 0 0 1 0 1.5H7a.75.75 0 0 1-.75-.75m3.5 0a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-6.5a.75.75 0 0 1-.75-.75"
                                clip-rule="evenodd" />
                        </svg>
                    </x-slot:icon>
                    Themes List
                </x-lb::navigate.item>
                <x-lb::navigate.item :route="route(config('cms.route_prefix') . '.themes.sections.index')" :is_active="request()->is(config('cms.route_prefix') . '/themes/sections')" no-navigate>
                    <x-slot:icon>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24">
                            <path fill="currentColor" fill-rule="evenodd"
                                d="M7.099 1.25H16.9c1.017 0 1.717 0 2.306.204a3.796 3.796 0 0 1 2.348 2.412l-.713.234l.713-.234c.196.597.195 1.307.195 2.36v14.148c0 1.466-1.727 2.338-2.864 1.297a.196.196 0 0 0-.271 0l-.484.442c-.928.85-2.334.85-3.262 0a.907.907 0 0 0-1.238 0c-.928.85-2.334.85-3.262 0a.907.907 0 0 0-1.238 0c-.928.85-2.334.85-3.262 0l-.483-.442a.196.196 0 0 0-.272 0c-1.137 1.04-2.864.169-2.864-1.297V6.227c0-1.054 0-1.764.195-2.361a3.795 3.795 0 0 1 2.348-2.412c.59-.205 1.289-.204 2.306-.204m.146 1.5c-1.221 0-1.642.01-1.96.121A2.296 2.296 0 0 0 3.87 4.334c-.111.338-.12.784-.12 2.036v14.004c0 .12.059.192.134.227a.2.2 0 0 0 .11.018a.194.194 0 0 0 .107-.055a1.695 1.695 0 0 1 2.296 0l.483.442a.907.907 0 0 0 1.238 0a2.407 2.407 0 0 1 3.262 0a.907.907 0 0 0 1.238 0a2.407 2.407 0 0 1 3.262 0a.907.907 0 0 0 1.238 0l.483-.442a1.695 1.695 0 0 1 2.296 0c.043.04.08.052.108.055a.2.2 0 0 0 .109-.018c.075-.035.135-.108.135-.227V6.37c0-1.252-.01-1.698-.12-2.037a2.296 2.296 0 0 0-1.416-1.462c-.317-.11-.738-.12-1.959-.12zM6.25 7.5A.75.75 0 0 1 7 6.75h.5a.75.75 0 0 1 0 1.5H7a.75.75 0 0 1-.75-.75m3.5 0a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-6.5a.75.75 0 0 1-.75-.75M6.25 11a.75.75 0 0 1 .75-.75h.5a.75.75 0 0 1 0 1.5H7a.75.75 0 0 1-.75-.75m3.5 0a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-6.5a.75.75 0 0 1-.75-.75m-3.5 3.5a.75.75 0 0 1 .75-.75h.5a.75.75 0 0 1 0 1.5H7a.75.75 0 0 1-.75-.75m3.5 0a.75.75 0 0 1 .75-.75H17a.75.75 0 0 1 0 1.5h-6.5a.75.75 0 0 1-.75-.75"
                                clip-rule="evenodd" />
                        </svg>
                    </x-slot:icon>
                    Sections List
                </x-lb::navigate.item>
                <x-lb::navigate.item :route="route(config('cms.route_prefix') . '.themes.sections.create')" :is_active="request()->is(config('cms.route_prefix') . '/themes/sections/create')" no-navigate>
                    <x-slot:icon>
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4">
                            <path
                                d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                        </svg>
                    </x-slot:icon>
                    Create Section
                </x-lb::navigate.item>
            </x-lb::navigate.item>
            @if (View::hasSection('bottom'))
                @yield('bottom')
            @else
                <x-dynamic-component :component="config('cms.navigation.bottom')" />
            @endif
        </x-slot>

        <x-slot:logout>
            <x-dynamic-component :component="config('cms.navigation.logout')" />
        </x-slot>

        {{ $slot }}
    </x-lb::partials.main>
</x-cms::layouts.app>
