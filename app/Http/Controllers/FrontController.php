<?php

namespace App\Http\Controllers;

use App\Models\ArticleNews;
use App\Models\Author;
use App\Models\BannerAdvertisement;
use App\Models\Category;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $articles = ArticleNews::with(['category'])
            ->where('is_featured', 'not_featured')
            ->latest()
            ->take(3)
            ->get();

        $featured_articles = ArticleNews::with(['category'])
            ->where('is_featured', 'featured')
            ->inRandomOrder()
            ->take(3)
            ->get();

        $authors = Author::all();

        $banner_ads = BannerAdvertisement::where('is_active', 'active')
            ->where('type', 'banner')
            ->inRandomOrder()
            ->first();

        $entertainment_articles = ArticleNews::whereHas('category', function ($query) {
            $query->where('name', 'Entertainment');
        })
            ->where('is_featured', 'not_featured')
            ->latest()
            ->take(6)
            ->get();

        $featured_entertainment_articles = ArticleNews::whereHas('category', function ($query) {
            $query->where('name', 'Entertainment');
        })
            ->where('is_featured', 'featured')
            ->inRandomOrder()
            ->first();

        $authors = Author::all();

        return view('front.index', compact(
            'categories',
            'articles',
            'authors',
            'featured_articles',
            'banner_ads',
            'entertainment_articles',
            'featured_entertainment_articles'
        ));
    }

    public function details($slug)
    {
        // Logic for the details page
        return view('front.details', compact('slug'));
    }

    public function category(Category $category)
    {
        $categories = Category::all();
        return view('front.category', compact('category', 'categories'));
    }

    public function author($slug)
    {
        // Logic for the author page
        return view('front.author', compact('slug'));
    }

    public function search(Request $request)
    {
        // Logic for the search functionality
        return view('front.search');
    }
}
