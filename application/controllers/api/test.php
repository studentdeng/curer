<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author      studentdeng 
 * @link        <studentdeng.github.com> 
 * @datetime    Apr 20, 2014 
 */
require APPPATH . '/libraries/CUREST_Controller.php';

class Test extends CUREST_Controller {

    public function time_post()
    {
        $inputParam = array('timestamp');
        $paramValues = $this->posts($inputParam);

        $timestamp = $paramValues['timestamp'];

        $this->responseSuccess(date('Y-m-d H:i:s', $timestamp));
    }
}