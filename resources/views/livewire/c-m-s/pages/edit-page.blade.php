<div>
    <x-slot:heading>
        <x-lb::breadcrumb :page-title="$page_title">
            <x-lb::breadcrumb.link link="/" first>Home</x-lb::breadcrumb.link>
            <x-lb::breadcrumb.link :link="route('cms.pages.index')">Pages</x-lb::breadcrumb.link>
            <x-lb::breadcrumb.link>Edit</x-lb::breadcrumb.link>
        </x-lb::breadcrumb>
        <x-lb::actions>
            @if (count(LaravelLocalization::getSupportedLocales()) > 1)
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
            @endif
        </x-lb::actions>
    </x-slot:heading>

    @section('page_title', $page_title)

    <div class="relative flex flex-col px-4">
        <div class="relative">
            <x-lb::form wire:submit.prevent="update(draft)" have-image :rtl="$language === 'ar' ? true : false" x-data="{ draft: 0 }">
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
                        <x-lb::card title="Featured Image">
                            @if (count(LaravelLocalization::getSupportedLocales()) == 1)
                                <x-lb::card.span-one>
                                    <label class="text-sm font-medium tracking-wide text-slate-950 block mb-1.5">
                                        General Featured Image
                                    </label>
                                    <x-lb::form.file wire:model="form.page_featured_image"
                                        label="General Featured Image" :error="$errors->first('form.page_featured_image')">
                                        @if ($form->page_featured_image)
                                            <img src="{{ $form->page_featured_image->temporaryUrl() }}" alt=""
                                                class="w-20" />
                                        @else
                                            <img src="{{ $form->featured_image_preview }}" alt=""
                                                class="w-20" />
                                        @endif
                                    </x-lb::form.file>
                                </x-lb::card.span-one>
                            @endif
                            @if (count(LaravelLocalization::getSupportedLocales()) > 1)
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
                            @endif
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
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="size-4">
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
                                                $skeleton_datas = $section->skeleton->skeleton['data'];
                                            @endphp
                                            <div x-show="expanded" x-collapse @class(['grid gap-4 p-2 bg-slate-100 grid-cols-1 lg:grid-cols-2'])>
                                                @foreach ($skeleton_datas as $skels_key => $data)
                                                    <div class="flex flex-col gap-4 p-4 border rounded-md bg-slate-50">
                                                        @foreach ($data['skeleton'] as $key => $value)
                                                            @php
                                                                $formattedValue = $value['label'];
                                                            @endphp
                                                            @if (str_contains($key, 'text_'))
                                                                <x-lb::form.input type="text" :label="$formattedValue"
                                                                    :placeholder="$formattedValue"
                                                                    wire:model="sections_data.{{ $section->pivot->id . '.' . $data['id'] . '.' . $key }}">
                                                                </x-lb::form.input>
                                                            @endif
                                                            @if (str_contains($key, 'textarea_'))
                                                                <x-lb::form.textarea type="text" :label="$formattedValue"
                                                                    :placeholder="$formattedValue"
                                                                    wire:model="sections_data.{{ $section->pivot->id . '.' . $data['id'] . '.' . $key }}">
                                                                </x-lb::form.textarea>
                                                            @endif
                                                            @if (str_contains($key, 'markdown_'))
                                                                <div wire:ignore>
                                                                    <x-lb::form.trix :label="$formattedValue .
                                                                        $section->pivot->id .
                                                                        $data['id']"
                                                                        :placeholder="$formattedValue"
                                                                        wire:model="sections_data.{{ $section->pivot->id . '.' . $data['id'] . '.' . $key }}">
                                                                    </x-lb::form.trix>
                                                                </div>
                                                            @endif
                                                            @if (str_contains($key, 'cta_'))
                                                                <div class="flex flex-col gap-2 p-2 border">
                                                                    <x-lb::form.input type="text" :label="$formattedValue . ' Button Text'"
                                                                        :placeholder="$formattedValue"
                                                                        wire:model="sections_data.{{ $section->pivot->id . '.' . $data['id'] . '.' . $key . '.text' }}">
                                                                    </x-lb::form.input>
                                                                    <x-lb::form.input type="text" :label="$formattedValue . ' Button Link'"
                                                                        :placeholder="$formattedValue"
                                                                        wire:model="sections_data.{{ $section->pivot->id . '.' . $data['id'] . '.' . $key . '.link' }}">
                                                                    </x-lb::form.input>
                                                                </div>
                                                            @endif
                                                            @if (str_contains($key, 'single_image_'))
                                                                <label
                                                                    class="text-sm font-medium tracking-wide text-slate-950">
                                                                    {{ $formattedValue }}
                                                                </label>
                                                                <x-lb::form.file :label="$formattedValue" :placeholder="$formattedValue"
                                                                    wire:model="sections_data.{{ $section->pivot->id . '.' . $data['id'] . '.' . $key }}">
                                                                    <div class="flex flex-col">
                                                                        @if (isset($sections_data[$section->pivot->id]) && count($sections_data[$section->pivot->id]) > 0)
                                                                            @if (isset($sections_data[$section->pivot->id][$data['id']]) &&
                                                                                    count($sections_data[$section->pivot->id][$data['id']]) > 0)
                                                                                @isset($sections_data[$section->pivot->id][$data['id']][$key])
                                                                                    @if (request()->hasfile($sections_data[$section->pivot->id][$data['id']][$key]))
                                                                                        @dd($sections_data[$section->pivot->id][$data['id']][$key])
                                                                                        <img src="{{ $sections_data[$section->pivot->id][$data['id']][$key][0]->temporaryUrl() }}"
                                                                                            alt=""
                                                                                            class="w-20" />
                                                                                    @else
                                                                                        <img src="{{ $section->pivot->imageUrl($sections_data[$section->pivot->id][$data['id']][$key]) }}"
                                                                                            alt=""
                                                                                            class="w-20" />
                                                                                    @endif
                                                                                @endisset
                                                                            @endif
                                                                        @endif
                                                                    </div>
                                                                </x-lb::form.file>
                                                            @endif
                                                            @if (str_contains($key, 'model_'))
                                                                <div
                                                                    class="p-4 border-l-4 border-r rounded-lg border-y border-l-indigo-600">
                                                                    <div class="mb-2 text-base font-bold">
                                                                        {{ $formattedValue }}
                                                                    </div>
                                                                    <div class="flex flex-col gap-4">
                                                                        <x-lb::form.select label="Type"
                                                                            wire:model.lazy="sections_data.{{ $section->pivot->id . '.' . $data['id'] . '.' . $key . '.value.type' }}">
                                                                            <option>Select the Record Type</option>
                                                                            <option value="all">All</option>
                                                                            <option value="selected">Selected</option>
                                                                        </x-lb::form.select>
                                                                        @php
                                                                            $model = '\App\\Models\\' . $value['model'];
                                                                        @endphp
                                                                        @if ($sections_data[$section->pivot->id][$data['id']][$key]['value']['type'] === 'selected')
                                                                            <x-lb::form.input type="text"
                                                                                label="Limit"
                                                                                wire:model.lazy="sections_data.{{ $section->pivot->id . '.' . $data['id'] . '.' . $key . '.value.limit' }}">
                                                                            </x-lb::form.input>
                                                                            <div class="grid gap-y-1">
                                                                                <x-lb::form.select :label="$value['model']"
                                                                                    wire:model.lazy="sections_data.{{ $section->pivot->id . '.' . $data['id'] . '.' . $key . '.value.records' }}"
                                                                                    multiple>
                                                                                    <option value="">
                                                                                        Select the
                                                                                        {{ $value['model'] }}
                                                                                    </option>
                                                                                    @foreach ($model::get() as $kel => $model)
                                                                                        <option
                                                                                            value="{{ $model->id }}">
                                                                                            {{ $model->{$value['field']} }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </x-lb::form.select>

                                                                                @if (count($sections_data[$section->pivot->id][$data['id']][$key]['value']['records']) >
                                                                                        $sections_data[$section->pivot->id][$data['id']][$key]['value']['limit']
                                                                                )
                                                                                    <span class="text-xs text-red-600">
                                                                                        You have selected more than
                                                                                        a limit
                                                                                    @else
                                                                                        <span class="text-xs">
                                                                                            You have selected
                                                                                @endif
                                                                                {{ count($sections_data[$section->pivot->id][$data['id']][$key]['value']['records']) }}/{{ $sections_data[$section->pivot->id][$data['id']][$key]['value']['limit'] }}
                                                                                </span>
                                                                            </div>
                                                                        @endif
                                                                        <x-lb::form.select label="Sort"
                                                                            wire:model.lazy="sections_data.{{ $section->pivot->id . '.' . $data['id'] . '.' . $key . '.value.orderby' }}">
                                                                            <option>Select the Sort</option>
                                                                            <option value="asc">Ascending</option>
                                                                            <option value="desc">Descending</option>
                                                                        </x-lb::form.select>
                                                                        @php
                                                                            $valueModel = new $model();
                                                                            $tableName = $valueModel->getTable();
                                                                            $tableField =
                                                                                '\Illuminate\\Support\\Facades\\Schema';
                                                                        @endphp
                                                                        <x-lb::form.select label="Order By Field"
                                                                            wire:model.lazy="sections_data.{{ $section->pivot->id . '.' . $data['id'] . '.' . $key . '.value.orderby_field' }}">
                                                                            <option>Select the Order By Field</option>
                                                                            @foreach ($tableField::getColumnListing($tableName) as $key => $value)
                                                                                <option value="{{ $value }}">
                                                                                    {{ $value }}
                                                                                </option>
                                                                            @endforeach
                                                                        </x-lb::form.select>
                                                                    </div>
                                                                </div>
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
                        <x-lb::card title="Sections">
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
                                    <x-lb::buttons-bg.warning type="submit" @click="draft = 1"
                                        wire:target="update(1)">
                                        Save as Draft
                                    </x-lb::buttons-bg.warning>
                                    <x-lb::buttons-bg.primary type="submit" wire:target="update">
                                        Publish
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
</div>
