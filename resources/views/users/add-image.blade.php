@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if (session('save'))
                    <div class="alert alert-success" role="alert">
                        <strong>Guardado</strong>
                        <img src="{{ asset('/storage/'.session('image')) }}" class="img-fluid" alt="perfil">
                    </div>
                    @endif
                    <form action="{{ route('update.image') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="image">Imagen de perfil</label>
                            <input type="file" class="form-control-file" name="image" id="image" placeholder="imagen" aria-describedby="image" accept="image/*">
                            <small id="imageS" class="form-text text-muted">Selecciona una imagen</small>
                        </div>
                        <button type="submit" class="btn btn-primary mt-1">Cargar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
