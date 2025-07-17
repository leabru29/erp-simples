@extends('adminlte::page')

@section('title', 'Produtos')

@section('content_header')
    <h1>Produtos</h1>
@stop

@section('content')
    <div class="card shadow">
        <div class="card-header">
            <h3 class="card-title">Lista de Produtos</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-success" id="btn_adicionar_produto">
                    <i class="fas fa-plus"></i> Adicionar Produto
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="col-12 mt-3">
                <table class="table table-striped" id="id_tabela_produtos">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Preço</th>
                            <th>Variações</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal_produto" tabindex="-1" role="dialog" aria-labelledby="modal_produto_label"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_produto_label">Adicionar Produto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_produto" class="form-horizontal" method="POST" action="{{ route('produtos.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="nome">Nome do Produto</label>
                            <input type="text" class="form-control" id="nome" name="nome">
                            <div id="nome_invalido"></div>
                        </div>
                        <div class="form-group">
                            <label for="preco">Preço</label>
                            <input type="number" class="form-control" id="preco" name="preco" step="0.01">
                            <div id="preco_invalido"></div>
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_editar_produto" tabindex="-1" role="dialog" aria-labelledby="modal_produto_label"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_produto_label">Adicionar Produto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_editar_produto" class="form-horizontal">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="nome">Nome do Produto</label>
                            <input type="text" class="form-control" id="nome" name="nome">
                            <div id="nome_invalido"></div>
                        </div>
                        <div class="form-group">
                            <label for="preco">Preço</label>
                            <input type="number" class="form-control" id="preco" name="preco" step="0.01">
                            <div id="preco_invalido"></div>
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@stop

@section('css')
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#id_tabela_produtos').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('produtos.index') }}",
                columns: [{
                        data: 'nome',
                        name: 'nome'
                    },
                    {
                        data: 'preco',
                        name: 'preco'
                    },
                    {
                        data: 'variacoes',
                        name: 'variacoes',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            let id = data;

                            return `
                                    <button class="btn btn-sm btn-success btn-visualizar" data-id="${id}" title="Visualizar">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-primary btn-editar" data-id="${id}" title="Editar">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger btn-excluir" data-id="${id}" title="Excluir">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                `;

                        }
                    }
                ]
            });
        });

        $(document).on('click', '#btn_adicionar_produto', function() {
            $('#modal_produto').modal('show');
            $('#form_produto')[0].reset();
        });

        $(document).on('submit', '#form_produto', function(e) {
            e.preventDefault();
            registrarDados($(this), $('#modal_produto'), $('#id_tabela_produtos'));
        });

        $(document).on('click', '.btn-editar', function() {
            let id = $(this).data('id');
            let url = "{{ route('produtos.update', ':id') }}";
            url = url.replace(':id', id);
            let form = $('#form_editar_produto');
            form.attr('action', url);
            form[0].reset();
            $.get(url, function(data) {
                $.each(data, function(index, value) {
                    form.find('#' + index).val(value);
                });
            });
            $('#modal_editar_produto').modal('show');
        });

        $(document).on('submit', '#form_editar_produto', function(e) {
            e.preventDefault();
            registrarDados($(this), $('#modal_editar_produto'), $('#id_tabela_produtos'));
        });

        $(document).on('click', '.btn-excluir', function() {
            let id = $(this).data('id');
            let url = "{{ route('produtos.destroy', ':id') }}";
            url = url.replace(':id', id);
            Swal.fire({
                title: 'Tem certeza?',
                text: "Você não poderá reverter isso!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, excluir!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        success: function(response) {
                            Swal.fire(
                                'Excluído!',
                                'O produto foi excluído com sucesso.',
                                'success'
                            );
                            $('#id_tabela_produtos').DataTable().ajax.reload();
                        },
                        error: function(xhr) {
                            Swal.fire(
                                'Erro!',
                                'Ocorreu um erro ao excluir o produto.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    </script>
@stop
