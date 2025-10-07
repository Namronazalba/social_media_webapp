<x-app-layout>
    <div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-4">{{ $friend->name }}'s Posts</h2>

        @if($posts->count() > 0)
            @foreach($posts as $post)
                <div class="border-b py-4">
                    <p class="text-gray-800">{{ $post->content }}</p>
                    <span class="text-gray-500 text-sm">{{ $post->created_at->diffForHumans() }}</span>
                </div>
            @endforeach
        @else
            <p class="text-gray-500">No posts yet.</p>
        @endif
    </div>
</x-app-layout>
