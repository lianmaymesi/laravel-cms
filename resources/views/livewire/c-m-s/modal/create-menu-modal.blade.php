<x-lb::form wire:submit="create" x-data="{}">
    <x-lb::sidebar wire:model.live="show">
        <x-lb::sidebar.header heading="Create Menu"></x-lb::sidebar.header>
        <x-lb::sidebar.body>
            <div>
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
                <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                    <div class="col-span-2">
                        <x-lb::form.select label="Parent Menu" wire:model="form.parent_id" :error="$errors->first('form.parent_id')">
                            <option value="">Select the Parent Menu</option>
                            @foreach ($this->parentMenu as $key => $menu)
                                <option value="{{ $menu->id }}">{{ $menu->label }}</option>
                            @endforeach
                        </x-lb::form.select>
                    </div>
                    <div class="col-span-2">
                        <x-lb::form.input type="text" label="Menu Label" wire:model="form.label"
                            placeholder="Menu Label" :error="$errors->first('form.label')"></x-lb::form.input>
                    </div>
                    <div class="col-span-2">
                        <x-lb::form.input type="text" label="Title" wire:model="form.translations.title"
                            placeholder="Title" :error="$errors->first('form.translations.title')"></x-lb::form.input>
                    </div>
                    <div class="hidden col-span-2">
                        <x-lb::form.select label="Placement" wire:model="form.placement" :error="$errors->first('form.placement')" multiple>
                            <option value="">Select the Field Type</option>
                            <option value="header">Header</option>
                            <option value="footer">Footer</option>
                            <option value="important_links">Important Links</option>
                            <option value="learn_more">Learn More</option>
                        </x-lb::form.select>
                    </div>
                    <div class="col-span-2 grid gap-y-1.5 hidden">
                        <div class="text-sm font-medium tracking-wide text-slate-950">Visible in Search</div>
                        <div class="flex gap-x-2">
                            <x-lb::form.radio label="Visible" value="1" wire:model="form.search_visible">
                                Visible
                            </x-lb::form.radio>
                            <x-lb::form.radio label="Hidden" value="0" wire:model="form.search_visible">
                                Hidden
                            </x-lb::form.radio>
                        </div>
                    </div>
                    <div class="col-span-2 grid gap-y-1.5 hidden">
                        <div class="text-sm font-medium tracking-wide text-slate-950">Is this toplevel no-page?</div>
                        <div class="flex gap-x-2">
                            <x-lb::form.radio label="Visible" value="1" wire:model.live="form.is_toplevel">
                                Yes
                            </x-lb::form.radio>
                            <x-lb::form.radio label="Hidden" value="0" wire:model.live="form.is_toplevel">
                                No
                            </x-lb::form.radio>
                        </div>
                    </div>
                    <div class="col-span-2 gap-y-1.5 hidden">
                        <div class="text-sm font-medium tracking-wide text-slate-950">Have default page for this menu?
                        </div>
                        <div class="flex gap-x-2">
                            <x-lb::form.radio label="Visible" value="1" wire:model.live="form.have_page">
                                Yes
                            </x-lb::form.radio>
                            <x-lb::form.radio label="Hidden" value="0" wire:model.live="form.have_page">
                                No
                            </x-lb::form.radio>
                        </div>
                    </div>
                    <div class="hidden col-span-2" x-show="$wire.form.have_page == 1">
                        <x-lb::form.input type="text" label="Route" wire:model="form.route"
                            placeholder="Ex. product.index" :error="$errors->first('form.route')"></x-lb::form.input>
                    </div>
                    <div class="col-span-2">
                        <x-lb::form.select label="Status" wire:model="form.status" :error="$errors->first('form.status')">
                            <option value="">Select the Status</option>
                            <option value="draft">Draft</option>
                            <option value="publish">Publish</option>
                        </x-lb::form.select>
                    </div>
                </div>
            </div>
        </x-lb::sidebar.body>
        <x-lb::sidebar.footer>
            <x-lb::buttons-bg.primary type="button" wire:target="create" wire:click="create">
                Save
            </x-lb::buttons-bg.primary>
        </x-lb::sidebar.footer>
    </x-lb::sidebar>
</x-lb::form>
