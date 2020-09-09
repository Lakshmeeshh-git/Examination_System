<?php
include('TCPDF/tcpdf.php');
$batch=$_GET['batch'];
$db_connection=mysqli_connect("localhost","root","",$batch."_examination");
/*
    $server="localhost: 3306";
    $username="root";
    $password="root";
    $batch=$_GET["batch"];
    $db=$batch.'_examination';
    $db_connection=mysqli_connect($server,$username,$password,$db);
    */
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
    $rooms=explode('|',$rooms_selected);

    //form details
    $form_details_query=mysqli_query($db_connection,"SELECT college,examination,college_code,deputy_chief_superintendent,chief_superintendent FROM main_examination.form_details;");
    $form_details=mysqli_fetch_array($form_details_query);

    //batch details
    $batch_details_query=mysqli_query($db_connection,"SELECT * FROM main_examination.batch WHERE batch_no='$batch';");
    $batch_details=mysqli_fetch_array($batch_details_query);


    $pdf=new TCPDF('P','mm','A4');
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    $pdf->SetTitle('B Form');
    $pdf->SetMargins(13, 10, 10, true); // set the margins 

    
    for($i=0;$i<$rooms_selected_count;$i++) {

        $header_query=mysqli_query($db_connection,"SELECT DISTINCT(sem),sub_name FROM student WHERE branch='$branch' AND room_no='$rooms[$i]' AND sub_code='$subject_code';");
        while($header_data=mysqli_fetch_array($header_query)) {
            $s_c=0;
            $seat=array();
            $usn_query=mysqli_query($db_connection,"SELECT COUNT(usn) FROM student WHERE branch='$branch' AND sub_code='$subject_code' AND room_no='$rooms[$i]' AND sem=$header_data[0] AND seat_no%2=1;");
            $usn_odd_count=mysqli_fetch_array($usn_query);
            if($usn_odd_count[0]>0) {
                $seat[$s_c++]=1;
            }
            $usn_query=mysqli_query($db_connection,"SELECT COUNT(usn) FROM student WHERE branch='$branch' AND sub_code='$subject_code' AND room_no='$rooms[$i]' AND sem=$header_data[0] AND seat_no%2=0;");
            $usn_even_count=mysqli_fetch_array($usn_query);
            if($usn_even_count[0]>0) {
                $seat[$s_c++]=0;
            }
            for($seat_count=0;$seat_count<$s_c;$seat_count++) {
    
            $semester=$header_data['sem'];
            $examination=$form_details['examination'];
            $block_no=$rooms[$i];
            $branch=$branch;
            $course=$batch_details['course'];
            $title_of_course='BE/MBA/MCA';
            
			if($branch=='MBA') {
				$branch_title_of_course="Title of the Course : <b>MBA</b>";
			}
			else if($branch=='MCA') {
				$branch_title_of_course="Title of the Course : <b>MCA</b>";
			}
			else if($branch=='M.Tech') {
				$branch_title_of_course="Title of the Course : <b>M.Tech</b>";
			}
			
			else {
				$branch_title_of_course="Branch/Title of the Course : <b>$branch/BE</b>";
			}
			
			
            if($branch=='MBA') {
                $title_of_course='<b>MBA</b>/BE/MCA/M.Tech';
				$branch_title_of_course="Title of the Course : <b>MBA</b>";
            }
            else if($branch=='MCA') {
                $title_of_course='<b>MCA</b>/BE/MBA/M.Tech';
				$branch_title_of_course="Title of the Course : <b>MCA</b>";
            }
			else if($branch=='M.Tech') {
                $title_of_course='<b>M.Tech</b>/BE/MBA/MCA';
				$branch_title_of_course="Title of the Course : <b>M.Tech</b>";
            }
            else {
                $title_of_course='<b>BE</b>/MBA/MCA/M.Tech';
				$branch_title_of_course="Branch/Title of the Course : <b>$branch/BE</b>";
            }
			
            $sub_code=$subject_code;
            $subject=$header_data['sub_name'];

            $usn_query=mysqli_query($db_connection,"SELECT usn FROM student WHERE branch='$branch' AND sub_code='$subject_code' AND room_no='$rooms[$i]' AND sem=$header_data[0] AND seat_no%2=$seat[$seat_count];");
            $start_usn=mysqli_fetch_array($usn_query);
            $end_usn='';
            $from_usn=$start_usn['usn'];
            while($next_usn=mysqli_fetch_array($usn_query)) {
                $end_usn=$next_usn['usn'];
            }
            $to_usn=$end_usn;
            $center=$form_details['college'];
            $from_time=$batch_details['start_time'];
            $to_time=$batch_details['end_time'];
            $date=$batch_details['date'];


            //$pdf=new TCPDF('P','mm','A4');
            //$pdf->setPrintHeader(false);
            //$pdf->setPrintFooter(false);

            //$pdf->SetMargins(10, 10, 10, true); // set the margins 


            $pdf->AddPage();
            //Heading
            $pdf->setFont('Times','B',9);
			$pdf->WriteHTMLCell('','','','','FORM - B',0,1,0,false,'R',false);
            $pdf->setFont('Times','B',14);
            $pdf->WriteHTMLCell('','',10,10,'<img src="vtu.jpeg" height="40px" width="40px">',0,0,0,false,'L',false);
            $pdf->WriteHTMLCell('','',35,5,'VISVESVARAYA TECHNOLOGICAL UNIVERSITY, BELGAUM',0,1,0,0,false,'L',false);
            $pdf->setFont('Times','B',10);
            $pdf->WriteHTMLCell('','',30,10,"ATTENDANCE & ROOM SUPERINTENDENT'S / THEORY EXAMINERS' REPORT (In Triplicate)",0,1,0,0,false,'C',false);
            //Details header
            $pdf->setFont('Times','',10);
            $pdf->WriteHTMLCell(63,'','','',"$title_of_course : <b>$semester Semester</b>",0,0,0,false,'L',false);
            $pdf->WriteHTMLCell(73,'','','',"Semester Examination : $examination",0,0,0,false,'C',false);
            $pdf->WriteHTMLCell(54,'','','',"<i>Block No. : </i><b>$block_no</b></span>",0,1,0,false,'R',true);

            //$pdf->WriteHTMLCell(95,'','','',"Branch/Title of the Course : <b>$branch/$course</b>",0,0,0,false,'L',false);
			$pdf->WriteHTMLCell(95,'','','',"$branch_title_of_course",0,0,0,false,'L',false);
            $pdf->WriteHTMLCell(95,'','','',"Sub Code : <b>$sub_code</b>",0,1,0,false,'R',true);

            $pdf->WriteHTMLCell(95,'','','',"Subject : <b>$subject</b>",0,0,0,false,'L',false);
            $pdf->WriteHTMLCell(95,'','','',"USN from : <b>$from_usn To $to_usn</b>",0,1,0,false,'R',true);

            $pdf->WriteHTMLCell(110,'','','',"Center : <b>$center</b>",0,0,0,false,'L',false);

            $pdf->WriteHTMLCell('','','','',"TIME : <b>$from_time To $to_time</b>",0,1,0,false,'R',true);

            $pdf->WriteHTMLCell(95,'','','',"Date : <b>$date</b>",0,1,0,false,'L',false);
            //$pdf->ln();
            //cells
            //column header
            $pdf->setFont('Times','B',10);
            $pdf->WriteHTMLCell(30,5,'','',"USN",1,0,0,false,'C',false);
            $pdf->setFont('Times','B',8);
            $pdf->WriteHTMLCell(45,5,'','',"Booklet / Dwg. Sheet Number",1,0,0,false,'C',false);
            $pdf->WriteHTMLCell(40,5,'','',"Signature",1,0,0,false,'C',false);
            $pdf->WriteHTMLCell(60,5,'','',"Add1. booklet/Drawing/Graph Sheet Number",1,0,0,false,'C',false);
            $pdf->WriteHTMLCell(15,5,'','',"Seat No.",1,1,0,false,'C',false);

            //candidates' cell

            $count_st=0;
            $usn_query=mysqli_query($db_connection,"SELECT usn,seat_no FROM student WHERE branch='$branch' AND sub_code='$subject_code' AND room_no='$rooms[$i]' AND sem=$header_data[0] AND seat_no%2=$seat[$seat_count];");
            while($next_usn=mysqli_fetch_array($usn_query)) {
                $count_st++;
                $pdf->setFont('Times','B',10);
                $pdf->WriteHTMLCell(30,7,'','',$next_usn['usn'],1,0,0,false,'C',false);
                $pdf->WriteHTMLCell(45,7,'','',"",1,0,0,false,'C',false);
                $pdf->WriteHTMLCell(40,7,'','',"",1,0,0,false,'C',false);
                $pdf->WriteHTMLCell(60,7,'','',"",1,0,0,false,'C',false);
                $pdf->WriteHTMLCell(15,7,'','',$next_usn['seat_no'],1,1,0,false,'C',false);
            }
			$c=$count_st;
            while($count_st<20) {
                $count_st++;
                $pdf->setFont('Times','B',10);
                $pdf->WriteHTMLCell(30,7,'','',"",1,0,0,false,'C',false);
                $pdf->WriteHTMLCell(45,7,'','',"",1,0,0,false,'C',false);
                $pdf->WriteHTMLCell(40,7,'','',"",1,0,0,false,'C',false);
                $pdf->WriteHTMLCell(60,7,'','',"",1,0,0,false,'C',false);
                $pdf->WriteHTMLCell(15,7,'','',"",1,1,0,false,'C',false);
                
            }
			$pdf->setFont('Times','',10);
			$pdf->WriteHTMLCell(43,7,'','',"Total Number Of Students : ",0,0,0,false,'L',false);
			$pdf->setFont('Times','B',11);
			$pdf->WriteHTMLCell(25,7,'','',$c,0,0,0,false,'L',false);
			$pdf->WriteHTMLCell(40,7,'','',"",0,0,0,false,'C',false);
			$pdf->WriteHTMLCell(60,7,'','',"",0,0,0,false,'C',false);
			$pdf->WriteHTMLCell(15,7,'','',"",0,1,0,false,'C',false);
                
            //Details footer

            $pdf->setFont('Times','',11);
            $pdf->WriteHTMLCell('','','','',"USNs (Absentees) : ",0,1,0,false,'L',false);
            $pdf->WriteHTMLCell('','','','',"USNs (candidates b/u Malpractice) : ",0,1,0,false,'L',false);

            $pdf->ln();

            $pdf->WriteHTMLCell(20,'','','',"",0,0,0,false,'L',false);
            $pdf->WriteHTMLCell(85,'','','',"<u><b>Room Superintendent</b></u>",0,0,0,false,'C',false);
            $pdf->WriteHTMLCell(85,'','','',"<u><b>Chief/Deputy Superintendent</b></u>",0,1,0,false,'C',false);

            $pdf->ln();

            $pdf->WriteHTMLCell(63,'','','',"Signature : ",0,0,0,false,'L',false);
            $pdf->WriteHTMLCell(63,'','','',"",0,0,0,false,'L',false);
            $pdf->WriteHTMLCell(63,'','','',"",0,1,0,false,'L',false);

            $pdf->ln();

            $pdf->WriteHTMLCell(63,'','','',"Name : ",0,0,0,false,'L',false);
            $pdf->WriteHTMLCell(63,'','','',"",0,0,0,false,'L',false);
            $pdf->WriteHTMLCell(63,'','','',"",0,1,0,false,'L',false);

            $pdf->ln();

            $pdf->WriteHTMLCell(63,'','','',"Affiliation : ",0,0,0,false,'L',false);
            $pdf->WriteHTMLCell(63,'','','',"",0,0,0,false,'L',false);
            $pdf->WriteHTMLCell(63,'','','',"",0,1,0,false,'L',false);

            $pdf->ln();

            $pdf->WriteHTMLCell('','','','',"<b>NOTE : </b>ANSWER PAPER BUNDLES TO BE SENT TO REGIONAL OFFICE ONLY.",0,1,0,false,'L',false);
            $pdf->setFont('Times','',9);
			$pdf->WriteHTMLCell('','','','',"1.Separate sheet to be used for each subject. 2. Statement shall be sent to a) Regional Center b) Registrar (Evaluation), c) Retained at the College",0,0,0,false,'L',false);
			

        }
    }
    }
    $pdf->output();
    

}

?>
<?php
mysqli_close($db_connection);
?>
