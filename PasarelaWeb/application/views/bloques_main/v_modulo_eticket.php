    
<div class="tab-pane fade" id="nav-ticket" role="tabpanel" aria-labelledby="nav-ticket-tab">
    <div class="row no-gutters">
        <div class="col-12 form-cuerpo">
            <div class="row no-gutters form-header">
                <div class="col-sm-12">
                    <h2>E-Ticket</h2>
                </div>
            </div>
            <?= form_open('E_ticket') ?>

            <div class="row form-body">
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label for="r-code">Código de reserva:</label>
                        <input type="text" class="form-control" aria-describedby="fecha" placeholder="selecciona" id="codigo_reserva" name="codigo_reserva" maxlength="6" minlength="6">
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="form-group">
                        <label for="rc-last_name">Apellido:</label>
                        <input type="text" class="form-control" aria-describedby="fecha" placeholder="selecciona" id="apellido" name="apellido" maxlength="60">
                    </div>
                </div>
                <div class="col-12">
                    <button class="btn btn-primary" type="submit">Buscar</button>
                </div>
            </div>
            <?= form_close() ?>

        </div>
    </div>
</div>