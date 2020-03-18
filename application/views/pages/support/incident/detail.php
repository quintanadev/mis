<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="header-title"><i class="fe-flag"></i> INCIDENTE N° #<?= $incident['IDTicket']; ?></h4>
                <p class="sub-header"></p>
                <form>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="col-form-label">Aberto Por</label>
                            <input type="text" class="form-control" readonly value="<?= $incident['UsuarioCadastro']; ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-form-label">Data Abertura</label>
                            <input type="text" class="form-control" readonly value="<?= $incident['DataCadastro'] . ' ' . $incident['HoraCadastro']; ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="col-form-label">Email</label>
                            <input type="text" class="form-control" readonly value="<?= $incident['UsuarioEmail']; ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-form-label">Operação</label>
                            <input type="text" class="form-control" readonly value="<?= $incident['Operacao']; ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="col-form-label">Tipo de Solicitação</label>
                            <input type="text" class="form-control" readonly value="<?= $incident['TipoSolicitacao']; ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-form-label">Solicitação</label>
                            <input type="text" class="form-control" readonly value="<?= $incident['Solicitacao']; ?>">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label class="col-form-label">Status</label>
                            <input type="text" class="form-control" readonly value="<?= $incident['Status']; ?>">
                        </div>
                        <div class="form-group col-md-6">
                            <label class="col-form-label">SLA</label>
                            <input type="text" class="form-control" readonly value="<?= $incident['SLATratamento']; ?>">
                        </div>
                    </div>
                    
                        
                            <label class="col-form-label">Descrição</label>
                            <p><?= $incident['Descricao']; ?></p>
                        
                    
                </form>
            </div>
        </div>
    </div>
</div>

<?php var_dump($incident); ?>