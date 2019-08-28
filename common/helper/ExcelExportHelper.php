<?php
/**
 * 处理execl文件类
 * @time 2018-11-15 17:10
 * @author jackwang
 */

namespace app\common\helper;

class ExcelExportHelper
{
    private $cells = null;
    private $seq = 0;
    private $charset = 'UTF-8';
    private $font = '宋体';
    private $objExcel;
    private $objWriter;
    public  $objActSheet;

    public $objPHPExcel = '';//excel基础类
    public $objDrawing = '';//图表类
    public $title = '';
    public $fieldName = ['返利数据分析', '卡源毛利明细', '卡源毛利环比', '结算数据明细', '结算数据分析'];
    public $cellName = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R',
        'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL',
        'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ');

    //编码方式：gb2312
    public function __construct($title, $charset = 'utf-8')
    {
        \think\Loader::import('PHPExcel.PHPExcel', EXTEND_PATH);
        \think\Loader::import('PHPExcel.Reader.IOFactory', EXTEND_PATH);
        $this->objPHPExcel = new \PHPExcel();
        $objDrawing = new \PHPExcel_Worksheet_Drawing();

        $this->objExcel = new \PHPExcel();
        $this->objWriter = new \PHPExcel_Writer_Excel5($this->objExcel);//非2007格式
        //$this->objWriter = new PHPExcel_Writer_Excel2007($objExcel);//2007格式
        //$this->objWriter->setOffice2003Compatibility(true);
        $this->objExcel->setActiveSheetIndex(0);

        $this->objActSheet = $this->objExcel->getActiveSheet();

        //设置当前活动sheet的名称
        $this->objActSheet->setTitle($title);

        if($charset != '')
        {
            $this->charset = $charset;
        }
        $outputFileName = iconv("UTF-8", $this->charset, $title.".xls");

        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition:inline;filename="'.$outputFileName.'"');
        header("Content-Transfer-Encoding: binary");
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
   /*     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');//2007格式
        header('Content-Type: application/vnd.ms-excel');//非2007格式*/
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: no-cache");
    }

    /**
     * NAME: handleMultiArr 处理三维数组导出 ， 并且区分图表和列表
     * 区分方法：图表x轴key值 例如本次为时间time，会判定是否存在timeKey
     */
    public function handleMultiArr($title = array(), array $data, $fileName = '', $savePath = './', $isDown = false)
    {
        $this->title = $title;
        $dataSource = [['1', '2'], ['3', '4'], ['5', ''], ['6'], ['singlePriceG', 'settChangeTrend']];
        foreach ($data as $key => $value) {
            foreach ($value as $k => $v) {
                if (array_key_exists('time', $v)) {
                    $this->exportChart($key, $v);
                } else {
                    //TODO 插入数据列的首行title
                    $this->exportList($key, $v);
                }
            }
        }

        if (!$fileName) {
            $fileName = uniqid(time(), true);
        }
        $objWrite = \PHPExcel_IOFactory::createWriter($this->objPHPExcel, 'Excel2007');
        if ($isDown) {   //网页下载
            header('pragma:public');
            header("Content-Disposition:attachment;filename=$fileName.xls");
            $objWrite->save('php://output');
            exit;
        }
        $_fileName = iconv("utf-8", "gb2312", $fileName);   //转码
        $_savePath = $savePath . $_fileName . '.xlsx';
        $objWrite->save($_savePath);
        return $savePath . $fileName . '.xlsx';
    }

    /**
     * 仅仅设置内容
     * @param $col_arr 要设置的数组
     */
    public function setExcelVal($arr,$colKeyArr,$order=1)
    {
        $rowNum = 0;
        foreach ($arr as $key => $value){
            $k = 0;
            //设置头部分
            if($key == 'header' && $order){
                $rowNum ++;
                $col = chr(65+$k);
                $this->objActSheet->setCellValue("$col$rowNum", $value);
            }

            //设置标题部分
            if($key == 'title'){
                $rowNum ++;
                //遍历设置标题部分
                foreach ($value as $valueSecond){
                    $col = chr(65+$k);
                    if(isset($value[$colKeyArr[$k]])){
                        $this->objActSheet->setCellValue("$col$rowNum", $value[$colKeyArr[$k]]);
                    }                    
                    $k++;
                }
            }

            //设置数据部分
            if($key == 'data'){
                //遍历设置标题部分
                foreach ($value as $valueSecond){
                    $rowNum ++;
                    $k = 0;
                    //遍历设置标题部分
                    foreach ($valueSecond as $valueThird){
                        $col = chr(65+$k);
                        //性别要特殊处理
                        if(isset($colKeyArr[$k]) && $colKeyArr[$k] == 'stdSex'){
                            if($valueSecond[$colKeyArr[$k]] == 0){
                                $this->objActSheet->setCellValue("$col$rowNum", '女');
                            }else{
                                $this->objActSheet->setCellValue("$col$rowNum", '男');
                            }
                        }else{
                            if(isset($colKeyArr[$k]) && isset($valueSecond[$colKeyArr[$k]])){
                                $this->objActSheet->setCellValue("$col$rowNum", $valueSecond[$colKeyArr[$k]]);
                            }                            
                        }
                        $k++;
                    }
                }
            }

        }
    }

    /**
     * 仅仅设置样式
     * @param $col_style 要设置的数组
     *         key值：
     *             'cell_str'  ：要设置的 单元格定位
     *             'cell_style'：放置的样式数组
     *
     */
    public function setCellStyle($col_style){

        $objStyle = $this->objActSheet->getStyle($col_style['cell_str']);

        //如果样式数组为空，则直接返回
        //$cell现在为单元格样式变量
        $cell = $col_style['cell_style'];
        if(empty($cell)){
            return ;
        }

        //水平位置设置
        $objAlign = $objStyle->getAlignment();
        if(!empty($cell['align'])){
            switch($cell['align']){
                case 'left':
                    $objAlign->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    break;
                case 'center':
                    $objAlign->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    break;
                case 'right':
                    $objAlign->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    break;
                default:
                    $objAlign->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    break;
            }
            //$objActSheet->getColumnDimension("$col1$col2")->setAutoSize(true);
        }
        //竖直位置设置
        if(!empty($cell['valign'])){
            switch($cell['valign']){
                case 'top':
                    $objAlign->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
                    break;
                case 'center':
                    $objAlign->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    break;
                case 'bottom':
                    $objAlign->setVertical(\PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
                    break;
                default:
                    $objAlign->setHorizontal(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    break;
            }
            //$objActSheet->getColumnDimension("$col1$col2")->setAutoSize(true);
        }
        //单元格内换行
        if(!empty($cell['wrap-text'])){
            $objAlign->setWrapText(true);
        }

        /****************字体设置****************/
        //获得字体属性
        $objFont = $objStyle->getFont();

        //设置字体
        isset($cell['family'])?$objFont->setName($cell['family'] ):$objFont->setName('微软雅黑' );
        //设置字号
        isset($cell['font-size'])?$objFont->setSize($cell['font-size'] ):$objFont->setSize( 11 );
        //设置加粗
        isset($cell['bold'])?$objFont->setBold($cell['bold'] ):$objFont->setBold( false );
        //设置字颜色
        isset($cell['font-color'])?$objFont->getColor()->setARGB($cell['font-color']):$objFont->getColor()->setARGB(\PHPExcel_Style_Color::COLOR_WHITE);

        //设置背景色
        if(isset($cell['background-color'])){
            $objStyle->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID);
            $objStyle->getFill()->getStartColor()->setARGB($cell['background-color']);
        }

        //取A1中的A和1
        $widthStr = substr($col_style['cell_str'],0,1);
        $heightStr = substr($col_style['cell_str'],1);

        //宽度设置
        if(!empty($cell['width'])){
            $this->objActSheet->getColumnDimension($widthStr)->setWidth($cell['width']);
        }

        //高度设置
        if(!empty($cell['height'])){
            $this->objActSheet->getRowDimension($heightStr)->setRowHeight($cell['height']);
        }
        //列合并
        if(!empty($cell['colspan'])){
            $this->objActSheet->mergeCells($cell['colspan']);
        }
        //行合并
        if(!empty($cell['rowspan'])){
            $this->objActSheet->mergeCells($cell['rowspan']);
        }
    }

    /**
     * 设置默认Excel样式
     */
    public function setExcelDefaultStyle($auto = true){

        //获取默认样式
        $objStyle = $this->objActSheet->getDefaultStyle();

        //设置默认对齐方式
        $objAlign = $this->objActSheet->getDefaultStyle()->getAlignment();
        $objAlign->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objAlign->setVertical(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
        //设置默认字体
        $objFont = $objStyle->getFont();

        //设置字体
        $objFont->setName('宋体' );
        //设置字号
        $objFont->setSize( 11 );
        //设置加粗
        $objFont->setBold( false );
        //设置字颜色
        $objFont->getColor()->setARGB(\PHPExcel_Style_Color::COLOR_BLACK);

        //设置自动筛选
        if($auto)$this->objActSheet->setAutoFilter("A2:B2");
//         $this->objActSheet->setAutoFilter("E2:E2");
//         $this->objActSheet->setAutoFilterByColumnAndRow();

        //设置单元格格式（防止科学技术法）
        $numberFormat = $objStyle->getNumberFormat();
        $numberFormat->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

    }

    /**
     * 输出Excel
     */
    public function save($title = '设备明细')
    {
        ob_end_clean(); //清除缓冲区,避免乱码
        header('Content-Type: application/vnd.ms-excel,charset=UFT-8');
        header('Content-Disposition: attachment;filename="'.$title.'.xls"');
        header('Cache-Control: max-age=0');
        $this->objWriter->save('php://output');
    }

    public function exportChart($key, $data)
    {
        $sheet_title = $this->fieldName[$key];//sheetName
        $time = $data['time']; unset($data['time']);//分离x,y轴
        $columnID = $this->cellName[$key];
        $objSheet = $this->objPHPExcel->getActiveSheet();
        $objSheet->fromArray($data);
    }

    public function exportList($key, $data)
    {
        $this->objPHPExcel->getActiveSheet($key)->setTitle($this->fieldName[$key]);   //设置sheet名称

        $_row = 1;   //设置纵向单元格标识

        if ($this->title) {
            $_cnt = count($this->title);
            $this->objPHPExcel->getActiveSheet($key)->mergeCells('A' . $_row . ':' . $this->cellName[$_cnt - 1] . $_row);   //合并单元格
            $this->objPHPExcel->setActiveSheetIndex($key)->setCellValue('A' . $_row, '数据导出：' . date('Y-m-d H:i:s'));  //设置合并后的单元格内容
            $_row++;
            $i = 0;
            foreach ($this->title AS $v) {   //设置列标题
                $this->objPHPExcel->setActiveSheetIndex($key)->setCellValue($this->cellName[$i] . $_row, $v);
                $i++;
            }
            $_row++;
        }
        //填写数据
        if ($data) {
            $i = 0;
            foreach ($data as $_v) {
                $j = 0;
                foreach ($_v as $_cell) {
                    $this->objPHPExcel->getActiveSheet($key)->setCellValue($this->cellName[$j] . ($i + $_row), $_cell);
                    $j++;
                }
                $i++;
            }
        }
    }

    /*
     * $this->browser_export($excel,"browser_chart.xlsx"); //浏览器输出
     * $this->SaveViaTempFile($objWriter);
     *
     */
    function browser_export($type, $filename)
    {
        if ($type == "Excel5") {
            header('Content-Type: application/vnd.ms-excel'); //excel2003
        } else {
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'); //excel2007
        }
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
    }

    /*解决Excel2007不能导出*/
    function SaveViaTempFile($objWriter)
    {
        $filePath = dirname(__FILE__) . rand(0, getrandmax()) . rand(0, getrandmax()) . ".tmp";
        $objWriter->save($filePath);
        readfile($filePath);
        unlink($filePath);
    }
}
