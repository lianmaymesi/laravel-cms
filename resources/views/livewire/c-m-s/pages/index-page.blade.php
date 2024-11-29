<div>
    <x-slot:heading>
        <x-lb::breadcrumb :page-title="$page_title">
            <x-lb::breadcrumb.link link="/" first>Home</x-lb::breadcrumb.link>
            <x-lb::breadcrumb.link :link="route('cms.pages.index')">Pages</x-lb::breadcrumb.link>
            <x-lb::breadcrumb.link>List</x-lb::breadcrumb.link>
        </x-lb::breadcrumb>
        <x-lb::actions>
            <x-lb::anchor-bg.primary :href="route('cms.pages.create')">
                Create
            </x-lb::anchor-bg.primary>
        </x-lb::actions>
    </x-slot:heading>

    @section('page_title', $page_title)

    <x-lb::table-wrapper :data-count="count($pages->links()->elements[0])" :columns="$columns" :pagination="$pages->links()" :search-bar="false" :filters-count="count($filters)"
        :columns-count="count($columns)">

        <div class="hidden" x-data="{
            pageColumn: $persist(@entangle('selectedColumns')),
            pagePerPage: $persist(@entangle('perPage'))
        }" x-init="$wire.set('selectedColumns', pageColumn)
        $wire.set('perPage', pagePerPage)"></div>

        <x-slot:filters>
        </x-slot:filters>

        <x-lb::table>
            <x-lb::table.head>
                <x-lb::table.heading>S.No</x-lb::table.heading>
                <x-lb::table.heading>Title</x-lb::table.heading>
                <x-lb::table.heading>Sections</x-lb::table.heading>
                <x-lb::table.heading></x-lb::table.heading>
            </x-lb::table.head>
            <x-lb::table.body>
                @forelse ($pages as $key => $page)
                    <x-lb::table.row>
                        <x-lb::table.cell>{{ $key + 1 }}</x-lb::table.cell>
                        <x-lb::table.cell>
                            {{ $page->menu?->detail->title }}
                        </x-lb::table.cell>
                        <x-lb::table.cell>
                            {{ $page->sections->count() }}
                        </x-lb::table.cell>
                        <x-lb::table.cell>
                            <div class="flex justify-end gap-2">
                                <x-lb::anchor.primary :href="route('cms.pages.edit', $page->id)" no-navigate>
                                    Edit
                                </x-lb::anchor.primary>
                                <x-lb::buttons.danger wire:click="trig('delete', {{ $page->id }})"
                                    wire:target="trig('delete', {{ $page->id }})">
                                    <x-slot:icon>
                                        <svg wire:loading.remove.delay.default="1" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor" class="h-[15px] w-[15px]"
                                            wire:target="trig('delete', {{ $page->id }})">
                                            <path fill-rule="evenodd"
                                                d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </x-slot:icon>
                                </x-lb::buttons.danger>
                            </div>
                        </x-lb::table.cell>
                    </x-lb::table.row>
                @empty
                    <x-lb::table.row>
                        <x-lb::table.cell colspan="4">
                            <div class="flex justify-center w-full py-8 text-xl text-slate-500">
                                Page(s) Not found!
                            </div>
                        </x-lb::table.cell>
                    </x-lb::table.row>
                @endforelse
            </x-lb::table.body>
        </x-lb::table>
    </x-lb::table-wrapper>

    <x-lb::modal.confirm wire:model="showDeleteModal" max-width="md">
        <x-slot:button>
            <x-lb::buttons-bg.danger wire:target="delete" wire:click="delete">
                Delete
            </x-lb::buttons-bg.danger>
        </x-slot>
    </x-lb::modal.confirm>

    <x-slot:logout>
        Hello
    </x-slot:logout>

</div>
