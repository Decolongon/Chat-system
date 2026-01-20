<div x-init="Echo.private('posts.{{ auth()->id() }}')
    .listen('PostEvent', (event) => {
        $wire.refreshPosts(event);
    })">
    {{-- If your happiness depends on money, you will never be happy with yourself. --}}

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @foreach ($this->getPosts as $post)
        <div wire:key="post-{{ $post->id }}">
            <h1>{{ $post->title }}</h1>
            <p>{{ $post->body }}</p>
        </div>
    @endforeach





</div>
