@extends('adminlte::page')

@section('title', 'Clientes')

@section('content_header')
    <h1>Clientes</h1>
@stop

@section('content')
    <div class="card shadow">
        <div class="card-header">
            <h3 class="card-title">Lista de clientes</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-success" id="btn_adicionar_cliente">
                    <i class="fas fa-plus"></i> Adicionar Cliente
                </button>
            </div>
        </div>
        <div class="card-body">
            <div class="col-12 mt-3">
                <table class="table table-striped" id="id_tabela_clientes">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>E-mail</th>
                            <th>Telefone</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modal_cadastro_cliente" tabindex="-1" role="dialog"
        aria-labelledby="modal_cadastro_cliente_label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_cadastro_cliente_label">Adicionar cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_modal_cadastro_cliente" class="form-horizontal" method="POST"
                        action="{{ route('clientes.store') }}">
                        @csrf
                        <div class="form-group">
                            <label for="nome">Nome do cliente</label>
                            <input type="text" class="form-control" id="nome" name="nome">
                            <div id="nome_invalido"></div>
                        </div>
                        <div class="form-group">
                            <label for="email">email do cliente</label>
                            <input type="email" class="form-control" id="email" name="email">
                            <div id="email_invalido"></div>
                        </div>
                        <div class="form-group">
                            <label for="telefone">Telefone do cliente</label>
                            <input type="text" class="form-control" id="telefone" name="telefone">
                            <div id="telefone_invalido"></div>
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_editar_cliente" tabindex="-1" role="dialog"
        aria-labelledby="modal_editar_cliente_label" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_editar_cliente_label">Adicionar cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="form_editar_cliente" class="form-horizontal">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="nome">Nome do cliente</label>
                            <input type="text" class="form-control" id="nome" name="nome">
                            <div id="nome_invalido"></div>
                        </div>
                        <div class="form-group">
                            <label for="email">email do cliente</label>
                            <input type="email" class="form-control" id="email" name="email">
                            <div id="email_invalido"></div>
                        </div>
                        <div class="form-group">
                            <label for="telefone">Telefone do cliente</label>
                            <input type="text" class="form-control" id="telefone" name="telefone">
                            <div id="telefone_invalido"></div>
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
            $('#id_tabela_clientes').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('clientes.index') }}",
                columns: [{
                        data: 'nome',
                        name: 'nome'
                    },
                    {
                        data: 'email',
                        name: 'email'
                    },
                    {
                        data: 'telefone',
                        name: 'telefone',
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

            var SPMaskBehavior = function(val) {
                    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
                },
                spOptions = {
                    onKeyPress: function(val, e, field, options) {
                        field.mask(SPMaskBehavior.apply({}, arguments), options);
                    }
                };

            $("input[name='telefone']").mask(SPMaskBehavior, spOptions);
        });

        $(document).on('click', '#btn_adicionar_cliente', function() {
            $('#modal_cadastro_cliente').modal('show');
            $('#form_modal_cadastro_cliente')[0].reset();
        });

        $(document).on('submit', '#form_modal_cadastro_cliente', function(e) {
            e.preventDefault();
            registrarDados($(this), $('#modal_cadastro_cliente'), $('#id_tabela_clientes'));
        });

        $(document).on('click', '.btn-editar', function() {
            let id = $(this).data('id');
            let url = "{{ route('clientes.update', ':id') }}";
            url = url.replace(':id', id);
            let form = $('#form_editar_cliente');
            form.attr('action', url);
            form[0].reset();
            $.get(url, function(data) {
                $.each(data, function(index, value) {
                    form.find('#' + index).val(value);
                });
            });
            $('#modal_editar_cliente').modal('show');
        });

        $(document).on('submit', '#form_editar_cliente', function(e) {
            e.preventDefault();
            registrarDados($(this), $('#modal_editar_cliente'), $('#id_tabela_clientes'));
        });

        $(document).on('click', '.btn-excluir', function() {
            let id = $(this).data('id');
            let url = "{{ route('clientes.destroy', ':id') }}";
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
                            $('#id_tabela_clientes').DataTable().ajax.reload();
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
