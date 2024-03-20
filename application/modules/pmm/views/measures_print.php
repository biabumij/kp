<!DOCTYPE html>
<html>
	<head>
	  <title>SATUAN</title>
	  
	  <style type="text/css">
		 body {
			font-family: helvetica;
		}

		table.table-border-pojok-kiri, th.table-border-pojok-kiri, td.table-border-pojok-kiri {
			border-top: 1px solid black;
			border-bottom: 1px solid black;
			border-right: 1px solid #cccccc;
			border-left: 1px solid black;
		}

		table.table-border-pojok-tengah, th.table-border-pojok-tengah, td.table-border-pojok-tengah {
			border-top: 1px solid black;
			border-bottom: 1px solid black;
			border-right: 1px solid #cccccc;
		}

		table.table-border-pojok-kanan, th.table-border-pojok-kanan, td.table-border-pojok-kanan {
			border-top: 1px solid black;
			border-bottom: 1px solid black;
			border-right: 1px solid black;
		}

		table.table-border-spesial, th.table-border-spesial, td.table-border-spesial {
			border-left: 1px solid black;
			border-right: 1px solid black;
		}

		table.table-border-spesial-kiri, th.table-border-spesial-kiri, td.table-border-spesial-kiri {
			border-left: 1px solid black;
			border-top: 2px solid black;
			border-bottom: 2px solid black;
		}

		table.table-border-spesial-tengah, th.table-border-spesial-tengah, td.table-border-spesial-tengah {
			border-left: 1px solid #cccccc;
			border-right: 1px solid #cccccc;
			border-top: 2px solid black;
			border-bottom: 2px solid black;
		}

		table.table-border-spesial-kanan, th.table-border-spesial-kanan, td.table-border-spesial-kanan {
			border-left: 1px solid #cccccc;
			border-right: 1px solid black;
			border-top: 2px solid black;
			border-bottom: 2px solid black;
		}

		table tr.table-judul{
			border: 1px solid;
			background-color: #e69500;
			font-weight: bold;
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
			font-weight: bold;
		}
			
		table tr.table-total{
			background-color: #FFFF00;
			font-weight: bold;
			font-size: 7px;
			color: black;
		}

		table tr.table-total2{
			background-color: #eeeeee;
			font-weight: bold;
			font-size: 7px;
			color: black;
		}
	  </style>

	</head>
	<body>
		<table width="98%" cellpadding="3">
			<tr>
				<td align="center">
					<div style="display: block;font-weight: bold;font-size: 11px;">SATUAN</div>
				</td>
			</tr>
		</table>
		<br />
		<br />
		<br />
		<table cellpadding="3" width="98%">
			<tr class="table-judul">
                <th width="5%" align="center" class="table-border-pojok-kiri">NO.</th>
                <th width="75%" align="center" class="table-border-pojok-tengah">SATUAN</th>
                <th width="20%" align="center" class="table-border-pojok-kanan">STATUS</th>
            </tr>
            <?php
            
            $total = 0;
            $total_2 = 0;
            $no=1;
            if(!empty($data)){
            	foreach ($data as $key => $row) {

            		?>
            		<tr>
            			<td align="center" class="table-border-pojok-kiri"><?php echo $no;?>.</td>
            			<td class="table-border-pojok-tengah"><?php echo $row['measure_name'];?></td>
            			<td align="center" class="table-border-pojok-kanan"><?php echo $row['status'];?></td>
            		</tr>
            		<?php	
            		$no++;
			        	            		
            		
            	}
            }else {
            	?>
            	<tr>
            		<td width="100%" colspan="3" align="center">Tidak Ada Data</td>
            	</tr>
            	<?php
            }
            
            ?>	
           
          
		</table>

		
	</body>
</html>