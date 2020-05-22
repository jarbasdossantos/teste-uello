@extends('template')

@section('content')
    <a href="{!! route('customers.create') !!}" class="btn btn-primary">Importar</a>
    
    @if ($customers->count())
        <a href="{!! route('customers.export') !!}" target="__blank" class="btn btn-light">Exportar</a>
        &nbsp;
        
        <a href="{!! route('customers.index') !!}" class="btn btn-light">Ver Rotas Otimizadas</a>
    @endif

    <hr>

    @if (!$customers->count())
        <div class="text-center">
            <div class="alert alert-warning">Não existem dados. Importe para visualizar aqui.</div>
        </div>
    @else
        <table class="table table-bordered table-striped table-responsive">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>Nascimento</th>
                    <th>CPF</th>
                    <th>Endereço</th>
                    <th>CEP</th>
                </tr>
            </thead>
            
            <tbody>
                @foreach ($customers as $customer)
                    <tr>
                        <td nowrap>{{ $customer->name }}</td>
                        <td nowrap>{{ $customer->email }}</td>
                        <td nowrap>{{ $customer->birth_date }}</td>
                        <td nowrap>{{ $customer->cpf }}</td>
                        <td nowrap>{{ $customer->address }}, {{ $customer->number }}</td>
                        <td nowrap>{{ $customer->zip_code }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection