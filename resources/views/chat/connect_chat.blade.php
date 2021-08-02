@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('chat.with') }}" method="GET">
                        @csrf
                        <div class="form-group">
                            <label for="id">Ingresa el id de la persona</label>
                            <input type="number" class="form-control" name="user" id="id" placeholder="id">
                        </div>
                        <button type="submit" class="btn btn-primary mt-1">Buscar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')

@endsection
