@extends('layouts.front.app')

@section('content')
    <div class="album py-5">
        <div class="container">
            <h3 class="mb-4">Resultados de la búsqueda: {{-- <span class="text-green">{{ $category }} --}}</span></h3>
            @if ($results->count() > 0)
                <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 g-3">
                    @foreach ($results as $result)
                        <div class="col mb-4">
                            <div class="card shadow-sm">
                                <img class="bd-placeholder-img card-img-top" src="{{ asset($result->image) }}" />

                                <div class="card-body">
                                    <h5 class="card-title">{{ $result->title }}</h5>
                                    <p class="card-text text-truncate">{{ $result->excerpt }}</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="badge bg-green text-white font-weight-normal p-2">{{ $result->category->name }}</span>
                                        <small class="text-muted">{{ $result->published_at->diffForHumans() }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="alert bg-green text-white text-center" role="alert">
                    Al parecer no hay resultados, inténtelo de otra forma, seguro tendrá suerte!
                </div>
            @endif
        </div>
        
        <div class="d-flex justify-content-center">
            {{ $results->links() }}
        </div>
    </div>
@endsection