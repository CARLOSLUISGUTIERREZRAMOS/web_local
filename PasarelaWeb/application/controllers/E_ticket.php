<?php

/**
 * Description of Pago_reservas
 *
 * @author cgutierrez
 */
class E_ticket extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->template->add_js('js/web/ticket.js');
        $this->load->library('form_validation');
        $this->load->model('Reserva_model');
        $this->load->helper('tiempos');
    }

    private function ValidarFormulario() {
        $this->form_validation->set_rules('codigo_reserva', 'codigo_reserva', 'trim|required|min_length[6]|max_length[6]');
        $this->form_validation->set_rules('apellido', 'apellido', 'required', 'trim|required|max_length[70]');
    }

    public function Index() {
        $this->ValidarFormulario();
        if ($this->form_validation->run() == FALSE) {
            header("Location: " . base_url());
        } else {
            $xss_post = $this->input->post(NULL, TRUE);
            $codigo_reserva = $xss_post['codigo_reserva'];
            $apellido = $xss_post['apellido'];
            $data['res_model_vuelo'] = $this->Reserva_model->Buscar_Reserva_Todos($codigo_reserva, $apellido);

            if (!is_null($data['res_model_vuelo'])) { // VALIDANDO QUE LA RESERVA SE ENCUENTRE EN LA DB DE STARPERU
                $RESERVA_PAGADA = (bool) $data['res_model_vuelo']->estado;

                if ($RESERVA_PAGADA) { //VALIDAMOS SI LA RESERVA YA FUE PAGADA
                    $reserva_id = $data['res_model_vuelo']->reserva_id;

                    $campos = 'nombres,apellidos,tipo_documento,num_documento,tipo_pasajero,num_ticket';
                    $data['res_model_pasajero'] = $this->Reserva_model->ObtenerPasajerosReserva_detalle($reserva_id, $campos);

//            
                    $this->template->load('v_e-ticket', $data);
                    $this->load->view('politicas_negocio/politicas_devolucion');
                    $this->load->view('politicas_negocio/terminos_condiciones');
                    $this->load->view('templates/v_modal_show_ticket');
                } else { //MOSTRANDO MENSAJE QUE LA RESERVA NO HA SIDO PAGADA AÚN
                    header("Location: " . base_url() . 'html/web/reserva_nopagada.html');
                }
            } else {
                header("Location: " . base_url() . 'html/web/reserva_noencontrada.html');
            }
        }
    }

}
