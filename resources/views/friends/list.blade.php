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
                    <form action="{{ route('friends.unfriend', $friend->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button>unfriend</button>
                    </form>
                </div>
            @endforeach
        @else
            <p class="text-gray-500">You haven’t added any friends yet.</p>
        @endif
    </div>
</x-app-layout>
