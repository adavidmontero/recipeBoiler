@extends('layouts.front.app')

@section('content')
    <div class="container py-4">
        <div class="row">
            <div class="col-lg-8">
                <h1 class="text-green">{{ $recipe->title }}</h1>
                <p class="lead text-justify">
                    {{ $recipe->excerpt }}
                </p>
                
                <hr>

                {{-- <p>
                    <i class="fa fa-calendar-alt"></i>
                    <span class="font-weight-bold">Publicado el:</span> 
                        {{ $recipe->published_at->formatLocalized('%d de %B %Y a las %H:%m %p') }}
                    |
                    <i class="fa fa-user-alt"></i>
                    <span class="font-weight-bold">Por:</span> 
                    {{ $recipe->user->name }}
                    |
                    <i class="fa fa-list-alt"></i>
                    <span class="font-weight-bold">Categoría:</span> 
                    {{ $recipe->category->name }}
                </p> --}}

                <div class="d-flex justify-content-between flex-wrap">
                    <p>
                        <i class="fa fa-calendar-alt"></i>
                        <span class="font-weight-bold">Publicado el:</span> 
                        {{ $recipe->published_at->formatLocalized('%d de %B %Y a las %H:%m %p') }}
                    </p>
                    <p>
                        <i class="fa fa-user-alt"></i>
                        <span class="font-weight-bold">Por:</span> 
                        {{ $recipe->user->name }}
                    </p>
                    <p>
                        <i class="fa fa-list-alt"></i>
                        <span class="font-weight-bold">Categoría:</span> 
                        {{ $recipe->category->name }}
                    </p>
                </div>

                <p>
                    <i class="fa fa-tag"></i>
                    <span class="font-weight-bold">Etiquetas:</span>
                    @foreach ($recipe->tags as $tag)
                        <span class="badge bg-green text-white font-weight-normal px-2 py-1">
                            #{{ $tag->name }}
                        </span>
                    @endforeach
                </p>
					
                <hr>

                <p class="lead">
                    {!! $recipe->description !!}
                </p>
                
                <hr>

                <div>
                    <div class="float-lg-left w-lg-50 bg-white p-4 mr-lg-5 rounded-lg shadow-sm">
                        <h4 class="text-green">Ingredientes</h4>
                        <hr>
                        <p>
                            {!! $recipe->ingredients !!}
                        </p>
                    </div>

                    <div class="pt-4">
                        <h4 class="text-green">Preparación</h4>
                        <p>
                            {!! $recipe->preparation !!}
                        </p>
                    </div>
                </div>
            </div>	
            
            <div class="col-lg-4">
                <hr class="d-block d-lg-none">

                <img src="{{ asset($recipe->image) }}" alt="{{ $recipe->title }}'s image"
                    class="img-fluid d-block mx-auto mb-4 rounded-lg" />

                <div class="bg-white p-4 rounded-lg shadow-sm mb-4">
                    <form action="{{ route('page.search') }}">
                        <h4 class="text-green">Búsqueda de recetas</h4>
                        <hr>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="fa fa-search"></i></span>
                            </div>
                            <input type="search" name="title" id="title" class="form-control border-green" placeholder="Buscar receta...">
                        </div>
                    </form>
                </div>

                <div class="bg-white text-green p-4 rounded-lg shadow-sm">
                    <h4>Categorías</h4>
                    <hr>
                    @foreach ($categories as $category)
                        <p>
                            <a href="{{ route('page.showCategory', $category) }}" class="text-dark text-decoration-none">
                                {{ $category->name }} ({{ $category->recipes->count() }})
                            </a>
                        </p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection