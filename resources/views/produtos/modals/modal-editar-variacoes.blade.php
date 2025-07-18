<div class="modal fade" id="modal_editar_variacao" tabindex="-1" role="dialog"
    aria-labelledby="modal_editar_variacao_label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modal_editar_variacao_label">Adicionar Variação</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="form_editar_variacao" class="form-horizontal">
                <div class="modal-body">
                    @csrf
                    @method('put')
                    <div class="form-group">
                        <label for="nome_variacao">Nome variacao do Produto</label>
                        <input type="text" class="form-control" id="nome_variacao" name="nome_variacao">
                        <div id="nome_variacao_invalido"></div>
                    </div>
                    <div class="form-group">
                        <label for="preco_variacao">Preço</label>
                        <input type="number" class="form-control" id="preco_variacao" name="preco_variacao"
                            step="0.01">
                        <div id="preco_variacao_invalido"></div>
                    </div>
                    <div class="form-group">
                        <label for="quantidade_variacao">Estoque</label>
                        <input type="number" class="form-control" id="quantidade_variacao" name="quantidade_variacao"
                            min="0">
                        <div id="quantidade_variacao_invalido"></div>
                    </div>
                    <div class="form-group">
                        <label for="produto_id">Produto</label>
                        <select class="form-control select2" id="produto_id" name="produto_id" style="width: 100%;">
                            <option value="">Selecione um produto</option>
                            @foreach ($produtos as $produto)
                                <option value="{{ $produto->id }}">{{ $produto->nome }}</option>
                            @endforeach
                        </select>
                        <div id="produto_id_invalido" class="invalid-feedback"></div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Salvar</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
            </form>
        </div>
    </div>
</div>
</div>
