<?php
include('TCPDF/tcpdf.php');

if($_SERVER['REQUEST_METHOD']=='GET') {
        $batch=$_GET['batch'];
        $db_connection=mysqli_connect("localhost","root","",$batch."_examination");
        class MYPDF extends TCPDF {
        public function Header() {
            $headerData = $this->getHeaderData();
            $this->SetFont('helvetica', '', 14);
            //$this->writeHTML($headerData['string']);
            //$this->WriteHTMLCell('','','','',$headerData['string'],0,true,'C',0,'',1,false,'M','M');
            $this->WriteHTMLCell('','','','',$headerData['string'],0,1,0,false,'C',false);
            $this->ln(4);
            $this->SetFont('Times','B',10);
            $this->Cell(30,5,"USN",1,0,'C',false,'',0,false,'M','M');
            $this->Cell(65,5,"NAME",1,0,'C',false,'',0,false,'M','M');
            $this->Cell(35,5,"SUBJECT",1,0,'C',false,'',0,false,'M','M');
            $this->Cell(40,5,"Room No.",1,0,'C',false,'',0,false,'M','M');
            $this->Cell(20,5,"Seat No.",1,1,'C',false,'',0,false,'M','M');
        }
    }
    
    /*function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $branch_sub = test_input($_GET["branch_sub"]);
    $branch_sub=explode('|',$branch_sub);
    $branch=$branch_sub[0];
    $subject_code=$branch_sub[1];*/
    $pdf=new MYPDF('P','mm','A4');
    $pdf->SetCreator(PDF_CREATOR);
    //$pdf->SetAuthor('MOHAN KRISHNA');
    $pdf->SetTitle('Alloted list');
    //$pdf->SetSubject('Alloted');
    //$pdf->SetKeywords('PDF, Alloted');

    //set margins
    $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
    $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
    $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

    //set auto page breaks
    $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


    //$pdf->setHeaderData($ln='', $lw=0, $ht='', $hs='<table cellspacing="0" cellpadding="1" border="1">tr><td rowspan="3">test</td><td>test</td></tr></table>', $tc=array(0,0,0), $lc=array(0,0,0));
    
    //$pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    $pdf->SetMargins(13, 18, 0, true); // set the margins 
    $batch_details_query=mysqli_query($db_connection,"SELECT date,start_time,end_time FROM main_examination.batch WHERE batch_no='$batch';");
    $batch_details=mysqli_fetch_array($batch_details_query);
    //$this->Cell('','',$batch_details['date'],0,false,'R',0,'',1,false,'M','M');
    //$this->Cell('','',$batch_details['start_time'],0,true,'R',0,'',1,false,'M','M');
    
    
    $branch_query=mysqli_query($db_connection,"SELECT DISTINCT(branch) FROM student;");
    while($branch=mysqli_fetch_array($branch_query)) {
    $pdf->setHeaderData(0,0, 0, "<table> <tr><th>BRANCH :<b> $branch[0] </b> </th> <th>$batch_details[0]</th><th>$batch_details[1] - $batch_details[2]</th></tr></table>", array(0,0,0), array(0,0,0));
    
    $pdf->AddPage();
    //Heading
    $pdf->setFont('Times','',12);

    //$pdf->ln(7);
    //cells
    //column header
/*  $pdf->setFont('Times','B',10);
    $pdf->WriteHTMLCell(30,5,'','',"USN",1,0,0,false,'C',false);
    $pdf->WriteHTMLCell(65,5,'','',"NAME",1,0,0,false,'C',false);
    $pdf->WriteHTMLCell(35,5,'','',"SUBJECT",1,0,0,false,'C',false);
    $pdf->WriteHTMLCell(40,5,'','',"Room No.",1,0,0,false,'C',false);
    $pdf->WriteHTMLCell(20,5,'','',"Seat No.",1,1,0,false,'C',false);
*/
    //candidates' cell
	
    $usn_query=mysqli_query($db_connection,"SELECT usn,name,sub_code,room_no,seat_no FROM student WHERE branch='$branch[0]' AND room_no NOT IN ('noroom');");
    while($next_usn=mysqli_fetch_array($usn_query)) {
        $pdf->setFont('Times','',10);
        if($next_usn['usn']=='4MH16IS048' || $next_usn['usn']=='4MH16IS037' || $next_usn['usn']=='4MH16CS032' || $next_usn['usn']=='4MH16CS133' || $next_usn['usn']=='4MH17EC089') {
            $pdf->setFont('Times','BI',11);
        }
		$name=substr($next_usn['name'],0,25);
        $pdf->WriteHTMLCell(30,5,'','',$next_usn['usn'],1,0,0,false,'C',false);
        $pdf->WriteHTMLCell(65,5,'','',$name,1,0,0,false,'L',false);
        $pdf->WriteHTMLCell(35,5,'','',$next_usn['sub_code'],1,0,0,false,'C',false);
        $pdf->WriteHTMLCell(40,5,'','',$next_usn['room_no'],1,0,0,false,'C',false);
        $pdf->WriteHTMLCell(20,5,'','',$next_usn['seat_no'],1,1,0,false,'C',false);
    }
	}
    $pdf->output();

}

?>