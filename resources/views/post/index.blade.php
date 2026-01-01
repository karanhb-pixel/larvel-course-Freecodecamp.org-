<x-app-layout>

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- category list --}}
            <x-catefory-tabs>
                No category Found
            </x-catefory-tabs>


            {{-- Post Section --}}
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
    </div>

</x-app-layout>