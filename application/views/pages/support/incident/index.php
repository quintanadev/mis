<div class="row">
    <div class="col-md-6 col-xl-3">
        <div class="widget-rounded-circle card-box">
            <div class="row">
                <div class="col-6">
                    <div class="avatar-lg rounded-circle bg-primary">
                        <i class="fe-tag font-22 avatar-title text-white"></i>
                    </div>
                </div>
                <div class="col-6">
                    <div class="text-right">
                        <h3 class=" mt-1"><span data-plugin="counterup">3947</span></h3>
                        <p class="text-muted mb-1 text-truncate">Total Tickets</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="widget-rounded-circle card-box">
            <div class="row">
                <div class="col-6">
                    <div class="avatar-lg rounded-circle bg-warning">
                        <i class="fe-clock font-22 avatar-title text-white"></i>
                    </div>
                </div>
                <div class="col-6">
                    <div class="text-right">
                        <h3 class=" mt-1"><span data-plugin="counterup">624</span></h3>
                        <p class="text-muted mb-1 text-truncate">Pendentes</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="widget-rounded-circle card-box">
            <div class="row">
                <div class="col-6">
                    <div class="avatar-lg rounded-circle bg-success">
                        <i class="fe-check-circle font-22 avatar-title text-white"></i>
                    </div>
                </div>
                <div class="col-6">
                    <div class="text-right">
                        <h3 class=" mt-1"><span data-plugin="counterup">3195</span></h3>
                        <p class="text-muted mb-1 text-truncate">Respondidos</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6 col-xl-3">
        <div class="widget-rounded-circle card-box">
            <div class="row">
                <div class="col-6">
                    <div class="avatar-lg rounded-circle bg-danger">
                        <i class="fe-percent font-22 avatar-title text-white"></i>
                    </div>
                </div>
                <div class="col-6">
                    <div class="text-right">
                        <h3 class=" mt-1"><span data-plugin="counterup">97%</span></h3>
                        <p class="text-muted mb-1 text-truncate">SLA</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <div class="card-box">
            <a href="<?= base_url('support/incident/created'); ?>" class="btn btn-sm btn-blue waves-effect waves-light float-right">
                <i class="mdi mdi-plus-circle"></i> Abrir Novo Incidente
            </a>
            <h4 class="header-title mb-4">Lista de Chamados</h4>
            <table class="table table-hover m-0 table-centered dt-responsive nowrap w-100" id="incidents-table"></table>
        </div>
    </div>
</div>

