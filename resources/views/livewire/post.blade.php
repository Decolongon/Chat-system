<div>
    {{-- Nothing in the world is as soft and yielding as water. --}}

    <form wire:submit.prevent="submit">

        <input type="text" wire:model="form.title">

        @error('form.title')
            {{ $message }}
        @enderror

        <textarea wire:model="form.body" cols="30" rows="10">

        </textarea>

         @error('form.body')
            {{ $message }}
        @enderror

        <button type="submit">Save Post</button>
    </form>

    {{-- @foreach ($posts as $post)

        <div>
            <h1>{{ $post->title }}</h1>
            <p>{{ $post->body }}</p>
        </div>
        
    @endforeach --}}

    <livewire:post-list/>
</div>
