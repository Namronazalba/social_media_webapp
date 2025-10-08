<x-app-layout>
    <div class="max-w-2xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
        <h2 class="text-xl font-semibold mb-4">Notifications</h2>

        @forelse($notifications as $notif)
            <div class="border-b py-3">
                <p class="text-gray-800">
                    @if($notif->type === 'comment')
                        💬 <strong>{{ $notif->fromUser->name }}</strong> commented on your post.
                    @elseif($notif->type === 'friend_request')
                        🧑‍🤝‍🧑 <strong>{{ $notif->fromUser->name }}</strong> sent you a friend request.
                    @endif
                </p>
                <small class="text-gray-500">{{ $notif->created_at->diffForHumans() }}</small>
            </div>
        @empty
            <p class="text-gray-500">No notifications yet.</p>
        @endforelse
    </div>
</x-app-layout>
