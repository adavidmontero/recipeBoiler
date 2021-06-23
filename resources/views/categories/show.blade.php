<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            Category Information
        </h2>
    </x-slot>

    <div class="row">
        <div class="col-sm-4">
            <h5 class="font-weight-light">Detalles de la categoría</h5>
            <p class="text-muted">
                Visualiza toda la información de esta categoría.
            </p>
        </div>
        <div class="col-sm-8 p-4 bg-white shadow-sm mb-5 rounded-lg">
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Nombre: </strong>{{ $category->name }}</li>
                <li class="list-group-item"><strong>Slug: </strong>{{ $category->slug }}</li>
            </ul>
        </div>
    </div>

</x-app-layout>