<?php
// Include the main TCPDF library (search for installation path).
require_once('TCPDF/tcpdf.php');
include("function.php");
ob_end_clean();
// Extend the TCPDF class to create custom Header and Footer
// 自訂頁首與頁尾
class MYPDF extends TCPDF
{
    //Page header
    public function Header()
    {
        // Set font
        $this->SetFont('msungstdlight', '', 10);

        // 公司與報表名稱
        $title = '
<h4 style="font-size: 20pt; font-weight: normal; text-align: center;">XXX公司</h4>

<table>
    <tr>
        <td style="width: 30%;"></td>
        <td style="border-bottom: 2px solid black; font-size: 20pt; font-weight: normal; text-align: center; width: 40%;">銷售資料</td>
        <td style="width: 30%;"></td>
    </tr>
    <tr>
        <td colspan="3"></td>
    </tr>
</table>';


        /**
         * 標題欄位
         *
         * 所有欄位的 width 設定值均與「資料欄位」互相對應，除第一個 <td> width 須向左偏移 5px，才能讓後續所有「標題欄位」與「資料欄位」切齊
         * 最後一個 <td> 必須設定 width: auto;，才能將剩餘寬度拉至最寬
         * style 屬性可使用 text-align: left|center|right; 來設定文字水平對齊方式
         */

        $fields = '
<table cellpadding="1">
    <tr>
        <td style="border-bottom: 1px solid black; width: 95px;">商品名</td>
        <td style="border-bottom: 1px solid black; width: 90px;">單價</td>
        <td style="border-bottom: 1px solid black; width: 90px;">銷售數量</td>
        <td style="border-bottom: 1px solid black; width: 90px;">銷售額</td>
        <td style="border-bottom: 1px solid black; width: 90px;">單價成本</td>
        <td style="border-bottom: 1px solid black; width: 90px;">銷售成本</td>
    </tr>
</table>';

        // 設定不同頁要顯示的內容 (數值為對應的頁數)
        switch ($this->getPage()) {
            case '1':
                // 設定資料與頁面上方的間距 (依需求調整第二個參數即可)
                $this->SetMargins(1, 50, 1);

                // 增加列印日期的資訊
                $html = $title . '
<table cellpadding="1">
    <tr>
        <td>列印日期：' . date('Y-m-d') . ' ' . date('H:i') . '</td>
        <td></td>
        <td></td>        
    </tr>
    <tr>
        <td colspan="3"></td>
    </tr>
</table>' .  $fields;
                break;
                // 其它頁
            default:
                $this->SetMargins(1, 40, 1);
                $html = $title . $fields;
        }

        // Title
        $this->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
    }

    // Page footer
    public function Footer()
    {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . '/' . $this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}

// create new PDF document
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetTitle('所有訂單資料');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE . ' 001', PDF_HEADER_STRING, array(0, 64, 255), array(0, 64, 128));
$pdf->setFooterData(array(0, 64, 0), array(0, 64, 128));

// set header and footer fonts
$pdf->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
// 版面配置 > 邊界
// $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetMargins(1, 1, 1);

// 頁首上方與頁面頂端的距離
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
// 頁尾上方與頁面底端的距離
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
// 自動分頁
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
    require_once(dirname(__FILE__) . '/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// ---------------------------------------------------------

// set default font subsetting mode
$pdf->setFontSubsetting(true);

// Set font
// dejavusans is a UTF-8 Unicode font, if you only need to
// print standard ASCII chars, you can use core fonts like
// helvetica or times to reduce file size.
// $pdf->SetFont('dejavusans', '', 14, '', true);
// 中文字體名稱, 樣式 (B 粗, I 斜, U 底線, D 刪除線, O 上方線), 字型大小 (預設 12pt), 字型檔, 使用文字子集 
$pdf->SetFont('msungstdlight', '', 10);

// Add a page
// This method has several options, check the source code documentation for more information.
// 版面配置：P 直向 | L 橫向, 紙張大小 (必須大寫字母)
$pdf->AddPage('P', 'LETTER');

// set text shadow effect
// 文字陰影
// $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

// Set some content to print
// $html = <<<EOD
// <h1>Welcome to <a href="http://www.tcpdf.org" style="text-decoration:none;background-color:#CC0000;color:black;"> <span style="color:black;">TC</span><span style="color:white;">PDF</span> </a>!</h1>
// <i>This is the first example of TCPDF library.</i>
// <p>This text is printed using the <i>writeHTMLCell()</i> method but you can also use: <i>Multicell(), writeHTML(), Write(), Cell() and Text()</i>.</p>
// <p>Please check the source code documentation and other examples for further information.</p>
// <p style="color:#CC0000;">TO IMPROVE AND EXPAND TCPDF I NEED YOUR SUPPORT, PLEASE <a href="http://sourceforge.net/donate/index.php?group_id=128076">MAKE A DONATION!</a></p>
// EOD;
if ($_POST["start"]!=null) {
    $sql = "SELECT `p_name`,`p_price`,sum(`od_num`),`p_id`
    FROM (`orderdetails` 
    INNER JOIN `orders` ON `orders`.`o_id`=`orderdetails`.`o_id`) 
    INNER JOIN `products` ON `products`.`p_id`=`orderdetails`.`od_pid`
    where  `o_time` like '%" . $_POST["start"] . "%' 
    GROUP BY `p_id`";
} else if ($_POST["year"]!=null) {
    $sql = "SELECT `p_name`,`p_price`,sum(`od_num`),`p_id`
    FROM (`orderdetails` 
    INNER JOIN `orders` ON `orders`.`o_id`=`orderdetails`.`o_id`) 
    INNER JOIN `products` ON `products`.`p_id`=`orderdetails`.`od_pid`
    where  `o_time` like '%" . $_POST["year"] . "%' 
    GROUP BY `p_id`";
}

$result = mysqli_query($db_link, $sql) or die('MySQL query error');
while ($row = $result->fetch_array()) {
    $sql_cost = 'SELECT * FROM `purchase` where `pu_product`="' . $row["p_id"] . '"';
    $result_cost = mysqli_query($db_link, $sql_cost) or die($sql);
    while ($row_cost = $result_cost->fetch_assoc()) {
        $sum_cost = $row_cost["pu_quantity"] * $row_cost["pu_cost"];
        $total_cost += $sum_cost;
        $total_num += $row_cost["pu_quantity"];
        $avg_cost = round($total_cost / $total_num, 0);
    }
    /**
     * 資料欄位
     *
     * 所有欄位的 width 設定值均與「標題欄位」互相對應，除第一個 <td> width 須 -5px
     * 最後一個 <td> 必須設定 width: auto;，才能將剩餘寬度拉至最寬
     * style 屬性可使用 text-align: left|center|right; 來設定文字水平對齊方式
     */
    $sum = $row["p_price"] * $row[2];
    $cost = $avg_cost * $row[2];
    $total_sales += $sum;
    $t_cost += $cost;
    $html .= '
            <tr>
                <td style="line-height: 1.5; width: 90px;">' . $row["p_name"] . '</td>
                <td style="line-height: 1.5; width: 90px;">' . $row["p_price"] . '</td>
                <td style="line-height: 1.5; width: 90px;">' . $row[2] . '</td>
                <td style="line-height: 1.5; width: 90px;">' . $sum . '</td>
                <td style="line-height: 1.5; width: 90px;">' . $avg_cost . '</td>
                 <td style="line-height: 1.5; width: 90px;">' . $cost . '</td>
            </tr>';
}

$html = '
<table cellpadding="1">' . $html . '
<tr>
    <td style="border-top: 1px solid black; width: 95px;"></td>
    <td style="border-top: 1px solid black; width: 90px;"></td>
    <td style="border-top: 1px solid black; width: 90px;"></td>
    <td style="border-top: 1px solid black; width: 90px;"></td>
    <td style="border-top: 1px solid black; width: 90px;"></td>
    <td style="border-top: 1px solid black; width: 90px;">總銷售：' . $total_sales . '<br>總成本：' . $t_cost . '</td>
</tr>
</table>';

$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

// ---------------------------------------------------------

// Close and output PDF document
// This method has several options, check the source code documentation for more information.
// 下載 PDF 的檔案名稱 (不可取中文名，即使有也會自動省略中文名)
$pdf->Output('mis-employees.pdf', 'I');
?>
<SCRIPT Language='JavaScript'>
function get(x) {
        document.getElementById("start").value = " ";
        document.getElementById("year").value = " ";
}
</SCRIPT>