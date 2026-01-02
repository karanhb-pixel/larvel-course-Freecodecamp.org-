<div class="flex bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 mb-8">
    @php 
        $route = route('post.show',[
            'user' =>$post->user,
            'post' =>$post->slug
            ]);

        $route_profile = route('profile.show',[
            'user' => $post->user->username
            ]);
    @endphp
    <div class="p-5 flex-1 flex flex-col">
        <a href="{{ $route }}">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                {{ $post->title }}
            </h5>
        </a>
        <div class="mb-3 font-normal text-gray-700 dark:text-gray-400">
            {{ Str::words($post->content, 20) }}
        </div>
        <div class="mt-auto text-gray-400 text-sm flex gap-4 items-center ">
            <div>
                By
                <a href="{{ $route_profile }}" class="text-gray-600 hover:underline underline-offset-4 hover:text-gray-900">
                    {{ $post->user->username }}
                </a>
                At
                    {{ $post->getCreatedAtDisplay() }}
            </div>
            <span class="inline-flex items-center gap-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640" class="w-6 h-6">
                <path d="M144 224C161.7 224 176 238.3 176 256L176 512C176 529.7 161.7 544 144 544L96 544C78.3 544 64 529.7 64 512L64 256C64 238.3 78.3 224 96 224L144 224zM334.6 80C361.9 80 384 102.1 384 129.4L384 133.6C384 140.4 382.7 147.2 380.2 153.5L352 224L512 224C538.5 224 560 245.5 560 272C560 291.7 548.1 308.6 531.1 316C548.1 323.4 560 340.3 560 360C560 383.4 543.2 402.9 521 407.1C525.4 414.4 528 422.9 528 432C528 454.2 513 472.8 492.6 478.3C494.8 483.8 496 489.8 496 496C496 522.5 474.5 544 448 544L360.1 544C323.8 544 288.5 531.6 260.2 508.9L248 499.2C232.8 487.1 224 468.7 224 449.2L224 262.6C224 247.7 227.5 233 234.1 219.7L290.3 107.3C298.7 90.6 315.8 80 334.6 80z"/>
                </svg>
                {{ $post->claps_count }} 
               
            </span>
        </div>
    </div>
    <a href="{{ $route }}">
        <img class="rounded-r-lg w-48 h-full object-cover " src="{{ $post->imageUrl() }}" alt="" />
    </a>
</div>