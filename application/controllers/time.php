<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Time extends CI_Controller
{

    function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
        $this->load->library('session');

        $isLogin = $this->session->userdata('isLogin');
        if (!$isLogin) {
            redirect('/user/login', 'location', 301);
        }
    }

    function index()
    {
        $url = base_url("/index.php/cola/stats/category_list");
        $labels = file_get_contents($url);
        $this->load->view('time/index', array('labels' => $labels));
    }

    function team()
    {
        $url = base_url("/index.php/cola/stats/category_list");
        $labels = file_get_contents($url);
        $this->load->view('time/team', array('labels' => $labels));
    }

    function stats_label()
    {
        $url = base_url("/index.php/cola/stats/category_list");
        $labels = file_get_contents($url);
        $this->load->view('time/stats_label', array('labels' => $labels));
    }
}