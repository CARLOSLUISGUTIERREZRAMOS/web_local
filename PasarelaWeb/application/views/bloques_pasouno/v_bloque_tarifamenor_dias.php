<div class="row no-gutters fechas" id="<?=$TipoVuelo?>">
    <div class="col"><a class="dias disabled"><i class="fa fa-fw fa-calendar"></i> <small id="<?= RestarFecha($date,'-3')?>"><?= FechaOperaLetras_ES($date,'-3')?></small></a></div>
    <div class="col"><a class="dias"><i class="fa fa-fw fa-calendar"></i> <small id="<?= RestarFecha($date,'-2')?>"><?= FechaOperaLetras_ES($date,'-2')?></small></a></div>
    <div class="col"><a class="dias"> <i class="fa fa-fw fa-calendar"></i> <small id="<?= RestarFecha($date,'-1')?>"><?= FechaOperaLetras_ES($date,'-1')?></small></a></div>
    <div class="col"><a class="dias active"><small class="smallactive_<?=$TipoVuelo?>"><?= FechaLetras_ES(fecha_iso_8601($date),'short')?></small></a></div>
    <div class="col"><a class="dias"><i class="fa fa-fw fa-calendar"></i> <small id="<?= RestarFecha($date,'+1')?>"><?= FechaOperaLetras_ES(fecha_iso_8601($date),'+1')?></small></a></div>
    <div class="col"><a class="dias"><i class="fa fa-fw fa-calendar"></i> <small id="<?= RestarFecha($date,'+2')?>"><?= FechaOperaLetras_ES(fecha_iso_8601($date),'+2')?></small></a></div>
    <div class="col"><a class="dias"><i class="fa fa-fw fa-calendar"></i> <small id="<?= RestarFecha($date,'+3')?>"><?= FechaOperaLetras_ES(fecha_iso_8601($date),'+3')?></small></a></div>
</div>