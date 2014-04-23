<?php

defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * @author      studentdeng 
 * @link        <studentdeng.github.com> 
 * @datetime    Apr 20, 2014 
 */
require APPPATH . '/libraries/CUREST_Controller.php';

class Worklog extends CUREST_Controller {

    public function list_post() {
        $inputParam = array('data');
        $paramValues = $this->posts($inputParam);
        $data = $paramValues["data"];
        $dataParam = json_decode($data, TRUE);
        $start = $dataParam['start'];
        $end = $dataParam['end'];


        $db = $this->load->database('default', TRUE);
        $sql = "select * from cola_log where start_time >= ? AND end_time <= ? ORDER BY start_time";
        $query = $db->query($sql, array($start, $end));
        $db->close();
        $result = $query->result_array();

        $resultData = array();

        $begin = $start;
        for ($i = 0; $i < 7; $i++) {
            $resultData[$begin] = array();
            $begin += 1000 * 3600 * 24;
        }

        foreach ($result as $item) { {
                $dbS = $this->load->database('default', TRUE);
                $dbS->where('id', $item['label_id']);
                $queryS = $dbS->get('cola_label');
                $dbS->close();

                $resultS = $queryS->row_array();
                $resultS['id'] = intval($resultS['id']);
                $resultS['status'] = intval($resultS['status']);
                $resultS['priority'] = intval($resultS['priority']);

                $label = $resultS;
            }

            $item['labels'] = array($label);
            $item['end_time'] = intval($item['end_time']);
            $item['start_time'] = intval($item['start_time']);
            $item['duration'] = intval($item['duration']);
            $item['id'] = intval($item['id']);

            $time = date('Y-m-d', $item['start_time'] / 1000);
            $time = strtotime($time) * 1000;

            $resultData["$time"][] = $item;
        }

        $this->response(array(
            'worklogs' => $resultData,
            'success' => TRUE,
            'end' => TRUE,
        ));
    }

    public function add_post() {
        $inputParam = array('data');
        $paramValues = $this->posts($inputParam);

        $data = $paramValues["data"];

        $dataParam = json_decode($data, TRUE);

        $content = $dataParam['content'];
        $teamId = $dataParam['team'];
        $labelGuid = $dataParam['labels'][0];
        $start = $dataParam['start'];
        $end = $dataParam['end'];
        {
            $dbS = $this->load->database('default', TRUE);
            $dbS->where('guid', $labelGuid);
            $queryS = $dbS->get('cola_label');
            $dbS->close();

            $resultS = $queryS->row_array();
            $labelId = $resultS['id'];
        }

        $db = $this->load->database('default', TRUE);
        $db->insert('cola_log', array(
            'start_t' => date('Y-m-d H:i:s', $start / 1000),
            'start_time' => $start,
            'end_t' => date('Y-m-d H:i:s', $end / 1000),
            'end_time' => $end,
            'label_id' => $labelId,
            'content' => $content,
            'team_id' => $teamId,
            'create_time' => date('Y-m-d H:i:s'),
            'duration' => ($end - $start) / 1000,
            'guid' => uniqid(),
        ));

        $insertId = $db->insert_id();
        $db->close();

        $dbL = $this->load->database('default', TRUE);
        $dbL->where('id', $insertId);
        $queryL = $dbL->get('cola_log');
        $dbL->close();

        $result = $queryL->row_array();
        $result['labels'] = array($resultS);

        $this->response(array('worklog' => $result, 'success' => TRUE));
    }

    public function update_post() {
        $inputParam = array('data');
        $paramValues = $this->posts($inputParam);

        $data = $paramValues["data"];

        $dataParam = json_decode($data, TRUE);

        $content = $dataParam['content'];
        $teamId = $dataParam['team'];
        $labelGuid = $dataParam['labels'][0];
        $start = $dataParam['start'];

        $updateGuid = $dataParam['guid'];

        $end = $dataParam['end'];
        {
            $dbS = $this->load->database('default', TRUE);
            $dbS->where('guid', $labelGuid);
            $queryS = $dbS->get('cola_label');
            $dbS->close();

            $resultS = $queryS->row_array();
            $labelId = $resultS['id'];
        }

        $db = $this->load->database('default', TRUE);
        $db->where('guid', $updateGuid);
        $db->update('cola_log', array(
            'start_t' => date('Y-m-d H:i:s', $start / 1000),
            'start_time' => $start,
            'end_t' => date('Y-m-d H:i:s', $end / 1000),
            'end_time' => $end,
            'label_id' => $labelId,
            'content' => $content,
            'team_id' => $teamId,
            'create_time' => date('Y-m-d H:i:s'),
            'duration' => ($end - $start) / 1000,
            'guid' => uniqid(),
        ));

        $db->close();

        $dbL = $this->load->database('default', TRUE);
        $dbL->where('guid', $updateGuid);
        $queryL = $dbL->get('cola_log');
        $dbL->close();

        $result = $queryL->row_array();
        $result['labels'] = array($resultS);

        $this->response(array('worklog' => $result, 'success' => TRUE));
    }

    public function delete_post() {

        $inputParam = array('data');
        $paramValues = $this->posts($inputParam);

        $data = $paramValues["data"];

        $dataParam = json_decode($data, TRUE);
        $updateGuid = $dataParam['guid'];
        
        $db = $this->load->database('default', TRUE);
        $db->where('guid', $updateGuid);
        $db->delete('cola_log');
        $this->response(array('success' => TRUE));
    }

    public function database_get() {

        $file_handle = fopen(dirname(__FILE__) . '/mac.csv', "r");

        $result = array();
        while (!feof($file_handle)) {

            $line_of_text = fgetcsv($file_handle, 1024 * 20);

            $startDate = $line_of_text[0];
            $startTime = $line_of_text[1];
            $endTime = $line_of_text[2];
            $duration = $line_of_text[3];
            $name = $line_of_text[4];
            $text = $line_of_text[5];
            $category = $line_of_text[6];

            if ($startDate == '日期') {
                continue;
            }

            $item['startDate'] = $startDate;
            $item['startTime'] = $startTime;
            $item['endTime'] = $endTime;
            $item['duration'] = $duration;
            $item['text'] = $text;
            $item['category'] = $category;

            $result[] = $item;

            $this->insertDB($item);
        }

        fclose($file_handle);

        $this->response($result);
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
