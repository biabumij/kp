<!DOCTYPE html>
<html>
	<head>
	  <title>LAPORAN PERNGIRIMAN PENJUALAN</title>
	  
	  <?php
		$search = array(
		'January',
		'February',
		'March',
		'April',
		'May',
		'June',
		'July',
		'August',
		'September',
		'October',
		'November',
		'December'
		);
		
		$replace = array(
		'Januari',
		'Februari',
		'Maret',
		'April',
		'Mei',
		'Juni',
		'Juli',
		'Agustus',
		'September',
		'Oktober',
		'November',
		'Desember'
		);
		
		$subject = "$filter_date";

		echo str_replace($search, $replace, $subject);

	  ?>
	  
	  <style type="text/css">
		body {
			font-family: helvetica;
		}
		
		table tr.table-judul{
			background-color: #e69500;
			font-weight: bold;
			font-size: 8px;
			color: black;
		}
			
		table tr.table-baris1{
			background-color: #F0F0F0;
			font-size: 8px;
		}

		table tr.table-baris1-bold{
			background-color: #F0F0F0;
			font-size: 8px;
			font-weight: bold;
		}
			
		table tr.table-baris2{
			font-size: 8px;
			background-color: #E8E8E8;
		}
			
		table tr.table-total{
			background-color: #cccccc;
			font-weight: bold;
			font-size: 8px;
			color: black;
		}
	  </style>

	</head>
	<body>
		<table width="98%" border="0" cellpadding="3">
			<tr>
				<td width="100%" align="center">
					<div style="display: block;font-weight: bold;font-size: 11px;">LAPORAN PENGIRIMAN PENJUALAN</div>
					<div style="display: block;font-weight: bold;font-size: 11px;">PROYEK BENDUNGAN TEMEF</div>
				    <div style="display: block;font-weight: bold;font-size: 11px;">PT. BIA BUMI JAYENDRA</div>
					<div style="display: block;font-weight: bold;font-size: 11px; text-transform: uppercase;">PERIODE <?php echo str_replace($search, $replace, $subject);?></div>
				</td>
			</tr>
		</table>
		<br />
		<br />
		<table cellpadding="4" width="98%">
			<tr class="table-judul">
                <th width="5%" align="center">NO.</th>
                <th width="40%" align="center">PELANGGAN / MUTU BETON</th>
				<th width="10%" align="center">SATUAN</th>
                <th width="15%" align="center">VOLUME</th>
				<th width="15%" align="center">HARGA SATUAN</th>
                <th width="15%" align="center">NILAI</th>
            </tr>
            <?php
			$vol_jasa_angkut = 0;
			$jasa_angkut = 0;
			$total_vol = 0;
			$total_vol_jasa_angkut = 0;
			$total_jasa_angkut = 0;
            if(!empty($data)){
            	foreach ($data as $key => $row) {
            		?>
            		<tr class="table-baris1-bold">
            			<td align="center"><?php echo $key + 1;?></td>
            			<td align="left" colspan="4"><?php echo $row['name'];?></td>
            			<td align="right"></td>
						<?php
						$total_vol += str_replace(['.', ','], ['', '.'], $row['real']);
						?>
            		</tr>
            		<?php
            		foreach ($row['mats'] as $mat) {
            			?>
            			<tr class="table-baris1">
	            			<td align="center"></td>
							<td align="left"><?php echo $mat['nama_produk'];?></td>
	            			<td align="center"><?php echo $mat['measure'];?></td>
	            			<td align="right"><?php echo $mat['real'];?></td>
							<td align="right">
	            				<table cellpadding="0" width="100%" border="0">
			    					<tr>
			    						<td width="20%" align="left">Rp.</td>
			    						<td width="80%" align="right"><?php echo $mat['price'];?></td>
			    					</tr>
			    				</table>
	            			</td>
	            			<td align="right">
	            				<table cellpadding="0" width="100%" border="0">
			    					<tr>
			    						<td width="20%" align="left">Rp.</td>
			    						<td width="80%" align="right"><?php echo $mat['total_price'];?></td>
			    					</tr>
			    				</table>
	            			</td>
	            		</tr>
            			<?php
						$total_vol_jasa_angkut += str_replace(['.', ','], ['', '.'], $mat['real']);
						$vol_jasa_angkut = $total_vol_jasa_angkut - $total_vol;
						$total_jasa_angkut += str_replace(['.', ','], ['', '.'], $mat['total_price']);
						$jasa_angkut = $total_jasa_angkut - $total;
            		}		
            	}
            }else {
            	?>
            	<tr>
            		<td width="100%" colspan="6" align="center">Tidak Ada Data</td>
            	</tr>
            	<?php
            }
            ?>
			<tr class="table-total">
            	<th align="right" colspan="3">TOTAL</th>
				<th align="right"><?php echo number_format($total_vol,2,',','.');?></th>
				<th align="right"></th>
            	<th align="right">
            		<table cellpadding="0" width="100%" border="0">
    					<tr>
    						<td width="20%" align="left">Rp.</td>
    						<td width="80%" align="right"><?php echo number_format($total_jasa_angkut,0,',','.');?></td>
    					</tr>
    				</table>
            	</th>
            </tr>
		</table>
	</body>
</html>