<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {   
        // \DB::listen(function ($query) {
        //     // Uncomment the line below to see the queries in the log
        //     \Log::info($query->sql, $query->bindings);
        // });
        
        $query = Post::with(['user', 'media'])
                ->where('published_at' ,'<=', now())
                ->withCount('claps')
                ->latest();
        $posts = $query->simplePaginate(5);
        // $posts = $query->simplePaginate(5);
        return view('post.index', [
            'posts' => $posts,
        ]);
    }
    public function indexByFollowing(User $user)
    {
        $query = Post::with(['user', 'media'])
                ->where('published_at' ,'<=', now())
                ->withCount('claps')
                ->latest();

        if($user){
            $ids = $user->following->pluck('id');
            $query->whereIn('user_id',$ids);
            // dd($ids);
        }
        $posts = $query->simplePaginate(5);
        return view('post.index', [
            'posts' => $posts,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();

        return view('post.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
public function store(PostCreateRequest $request)
    {
       $data = $request->validated();

        $data['user_id'] = auth()->id();
        
        // $data['image'] = $data['image']->store('posts', 'public');

        
        $post = Post::create($data);

        $post->addMediaFromRequest('image')
            ->toMediaCollection();

        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user, Post $post)
    {
        $post = Post::with(['user', 'media'])
                ->withCount('claps')
                ->findOrFail($post->id);

        return view('post.show',[
            'post'=>$post,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        $categories = Category::get();
         if($post->user_id !== auth()->id()){
            abort(403);
        }
        return view('post.edit', [
            'post' => $post,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
         if($post->user_id !== auth()->id()){
            abort(403);
        }

        $data = $request->validated();

        $post->update($data);

        if($request->hasFile('image')){
            $post->clearMediaCollection();
            $post->addMediaFromRequest('image')
                ->toMediaCollection();
        }

        return redirect()->route('post.myPosts');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if($post->user_id !== auth()->id()){
            abort(403);
        }
        $post->delete();

        return redirect()->route('post.myPosts');
    }

    public function category(Category $category){
        $posts = $category->posts()
                ->with(['user', 'media'])
                ->where('published_at'  ,'<=', now())
                ->withCount('claps')
                ->latest()
                ->simplePaginate(5);

        return view('post.index', [
            'posts' => $posts,
        ]);
    }
    public function myPosts(){
        $user = auth()->user();
        $posts = $user->posts()
                ->with(['user', 'media'])
                ->withCount('claps')
                ->latest()
                ->simplePaginate(5);

        return view('post.index', [
            'posts' => $posts,
        ]);
    }
}
