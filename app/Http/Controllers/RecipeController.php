<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Tag;
use App\Models\Recipe;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Gate;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;


class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        abort_if(Gate::denies('recipe_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if (auth()->user()->hasRole('Admin')) {
            $recipes = Recipe::all();
        } else {
            $recipes = Recipe::where('user_id', auth()->user()->id)->get();
        }

        return view('recipes.index', compact('recipes'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        abort_if(Gate::denies('recipe_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::all()->pluck('name', 'id');
        $tags = Tag::all();

        return view('recipes.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Recipe $recipe)
    {
        $request->validate([
            'title' => 'required|min:2|max:50',
            'category' => 'required|numeric',
            'image' => 'required|dimensions:min_width=400,min_height=300',
            'excerpt' => 'required|max:250',
            'description' => 'required',
            'ingredients' => 'required',
            'preparation' => 'required',
        ]);

        if ($request->file('image')) {
            //Obtenemos la ruta de la imagen
            $ruta_imagen = $request->file('image')->store('upload-recipes', 'public');
            //Recortamos la imagen para que se ajuste a lo requerido
            $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(400, 300);
            //Guardamos la imagen en el directorio
            $img->save();
        }

        //Guardamos las imagenes que vengan en los campos ingredients y preparation
        $data = $recipe->saveImagesFromRecipes($request->ingredients, $request->preparation);

        //Guardamos la receta, enviamos el request y el contenido de ingredients y preparation
        $recipe->saveRecipe($request, $data, $ruta_imagen);

        return redirect()->route('recipes.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function show(Recipe $recipe)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function edit(Recipe $recipe)
    {
        abort_if(Gate::denies('recipe_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $categories = Category::all()->pluck('name', 'id');
        $tags = Tag::all();

        return view('recipes.edit', compact('categories', 'tags', 'recipe'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Recipe $recipe)
    {
        $request->validate([
            'title' => ['required', 'min:2', 'max:50', Rule::unique('recipes')->ignore($recipe->id)],
            'image' => 'dimensions:min_width=400,min_height=300',
            'category' => 'required|numeric',
            'excerpt' => 'required|max:250',
            'description' => 'required',
            'ingredients' => 'required',
            'preparation' => 'required',
        ]);

        $ruta_imagen = null;

        if ($request->file('image')) {
            Storage::delete('public' . Str::of($recipe->image)->after('storage'));
            //Obtenemos la ruta de la imagen
            $ruta_imagen = $request->file('image')->store('upload-recipes', 'public');
            //Recortamos la imagen para que se ajuste a lo requerido
            $img = Image::make(public_path("storage/{$ruta_imagen}"))->fit(400, 300);
            //Guardamos la imagen en el directorio
            $img->save();
        }

        $recipe->deleteImages('update', $request);

        $data = $recipe->saveImagesFromRecipes($request->ingredients, $request->preparation);

        $recipe->updateRecipe($request, $data, $ruta_imagen);

        return redirect()->route('recipes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Recipe  $recipe
     * @return \Illuminate\Http\Response
     */
    public function destroy(Recipe $recipe)
    {
        abort_if(Gate::denies('recipe_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        Storage::delete('public' . Str::of($recipe->image)->after('storage'));   

        $recipe->deleteImages('delete', null);

        $recipe->delete();

        return redirect()->route('recipes.index');
    }
}
