<div>
    <x-slot:heading>
        <x-lb::breadcrumb :page-title="$page_title">
            <x-lb::breadcrumb.link link="/" first>Home</x-lb::breadcrumb.link>
            <x-lb::breadcrumb.link :link="route('cms.themes.index')">Themes</x-lb::breadcrumb.link>
            <x-lb::breadcrumb.link>List</x-lb::breadcrumb.link>
        </x-lb::breadcrumb>
        <x-lb::actions>
            <x-lb::buttons-bg.primary type="button" x-data="{}"
                x-on:click="$dispatch('create-theme', { event: 'show' })">
                Create
            </x-lb::buttons-bg.primary>
        </x-lb::actions>
    </x-slot:heading>

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

    @livewire('create-theme-modal')
</div>
