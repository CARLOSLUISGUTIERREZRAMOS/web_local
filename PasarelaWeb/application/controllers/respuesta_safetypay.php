<?php

class Respuesta_safetypay extends CI_Controller {

    private $kiu;
    private $funciones;
    private $safetypay;
    private $funciones_safetypay;
    private $tarifa;

    public function __construct() {
        parent::__construct();
        $this->load->helper("safetypay");
    }

    function index() {

         /* CAMPOS POST ENVIADOS DESDE SAFETYPAY - NOTIFICACION DE PAGO */
        $ErrorNumber = "0";
        $ApiKey = strip_tags($_POST['ApiKey']);
        $ResponseDateTime = strip_tags($_POST['RequestDateTime']); //Fecha Hora de confirmacion por parte de SafetyPay
        $MerchantSalesID = strip_tags($_POST['MerchantSalesID']); //Codigo de Pago (PNR - Id_Reserva)
        $ReferenceNo = strip_tags($_POST['ReferenceNo']); //Identificador de la operación de SafetyPay
        $CreationDateTime = strip_tags($_POST['Creati  onDateTime']); //Usado para componer el Signature ISO 8601: yyyy-MM-ddThh:mm:ss
        $Amount = strip_tags($_POST['Amount']); //Monto de la transacción en la moneda del comercio. Con precisión de 2 decimales
        $CurrencyID = strip_tags($_POST['CurrencyID']); //Código de moneda de la transacción
        $PaymentReferenceNo = strip_tags($_POST['PaymentReferenceNo']); //Numero de referencia de la operación de pago enviado por el banco, normalmente es null
        $Status = strip_tags($_POST['Status']); //Estado de la operación de SafetyPay
        $OrderNo = $MerchantSalesID;
        $Signature = strip_tags($_POST['Signature']);
        $SignatureKey = $this->safetypay->GetSignatureKey();
        //csv
        $data = $ResponseDateTime . $MerchantSalesID . $ReferenceNo . $CreationDateTime . $Amount . $CurrencyID . $PaymentReferenceNo . $Status . $OrderNo . $SignatureKey;
        $SignatureHash = $this->funciones_safetypay->hash_signature($data);




        $this->safetypay_helper->actualizar_log_respuesta_safetypay($ErrorNumber . $ApiKey, $ResponseDateTime, $MerchantSalesID, $ReferenceNo, $CreationDateTime, $Amount, $CurrencyID, $PaymentReferenceNo, $Status, $OrderNo, $SignatureHash);
    }

}

?>
