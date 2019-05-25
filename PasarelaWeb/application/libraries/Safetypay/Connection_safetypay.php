<?php

/**
 * Description of Connection_safetypay
 *
 * @author cgutierrez
 */
class Connection_safetypay {

    //<editor-fold defaultstate="collapsed" desc="PARAMETROS DE PRODUCCION">
//    public $ApiKey = "22abdb77542b40c69d124a205ab3889b";
//    public $SignatureKey = "eecb9c4ae4d2434aaf3142da7bc82fcb";
//    public $TokenURLExpressSafetyPay = "https://mws2.safetypay.com/express/ws/v.3.0/Post/CreateExpressToken";
//    public $URLFormularioSuccess = "http://www.starperu.com/";
//    public $URLFormularioError = "https://sslzone.starperu.com/error_safetypay.php";
//    public $WSConsultaSafetyPay = "https://mws2.safetypay.com/express/ws/v.3.0/Post/GetOperation";
    //</editor-fold>

    public $ApiKey = "a1c1cbdc9144c58b628896ee3f8bdc74";
    public $SignatureKey = "0ce185fb4bd47bfbc528c9f7d4e28fea";
    public $TokenURLExpressSafetyPay = "https://sandbox-mws2.safetypay.com/express/ws/v.3.0/Post/CreateExpressToken";
    public $URLFormularioSuccess = "http://www.starperu.com/";
    public $URLFormularioError = "https://sslzone.starperu.com/error_safetypay.php";
    public $WSConsultaSafetyPay = "https://sandbox-mws2.safetypay.com/express/ws/v.3.0/Post/GetOperation";
    public $ErrorCode;
    public $ErrorMsg;

    function __construct() {
        //open connection
        $this->ch = curl_init();
    }

    public function Connection($url) {
        //set the url, number of POST vars, POST data
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_POST, 1);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array(
            'Connection: Keep-Alive',
            'Keep-Alive: 300'
        ));
        if (curl_errno($this->ch))
            $this->catchError(curl_error($this->ch)); //throw new Exception(curl_error($this->ch));
    }

    public function GetApiKey() {
        return $this->ApiKey;
    }

    public function GetFromSuccess() {
        return $this->URLFormularioSuccess;
    }

    public function GetFromError() {
        return $this->URLFormularioError;
    }

    public function GetSignatureKey() {
        return $this->SignatureKey;
    }

    public function CloseConnection() {
        curl_close($this->ch);
    }

    public function SendMessage($parametros) {
        curl_setopt($this->ch, CURLOPT_POSTFIELDS, $parametros);
        //execute post
        $result = curl_exec($this->ch);
        //Check errors
        if (curl_errno($this->ch))
            $this->catchError(curl_error($this->ch)); //throw new Exception(curl_error($this->ch));







            
//Get Info
        $info = curl_getinfo($this->ch);
        //Check response code is OK
        if ($info['http_code'] != 200)
            $this->catchError("Invalid response code " . $info["http_code"]); //throw new Exception("Invalid response code $info[http_code]");
        return $result;
    }

    public function catchError($ErrorMsg) {
        $this->ErrorCode = 1;
        $this->ErrorMsg = $ErrorMsg;
    }

}

?>
