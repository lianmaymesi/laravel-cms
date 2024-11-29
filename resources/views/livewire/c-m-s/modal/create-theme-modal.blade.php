<x-lb::form wire:submit="create" x-data="{}">
    <x-lb::sidebar wire:model.live="show">
        <x-lb::sidebar.header heading="Create Theme"></x-lb::sidebar.header>
        <x-lb::sidebar.body>
            <div>
                <div class="grid grid-cols-1 gap-4 lg:grid-cols-2">
                    <div class="col-span-2">
                        <x-lb::form.input type="text" label="Theme Title" wire:model="form.title"
                            placeholder="Theme Title" :error="$errors->first('form.title')"></x-lb::form.input>
                    </div>
                    <div class="col-span-2 my-2">
                        <div class="flex gap-x-2">
                            <x-lb::form.checkbox label="Visible" wire:model="form.is_default">
                                Is Default Active Theme?
                            </x-lb::form.checkbox>
                        </div>
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
