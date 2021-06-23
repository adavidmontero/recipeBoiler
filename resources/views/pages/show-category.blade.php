@extends('layouts.front.app')

@section('content')
    <div class="album py-5">
        <div class="container">
            <h3 class="mb-4">Recetas con la categoría: <span class="text-green">{{ $category }}</span></h3>
            @if ($recipes->count() > 0)
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    @foreach ($recipes as $recipe)
                        <div class="col mb-4">
                            <div class="card shadow-sm">
                                <img class="bd-placeholder-img card-img-top" src="{{ asset($recipe->image) }}" />

                                <div class="card-body">
                                    <h5 class="card-title">{{ $recipe->title }}</h5>
                                    <p class="card-text text-truncate">{{ $recipe->excerpt }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-green text-white font-weight-normal p-2">{{ $recipe->category->name }}</span>
                                        <small class="text-muted">{{ $recipe->published_at->diffForHumans() }}</small>
                                    </div>
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
        </div>
        
        <div class="d-flex justify-content-center">
            {{ $recipes->links() }}
        </div>
    </div>
@endsection