<?php
/**
 * Description of PasarelaPagos
 *
 * @author cgutierrez
 */
class PasarelaPagos extends CI_Controller{
    
    public function __construct() {
        parent::__construct();
    }   
    
    public function Index(){
       $xss_post = $this->input->post(NULL, TRUE);
       print_r($xss_post);die;
//       $xss_post['transactionToken'];
       if(isset($_GET["token"])){
           $this->ProcesoPayPal();
       }
       
    }
    public function ProcesoPayPal(){
        
        
    }
    
    
}
