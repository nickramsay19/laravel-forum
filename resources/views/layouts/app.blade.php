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

        <script src="https://unpkg.com/htmx.org@1.9.6" integrity="sha384-FhXw7b6AlE/jyjlZH5iHa/tTe9EpJ1Y55RjcgPbjeWMskSxZt1v9qkxLJWNJaGni" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/gh/Emtyloc/json-enc-custom@main/json-enc-custom.js"></script>
        <script id="MathJax-script" async src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-mml-chtml.js"></script>
        
        @vite(['resources/css/app.css'])
        
        <title>{{ isset($title) ? ($title . ' | ') : '' }} apparatchiks.exnet.su</title>
    </head>
    <body class="bg-gray-50 dark:bg-dark-alpha dark:text-rose-50 m-0 text-sm font-mono" hx-headers='{"X-CSRF-TOKEN": "{{ csrf_token() }}"}'>
        <div class="bg-gray-50 dark:bg-dark-beta rounded-sm w-full md:w-60/100 m-0 md:m-auto mt-0 md:mt-1 p-1 px-2">
            <header class="mb-2">
                <div class="flex flex-row gap-1 justify-between w-full">
                    <span class="flex flex-inline align-middle gap-1 md:mb-2">
                        <div class="inline align-middle [&_span]:first:text-bright *:inline *:align-middle *:my-auto">
                            <x-nav.link to="home" class="">apparatchiks.exnet.su</x-nav.link> 
                            <span>/</span>

                        @for ($i = 0; $i < count(Request::segments())-1; $i++)
                            <x-link href="/{{ implode('/', array_slice(Request::segments(), 0, $i+1)) }}">{{ Request::segment($i+1) }}</x-link>
                            <span>/</span>
                        @endfor

                        @if (count(Request::segments()))
                            <x-link class="!hidden md:!inline dark:text-rose-50">{{ Str::lower($attributes->get('title', 'apparatchiks.exnet.su')) }}</x-link>
                        @endif

                        </div>
                    </span>
                    @if (!Auth::guest()) 
                        <aside class="hidden md:block flex-none">
                            <small class="text-sm">user: {{ Auth::user()->name }}</small>
                        </aside>
                    @endif
                </div>

                <nav class="flex justify-between mb-1 border-b-2 border-b-accent align-middle">
                    <h1 class="border-b-0 heading-1 text-accent font-bold border-0 self-end">{{ $attributes->get('title', 'apparatchiks.exnet.su') ?? 'apparatchiks.exnet.su' }}</h1>
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
