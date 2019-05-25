<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Connection_kiu {

    protected $URL = 'https://ssl00.kiusys.com/ws3/';
    protected $user = '2I';
//    protected $pass='nuo8noo0dooMJain';
    protected $pass = 'kiu2019starperu';
    protected $ErrorCode;
    protected $ErrorMsg;

    public function GetErrorCode() {
        return $this->ErrorCode;
    }

    public function Connection() {
        //open connection
        $this->ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($this->ch, CURLOPT_URL, $this->URL);
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

    public function CloseConnection() {
        //close connection
        curl_close($this->ch);
    }

    public function SendMessage($xml) {
//		curl_setopt($this->ch, CURLOPT_VERBOSE, true);
//		$verbose = fopen('php://temp', 'rw+');
//		curl_setopt($this->ch, CURLOPT_STDERR, $verbose);
        $xml = str_replace('+', '%20', urlencode($xml));
        $res = curl_setopt($this->ch, CURLOPT_POSTFIELDS, "user=" . $this->user . "&password=" . $this->pass . "&request=$xml");
//                return $res;
        //execute post
        $result = curl_exec($this->ch);
        //Check errors
        if (curl_errno($this->ch))
            $this->catchError(curl_error($this->ch)); //throw new Exception(curl_error($this->ch));

            
//Get Info
        $info = curl_getinfo($this->ch);
        //Check response code is OK
        if ($info['http_code'] != 200)
            $this->catchError("Invalid response code $info[http_code]"); //throw new Exception("Invalid response code $info[http_code]");

            
//		rewind($verbose);
//		$verboseLog = stream_get_contents($verbose);
//		echo "Verbose information:\n<pre>", htmlspecialchars($verboseLog), "</pre>\n";
        return $result;
    }

    public function catchError($ErrorMsg) {
        $this->ErrorCode = 1;
        $this->ErrorMsg = $ErrorMsg;
    }

}

?>