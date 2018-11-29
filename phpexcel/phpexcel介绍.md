PHPExcel工具类分成以下几个部分介绍：

1、第一个部分：介绍PHPExcel的属性设置

2、第二个部分：封装PHPExcel的工具类

 

第一部分：

PHPExcel常用属性使用

 前景：

　　需先实例化几个变量：

　　　　　　$this->objExcel = new PHPExcel();　　//实例化一个PHPExcel变量

　　　　　　　$this->objExcel->setActiveSheetIndex(0);　　//设置要操作的Sheet页

　　　　　　　$this->objActSheet = $this->objExcel->getActiveSheet();　　//获取当前要操作的Sheet页

　　　　　　　$objStyle = $this->objActSheet->getStyle('A1');　　//获取要设置单元格的样式，括号里的内容也可是：('A1:E1')

　　　　　　　$objAlign = $objStyle->getAlignment();　　//用来设置对齐属性和单元格内文本换行的一个变量

　　　　　　$objFont = $objStyle->getFont();　　//获得字体属性

 

　常用属性：

　　1、设置Sheet名称：

　　　　　 //设置当前活动sheet的名称
　　　　　　$this->objActSheet->setTitle($title);

　 　2、设置对齐和单元格内换行

　　　　2.1、水平对齐

　　　　　　//设置单元格内容水平对齐

　　　　　　$objAlign->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

　　　　　　说明：

　　　　　　　　水平对齐的变量有：PHPExcel_Style_Alignment::HORIZONTAL_LEFT、PHPExcel_Style_Alignment::HORIZONTAL_CENTER、PHPExcel_Style_Alignment::HORIZONTAL_RIGHT；

　　　　　　　　具体含义分别为：左对齐、居中对齐、右对齐。

　　　　　2.2、竖直对齐

　　　　　$objAlign->setVertical(PHPExcel_Style_Alignment::VERTICAL_TOP);

　　　　　　说明：

　　     　　　　竖直对齐的变量有：PHPExcel_Style_Alignment::VERTICAL_TOP、PHPExcel_Style_Alignment::VERTICAL_CENTER、PHPExcel_Style_Alignment::VERTICAL_BOTTOM

　　　　  　　　  具体含义分别为：顶部对齐、竖直居中对齐、底部对齐

　　　　　2.3、单元格内换行

　　　　　　$objAlign->setWrapText(true);

　　　　　　说明：

　　　　　　　　1、此举是为了实现单元格内可以手动指定换行的位置。只要指定的文本本身是换行的，或者插入换行符（'\n'）。

　　　　　　　　2、要换行的文字，外面必须是双引号

　　　　　　例如：

　　　　　　　　文本设置为：$arr['header'] = "哈哈\nHelloWorld";

　　　　　　　　显示的效果为：

　　　　　　　　　　　　　　哈哈
　　　　　　　　　　　　　　HelloWorld

　　3、设置字体、颜色等

　　　3.1、设置字体

　　　　　　$objFont->setName('微软雅黑' );　　//设置要使用的字体

　　　  3.2、设置字号

　　　　　　 $objFont->setSize( 11 );

  　　　3.3、设置加粗

　　　　　　$objFont->setBold( false );

　　　  3.4、设置字颜色

　　　　　  $objFont->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);　　

　　　　　说明：

　　　　　　　1、其颜色组成为：Alpha（透明度）通道+RGB色彩模式

　　　　　　　2、ARGB---Alpha,Red,Green,Blu

　　　　　　　3、一般我自己用的值都是"FF"+RGB的颜色值，如："FFCC15DD"

　　4、单元格设置：

　　　4.1、设置背景色　　

　　　　　　$objStyle->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
　　　　　　　$objStyle->getFill()->getStartColor()->setARGB('FF595959');

 

　　　4.2、设置宽度

　　　　　　$this->objActSheet->getColumnDimension($widthStr)->setWidth('27.45');

　　　4.3、设置高度

　　　　　　$this->objActSheet->getRowDimension($heightStr)->setRowHeight('27.45');

　　　4.4、单元格合并

　　　　　　$this->objActSheet->mergeCells('A1:I1');

　　　　　　　里面指定要合并的单元格范围

　　5、其他设置：

　　　5.1、设置自动筛选

　　　　　　$this->objActSheet->setAutoFilter("A2:B2");

　　　　　　　说明：

　　　　　　　　　当前笔者比较愚笨，还不能做到随意指定设置自动筛选的方法。

　　　5.2、单元格格式设置防止科学计数法　　　　　

　　　　　　　//设置单元格格式（防止科学技术法）
　　　　　　　$numberFormat = $objStyle->getNumberFormat();
　　　　　　　$numberFormat->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);

　　　　　　　说明：　　　　　　　　　

　　　　　　　　　读取的时候一定要用：getFormattedValue()，这样可以一定程度上减少读出科学计数法的数。虽然php有方法转换科学计数法，但是会遭遇精度丢失的情况。

　　　　　　　　　笔者现在最头疼的一个问题就是科学计数法，现在还未有非常好的解决方案，现在能解决的方法都不彻底。笔者会继续探索！　

　总结：

　　　基本属性设置作者自己的使用基本就是这些，其他的一些属性待笔者亲自验证后再补充！

　　　作者第一次在博客园记录下自己在项目中用到的知识，虽然很浅显，但是确能解决一部分Excel导出的问题，希望能对读者有所帮助！