<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Time extends CI_Controller {

    private $teamcola;

    function __construct() {
        parent::__construct();

        $this->load->helper('url');
        $this->load->library('session');

        $isLogin = $this->session->userdata('isLogin');
        if (!$isLogin) {
            redirect('/user/login', 'location', 301);
        }

        $this->teamcola = $this->createTeamcola();
    }

    function createTeamcola() {
        $url = 'http://' . $_SERVER['HTTP_HOST'] . '/curer/index.php/cola/stats/category_list';
        $labelsString = file_get_contents($url);
        $labels = json_decode($labelsString, TRUE);

        $teamcola = array();
        $teamcola['api'] = array(
            'addWorklog' => '/curer/index.php/cola/worklog/add',
            'updateWorklog' => "/curer/index.php/cola/worklog/update",
            'getWorklog' => "/curer/index.php/cola/worklog/list",
            'deleteWorklog' => "/curer/index.php/cola/worklog/delete",
            'exportWorklog' => "/curer/index.php/cola/worklog/export/",
        );

        $teamcola['me'] = array(
            'guid' => "1bf27d0f003c411193b6f8bfe28b8dfc",
            'avatar' => "/uploads/avatar/1bf27d0f003c411193b6f8bfe28b8dfc.jpg",
            'name' => "curer",
            'email' => "studentdeng@hotmail.com"
        );

        $teamcola['currentTeam'] = '990de71f506043858c431e1ea41dc725';
        $teamcola['teams'] = array(
            array(
                'labels' => $labels,
                'guid' => "990de71f506043858c431e1ea41dc725",
                'name' => "Studentdeng",
                'archive_labels' => array(),
            )
        );

        return $teamcola;
    }

    function index() {
        $this->load->view('time/index', array('teamcola' => $this->teamcola));
    }

    function team() {
        $this->load->view('time/team', array('teamcola' => $this->teamcola));
    }

    function stats_label() {
        $this->load->view('time/stats_label', array('teamcola' => $this->teamcola));
    }

}
