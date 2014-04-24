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
            
            $dataDic[$key] += $value['duration'] / 3600;
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
            $sumDuration += intval($value['amount']);
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
            $item['amount'] = intval($value['amount']);
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
}
