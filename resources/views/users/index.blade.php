<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between">
            <h2 class="h4 font-weight-bold">
                Users List
            </h2>
            <a href="{{ route('users.create') }}" class="btn btn-sm btn-dark">New User</a>
        </div>
    </x-slot>

    <div class="row">
        <div class="col-sm-4">
            <h5 class="font-weight-light">Usuarios registrados</h5>
            <p class="text-muted">
                Visualiza la información principal de los usuarios registrados en el sistema.
            </p>
        </div>
        <div class="col-sm-8 p-4 bg-white shadow-sm mb-5 rounded-lg">
            <div class="table-responsive table-light">
                <table class="table">
                    <thead class="thead-dark">
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Email Verified At</th>
                            <th scope="col">Roles</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <th scope="row">{{ $user->id }}</th>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->email_verified_at }}</td>
                                <td>
                                    @foreach ($user->roles as $role)
                                        <span class="badge badge-success py-1">
                                            {{ $role->title }}
                                        </span>
                                    @endforeach
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <a href="{{ route('users.show', $user->id) }}" class="mr-2 btn btn-sm btn-primary">View</a>
                                        <a href="{{ route('users.edit', $user->id) }}" class="mr-2 btn btn-sm btn-warning">Edit</a>
                                        <form class="d-inline-block" action="{{ route('users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
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