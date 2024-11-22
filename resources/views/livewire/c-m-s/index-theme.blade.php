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
                        Themes
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
            <x-lb::buttons-bg.primary type="button" x-data="{}"
                wire:click="$dispatch('create-theme', { event: 'show' })">
                Create
            </x-lb::buttons-bg.primary>
        </div>
    @endsection

    @section('page_title', $page_title)

    <x-lb::table-wrapper :data-count="count($themes->links()->elements[0])" :columns="$columns" :pagination="$themes->links()" :search-bar="false" :filters-count="count($filters)"
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
                <x-lb::table.heading>Title</x-lb::table.heading>
                <x-lb::table.heading>Status</x-lb::table.heading>
                <x-lb::table.heading>No of Sections</x-lb::table.heading>
            </x-lb::table.head>
            <x-lb::table.body>
                @forelse ($themes as $key => $theme)
                    <x-lb::table.row>
                        <x-lb::table.cell>{{ $key + 1 }}</x-lb::table.cell>
                        <x-lb::table.cell>
                            {{ $theme->title }}
                        </x-lb::table.cell>
                        <x-lb::table.cell>
                            <span @class([
                                'px-1 py-0.5 rounded-lg text-xs',
                                'bg-red-600 text-red-50' => !$theme->is_default,
                                'bg-green-600 text-green-50' => $theme->is_default,
                            ])>
                                {{ $theme->is_default ? 'Active' : 'In-Active' }}
                            </span>
                        </x-lb::table.cell>
                        <x-lb::table.cell>
                            {{ $theme->sections->count() }}
                        </x-lb::table.cell>
                    </x-lb::table.row>
                @empty
                    <x-lb::table.row>
                        <x-lb::table.cell colspan="4">
                            <div class="flex justify-center w-full py-8 text-xl text-slate-500">
                                Theme(s) Not found!
                            </div>
                        </x-lb::table.cell>
                    </x-lb::table.row>
                @endforelse
            </x-lb::table.body>
        </x-lb::table>
    </x-lb::table-wrapper>

    @livewire('marketing.c-m-s.modal.create-theme-modal')
</x-marketing.partials.app>
