<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Recipe;
use App\Models\Category;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recents = Recipe::published()->latest('published_at')->take(3)->get();

        $populars = Recipe::withCount('likes')->get()->sortByDesc('likes_count')->take(3);

        $recipesByCat = Category::byCategory();

        $categories = Category::pluck('name', 'id')->all();

        //dd($categories);

        return view('pages.index', compact('recents', 'recipesByCat', 'populars', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    public function showCategory(Category $category)
    {
        $recipes = $category->recipes()->published()->simplePaginate(10);
        $categories = Category::with(['recipes' => function ($recipes) {
            $recipes->published();
        }])->get()->filter(function ($item) {
            return $item->recipes->count() > 0;
        })->sortByDesc(function ($item) {
            return $item->recipes->count();
        })->take(5);
        $category = $category->name;

        return view('pages.show-category', compact('recipes', 'category', 'categories'));
    }

    public function showFavorites(User $user)
    {
        $recipes = $user->myLikes()->simplePaginate(10);
        $categories = Category::with(['recipes' => function ($recipes) {
            $recipes->published();
        }])->get()->filter(function ($item) {
            return $item->recipes->count() > 0;
        })->sortByDesc(function ($item) {
            return $item->recipes->count();
        })->take(5);

        return view('pages.show-favorites', compact('recipes', 'categories'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'title' => 'required'
        ]);

        if ($request->category) {
            $results = Recipe::published()
                        ->where('category_id', $request->category)
                        ->where('title', 'ilike', '%' . $request->title . '%')->simplePaginate(3);
        } else {
            $results = Recipe::published()
                            ->where('title', 'ilike', '%' . $request->title . '%')->simplePaginate(3);
        }

        $categories = Category::with(['recipes' => function ($recipes) {
            $recipes->published();
        }])->get()->filter(function ($item) {
            return $item->recipes->count() > 0;
        })->sortByDesc(function ($item) {
            return $item->recipes->count();
        })->take(5);

        $title = $request->title;

        return view('pages.search', compact('results', 'categories', 'title'));
    }
}
