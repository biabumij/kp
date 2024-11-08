<!DOCTYPE html>
<html>
	<head>
	  <title>LAPORAN HUTANG</title>
	  
	  <style type="text/css">
		 body {
			font-family: helvetica;
		}

		table tr.table-judul{
			background-color: #e69500;
			font-weight:bold; 
			font-size: 7px;
			color: black;
		}
			
		table tr.table-baris1{
			background-color: none;
			font-size: 7px;
		}

		table tr.table-baris1-bold{
			background-color: none;
			font-size: 7px;
			font-weight:bold; 
		}
			
		table tr.table-total{
			font-weight:bold; 
			font-size: 7px;
			color: black;
		}

		table tr.table-total2{
			background-color: #cccccc;
			font-weight:bold; 
			font-size: 7px;
			color: black;
		}
	  </style>

	</head>
	<body>
		<div align="center" style="display: block;font-weight:bold; font-size: 11px;">LAPORAN HUTANG</div>
		<div align="center" style="display: block;font-weight:bold; font-size: 11px;">BP TRENGGALEK</div>
		<br /><br /><br />
		<?php
		$data = array();
		
		$arr_date = $this->input->get('filter_date');
		$arr_filter_date = explode(' - ', $arr_date);
		$date1 = '';
		$date2 = '';

		if(count($arr_filter_date) == 2){
			$date1 	= date('Y-m-d',strtotime($arr_filter_date[0]));
			$date2 	= date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('d F Y',strtotime($arr_filter_date[0])).' - '.date('d F Y',strtotime($arr_filter_date[1]));
		}
		
		?>
		
		<table width="98%" border="1" cellpadding="3">
			<tr class="table-judul">
				<th width="3%" align="center" rowspan="2">&nbsp; <br />NO.</th>
				<th width="17%" align="center" rowspan="2">&nbsp; <br />REKANAN</th>
				<th width="28%" align="center" colspan="4">TAGIHAN / TERMIN</th>
				<th width="33%" align="center" colspan="5">PEMBAYARAN</th>
				<th width="20%" align="center" colspan="3">HUTANG</th>
			</tr>
			<tr class="table-judul">
				<th align="center">DPP</th>
				<th align="center">PPH</th>
				<th align="center">PPN</th>
				<th align="center">Jumlah</th>
				<th align="center">DPP</th>
				<th align="center">Pos Silang<br />Piutang / Hutang</th>
				<th align="center">PPH</th>
				<th align="center">PPN</th>
				<th align="center">Jumlah</th>
				<th align="center">DPP</th>
				<th align="center">PPN</th>
				<th align="center">Jumlah</th>
			</tr>
			<tr class="table-baris1">
				<th align="center">1.</th>
				<th align="left">PT Kalitelu Teknik</th>
				<th align="right"><?php echo number_format(532921735,0,',','.');?></th>
				<th align="right">-</th>
				<th align="right"><?php echo number_format(265076333.8,0,',','.');?></th>
				<th align="right"><?php echo number_format(797998068.8,0,',','.');?></th>
				<th align="right"><?php echo number_format(508963335,0,',','.');?></th>
				<th align="right">-</th>
				<th align="right">-</th>
				<th align="right">-</th>
				<th align="right"><?php echo number_format(508963335,0,',','.');?></th>
				<th align="right"><?php echo number_format(23958400,0,',','.');?></th>
				<th align="right"><?php echo number_format(265076333.8,0,',','.');?></th>
				<th align="right"><?php echo number_format(289034733.8,0,',','.');?></th>
			</tr>
			<tr class="table-baris1">
				<th align="center">2.</th>
				<th align="left">PT Heleh Westo Bene</th>
				<th align="right"><?php echo number_format(45484740,0,',','.');?></th>
				<th align="right">-</th>
				<th align="right">-</th>
				<th align="right"><?php echo number_format(45484740,0,',','.');?></th>
				<th align="right"><?php echo number_format(2784234,0,',','.');?></th>
				<th align="right">-</th>
				<th align="right">-</th>
				<th align="right">-</th>
				<th align="right"><?php echo number_format(2784234,0,',','.');?></th>
				<th align="right"><?php echo number_format(42700506,0,',','.');?></th>
				<th align="right">-</th>
				<th align="right"><?php echo number_format(42700506,0,',','.');?></th>
			</tr>
			<tr class="table-baris1">
				<th align="center">3.</th>
				<th align="left">PT Bia Bumi Jayendra Div. Cutting Stone</th>
				<th align="right"><?php echo number_format(3280543395,0,',','.');?></th>
				<th align="right">-</th>
				<th align="right">-</th>
				<th align="right"><?php echo number_format(3280543395,0,',','.');?></th>
				<th align="right"><?php echo number_format(2643046784,0,',','.');?></th>
				<th align="right"><?php echo number_format(574728501,0,',','.');?></th>
				<th align="right">-</th>
				<th align="right">-</th>
				<th align="right"><?php echo number_format(3217775285,0,',','.');?></th>
				<th align="right"><?php echo number_format(62768110,0,',','.');?></th>
				<th align="right">-</th>
				<th align="right"><?php echo number_format(62768110,0,',','.');?></th>
			</tr>
			<tr class="table-baris1">
				<th align="center">4.</th>
				<th align="left">PT Nindya Karya (Persero) Div. Alat</th>
				<th align="right"><?php echo number_format(420500000,0,',','.');?></th>
				<th align="right"><?php echo number_format(8410000,0,',','.');?></th>
				<th align="right"><?php echo number_format(42050000,0,',','.');?></th>
				<th align="right"><?php echo number_format(454140000,0,',','.');?></th>
				<th align="right"><?php echo number_format(313000000,0,',','.');?></th>
				<th align="right">-</th>
				<th align="right"><?php echo number_format(6260000,0,',','.');?></th>
				<th align="right">-</th>
				<th align="right"><?php echo number_format(306740000,0,',','.');?></th>
				<th align="right"><?php echo number_format(107500000,0,',','.');?></th>
				<th align="right"><?php echo number_format(42050000,0,',','.');?></th>
				<th align="right"><?php echo number_format(149550000,0,',','.');?></th>
			</tr>
			<tr class="table-total2">
				<th align="center" colspan="2">TOTAL HUTANG</th>
				<th align="right"><?php echo number_format(4279449870,0,',','.');?></th>
				<th align="right"><?php echo number_format(8410000,0,',','.');?></th>
				<th align="right"><?php echo number_format(307126333.8,0,',','.');?></th>
				<th align="right"><?php echo number_format(4578166203.8,0,',','.');?></th>
				<th align="right"><?php echo number_format(3467794353,0,',','.');?></th>
				<th align="right"><?php echo number_format(574728501,0,',','.');?></th>
				<th align="right"><?php echo number_format(6260000,0,',','.');?></th>
				<th align="right">-</th>
				<th align="right"><?php echo number_format(4036262854,0,',','.');?></th>
				<th align="right"><?php echo number_format(236927016,0,',','.');?></th>
				<th align="right"><?php echo number_format(307126333.8,0,',','.');?></th>
				<th align="right"><?php echo number_format(544053349.8,0,',','.');?></th>
			</tr>
		</table>
		
			
	</body>
</html>