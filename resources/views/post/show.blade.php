<x-app-layout>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg lg:p-8">
                <h1 class="text-3xl font-bold mb-4">{{ $post->title }}</h1>

                {{-- user details section --}}
                <div id="user-container" class="flex gap-4 justify-start items-center mb-6">
                    <x-user-avatar :user="$post->user"/>
                    {{-- user details --}}
                    <div>
                        {{-- {{ dd($post->user->name); }} --}}
                        <x-follower-button class="flex gap-2" :user="$post->user">
                            <a href="{{ route('profile.show', $post->user) }}" class="text-lg font-semibold hover:underline">{{ $post->user->name }}</a>
                           @auth
                            &middot;
                            <button @click="follow()" x-text="following ? 'Unfollow' : 'Follow'"  :class="following ? 'text-red-600':'text-emerald-500'" ></button>
                            @endauth
                        </x-follower-button>

                        <div class="flex gap-2 text-gray-500 text-sm">
                            {{ $post->user->readTime() }} min read
                            &middot;
                            {{ $post->created_at->format('M d, Y') }}
                        </div>
                    </div>
                </div>
                {{-- End of user details section --}}

                {{-- Clap Section --}}
                <div class="border-t border-b py-4 flex items-center justify-between mt-8 px-4">
                    <x-clap-button :post="$post"/>
                </div>
                {{-- End of Clap section --}}


                {{-- post Content Section --}}
                <div class="mt-8 p-4">
                    <img src="{{ $post->imageUrl('large') }}" alt="{{ $post->title }}"
                        class="w-full h-96 object-cover mb-6 " />
                    <div class="mt-4">{{ $post->content }}</div>
                </div>

                {{-- Caterory section --}}
                <div class="mt-8">
                    <span class="bg-gray-200 text-gray-800 px-4 py-2 rounded-xl text-sm font-medium">
                        {{ $post->category->name }}
                    </span>
                </div>
                {{-- End of Caterory section --}}

                {{-- Clap Section --}}
                <div class="border-t border-b py-4 flex items-center justify-between mt-8 px-4">
                    <x-clap-button :post="$post"/>
                </div>
                {{-- End of Clap section --}}

                {{-- End of post Content Section --}}
                <x-primary-button class="mt-8 hover:underline">
                    Back to Posts
                    </x-primary-button>
            </div>
        </div>
    </div>

</x-app-layout>