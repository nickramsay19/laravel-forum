<button {{ $attributes->merge(['class' => 'bg-bg-beta hover:bg-bg-gamma text-fg-alpha hover:text-bg-beta p-0.5 px-0.5 text-sm leading-none']) }}>
    {{ $slot }}
</button>