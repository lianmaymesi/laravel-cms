<div @class([
    'grid gap-4 border -m-4 rounded-lg p-2',
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
    'grid-cols-' . count(json_decode($skeleton->skeleton, true)['data']) =>
        $settings['screens']['sm'] == 0 &&
        $settings['screens']['md'] == 0 &&
        $settings['screens']['lg'] == 0 &&
        $settings['screens']['xl'] == 0 &&
        $settings['screens']['2xl'] == 0,
])>
    @foreach (json_decode($skeleton->skeleton, true)['data'] as $key => $column)
        <div class="p-4">
            @foreach ($column['skeleton'] as $key => $value)
                @if (str_contains($value, 'text_'))
                    <div class="text-xs">This is title</div>
                @endif
                @if (str_contains($value, 'textarea_'))
                    <div class="text-xs">This is title</div>
                @endif
            @endforeach
        </div>
    @endforeach
</div>
