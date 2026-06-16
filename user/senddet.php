<?php
require_once("config.php");
require_once('phpmailer/PHPMailerAutoload.php');
require_once("fpdf17/fpdf.php"); 
$fdate=$_POST["fdate"];
 $eil=$_POST["email"];
 $temail=$_POST["temail"];
$cid=$_POST["cid"];
$s=substr($cid,0,1);
    if($s==3)
    {
        $leo="LEO DISTRIBUTORS";
    }
    else if($s==1)
    {
        $leo="LEO ENTERPRISES";
    }
    else if($s==5)
    {
        $leo="ARIES DISTRIBUTORS";
    }
    $date1=date('d-m-Y', strtotime($fdate));
$qr_led="SELECT l.*,c.`company` FROM `costomer` c,`ledger` l WHERE c.`costomer_id`='$cid' AND l.`costomer_id`='$cid' AND l.`date`='$fdate' order by `name`";
$stmt = $con->prepare($qr_led);
$stmt -> execute();
$stmt->store_result();
$stmt -> bind_result($date,$costomer_id,$code,$name ,$prate,$op_stock,$purchase_qty,$purchase_free,$preturn,$sales_qty,$sales_free,$salesqty_spoke,$salesfree_spoke,$s_value,$s_return,$excess,$short,$cl_stock,$cl_stock_spoke,$cl_value,$company);
$all_posts = Array();
while($stmt->fetch())
{
    $individual_post = Array(
         'date'=>$date,
        'costomer_id'=>$costomer_id,
        'code'=>$code,
        'name' => $name,
        'prate'=>$prate,
        'op_stock' => $op_stock,
        'purchase_qty' => $purchase_qty,
        'purchase_free'=>$purchase_free,
        'preturn'=>$preturn,
        'sales_qty'=>$sales_qty,
        'sales_free'=>$sales_free,
        
        'salesqty_spoke'=>$salesqty_spoke,
        'salesfree_spoke'=>$salesfree_spoke,
        
        's_value' =>$s_value,
        's_return'=>$s_return,
        'excess'=>$excess,
        'short'=>$short,
        'cl_stock'=>$cl_stock,
        'cl_value'=>$cl_value,
        
        'cl_stock_spoke'=>$cl_stock_spoke,
        
        'company'=>$company

        );
array_push($all_posts, $individual_post);
}
$stmt->close();

class PDFtt extends FPDF
{
    function Header()
    {
       

        
        

    }

    // Page footer
    function Footer()
    {
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Arial italic 8
        $this->SetFont('Arial','I',8);
        // Page number
        $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
    }

    function TableHead5()
    {

        $this->SetFont('Arial','B',8);

        //set initial y axis position per page
        $y_axis_initial = 45;

        //print column titles for the actual page
        $this->SetFillColor(232, 232, 232);
        $this->SetY($y_axis_initial);
        $this->SetX(5);
        $this->Cell(35, 6, 'NAME', 1, 0, 'C', 1);
        $this->Cell(18, 6, 'CODE', 1, 0, 'C', 1);
        $this->Cell(18, 6, 'PRATE', 1, 0, 'C', 1);
        $this->Cell(18, 6, 'OPSTOCK', 1, 0, 'C', 1);
        $this->Cell(18, 6 ,'P_QTY', 1, 0, 'C', 1);        
        $this->Cell(18, 6,'P_FREE', 1, 0, 'C', 1);
        $this->Cell(18, 6 ,'PRETURN', 1, 0, 'C', 1);
        $this->Cell(18, 6 ,'S_QTY', 1, 0, 'C', 1);
        $this->Cell(18, 6 ,'S_FREE', 1, 0, 'C', 1);
        
        $this->Cell(18, 6 ,'S_QTY_SPK', 1, 0, 'C', 1);
        $this->Cell(18, 6 ,'S_FREE_SPK', 1, 0, 'C', 1);
        
        $this->Cell(18, 6, 'SVALUE', 1, 0, 'C', 1);
        $this->Cell(18, 6, 'SRETURN', 1, 0, 'C', 1);        
        $this->Cell(18, 6, 'EXCESS', 1, 0, 'C', 1);
        $this->Cell(18, 6, 'SHORT', 1, 0, 'C', 1);
        $this->Cell(18, 6, 'CLSTOCK', 1, 0, 'C', 1);
        
         $this->Cell(18, 6, 'CLSTOCK SPK', 1, 0, 'C', 1);
        
        $this->Cell(18, 6, 'CLVALUE', 1, 0, 'C', 1);
        
    }

}
// Instanciation of inherited class
$pdf = new PDFtt('L','mm','A4');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetTitle('Ledger Report');
//set initial y axis position per page
$y_axis_initial = 45;

$pdf->SetFont('Arial', 'B', 15);
$pdf->SetXY(10, 20); // position of text1, numerical, of course, not x1 and y1
$pdf->Cell(35,6,substr($leo, 0, 32),0,0,'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(70,6,' THRISSUR,KERALA',0,0,'C');

$pdf->SetXY(10, 29); // position of text2
$pdf->SetFont('Arial', 'B', 12);
$pdf->SetXY(10, 31); // position of text3
$pdf->Write(0, 'Closing Stock &  Sales Register - Date : ');
$pdf->Cell(50,0,substr($date1, 0, 32),0,0,'L');
$pdf->SetFont('Arial', 'B', 13);
$pdf->SetXY(10, 35); // position of text3
$pdf->Cell(35,6,substr($company, 0, 32),0,0,'L');

$pdf->TableHead5();
$pdf->SetLeftMargin(5);
$cl_valuetot=0;
$s_valuetot=0;
foreach($all_posts as $mem_dt)
{
    
    $company=$mem_dt['company'];  
    $code= $mem_dt['code'];
    $name= $mem_dt['name'];
    $prate= $mem_dt['prate'];
    $op_stock= $mem_dt['op_stock'];
    $purchase_qty= $mem_dt['purchase_qty'];
    $purchase_free= $mem_dt['purchase_free'];
    $preturn= $mem_dt['preturn'];
    $sales_qty= $mem_dt['sales_qty'];
    $sales_free= $mem_dt['sales_free'];
    
    $salesqty_spoke= $mem_dt['salesqty_spoke'];
    $salesfree_spoke= $mem_dt['salesfree_spoke'];
    
    $s_value= $mem_dt['s_value'];
    $s_return= $mem_dt['s_return'];
    $excess= $mem_dt['excess'];
    $short= $mem_dt['short'];
    $cl_stock= $mem_dt['cl_stock'];
    
    $cl_stock_spoke= $mem_dt['cl_stock_spoke'];
    
    $cl_value= $mem_dt['cl_value'];
    $s_valuetot +=$mem_dt['s_value'];
    $cl_valuetot +=$mem_dt['cl_value'];

    
    $pdf->SetFont('Arial', 'B', 8);
    $pdf->ln();
    $pdf->Cell(35,6,substr($name, 0, 32),'LRB',0,'C');
    $pdf->Cell(18,6,substr($code, 0, 14),'LRB',0,'C');
    $pdf->Cell(18,6,substr($prate, 0, 15),'LRB',0,'C');
    $pdf->Cell(18,6,substr($op_stock, 0, 15),'LRB',0,'C');
    $pdf->Cell(18,6,substr($purchase_qty, 0, 15),'LRB',0,'C');    
    $pdf->Cell(18,6,substr($purchase_free, 0, 15),'LRB',0,'C');
    $pdf->Cell(18,6,substr($preturn, 0,15),'LRB',0,'C');
    $pdf->Cell(18,6,substr($sales_qty, 0, 14),'LRB',0,'C');
    $pdf->Cell(18,6,substr($sales_free, 0, 32),'LRB',0,'C');
    $pdf->Cell(18,6,substr($s_value, 0, 15),'LRB',0,'C');
    $pdf->Cell(18,6,substr($s_return, 0, 15),'LRB',0,'C');
    $pdf->Cell(18,6,substr($excess, 0, 15),'LRB',0,'C');    
    $pdf->Cell(18,6,substr($short, 0, 15),'LRB',0,'C');
    $pdf->Cell(18,6,substr($cl_stock, 0, 15),'LRB',0,'C');    
    $pdf->Cell(18,6,substr($cl_value, 0, 15),'LRB',0,'C');
} 
$pdf->ln();
    $pdf->Cell(35,6,substr('Grand Total', 0, 32),'LRB',0,'C');
    $pdf->Cell(18,6,substr('', 0, 14),'LRB',0,'C');
    $pdf->Cell(18,6,substr('', 0, 15),'LRB',0,'C');
    $pdf->Cell(18,6,substr('', 0, 15),'LRB',0,'C');
    $pdf->Cell(18,6,substr('', 0, 15),'LRB',0,'C');    
    $pdf->Cell(18,6,substr('', 0, 15),'LRB',0,'C');
    $pdf->Cell(18,6,substr('', 0,15),'LRB',0,'C');
    $pdf->Cell(18,6,substr('', 0, 14),'LRB',0,'C');
    $pdf->Cell(18,6,substr('', 0, 32),'LRB',0,'C');
    $pdf->Cell(18,6,substr($s_valuetot, 0, 15),'LRB',0,'C');
    $pdf->Cell(18,6,substr('', 0, 15),'LRB',0,'C');
    $pdf->Cell(18,6,substr('', 0, 15),'LRB',0,'C');    
    $pdf->Cell(18,6,substr('', 0, 15),'LRB',0,'C');
    $pdf->Cell(18,6,substr('', 0, 15),'LRB',0,'C');    
    $pdf->Cell(18,6,substr($cl_valuetot, 0, 15),'LRB',0,'C');
    clearstatcache();
if (file_exists("iii.pdf"))
{
    unlink("iii.pdf");
}
$pdf->Output("iii.pdf");

$mail = new PHPMailer;

$mail->isSMTP();
//$mail->SMTPDebug = 2;
$mail->SMTPKeepAlive = true;   
$mail->Mailer ="smtp";


//$mail->Host = 'ssl://mail.rareeram.com:587';
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = 'leoledger007@gmail.com';
$mail->Password = '(leo)@ledger?2?';
//$mail->SMTPSecure = 'ssl';
$mail->SMTPSecure = 'tls';
$mail->addAttachment("iii.pdf");
$mail->SMTPAutoTLS = false;
$mail->Port = 587;

//$mail->setFrom('info@bestcateringthalore.com', 'Best Catering Online Enquiries');
$mail->setFrom($eil,'LEO GROUP');
$mail->addAddress($temail);

// Email subject
$mail->Subject = 'Leo Group Ledger Report';

// Set email format to HTML
$mail->isHTML(true);


$mailContent = 'Attech Ledger';

$mail->Body = $mailContent;
 if(!$mail->send()){
    echo $mail->ErrorInfo;
 } else {
    echo 'Sent Email Successfuly';
 } 
 ob_end_flush(); 

?>
