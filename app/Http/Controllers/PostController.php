<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\View\View;
use Illuminate\Http\Request;
use ProtoneMedia\Splade\SpladeTable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use ProtoneMedia\Splade\FileUploads\ExistingFile;
use ProtoneMedia\Splade\FileUploads\HandleSpladeFileUploads;

class PostController extends Controller
{
    public function index(): View
    {
        return view('post.index', [
            'posts' => SpladeTable::for(Post::class)
                ->column('title')
                ->column('action')
                ->paginate(10),
        ]);
    }

    public function create(): View
    {
        return view('post.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => ['required'],
            'image'  => 'required',
        ]);

        if ($request->hasFile('image')) {
            $path = Storage::putFile('posts', $request->file('image'));
            Post::create([
                'title' => $request->input('title'),
                'image' => $path,
            ]);

            return to_route('posts.index');
        }
        return back();
    }

    public function edit(Post $post): View
    {
        $image = ExistingFile::fromDisk('public')->get($post->image);
        return view('post.edit', [
            'post' => $post,
            'image' => $image,
        ]);
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $request->validate([
            'title' => 'required',
        ]);

        HandleSpladeFileUploads::forRequest($request);
        $path = $post->image;

        if (!isset($request->image_existing) && $request->hasFile('image')) {
            Storage::delete($post->image);

            $path = Storage::putFile('posts', $request->file('image'));
        }

        $post->update([
            'title' => $request->input('title'),
            'image' => $path,
        ]);

        return to_route('posts.index');
    }
}
