<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Category;
use Carbon\Carbon;
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

        $recipesByCat = Category::byCategory();
        
        $categories = Category::pluck('name', 'id')->all();

        //dd($categories);

        return view('pages.index', compact('recents', 'recipesByCat', 'categories'));
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
        $recipes = $category->recipes()->published()->simplePaginate(9);
        $categories = Category::pluck('name', 'id')->all();
        $category = $category->name;
        
        return view('pages.show-category', compact('recipes', 'category', 'categories'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'title' => 'required'
        ]);

        if ($request->category) {
            $results = Recipe::published()
                        ->where('category_id', $request->category)
                        ->where('title', 'like', '%' . $request->title . '%')->paginate(3);
        } else {
            $results = Recipe::published()
                            ->where('title', 'like', '%' . $request->title . '%')->paginate(3);
        }

        $categories = Category::pluck('name', 'id')->all();

        return view('pages.search', compact('results', 'categories'));
    }
}
