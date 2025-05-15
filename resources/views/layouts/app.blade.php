<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta name="keywords" content="dev, developer, programming, c, cpp, python prog, math, aus, australia, sydney, nsw, algo, debug, books, memory" />
        <meta name="viewport" content="width=device-width" />

        <link rel="alternate" type="application/rss+xml" title="apparatchiks.exnet.su" href="https://apparatchiks.exnet.su/posts/feed/rss" />

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Azeret+Mono:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">

        <script src="https://unpkg.com/htmx.org@1.9.6" integrity="sha384-FhXw7b6AlE/jyjlZH5iHa/tTe9EpJ1Y55RjcgPbjeWMskSxZt1v9qkxLJWNJaGni" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/gh/Emtyloc/json-enc-custom@main/json-enc-custom.js"></script>
        <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
        
        @vite(['resources/css/app.css'])
        
        <title>{{ isset($title) ? ($title . ' | ') : '' }} apparatchiks.exnet.su</title>
    </head>
    <body class="bg-bg-alpha dark:bg-dark-bg-alpha text-fg-alpha dark:text-dark-fg-alpha text-md font-mono m-0" hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'>
        <div class="bg-bg-beta dark:bg-dark-bg-beta rounded-sm w-full md:w-60/100 m-0 md:m-auto mt-0 md:mt-2 p-1 px-2">
            <header class="mb-2">
                <div class="flex flex-row gap-1 justify-between w-full">
                    <span class="flex flex-inline align-middle gap-1 md:mb-2">
                        <div class="inline align-middle [&_span]:first:text-bg-gamma dark:[&_span]:first:text-dark-bg-gamma* :inline *:align-middle *:my-auto">

                            <x-nav.link to="home">apparatchiks.exnet.su</x-nav.link> 
                            <span>/</span>

                            @for ($i = 0; $i < count(Request::segments())-1; $i++)
                                <x-link href="/{{ implode('/', array_slice(Request::segments(), 0, $i+1)) }}">{{ Request::segment($i+1) }}</x-link>
                                <span>/</span>
                            @endfor

                            @if (count(Request::segments()))
                                <x-link class="!text-bg-gamma !hidden md:!inline ">{{ Str::lower($attributes->get(slug('title'), 'apparatchiks.exnet.su')) }}</x-link>
                            @endif

                        </div>
                    </span>
                    @if (!Auth::guest()) 
                        <aside class="hidden md:block flex-none">
                            <small class="text-sm">user: {{ Auth::user()->name }}</small>
                        </aside>
                    @endif
                </div>

                <nav class="flex justify-between mb-1 border-b-2 border-b-fg0veta align-middle">
                    <h1 class="border-b-0 heading-1 text-fg-beta dark:text-dark-fg-beta font-bold border-0 self-end">{{ $attributes->get('title', 'apparatchiks.exnet.su') ?? 'apparatchiks.exnet.su' }}</h1>
                </nav>
            </header>

            <main> 
                {{ $slot }}
            </main>

            <footer id="footer" class="text-center block mt-5">
                apparatchiks.exnet.su | 
                <x-nav.link to="home">home</x-nav.link>
                <x-nav.link to="posts">posts</x-nav.link>

                @can ('create', \App\Models\Tag::class)
                    <x-nav.link to="tags">tags</x-nav.link>
                @endcan
                
                @can ('viewAny', \App\Models\Role::class)
                    <x-nav.link to="roles">roles</x-nav.link>
                @endcan

                @if (Auth::check()) 
                    <x-nav.link to="logout">logout</x-nav.link>
                @else
                    <x-nav.link to="login">login</x-nav.link>
                @endif
                
            </footer>
        </div>

        @vite(['resources/js/app.js'])
    </body>
</html>
