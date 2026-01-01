{{-- user Avatar --}}

@props(['user','size'=>'w-20 h-20'])
<img    
    src="{{$user->image ? $user->imageUrl() : 'https://www.shutterstock.com/image-vector/vector-design-avatar-dummy-sign-600nw-1290556063.jpg'}}" 
    alt="User Avatar" class="{{ $size }} rounded-full" />