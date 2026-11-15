<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories using Query Builder.
     * Menggunakan Query Builder: leftJoin dengan tabel posts, select agregasi, nested where, dan pagination.
     */
    public function index(Request $request)
    {
        $query = DB::table('categories')
            ->select(
                'categories.id',
                'categories.name',
                'categories.slug',
                'categories.description',
                'categories.created_at',
                DB::raw('COUNT(posts.id) as total_posts')
            )
            ->leftJoin('posts', 'posts.category_id', '=', 'categories.id')
            ->groupBy(
                'categories.id',
                'categories.name',
                'categories.slug',
                'categories.description',
                'categories.created_at'
            );

        // Eksplorasi Query Builder: Nested Where untuk filter pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('categories.name', 'like', '%' . $search . '%')
                  ->orWhere('categories.description', 'like', '%' . $search . '%');
            });
        }

        $dataCategories = $query->orderBy('categories.created_at', 'desc')->paginate(10)->withQueryString();

        return view('admin.category.index', compact('dataCategories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created category in storage using Query Builder.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $slug = Str::slug($request->name);

        // Pastikan slug unik via Query Builder
        $existingSlugCount = DB::table('categories')->where('slug', 'like', $slug . '%')->count();
        if ($existingSlugCount > 0) {
            $slug .= '-' . ($existingSlugCount + 1);
        }

        DB::table('categories')->insert([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('category.index')->with('success', 'Kategori berhasil ditambahkan (Query Builder)!');
    }

    /**
     * Show the form for editing the specified category using Query Builder.
     */
    public function edit(string $id)
    {
        $category = DB::table('categories')->where('id', $id)->first();

        if (!$category) {
            return redirect()->route('category.index')->with('error', 'Kategori tidak ditemukan!');
        }

        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified category in storage using Query Builder.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
        ]);

        $slug = Str::slug($request->name);

        DB::table('categories')->where('id', $id)->update([
            'name' => $request->name,
            'slug' => $slug,
            'description' => $request->description,
            'updated_at' => now(),
        ]);

        return redirect()->route('category.index')->with('success', 'Kategori berhasil diperbarui (Query Builder)!');
    }

    /**
     * Remove the specified category from storage using Query Builder.
     */
    public function destroy(string $id)
    {
        DB::table('categories')->where('id', $id)->delete();

        return redirect()->route('category.index')->with('success', 'Kategori berhasil dihapus (Query Builder)!');
    }
}
