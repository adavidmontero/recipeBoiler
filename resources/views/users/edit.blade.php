<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            User Edit Form
        </h2>
    </x-slot>

    <div class="row">
        <div class="col-sm-4">
            <h5 class="font-weight-light">Edición de Usuario</h5>
            <p class="text-muted">
                Modifica los datos para la actualización de este usuario.
            </p>
        </div>
        <div class="col-sm-8 p-4 bg-white shadow-sm mb-5 rounded-lg">
            <form method="POST" action="{{ route('users.update', $user) }}">
                @csrf
                @method('PUT')

                <div class="w-md-75">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}">
                        @error('name')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
                        @error('email')    
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password">
                        @error('password')    
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="roles" class="form-label">Roles</label>
                        <select class="form-control form-select" id="roles" name="roles[]" multiple aria-label="multiple select">
                            <option disabled>-- Selecciona los roles --</option>
                            @foreach ($roles as $id => $item)
                                <option  value="{{ $id }}" {{ in_array($id, old('roles', $user->roles->pluck('id')->toArray())) ? ' selected' : '' }}>
                                    {{ $item }}
                                </option>
                            @endforeach
                        </select>
                        @error('roles')    
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