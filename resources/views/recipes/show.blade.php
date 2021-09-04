@extends('layouts.front.app')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-lg-8 m-auto">
                <h1 class="text-green">{{ $recipe->title }}</h1>

                <hr>

                <p class="lead text-justify">
                    {{ $recipe->excerpt }}
                </p>

                <hr>

                <div class="d-flex flex-wrap">
                    <p class="mr-4">
                        <i class="fa fa-calendar-alt"></i>
                        <span class="font-weight-bold">Publicado el:</span>
                        {{ $recipe->published_at->formatLocalized('%d de %B del %Y %H:%M') }}
                    </p>
                    <p class="mr-4">
                        <i class="fa fa-user-alt"></i>
                        <span class="font-weight-bold">Autor:</span>
                        {{ $recipe->user->name }}
                    </p>
                    <p class="mr-4">
                        <i class="fa fa-list-alt"></i>
                        <span class="font-weight-bold">Categoría:</span>
                        {{ $recipe->category->name }}
                    </p>
                    <p>
                        <i class="fa fa-tag"></i>
                        <span class="font-weight-bold">Etiquetas:</span>
                        @foreach ($recipe->tags as $tag)
                            <span class="badge bg-green text-white font-weight-normal px-2 py-1">
                                #{{ $tag->name }}
                            </span>
                        @endforeach
                    </p>
                </div>

                <hr>

                <p class="lead">
                    {!! $recipe->description !!}
                </p>

                <hr>

                <img src="{{ asset($recipe->image) }}" alt="{{ $recipe->title }}'s image"
                        class="img-fluid d-block mx-auto rounded-lg" />

                <hr>

                <div class="bg-white p-4 rounded-lg shadow-sm">

                    <h4 class="text-green">Ingredientes</h4>
                    <hr>
                    <p>
                        {!! $recipe->ingredients !!}
                    </p>
                </div>

                <hr>

                <div class="bg-white p-4 rounded-lg shadow-sm">
                    <h4 class="text-green">Preparación</h4>
                    <hr>
                    <p>
                        {!! $recipe->preparation !!}
                    </p>
                </div>

                <hr>

                <div class="d-flex justify-content-center text-center">
                    <livewire:like :recipe="$recipe->id" />
                </div>
            </div>

            <div class="col-lg-4">
                <hr class="d-block d-lg-none">

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
@endsection
