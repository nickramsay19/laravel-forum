<x-layout :title="$headerPost->title ?? 'The Apparatchiks Forum'">
    <section class="mt-2">

        <x-posts.body>
            {{ $headerPost->body }}
        </x-posts.body>

        <hr class="text-bg-gamma last:hidden my-2">

        <x-posts.list :posts="$posts" readonly />

        <x-divider class="my-2" />

        <x-link to="posts" class="font-mono font-sembold underline">see all posts</x-link>
    </section>
</x-layout>