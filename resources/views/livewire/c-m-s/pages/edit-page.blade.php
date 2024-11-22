<x-marketing.partials.app>
    @section('heading')
        <x-lb::breadcrumb :page-title="$page_title">
            <x-lb::breadcrumb.link :link="route('admin.dashboard')" first>Dashboard</x-lb::breadcrumb.link>
            <x-lb::breadcrumb.link link="/" first>Categories</x-lb::breadcrumb.link>
            <x-lb::breadcrumb.link link="/">List</x-lb::breadcrumb.link>
        </x-lb::breadcrumb>
        <x-lb::actions>
            <div class="flex items-center mb-2 gap-x-2">
                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                    <label for="{{ $localeCode }}" @class([
                        'cursor-pointer rounded-md border px-3 py-0.5 text-sm',
                        'bg-indigo-600 text-indigo-50' =>
                            $language == null && app()->getLocale() === $localeCode,
                        'bg-indigo-600 text-indigo-50' => $language === $localeCode,
                    ])>
                        <input type="radio" id="{{ $localeCode }}" class="hidden" wire:model.live="language"
                            value="{{ $localeCode }}" @if ($language == null && app()->getLocale() === $localeCode) checked @endif />
                        {{ $properties['native'] }}
                    </label>
                @endforeach
            </div>
        </x-lb::actions>
    @endsection

    @section('page_title', $page_title)

    <div class="relative flex flex-col px-4">
        <div class="relative">
            <x-lb::form wire:submit.prevent="update" have-image :rtl="$language === 'ar' ? true : false">
                <x-lb::form.layout.flex-row>
                    <x-lb::form.layout.flex-col max-width="full">
                        <x-lb::card title="SEO Details">
                            <x-lb::card.span-one>
                                <x-lb::form.input type="text" wire:model="form.translations.title" label="Page Title"
                                    :error="$errors->first('form.translations.title')" placeholder="Page Title">
                                </x-lb::form.input>
                            </x-lb::card.span-one>
                            <x-lb::card.span-one>
                                <x-lb::form.input type="text" wire:model="form.translations.meta_title"
                                    label="Meta Title" :error="$errors->first('form.translations.meta_title')" placeholder="Meta Title">
                                </x-lb::form.input>
                            </x-lb::card.span-one>
                            <x-lb::card.span-one>
                                <x-lb::form.tag wire:model="form.translations.meta_tags" label="Meta Tags"
                                    :error="$errors->first('form.translations.meta_tags')" placeholder="Meta Tags">
                                </x-lb::form.tag>
                            </x-lb::card.span-one>
                            <x-lb::card.span-one>
                                <x-lb::form.textarea wire:model="form.translations.meta_description"
                                    label="Meta Description" :error="$errors->first('form.translations.meta_description')" placeholder="Meta Description">
                                </x-lb::form.textarea>
                            </x-lb::card.span-one>
                            <x-lb::card.span-one>
                                <x-lb::form.textarea wire:model="form.head_scripts" label="Head Scripts"
                                    :error="$errors->first('form.head_scripts')" placeholder="Head Scripts">
                                </x-lb::form.textarea>
                            </x-lb::card.span-one>
                            <x-lb::card.span-one>
                                <x-lb::form.textarea wire:model="form.footer_scripts" label="Footer Scripts"
                                    :error="$errors->first('form.footer_scripts')" placeholder="Footer Scripts">
                                </x-lb::form.textarea>
                            </x-lb::card.span-one>
                        </x-lb::card>
                        <x-lb::card title="Success Page Details">
                            <x-lb::card.span-one>
                                <x-lb::form.input type="text" wire:model="form.translations.success_title"
                                    label="Success Title" :error="$errors->first('form.translations.success_title')" placeholder="Success Title">
                                </x-lb::form.input>
                            </x-lb::card.span-one>
                            <x-lb::card.span-one>
                                <x-lb::form.input type="text" wire:model="form.translations.help_title"
                                    label="Help Title" :error="$errors->first('form.translations.help_title')" placeholder="Help Title">
                                </x-lb::form.input>
                            </x-lb::card.span-one>
                            <x-lb::card.span-one>
                                <x-lb::form.textarea wire:model="form.translations.success_content"
                                    label="Success Content" :error="$errors->first('form.translations.success_content')" placeholder="Success Content">
                                </x-lb::form.textarea>
                            </x-lb::card.span-one>
                            <x-lb::card.span-one>
                                <x-lb::form.textarea wire:model="form.success_scripts" label="Success Scripts"
                                    :error="$errors->first('form.success_scripts')" placeholder="Success Scripts">
                                </x-lb::form.textarea>
                            </x-lb::card.span-one>
                            <x-lb::card.span-one>
                                <label class="text-sm font-medium tracking-wide text-slate-950 block mb-1.5">
                                    Success Page Image
                                </label>
                                <x-lb::form.file wire:model="form.image_trans" label="Success Page Image"
                                    :error="$errors->first('form.image_trans')">
                                    @if ($form->image_trans)
                                        <img src="{{ $form->image_trans->temporaryUrl() }}" alt=""
                                            class="w-20" />
                                    @else
                                        <img src="{{ $form->featured_image_success_preview }}" alt=""
                                            class="w-20" />
                                    @endif
                                </x-lb::form.file>
                            </x-lb::card.span-one>
                            <x-lb::card.span-two>
                                <div class="w-full mt-4">
                                    <div class="flex items-center justify-between mb-4">
                                        <h1 class="font-bold">CTA for Success Links</h1>
                                        <button type="button" x-data="{}"
                                            wire:click="$dispatch('create-page-success-link-modal', { event: 'show' })">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" class="size-5">
                                                <path fill-rule="evenodd"
                                                    d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </button>
                                    </div>
                                    <x-lb::table>
                                        <x-lb::table.head>
                                            <x-lb::table.heading>CTA Text</x-lb::table.heading>
                                            <x-lb::table.heading>CTA Link</x-lb::table.heading>
                                            <x-lb::table.heading>Action</x-lb::table.heading>
                                        </x-lb::table.head>
                                        <x-lb::table.body>
                                            @forelse ($links as $key => $link)
                                                <x-lb::table.row>
                                                    <x-lb::table.cell>{{ $link->title }}</x-lb::table.cell>
                                                    <x-lb::table.cell>{{ $link->link }}</x-lb::table.cell>
                                                    <x-lb::table.cell>
                                                        <x-lb::buttons.primary type="button"
                                                            wire:click="$dispatch('create-page-success-link-modal', { event: 'show', pagelink: {{ $link->id }} })">
                                                            Edit
                                                        </x-lb::buttons.primary>
                                                        <x-lb::buttons.danger type="button"
                                                            wire:click="deleteLink({{ $link->id }})">
                                                            <x-slot:icon>
                                                                <svg wire:loading.remove.delay.default="1"
                                                                    xmlns="http://www.w3.org/2000/svg"
                                                                    viewBox="0 0 20 20" fill="currentColor"
                                                                    class="h-[15px] w-[15px]"
                                                                    wire:target="deleteLink({{ $link->id }})">
                                                                    <path fill-rule="evenodd"
                                                                        d="M8.75 1A2.75 2.75 0 006 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 10.23 1.482l.149-.022.841 10.518A2.75 2.75 0 007.596 19h4.807a2.75 2.75 0 002.742-2.53l.841-10.52.149.023a.75.75 0 00.23-1.482A41.03 41.03 0 0014 4.193V3.75A2.75 2.75 0 0011.25 1h-2.5zM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4zM8.58 7.72a.75.75 0 00-1.5.06l.3 7.5a.75.75 0 101.5-.06l-.3-7.5zm4.34.06a.75.75 0 10-1.5-.06l-.3 7.5a.75.75 0 101.5.06l.3-7.5z"
                                                                        clip-rule="evenodd" />
                                                                </svg>
                                                            </x-slot:icon>
                                                        </x-lb::buttons.danger>
                                                    </x-lb::table.cell>
                                                </x-lb::table.row>
                                            @empty
                                                <x-lb::table.row>
                                                    <x-lb::table.cell colspan="3">
                                                        <div
                                                            class="flex justify-center w-full my-16 text-xl text-slate-600">
                                                            No Button(s)
                                                        </div>
                                                    </x-lb::table.cell>
                                                </x-lb::table.row>
                                            @endforelse
                                        </x-lb::table.body>
                                    </x-lb::table>
                                </div>
                            </x-lb::card.span-two>
                        </x-lb::card>
                        <x-lb::card title="Featured Image">
                            <x-lb::card.span-one>
                                <label class="text-sm font-medium tracking-wide text-slate-950 block mb-1.5">
                                    General Featured Image
                                </label>
                                <x-lb::form.file wire:model="form.page_featured_image" label="General Featured Image"
                                    :error="$errors->first('form.page_featured_image')">
                                    @if ($form->page_featured_image)
                                        <img src="{{ $form->page_featured_image->temporaryUrl() }}" alt=""
                                            class="w-20" />
                                    @else
                                        <img src="{{ $form->featured_image_preview }}" alt="" class="w-20" />
                                    @endif
                                </x-lb::form.file>
                            </x-lb::card.span-one>
                            <x-lb::card.span-one>
                                <label class="text-sm font-medium tracking-wide text-slate-950 block mb-1.5">
                                    Featured Image for Each Language
                                </label>
                                <x-lb::form.file wire:model="form.featured_image_trans"
                                    label="Featured Image for Each Language" :error="$errors->first('form.featured_image_trans')">
                                    @if ($form->featured_image_trans)
                                        <img src="{{ $form->featured_image_trans->temporaryUrl() }}" alt=""
                                            class="w-20" />
                                    @else
                                        <img src="{{ $form->featured_image_trans_preview }}" alt=""
                                            class="w-20" />
                                    @endif
                                </x-lb::form.file>
                            </x-lb::card.span-one>
                        </x-lb::card>
                    </x-lb::form.layout.flex-col>
                </x-lb::form.layout.flex-row>
                <div class="p-4"></div>
                <x-lb::form.layout.flex-row>
                    <x-lb::form.layout.flex-col max-width="full">
                        <x-lb::card title="Page Editor">
                            <x-lb::card.span-two>
                                <div wire:sortable="updateSectionOrder" class="flex flex-col gap-4"
                                    x-data="{ active: null }">
                                    @foreach ($page->sections as $key => $section)
                                        <div class="relative p-2 border rounded-lg bg-slate-100"
                                            wire:sortable.item="{{ $section->pivot->id }}"
                                            wire:key="section-{{ $section->pivot->id }}" x-data="{
                                                id: {{ $key }},
                                                get expanded() {
                                                    return this.active === this.id
                                                },
                                                set expanded(value) {
                                                    this.active = value ? this.id : null
                                                },
                                            }"
                                            role="region">
                                            <div class="flex items-center justify-between px-4 pb-2 -mx-2 border-b">
                                                <h1>{{ $section->title }} #{{ $key + 1 }}</h1>
                                                <div class="flex items-center gap-2">
                                                    <button type="button" x-on:click="expanded = !expanded"
                                                        :aria-expanded="expanded"
                                                        class="p-1 bg-indigo-600 rounded-md text-indigo-50">
                                                        <span x-show="expanded" aria-hidden="true">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="size-4">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M5 12h14" />
                                                            </svg>
                                                        </span>
                                                        <span x-show="!expanded" aria-hidden="true">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="1.5"
                                                                stroke="currentColor" class="size-4">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M12 4.5v15m7.5-7.5h-15" />
                                                            </svg>
                                                        </span>
                                                    </button>
                                                    <button type="button" wire:sortable.handle
                                                        class="p-1 bg-indigo-600 rounded-md text-indigo-50">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor" class="size-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                                        </svg>
                                                    </button>
                                                    <button type="button"
                                                        wire:click="trig('delete', {{ $section->pivot->id }})"
                                                        wire:target="trig('delete', {{ $section->pivot->id }})"
                                                        class="p-1 bg-red-600 rounded-md text-red-50">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor" class="size-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M6 18 18 6M6 6l12 12" />
                                                        </svg>
                                                    </button>
                                                </div>
                                            </div>
                                            @php
                                                $settings = json_decode($section->skeleton->skeleton, true)['settings'];
                                                $skeleton_datas = json_decode($section->skeleton->skeleton, true)[
                                                    'data'
                                                ];
                                            @endphp
                                            <div x-show="expanded" x-collapse @class(['grid gap-4 p-2 bg-slate-100 grid-cols-1 lg:grid-cols-2'])>
                                                @foreach ($skeleton_datas as $skels_key => $data)
                                                    <div class="flex flex-col gap-4 p-4 border rounded-md bg-slate-50">
                                                        @foreach ($data['skeleton'] as $key => $value)
                                                            @if (!is_array($value))
                                                                @php
                                                                    $formattedValue = ucwords(
                                                                        str_replace('_', ' ', $value),
                                                                    );
                                                                @endphp
                                                                @if (str_contains($value, 'text_'))
                                                                    <x-lb::form.input type="text" :label="$formattedValue"
                                                                        :placeholder="$formattedValue"
                                                                        wire:model="sections_data.{{ $section->pivot->id . '.' . $data['id'] . '.' . $value }}">
                                                                    </x-lb::form.input>
                                                                @endif
                                                                @if (str_contains($value, 'textarea_'))
                                                                    <x-lb::form.textarea type="text"
                                                                        :label="$formattedValue" :placeholder="$formattedValue"
                                                                        wire:model="sections_data.{{ $section->pivot->id . '.' . $data['id'] . '.' . $value }}">
                                                                    </x-lb::form.textarea>
                                                                @endif
                                                                @if (str_contains($value, 'markdown_'))
                                                                    <div wire:ignore>
                                                                        <x-lb::form.trix :label="$formattedValue .
                                                                            $section->pivot->id .
                                                                            $data['id']"
                                                                            :placeholder="$formattedValue"
                                                                            wire:model="sections_data.{{ $section->pivot->id . '.' . $data['id'] . '.' . $value }}">
                                                                        </x-lb::form.trix>
                                                                    </div>
                                                                @endif
                                                                @if (str_contains($value, 'cta_'))
                                                                    <div class="flex flex-col gap-2 p-2 border">
                                                                        <x-lb::form.input type="text"
                                                                            :label="$formattedValue . ' Button Link'" :placeholder="$formattedValue"
                                                                            wire:model="sections_data.{{ $section->pivot->id . '.' . $data['id'] . '.' . $value . '.link' }}">
                                                                        </x-lb::form.input>
                                                                        <x-lb::form.input type="text"
                                                                            :label="$formattedValue . ' Button Text'" :placeholder="$formattedValue"
                                                                            wire:model="sections_data.{{ $section->pivot->id . '.' . $data['id'] . '.' . $value . '.text' }}">
                                                                        </x-lb::form.input>
                                                                    </div>
                                                                @endif
                                                                @if (str_contains($value, 'single_image_'))
                                                                    <label
                                                                        class="text-sm font-medium tracking-wide text-slate-950">
                                                                        {{ $formattedValue }}
                                                                    </label>
                                                                    <x-lb::form.file :label="$formattedValue"
                                                                        :placeholder="$formattedValue"
                                                                        wire:model="sections_data.{{ $section->pivot->id . '.' . $data['id'] . '.' . $value }}">
                                                                        <div class="flex flex-col">
                                                                            @if (isset($sections_data[$section->pivot->id]) && count($sections_data[$section->pivot->id]) > 0)
                                                                                @if (isset($sections_data[$section->pivot->id][$data['id']]) &&
                                                                                        count($sections_data[$section->pivot->id][$data['id']]) > 0)
                                                                                    @isset($sections_data[$section->pivot->id][$data['id']][$value])
                                                                                        @if (is_object($sections_data[$section->pivot->id][$data['id']][$value]))
                                                                                            <img src="{{ $sections_data[$section->pivot->id][$data['id']][$value]->temporaryUrl() }}"
                                                                                                alt=""
                                                                                                class="w-20" />
                                                                                        @else
                                                                                            <img src="{{ $section->pivot->imageUrl($sections_data[$section->pivot->id][$data['id']][$value]) }}"
                                                                                                alt=""
                                                                                                class="w-20" />
                                                                                        @endif
                                                                                    @endisset
                                                                                @endif
                                                                            @endif
                                                                        </div>
                                                                    </x-lb::form.file>
                                                                @endif
                                                            @else
                                                                @php
                                                                    $formattedValue = ucwords(
                                                                        str_replace('_', ' ', $key),
                                                                    );
                                                                @endphp
                                                                @if (str_contains($key, 'model_'))
                                                                    <div
                                                                        class="p-4 border-l-4 border-r rounded-lg border-y border-l-indigo-600">
                                                                        <div class="mb-2 text-base font-bold">
                                                                            {{ $formattedValue }}
                                                                        </div>
                                                                        <div class="flex flex-col gap-4">
                                                                            <x-lb::form.select label="Model"
                                                                                wire:model="sections_data.{{ $section->pivot->id . '.' . $data['id'] . '.' . $key . '.model' }}">
                                                                                <option value="">Select the Model
                                                                                </option>
                                                                                @foreach ($this->allmodels as $kel => $model)
                                                                                    <option
                                                                                        value="{{ $model }}">
                                                                                        {{ $model }}
                                                                                    </option>
                                                                                @endforeach
                                                                            </x-lb::form.select>
                                                                            <x-lb::form.input type="text"
                                                                                label="Records"
                                                                                wire:model="sections_data.{{ $section->pivot->id . '.' . $data['id'] . '.' . $key . '.records' }}">
                                                                            </x-lb::form.input>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @endif
                                                        @endforeach
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </x-lb::card.span-two>
                        </x-lb::card>
                    </x-lb::form.layout.flex-col>
                    <x-lb::form.layout.flex-col-sticky max-width="lg" sticky>
                        <x-lb::card title="Featured Image">
                            <x-lb::card.span-two breakpoint="lg">
                                <div class="grid gap-y-2">
                                    @foreach ($this->sections as $key => $section)
                                        <div wire:click="addSection({{ $section->id }})"
                                            class="px-4 py-2 text-sm duration-150 border rounded-lg cursor-pointer select-none hover:bg-indigo-600 hover:text-indigo-50">
                                            {{ $section->title }}
                                        </div>
                                    @endforeach
                                </div>
                            </x-lb::card.span-two>
                        </x-lb::card>
                        <x-slot:sticky-content>
                            <x-lb::card sticky>
                                <div class="flex items-center justify-end col-span-2 space-x-3">
                                    <span wire:loading wire:target="update" @class(['text-sm'])>
                                        Saving
                                    </span>
                                    <span x-data="{
                                        open: false
                                    }" x-init="@this.on('notify-saved', (event) => {
                                        setTimeout(() => { open = false }, 2500);
                                        open = true;
                                    })"
                                        x-show:transition.out.duration.1000ms="open" style="display: none"
                                        class="text-sm text-slate-600">
                                        Saved!
                                    </span>
                                    <x-lb::buttons-bg.warning type="submit" wire:target="update(1)">
                                        Draft
                                    </x-lb::buttons-bg.warning>
                                    <x-lb::buttons-bg.primary type="submit" wire:target="update">
                                        Save
                                    </x-lb::buttons-bg.primary>
                                </div>
                            </x-lb::card>
                        </x-slot:sticky-content>
                    </x-lb::form.layout.flex-col-sticky>
                </x-lb::form.layout.flex-row>
            </x-lb::form>
        </div>
    </div>

    <x-lb::modal.confirm wire:model="showDeleteModal" max-width="md">
        <x-slot:button>
            <x-lb::buttons-bg.danger wire:target="delete" wire:click="delete">
                Delete
            </x-lb::buttons-bg.danger>
        </x-slot>
    </x-lb::modal.confirm>

    @livewire('marketing.c-m-s.modal.create-page-success-link-modal', [
        'page_id' => $page->id,
    ])

</x-marketing.partials.app>
