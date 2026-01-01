<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="flex">

                    {{-- left Side Section --}}
                    <div id="left_side" class="flex-1 px-4">
                        <h1 class="text-3xl">{{ $user->name }}</h1>

                        {{-- User Posts --}}
                        <div class="text-gray-900 mt-8">
                            @forelse ($posts as $post)
                                <x-post-item :post="$post" />
                            @empty
                                <p class="text-center text-gray-500 py-16">No posts available.</p>
                            @endforelse
                        </div>

                        {{-- pagination --}}
                        {{ $posts->onEachSide(1)->links() }}
                    </div>

                    {{-- Right Side Section --}}
                    <x-follower-button :user="$user" id="right_side" 
                        class="w-[320px] border-l px-5 flex flex-col items-flex-start gap-4">
                        <x-user-avatar :user="$user" size="w-20 h-20" />
                        <h3>{{ $user->name }}</h3>
                        <span class="text-gray-500 text-sm"
                            x-text = "follwersCount + ' Followes'">
                        </span>
                        <p>{{ $user->bio }}</p>

                        @if(auth()->user() && auth()->user()->id !== $user->id)
                            <div class="mt-4">
                                <button @click="follow()" class="rounded-xl px-4 py-2 text-white "
                                    x-text="following ? 'Unfollow' : 'Follow'"
                                    :class="following ? 'bg-red-600' : 'bg-emerald-600'">

                                </button>
                            </div>
                        @endif
                    </x-follower-button>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>