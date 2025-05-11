<x-layout title="Edit">
    <form hx-put="{{ route('tags.update', ['tag' => $tag]) }}" class="flex flex-col">
        <x-input name="name" type="text" label="name" placeholder="$tag-name" :value="$tag->name" required inline />

        <hr class="text-light-gamma" />

        <div class="flex flex-row gap-2 mt-2">
            <x-button
                type="submit"
            >
                Save
            </x-button>
        </div>
    </form>
</x-layout>