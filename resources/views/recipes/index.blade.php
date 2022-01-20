<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between">
            <h2 class="h4 font-weight-bold">
                Recipes List
            </h2>
            <a href="{{ route('recipes.create') }}" class="btn btn-sm btn-dark">New Recipe</a>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-sm-4">
            <h5 class="font-weight-light">Recetas registradas</h5>
            <p class="text-muted">
                Visualiza la información principal de los recetas registradas en el sistema.
            </p>
        </div>
        <div class="col-sm-8 p-4 bg-white shadow-sm mb-5 rounded-lg">
            <div class="table-responsive table-light">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Título</th>
                            {{-- <th scope="col">Descripción</th> --}}
                            <th scope="col">Categoría</th>
                            <th scope="col">Etiquetas</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recipes as $recipe)
                            <tr>
                                <th scope="row">{{ $recipe->id }}</th>
                                <td>{{ $recipe->title }}</td>
                                {{-- <td><img src="{{ $recipe->image }}" /></td> --}}
                                <td>{{ $recipe->category->name }}</td>
                                <td>{{ $recipe->tags->pluck('name')->implode(', ') }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('recipes.show', $recipe) }}" class="mr-2 btn btn-sm btn-primary">View</a>
                                        <a href="{{ route('recipes.edit', $recipe) }}" class="mr-2 btn btn-sm btn-warning">Edit</a>
                                        <form class="d-inline-block" action="{{ route('recipes.destroy', $recipe) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                            @method('DELETE')
                                            @csrf
                                            <input type="submit" class="btn btn-sm btn-danger" value="Delete">
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</x-app-layout>
