@extends('template')

@section('content')
<a href="/" class="btn btn-light">Voltar</a>

<hr>

<p>Dados na ordem de melhor rota para as entregas.</p>

<table class="table table-bordered table-striped table-responsive">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Endereço</th>
            <th>CEP</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($customers as $customer)
        <tr>
            <td nowrap>{{ $customer->name }}</td>
            <td nowrap>{{ $customer->address }}, {{ $customer->number }} - {{ $customer->neighborhood }}</td>
            <td nowrap>{{ $customer->zip_code }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection