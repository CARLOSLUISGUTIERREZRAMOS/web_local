 <script type="text/javascript">

            function printDiv(ticketN)
            {

                var divToPrint = document.getElementById(ticketN);

                var newWin = window.open('', 'Print-Window');
//                var newWin = window.open("", "_self");

                newWin.document.open();

                newWin.document.write('<html><body onload="window.print()">' + divToPrint.innerHTML + '</body></html>');

                newWin.document.close();

                setTimeout(function () {
                    newWin.close();
                }, 1);

            }

//            function printDiv(nombreDiv) {
//
//                var contenido = document.getElementById(nombreDiv).innerHTML;
//                var contenidoOriginal = document.body.innerHTML;
//
//                document.body.innerHTML = contenido;
//
////                window.print();
//                if (window.print()) { 
//                    document.body.innerHTML = contenidoOriginal;
//                    return false; 
//                } 
//                else { 
////                    location.reload(); 
//                }
//            }
        </script>

<div class="modal full fade" id="etktModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"> <?= img('img/Logotipo.png') ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="areaImprimir">
                <?php echo $eticket ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="printDiv('areaImprimir')">Imprimir</button>
            </div>
        </div>
    </div>
</div>