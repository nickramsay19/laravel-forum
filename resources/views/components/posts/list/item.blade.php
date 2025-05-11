@props([
    'post' => null,
    'readonly' => false,
])

@php
    $readonly = boolval($readonly);
@endphp

<article dir="ltr" {{ $attributes->merge(['class' => 'flex flex-col justify-between']) }}>
    <div class="flex flex-row group">
        <x-link href="/posts/{{ $post->slug }}" class="!text-accent font-semibold group-hover:underline align-top basis-full grow">{{ $post->title }}</x-link>

        @if ($readonly === false)
            <x-posts.command-menu :post="$post" class="justify-end" />
        @endif
    </div>

    <span>
        
        <span class="text-fg-gamma">{{ $post->created_at_date }}</span>
        <span class="text-accent">{{ $post->author->name }}</span>

        @foreach ($post->tags as $tag)
            <x-tag-link :tag="$tag" />
        @endforeach
    </span>
</article>