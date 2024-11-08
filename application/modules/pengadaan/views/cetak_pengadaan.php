<!DOCTYPE html>
<html>
	<head>
	  <?= include 'lib.php'; ?>
	  <title>Pengadaan</title>
	  
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
					<div style="display: block;font-weight: bold;font-size: 12px;">PERMINTAAN PENGADAAN BARANG DAN JASA</div>
					<?php
					$judul = $this->db->select('p.*')
					->from('pengadaan p ')
					->where('p.id',$id)
					->get()->row_array();

					$tanggal = $judul['tanggal_permintaan'];
					$date = date('Y-m-d',strtotime($tanggal));
					?>
					<div style="display: block;font-weight: bold;font-size: 12px; text-transform: uppercase;"><?= $judul["judul"] ?></div>
					<?php
					function tgl_indo($date){
						$bulan = array (
							1 =>   'Januari',
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
						$pecahkan = explode('-', $date);
						
						// variabel pecahkan 0 = tanggal
						// variabel pecahkan 1 = bulan
						// variabel pecahkan 2 = tahun
					
						return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
						
					}
					?>

					<div style="display: block;font-weight: bold;font-size: 12px; text-transform: uppercase;">(<?= tgl_indo(date($date)); ?>)</div>
				</td>
			</tr>
		</table>
		<br />
		<br />
		<table class="minimalistBlack" cellpadding="5" width="98%">
			<tr class="table-active">
				<th align="center" width="5%" rowspan="2">&nbsp; <br />NO.</th>
				<th align="center" width="25%" rowspan="2">&nbsp; <br />JENIS BARANG / JASA</th>
				<th align="center" width="8%" rowspan="2">&nbsp; <br />QTY</th>
				<th align="center" width="8%" rowspan="2">&nbsp; <br />SATUAN</th>
				<th align="center" width="28%" colspan="2">PERKIRAAN HARGA</th>
				<th align="center" width="25%" colspan="2">&nbsp; <br />KETERANGAN</th>
            </tr>
			<tr class="table-active">
				<th>HARGA SATUAN</th>
				<th>JUMLAH</th>
				<th>STOK</th>
				<th>KEBUTUHAN</th>
			</tr>

			<?php
			$pengadaan = $this->db->select('pd.judul, pd.tanggal_permintaan, pdt.*, p.nama_produk')
			->from('pengadaan pd')
			->join('pengadaan_detail pdt','pd.id = pdt.pengadaan_id','left')
			->join('produk p','pdt.produk = p.id','left')
			->where('pdt.pengadaan_id',$id)
			->order_by('p.nama_produk','asc')
			->get()->result_array();

           	$no = 0 ;

            $total = 0;
			
           	foreach ($pengadaan as $row) : ?>  
               <tr>
                   <td align="center"><?php echo $no+1;?></td>
                   <td align="left"><?= $this->crud_global->GetField('produk',array('id'=>$row['produk']),'nama_produk');?></td>
				   <td align="center"><?= number_format($row['qty'],0,',','.'); ?></td>
	               <td align="center"><?= $this->crud_global->GetField('satuan',array('id'=>$row['satuan']),'nama_satuan');?></td>
	               <td align="right"><?= number_format($row['harga_satuan'],0,',','.'); ?></td>
	               <td align="right"><?= number_format($row['jumlah'],0,',','.'); ?></td>
				   <td align="center"><?= $row["keterangan"]; ?></td>
				   <td align="center"><?= number_format($row['qty'],0,',','.'); ?> <?= $this->crud_global->GetField('satuan',array('id'=>$row['satuan']),'nama_satuan');?></td>
               </tr>

			<?php
			$no++;
			$total += $row['jumlah'];
			endforeach; ?>

            
            <tr>
                <th colspan="5" align="right">TOTAL HARGA PERMINTAAN BARANG / JASA</th>
                <th align="right"><?= number_format($total,0,',','.'); ?></th>
				<th align="right"></th>
				<th align="right"></th>
            </tr>
		</table>
		<table width="98%" border="0" cellpadding="10">
			<tr >
				<td width="5%"></td>
				<td width="90%">
					<table width="100%" border="0" cellpadding="2">
						<tr>
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
						</tr>
						<tr>
							<td align="center">
								<b><u>Debi Khania</u><br />
								Keuangan & SDM</b>
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