<?php

class Descuento_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->db_web = $this->load->database('sandbox', TRUE);
    }

    public function GetMontoDescuento($tipo_viaje,$origen,$destino,$clases){
        $this->db_web->select("monto,codigo,metodos_pago,ruta,clase");
        $this->db_web->from('descuento');
        $this->db_web->where("CURDATE() BETWEEN fecha_inicio AND fecha_fin",false,false);
        
        $cadena_forma_querysetruta = '';
        
        $cadena_forma_querysetruta .= $origen.$destino;
        $this->db_web->like('clase', $clases['ida']);
        if($tipo_viaje === 'R'){
            $this->db_web->like('clase', $clases['retorno']);
            $cadena_forma_querysetruta .= ','.$destino.$origen;
        }
        $this->db_web->where_in("ruta",$cadena_forma_querysetruta); //Forma=>LIMPCL
        $this->db_web->where("estado",'Y');
        $res = $this->db_web->get()->row();
        
        return $res;
        
    }

    public function GetDataCodigoDescuento($codigo_descuento_ingresado){
        $this->db_web->select("monto,codigo");
        $this->db_web->from('descuento');
        $this->db_web->where("CURDATE() BETWEEN fecha_inicio AND fecha_fin",false,false);
        $this->db_web->where("codigo",$codigo_descuento_ingresado);
        $this->db_web->where("estado",'Y');
        return $this->db_web->get()->row();
    }

}
