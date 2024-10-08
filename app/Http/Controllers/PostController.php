<?php

namespace App\Http\Controllers;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Psy\Readline\Hoa\Console;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
class PostController extends Controller
{
    public function index()
    {

        $posts = Post::when(request()->category, function (Builder $query, int $category) {
            $query->where('category_id', $category);
        })->simplePaginate(3);
        $categories = Category::all();
        return view('post.index', ['posts' => $posts, 'categories' => $categories]);
    }

    public function show($id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::all();
        $lastPost = Post::orderBy('created_at', 'DESC')
            ->take(4)->get();

        return view('post.post', ['post' => $post, 'categories' => $categories, 'lastPosts' => $lastPost]);
    }

    public function create()
    {

        return view('post.create');
    }

    public function store(PostRequest $req)
    {

        $post = new Post();
        $post->title = $req->title;
        $post->description = $req->desc;
        $file_name = time() . '.' . $req->file('image')->getClientOriginalExtension();
        $req->file('image')->move(public_path('images'), $file_name);
        $post->image = $file_name;
        $post->save();
        return redirect('post');
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return view('post.postEdit', ['post' => $post]);
    }

    public function update(PostRequest $req, $id)
    {
        $post = Post::findOrFail($id);
        $post->title = $req->title;
        $post->description = $req->desc;
        $post->save();
        return redirect('post');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return redirect('post');
    }
}