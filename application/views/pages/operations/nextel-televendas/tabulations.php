<div class="row">
    <div class="col-md-4 col-xl-4">
        <div class="widget-rounded-circle card-box">
            <div class="row">
                <div class="col-6">
                    <div class="avatar-lg rounded-circle bg-soft-info border-info border">
                        <i class="fe-edit font-22 avatar-title text-info"></i>
                    </div>
                </div>
                <div class="col-6">
                    <div class="text-right">
                        <h3 class="mt-1"><span id="counterup-tabulacao">-</span></h3>
                        <p class="text-muted mb-1 text-truncate">Tabulações</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-xl-4">
        <div class="widget-rounded-circle card-box">
            <div class="row">
                <div class="col-6">
                    <div class="avatar-lg rounded-circle bg-soft-success border-success border">
                        <i class="fe-shopping-cart font-22 avatar-title text-success"></i>
                    </div>
                </div>
                <div class="col-6">
                    <div class="text-right">
                        <h3 class="mt-1"><span id="counterup-venda">-</span>%</h3>
                        <p class="text-muted mb-1 text-truncate">Vendas</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-xl-4">
        <div class="widget-rounded-circle card-box">
            <div class="row">
                <div class="col-6">
                    <div class="avatar-lg rounded-circle bg-soft-danger border-danger border">
                        <i class="fe-phone-off font-22 avatar-title text-danger"></i>
                    </div>
                </div>
                <div class="col-6">
                    <div class="text-right">
                        <h3 class="mt-1"><span id="counterup-insucesso">-</span>%</h3>
                        <p class="text-muted mb-1 text-truncate">Insucesso</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-xl-6">
        <div class="card-box">
            <h4 class="header-title">Resultado Intervalo</h4>
            <div id="chart-interval" class="chart" style="height: 200px;"></div>
        </div>
    </div>
    <div class="col-md-12 col-xl-6">
        <div class="card-box">
            <h4 class="header-title">Resultado Diário</h4>
            <div id="chart-date" class="chart" style="height: 200px;"></div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card-box">
            <table class="table table-hover m-0 table-centered nowrap w-100" id="table-tabulations"></table>
        </div>
    </div>
</div>

<div id="filter" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Filtros</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Data Início</label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control flatpickr" name="DataReferenciaDe">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-blue border-blue text-white">
                                        <i class="mdi mdi-calendar-range font-13"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="control-label">Data Fim</label>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control flatpickr" name="DataReferenciaAte">
                                <div class="input-group-append">
                                    <span class="input-group-text bg-blue border-blue text-white">
                                        <i class="mdi mdi-calendar-range font-13"></i>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="modal-footer">
                <button type="button" class="btn btn-light waves-effect" data-dismiss="modal">Fechar</button>
                <button type="button" class="btn btn-primary waves-effect waves-light btn-save-filter">Salvar</button>
            </div>
        </div>
    </div>
</div>