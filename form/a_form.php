<?php
include('TCPDF/tcpdf.php');
$batch=$_GET['batch'];
$db_connection=mysqli_connect("localhost","root","",$batch."_examination");
/*    $server="localhost: 3306";
    $username="root";
    $password="root";
    $batch=$_GET["batch"];
    $db=$batch.'_examination';
    $db_connection=mysqli_connect($server,$username,$password,"$db");*/

if($_SERVER['REQUEST_METHOD']=='GET') {
    
    function test_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $branch_sub = test_input($_GET["branch_sub"]);
    $branch_sub=explode('|',$branch_sub);
    $branch=$branch_sub[0];
    $subject_code=$branch_sub[1];
    $rooms_selected_count = test_input($_GET["rooms_selected_count"]);
    $rooms_selected = test_input($_GET["rooms_selected"]);
    $rooms_selected=substr($rooms_selected, 0, strlen($rooms_selected)-1); 

    //form details
    $form_details_query=mysqli_query($db_connection,"SELECT college,examination,college_code,deputy_chief_superintendent,chief_superintendent FROM main_examination.form_details;");
    $form_details=mysqli_fetch_array($form_details_query);

    //batch details
    $batch_details_query=mysqli_query($db_connection,"SELECT * FROM main_examination.batch WHERE batch_no='$batch';");
    $batch_details=mysqli_fetch_array($batch_details_query);

    //echo($rooms_selected);
    $pdf=new TCPDF('P','mm','A4');
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);
    $pdf->SetTitle('A Form');
    $pdf->SetMargins(13, 10, 10, true); // set the margins 

    $sem_query=mysqli_query($db_connection,"SELECT DISTINCT(sem) FROM student WHERE sub_code='$subject_code' AND branch='$branch';");
    while($sem=mysqli_fetch_array($sem_query)) {
        $semester=$sem[0];
        $examination=$form_details['examination'];
        $branch=$branch;
        $title_of_course=$batch_details['course'];
        $sub_code=$subject_code;
        $center=$form_details['college'];
        $from_time=$batch_details['start_time'];
        $to_time=$batch_details['end_time'];
        $date=$batch_details['date'];


        $pdf->AddPage();
        //Heading
            $pdf->setFont('Times','B',9);
			$pdf->WriteHTMLCell('','','','','FORM - A',0,1,0,false,'R',false);
        $pdf->setFont('Times','B',14);
        $pdf->WriteHTMLCell('','',10,10,'<img src="vtu.jpeg" height="40px" width="40px">',0,0,false,'L',false);
        $pdf->WriteHTMLCell('','',35,5,'VISVESVARAYA TECHNOLOGICAL UNIVERSITY, BELGAUM',0,1,0,false,'L',false);
        $pdf->setFont('Times','B',10);
        $pdf->WriteHTMLCell('','',20,10,"CONSOLIDATED ATTENDANCE REPORT & DESPATCH MEMO(In Triplicate)",0,1,0,false,'C',false);

        //Details header
        $pdf->setFont('Times','',10);
        $pdf->WriteHTMLCell(190,'','','',"<b>College Name :$center</b>",0,1,0,false,'L',false);

        $pdf->WriteHTMLCell(63,'','','',"Branch : $branch",0,0,0,false,'L',false);
        $pdf->WriteHTMLCell(63,'','','',"Semester : $semester",0,0,0,false,'C',false);
        $pdf->WriteHTMLCell(64,'','','',"Subject Code : $sub_code",0,1,0,false,'R',true);

        $pdf->WriteHTMLCell(63,'','','',"Exam Time : $from_time-$to_time",0,0,0,false,'L',false);
        $pdf->WriteHTMLCell(63,'','','',"Exam Date : $date",0,0,0,false,'C',false);
        $pdf->WriteHTMLCell(64,'','','',"College Code : MH",0,1,0,false,'R',true);

        $pdf->ln();
        //cells
        //column header

        //candidates' Present cell
        $pdf->WriteHTMLCell(190,'','','',"Seat Numbers of the Candidates Present:",0,1,0,false,'L',false);
        $pdf->ln();

        $pdf->setFont('Times','B',8);
        $col_count=0;
        $pdf->WriteHTMLCell(5,5,'','',"",0,0,0,false,'C',false);
        $present_query=mysqli_query($db_connection,"SELECT usn FROM student WHERE room_no IN ($rooms_selected) AND branch='$branch' AND sub_code='$sub_code' AND sem='$semester' AND present=1;");
        $p_count=0;
        while($present_usn=mysqli_fetch_array($present_query))
        {
            if($col_count<8) {
                $pdf->WriteHTMLCell(20,5,'','',"$present_usn[0]",0,0,0,false,'C',false);
                $col_count++;
                $p_count++;
            }
            else {
                $pdf->ln();
                $pdf->WriteHTMLCell(5,5,'','',"",0,0,0,false,'C',false);
                $pdf->WriteHTMLCell(20,5,'','',"$present_usn[0]",0,0,0,false,'C',false);
                $col_count=1;
                $p_count++;
            }
        }
		
        $pdf->ln();
        $pdf->setFont('Times','',10);
        $pdf->WriteHTMLCell(180,5,'','',"Count : $p_count",0,1,0,false,'R',false);
        $pdf->ln();

        //candidates' Absent cell
        $pdf->setFont('Times','',10);
        $pdf->WriteHTMLCell(190,'','','',"Seat Numbers of the Candidates Absent:",0,1,0,false,'L',false);
        $pdf->ln();

        $pdf->setFont('Times','B',9);
        $col_count=0;
        $pdf->WriteHTMLCell(5,5,'','',"",0,0,0,false,'C',false);


        $absent_query=mysqli_query($db_connection,"SELECT usn FROM student WHERE room_no IN ($rooms_selected) AND branch='$branch' AND sub_code='$sub_code' AND sem='$semester' AND present=0;");
        $a_count=0;
        while($absent_usn=mysqli_fetch_array($absent_query))
        {
            if($col_count<7) {
                $pdf->WriteHTMLCell(25,5,'','',"$absent_usn[0]",0,0,0,false,'C',false);
                $col_count++;
                $a_count++;
            }
            else {
                $pdf->ln();
                $pdf->WriteHTMLCell(5,5,'','',"",0,0,0,false,'C',false);
                $pdf->WriteHTMLCell(25,5,'','',"$absent_usn[0]",0,0,0,false,'C',false);
                $col_count=0;
                $a_count++;
            }
        }

        $pdf->ln();
        $pdf->setFont('Times','',10);
        $pdf->WriteHTMLCell(180,5,'','',"Count : $a_count",0,1,0,false,'R',false);
        $pdf->ln();

        //candidates' Malpractice cell
        $pdf->WriteHTMLCell(190,'','','',"Seat Numbers of the Candidates MPC:",0,1,0,false,'L',false);
        $pdf->ln();

        $pdf->setFont('Times','B',9);
        $col_count=0;
        $pdf->WriteHTMLCell(5,5,'','',"",0,0,0,false,'C',false);

        $present_query=mysqli_query($db_connection,"SELECT usn FROM student WHERE room_no IN ($rooms_selected) AND branch='$branch' AND sub_code='$sub_code' AND sem='$semester' AND present=2;");
        $p_count=0;
        while($present_usn=mysqli_fetch_array($present_query))
        {
            if($col_count<7) {
                $pdf->WriteHTMLCell(25,5,'','',"$present_usn[0]",0,0,0,false,'C',false);
                $col_count++;
                $p_count++;
            }
            else {
                $pdf->ln();
                $pdf->WriteHTMLCell(5,5,'','',"",0,0,0,false,'C',false);
                $pdf->WriteHTMLCell(25,5,'','',"$present_usn[0]",0,0,0,false,'C',false);
                $col_count=1;
                $p_count++;
            }
        }

        $pdf->ln();
        $pdf->setFont('Times','',10);
        $pdf->WriteHTMLCell(180,5,'','',"Count : $p_count",0,1,0,false,'R',false);
        $pdf->ln();

        //candidates' Court Cases cell
        $pdf->setFont('Times','',10);
        $pdf->WriteHTMLCell(190,'','','',"Seat Numbers of the Candidates Court Cases:",0,1,0,false,'L',false);
        $pdf->ln();

        $pdf->setFont('Times','B',10);
        $col_count=0;
        $pdf->WriteHTMLCell(5,5,'','',"",0,0,0,false,'C',false);
        for($i=1;$i<=1;$i++)
        {
            if($col_count<7) {
                $pdf->WriteHTMLCell(25,5,'','',"",0,0,0,false,'C',false);
                $col_count++;        
            }
            else {
                $pdf->ln();
                $pdf->WriteHTMLCell(5,5,'','',"",0,0,0,false,'C',false);
                $col_count=0;
            }
        }

        $pdf->ln();
        $pdf->setFont('Times','',10);
        $pdf->WriteHTMLCell(180,5,'','',"Count : 0",0,1,0,false,'R',false);

        //Details footer

        $pdf->ln();
        $pdf->ln();

        $pdf->setFont('Times','',11);
        $pdf->WriteHTMLCell(85,'','','',"Remarks : Suggesstions related FORM-A Entry",0,1,0,false,'L',false);
        $pdf->WriteHTMLCell(85,'','','',"<b>N/A</b>",0,1,0,false,'L',false);

        $pdf->ln();
        $pdf->ln();
        $pdf->ln();
        $pdf->ln();
		
        $pdf->WriteHTMLCell(10,'','','',"",0,0,0,false,'C',false);
        $pdf->WriteHTMLCell(95,'','','',"<b>$form_details[3]</b>",0,0,0,false,'L',false);
        $pdf->WriteHTMLCell(75,'','','',"<b>$form_details[4]</b>",0,1,0,false,'R',false);
		
        $pdf->WriteHTMLCell(10,'','','',"",0,0,0,false,'C',false);
        $pdf->WriteHTMLCell(95,'','','',"<u><b>Deputy Chief Superintendent</b></u>",0,0,0,false,'L',false);
        $pdf->WriteHTMLCell(75,'','','',"<u><b>Chief Superintendent</b></u>",0,1,0,false,'R',false);

    }
    $pdf->output();
}
?>
<?php
mysqli_close($db_connection);
?>