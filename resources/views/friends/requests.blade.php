<x-app-layout>
    <div class="max-w-3xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Friend Requests</h2>

        @if($requests->count() > 0)
            @foreach ($requests as $req)
                <div class="flex justify-between items-center border-b py-3">
                    <div>
                        <a href="{{ route('friends.profile', $req->sender->id) }}" 
                           class="text-lg font-semibold text-blue-600 hover:underline">
                           {{ $req->sender->name }}
                        </a>
                        <p class="text-gray-500 text-sm">sent you a friend request</p>
                    </div>

                    <div class="flex gap-2">
                        <form action="{{ route('friends.accept', $req->id) }}" method="POST">
                            @csrf
                            <button class="px-3 py-1 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                Accept
                            </button>
                        </form>
                        <form action="{{ route('friends.ignore', $req->id) }}" method="POST">
                            @csrf
                            <button class="px-3 py-1 bg-gray-400 text-white rounded-lg hover:bg-gray-500">
                                Ignore
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-gray-500">No pending friend requests.</p>
        @endif
    </div>
</x-app-layout>
