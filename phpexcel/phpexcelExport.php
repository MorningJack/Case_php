
########### Excel导出工具类　 ###########
/**
 * 导出工具类
 *
 * @package util
 * @category util
 * @link /util/ExcelExportUtil.php
 * @author mingwang3
 * @version 1.0
 * @created 2014-8-18 13:19:00
 */
// PHPExcel
require_once ( INCLUDE_PATH . "/PHPExcel.php" );
require_once ( INCLUDE_PATH . "/PHPExcel/Writer/Excel5.php" );

class ExcelExportUtil
{
    private $cells = null;
    private $seq = 0;
    private $charset = 'gb2312';
    private $font = '宋体';
    private $objExcel;
    private $objWriter;
    private $objActSheet;

    //编码方式：gb2312
    public function __construct($title, $charset = 'utf-8')
    {
        $this->objExcel = new PHPExcel();
        $this->objWriter = new PHPExcel_Writer_Excel5($this->objExcel);//非2007格式
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
        //header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');//2007格式
        //header('Content-Type: application/vnd.ms-excel');//非2007格式
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header('Content-Disposition:inline;filename="'.$outputFileName.'"');
        header("Content-Transfer-Encoding: binary");
        header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
        header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Pragma: no-cache");
    }

    /**
     * 仅仅设置内容
     * @param $col_arr 要设置的数组
     */
    public function setExcelVal($arr,$colKeyArr)
    {
        $rowNum = 0;
        foreach ($arr as $key => $value){
            $k = 0;
            //设置头部分
            if($key == 'header'){
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
//                     dump($colKeyArr[$k]);
//                     die; 
                    $this->objActSheet->setCellValue("$col$rowNum", $value[$colKeyArr[$k]]);
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
                        if($colKeyArr[$k] == 'stdSex'){
                            if($valueSecond[$colKeyArr[$k]] == 0){
                                $this->objActSheet->setCellValue("$col$rowNum", '女');
                            }else{
                                $this->objActSheet->setCellValue("$col$rowNum", '男');
                            }
                        }else{
                            $this->objActSheet->setCellValue("$col$rowNum", $valueSecond[$colKeyArr[$k]]);
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
                    $objAlign->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    break;
                case 'center':
                    $objAlign->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    break;
                case 'right':
                    $objAlign->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    break;
                default:
                    $objAlign->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    break;
            }
            //$objActSheet->getColumnDimension("$col1$col2")->setAutoSize(true);
        }
        //竖直位置设置
        if(!empty($cell['valign'])){
            switch($cell['valign']){
                case 'top':
                    $objAlign->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);
                    break;
                case 'center':
                    $objAlign->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
                    break;
                case 'bottom':
                    $objAlign->setVertical(PHPExcel_Style_Alignment::VERTICAL_BOTTOM);
                    break;
                default:
                    $objAlign->setHorizontal(PHPExcel_Style_Alignment::VERTICAL_CENTER);
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
        isset($cell['font-color'])?$objFont->getColor()->setARGB($cell['font-color']):$objFont->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
        
        //设置背景色
        if(isset($cell['background-color'])){
            $objStyle->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
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
    public function setExcelDefaultStyle(){
        
        //获取默认样式
        $objStyle = $this->objActSheet->getDefaultStyle();
        
        //设置默认对齐方式
        $objAlign = $this->objActSheet->getDefaultStyle()->getAlignment();
        $objAlign->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objAlign->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
        //设置默认字体
        $objFont = $objStyle->getFont();
        
        //设置字体
        $objFont->setName('宋体' );
        //设置字号
        $objFont->setSize( 11 );
        //设置加粗
        $objFont->setBold( false );
        //设置字颜色
        $objFont->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
        
        //设置自动筛选
        $this->objActSheet->setAutoFilter("A2:B2");
//         $this->objActSheet->setAutoFilter("E2:E2");
//         $this->objActSheet->setAutoFilterByColumnAndRow();

        //设置单元格格式（防止科学技术法）
        $numberFormat = $objStyle->getNumberFormat();
        $numberFormat->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
        
    }

    /**
     * 输出Excel
     */
    public function save()
    {
        $this->objWriter->save('php://output');
    }
}

###########  调用方法

/**
     * 导出学生数据
     * @param Array $result 要导出的数据
     */
    public function exportStudentDataToExcel( $result ){
        
        //设置标题
        $arr['header'] = "哈哈\nHelloWorld";
        
        //设置标题
        $arr['title'] = array(
                'stdCode'=>'学籍号',
                'stdName'=>'姓名',
                'stdSex'=>'性别',
                'semName'=>'学期',
                'gradeName'=>'年级',
                'classNoName'=>'班级',
                'stdMobile'=>'联系方式',
                'loginName'=>'登录名',
                'password'=>'登录密码',
        
        );
        //设置key值列
        $colKeyArr = array('semName','gradeName','classNoName',
                'stdCode','stdName','loginName','password');
        //设置数据列
        $arr['data'] = $result;
        
        $excel = new ExcelExportUtil('学生账户');
        //设置默认样式
        $excel->setExcelDefaultStyle();
        //设置值
        $excel->setExcelVal($arr , $colKeyArr );
        
        //设置样式
        $col_style = $this->getStudentCellStyle();
        foreach($col_style as $val){
            $excel->setCellStyle($val);
        }
        //保存Excel
        $excel->save();
    }

############ 设置值的数据格式样子
Array
(
    [header] => 哈哈
HelloWorld
    [title] => Array
        (
            [stdCode] => 学籍号
            [stdName] => 姓名
            [stdSex] => 性别
            [semName] => 学期
            [gradeName] => 年级
            [classNoName] => 班级
            [stdMobile] => 联系方式
            [loginName] => 登录名
            [password] => 登录密码
        )

    [data] => Array
        (
            [0] => Array
                (
                    [classId] => 1
                    [classNoName] => 1班（老区）
                    [glId] => 1
                    [glName] => 小学
                    [gradeId] => 14
                    [gradeName] => 小学四年级
                    [loginName] => zxr11
                    [password] => xgsc26
                    [semId] => 10
                    [semName] => 2013-2014第二学期
                    [stdCode] => 3401041000120020
                    [stdId] => 11
                    [stdMobile] => 
                    [stdName] => 周晓冉
                    [stdSex] => 
                )

            [1] => Array
                (
                    [classId] => 1
                    [classNoName] => 1班（老区）
                    [glId] => 1
                    [glName] => 小学
                    [gradeId] => 14
                    [gradeName] => 小学四年级
                    [loginName] => hyx12
                    [password] => xgsc26
                    [semId] => 10
                    [semName] => 2013-2014第二学期
                    [stdCode] => 3401041000120024
                    [stdId] => 12
                    [stdMobile] => 
                    [stdName] => 胡远晰
                    [stdSex] => 
                )

            [2] => Array
                (
                    [classId] => 1
                    [classNoName] => 1班（老区）
                    [glId] => 1
                    [glName] => 小学
                    [gradeId] => 14
                    [gradeName] => 小学四年级
                    [loginName] => qkh13
                    [password] => xgsc26
                    [semId] => 10
                    [semName] => 2013-2014第二学期
                    [stdCode] => 3401041000120028
                    [stdId] => 13
                    [stdMobile] => 
                    [stdName] => 祁克涵
                    [stdSex] => 
                )            

        )

)


############  样式设置
/**
     * 获得样式数组
     * @return Array 返回一个样式数组
     */
    private function getStudentCellStyle(){
        //样式数组
        $col_style[] =array(
                'cell_str'=>'A1',
                'cell_style'=>array(
                        'font-size'=>11,
                        'family'=>'宋体',
                        //                        'background-color'=>'FF595959',
                        'font-color'=>'FFFF0000',
                        'colspan'=>"A1:I1",
                        'height'=>'75',
                        'align'=>'left',
                        'valign'=>'top',
                        'wrap-text'=>true,
                )
        ); 
    
        //样式数组
        $col_style[] =array(
                'cell_str'=>'A1:G1',
                'cell_style'=>array(
                        'font-size'=>11,
                        'bord'=>true,
                        'family'=>'微软雅黑',
                        'background-color'=>'FF595959',
                        'font-color'=>'FFFFFFFF',
                        'align'=>'center',
                        'bold'=>'true',
                )
        );
        /* $col_style[] =array(
                'cell_str'=>'F2:H2',
                'cell_style'=>array(
                        'background-color'=>'FFBFBFBF',
                )
        ); */
        $col_style[] =array(
                'cell_str'=>'A',
                'cell_style'=>array(
                        'width'=>'27.45',
                )
        );
        $col_style[] =array(
                'cell_str'=>'B',
                'cell_style'=>array(
                        'width'=>'15.73',
                )
        );
        $col_style[] =array(
                'cell_str'=>'C',
                'cell_style'=>array(
                        'width'=>'17.45',
                )
        );
        $col_style[] =array(
                'cell_str'=>'D',
                'cell_style'=>array(
                        'width'=>'25.38',
                )
        );
        $col_style[] =array(
                'cell_str'=>'E',
                'cell_style'=>array(
                        'width'=>'16.63',
                )
        );
        $col_style[] =array(
                'cell_str'=>'F',
                'cell_style'=>array(
                        'width'=>'16.63',
                )
        );
        $col_style[] =array(
                'cell_str'=>'G',
                'cell_style'=>array(
                        'width'=>'16.63',
                )
        );
        return $col_style;
    }

