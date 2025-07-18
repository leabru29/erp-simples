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
            <form id="form_produto" class="form-horizontal" method="POST" action="{{ route('produtos.store') }}">
                <div class="modal-body">
                    @csrf

                    <!-- Nome do produto -->
                    <div class="form-group">
                        <label for="nome">Nome do Produto</label>
                        <input type="text" class="form-control" id="nome" name="nome">
                        <div id="nome_invalido"></div>
                    </div>

                    <!-- Preço do produto -->
                    <div class="form-group">
                        <label for="preco">Preço</label>
                        <input type="number" class="form-control" id="preco" name="preco" step="0.01">
                        <div id="preco_invalido"></div>
                    </div>

                    <!-- Estoque (caso não tenha variações) -->
                    <div class="form-group">
                        <label for="quantidade_estoque_produto">Estoque</label>
                        <input type="number" class="form-control" id="quantidade_estoque_produto"
                            name="quantidade_estoque_produto" min="0">
                    </div>
                </div>
                <div class="modal-footer">
                    <!-- Botões -->
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </form>
        </div>
    </div>
</div>
</div>
