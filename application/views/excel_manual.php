<?php
	require_once APPPATH.'third_party/excel/PHPExcel.php';
	$sheet = new PHPExcel();
	try {
		$users = $result;
		$sheet->setActiveSheetIndex(0);
		$activeSheet = $sheet->getActiveSheet();
		$activeSheet->setTitle("Register");
		$style1 = array(
			'font'  => array(
					'bold'  => false,
					'color' => array('rgb' => 'FFFFFF'),
					'size'  => 18,
					'name'  => 'Arial'
			),
			'alignment'  => array(
					'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
			),
			'fill'  => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => '808080')
			)
		);
		$activeSheet->getStyle('A1')->applyFromArray($style1);
		$activeSheet->mergeCells('A1:Q1');
		$activeSheet->getCell('A1')->setValue('Risk Register');
		$activeSheet->getRowDimension('1')->setRowHeight(30);
		$activeSheet->mergeCells('A2:Q2');
		$activeSheet->getCell('A2')->setValue();
		$style2 = array(
				'font'  => array(
						'bold'  => true,
						'color' => array('rgb' => '000000'),
						'size'  => 14,
						'name'  => 'Arial'
				),
				'alignment'  => array(
						'horizontal'  => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
				),
				'fill'  => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => 'BFBFBF')
				)
		);
		$activeSheet->getStyle('A3')->applyFromArray($style2);
		$activeSheet->mergeCells('A3:G3');
		$activeSheet->getCell('A3')->setValue('RISK IDENTIFICATION');
		$style3 = array(
				'font'  => array(
						'bold'  => true,
						'color' => array('rgb' => '000000'),
						'size'  => 14,
						'name'  => 'Arial'
				),
				'alignment'  => array(
						'horizontal'  => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
				),
				'fill'  => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => '808080')
				)
		);
		$activeSheet->getStyle('H3')->applyFromArray($style3);
		$activeSheet->mergeCells('H3:J3');
		$activeSheet->getCell('H3')->setValue('RISK ASSESSMENT');
		$style4 = array(
				'font'  => array(
						'bold'  => true,
						'color' => array('rgb' => 'FFFFFF'),
						'size'  => 14,
						'name'  => 'Arial'
				),
				'alignment'  => array(
						'horizontal'  => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
				),
				'fill'  => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => '606060')
				)
		);
		$activeSheet->getStyle('K3')->applyFromArray($style4);
		$activeSheet->mergeCells('K3:N3');
		$activeSheet->getCell('K3')->setValue('RISK TREATMENT');
		$style5 = array(
				'font'  => array(
						'bold'  => true,
						'color' => array('rgb' => 'FFFFFF'),
						'size'  => 14,
						'name'  => 'Arial'
				),
				'alignment'  => array(
						'horizontal'  => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
				),
				'fill'  => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => '000000')
				)
		);
		$activeSheet->getStyle('O3')->applyFromArray($style5);
		$activeSheet->mergeCells('O3:Q3');
		$activeSheet->getCell('O3')->setValue('RISK MONITORING & REVIEW');
		$activeSheet->getRowDimension('3')->setRowHeight(30);
		$style6 = array(
				'font'  => array(
						'bold'  => true,
						'color' => array('rgb' => '000000'),
						'size'  => 12,
						'name'  => 'Arial'
				),
				'alignment'  => array(
						'horizontal'  => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
				),
				'fill'  => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => 'F2F2F2')
				)
		);

		$activeSheet->getStyle('A4')->applyFromArray($style6);
		$activeSheet->mergeCells('A4:A5');
		$activeSheet->getCell('A4')->setValue('Risk ID');
		$activeSheet->getColumnDimension('A')->setWidth(10);
		$activeSheet->getStyle('B4')->applyFromArray($style6);
		$activeSheet->mergeCells('B4:B5');
		$activeSheet->getCell('B4')->setValue('Date Raised');
		$activeSheet->getColumnDimension('B')->setWidth(15);
		$activeSheet->getStyle('C4')->applyFromArray($style6);
		$activeSheet->mergeCells('C4:C5');
		$activeSheet->getCell('C4')->setValue('Raised by');
		$activeSheet->getColumnDimension('C')->setWidth(15);
		$activeSheet->getStyle('D4')->applyFromArray($style6);
		$activeSheet->mergeCells('D4:D5');
		$activeSheet->getCell('D4')->setValue('Risk Category');
		$activeSheet->getColumnDimension('D')->setWidth(15);
		$activeSheet->getStyle('E4')->applyFromArray($style6);
		$activeSheet->mergeCells('E4:E5');
		$activeSheet->getCell('E4')->setValue('Event');
		$activeSheet->getColumnDimension('E')->setWidth(25);
		$activeSheet->getStyle('F4')->applyFromArray($style6);
		$activeSheet->mergeCells('F4:F5');
		$activeSheet->getCell('F4')->setValue('Cause');
		$activeSheet->getColumnDimension('F')->setWidth(20);
		$activeSheet->getStyle('G4')->applyFromArray($style6);
		$activeSheet->mergeCells('G4:G5');
		$activeSheet->getCell('G4')->setValue('Consequence');
		$activeSheet->getColumnDimension('G')->setWidth(20);
		$activeSheet->getRowDimension('4')->setRowHeight(25);
		$activeSheet->getStyle('H4')->applyFromArray($style6);
		$activeSheet->mergeCells('H4:J4');
		$activeSheet->getCell('H4')->setValue('Residual Risk Analysis');
		$activeSheet->getCell('H5')->setValue('Likelihood');
		$activeSheet->getColumnDimension('H')->setWidth(15);
		$activeSheet->getCell('I5')->setValue('Consequence');
		$activeSheet->getColumnDimension('I')->setWidth(15);
		$activeSheet->getCell('J5')->setValue('Risk Rating');
		$activeSheet->getColumnDimension('J')->setWidth(15);
		$activeSheet->getStyle('K4')->applyFromArray($style6);
		$activeSheet->mergeCells('K4:K5');
		$activeSheet->getCell('K4')->setValue('Action');
		$activeSheet->getColumnDimension('K')->setWidth(15);
		$activeSheet->getStyle('L4')->applyFromArray($style6);
		$activeSheet->mergeCells('L4:L5');
		$activeSheet->getCell('L4')->setValue('Plan');
		$activeSheet->getColumnDimension('L')->setWidth(70);
		$activeSheet->getStyle('M4')->applyFromArray($style6);
		$activeSheet->mergeCells('M4:M5');
		$activeSheet->getCell('M4')->setValue('Risk Owner');
		$activeSheet->getColumnDimension('M')->setWidth(15);
		$activeSheet->getStyle('N4')->applyFromArray($style6);
		$activeSheet->mergeCells('N4:N5');
		$activeSheet->getCell('N4')->setValue('Resolved by');
		$activeSheet->getColumnDimension('N')->setWidth(15);
		$activeSheet->getStyle('O4')->applyFromArray($style6);
		$activeSheet->mergeCells('O4:O5');
		$activeSheet->getCell('O4')->setValue('Method');
		$activeSheet->getColumnDimension('O')->setWidth(25);
		$activeSheet->getStyle('P4')->applyFromArray($style6);
		$activeSheet->mergeCells('P4:P5');
		$activeSheet->getCell('P4')->setValue('Progress and Compliance Reporting');
		$activeSheet->getColumnDimension('P')->setWidth(30);
		$activeSheet->getStyle('Q4')->applyFromArray($style6);
		$activeSheet->mergeCells('Q4:Q5');
		$activeSheet->getCell('Q4')->setValue('Status');
		$activeSheet->getColumnDimension('Q')->setWidth(15);
		$activeSheet->getStyle("P4")->getAlignment()->setWrapText(true);
		$activeSheet->getStyle('H5:Q5')->applyFromArray($style6);
		$activeSheet->getRowDimension('5')->setRowHeight(25);

		$style7 = array(
				'borders'  => array(
						'allborders'  => array('style'=>PHPExcel_Style_Border::BORDER_THIN,)
				)
		);
		$activeSheet->getStyle("A2:Q2")->applyFromArray($style7);
		$activeSheet->getStyle("A3:Q3")->applyFromArray($style7);
		$activeSheet->getStyle("A4:Q4")->applyFromArray($style7);
		$activeSheet->getStyle("A5:Q5")->applyFromArray($style7);

		$style8 = array(
				'font'  => array(
						'bold'  => false,
						'color' => array('rgb' => '000000'),
						'size'  => 12,
						'name'  => 'Arial'
				),
				'alignment'  => array(
						'horizontal'  => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
						'vertical'  => PHPExcel_Style_Alignment::VERTICAL_CENTER
				),
				'fill'  => array(
						'type' => PHPExcel_Style_Fill::FILL_SOLID,
						'color' => array('rgb' => 'F2F2F2')
				)
		);
		$count = 6;
		$id = 1;
		foreach ($result as $row){
			$activeSheet->getCell('A'.$count)->setValue($id);
			$activeSheet->getCell('B'.$count)->setValue($row->date_raised);
			$activeSheet->getCell('C'.$count)->setValue($row->username);
			$activeSheet->getCell('D'.$count)->setValue($row->category);
			$activeSheet->getCell('E'.$count)->setValue($row->event);
			$activeSheet->getCell('F'.$count)->setValue($row->cause);

			$activeSheet->getStyle("A".$count.":Q".$count)->applyFromArray($style8);
			$activeSheet->getStyle("A".$count.":Q".$count)->applyFromArray($style7);
			$activeSheet->getStyle("A".$count.":Q".$count)->getAlignment()->setWrapText(true);
			$count++;
			$id++;
		}
		$activeSheet->freezePane("F1");

		//destification sheet
		$sheet->createSheet();
		$activeSheet2 = $sheet->getSheet(1);
		$activeSheet2->setTitle("destification");

		//Assessment likelihood sheet
		$sheet->createSheet();
		$activeSheet3 = $sheet->getSheet(2);
		$activeSheet3->setTitle("Assessment Likelihood");
		$activeSheet3->getStyle('A1')->applyFromArray($style1);
		$activeSheet3->mergeCells('A1:E1');
		$activeSheet3->getCell('A1')->setValue('Assessment Likelihood');
		$activeSheet3->getStyle('A2')->applyFromArray($style6);
		$activeSheet3->getCell('A2')->setValue('ID');
		$activeSheet3->getColumnDimension('A')->setWidth(10);
		$activeSheet3->getStyle('B2')->applyFromArray($style6);
		$activeSheet3->getCell('B2')->setValue('Likelihood');
		$activeSheet3->getColumnDimension('B')->setWidth(20);
		$activeSheet3->getStyle('C2')->applyFromArray($style6);
		$activeSheet3->getCell('C2')->setValue('Risk');
		$activeSheet3->getColumnDimension('C')->setWidth(40);
		$activeSheet3->getStyle('D2')->applyFromArray($style6);
		$activeSheet3->getCell('D2')->setValue('Opportunity');
		$activeSheet3->getColumnDimension('D')->setWidth(40);
		$activeSheet3->getStyle('E2')->applyFromArray($style6);
		$activeSheet3->getCell('E2')->setValue('type');
		$activeSheet3->getColumnDimension('E')->setWidth(20);
		$activeSheet3->getRowDimension('2')->setRowHeight(15);
		$activeSheet3->getStyle("A2:E2")->applyFromArray($style7);

		$count = 3;
		$id = 1;
		foreach ($likelihood as $row){
			$activeSheet3->getCell('A'.$count)->setValue($id);
			$activeSheet3->getCell('B'.$count)->setValue($row->name);
			$activeSheet3->getCell('C'.$count)->setValue($row->risk);
			$activeSheet3->getCell('D'.$count)->setValue($row->opportunity);
			$activeSheet3->getCell('E'.$count)->setValue($row->type);

			$activeSheet3->getStyle("A".$count.":E".$count)->applyFromArray($style8);
			$activeSheet3->getStyle("A".$count.":E".$count)->applyFromArray($style7);
			$activeSheet3->getStyle("A".$count.":E".$count)->getAlignment()->setWrapText(true);
			$count++;
			$id++;
		}
		$activeSheet3->freezePane("A3");
		//Assessment consequence sheet
		$sheet->createSheet();
		$activeSheet4 = $sheet->getSheet(3);
		$activeSheet4->setTitle("Assessment Consequence");
		$activeSheet4->getStyle('A1')->applyFromArray($style1);
		$activeSheet4->mergeCells('A1:E1');
		$activeSheet4->getCell('A1')->setValue('Assessment Consequence');
		$activeSheet4->getStyle('A2')->applyFromArray($style6);
		$activeSheet4->getCell('A2')->setValue('ID');
		$activeSheet4->getColumnDimension('A')->setWidth(10);
		$activeSheet4->getStyle('B2')->applyFromArray($style6);
		$activeSheet4->getCell('B2')->setValue('Impact');
		$activeSheet4->getColumnDimension('B')->setWidth(20);
		$activeSheet4->getStyle('C2')->applyFromArray($style6);
		$activeSheet4->getCell('C2')->setValue('Risk');
		$activeSheet4->getColumnDimension('C')->setWidth(40);
		$activeSheet4->getStyle('D2')->applyFromArray($style6);
		$activeSheet4->getCell('D2')->setValue('Opportunity');
		$activeSheet4->getColumnDimension('D')->setWidth(40);
		$activeSheet4->getStyle('E2')->applyFromArray($style6);
		$activeSheet4->getCell('E2')->setValue('type');
		$activeSheet4->getColumnDimension('E')->setWidth(20);
		$activeSheet4->getRowDimension('2')->setRowHeight(15);
		$activeSheet4->getStyle("A2:E2")->applyFromArray($style7);

		$count = 3;
		$id = 1;
		foreach ($consequence as $row){
			$activeSheet4->getCell('A'.$count)->setValue($id);
			$activeSheet4->getCell('B'.$count)->setValue($row->name);
			$activeSheet4->getCell('C'.$count)->setValue($row->risk);
			$activeSheet4->getCell('D'.$count)->setValue($row->opportunity);
			$activeSheet4->getCell('E'.$count)->setValue($row->type);

			$activeSheet4->getStyle("A".$count.":E".$count)->applyFromArray($style8);
			$activeSheet4->getStyle("A".$count.":E".$count)->applyFromArray($style7);
			$activeSheet4->getStyle("A".$count.":E".$count)->getAlignment()->setWrapText(true);
			$count++;
			$id++;
		}
		$activeSheet4->freezePane("A3");
		//Rating Matrix sheet
		$sheet->createSheet();
		$activeSheet5 = $sheet->getSheet(4);
		$activeSheet5->setTitle("Rating Matrix");
		$activeSheet5->getStyle('A1')->applyFromArray($style1);
		$activeSheet5->mergeCells('A1:E1');
		$activeSheet5->getCell('A1')->setValue('Rating Matrix');
		$activeSheet5->getStyle('A2')->applyFromArray($style6);
		$activeSheet5->getCell('A2')->setValue('ID');
		$activeSheet5->getColumnDimension('A')->setWidth(10);
		$activeSheet5->getStyle('B2')->applyFromArray($style6);
		$activeSheet5->getCell('B2')->setValue('Likelihood');
		$activeSheet5->getColumnDimension('B')->setWidth(20);
		$activeSheet5->getStyle('C2')->applyFromArray($style6);
		$activeSheet5->getCell('C2')->setValue('Consequence');
		$activeSheet5->getColumnDimension('C')->setWidth(20);
		$activeSheet5->getStyle('D2')->applyFromArray($style6);
		$activeSheet5->getCell('D2')->setValue('type');
		$activeSheet5->getColumnDimension('D')->setWidth(20);
		$activeSheet5->getStyle('E2')->applyFromArray($style6);
		$activeSheet5->getCell('E2')->setValue('value');
		$activeSheet5->getColumnDimension('E')->setWidth(20);
		$activeSheet5->getRowDimension('2')->setRowHeight(15);
		$activeSheet5->getStyle("A2:E2")->applyFromArray($style7);

		$count = 3;
		$id = 1;
		foreach ($rating_matrix as $row){
			$activeSheet5->getCell('A'.$count)->setValue($id);
			$activeSheet5->getCell('B'.$count)->setValue($row->likelihood_name);
			$activeSheet5->getCell('C'.$count)->setValue($row->consequence_name);
			$activeSheet5->getCell('D'.$count)->setValue($row->type);
			if ($risk_type == "0"){
				$sql = "select IF (".$row->value." >= a. START && ".$row->value." <= a.END,a. LEVEL,NULL) name
						FROM risk_value a where company_id = ".$consultant_id." and type = 0 having name is not NULL";
			}else if ($risk_type == "1"){
				$sql = "select IF (".$row->value." >= a. START && ".$row->value." <= a.END,a. LEVEL,NULL) name
						FROM risk_value a where company_id = ".$consultant_id." and type != 0 having name is not NULL";
			}
			$value = @$this->db->query($sql)->row();
			$activeSheet5->getCell('E'.$count)->setValue($value->name);

			$activeSheet5->getStyle("A".$count.":E".$count)->applyFromArray($style8);
			$activeSheet5->getStyle("A".$count.":E".$count)->applyFromArray($style7);
			$activeSheet5->getStyle("A".$count.":E".$count)->getAlignment()->setWrapText(true);
			$count++;
			$id++;
		}
		$activeSheet5->freezePane("A3");
		//Assessment controls sheet
		$sheet->createSheet();
		$activeSheet6 = $sheet->getSheet(5);
		$activeSheet6->setTitle("Assessment Controls");
		$activeSheet6->getStyle('A1')->applyFromArray($style1);
		$activeSheet6->mergeCells('A1:D1');
		$activeSheet6->getCell('A1')->setValue('Assessment Controls');
		$activeSheet6->getStyle('A2')->applyFromArray($style6);
		$activeSheet6->getCell('A2')->setValue('ID');
		$activeSheet6->getColumnDimension('A')->setWidth(10);
		$activeSheet6->getStyle('B2')->applyFromArray($style6);
		$activeSheet6->getCell('B2')->setValue('Rating');
		$activeSheet6->getColumnDimension('B')->setWidth(20);
		$activeSheet6->getStyle('C2')->applyFromArray($style6);
		$activeSheet6->getCell('C2')->setValue('Action');
		$activeSheet6->getColumnDimension('C')->setWidth(40);
		$activeSheet6->getStyle('D2')->applyFromArray($style6);
		$activeSheet6->getCell('D2')->setValue('Description');
		$activeSheet6->getColumnDimension('D')->setWidth(40);
		$activeSheet6->getRowDimension('2')->setRowHeight(15);
		$activeSheet6->getStyle("A2:D2")->applyFromArray($style7);

		$count = 3;
		$id = 1;
		foreach ($assessment_controls as $row){
			$activeSheet6->getCell('A'.$count)->setValue($id);
			$activeSheet6->getCell('B'.$count)->setValue($row->rating);
			$activeSheet6->getCell('C'.$count)->setValue($row->action);
			$activeSheet6->getCell('D'.$count)->setValue($row->description);

			$activeSheet6->getStyle("A".$count.":D".$count)->applyFromArray($style8);
			$activeSheet6->getStyle("A".$count.":D".$count)->applyFromArray($style7);
			$activeSheet6->getStyle("A".$count.":D".$count)->getAlignment()->setWrapText(true);
			$count++;
			$id++;
		}
		$activeSheet6->freezePane("A3");
		//treatment sheet
		$sheet->createSheet();
		$activeSheet7 = $sheet->getSheet(6);
		$activeSheet7->setTitle("treatment");


		$sheet->setActiveSheetIndex(0);

		header('Content-Encoding: utf-8');
		header('Content-Type: application/vnd.ms-excel');
//
		header('Content-Disposition: attachment;filename="report.xls"');
		header('Cache-Control: max-age=0');

		$objWriter = PHPExcel_IOFactory::createWriter($sheet, 'Excel5');
//		$objWriter->setPreCalculateFormulas(false);
		$objWriter->save('php://output');
	} catch(Exception $e) {
		echo($e->getMessage());
	}
?>