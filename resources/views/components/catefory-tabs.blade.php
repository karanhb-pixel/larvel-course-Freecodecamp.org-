<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
    <div class="p-4 text-gray-900">
        {{-- Category links --}}
        <ul class="flex flex-wrap text-sm font-medium text-center text-gray-500 dark:text-gray-400 justify-center">
            <li class="me-2">
                <a href="/"
                    class="inline-block px-4 py-2.5 rounded-lg active transition-colors
                 {{ request()->is('/') ? 'bg-blue-600 text-white' : 'hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-white' }}"
                    aria-current="{{ request()->is('/') ? 'page' : 'false' }}">All</a>
            </li>

            {{-- Category links Loop --}}
            @forelse ($categories as $category)

                @php
                    // check of current URL match this category route
                    $isActive = request()->fullUrlIs(route('post.byCategory', $category));
                @endphp
                <li class="me-2">
                    <a href="{{ route('post.byCategory', $category) }}"
                        class="inline-block px-4 py-2.5 rounded-lg {{ $isActive ? 'bg-blue-600 text-white' : 'hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-white' }}"
                        aria-current="{{ $isActive ? 'page' : 'false' }}">
                        {{ $category->name }}
                    </a>
                </li>
            @empty
                <p class="text-center text-gray-500 py-4">{{ $slot }}</p>
            @endforelse

            @auth
            <li class="me-2">
                @php
                 $user = auth()->user() ;
                @endphp
                <a href="{{ route('post.byFollowing',$user) }}"
                    class="inline-block px-4 py-2.5 rounded-lg active transition-colors
                 {{ request()->is(route('post.byFollowing',$user)) ? 'bg-blue-600 text-white' : 'hover:text-gray-900 hover:bg-gray-100 dark:hover:bg-gray-800 dark:hover:text-white' }}"
                    aria-current="{{ request()->is(route('post.byFollowing',$user)) ? 'page' : 'false' }}">Following</a>
            </li>
            @endauth
        </ul>
    </div>
</div>