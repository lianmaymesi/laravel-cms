<div>
    <x-slot:heading>
        <x-lb::breadcrumb :page-title="$page_title">
            <x-lb::breadcrumb.link link="/" first>Home</x-lb::breadcrumb.link>
            <x-lb::breadcrumb.link link="/">{{ $page_title }}</x-lb::breadcrumb.link>
        </x-lb::breadcrumb>
    </x-slot:heading>

    <x-lb::table-wrapper :data-count="count($menus->links()->elements[0])" :columns="$columns" :pagination="$menus->links()" :search-bar="false" :filters-count="count($filters)"
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
                <x-lb::table.heading></x-lb::table.heading>
                <x-lb::table.heading>Title</x-lb::table.heading>
                <x-lb::table.heading>Visible</x-lb::table.heading>
                <x-lb::table.heading>Status</x-lb::table.heading>
                <x-lb::table.heading>Link</x-lb::table.heading>
                <x-lb::table.heading></x-lb::table.heading>
            </x-lb::table.head>
            <x-lb::table.body>
                @forelse ($menus as $key => $menu)
                    <x-lb::table.row>
                        <x-lb::table.cell colspan="2">{{ $key + 1 }}</x-lb::table.cell>
                        <x-lb::table.cell>
                            {{ $menu->label }}
                        </x-lb::table.cell>
                        <x-lb::table.cell>
                            <span @class([
                                'px-1 py-0.5 rounded-lg text-xs',
                                'bg-red-600 text-red-50' => !$menu->search_visible,
                                'bg-green-600 text-green-50' => $menu->search_visible,
                            ])>
                                {{ $menu->search_visible ? 'Visible' : 'Hidden' }}
                            </span>
                        </x-lb::table.cell>
                        <x-lb::table.cell>
                            {{ $menu->status }}
                        </x-lb::table.cell>
                        <x-lb::table.cell>
                            <a href="{{ route('user.pages.dynamic.preview', $menu->detail?->slug) }}"
                                class="text-blue-600 underline" target="_blank">
                                Preview
                            </a>
                            <a href="{{ route('user.pages.dynamic.view', $menu->detail?->slug) }}"
                                class="ml-3 text-blue-600 underline" target="_blank">
                                Live
                            </a>
                        </x-lb::table.cell>
                        <x-lb::table.cell>
                            <div class="flex justify-end gap-2">
                                @if ($menu->status === 'draft')
                                    <span class="px-2 pb-0.5 font-semibold bg-red-600 rounded-lg text-red-50">
                                        {{ $menu->status }}
                                    </span>
                                @endif
                                @if ($menu->status === 'publish')
                                    <span class="px-2 pb-0.5 font-semibold bg-green-600 rounded-lg text-green-50">
                                        {{ $menu->status }}
                                    </span>
                                @endif
                                @if (!$menu->is_published)
                                    <x-lb::buttons.primary wire:click="updateStatus({{ $menu->id }}, 'publish')">
                                        Publish
                                    </x-lb::buttons.primary>
                                @else
                                    <x-lb::buttons.danger wire:click="updateStatus({{ $menu->id }}, 'draft')">
                                        Draft
                                    </x-lb::buttons.danger>
                                @endif
                                <x-lb::buttons.primary
                                    wire:click="$dispatch('create-menu', { event: 'show', menu: {{ $menu->id }} })">
                                    Edit
                                </x-lb::buttons.primary>
                                @if ($menu->order != 1)
                                    <x-lb::buttons.warning wire:click="moveUp({{ $menu->id }})"
                                        wire:target="moveUp({{ $menu->id }})">
                                        <x-slot:icon>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="2" stroke="currentColor" class="h-[15px] w-[15px]"
                                                wire:target="moveUp({{ $menu->id }})">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                                            </svg>
                                        </x-slot:icon>
                                    </x-lb::buttons.warning>
                                @endif
                                @if ($menu->last_order != $menu->order)
                                    <x-lb::buttons.warning wire:click="moveDown({{ $menu->id }})"
                                        wire:target="moveDown({{ $menu->id }})">
                                        <x-slot:icon>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="2" stroke="currentColor" class="h-[15px] w-[15px]"
                                                wire:target="moveDown({{ $menu->id }})">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </x-slot:icon>
                                    </x-lb::buttons.warning>
                                @endif
                                <x-lb::buttons.danger wire:click="trig('delete', {{ $menu->id }})"
                                    wire:target="trig('delete', {{ $menu->id }})">
                                    <x-slot:icon>
                                        <svg wire:loading.remove.delay.default="1" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="currentColor" class="h-[15px] w-[15px]"
                                            wire:target="trig('delete', {{ $menu->id }})">
                                            <path fill-rule="evenodd"
                                                d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </x-slot:icon>
                                </x-lb::buttons.danger>
                            </div>
                        </x-lb::table.cell>
                    </x-lb::table.row>
                    @foreach ($menu->children as $skey => $child_menu)
                        <x-lb::table.row>
                            <x-lb::table.cell></x-lb::table.cell>
                            <x-lb::table.cell>{{ $skey + 1 }}</x-lb::table.cell>
                            <x-lb::table.cell>
                                {{ $child_menu->label }}
                            </x-lb::table.cell>
                            <x-lb::table.cell>
                                <span @class([
                                    'px-1 py-0.5 rounded-lg text-xs',
                                    'bg-red-600 text-red-50' => !$menu->search_visible,
                                    'bg-green-600 text-green-50' => $menu->search_visible,
                                ])>
                                    {{ $menu->search_visible ? 'Visible' : 'Hidden' }}
                                </span>
                            </x-lb::table.cell>
                            <x-lb::table.cell>
                                {{ $menu->status }}
                            </x-lb::table.cell>
                            <x-lb::table.cell>
                                <a href="{{ route('user.pages.dynamic.view', $menu->detail->slug . '/' . $child_menu->detail->slug) }}"
                                    class="text-blue-600 underline" target="_blank">
                                    Link
                                </a>
                            </x-lb::table.cell>
                            <x-lb::table.cell>
                                <div class="flex justify-end gap-2">
                                    <x-lb::buttons.primary
                                        wire:click="$dispatch('create-menu', { event: 'show', menu: {{ $child_menu->id }} })">
                                        Edit
                                    </x-lb::buttons.primary>
                                    @if ($child_menu->order != 1)
                                        <x-lb::buttons.warning wire:click="moveUp({{ $child_menu->id }})"
                                            wire:target="moveUp({{ $child_menu->id }})">
                                            <x-slot:icon>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    class="h-[15px] w-[15px]"
                                                    wire:target="moveUp({{ $child_menu->id }})">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m4.5 15.75 7.5-7.5 7.5 7.5" />
                                                </svg>
                                            </x-slot:icon>
                                        </x-lb::buttons.warning>
                                    @endif
                                    @if ($child_menu->child_last_order != $child_menu->order)
                                        <x-lb::buttons.warning wire:click="moveDown({{ $child_menu->id }})"
                                            wire:target="moveDown({{ $child_menu->id }})">
                                            <x-slot:icon>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                    class="h-[15px] w-[15px]"
                                                    wire:target="moveDown({{ $child_menu->id }})">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                                </svg>
                                            </x-slot:icon>
                                        </x-lb::buttons.warning>
                                    @endif
                                    <x-lb::buttons.danger wire:click="trig('delete', {{ $child_menu->id }})"
                                        wire:target="trig('delete', {{ $child_menu->id }})">
                                        <x-slot:icon>
                                            <svg wire:loading.remove.delay.default="1"
                                                xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                fill="currentColor" class="h-[15px] w-[15px]"
                                                wire:target="trig('delete', {{ $child_menu->id }})">
                                                <path fill-rule="evenodd"
                                                    d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </x-slot:icon>
                                    </x-lb::buttons.danger>
                                </div>
                            </x-lb::table.cell>
                        </x-lb::table.row>
                    @endforeach
                @empty
                    <x-lb::table.row>
                        <x-lb::table.cell colspan="4">
                            <div class="flex justify-center w-full py-8 text-xl text-slate-500">
                                Menu(s) Not found!
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

    @livewire('create-menu-modal')
</div>
