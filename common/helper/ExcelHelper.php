<?php
/**
 * 处理execl文件类
 * @time 2018-11-15 17:10
 * @author jackwamg
 */

namespace app\common\helper;

class ExcelHelper
{
    public function __construct()
    {
        \think\Loader::import('PHPExcel.PHPExcel', EXTEND_PATH);
        \think\Loader::import('PHPExcel.Reader.IOFactory', EXTEND_PATH);
    }

    /**
     * NAME: inputExcel excel 导入
     * @param $path '文件地址'
     * @param $highestColumnMax '最高行'
     * @param $highestRowMax '最高行'
     * @return array
     */
    public function inputExcel($path, $highestColumnMax, $highestRowMax = 1000)
    {
        $aryStr = explode(".", $path);
        $fileType = strtolower($aryStr[count($aryStr) - 1]);
        if ($fileType == 'xlsx') {
            \think\Loader::import('PHPExcel.Reader.Excel2007', EXTEND_PATH);
            $objReader = new \PHPExcel_Reader_Excel2007();
        } else if ($fileType == 'xls') {
            \think\Loader::import('PHPExcel.Reader.Excel5', EXTEND_PATH);
            $objReader = new \PHPExcel_Reader_Excel5();
        } else {
            ajax_info(1, '文件错误');
        }
        $objReader->setReadDataOnly(true);
        $objPHPExcel = $objReader->load($path);
        $sheet = $objPHPExcel->getSheet(0);
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        if ($highestRow > $highestRowMax) ajax_info(1, "一次最多导入".$highestRowMax."行");
        if ($highestColumn != $highestColumnMax) ajax_info(1, "模板有误");
        $data = $objPHPExcel->getActiveSheet()->toArray();
        return $data;
    }

    /**
     * NAME: inputDataTokV 将excel内容变成可直接插入的数据
     * $keyArr 对应的数据库字段名
     */
   public function inputDataTokV($fileName, $keyArr)
    {
        $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        $obj_PHPExcel = $objReader->load($fileName, $encode = 'utf-8');  //加载文件内容,编码utf-8
        $excel_array = $obj_PHPExcel->getsheet(0)->toArray();   //转换为数组格式
        array_shift($excel_array);  //删除第一个数组(标题);
        $data = array();
        $invalid = array();
        foreach ($excel_array as $k => $v) {
            $i = 0;
            $flag = false;
            foreach ($keyArr as $key => $value) {
                switch ($key) {
                    case 'unique':
                        $data[$k][$value] =
                            implode(',', array_unique(explode(',', $v[$i])));
                        break;
                    case 'require':
                        $data[$k][$value] = $v[$i];
                        if (!trim($data[$k][$value])) {
                            $flag = true;
                        }
                        break;
                    default:
                        $data[$k][$value] = $v[$i];
                        break;
                }
                $i++;
            }
            if ($flag) {
                $invalid[] = $data[$k];
                unset($data[$k]);
            }
        }

        return ['valid' => $data,'invalid' => $invalid];
    }
}
