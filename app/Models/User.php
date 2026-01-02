<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;


class User extends Authenticatable implements MustVerifyEmail,HasMedia
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,InteractsWithMedia;
     

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'image',
        'bio',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }


    
    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('avatar')
            ->width( 128)
            ->crop(128, 128)
            ->nonQueued();
        
    }
    public function registerMediaCollections(): void
    {
        $this
            ->addMediaCollection('avatar')
            ->singleFile();
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    // Followers relationship (Users who follow this user)
    public function followers()
    {
        return $this->belongsToMany(User::class, 'followers', 'user_id', 'follower_id');
    }

    // Following relationship (this user follow Users)
    public function following()
    {
        return $this->belongsToMany(User::class, 'followers', 'follower_id', 'user_id');
    }

    public function imageUrl()
    {
        $media = $this->getFirstMedia('avatar');
        if($media){
            if($media?->hasGeneratedConversion('avatar')){
                return $media->getUrl('avatar');
            }
            return $media->getUrl();
        }
        return 'https://placehold.co/128x128/png';
    }

    
    public function readTime($readingSpeed = 100)
    {

        $wordCount = str_word_count(strip_tags($this->content));

        $minute = ceil($wordCount / $readingSpeed);

        return max(1, $minute);
    }

    /**
     * Check if the current user is followed by the given user(current user means user which post showing right now and given user is login user).
     *
     * @param  User  $user  The user to check if they are following this user.
     * @return bool True if the given user is following this user, false otherwise.
     */
    public function isFollowedBy(?User $user)
    {
        if(!$user){
            return false;
        }
        return $this->followers()->where('follower_id', $user->id)->exists();
    }

     public function hasClapped(Post $post){
        return $post->claps()->where('user_id',$this->id)->exists();
    }
}
