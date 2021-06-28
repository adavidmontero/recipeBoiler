@extends('layouts.front.app')

@section('hero')
    @include('layouts.front.hero')
@endsection

@section('content')
    <div class="album py-5">
        <div class="container">
            <h3 class="py-2">Recetas recientes</h3>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                @foreach ($recents as $recent)
                    <div class="col mb-4">
                        <div class="card shadow-sm">
                            <a href="{{ route('recipes.show', $recent) }}">
                                <img class="bd-placeholder-img card-img-top" src="{{ $recent->image }}" />
                            </a>

                            <div class="card-body">
                                <small class="d-block text-muted text-right">{{ $recent->published_at->diffForHumans() }}</small>
                                <h5 class="card-title">{{ $recent->title }}</h5>
                                <p class="card-text text-truncate">{{ $recent->excerpt }}</p>
                                @foreach ($recent->tags as $tag)
                                    <span class="badge bg-green text-white font-weight-normal p-2">#{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <hr>

            <h3 class="py-2">Recetas populares</h3>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                @foreach ($populars as $popular)
                    <div class="col mb-4">
                        <div class="card shadow-sm">
                            <a href="{{ route('recipes.show', $popular) }}">
                                <img class="bd-placeholder-img card-img-top" src="{{ $popular->image }}" />
                            </a>

                            <div class="card-body">
                                <small class="d-block text-muted text-right">{{ $popular->published_at->diffForHumans() }}</small>
                                <h5 class="card-title">{{ $popular->title }}</h5>
                                <p class="card-text text-truncate">{{ $popular->excerpt }}</p>
                                @foreach ($popular->tags as $tag)
                                    <span class="badge bg-green text-white font-weight-normal p-2">#{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <hr>

            @foreach ($recipesByCat as $category)
                <div class="d-flex justify-content-between align-items-center">
                    <h3 class="py-2">{{ $category->name }}</h3>
                    <a class="btn bg-green text-white" href="{{ route('page.showCategory', $category) }}" role="button">Ver todos</a>
                </div>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                    @foreach ($category->recipes as $rc)
                        <div class="col mb-4">
                            <div class="card shadow-sm">
                                <a href="{{ route('recipes.show', $rc) }}">
                                    <img class="bd-placeholder-img card-img-top" src="{{ $rc->image }}" />
                                </a>

                                <div class="card-body">
                                    <small class="d-block text-muted text-right">{{ $rc->published_at->diffForHumans() }}</small>
                                    <h5 class="card-title">{{ $rc->title }}</h5>
                                    <p class="card-text text-truncate">{{ $rc->excerpt }}</p>
                                    @foreach ($rc->tags as $tag)
                                        <span class="badge bg-green text-white font-weight-normal p-2">#{{ $tag->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <hr>
            @endforeach
        </div>
    </div>
@endsection