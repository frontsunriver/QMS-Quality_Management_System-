<?php
	require_once APPPATH.'third_party/excel/PHPExcel.php';
	try {
		$objPHPExcel = PHPExcel_IOFactory::load(realpath("assets/_excels/report.xls"));

		$objPHPExcel->setActiveSheetIndex(0);
		$sheet = $objPHPExcel->getActiveSheet(0);
		$sheet->getPageMargins()->setTop(0.6);
		$sheet->getPageMargins()->setLeft(0.4);
		$sheet->getPageMargins()->setRight(0.4);
		$sheet->getPageMargins()->setBottom(0.5);
		$sheet->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_B5);
		$sheet->getPageSetup()->clearPrintArea();
		
		$titleStyle = new PHPExcel_Style();
		$titleStyle->applyFromArray(
			array(
				"font" => array(
					"name" => 'Arial', "size" => '18pt', "bold" => true
				),
				"alignment" => array(
					"horizontal" => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					"vertical" => PHPExcel_Style_Alignment::VERTICAL_CENTER
				)
			)
		);
		$dataStyle = new PHPExcel_Style();
		$dataStyle->applyFromArray(
			array(
				"font" => array(
					"name" => 'Arial', "size" => '11pt'
				),
				"borders" => array(
					"bottom"	=> array('style' => PHPExcel_Style_Border::BORDER_HAIR),
					"right"	=> array('style' => PHPExcel_Style_Border::BORDER_HAIR),
					"left"	=> array('style' => PHPExcel_Style_Border::BORDER_HAIR),
					"top"		=> array('style' => PHPExcel_Style_Border::BORDER_HAIR)
				),
				'alignment' => array(
					'horizontal'	=> PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
					'vertical'	=> PHPExcel_Style_Alignment::VERTICAL_CENTER
				)
			)
		);
		$headerStyle = clone $dataStyle;
		$headerStyle->applyFromArray(
			array(
				'font' => array(
					'bold' => true
				)
			)
		);
	
		function getRange($row,$col,$rows = 1,$cols = 1) {
			return PHPExcel_Cell::stringFromColumnIndex($col) . $row . ":" . 
				PHPExcel_Cell::stringFromColumnIndex($col+$cols-1) .	($row+$rows-1);
		}
		function drawValue($sheet,$col,$row,$value,$align="center",$colspan=1,$rowspan=1) {
			if(!$colspan)
				$colspan = 1;
			if(!$rowspan)
				$rowspan = 1;
			if($colspan>1 || $rowspan>1)
				$sheet->mergeCellsByColumnAndRow($col,$row,$col+$colspan-1,$row+$rowspan-1);
			$sheet->setCellValueByColumnAndRow($col,$row,$value);
			if($align=="left")
				$sheet->getStyleByColumnAndRow($col,$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
			else if($align=="right")
				$sheet->getStyleByColumnAndRow($col,$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
			else
				$sheet->getStyleByColumnAndRow($col,$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		}
		function drawHeader($sheet,$group,$row=0,$col=0) {
			if(is_array($group)) {
				foreach($group as $i=>$line) {
					foreach($line as $j=>$cell) {
						if($cell===true)
							continue;
						$colspan = intval(array_key_exists('colspan',$cell)?$cell['colspan']:"0");
						$rowspan = intval(array_key_exists('rowspan',$cell)?$cell['rowspan']:"0");
						if(!$colspan)
							$colspan = 1;
						if(!$rowspan)
							$rowspan = 1;
						if($colspan>1 || $rowspan>1)
							$sheet->mergeCellsByColumnAndRow($col+$j,$row+$i,$col+$j+$colspan-1,$row+$i+$rowspan-1);
						$sheet->setCellValueByColumnAndRow($col+$j,$row+$i,$cell['text']);
					}
				}
			}
			return $row+count($group);
		}
		function drawData($sheet,$headers,$data,$row,$col=0,$rate=1) {
			global $index;
			if(is_array($headers)) {
				if(is_object($data))
					$data = get_object_vars($data);
				$style = "";
				if (array_key_exists('style',$data))
					$style = $data['style'];
				foreach($headers as $field) {
					$value = $data[$field['field']];
					if($field['type']=='index') {
						$value = ++$index;
						$sheet->setCellValueByColumnAndRow($col,$row,$value);
					} else if($field['type']=='money') {
						$sheet->getStyleByColumnAndRow($col,$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						$sheet->getStyleByColumnAndRow($col,$row)->getNumberFormat()->setFormatCode("# ### ### ### ##0.00");
						if($value==0)
							$value = "";
						else if($rate!=1)
							$value *= $rate;
						$sheet->setCellValueByColumnAndRow($col,$row,$value);
					} else {
						if($field['align']=="left")
							$sheet->getStyleByColumnAndRow($col,$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);				
						else if($field['align']=="right")
							$sheet->getStyleByColumnAndRow($col,$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);				
						else if($field['align']=="justify")
							$sheet->getStyleByColumnAndRow($col,$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_JUSTIFY);
						else
							$sheet->getStyleByColumnAndRow($col,$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
						if($field['type']=="number") {
							$sheet->setCellValueExplicitByColumnAndRow($col,$row,number_format($value,2),PHPExcel_Cell_DataType::TYPE_NUMERIC);
							$sheet->getStyleByColumnAndRow($col,$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
						} else if($field['type']=="formula") {
							if($field['value'])
								$value = $field['value'];
							$sheet->setCellValueExplicitByColumnAndRow($col,$row,$value,PHPExcel_Cell_DataType::TYPE_FORMULA);
							$sheet->getStyleByColumnAndRow($col,$row)->getNumberFormat()->setFormatCode("# ### ### ### ##0.00");
						} else {
							$sheet->setCellValueExplicitByColumnAndRow($col,$row,str_replace("&nbsp;"," ",$value),PHPExcel_Cell_DataType::TYPE_STRING);
						}
					}
					if($style=="bold") {
						$sheet->getStyleByColumnAndRow($col,$row)->getFont()->setBold(true);
					}
					$col++;
				}
				return $row+1;
			}
		}
		
		$headers = array();
		if(is_array($columns)) {
			$group_headers = array_fill(0,count($columns),array());
			foreach($columns as $i=>$line) {
				for($j = 0;isset($group_headers[$i][$j]);$j++);
				foreach($line as $cell) {
					$colspan = intval(array_key_exists('colspan',$cell)?$cell['colspan']:"0");
					$rowspan = intval(array_key_exists('rowspan',$cell)?$cell['rowspan']:"0");
					if($rowspan==0)
						$rowspan = 1;
					if($colspan==0)
						$colspan = 1;
					if($colspan==1) {
						$headers[$j] = $cell;
						$group_headers[$i][$j] = $cell;
						for($k = 1;$k<$rowspan;$k++) {
							$group_headers[$i+$k][$j] = true;
						}
					} else {
						$group_headers[$i][$j] = $cell;
						for($k = 1;$k<$colspan;$k++) {
							$group_headers[$i][$j+$k] = true;
						}
					}
					$j += $colspan;
				}
			}
		}
		$sheet->setBreakByColumnAndRow(count($headers),0,PHPExcel_Worksheet::BREAK_COLUMN);
		$col = 0;$row = 1;

		$row++;
		drawValue($sheet, $col, $row, $title, "center", count($headers));
		$sheet->setSharedStyle($titleStyle,getRange($row, $col));
		$row++;
		if (isset($range))
			drawValue($sheet, $col, $row, $range, "left", 3);
		/*if($money_unit)
			drawValue($sheet, count($headers)-3, $row, "[ $money_unit ]", "right", 3);*/
		$row++;
		
		$sheet->setSharedStyle($headerStyle,getRange($row, $col, count($columns), count($headers)));
		$sheet->getPageSetup()->setRowsToRepeatAtTop(range($row,$row+count($columns)-1));
		$row = drawHeader($sheet,$group_headers,$row);
		$sheet->setSharedStyle($dataStyle,getRange($row, $col, count($result), count($headers)));
		
		foreach($result as $data) {
			$row = drawData($sheet,$headers,$data,$row,0);
		}
		if(is_array($summary)) {
			$sheet->setSharedStyle($dataStyle,getRange($row, $col, count($summary), count($headers)));
			foreach($summary as $data) {
				$row = drawData($sheet,$headers,$data,$row,0);
			}
		} else {
			$sheet->setSharedStyle($dataStyle,getRange($row, $col, 1, count($headers)));
			foreach($headers as $i=>$field) {
				if($field[type]=="money" && $field[autoSummary]!==false) {
					$sheet->setCellValueExplicitByColumnAndRow($col+$i,$row,"=SUM(" . getRange(4+count($columns),$col+$i,count($result)) . ")",PHPExcel_Cell_DataType::TYPE_FORMULA);
					$sheet->getStyleByColumnAndRow($col+$i,$row)->getNumberFormat()->setFormatCode("# ### ### ### ##0.00");
					$sheet->getStyleByColumnAndRow($col+$i,$row)->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
				}
			}
		}

		$sheet->getPageSetup()->setFitToWidth();
		$sheet->calculateColumnWidths();

		$header = array(
				array('text'=>'111', 'field'=>"risk_id",'align'=>"left",'type'=>""),
				array('text'=>'222', 'field'=>"assess_type",'align'=>"left",'type'=>""),
				array('text'=>'333', 'field'=>"description",'align'=>"right",'type'=>"")
		);
		$objPHPExcel->createSheet();
		$objPHPExcel->setActiveSheetIndex(1);
		$activeSheet2 = $objPHPExcel->getActiveSheet(1);
		$activeSheet2->setTitle("Risk");
		$activeSheet2->getStyle('A1:T1')->getFont()->setBold(true);
		$activeSheet2->fromArray($header,null,'A1');
		$activeSheet2->fromArray($result,null,'A2');

		header('Content-Encoding: utf-8');	
		header('Content-Type: application/vnd.ms-excel');

		header('Content-Disposition: attachment;filename="report.xls"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
		$objWriter->setPreCalculateFormulas(false);
		$objWriter->save('php://output');
	} catch(Exception $e) {
		echo($e->getMessage());
	}
?>