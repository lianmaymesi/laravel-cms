<div>
    <x-slot:heading>
        <x-lb::breadcrumb :page-title="$page_title">
            <x-lb::breadcrumb.link link="/" first>Home</x-lb::breadcrumb.link>
            <x-lb::breadcrumb.link :link="route('cms.themes.sections.index')">Sections</x-lb::breadcrumb.link>
            <x-lb::breadcrumb.link>List</x-lb::breadcrumb.link>
        </x-lb::breadcrumb>
        <x-lb::actions>
            <x-lb::anchor-bg.primary href="{{ route('cms.themes.sections.create') }}" no-navigate>
                Create
            </x-lb::anchor-bg.primary>
        </x-lb::actions>
    </x-slot:heading>

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
                <x-lb::table.heading>Visual</x-lb::table.heading>
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
                            <div class="flex items-center">
                                <img src="{{ $section->imageUrl() }}" alt="" class="h-24">
                            </div>
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
                            <div class="flex w-full justify-center py-8 text-xl text-slate-500">
                                Section(s) not found!
                            </div>
                        </x-lb::table.cell>
                    </x-lb::table.row>
                @endforelse
            </x-lb::table.body>
        </x-lb::table>
    </x-lb::table-wrapper>

</div>
