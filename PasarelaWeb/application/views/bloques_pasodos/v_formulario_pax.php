<div class="card-body">
    <div class="row">
        <div class="col-10">
            <h3>Pasajero <?= $tipo_pax_name . ' N° ' . $pax_num ?></h3>
            <p>La información que ingreses aquí debe ser la misma de la identificación que presentarás al momento de abordar</p>
            <div class="form-group">
                <label for="nombres">Nombres:</label>
                <input type="text" class="form-control texto vacios" aria-describedby="nombres" name="nombres_<?= $tipo_pax_cod ?>_<?= $pax_num ?>" id="nombres" value="DEMO NAME">
            </div>
            <div class="form-group">
                <label for="ape-pat">Apellidos:</label>
                <input type="text" class="form-control texto vacios" aria-describedby="ape-pat" id="ape-pat" name="apellidos_<?= $tipo_pax_cod ?>_<?= $pax_num ?>" value="DEMO APE">
            </div>
            <div class="form-group">
                <label for="nacionalidad">Nacionalidad:</label>
                <div class="select">
                    <select name="nacionalidad_<?= $tipo_pax_cod ?>_<?= $pax_num ?>">
                        <?php foreach ($paises->result() as $pais) { ?>
                            <!-- PERU ID = 43 -->
                            <option value="<?= $pais->id ?>" <?= ($pais->id == 43) ? 'selected' : '' ?>><?= $pais->nombre_pais ?></option> 
                        <?php }
                        ?>

                    </select>
                    <div class="select__arrow"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-md-4">
            <label for="">Documento de identidad:</label>
            <div class="select">
                <select name="tipo_documento_<?= $tipo_pax_cod ?>_<?= $pax_num ?>" class="documento" value="vacio"  id="tipo_documento_<?= $tipo_pax_cod ?>_<?= $pax_num ?>">
                    <option disabled selected value>  SELECCIONE   </option>
                    <option value="NI" selected>DNI</option>
                    <option value="PP">PASAPORTE</option>
                    <option value="ID">CEX</option>
                </select>
                <div class="select__arrow"></div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="form-group">
                <label for="num-doc">Número de documento:</label>
                <label class="prueba" id="<?= $pax_num ?>"></label>
                <input type="text" class="form-control numdoc vacios" aria-describedby="num-doc" id="input_documento" name="numdoc_<?= $tipo_pax_cod ?>_<?= $pax_num ?>" value="45571574"/>
            </div>
        </div>
    </div>
</div>