@extends('layouts.front.app')

@section('content')
    <div class="album py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <h3 class="mb-4">Recetas con la categoría: <span class="text-green">{{ $category }}</span></h3>
                    @if ($recipes->count() > 0)
                        <div class="row row-cols-1 row-cols-md-2 g-3">
                            @foreach ($recipes as $recipe)
                                <div class="col mb-4">
                                    <div class="card shadow-sm">
                                        <a href="{{ route('recipes.show', $recipe) }}">
                                            <img class="bd-placeholder-img card-img-top" src="{{ asset($recipe->image) }}" />
                                        </a>

                                        <div class="card-body">
                                            <small class="d-block text-muted text-right">{{ $recipe->published_at->diffForHumans() }}</small>
                                            <h5 class="card-title">{{ $recipe->title }}</h5>
                                            <p class="card-text text-truncate">{{ $recipe->excerpt }}</p>
                                            @foreach ($recipe->tags as $tag)
                                                <span class="badge bg-green text-white font-weight-normal p-2">#{{ $tag->name }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert bg-green text-white text-center" role="alert">
                            Al parecer esta categoría aún no cuenta con recetas publicadas, atrévete 
                            a ser el primero en hacerlo, tal vez seas un gran chef!
                        </div>
                    @endif

                    <div class="d-flex justify-content-center">
                        {{ $recipes->links() }}
                    </div>
                </div>
                <div class="col-lg-4">
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
                        @foreach ($categories as $c)
                            <p>
                                <a href="{{ route('page.showCategory', $c) }}" class="text-dark text-decoration-none">
                                    {{ $c->name }} ({{ $c->recipes->count() }})
                                </a>
                            </p>
                        @endforeach
                    </div>
                </div>
            </div> 
        </div>
    </div>
@endsection