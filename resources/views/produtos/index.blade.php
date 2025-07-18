@extends('adminlte::page')

@section('title', 'Produtos')

@section('content_header')
    <h1>Produtos</h1>
@stop

@section('content')
    <div class="card shadow">
        <div class="card-header">
            <h3 class="card-title">Gerenciar Produtos</h3>
            <div class="card-tools">
                <button type="button" class="btn btn-success shadow my-2" id="btn_adicionar_produto">
                    <i class="fas fa-plus"></i> Adicionar Produto
                </button>

                <button type="button" class="btn btn-primary shadow" id="btn_adicionar_variacao">
                    <i class="fas fa-plus"></i> Adicionar Variação
                </button>
            </div>
        </div>

        <div class="card-body">
            <ul class="nav nav-tabs" id="produtoTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="produtos-tab" data-toggle="tab" href="#produtos" role="tab"
                        aria-controls="produtos" aria-selected="true">Produtos</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="variacoes-tab" data-toggle="tab" href="#variacoes" role="tab"
                        aria-controls="variacoes" aria-selected="false">Variações</a>
                </li>
            </ul>
            <div class="tab-content" id="produtoTabsContent">
                <div class="tab-pane fade show active pt-3" id="produtos" role="tabpanel" aria-labelledby="produtos-tab">
                    <table class="table table-striped" id="id_tabela_produtos">
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>Preço</th>
                                <th>Estoque</th>
                                <th>Variações</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <div class="tab-pane fade pt-3" id="variacoes" role="tabpanel" aria-labelledby="variacoes-tab">
                    <table class="table table-striped" id="id_tabela_variacoes" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Produto</th>
                                <th>Nome da Variação</th>
                                <th>Preço</th>
                                <th>Estoque</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalCarrinho" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formAddCarrinho">
                    <div class="modal-header">
                        <h5 class="modal-title">Adicionar ao Carrinho</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" id="produto_id" name="produto_id">

                        <div class="mb-3">
                            <label>Produto</label>
                            <input type="text" id="produto_nome" class="form-control" readonly>
                        </div>

                        <div class="mb-3">
                            <label>Quantidade</label>
                            <input type="number" name="quantidade_carrinho_produto" class="form-control" min="1"
                                value="1">
                        </div>

                        <!-- Variações se houver -->
                        <div id="opcoes_variacoes"></div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Adicionar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    @include('produtos/modals/modal-adicionar-produto')
    @include('produtos/modals/modal-editar-produto')
    @include('produtos/modals/modal-adicionar-variacao')
    @include('produtos/modals/modal-editar-variacoes')
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
                language: {
                    url: "{{ asset('js/datatables/pt_br.json') }}"
                },
                columns: [{
                        data: 'nome',
                        name: 'nome'
                    },
                    {
                        data: 'preco',
                        name: 'preco'
                    },
                    {
                        data: 'estoque',
                        name: 'estoque'
                    },
                    {
                        data: 'variacoes',
                        name: 'variacoes',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            if (!data) return '';
                            if (typeof data === 'string') {
                                try {
                                    data = JSON.parse(data);
                                } catch (e) {
                                    console.error('Erro ao fazer JSON.parse em variacoes:', e);
                                    return '';
                                }
                            }

                            if (!Array.isArray(data)) return '';
                            return data.map(function(v) {
                                return `${v.nome} - R$ ${parseFloat(v.preco).toFixed(2)} (${v.estoque} un.)`;
                            }).join('<br>');
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row, meta) {
                            let id = data;

                            return `
                                    <button class="btn btn-sm btn-warning btn-comprar-produto" data-id="${id}" title="Comprar">
                                        <i class="fas fa-cart-plus"></i>
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

            $('#id_tabela_variacoes').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('variacoes.index') }}",
                language: {
                    url: "{{ asset('js/datatables/pt_br.json') }}"
                },
                columns: [{
                        data: 'produto',
                        name: 'produto'
                    },
                    {
                        data: 'nome_variacao',
                        name: 'nome_variacao'
                    },
                    {
                        data: 'preco_variacao',
                        name: 'preco_variacao'
                    },
                    {
                        data: 'quantidade_variacao',
                        name: 'quantidade_variacao',
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
                                    <button class="btn btn-sm btn-success btn-visualizar-variacao" data-id="${id}" title="Visualizar">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    <button class="btn btn-sm btn-primary btn-editar-variacao" data-id="${id}" title="Editar">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger btn-excluir-variacao" data-id="${id}" title="Excluir">
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


        $(document).on('click', '#btn_adicionar_variacao', function() {
            $('#modal_variacao').modal('show');
            $('#form_variacao')[0].reset();
        });

        $(document).on('submit', '#form_variacao', function(e) {
            e.preventDefault();
            registrarDados($(this), $('#modal_variacao'), $('#id_tabela_variacoes'));
            $('#id_tabela_produtos').DataTable().ajax.reload();
        });

        $(document).on('click', '.btn-editar-variacao', function() {
            let id = $(this).data('id');
            let url = "{{ route('variacoes.update', ':id') }}";
            url = url.replace(':id', id);
            let form = $('#form_editar_variacao');
            form.attr('action', url);
            form[0].reset();
            $.get(url, function(data) {
                $.each(data, function(index, value) {
                    form.find('#' + index).val(value);
                });
            });
            $('#modal_editar_variacao').modal('show');
        });

        $(document).on('submit', '#form_editar_variacao', function(e) {
            e.preventDefault();
            registrarDados($(this), $('#modal_editar_variacao'), $('#id_tabela_variacoes'));
            $('#id_tabela_produtos').DataTable().ajax.reload();
        });

        $(document).on('click', '.btn-excluir-variacao', function() {
            let id = $(this).data('id');
            let url = "{{ route('variacoes.destroy', ':id') }}";
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
                            $('#id_tabela_variacoes').DataTable().ajax.reload();
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

        $(document).on('click', '.btn-comprar-produto', function() {
            const id = $(this).data('id');
            const form = $('#formAddCarrinho');
            $.get(`api/produtos/${id}`, function(res) {
                $(form).find('#produto_id').val(res.id);
                $(form).find('#produto_nome').val(res.nome);
                $(form).find('#quantidade_carrinho_produto').attr('max', res.estoque
                    .quantidade_estoque_produto);
                let html = '';
                if (res.variacoes && res.variacoes.length > 0) {
                    html += `<label>Variações</label><select name="variacao_id" class="form-control">`;
                    res.variacoes.forEach(v => {
                        html +=
                            `<option value="${v.id}">${v.nome_variacao} - R$ ${parseFloat(v.preco_variacao).toFixed(2)} - Estoque: ${v.quantidade_variacao}</option>`;
                    });
                    html += `</select>`;
                } else {
                    html = '<div class="text-muted">Este produto não possui variações.</div>';
                }
                $(form).find('#opcoes_variacoes').html(html);
            });

            $('#modalCarrinho').modal('show');
        });

        $(document).on('submit', '#formAddCarrinho', function(e) {
            e.preventDefault();

            let formData = {
                produto_id: $('#produto_id').val(),
                quantidade: $('input[name="quantidade_carrinho_produto"]').val(),
                variacao_id: $('input[name="variacao_id"]:checked').val() || null, // se houver variações
            };

            $.ajax({
                url: '/api/carrinho/adicionar',
                method: 'POST',
                data: formData,
                success: function(res) {
                    Swal.fire('Sucesso', res.message, 'success');
                    $('#modalCarrinho').modal('hide');
                    // Atualizar visual do carrinho, se desejar
                },
                error: function(xhr) {
                    let errors = xhr.responseJSON?.errors || {};
                    let errorMsg = Object.values(errors).join('<br>');
                    Swal.fire('Erro', errorMsg || 'Erro ao adicionar ao carrinho.', 'error');
                }
            });
        });
    </script>
@stop
