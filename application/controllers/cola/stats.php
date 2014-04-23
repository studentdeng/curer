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
        
        $this->load->model('Label_model');

        $inputParam = array('data');
        $paramValues = $this->posts($inputParam);

        $data = $paramValues["data"];

        $dataParam = json_decode($data, TRUE);

        $start = $dataParam['start'];
        $end = $dataParam['end'];

        $this->response(array(
            'table' => $this->calStatsTable($start, $end),
            'chart' => $this->calStatsData($start, $end),
        ));
    }

    private function calStatsData($start, $end) {

        $db = $this->load->database('default', TRUE);
        $sql = "SELECT * FROM `cola_log` WHERE start_time >= ? AND end_time <= ? order by start_time";
        
        $query = $db->query($sql, array($start, $end));
        $db->close();
        $result = $query->result_array();

        $dataDic = array();
        foreach ($result as $value) {
            $key = date('n月d日', $value['start_time'] / 1000);
            if (empty($dataDic[$key]))
            {
                $dataDic[$key] = 0;
            }
            
            $dataDic[$key] += floatval($value['duration']);
        }

        foreach ($dataDic as $key => $value) {
            $data[] = $value;
            $categories[] = $key;
        }
        
        return array(
            'data' => $data,
            'categories' => $categories,
        );
    }

    function calStatsTable($start, $end) {

        $db = $this->load->database('default', TRUE);
        $sql = "SELECT *, sum(`duration`) as amount FROM `cola_log` WHERE start_time >= ? AND end_time <= ?  group by label_id order by amount desc";
        $query = $db->query($sql, array($start, $end));
        $db->close();
        $result = $query->result_array();
        
        $sumDuration = 0;
        foreach ($result as $value) {
            $sumDuration += $value['amount'];
        }
        
        if ($sumDuration == 0)
        {
            return;
        }

        $data = array();
        foreach ($result as $value) {

            $label = $this->Label_model->findLabelWithId($value['label_id']);
            
            $item = array();
            $item['percent'] = $value['amount'] / $sumDuration;
            $item['amount'] = floatval($value['amount']) * 3600;
            $item['guid'] = uniqid();
            $item['sub_title'] = null;
            $item['title'] = array(
                array(
                'url' => 'http://www.baidu.com',
                'name' => $label['name'],
            )
            );
            
            $data[] = $item;
        }

        return $data;
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
