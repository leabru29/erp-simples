@extends('adminlte::page')

@section('title', 'Carrinho de Compras')

@section('content_header')
    <h1>Carrinho de Compras</h1>
@stop

@section('content')
    <div class="card">
        <div class="card-body table-responsive">
            @if (session('carrinho') && count(session('carrinho')) > 0)
                <form id="formAtualizarCarrinho" method="POST" action="{{ route('carrinho.atualizar') }}">
                    @csrf
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Preço</th>
                                <th>Quantidade</th>
                                <th>Total</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $subtotal = 0; @endphp
                            @foreach (session('carrinho') as $key => $item)
                                @php $totalItem = $item['preco'] * $item['quantidade']; @endphp
                                @php $subtotal += $totalItem; @endphp
                                <tr>
                                    <td>{{ $item['nome'] }}</td>
                                    <td>R$ {{ number_format($item['preco'], 2, ',', '.') }}</td>
                                    <td>
                                        <input type="number" name="quantidades[{{ $key }}]" class="form-control"
                                            min="1" value="{{ $item['quantidade'] }}">
                                    </td>
                                    <td>R$ {{ number_format($totalItem, 2, ',', '.') }}</td>
                                    <td>
                                        <form action="{{ route('carrinho.remover', $key) }}" method="POST"
                                            style="display:inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('Remover produto?')">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" name="cupom" class="form-control" placeholder="Cupom de desconto">
                                <button type="submit" formaction="{{ route('carrinho.aplicar-cupom') }}"
                                    class="btn btn-outline-secondary">Aplicar</button>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <p><strong>Subtotal:</strong> R$ {{ number_format($subtotal, 2, ',', '.') }}</p>
                            <p><strong>Desconto:</strong> R$ {{ number_format(session('desconto', 0), 2, ',', '.') }}</p>
                            <p><strong>Frete:</strong> R$ {{ number_format(session('frete', 0), 2, ',', '.') }}</p>
                            <h4><strong>Total:</strong> R$
                                {{ number_format($subtotal - session('desconto', 0) + session('frete', 0), 2, ',', '.') }}
                            </h4>
                            <button type="submit" formaction="{{ route('carrinho.finalizar') }}"
                                class="btn btn-success mt-2">
                                Finalizar Compra
                            </button>
                        </div>
                    </div>
                </form>
            @else
                <div class="alert alert-info">
                    Seu carrinho está vazio.
                </div>
            @endif
        </div>
    </div>
@stop
