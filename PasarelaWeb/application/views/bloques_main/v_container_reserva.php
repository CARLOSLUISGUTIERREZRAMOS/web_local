<div class="form-reserva">
    <div class="container-fluid">
        <div class="row no-gutters">
            <div class="col-12">
                <?php $this->load->view('bloques_main/v_modulos_procesos_web'); ?>
            </div>
            <div class="col-12">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="nav-reserva" role="tabpanel" aria-labelledby="nav-reserva-tab">
                        <div class="row no-gutters">
                            <div class="col-12 form-cuerpo">
                                <?= form_open('PasoUno', 'id="FormMain"') ?>
                                <div class="row no-gutters form-header">
                                    <div class="col-sm-12 col-md-6">
                                        <h2><?= $this->lang->line('quiero_viajar') ?></h2>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="row">
                                            <div class="col-12 text-right">
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="customRadioInline2" name="tipo_viaje" class="custom-control-input" checked="checked" value="R">
                                                    <label class="custom-control-label" for="customRadioInline2"><?= $this->lang->line('rt') ?></label>
                                                </div>
                                                <div class="custom-control custom-radio custom-control-inline">
                                                    <input type="radio" id="customRadioInline1" name="tipo_viaje" class="custom-control-input" value="O">
                                                    <label class="custom-control-label" for="customRadioInline1"><?= $this->lang->line('ow') ?></label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>


                                <div class="row form-body">
                                    <div class="col-sm-12 col-md-6">
                                        <!--<label for="">Desde:</label>-->
                                        <label for=""><?= $this->lang->line('desde') ?></label>
                                        <div class="select">

                                            <select name="origen" id="origen">
                                                <?php
                                                foreach ($ciudad_origen->result() as $row) {
                                                    $selected = ($row->codigo == 'LIM') ? 'selected' : '';
                                                    ?>
                                                    <option value="<?= $row->codigo ?>" <?= $selected ?>><?= $row->nombre ?></option>
                                                    <?php
                                                }
                                                ?>

                                            </select>
                                            <div class="select__arrow"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <label for=""><?= $this->lang->line('hacia') ?></label>
                                        <div class="select">
                                            <select id="ciudad_destino" name="destino"  data-container="body" data-toggle="popover" data-placement="top" data-content="No debes exceder los 9 pasajeros" data-trigger="focus">
                                            </select>
                                            <div class="select__arrow"></div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6">
                                        <div class="form-group">
                                            <label for="date_from"><?= $this->lang->line('salida') ?></label>
                                            <input type="text" class="form-control" aria-describedby="fecha" placeholder="selecciona" id="date_from" name="date_from" readonly="true">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 twoway" id="twoway">
                                        <div class="form-group">
                                            <label for="date_to"><?= $this->lang->line('retorno') ?></label>
                                            <input type="text" class="form-control" aria-describedby="fecha" placeholder="selecciona" id="date_to" name="date_to" readonly="true">
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-6 oneway" id="oneway" style="display: none;">
                                        &nbsp;
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        &nbsp;
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label for="adultos"><?= $this->lang->line('adultos') ?></label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend" id="button-addon3">
                                                    <button class="btn btn-outline-secondary mod SumAdl" type="button">-</button>
                                                </div>
                                                <input type="text" id="adultos" name="cant_adultos" class="form-control" placeholder="" aria-label="adultos" aria-describedby="button-addon3" value="1" data-container="body" data-toggle="popover" data-placement="top" data-content="No debes exceder los 9 pasajeros" data-trigger="focus">
                                                <div class="input-group-append" id="button-addon4">
                                                    <button class="btn btn-outline-secondary mod SumAdl" type="button" >+</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label for="ninos"><?= $this->lang->line('ninios') ?></label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend" id="button-addon3">
                                                    <button class="btn btn-outline-secondary mod SumAdl" type="button">-</button>
                                                </div>
                                                <input type="text" id="ninos" name="cant_ninos" class="form-control" placeholder="" aria-label="niños" aria-describedby="button-addon3" value="0">
                                                <div class="input-group-append" id="button-addon4">
                                                    <button class="btn btn-outline-secondary mod SumAdl" type="button" >+</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">
                                        <div class="form-group">
                                            <label for="bebes"><?= $this->lang->line('infantes') ?></label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend" id="button-addon3">
                                                    <button class="btn btn-outline-secondary mod SumAdl" type="button">-</button>
                                                </div>
                                                <input type="text" id="bebes" name="cant_infantes" class="form-control" placeholder="" aria-label="bebes" aria-describedby="button-addon3" value="0">
                                                <div class="input-group-append" id="button-addon4">
                                                    <button class="btn btn-outline-secondary mod SumAdl" type="button">+</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-12 col-md-3">

                                    </div>
                                    <div class="col-12 text-right">

                                        <button class="btn btn-primary btn-lg btn_submit" type="submit"><?= $this->lang->line('buscar_vuelos') ?></button>
                                    </div>
                                </div>
                                <input type="hidden" id="hidd_name_ciu_orig" name="hidd_name_ciu_orig" value="">
                                <input type="hidden" id="hidd_name_ciu_dest" name="hidd_name_ciu_dest" value="">
                                <?= form_close() ?>
                            </div>
                        </div>
                    </div>
                    <?php $this->load->view('bloques_main/v_modulo_ckeckin'); ?>
                    <?php $this->load->view('bloques_main/v_modulo_pagoreservas'); ?>
                    <?php $this->load->view('bloques_main/v_modulo_eticket'); ?>
                </div>
            </div>
        </div>
    </div>
</div>    