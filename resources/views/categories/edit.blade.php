<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            Category Form
        </h2>
    </x-slot>

    <div class="row">
        <div class="col-sm-4">
            <h5 class="font-weight-light">Nueva Categoría</h5>
            <p class="text-muted">
                Modifica los datos para la actualización de esta categoría.
            </p>
        </div>
        <div class="col-sm-8 p-4 bg-white shadow-sm mb-5 rounded-lg">
            <form method="POST" action="{{ route('categories.update', $category) }}">
                @csrf
                @method('PUT')

                <div class="w-md-75">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $category->name) }}">
                        @error('name')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                </div>
                <button type="submit" class="btn btn-dark float-right">Save</button>
            </form>
        </div>
    </div>

</x-app-layout>