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
                            $form->language == null && app()->getLocale() === $localeCode,
                        'bg-indigo-600 text-indigo-50' => $form->language === $localeCode,
                    ])>
                        <input type="radio" id="{{ $localeCode }}" class="hidden" wire:model.live="form.language"
                            value="{{ $localeCode }}" @if ($form->language == null && app()->getLocale() === $localeCode) checked @endif />
                        {{ $properties['native'] }}
                    </label>
                @endforeach
            </div>
        </x-lb::actions>
    @endsection

    @section('page_title', $page_title)

    <div class="relative flex flex-col px-4">
        <div class="relative">
            <x-lb::form wire:submit.prevent="create" have-image :rtl="$form->language === 'ar' ? true : false">
                <x-lb::form.layout.flex-row>
                    <x-lb::form.layout.flex-col max-width="full">
                        <x-lb::card title="Basic Details">
                            <x-lb::card.span-one>
                                <x-lb::form.select wire:model="form.menu_id" label="Menu" :error="$errors->first('form.menu_id')">
                                    <option>Select the Menu</option>
                                    @foreach ($this->menus as $key => $menu)
                                        <option value="{{ $menu->id }}">{{ $menu->detail->title }}</option>
                                    @endforeach
                                </x-lb::form.select>
                            </x-lb::card.span-one>
                        </x-lb::card>
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
                        </x-lb::card>
                    </x-lb::form.layout.flex-col>
                    <x-lb::form.layout.flex-col-sticky max-width="xs" sticky>
                        <x-lb::card title="Featured Image">
                            <x-lb::card.span-two breakpoint="lg">
                                <label class="text-sm font-medium tracking-wide text-slate-950 block mb-1.5">
                                    General Featured Image
                                </label>
                                <x-lb::form.file wire:model="form.featured_image" label="General Featured Image"
                                    :error="$errors->first('form.featured_image')">
                                </x-lb::form.file>
                            </x-lb::card.span-two>
                            <x-lb::card.span-two breakpoint="lg">
                                <label class="text-sm font-medium tracking-wide text-slate-950 block mb-1.5">
                                    Featured Image for Each Language
                                </label>
                                <x-lb::form.file wire:model="form.translations.featured_image"
                                    label="Featured Image for Each Language" :error="$errors->first('form.translations.featured_image')">
                                </x-lb::form.file>
                            </x-lb::card.span-two>
                        </x-lb::card>
                        <x-slot:sticky-content>
                            <x-lb::card sticky>
                                <div class="flex items-center justify-end col-span-2 space-x-3">
                                    <span wire:loading wire:target="create" @class(['text-sm'])>
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
                                    <x-lb::buttons-bg.disabled type="button" wire:click="resetForm">
                                        Reset
                                    </x-lb::buttons-bg.disabled>
                                    <x-lb::buttons-bg.primary type="submit" wire:target="create">
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
</x-marketing.partials.app>
