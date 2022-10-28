<!DOCTYPE html>
<html>
	<head>
	  <?= include 'lib.php'; ?>
	  <title>Stok</title>

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
	  	body{
	  		font-family: "Open Sans", Arial, sans-serif;
	  	}
	  	table.minimalistBlack {
		  border: 0px solid #000000;
		  width: 100%;
		  text-align: left;
		}
		table.minimalistBlack td, table.minimalistBlack th {
		  border: 1px solid #000000;
		  padding: 5px 4px;
		}
		table.minimalistBlack tr td {
		  /*font-size: 13px;*/
		  text-align:center;
		}
		table.minimalistBlack tr th {
		  /*font-size: 14px;*/
		  font-weight: bold;
		  color: #000000;
		  text-align: center;
		  padding: 10px;
		}
		table.head tr th {
		  /*font-size: 14px;*/
		  font-weight: bold;
		  color: #000000;
		  text-align: left;
		  padding: 10px;
		}
		table tr.table-active{
            background-color: #b5b5b5;
        }
        table tr.table-active2{
            background-color: #cac8c8;
        }
		table tr.table-active3{
            background-color: #eee;
        }
		hr{
			margin-top:0;
			margin-bottom:30px;
		}
		h3{
			margin-top:0;
		}
	  </style>

	</head>
	<body>
		<table width="100%" border="0" cellpadding="3">
			<tr>
				<td align="center">
					<div style="display: block;font-weight: bold;font-size: 12px;">STOCK OPNAME</div>
					<div style="display: block;font-weight: bold;font-size: 12px; text-transform: uppercase;">PERIODE <?php echo str_replace($search, $replace, $subject);?></div>
				</td>
			</tr>
		</table>
		<br />
		<br />
		<table class="minimalistBlack" cellpadding="5" width="98%">
			<tr class="table-active">
				<th align="center" width="5%">NO.</th>
				<th align="center" width="10%">TANGGAL</th>
				<th align="center" width="20%">PRODUK</th>
				<th align="center" width="10%">STOK</th>
				<th align="center" width="10%">SATUAN</th>
				<th align="center" width="15%">HARGA SATUAN</th>
				<th align="center" width="15%">JUMLAH</th>
				<th align="center" width="15%">KETERANGAN</th>
            </tr>

			<?php
			$stok = $this->db->select('s.*')
			->from('stok s')
			->join('produk p','s.produk = p.id','left')
			->where("(s.tanggal between '$date1' and '$date2')")
			->order_by('p.nama_produk','asc')
			->get()->result_array();

           	$no = 0 ;
            $total = 0;
			
           	foreach ($stok as $row) : ?>  
               <tr>
                   <td align="center"><?php echo $no+1;?></td>
                   <td align="left"><?= $row["tanggal"] = date('d-m-Y',strtotime($row["tanggal"])); ?></td>
				   <td align="left"><?= $this->crud_global->GetField('produk',array('id'=>$row['produk']),'nama_produk');?></td>
				   <td align="center"><?= number_format($row['stok'],0,',','.'); ?></td>
	               <td align="center"><?= $this->crud_global->GetField('satuan',array('id'=>$row['satuan']),'nama_satuan');?></td>
	               <td align="right"><?= number_format($row['harga_satuan'],0,',','.'); ?></td>
	               <td align="right"><?= number_format($row['jumlah'],0,',','.'); ?></td>
				   <td align="center"><?= $row["keterangan"]; ?></td>
               </tr>

			<?php
			$no++;
			$total += $row['jumlah'];
			endforeach; ?>

            
            <tr>
                <th colspan="6" align="right">TOTAL</th>
                <th align="right"><?= number_format($total,0,',','.'); ?></th>
				<th align="right"></th>
            </tr>
           	
		</table>
		<table width="98%" border="0" cellpadding="10">
			<tr >
				<td width="5%"></td>
				<td width="90%">
					<table width="100%" border="0" cellpadding="2">
						<tr>
							<td align="center">
								Diketahui Oleh
							</td>
							<td align="center">
								Disetujui Oleh
							</td>
							<td align="center" >
								Diperiksa Oleh
							</td>
							<td align="center" >
								Diminta Oleh
							</td>	
						</tr>
						<tr class="">
							<td align="center" height="35px">
								
							</td>
							<td align="center">
								
							</td>
							<td align="center">
								
							</td>
							<td align="center">
								
							</td>
						</tr>
						<tr>
							<td align="center" >
								<b><u>Erika Sinaga</u><br />
								M. Keuangan & SDM</b>
							</td>
							<td align="center" >
								<b><u>Debi Khania</u><br />
								Keuangan & SDM</b>
							</td>
							<td align="center">
								<b><u>Feby Puji Lestari</u><br />
								Kasir</b>
							</td>
							<td align="center">
								<b><u>Ahmad Rozi</u><br />
								Staff Operasional</b>
							</td>
						</tr>
					</table>
				</td>
				<td width="5%"></td>
			</tr>
		</table>
	</body>
</html>