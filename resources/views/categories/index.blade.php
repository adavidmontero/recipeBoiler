<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between">
            <h2 class="h4 font-weight-bold">
                Categories List
            </h2>
            <a href="{{ route('categories.create') }}" class="btn btn-sm btn-dark">New Category</a>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-sm-4">
            <h5 class="font-weight-light">Categorías registradas</h5>
            <p class="text-muted">
                Visualiza la información principal de las categorías registradas en el sistema.
            </p>
        </div>
        <div class="col-sm-8 p-4 bg-white shadow-sm mb-5 rounded-lg">
            <div class="table-responsive table-light">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <th scope="row">{{ $category->id }}</th>
                                <td>{{ $category->name }}</td>
                                <td>{{ $category->slug }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('categories.show', $category) }}" class="mr-2 btn btn-sm btn-primary">View</a>
                                        <a href="{{ route('categories.edit', $category) }}" class="mr-2 btn btn-sm btn-warning">Edit</a>
                                        <form class="d-inline-block" action="{{ route('categories.destroy', $category) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
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