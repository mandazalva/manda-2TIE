<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of posts using Eloquent ORM.
     * Menggunakan Eloquent: with('category') untuk eager loading relasi.
     */
    public function index(Request $request)
    {
        $query = Post::with('category');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('content', 'like', '%' . $search . '%');
            });
        }

        $dataPosts = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.post.index', compact('dataPosts', 'categories'));
    }

    /**
     * Show the form for creating a new post.
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();

        if ($categories->isEmpty()) {
            return redirect()->route('category.create')->with('info', 'Silakan buat kategori terlebih dahulu sebelum membuat postingan!');
        }

        return view('admin.post.create', compact('categories'));
    }

    /**
     * Store a newly created post in storage using Eloquent ORM.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'is_published' => 'nullable|boolean',
        ]);

        $slug = Str::slug($request->title);
        $count = Post::where('slug', 'like', $slug . '%')->count();
        if ($count > 0) {
            $slug .= '-' . ($count + 1);
        }

        Post::create([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'is_published' => $request->has('is_published') ? 1 : 0,
        ]);

        return redirect()->route('post.index')->with('success', 'Postingan berhasil ditambahkan (Eloquent ORM)!');
    }

    /**
     * Show the form for editing the specified post using Eloquent ORM.
     */
    public function edit(string $id)
    {
        $post = Post::findOrFail($id);
        $categories = Category::orderBy('name')->get();

        return view('admin.post.edit', compact('post', 'categories'));
    }

    /**
     * Update the specified post in storage using Eloquent ORM.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'is_published' => 'nullable|boolean',
        ]);

        $post = Post::findOrFail($id);

        $slug = Str::slug($request->title);
        if ($slug !== $post->slug) {
            $count = Post::where('slug', 'like', $slug . '%')->where('id', '!=', $id)->count();
            if ($count > 0) {
                $slug .= '-' . ($count + 1);
            }
        }

        $post->update([
            'title' => $request->title,
            'slug' => $slug,
            'content' => $request->content,
            'category_id' => $request->category_id,
            'is_published' => $request->has('is_published') ? 1 : 0,
        ]);

        return redirect()->route('post.index')->with('success', 'Postingan berhasil diperbarui (Eloquent ORM)!');
    }

    /**
     * Remove the specified post from storage using Eloquent ORM.
     */
    public function destroy(string $id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return redirect()->route('post.index')->with('success', 'Postingan berhasil dihapus (Eloquent ORM)!');
    }
}
