<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Sluggable;
use Staudenmeir\EloquentEagerLimit\HasEagerLimit;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Recipe extends Model
{
    use HasFactory, Sluggable, HasEagerLimit;

    protected $guarded = [];

    protected $dates = ['published_at'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    //MODEL BINDING
    public function getRouteKeyName()
    {
        return 'slug';
    }

    //RELACIONES
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'likes_recipe');
    }

    //QUERY SCOPES
    public function scopePublished($query)
    {
        $query->whereNotNull('published_at')
              ->where('published_at', '<=', Carbon::now());
    }

    public function scopeByCategory($query)
    {
        return $query->get()->groupBy('category_id');
    }

    //OPERACIONES
    public function saveRecipe($request, $data, $ruta_imagen)
    {
        $recipe = new Recipe;
        $recipe->title = $request->title;
        $recipe->excerpt = $request->excerpt;
        $recipe->description = $data[0];
        $recipe->ingredients = $request->ingredients;
        $recipe->preparation = $data[1];
        $recipe->image = 'storage/' . $ruta_imagen;
        $recipe->category_id = $request->category;
        $recipe->user_id = auth()->user()->id;
        $request->published_at
            ? $recipe->published_at = Carbon::parse($request->published_at)->format('Y-m-d H:i:s')
            : '';
        $recipe->save();

        $recipe->syncTags($request->get('tags'));
    }

    public function updateRecipe($request, $data, $ruta_imagen)
    {
        $this->slug = null;
        $this->update([
            'title' => $request->title,
            'excerpt' => $request->excerpt,
            'description' => $data[0],
            'ingredients' => $request->ingredients,
            'preparation' => $data[1],
            'category_id' => $request->category,
            'published_at' => $request->published_at
                ? $request->published_at = Carbon::parse($request->published_at)->format('Y-m-d H:i:s')
                : null
        ]);

        if ($ruta_imagen) {
            $this->update([
                'image' => 'storage/' . $ruta_imagen
            ]);
        }

        $this->syncTags($request->get('tags'));
    }

    public function syncTags($tags)
    {
        //Crea una colección con el arreglo y comienza un map
        $tagsIds = collect($tags)->map(function ($tag) {

            if(is_numeric($tag)) {
                //Si la etiqueta no existe la crea
                return Tag::find($tag) ? $tag : Tag::create(['name' => $tag])->id;
            } else {
                return !Tag::where('name', $tag)->get() ? Tag::where('name', $tag)->get('id') : Tag::create(['name' => $tag])->id;
            }
        });

        $this->tags()->sync($tagsIds);
    }

    public function saveImagesFromRecipes($description, $preparation)
    {
        $arrayFields = [$description, $preparation];
        //Este array contendrá los campos reconvertidos al final
        $newArr = [];

        //Iteramos sobre el array de campos que puedan tener imagenes
        foreach ($arrayFields as $item) {
            $dom = new \DomDocument();
            @$dom->loadHtml(mb_convert_encoding($item, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

            //Tomamos todos los elementos con la etiqueta img
            $images = $dom->getElementsByTagName('img');

            //Verificamos que la tarjeta exista si no la creamos
            if (!file_exists('storage/recipeImages/')) {
                mkdir('storage/recipeImages/', 0777, true);
            }

            // foreach <img> in the submited message
            foreach ($images as $img) {
                $src = $img->getAttribute('src');

                // if the img source is 'data-url'
                if (preg_match('/data:image/', $src)) {

                    // get the mimetype
                    preg_match('/data:image\/(?<mime>.*?)\;/', $src, $groups);
                    $mimetype = $groups['mime'];

                    // Generating a random filename
                    $filename = uniqid();
                    $filepath = "storage/recipeImages/$filename.$mimetype";

                    // @see http://image.intervention.io/api/
                    Image::make($src)
                        // resize if required
                        /* ->resize(300, 200) */
                        ->encode($mimetype, 100)     // encode file to the specified mimetype
                        ->save(public_path($filepath));

                    $new_src = asset($filepath);
                    $img->removeAttribute('src');
                    $img->setAttribute('src', $new_src);
                    $img->setAttribute("class", "img-fluid rounded");
                } // <!--endif
            } // <!--endforeach

            $item = $dom->saveHTML();

            array_push($newArr, html_entity_decode($item));
        }

        return $newArr;
    }

    public function deleteImages($action, $request)
    {
        $arrayFields = [$this->description, $this->preparation];

        foreach ($arrayFields as $item) {
            $dom = new \DomDocument();
            @$dom->loadHtml($item, LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

            $images = $dom->getElementsByTagName('img');

            //Iteramos en todoas las imagenes obtenidas del campo
            foreach ($images as $img) {
                //Obtenemos el contenido del atributo src de img
                $src = $img->getAttribute('src');
                if ($action === 'delete') {
                    //Modificamos el string para obtener la url de la imagen
                    $urlImage = 'public' . Str::of($src)->after('storage');
                    //Borramos la imagen
                    Storage::delete($urlImage);
                } else if ($action === 'update') {
                    if (
                        !Str::of($request->description)->contains($src)
                        AND
                        !Str::of($request->preparation)->contains($src)
                    )
                    {
                        //Modificamos el string para obtener la url de la imagen
                        $urlImage = 'public' . Str::of($src)->after('storage');
                        //Borramos la imagen
                        Storage::delete($urlImage);
                    }
                }
            }

            $item = $dom->saveHTML();
        }
    }
}
