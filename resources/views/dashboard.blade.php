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
                    <!-- Comments Section -->
                    <div class="mt-4 border-t pt-3">
                        <h4 class="text-sm font-semibold mb-2">Comments</h4>

                        @foreach($post->comments as $comment)
                            <div x-data="{ open: false, editing: false }" class="relative mb-3 bg-gray-50 p-3 rounded-lg">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <p class="text-sm">
                                            <span class="font-semibold">{{ $comment->user->name }}</span>
                                            <span x-show="!editing">{{ $comment->content }}</span>
                                        </p>
                                        <p class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                                    </div>

                                    @if($comment->user_id === auth()->id())
                                        <!-- Burger menu -->
                                        <div class="relative">
                                            <button @click="open = !open" class="text-gray-500 hover:text-gray-700">⋮</button>

                                            <div x-show="open" @click.away="open = false"
                                                x-transition
                                                class="absolute right-0 mt-2 w-32 bg-white border rounded-lg shadow-lg z-30">
                                                <button @click="editing = true; open = false"
                                                        class="block w-full text-left px-4 py-2 text-gray-700 hover:bg-gray-100">
                                                    Edit
                                                </button>
                                                <form method="POST" action="{{ route('comments.destroy', $comment->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="block w-full text-left px-4 py-2 text-red-600 hover:bg-gray-100">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <!-- Inline edit form -->
                                <div x-show="editing" x-transition class="mt-2">
                                    <form method="POST" action="{{ route('comments.update', $comment->id) }}" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <input type="text" name="content" value="{{ $comment->content }}"
                                            class="flex-1 border border-gray-300 rounded-lg px-3 py-1 text-sm focus:outline-none focus:ring focus:ring-blue-100">
                                        <button type="submit"
                                                class="px-3 py-1 bg-blue-600 text-white text-xs rounded-lg hover:bg-blue-700">Save</button>
                                        <button type="button" @click="editing = false"
                                                class="px-3 py-1 bg-gray-300 text-gray-800 text-xs rounded-lg hover:bg-gray-400">Cancel</button>
                                    </form>
                                </div>
                            </div>
                        @endforeach

                        <!-- Add Comment -->
                        <form method="POST" action="{{ route('comments.store', $post->id) }}" class="mt-3 flex items-center gap-2">
                            @csrf
                            <input type="text" name="content" placeholder="Write a comment..."
                                class="flex-1 border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring focus:ring-blue-100">
                            <button type="submit"
                                class="px-3 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700">Post</button>
                        </form>
                    </div>


                </div>
            @empty
                <p class="text-gray-500">No posts yet. Share something!</p>
            @endforelse


        </div>

    </div>
</x-app-layout>
