<x-app-layout>
    <div class="max-w-2xl mx-auto mt-10">

        <!-- Create Post -->
        <div class="bg-white p-6 rounded-lg shadow mb-6">
            <h2 class="text-xl font-semibold mb-4">Create a Post</h2>

            <form method="POST" action="{{ route('posts.store') }}">
                @csrf
                <textarea name="content" rows="3" placeholder="What's on your mind?"
                          class="w-full p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:ring-blue-200"></textarea>

                <button type="submit"
                        class="mt-3 px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Post
                </button>
            </form>
        </div>

        <!-- Feed -->
        <div class="space-y-4">
            <h2 class="text-xl font-semibold mb-2">Your Posts</h2>
            @forelse($posts as $post)
                <div class="relative bg-white p-5 rounded-lg shadow">
                <!-- Burger Menu (only for own posts) -->
                @if($post->user_id === auth()->id())
                    <div x-data="{ open: false }" class="absolute top-4 right-4 z-20">
                        <button @click="open = !open"
                            class="text-gray-500 hover:text-gray-700 focus:outline-none">
                            ⋮
                        </button>

                        <div x-show="open" @click.away="open = false"
                            x-transition
                            class="absolute right-0 mt-2 w-32 bg-white border rounded-lg shadow-lg z-30">
                            <a href="{{ route('posts.edit', $post->id) }}"
                            class="block px-4 py-2 text-gray-700 hover:bg-gray-100">Edit</a>

                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                onsubmit="return confirm('Are you sure?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">Delete</button>
                            </form>
                        </div>
                    </div>
                @else
                    <div x-data="{ open: false }" class="absolute top-4 right-4 z-20">
                        <button @click="open = !open" class="text-gray-400 hover:text-gray-600">⋮</button>
                        <div x-show="open" @click.away="open = false"
                            class="absolute right-0 mt-2 w-32 bg-white border rounded-lg shadow-lg z-30">
                            <button class="w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                Hide
                            </button>
                        </div>
                    </div>
                @endif




                    <!-- Post Content -->
                    <div class="flex justify-between items-center mb-2">
                        <p class="font-semibold">{{ $post->user->name }}</p>
                        <small class="text-gray-500">{{ $post->created_at->diffForHumans() }}</small>
                    </div>
                    <p class="text-gray-800 whitespace-pre-line">{{ $post->content }}</p>
                </div>
            @empty
                <p class="text-gray-500">No posts yet. Share something!</p>
            @endforelse


        </div>

    </div>
</x-app-layout>
