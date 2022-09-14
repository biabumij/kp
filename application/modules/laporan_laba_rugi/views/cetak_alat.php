<!DOCTYPE html>
<html>
	<head>
	  <title>ALAT</title>
	  
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
		<br />
		<br />
		<table width="98%" cellpadding="3">
			<tr>
				<td align="center"  width="100%">
					<div style="display: block;font-weight: bold;font-size: 12px;">PEMAKAIAN ALAT</div>
					<div style="display: block;font-weight: bold;font-size: 11px;">DIVISI BETON  PROYEK BENDUNGAN TEMEF</div>
				    <div style="display: block;font-weight: bold;font-size: 11px;">PT. BIA BUMI JAYENDRA</div>
					<div style="display: block;font-weight: bold;font-size: 12px; text-transform: uppercase;">PERIODE : <?php echo str_replace($search, $replace, $subject);?></div>
				</td>
			</tr>
		</table>
		<br />
		<br />
		<br />
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
		
		<table width="98%" border="0" cellpadding="3" border="0">
		
		<?php

			$pembelian = $this->db->select('
			pn.nama, po.no_po, p.nama_produk, prm.measure, SUM(prm.volume) as volume, prm.harga_satuan, SUM(prm.price) as price')
			->from('pmm_receipt_material prm')
			->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
			->join('produk p', 'prm.material_id = p.id','left')
			->join('penerima pn', 'po.supplier_id = pn.id','left')
			->where("prm.date_receipt between '$date1' and '$date2'")
			->where("prm.material_id in (8,12,13,14,15,16,23,24)")
			->where("po.status in ('PUBLISH','CLOSED')")
			->group_by('prm.material_id')
			->order_by('po.supplier_id','asc')
			->get()->result_array();

			//file_put_contents("D:\\penjualan.txt", $this->db->last_query());

			$total_nilai = 0;

			foreach ($pembelian as $x){
				$total_nilai += $x['price'];
			}

			$total_nilai_all = 0;
			$total_nilai_all = $total_nilai;

			$total_insentif_tm = 0;

			$insentif_tm = $this->db->select('pb.memo as memo, sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun = 220")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->group_by('pdb.id')
			->get()->result_array();

			//file_put_contents("D:\\insentif_tm.txt", $this->db->last_query());

			$total_insentif_tm = 0;

			foreach ($insentif_tm as $y){
				$total_insentif_tm += $y['total'];
			}

			$total_insentif_tm_all = 0;
			$total_insentif_tm_all = $total_insentif_tm;

			$total_nilai = $total_nilai_all + $total_insentif_tm_all;

			?>
			
			<tr class="table-judul">
				<th width="35%" align="center"><br>REKANAN</th>
				<th width="20%" align="center"><br>PRODUK</th>
				<th width="7%" align="center"><br>SATUAN</th>
				<th width="13%" align="center"><br>VOLUME</th>
				<th width="15%" align="center">HARGA SATUAN</th>
				<th width="10%" align="center">NILAI</th>
	        </tr>
			<?php foreach ($pembelian as $x): ?>
			<tr class="table-baris1">
				<th align="left">&bull; <?= $x['nama'] ?></th>
				<th align="left"><?= $x['nama_produk'] ?></th>
				<th align="center"><?= $x['measure'] ?></th>
				<th align="right"><?php echo number_format($x['volume'],2,',','.');?></th>
				<th align="right"><?php echo number_format($x['harga_satuan'],0,',','.');?></th>
				<th align="right"><?php echo number_format($x['price'],0,',','.');?></th>
			</tr>
			<?php endforeach; ?>
			<?php foreach ($insentif_tm as $y): ?>
			<tr class="table-baris1">
				<th align="left" colspan="5">&bull; <?= $y['memo'] ?></th>
				<th align="right"><?php echo number_format($y['total'],0,',','.');?></th>
			</tr>
			<?php endforeach; ?>
			<tr class="table-total">
				<th align="right" colspan="5">TOTAL</th>
				<th align="right"><?php echo number_format($total_nilai,0,',','.');?></th>
			</tr>
	    </table>
		
	</body>
</html>