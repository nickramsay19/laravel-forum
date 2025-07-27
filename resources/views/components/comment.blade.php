<div class="flex flex-col gap-2">
    <div class="flex flex-col justify-between gap-1 border-l-2 border-accent pl-2 my-1 mt-2">

        <div class="flex flex-row group gap-1 justify-between">

            <div class="flex flex-row group gap-2 justify-left">
                <x-link href="#" class="align-top basis-full grow font-semibold group-hover:underline">{{ $comment->author->name }}</x-link>
                <span class="text-disabled">{{ $comment->created_at_date }}
            </div>

            @if (Auth::check())
                <a href="#" onclick="toggleReplyForm({{ $comment->id }})" class="text-yellow-500 underline cursor-pointer hover:font-semibold">reply</a>
            @endif
        </div>

        <span>
            {{ $comment->body }}
        </span>

        @if (Auth::check())
            <div id="reply-form-{{ $comment->id }}" style="display: none" class="flex flex-col justify-between gap-1 border-l-2 border-accent pl-2 my-1 mt-2">
                <div class="flex flex-row gap-1">
                    <x-link href="#" class="align-top basis-full grow font-semibold group-hover:underline">{{ Auth::user()->name }}</x-link>
                </div>

                <form hx-post="{{ route('comments.store') }}" hx-ext='json-enc' class="flex flex-col">

                    <x-input name="post_id" type="hidden" value="{{ $comment->post_id }}" />
                    <x-input name="reference_id" type="hidden" value="{{ $comment->id }}" />
                    <x-input name="body" type="textarea" placeholder="The reply's content" rows="3" class="mt-1" />
                    <div class="flex flex-row gap-2 mt-2">
                        <x-button
                            type="button"
                            onclick="toggleReplyForm({{ $comment->id }})" 
                            class="hover:!bg-red-500 border !border-red-500"
                        >
                            Cancel
                        </x-button>
                        <x-button
                            type="submit"
                        >
                            Save
                        </x-button>
                    </div>
                </form>
            </div>
        @endif

        @foreach ($comment->referrers as $refferer)
            <x-comment :comment="$refferer" />
        @endforeach
    </div>
</div>