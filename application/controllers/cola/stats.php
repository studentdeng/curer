<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author      studentdeng 
 * @link        <studentdeng.github.com> 
 * @datetime    Apr 20, 2014 
 */
require APPPATH . '/libraries/CUREST_Controller.php';

class Stats extends CUREST_Controller {

    public function chat_post() {

        $inputParam = array('data');
        $paramValues = $this->posts($inputParam);

        $data = $paramValues["data"];

        $dataParam = json_decode($data, TRUE);

        $start = $dataParam['start'];
        $end = $dataParam['end'];
        
        $item = array();
        $item['percent'] = 0.8;
        $item['amount'] = 33;
        $item['guid'] = uniqid();
        $item['sub_title'] = null;
        $item['title'] = array(
            'url' => '',
            'name' => '产品开发',
        );

        $table = array();
        $table[] = $this->test();
        $table[] = $this->test();
        

        $this->response(array(
            'table' => $table,
            'chart' => array(
                'data' => array(),
                'categories' => array(),
            )
        ));
    }
    
    private function calStatsData($start, $end) {
        
    }
    
    function test() {
        $item = array();
        $item['percent'] = 0.8;
        $item['amount'] = 33;
        $item['guid'] = uniqid();
        $item['sub_title'] = null;
        $item['title'] = array(
            'url' => '',
            'name' => '产品开发',
        );
        
        return $item;
    }

    public function insertDB($item) {
        $db = $this->load->database('default', TRUE);

        $labels = array(
            '自我提高' => 2,
            '其他' => 3,
            '项目会议与沟通' => 4,
            '产品开发' => 5,
            '健身' => 6,
            '活动' => 7,
            '英语' => 8,
            'code review' => 9,
            '产品设计' => 10,
            '文档编写' => 11,
            '驾照' => 12,
        );

        $db->insert('cola_log', array(
            'start_time' => strtotime($item['startTime']) * 1000,
            'label_id' => $labels[$item['category']],
            'content' => $item['text'],
            'team_id' => '990de71f506043858c431e1ea41dc725',
            'create_time' => $item['startDate'],
            'duration' => intval($item['duration']),
            'guid' => uniqid(),
            'end_time' => strtotime($item['endTime']) * 1000,
            'start_t' => $item['startTime'],
            'end_t' => $item['endTime'],
        ));
        $db->close();
    }

}
