@extends('template')

@section('content')
    <a href="/" class="btn btn-light">Voltar</a>

    <hr>
    
    <form action="{!! route('customers.store') !!}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <div class="custom-file">
                <input type="file" name="csv" class="custom-file-input @error('csv') is-invalid @enderror" id="csv" required>
                <label class="custom-file-label" for="csv">Escolha um arquivo...</label>
                
                @error('csv')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <button type="submit" class="btn btn-success">Enviar</button>
    </form>
@endsection