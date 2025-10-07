<x-app-layout>
    <div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Suggested Friends</h2>

        @foreach ($users as $user)
            <div class="flex justify-between items-center border-b py-3">
                <div>
                    <a href="{{ route('friends.profile', $user->id) }}" 
                       class="text-lg font-semibold text-blue-600 hover:underline">
                        {{ $user->name }}
                    </a>
                </div>

                @if(in_array($user->id, $pending))
                    {{-- Request already sent --}}
                    <form action="{{ route('friends.cancel', $user->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                            Request Sent (Cancel)
                        </button>
                    </form>
                @else
                    {{-- Can send new request --}}
                    <form action="{{ route('friends.add', $user->id) }}" method="POST">
                        @csrf
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Add Friend
                        </button>
                    </form>
                @endif
            </div>
        @endforeach
    </div>
</x-app-layout>
