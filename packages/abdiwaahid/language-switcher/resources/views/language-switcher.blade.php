<div>
    <x-filament::dropdown offset="5" width="fit">
        <x-slot name="trigger">
            <x-filament::button outlined>
                {{ str($locale)->upper() }}
            </x-filament::button>
        </x-slot>

        @foreach ($languages as $key => $language)
            <x-filament::dropdown.list.item :href="route('abdiwaahid-language-switcher', $key)" tag='a'>
                {{ $key }} {{ __('abdiwaahid-users::messages.language-switcher.' . $key) }}
            </x-filament::dropdown.list.item>
        @endforeach
    </x-filament::dropdown>
</div>
