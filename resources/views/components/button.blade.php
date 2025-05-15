<button {{ $attributes->merge(['class' => 'bg-bg-beta dark:bg-dark-bg-beta hover:bg-bg-gamma dark:hover:bg-dark-bg-gamma text-fg-alpha dark:text-dark-fg-alpha hover:text-bg-beta dark:hover:text-dark-bg-beta p-0.5 px-0.5 text-sm leading-none']) }}>
    {{ $slot }}
</button>