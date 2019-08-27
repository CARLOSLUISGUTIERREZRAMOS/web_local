<div class="col-sm-12 col-lg-10 col-md-12" id="bloque_desc" style="display: none">
    <div class="input-group mb-3">
        <input type="text" maxlength="2" id="input_desc" onkeyup="mayus(this);" class="form-control" placeholder="Ingrese código de descuento">
        <div class="input-group-append">
            <button class="btn btn-danger" type="button" id="btn_aplica_desc" title="Click para aplicar el código de descuento.">APLICAR DESCUENTO</button>
        </div>
    </div>
    <small id="emailHelp" class="form-text text-muted">Solo dale click a la opción "APLICAR DESCUENTO".</small>
</div>
<input type="hidden" value="<?=$cc_codes?>" id="cc_codes_validos_desc">
<input type="hidden" value="PROMODESC_TRUE" id="PROMODESC_TRUE">
