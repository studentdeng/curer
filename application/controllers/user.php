<?php
/**
 * Created by PhpStorm.
 * User: yuguang
 * Date: 21/10/14
 * Time: 6:58 PM
 */

if (!defined('BASEPATH')) exit('No direct script access allowed');

class User extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    function index()
    {
        echo "hello user";
    }

    function login()
    {
        $this->load->helper('url');
        $this->load->library('session');
        $this->load->view('login');
    }
}