@props(['user'])

<div {{ $attributes }} x-data="{
        following: {{ auth()->check() && $user->isFollowedBy(auth()->user()) ? 'true' : 'false' }},
        follwersCount: {{ $user->followers()->count() }},
        follow() {
            // Save original state in case the request fails
            let previousState = this.following;
            
            axios.post('/follow/{{ $user->id }}')
                .then(res => {
                    {{-- console.log('Success:', res); --}}
                    // Optimistically update UI
            this.following = !this.following;
                    this.follwersCount = res.data.followers_count;
                })
                .catch(err => {
                    {{-- console.log('Error:', err); --}}
                    // Rollback state if server request fails
                    this.following = previousState;
                    alert('Something went wrong. Please try again.');
                });
        }
    }">
    {{ $slot }}
</div>