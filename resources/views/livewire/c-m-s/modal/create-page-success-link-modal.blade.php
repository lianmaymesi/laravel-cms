<x-lb::form wire:submit="save" x-data="{}">
    <x-lb::modal.dialog wire:model.live="show">
        <x-slot:header>
            CTA
        </x-slot>
        <x-slot:body>
            <div class="grid gap-4 p-4 text-xs">
                <div class="">
                    <x-lb::form.input type="text" label="CTA Text" wire:model="form.title" placeholder="CTA Text"
                        :error="$errors->first('form.title')"></x-lb::form.input>
                </div>
                <div class="">
                    <x-lb::form.input type="text" label="CTA Link" wire:model="form.link" placeholder="CTA Link"
                        :error="$errors->first('form.link')"></x-lb::form.input>
                </div>
            </div>
        </x-slot>
        <x-slot:button>
            <x-slot:customClose>
                <x-lb::buttons-bg.disabled type="button" wire:click="close">
                    Close
                </x-lb::buttons-bg.disabled>
            </x-slot:customClose>
            <x-lb::buttons-bg.success type="submit" wire:target="store">
                Save
            </x-lb::buttons-bg.success>
        </x-slot>
    </x-lb::modal.dialog>
</x-lb::form>
