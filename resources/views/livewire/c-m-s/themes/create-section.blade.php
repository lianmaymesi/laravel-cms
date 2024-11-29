<div>
    <x-slot:heading>
        <x-lb::breadcrumb :page-title="$page_title">
            <x-lb::breadcrumb.link link="/" first>Home</x-lb::breadcrumb.link>
            <x-lb::breadcrumb.link :link="route('cms.themes.sections.index')">Sections</x-lb::breadcrumb.link>
            <x-lb::breadcrumb.link>Create</x-lb::breadcrumb.link>
        </x-lb::breadcrumb>
        <x-lb::actions>
            <x-lb::anchor-bg.warning href="{{ route('cms.themes.sections.index') }}" no-navigate>
                List
            </x-lb::anchor-bg.warning>
        </x-lb::actions>
    </x-slot:heading>

    @section('page_title', $page_title)

    <div class="relative flex flex-col">
        <div
            class="flex items-center p-2 mb-2 text-sm text-red-600 border border-red-200 rounded-lg bg-red-50 gap-x-2 z-[99999999]">
            <span>
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                </svg>
            </span>
            <span>
                You must be careful to create each section, it cannot be edit.
            </span>
        </div>
        <div class="relative">
            <x-lb::form wire:submit.prevent="create" have-image>
                <x-lb::form.layout.flex-row>
                    <x-lb::form.layout.flex-col max-width="full">
                        <x-lb::card title="Basic Details">
                            <x-lb::card.span-one>
                                <x-lb::form.select wire:model.live="theme_id" label="Theme" :error="$errors->first('theme_id')">
                                    <option>Select the Theme</option>
                                    @foreach ($this->themes as $key => $theme)
                                        <option value="{{ $theme->id }}">{{ $theme->title }}</option>
                                    @endforeach
                                </x-lb::form.select>
                            </x-lb::card.span-one>
                            <x-lb::card.span-one>
                                <x-lb::form.input type="text" wire:model="title" label="Section Title"
                                    :error="$errors->first('title')" placeholder="Section Title">
                                </x-lb::form.input>
                            </x-lb::card.span-one>
                            <x-lb::card.span-one>
                                <x-lb::form.select wire:model="section_file" label="Theme File" :error="$errors->first('section_file')">
                                    <option>Select the Theme File</option>
                                    @foreach ($bladeFiles as $key => $file)
                                        <option value="{{ $file }}">{{ $file }}</option>
                                    @endforeach
                                </x-lb::form.select>
                            </x-lb::card.span-one>
                        </x-lb::card>
                        <x-lb::card title="Section Structure">
                            <x-lb::card.span-two>
                                <div class="relative p-4 border bg-slate-100 rounded-xl hidden">
                                    <h2 class="mb-2 text-lg font-semibold">
                                        Screen Settings <span
                                            class="text-xs italic font-normal select-none text-slate-700">
                                            This is default screen settings, you can customize depend on your theme.
                                        </span></h2>
                                    <div class="flex items-center justify-between gap-2">
                                        @foreach ($settings['screens'] as $key => $screen)
                                            <x-lb::form.input type="number" :label="$key"
                                                wire:model.live="settings.screens.{{ $key }}">
                                            </x-lb::form.input>
                                        @endforeach
                                    </div>
                                </div>
                            </x-lb::card.span-two>
                            <x-lb::card.span-two>
                                @if (count($subSection) > 0)
                                    <div @class([
                                        'mb-4 gap-4 grid',
                                        'sm:grid-cols-' . $settings['screens']['sm'] =>
                                            $settings['screens']['sm'] != 0,
                                        'md:grid-cols-' . $settings['screens']['md'] =>
                                            $settings['screens']['md'] != 0,
                                        'lg:grid-cols-' . $settings['screens']['lg'] =>
                                            $settings['screens']['lg'] != 0,
                                        'xl:grid-cols-' . $settings['screens']['xl'] =>
                                            $settings['screens']['xl'] != 0,
                                        '2xl:grid-cols-' . $settings['screens']['2xl'] =>
                                            $settings['screens']['2xl'] != 0,
                                        'grid-cols-' . count($subSection) =>
                                            $settings['screens']['sm'] == 0 &&
                                            $settings['screens']['md'] == 0 &&
                                            $settings['screens']['lg'] == 0 &&
                                            $settings['screens']['xl'] == 0 &&
                                            $settings['screens']['2xl'] == 0,
                                    ]) wire:sortable="updateSection"
                                        wire:sortable-group="updateSkeleton">
                                        @foreach ($subSection as $key => $section)
                                            <div wire:key="group-section-{{ $section['id'] }}"
                                                wire:sortable.item="{{ $section['id'] }}">
                                                <div class="relative p-4 border rounded-lg">
                                                    <button type="button"
                                                        wire:click="removeColumn('{{ $key }}')"
                                                        class="absolute flex items-center justify-center bg-red-600 rounded-full -right-2.5 -top-2.5 text-red-50">
                                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                            fill="currentColor" class="size-5">
                                                            <path
                                                                d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z" />
                                                        </svg>
                                                    </button>
                                                    <button type="button" wire:sortable.handle
                                                        class="absolute p-0.5 mt-0.5 flex items-center justify-center bg-indigo-600 rounded-full -right-2.5 top-3 text-indigo-50">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                            class="size-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="M7.5 21 3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                                                        </svg>
                                                    </button>
                                                    <div class="flex items-center gap-x-2">
                                                        <div class="w-full">
                                                            <x-lb::form.select label="Input Type"
                                                                wire:model="skeletonValues" label-off>
                                                                <option>Select the Input Type</option>
                                                                <option value="text">Text</option>
                                                                <option value="textarea">Textarea</option>
                                                                <option value="markdown">Markdown</option>
                                                                <option value="single_image">Single Image</option>
                                                                <option value="model">Data from Database</option>
                                                                <option value="cta">Call to Action</option>
                                                            </x-lb::form.select>
                                                        </div>
                                                        <button type="button"
                                                            wire:click="addValue('{{ $key }}', '{{ $section['id'] }}')"
                                                            class="p-2 rounded-md !bg-green-400 text-green-900">
                                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                                                fill="currentColor" class="size-5">
                                                                <path
                                                                    d="M10.75 4.75a.75.75 0 0 0-1.5 0v4.5h-4.5a.75.75 0 0 0 0 1.5h4.5v4.5a.75.75 0 0 0 1.5 0v-4.5h4.5a.75.75 0 0 0 0-1.5h-4.5v-4.5Z" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                </div>
                                                @if (isset($section))
                                                    <ul class="flex flex-col gap-2 mt-2"
                                                        wire:sortable-group.item-group="{{ $section['id'] }}">
                                                        @foreach ($section['skeleton'] as $skelKey => $value)
                                                            @if (str_contains($value, 'model_'))
                                                                <li wire:key="task-{{ $value }}"
                                                                    wire:sortable-group.item="{{ $value }}"
                                                                    class="flex items-center justify-between py-2 pl-4 pr-2 text-sm border border-indigo-400 border-dashed rounded-lg">
                                                                    <span>
                                                                        <x-lb::form.input type="text"
                                                                            :label="$value"
                                                                            wire:model="config.{{ $section['id'] . '.' . $value . '.label' }}"
                                                                            label-off></x-lb::form.input>
                                                                    </span>
                                                                    <div class="flex flex-col gap-2">
                                                                        <select class="pl-0.5 py-0.5 text-xs rounded-sm"
                                                                            wire:model="config.{{ $section['id'] . '.' . $value . '.model' }}"
                                                                            wire:change="changeModel($event.target.value, `{{ $section['id'] }}`, `{{ $value }}`)">
                                                                            <option value="">
                                                                                Select the Model
                                                                            </option>
                                                                            @foreach ($this->allmodels as $key => $model)
                                                                                <option value="{{ $model }}">
                                                                                    {{ $model }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                        <select class="pl-0.5 py-0.5 text-xs rounded-sm"
                                                                            wire:model="config.{{ $section['id'] . '.' . $value . '.field' }}">
                                                                            <option>Select the Display Field</option>
                                                                            @isset($allFields[$section['id']][$value])
                                                                                @foreach ($allFields[$section['id']][$value] as $key => $value)
                                                                                    <option value="{{ $value }}">
                                                                                        {{ $value }}
                                                                                    </option>
                                                                                @endforeach
                                                                            @endisset
                                                                        </select>
                                                                    </div>
                                                                    <div class="flex items-center gap-x-2">
                                                                        <span
                                                                            class="p-1 bg-orange-400 rounded cursor-pointer"
                                                                            wire:sortable-group.handle>
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                fill="none" viewBox="0 0 24 24"
                                                                                stroke-width="1.5" stroke="currentColor"
                                                                                class="size-4">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                                                            </svg>
                                                                        </span>
                                                                        <span
                                                                            wire:click="removeValue({{ $key }})"
                                                                            class="p-1 bg-red-600 rounded cursor-pointer">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                viewBox="0 0 24 24"
                                                                                fill="currentColor" class="size-4">
                                                                                <path fill-rule="evenodd"
                                                                                    d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z"
                                                                                    clip-rule="evenodd" />
                                                                            </svg>
                                                                        </span>
                                                                    </div>
                                                                </li>
                                                            @else
                                                                <li wire:key="task-{{ $value }}"
                                                                    wire:sortable-group.item="{{ $value }}"
                                                                    class="flex items-center justify-between py-2 pl-4 pr-2 text-sm border border-indigo-400 border-dashed rounded-lg">
                                                                    <span>
                                                                        <x-lb::form.input type="text"
                                                                            :label="$value"
                                                                            wire:model="config.{{ $section['id'] . '.' . $value . '.label' }}"
                                                                            label-off></x-lb::form.input>
                                                                    </span>
                                                                    <div class="flex items-center gap-x-2">
                                                                        <span
                                                                            class="p-1 bg-orange-400 rounded cursor-pointer"
                                                                            wire:sortable-group.handle>
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                fill="none" viewBox="0 0 24 24"
                                                                                stroke-width="1.5"
                                                                                stroke="currentColor" class="size-4">
                                                                                <path stroke-linecap="round"
                                                                                    stroke-linejoin="round"
                                                                                    d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                                                            </svg>
                                                                        </span>
                                                                        <span
                                                                            wire:click="removeValue({{ $key }})"
                                                                            class="p-1 bg-red-600 rounded cursor-pointer">
                                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                                viewBox="0 0 24 24"
                                                                                fill="currentColor" class="size-4">
                                                                                <path fill-rule="evenodd"
                                                                                    d="M5.47 5.47a.75.75 0 0 1 1.06 0L12 10.94l5.47-5.47a.75.75 0 1 1 1.06 1.06L13.06 12l5.47 5.47a.75.75 0 1 1-1.06 1.06L12 13.06l-5.47 5.47a.75.75 0 0 1-1.06-1.06L10.94 12 5.47 6.53a.75.75 0 0 1 0-1.06Z"
                                                                                    clip-rule="evenodd" />
                                                                            </svg>
                                                                        </span>
                                                                    </div>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div
                                        class="mb-4 p-4 bg-slate-100 rounded-lg border border-dashed border-slate-300 flex justify-center text-slate-800">
                                        No Structure has been added yet!
                                    </div>
                                @endif
                                <div class="grid w-full grid-cols-1">
                                    <button type="button" @click="$wire.addColumn"
                                        class="flex items-center justify-center p-4 text-blue-600 border border-blue-600 border-dotted gap-x-4 rounded-xl">
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                                                fill="currentColor" class="size-6">
                                                <path fill-rule="evenodd"
                                                    d="M12 3.75a.75.75 0 0 1 .75.75v6.75h6.75a.75.75 0 0 1 0 1.5h-6.75v6.75a.75.75 0 0 1-1.5 0v-6.75H4.5a.75.75 0 0 1 0-1.5h6.75V4.5a.75.75 0 0 1 .75-.75Z"
                                                    clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div>
                                            Add new Column
                                        </div>
                                    </button>
                                </div>
                            </x-lb::card.span-two>
                        </x-lb::card>
                        <x-lb::card>
                            <x-lb::card.span-two>
                                <div class="flex justify-end">
                                    <x-lb::buttons-bg.primary type="submit" wire:target="create">
                                        Save
                                    </x-lb::buttons-bg.primary>
                                </div>
                            </x-lb::card.span-two>
                        </x-lb::card>
                    </x-lb::form.layout.flex-col>
                </x-lb::form.layout.flex-row>
            </x-lb::form>
        </div>
    </div>
</div>
