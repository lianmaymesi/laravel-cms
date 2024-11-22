<x-marketing.partials.app>
    @section('heading')
        <div class="py-4">
            <ul class="flex items-center space-x-2 text-sm font-medium text-slate-500">
                <li class="text-slate-800">
                    <a href="{{ route('admin.dashboard') }}" class="duration-150 hover:text-slate-600" wire:navigate>
                        Home
                    </a>
                </li>
                <li class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-3 h-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                    <a href="" class="duration-150 hover:text-slate-600" wire:navigate>
                        Sections
                    </a>
                </li>
                <li class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-3 h-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                    </svg>
                    <a class="duration-150 hover:text-slate-600">List</a>
                </li>
            </ul>
            <h1 class="text-3xl font-semibold text-slate-900">
                {{ $page_title }}
            </h1>
        </div>
        <div class="pb-6">
            <x-lb::anchor-bg.primary href="{{ route('admin.cms.themes.sections.create') }}">
                Create
            </x-lb::anchor-bg.primary>
        </div>
    @endsection

    @section('page_title', $page_title)

    <x-lb::table-wrapper :data-count="count($sections->links()->elements[0])" :columns="$columns" :pagination="$sections->links()" :search-bar="false" :filters-count="count($filters)"
        :columns-count="count($columns)">

        <div class="hidden" x-data="{
            feeColumn: $persist(@entangle('selectedColumns')),
            feePerPage: $persist(@entangle('perPage'))
        }" x-init="$wire.set('selectedColumns', feeColumn)
        $wire.set('perPage', feePerPage)"></div>

        <x-slot:filters>
        </x-slot:filters>

        <x-lb::table>
            <x-lb::table.head>
                <x-lb::table.heading>S.No</x-lb::table.heading>
                <x-lb::table.heading>Theme</x-lb::table.heading>
                <x-lb::table.heading>Section Title</x-lb::table.heading>
                <x-lb::table.heading></x-lb::table.heading>
            </x-lb::table.head>
            <x-lb::table.body>
                @forelse ($sections as $key => $section)
                    <x-lb::table.row>
                        <x-lb::table.cell>{{ $key + 1 }}</x-lb::table.cell>
                        <x-lb::table.cell>
                            {{ $section->theme->title }}
                        </x-lb::table.cell>
                        <x-lb::table.cell>
                            {{ $section->title }}
                        </x-lb::table.cell>
                        <x-lb::table.cell>

                        </x-lb::table.cell>
                    </x-lb::table.row>
                @empty
                    <x-lb::table.row>
                        <x-lb::table.cell colspan="4">
                            <div class="flex justify-center w-full py-8 text-xl text-slate-500">
                                Section(s) Not found!
                            </div>
                        </x-lb::table.cell>
                    </x-lb::table.row>
                @endforelse
            </x-lb::table.body>
        </x-lb::table>
    </x-lb::table-wrapper>

</x-marketing.partials.app>
