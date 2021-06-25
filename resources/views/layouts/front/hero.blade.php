<div class="container col-xxl-8 px-4 py-2 rounded mt-lg-5 bg-white shadow">
    <form action="{{ route('page.search') }}">
        <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
            <div class="col-10 col-sm-8 col-lg-6 mx-auto mb-4 mb-lg-0">
                <img src="{{ asset('./images/hamburger.jpg') }}" class="d-block img-fluid rounded" alt="Bootstrap Themes" loading="lazy">
            </div>
            <div class="col-lg-6">
                <h1 class="display-5 fw-bold lh-1 mb-3 text-center">Encuentra tu receta favorita</h1>
                <p class="lead text-justify">
                    En Recipe Boiler contamos con una gran variedad de recetas para todos los 
                    gustos, a las que podrás acceder de manera fácil, rápida y clara. 
                    Sorprende a tu familia, amigos e invitados con uno de nuestros platos, 
                    de seguro quedarán satisfechos.
                </p>
                <div class="form-group">
                    <select name="category" class="form-control border-green w-75 mx-auto">
                        <option value="">-- Seleccione una categoría, si lo desea --</option>
                        @foreach ($categories as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <input type="search" name="title" id="title" class="form-control w-75 border-green mx-auto">
                    @error('title')
                        <span class="d-block text-danger text-center">
                            {{ $message }}
                        </span>
                    @enderror
                </div>
            </div>
        </div>
    </form>
</div>