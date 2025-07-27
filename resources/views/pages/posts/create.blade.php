<x-layout title="Create">
    <form hx-post="{{ route('posts.store') }}" hx-ext='json-enc' class="flex flex-col">
        
        <x-input name="title" type="text" label="Title" placeholder="Your post's title" required />

        <x-input name="body" type="textarea" label="Body" placeholder="The post's contents..." rows="25" class="mt-3" />
        
        <x-input.select name="tags" class="my-2" multiple>
            <option disabled>Tags:</option>
            @foreach (\App\Models\Tag::all()->pluck('name') as $tag)
                <option value="{{ $tag }}">{{ $tag }}</option>
            @endforeach
        </x-input.select>

        <hr class="text-light-beta " />

        <div class="flex flex-row gap-2 mt-2">
            <x-button
                type="submit"
                name="published" 
                value="0"
            >
                Saves
            </x-button>

            <x-button
                type="submit"
                name="published" 
                value="1"
            >
                Save & Publish
            </x-button>
        </div>
    </form>
</x-layout>