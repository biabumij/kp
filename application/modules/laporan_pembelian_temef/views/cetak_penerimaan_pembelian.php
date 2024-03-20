<!DOCTYPE html>
<?php

$this->db2 = $this->load->database('database2', TRUE);
		?>
<html>
	<head>
	  <title>LAPORAN PENERIMAAN PEMBELIAN</title>
	  
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

		table tr.table-baris2-bold{
			font-size: 8px;
			background-color: #E8E8E8;
			font-weight: bold;
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
		<table width="98%" border="0" cellpadding="15">
			<tr>
				<td width="100%" align="center">
					<div style="display: block;font-weight: bold;font-size: 10px;">LAPORAN PENERIMAAN PEMBELIAN</div>
				    <div style="display: block;font-weight: bold;font-size: 10px;">PROYEK BENDUNGAN TEMEF</div>
				    <div style="display: block;font-weight: bold;font-size: 10px;">PT. BIA BUMI JAYENDRA</div>
					<div style="display: block;font-weight: bold;font-size: 10px; text-transform: uppercase;">PERIODE <?php echo str_replace($search, $replace, $subject);?></div>
				</td>
			</tr>
		</table>	
		<table cellpadding="4" width="98%">
			<tr class="table-judul">
                <th align="center" width="5%">NO.</th>
                <th align="left" width="30%">URAIAN / PRODUK</th>
                <th align="right" width="10%">SATUAN</th>
                <th align="right" width="15%">VOLUME</th>
				<th align="right" width="20%">HARGA SATUAN</th>
                <th align="right" width="20%">NILAI</th>
            </tr>
            <?php
			$total_vol = 0;
            if(!empty($data)){
            	foreach ($data as $key => $row) {
            		?>
            		<tr class="table-baris1-bold">
            			<td align="center"><?php echo $key + 1;?></td>
            			<td align="left"><?php echo $row['name'];?></td>
            			<td align="right"><?php echo $row['measure'];?></td>
            			<td align="right"><?php echo $row['volume'];?></td>
						<td align="right"></td>
            			<td align="right">
            				<table cellpadding="0" width="100%" border="0">
		    					<tr>
		    						<td width="20%" align="left">Rp.</td>
		    						<td width="80%" align="right"><?php echo $row['total_price'];?></td>
		    					</tr>
		    				</table>
            			</td>
						<?php
						$total_vol += str_replace(['.', ','], ['', '.'], $row['volume']);
						?>
            		</tr>
            		<?php
            		foreach ($row['mats'] as $mat) {
            			?>
            			<tr class="table-baris1">
	            			<td align="center"></td>
	            			<td align="left">&nbsp;&nbsp;&nbsp;<?php echo $mat['nama_produk'];?></td>
	            			<td align="right"><?php echo $mat['measure'];?></td>
	            			<td align="right"><?php echo $mat['volume'];?></td>
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
            		}
            		
            		
            	}
            }else {
            	?>
            	<tr>
            		<td width="100%" colspan="7" align="center">Tidak Ada Data</td>
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
    						<td width="80%" align="right"><?php echo number_format($total,0,',','.');?></td>
    					</tr>
    				</table>
            	</th>
            </tr>   
		</table>
	</body>
</html>