@extends('layouts.front.app')

@section('hero')
    @include('layouts.front.hero')
@endsection

@section('content')
    <div class="album py-5">
        <div class="container">
            <h3 class="mb-4">Resultados de la búsqueda: <span class="text-green">{{ $results->count() }}</span> {{-- <span class="text-green">{{ $category }} --}}</span></h3>
            @if ($results->count() > 0)
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                    @foreach ($results as $result)
                        <div class="col mb-4">
                            <div class="card shadow-sm">
                                <a href="{{ route('recipes.show', $result) }}">
                                    <img class="bd-placeholder-img card-img-top" src="{{ asset($result->image) }}" />
                                </a>

                                <div class="card-body">
                                    <small class="d-block text-muted text-right">{{ $result->published_at->diffForHumans() }}</small>
                                    <h5 class="card-title">{{ $result->title }}</h5>
                                    <p class="card-text text-truncate">{{ $result->excerpt }}</p>
                                    @foreach ($result->tags as $tag)
                                        <span class="badge bg-green text-white font-weight-normal p-2">#{{ $tag->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert bg-green text-white text-center" role="alert">
                    Al parecer no hay resultados, inténtelo de otra forma, probablemente tenga 
                    suerte!
                </div>
            @endif
        </div>
        
        <div class="d-flex justify-content-center">
            {{ $results->links() }}
        </div>
    </div>
@endsection