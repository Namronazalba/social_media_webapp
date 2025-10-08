<x-app-layout>
    <div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Your Friends</h2>

        @if($friends->count() > 0)
            @foreach($friends as $friend)
                <div class="flex justify-between items-center border-b py-3">
                    <a href="{{ route('friends.profile', $friend->id) }}" 
                       class="text-blue-600 font-semibold hover:underline text-lg">
                        {{ $friend->name }}
                    </a>
                    <span class="text-gray-500 text-sm">{{ $friend->email }}</span>
                    <form action="{{ route('friends.unfriend', $friend->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to unfriend {{ $friend->name }}?')">
                        @csrf
                        @method('DELETE')
                        <button 
                            type="submit"
                            class="flex items-center gap-1 bg-red-500 hover:bg-red-600 text-white text-sm px-4 py-2 rounded-lg transition duration-200 shadow-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Unfriend
                        </button>
                    </form>

                </div>
            @endforeach
        @else
            <p class="text-gray-500">You haven’t added any friends yet.</p>
        @endif
    </div>
</x-app-layout>
