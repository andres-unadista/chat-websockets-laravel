@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-body">
                            <form id="formUser">
                                <div class="form-group">
                                    <label for="id">Ingresa el id de la persona</label>
                                    <input type="number" class="form-control" name="user" id="idUser" placeholder="id">
                                </div>
                                <button type="submit" class="btn btn-primary mt-1">Buscar</button>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script>
        $formUser = document.getElementById('formUser');
        $idUser = document.getElementById('idUser');

        $formUser.addEventListener('submit', function(e){
            e.preventDefault();
            window.location = '/chat/with/'+ $idUser.value;
        });
    </script>
@endsection
