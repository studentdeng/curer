<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author      studentdeng 
 * @link        <studentdeng.github.com> 
 * @datetime    Mar 7, 2014 
 */
require APPPATH . '/libraries/CUREST_Controller.php';

class Ibeacon extends CUREST_Controller
{

    public function region_enter_post()
    {
        $inputParam = array('message');
        $paramValues = $this->posts($inputParam);

        $message = $paramValues["message"];
        
        $db = $this->load->database('curer', TRUE);
        
        $data = array(
            'time' => date('Y-m-d H:i:s'),
            'message' => $message,
        );
        
        $db->insert("position", $data);
        $db->close();
        
        $this->responseSuccess();
    }

    public function region_leave_post()
    {
        $inputParam = array('message');
        $paramValues = $this->posts($inputParam);

        $message = $paramValues["message"];
        
        $db = $this->load->database('curer', TRUE);
        
        $data = array(
            'time' => date('Y-m-d H:i:s'),
            'message' => $message,
        );
        
        $db->insert("position", $data);
        $db->close();
        
        $this->responseSuccess();
    }

}