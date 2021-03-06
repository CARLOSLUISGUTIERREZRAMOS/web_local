<?php

class Descuento_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->db_web = $this->load->database('sandbox', TRUE);
    }

    public function GetDataDescuentoMovilApp($cc_code)
    {
        $today = date('Y-m-d');
        $time = date('H:i:s');
     
        $this->db_web->select("id,cantidad_aplica,cantidad_restante");
        $this->db_web->from('descuento');
        $this->db_web->where("'$today' BETWEEN fecha_inicio AND fecha_fin", false, false);
        $this->db_web->where("'$time' BETWEEN hora_inicio AND hora_fin", false, false);
        $this->db_web->where("estado_web", 'Y');
        $this->db_web->where("estado", 'Y');
        $this->db_web->like("metodos_pago", "$cc_code");
        $this->db_web->like("dispositivo", 'IOS');
        $this->db_web->like("dispositivo", 'ANDROID');
        $res = $this->db_web->get()->row();
        // return $this->db_web->last_query();
        return $res;
    }
    public function RestarCuponesFree($id,$new_quantity_coupons){
        $this->db_web->set('cantidad_restante', $new_quantity_coupons);
        $this->db_web->where('id', $id);
        $res = $this->db_web->update('descuento');
        return $res;
    }

    public function GetMontoDescuento($tipo_viaje, $origen, $destino, $clases)
    {
        $this->db_web->select("monto,codigo,metodos_pago,ruta,clase,aerolinea");
        $this->db_web->from('descuento');
        $this->db_web->where("CURDATE() BETWEEN fecha_inicio AND fecha_fin", false, false);
        $this->db_web->where("estado_web", 'Y');

        $cadena_forma_querysetruta = '';

        $cadena_forma_querysetruta .= $origen . $destino;
        $this->db_web->like('clase', $clases['ida']);
        if ($tipo_viaje === 'R') {
            $this->db_web->like('clase', $clases['retorno']);
            $cadena_forma_querysetruta .= ',' . $destino . $origen;
        }
        $this->db_web->like("ruta", $cadena_forma_querysetruta); //Forma=>LIMPCL
        $this->db_web->where("estado", 'Y');
        $res = $this->db_web->get()->row();

        return $res;
    }

    public function GetDataCodigoDescuento($codigo_descuento_ingresado)
    {
        $this->db_web->select("monto,id,codigo");
        $this->db_web->from('descuento');
        $this->db_web->where("CURDATE() BETWEEN fecha_inicio AND fecha_fin", false, false);
        $this->db_web->where("codigo", $codigo_descuento_ingresado);
        $this->db_web->where("estado", 'Y');
        return $this->db_web->get()->row();
    }
    public function GetInfoCodDesc($id_codigo)
    {
        $this->db_web->select("*");
        $this->db_web->from('descuento');
        $this->db_web->where("codigo", $id_codigo);
        $this->db_web->where("estado", 'Y');
        return $this->db_web->get()->row();
    }
    
}
