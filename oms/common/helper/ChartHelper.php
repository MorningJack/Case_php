<?php
/**
 * Created by PhpStorm.
 * User: 1455
 * Date: 2018/11/13
 * Time: 14:36
 */

namespace app\common\helper;

/*
 * 图表统计助手
 */
class ChartHelper
{
    private $times = [];
    private $rows = [];

    /*
     * @Param $data 1. 数据
     * @Param $date 2. 时间
     */
    public function __construct(array $data, array $date = [])
    {
        $this->makeDefaultDate($date);
        $this->rows = $data;
    }


    protected function makeDefaultDate($date)
    {
        if ((!isset($date['startTime']) || !isset($date['endTime']))
            && (empty($date['startTime']) || empty($date['startTime']))) {
            $date['startTime'] = date('Y-m-d', strtotime('-7 day'));
            $date['endTime'] = date('Y-m-d', time());
        }
        $dateUnit = dateUnit(dateDiff($date['startTime'], $date['endTime'], 0));
        $this->times = dateArray($dateUnit, $date['startTime'], $date['endTime']);
    }

    /**
     * NAME: getChartCount-- 适用【折线，柱状】
     * import:['array1' => [2018-10-11 => 11 , 2018-10-12 =>12] ,
     * 'array2' =>[2018-10-11 => 11]]
     * export:[times => [2018-10-22 , 2018-10-23] , rows => ['field1' => [11,22] , field2 => [22,33]]]
     */
    public function typeOneOfChart()
    {
        /*
         * 1.日期格式
         * 2. 数据验证
         */
        $sum = $this->rows;
        $dateArray = $this->times;
        $data = [];
        $info = [];
        $row = [];
        foreach ($sum as $sk => $sv) {
            if (empty($sv)) {
                $i = 0;
                foreach ($dateArray as $dv) {
                    $row[$sk][$i] = 0;
                    foreach ($sv as $rrv) {
                        if ($rrv['datetime'] == $dv) {
                            $row[$sk][$i] = $rrv['count'];
                        }
                    }
                    $i++;
                }
            } else {
                foreach ($sv as $k => $v) {
                    $info[$sk][] = $v->getData();
                    $i = 0;
                    foreach ($dateArray as $dv) {
                        $row[$sk][$i] = 0;
                        foreach ($sv as $rrv) {
                            if ($rrv['datetime'] == $dv) {
                                $row[$sk][$i] = $rrv['count'];
                            }
                        }
                        $i++;
                    }
                }
            }
        }
        $data['rows'] = $row;
        $data['times'] = $dateArray;
        return $data;
    }

    /**
     * NAME: typeTwoOfChart -- 适用【折线，柱状】
     * import:[['datetime' => 2018-10-22 , field1 => 11 , field2 => 22]
     *  , ['datetime' => 2018-10-23 , field2 => 22 , field2 => 33]]
     * export:[times => [2018-10-22 , 2018-10-23] , rows => ['field1' => [11,22] , field2 => [22,33]]]
     */
    public function typeTwoOfChart()
    {
        $sum = $this->rows;
        $array = [];
        $dateArray = $this->times;
        if(empty($sum)){
            foreach ($dateArray as $datek => $datev) {
                $array[$datek] = 0;
            }
        }else{
            foreach ($sum as $key => $value) {
                $date = $value['datetime'];
                if (isset($value['datetime'])) unset($value['datetime']);
                foreach ($value as $k => $v) {
                    $i = 0;
                    foreach ($dateArray as $dv) {
                        if (!isset($array[$k][$i])) $array[$k][$i] = 0;
                        if ($date == $dv) {
                            $array[$k][$i] = $v;
                        }
                        $i++;
                    }
                }
            }
        }
        $data['rows'] = $array;
        $data['times'] = $dateArray;
        return $data;
    }
}