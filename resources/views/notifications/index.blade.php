<x-app-layout>
    <div class="max-w-2xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-4">Notifications</h2>

        <!-- Friend Requests -->
        @if(isset($friendRequests) && $friendRequests->count() > 0)
            <h3 class="text-lg font-semibold mb-2">Friend Requests</h3>

            @foreach($friendRequests as $request)
                <div class="border-b py-3 flex justify-between items-center">
                    <div>
                        🧑‍🤝‍🧑 
                        <strong>{{ $request->sender->name }}</strong> 
                        sent you a friend request.
                    </div>

                    <div class="flex gap-2">
                        <!-- Accept Button -->
                        <form action="{{ route('friends.accept', $request->id) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="bg-blue-600 text-white px-3 py-1 text-xs rounded-lg hover:bg-blue-700 transition">
                                Accept
                            </button>
                        </form>

                        <!-- Ignore Button -->
                        <form action="{{ route('friends.ignore', $request->id) }}" method="POST">
                            @csrf
                            <button type="submit" 
                                    class="bg-gray-300 text-gray-700 px-3 py-1 text-xs rounded-lg hover:bg-gray-400 transition">
                                Ignore
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        @endif

        <!-- Post Comments Notifications -->
        @if($notifications->count() > 0)
            <h3 class="text-lg font-semibold mt-6 mb-2">Post Notifications</h3>
            @foreach($notifications as $notif)
                <div class="border-b py-3">
                    <p class="text-gray-800">
                        💬 <strong>{{ $notif->fromUser->name }}</strong> commented on your post.
                    </p>
                    <small class="text-gray-500">{{ $notif->created_at->diffForHumans() }}</small>
                </div>
            @endforeach
        @endif

        @if($friendRequests->isEmpty() && $notifications->isEmpty())
            <p class="text-gray-500 text-center">No notifications yet.</p>
        @endif
    </div>
</x-app-layout>
