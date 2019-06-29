<div class="col-sm-12 col-md-8" id="bloque_desc" style="display: none">
    <div class="input-group mb-3">
        <input type="text" maxlength="2" id="input_desc" onkeyup="mayus(this);" class="form-control" placeholder="Ingrese código de descuento">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="button" id="btn_aplica_desc">APLICAR</button>
        </div>
    </div>
</div>
<input type="hidden" value="<?=$cc_codes?>" id="cc_codes_validos_desc">
<input type="hidden" value="PROMODESC_TRUE" id="PROMODESC_TRUE">
