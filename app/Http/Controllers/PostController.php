<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
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
        
        $query = Post::latest();
        $posts = $query->simplePaginate(5);
        // $posts = $query->simplePaginate(5);
        return view('post.index', [
            'posts' => $posts,
        ]);
    }
    public function indexByFollowing(User $user)
    {
        $query = Post::latest();

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
        $data['slug'] = Str::slug($data['title']);
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
        return view('post.show',[
            'post'=>$post,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }

    public function category(Category $category){
        $posts = $category->posts()->latest()->simplePaginate(5);

        return view('post.index', [
            'posts' => $posts,
        ]);
    }
}
