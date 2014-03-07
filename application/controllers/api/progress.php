<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/CUREST_Controller.php';
require APPPATH . '/third_party/ExpressiveDate.php';

class Progress extends CUREST_Controller {

    public $rest_format = 'json';

    public function list_get() {
        $inputParam = array('plan_id');
        $paramValues = $this->gets($inputParam);
        $plan_id = $paramValues['plan_id'];

        $page = $this->get('page');
        $count = $this->get('count');
        if (empty($page)) {
            $page = 0;
        }

        if (empty($count)) {
            $count = 10;
        }

        $db = $this->load->database('default', TRUE);
        $db->where('plan_id', $plan_id);
        $db->limit($count, $page * $count);
        $query = $db->get('progress');

        $db2 = $this->load->database('default', TRUE);
        $db2->where('plan_id', $plan_id);
        $queryCount = $db2->get('progress');

        $db->close();

        $this->response(array(
            'list' => $query->result_array(),
            'sum' => $queryCount->num_rows()
                )
        );
    }

    public function analysis_month_get()
    {
        $inputParam = array('plan_id');
        $paramValues = $this->gets($inputParam);
        
        $date = new ExpressiveDate();
        $startMonth = $date->startOfMonth()->getDate();
        $endMonth = $date->endOfMonth()->getDate();
        
        $db = $this->load->database('default', TRUE);
        $sql = "select * from progress where plan_id = ? AND created >= ? AND created <= ?";
        $query = $db->query($sql, 
                            array(
                                $paramValues['plan_id'], 
                                $startMonth, 
                                $endMonth
                            )
                 );
        $db->close();
        
        $result = $query->result_array();
        
        $this->response($result);
    }
    /**
     *  analysis
     * 
     */
    public function analysis_get() {
        $inputParam = array('type', 'plan_id');
        $paramValues = $this->gets($inputParam);

        $sql = null;
        switch ($paramValues['type']) {
            case 'week':
                $sql = "SELECT *,DATE_FORMAT(created, '%x年-%v周') as week, DATE_FORMAT(created, '%x_%v') as week_number ,sum(`cost_time_min`) as time
                FROM `progress` 
                where `plan_id` = ?
                group by week";
                break;

            default:
                break;
        }
        
        $db = $this->load->database('default', TRUE);
        $query = $db->query($sql, array($paramValues['plan_id']));
        $db->close();
        
        $result = $query->result_array();
        $timeLabels = array();
        foreach ($result as $item) {
            $timeLabels[] = $item['week'];
        }
        
        $container = array();
        for ($i = 1; $i <= 52; ++$i)
        {
            $item = sprintf('2013年-%d周', $i);
            
            if (!in_array($item, $timeLabels))
            {
                $container[] = array('time' => '0', 'week' => $item, 'name' => $item);
            }
            else
            {
                $key = array_search($item, $timeLabels);
                
                $result[$key]['name'] = $result[$key]['week'];
                
                $container[] = $result[$key];
            }
        }
        
        $this->responseArray($container);
    }

    public function add_post() {
        $inputParam = array('cost_time_min', 'plan_id');
        $paramValues = $this->posts($inputParam);

        $data = array(
            'created' => date('Y-m-d H:i:s'),
            'cost_time_min' => $paramValues['cost_time_min'],
            'plan_id' => $paramValues['plan_id']
        );

        $db = $this->load->database('default', TRUE);
        $bResult = $db->insert('progress', $data);
        $db->close();

        $this->responseBool($bResult);
    }

    /**
     * 
     * @params plan_id
     * @params time
     */
    public function evaluate_get() {
        $time = $this->get('time');
        //$time = "2013-12-31 23:59:59";
        $inputParam = array('plan_id');
        $paramValues = $this->gets($inputParam);

        $plan_id = $paramValues['plan_id'];

        $db2 = $this->load->database('default', TRUE);
        $db2->where('id', $plan_id);
        $query2 = $db2->get('plan');
        $db2->close();

        if ($query2->num_rows() == 0) {
            $this->responseError(400, 'plan_id not found');
        }

        $planInfo = $query2->row_array();
        $planCreateTime = $planInfo['created'];

        $date = new ExpressiveDate($time);
        $startMonth = $date->startOfMonth()->getDate();
        $endMonth = $date->endOfMonth()->getDateTime();
        
        $db = $this->load->database('default', TRUE);
        $sql = "select *, SUM(cost_time_min) as sum_time_min, count(id) as sum_day
            from progress 
            where plan_id = ? AND created >= ? AND created <= ?";
        $query = $db->query($sql, array($plan_id, $startMonth, $endMonth));
        $db->close();

        if ($startMonth <= $planCreateTime)
        {
            $startMonth = $planCreateTime;
        }
        
        $startMonthTimestamp = strtotime($startMonth);
        $timeBegin = $startMonthTimestamp;
        
        if (empty($time))
        {
            $finishtime = date('Y-m-d H:i:s');
        }
        else
        {
            $finishtime = $date->endOfMonth()->getDateTime();
        }
        
        $timeEnd = strtotime($finishtime);
        
        $diff = $timeEnd - $timeBegin;
        $time_day = $diff / (3600 * 24);

        $totalDays = round($time_day);
        $completeDays = $query->row()->sum_day;

        $planName = $planInfo['name'];
        $expectTime = $planInfo['expect_rate'] * $totalDays;

        $sumTime = $query->row()->sum_time_min;
        $sumTime /= 60;
        $sumTime = round($sumTime, 2);

        $expectTime = round($expectTime, 2);
        
        $planTotalTime = round($this->calSumTime($plan_id) / 60, 2);

        $currentMonthLabel = intval($date->getMonth());
        
        $html = "<html>
<p>计划名称:    $planName</p>
<p>创建时间:    $planCreateTime</p>
<p>总计时间:    $planTotalTime 小时</p> 
<p>$currentMonthLabel 月份完成天数:    $completeDays</p>
<p>$currentMonthLabel 月份总计天数:    $totalDays</p>
<p>$currentMonthLabel 月份总计时间:    $sumTime 小时</p>
</html>";

        $html2 = "
<p>计划名称:    $planName</p>
<p>创建时间:    $planCreateTime</p>
<p>总计时间:    $planTotalTime 小时</p> 
<p>$currentMonthLabel 月份总计时间:    $sumTime 小时</p>    
<p>$currentMonthLabel 月份期望时间:    $expectTime 天</p>
<p>$currentMonthLabel 月份完成天数:    $completeDays 天</p>
<p>$currentMonthLabel 月份总计天数:    $totalDays 天</p>";

        $this->response(array(
            'plan' => $planInfo,
            'total_days' => $totalDays,
            'complete_days' => $completeDays,
            'html' => $html,
            'html2' => $html2
        ));
    }

    private function calSumTime($plan_id) {
        $db = $this->load->database('default', TRUE);
        $sql = "select *, SUM(cost_time_min) as sum_time_min, count(id) as sum_day
            from progress 
            where plan_id = ?";
        $query = $db->query($sql, array($plan_id));
        $db->close();
        
        return $query->row()->sum_time_min;
    }

}