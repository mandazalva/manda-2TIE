<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // 1. Ambil data Post dengan Eloquent ORM & Relasi BelongsTo(Category)
        $postQuery = Post::with('category')->where('is_published', true);

        if ($request->filled('category')) {
            $categorySlug = $request->category;
            $postQuery->whereHas('category', function ($q) use ($categorySlug) {
                $q->where('slug', $categorySlug);
            });
        }

        if ($request->filled('q')) {
            $keyword = $request->q;
            $postQuery->where(function ($q) use ($keyword) {
                $q->where('title', 'like', '%' . $keyword . '%')
                  ->orWhere('content', 'like', '%' . $keyword . '%');
            });
        }

        $guestPosts = $postQuery->latest()->paginate(6)->withQueryString();

        // 2. Ambil data Kategori menggunakan Query Builder (leftJoin & aggregasi count)
        $guestCategories = DB::table('categories')
            ->select(
                'categories.id',
                'categories.name',
                'categories.slug',
                DB::raw('COUNT(posts.id) as total_posts')
            )
            ->leftJoin('posts', function ($join) {
                $join->on('posts.category_id', '=', 'categories.id')
                     ->where('posts.is_published', '=', 1);
            })
            ->groupBy('categories.id', 'categories.name', 'categories.slug')
            ->orderBy('categories.name', 'asc')
            ->get();

        $data = [
            'username'        => 'Laravel 2 TIE',
            'last_login'      => date('Y-m-d H:i:s'),
            'list_pendidikan' => ['SD', 'SMP', 'SMA', 'S1', 'S2', 'S3'],
            'guestPosts'      => $guestPosts,
            'guestCategories' => $guestCategories,
        ];

        return view('home', $data);
    }
}
