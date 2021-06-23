@extends('layouts.front.app')

@section('content')
    <div class="album py-5">
        <div class="container">
            <h3 class="py-2">Recetas recientes</h3>
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                @foreach ($recents as $recent)
                    <div class="col mb-4">
                        <div class="card shadow-sm">
                            <img class="bd-placeholder-img card-img-top" src="{{ $recent->image }}" />

                            <div class="card-body">
                                <h5 class="card-title">{{ $recent->title }}</h5>
                                <p class="card-text text-truncate">{{ $recent->excerpt }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="badge bg-green text-white font-weight-normal p-2">{{ $recent->category->name }}</span>
                                    <small class="text-muted">{{ $recent->published_at->diffForHumans() }}</small>
                                </div>
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
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    @foreach ($category->recipes as $rc)
                        <div class="col mb-4">
                            <div class="card shadow-sm">
                                <img class="bd-placeholder-img card-img-top" src="{{ $rc->image }}" />

                                <div class="card-body">
                                    <h5 class="card-title">{{ $rc->title }}</h5>
                                    <p class="card-text text-truncate">{{ $rc->excerpt }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-green text-white font-weight-normal p-2">{{ $rc->category->name }}</span>
                                        <small class="text-muted">{{ $rc->published_at->diffForHumans() }}</small>
                                    </div>
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