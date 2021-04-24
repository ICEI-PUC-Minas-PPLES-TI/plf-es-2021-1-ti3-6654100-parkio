@extends('layouts.standard')

@section('extraassets')
    <link rel="stylesheet" href="{{ url('/assets/css/gate.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ url('/assets/css/select2.css') }}" type="text/css">
    <script src="{{ url('assets/js/gate.js') }}"></script>
    <script src="{{ url('assets/js/select2.min.js') }}"></script>
@endsection

@section('pagename')
    Portaria
@endsection

@section('content')

<div class="container-fluid" id="gate">
    <ul class="nav nav-tabs" id="gateTab" role="tablist">
        <li class="nav-item col-6 col-md-3" role="presentation">
            <button class="nav-link col-12 active" id="entrance-tab" data-bs-toggle="tab" data-bs-target="#entrance" type="button" role="tab" aria-controls="entrance" aria-selected="true">Entrada</button>
        </li>
        <li class="nav-item col-6 col-md-3" role="presentation">
            <button class="nav-link col-12" id="exit-tab" data-bs-toggle="tab" data-bs-target="#exit" type="button" role="tab" aria-controls="exit" aria-selected="false">Saída</button>
        </li>
    </ul>
    <div id="entrance-exit-container">
        <div class="tab-content" id="gateTabContent">
            <!-- Vehicle Input  -->
            <div class="tab-pane fade show active" id="entrance" role="tabpanel" aria-labelledby="entrance-tab">
                <form onSubmit="handleEntranceFormSubmit(event)" class="row" id="entrance-form">
                    <div class="mb-3 col-12 col-md-4 col-lg-2">
                        <label for="input-plate" class="form-label">Placa <span class="required">*</span></label>
                        <input minlength="7" maxlength="8" type="text" class="form-control" id="input-plate" required>
                    </div>
                    <div class="mb-3 col-12 col-md-8 col-lg-6">
                        <label for="input-name" class="form-label">Nome do condutor <span class="required">*</span></label>
                        <input type="text" class="form-control" id="input-name" required>
                    </div>
                    <div class="mb-3 col-12 col-md-6 col-lg-4">
                        <label for="txtDestination" class="form-label d-block">Destino <span class="required">*</span></label>
                        <select id="selDestination" class="select2 form-select d-block" required></select>
                    </div>
                    <div class="mb-3 col-12 col-md-3 col-lg-2">
                        <label for="input-type" class="form-label">Tipo</label>
                        <select onChange="handleSelectChange(event)" id="input-type" class="form-select">
                            <option value="0"></option>
                        </select>
                    </div>
                    <div class="mb-3 col-12 col-md-3 col-lg-2">
                        <label for="input-time" class="form-label">Tempo (minutos)</label>
                        <input type="number" min="0" class="form-control" id="input-time">
                    </div>
                    <div class="mb-3 col-12 col-md-6 col-lg-4">
                        <label for="input-cpf" class="form-label">CPF</label>
                        <input type="text" class="form-control" id="input-cpf" maxlength="14">
                    </div>
                    <div class="mb-3 col-12 col-md-4 col-lg-2">
                        <label for="input-model" class="form-label">Modelo</label>
                        <input type="text" class="form-control" id="input-model">
                    </div>
                    <div class="mb-3 col-12 col-md-2 col-lg-2">
                        <label for="input-color" class="form-label">Cor</label>
                        <select class="gate-inputcolor form-select d-block" id="input-color">
                            <option selected value="">Indefinido</option>
                        </select>
                    </div>
                    <div class="button-div text-center mt-5">
                        <button class="btn" type="submit">Cadastrar</button>
                    </div>
                    
                </form>
            </div>
            <!--  Vehicle Output -->
            <div class="tab-pane fade" id="exit" role="tabpanel" aria-labelledby="exit-tab">
                <form onSubmit="handleExitFormSubmit(event)" class="row" id="exit-form">
                    <div class="mb-3 col-12 col-md-4 col-lg-2">
                        <label for="input-plate-exit" class="form-label">Placa <span class="required">*</span></label>
                        <input type="text" class="form-control" id="input-plate-exit" required>
                    </div>
                    <div class="button-div text-center mt-5">
                        <button id="button-att" class="btn" type="submit">Atualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Inside Vehicles Table -->
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-center">
                <i class="fas fa-chevron-down fa-5x"></i>
            </div>
            <div id="tabela" class="row">
                <div class="col-12">
                    <table id="tabela-veiculo" class="table table-dark sortable">
                        <thead>
                            <tr>
                                <th class="col">Placa</th>
                                <th class="col">Modelo</th>
                                <th class="col">Cor</th>
                                <th class="col">Hora de Entrada</th>
                                <th class="col-2">Ações</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                        </tbody>
                    </table>
                    <div id="lista-veiculo">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Exit -->
    <div class="modal fade" id="modalNovoUsuario" tabindex="-1" aria-labelledby="modalNovoUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content">
                <div class="modal-header justify-content-left border-0">
                    <h5 class="modal-title" id="modalNovoUsuarioLabel"><i class="fas fa-exclamation-triangle"></i>&nbsp;Confirmar saída do veículo <span id="span-plate"></span>?</h5>
                </div>
                <div class="modal-body justify-content-center">
                    <form onSubmit="handleExitModal(event)" id="exit-modal" class="justify-content-center">
                        <div id="modal-score" class="mb-5 d-flex">
                            <label for="input-name" class="form-label">Comportamento do visitante:&nbsp;</label>
                            <div class="form-check form-check-inline">
                                <label id="label-good" class="form-check-label" for="good-score">
                                    <input class="form-check-input d-none" type="radio" checked name="scores" id="good-score" value="G">
                                    <i class="far fa-thumbs-up goodcheckmark"></i>
                                </label>
                            </div>
                            <div class="form-check form-check-inline">
                                <label id="label-bad" class="form-check-label" for="bad-score">
                                    <input class="form-check-input d-none" type="radio" name="scores" id="bad-score" value="B">
                                    <i class="far fa-thumbs-down badcheckmark"></i>
                                </label>
                            </div>
                        </div>
                        <div id="modal-buttons" class="mb-3">
                            <div class="row">
                                <div class="col-4">
                                    <button id="reportar" disabled type="button" class="btn btn-danger w-100">Reportar</button>
                                </div>
                                <div class="col-4">
                                    <button id="close-modal" type="button" class="btn btn-secondary w-100 " data-bs-dismiss="modal">Não&nbsp;<small>(cancelar)</small></button>
                                </div>
                                <div class="col-4">
                                    <button id="atualizar" type="submit" class="btn btn-secondary w-100">Sim&nbsp;<small>(Enter)</small></button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    

</div>

</div>
@endsection