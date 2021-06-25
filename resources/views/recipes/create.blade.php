<x-app-layout>
    <x-slot name="header">
        <h2 class="h4 font-weight-bold">
            Recipe Form
        </h2>
    </x-slot>

    <div class="row">
        <div class="col-sm-4">
            <h5 class="font-weight-light">Nueva Receta</h5>
            <p class="text-muted">
                Ingresa los datos requeridos para la creación de un nueva receta.
            </p>
        </div>
        <div class="col-sm-8 p-4 bg-white shadow-sm mb-5 rounded-lg">
            <form method="POST" action="{{ route('recipes.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="w-md-75">
                    <div class="mb-3">
                        <label for="published-at" class="form-label">Fecha de Publicación</label>
                        <div class="input-group date" id="datetimepicker1" data-target-input="nearest">
                            <input type="text" class="form-control datetimepicker-input" id="published-at" name="published_at" data-target="#datetimepicker1"/>
                            <div class="input-group-append" data-target="#datetimepicker1" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Categoría</label>
                        <select class="form-control form-select {{ $errors->has('category') ? 'is-invalid' : '' }}" id="category" name="category" aria-label="select">
                            <option disabled selected>-- Selecciona la categoría --</option>
                            @foreach ($categories as $id => $item)
                                <option value="{{ $id }}" {{ old('category') == $id ? 'selected' : '' }}>
                                    {{ $item }}
                                </option>
                            @endforeach
                        </select>
                        @error('category')    
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="title" class="form-label">Título</label>
                        <input type="text" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" id="title" name="title" value="{{ old('title') }}">
                        @error('title')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="image" class="form-label">Imagen</label>
                        <input type="file" class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}" id="image" name="image" value="{{ old('image') }}">
                        @error('image')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tags" class="form-label">Etiquetas</label>
                        <select name="tags[]" class="select2 form-control {{ $errors->has('tags') ? 'is-invalid' : '' }}" 
                            multiple="multiple" data-placeholder="--Selecciona las etiquetas--" style="width: 100%;">
                            @foreach ($tags as $tag)
                                <option value="{{ $tag->id }}">{{ $tag->name }}</option>
                            @endforeach
                        </select>
                        @error('tags')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="excerpt" class="form-label">Extracto</label>
                        <textarea class="form-control {{ $errors->has('excerpt') ? 'is-invalid' : '' }}" 
                            id="excerpt" name="excerpt" rows="3">{{ old('excerpt') }}</textarea>
                        @error('excerpt')
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Cuerpo</label>
                        <textarea id="description" name="description" class="form-control 
                            {{ $errors->has('description') ? 'is-invalid' : '' }}">{{ old('description') }}</textarea>
                        @error('description')    
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="ingredients" class="form-label">Ingredientes</label>
                        <textarea id="ingredients" name="ingredients" class="form-control 
                            {{ $errors->has('ingredients') ? 'is-invalid' : '' }}">{{ old('ingredients') }}</textarea>
                        @error('ingredients')    
                            <span class="text-danger">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="preparation" class="form-label">Preparación</label>
                        <textarea id="preparation" name="preparation" class="form-control 
                            {{ $errors->has('preparation') ? 'is-invalid' : '' }}">{{ old('preparation') }}</textarea>
                        @error('preparation')    
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

    @push('css')
        <link href="http://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet" />
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css" integrity="sha512-3JRrEUwaCkFUBLK1N8HehwQgu8e23jTH4np5NHOmQOobuC4ROQxFwFgBLTnhcnQRMs84muMh0PnnwXlPq5MGjg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @endpush

    @push('js')
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/js/all.min.js" defer></script>
        <script src="http://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js" defer></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js" integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ==" crossorigin="anonymous" referrerpolicy="no-referrer" defer></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/js/tempusdominus-bootstrap-4.min.js" integrity="sha512-k6/Bkb8Fxf/c1Tkyl39yJwcOZ1P4cRrJu77p83zJjN2Z55prbFHxPs9vN7q3l3+tSMGPDdoH51AEU8Vgo1cgAA==" crossorigin="anonymous" referrerpolicy="no-referrer" defer></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#datetimepicker1').datetimepicker({
                    minDate:new Date()
                });

                //Asignamos altura a los editores de summernote
                $('#description').summernote({
                    height: 300,
                    toolbar: [
                        [ 'style', [ 'style' ] ],
                        [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
                        [ 'fontname', [ 'fontname' ] ],
                        [ 'fontsize', [ 'fontsize' ] ],
                        [ 'color', [ 'color' ] ],
                        [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
                        [ 'table', [ 'table' ] ],
                        [ 'insert', [ 'link', 'picture'] ],
                        [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
                    ]
                });
                $('#ingredients').summernote({
                    height: 300,
                    toolbar: [
                        [ 'style', [ 'style' ] ],
                        [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
                        [ 'fontname', [ 'fontname' ] ],
                        [ 'fontsize', [ 'fontsize' ] ],
                        [ 'color', [ 'color' ] ],
                        [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
                        [ 'table', [ 'table' ] ],
                        [ 'insert', [ 'link' ] ],
                        [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
                    ]
                });
                $('#preparation').summernote({
                    height: 300,
                    toolbar: [
                        [ 'style', [ 'style' ] ],
                        [ 'font', [ 'bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear'] ],
                        [ 'fontname', [ 'fontname' ] ],
                        [ 'fontsize', [ 'fontsize' ] ],
                        [ 'color', [ 'color' ] ],
                        [ 'para', [ 'ol', 'ul', 'paragraph', 'height' ] ],
                        [ 'table', [ 'table' ] ],
                        [ 'insert', [ 'link', 'picture'] ],
                        [ 'view', [ 'undo', 'redo', 'fullscreen', 'codeview', 'help' ] ]
                    ]
                });

                //Initialize Select2 Elements
                $('.select2').select2({
                    tags: true,
                    maximumSelectionLength: 3
                });

                //Initialize Select2 Elements
                $('.select2bs4').select2({
                    theme: 'bootstrap4',
                });
            });
        </script>
    @endpush

</x-app-layout>


