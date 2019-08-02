<?php
if (!function_exists('GetCodeStandard')) {
    function GetCodeStandard($cc_code_web)
    //Obtener el codigo real con el que se identifica el método de pago 
    {
        switch ($cc_code_web) {
            case 'TC_V':
                $cc_code_standar = 'VI';
                break;
            case 'TC_M':
                $cc_code_standar = 'VI';
                break;
            case 'TC_D':
                $cc_code_standar = 'VI';
                break;
            case 'TC_A':
                $cc_code_standar = 'VI';
                break;
            case 'SP_C':
                $cc_code_standar = 'SP';
                break;
            case 'SP_I':
                $cc_code_standar = 'SP';
                break;
            case 'SP_E':
                $cc_code_standar = 'SP';
                break;
            case 'PE_B':
                $cc_code_standar = 'PE';
                break;
        }
        return $cc_code_standar;
    }
}
