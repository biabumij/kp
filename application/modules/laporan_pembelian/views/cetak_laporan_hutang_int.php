<!DOCTYPE html>
<?php
$this->db2 = $this->load->database('database2', TRUE);
$this->db3 = $this->load->database('database3', TRUE);
?>
<html>
	<head>
	  <title>LAPORAN HUTANG</title>
	  
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
		<table width="98%" border="0" cellpadding="15">
			<tr>
				<td width="100%" align="center">
					<div style="display: block;font-weight: bold;font-size: 10px;">LAPORAN HUTANG</div>
				    <div style="display: block;font-weight: bold;font-size: 10px;">PT. BIA BUMI JAYENDRA</div>
					<div style="display: block;font-weight: bold;font-size: 10px; text-transform: uppercase;">PERIODE <?php echo str_replace($search, $replace, $subject);?></div>
				</td>
			</tr>
		</table>	
		<table cellpadding="4" width="98%">
			<?php
			//TEMEF
			//PENERIMAAN_TEMEF
			$this->db2->select('sum(prm.display_price) as nilai, ps.nama');
			if(!empty($supplier_id)){
				$this->db2->where('ps.nama',$supplier_id);
			}
			$this->db2->join('pmm_purchase_order ppo','prm.purchase_order_id = ppo.id','left');
			$this->db2->join('penerima ps','ppo.supplier_id = ps.id','left');
			$this->db2->where("(prm.date_receipt between '$date1' and '$date2')");
			$this->db2->where("ppo.status in ('PUBLISH','CLOSED')");
			$query = $this->db2->get('pmm_receipt_material prm');
			$penerimaan_pembelian_temef = $query->row_array();
			$nilai_penerimaan_pembelian_temef =  $penerimaan_pembelian_temef['nilai'];

			//TAGIHAN_TEMEF
			$this->db2->select('sum(ppd.total) as nilai, ps.nama');
			if(!empty($supplier_id)){
				$this->db2->where('ps.nama',$supplier_id);
			}
			$this->db2->join('pmm_penagihan_pembelian_detail ppd','ppp.id = ppd.penagihan_pembelian_id','left');
			$this->db2->join('pmm_purchase_order ppo','ppp.purchase_order_id = ppo.id','left');
			$this->db2->join('penerima ps','ppo.supplier_id = ps.id','left');
			$this->db2->where("(ppp.tanggal_invoice between '$date1' and '$date2')");
			$this->db2->where("ppo.status in ('PUBLISH','CLOSED')");
			$query = $this->db2->get('pmm_penagihan_pembelian ppp');
			$tagihan_pembelian_temef = $query->row_array();
			$nilai_tagihan_pembelian_temef =  $tagihan_pembelian_temef['nilai'];

			//TAGIHAN_BRUTO_TEMEF
			$nilai_tagihan_bruto_temef =  $nilai_penerimaan_pembelian_temef - $nilai_tagihan_pembelian_temef;

			//PEMBAYARAN_TEMEF
			$this->db2->select('sum(pppp.total) as nilai, pppp.supplier_name, ps.nama');
			if(!empty($supplier_id)){
				$this->db2->where('ps.nama',$supplier_id);
			}
			$this->db2->join('pmm_penagihan_pembelian ppp','pppp.penagihan_pembelian_id = ppp.id','left');
			$this->db2->join('pmm_purchase_order ppo','ppp.purchase_order_id = ppo.id','left');
			$this->db2->join('penerima ps','ppo.supplier_id = ps.id','left');
			$this->db2->where("(pppp.tanggal_pembayaran between '$date1' and '$date2')");
			$this->db2->where("pppp.memo <> 'PPN' ");
			$this->db2->where("ppo.status in ('PUBLISH','CLOSED')");
			$query = $this->db2->get('pmm_pembayaran_penagihan_pembelian pppp');
			$pembayaran_pembelian_temef = $query->row_array();
			$nilai_pembayaran_pembelian_temef = $pembayaran_pembelian_temef['nilai'];

			//HUTANG_PENERIMAAN_TEMEF
			$nilai_hutang_penerimaan_temef = $nilai_penerimaan_pembelian_temef - $nilai_pembayaran_pembelian_temef;
			//HUTANG_INVOICE_TEMEF
			$nilai_hutang_invoice_temef = $nilai_tagihan_pembelian_temef - $nilai_pembayaran_pembelian_temef;

			//SC
			//PENERIMAAN_SC
			$this->db3->select('sum(prm.display_price) as nilai, ps.nama');
			if(!empty($supplier_id)){
				$this->db3->where('ps.nama',$supplier_id);
			}
			$this->db3->join('pmm_purchase_order ppo','prm.purchase_order_id = ppo.id','left');
			$this->db3->join('penerima ps','ppo.supplier_id = ps.id','left');
			$this->db3->where("(prm.date_receipt between '$date1' and '$date2')");
			$this->db3->where("ppo.status in ('PUBLISH','CLOSED')");
			$query = $this->db3->get('pmm_receipt_material prm');
			$penerimaan_pembelian_sc = $query->row_array();
			$nilai_penerimaan_pembelian_sc =  $penerimaan_pembelian_sc['nilai'];

			//TAGIHAN_SC
			$this->db3->select('sum(ppd.total) as nilai, ps.nama');
			if(!empty($supplier_id)){
				$this->db3->where('ps.nama',$supplier_id);
			}
			$this->db3->join('pmm_penagihan_pembelian_detail ppd','ppp.id = ppd.penagihan_pembelian_id','left');
			$this->db3->join('pmm_purchase_order ppo','ppp.purchase_order_id = ppo.id','left');
			$this->db3->join('penerima ps','ppo.supplier_id = ps.id','left');
			$this->db3->where("(ppp.tanggal_invoice between '$date1' and '$date2')");
			$this->db3->where("ppo.status in ('PUBLISH','CLOSED')");
			$query = $this->db3->get('pmm_penagihan_pembelian ppp');
			$tagihan_pembelian_sc = $query->row_array();
			$nilai_tagihan_pembelian_sc =  $tagihan_pembelian_sc['nilai'];

			//TAGIHAN_BRUTO_SC
			$nilai_tagihan_bruto_sc =  $nilai_penerimaan_pembelian_sc - $nilai_tagihan_pembelian_sc;

			//PEMBAYARAN_SC
			$this->db3->select('sum(pppp.total) as nilai, pppp.supplier_name, ps.nama');
			if(!empty($supplier_id)){
				$this->db3->where('ps.nama',$supplier_id);
			}
			$this->db3->join('pmm_penagihan_pembelian ppp','pppp.penagihan_pembelian_id = ppp.id','left');
			$this->db3->join('pmm_purchase_order ppo','ppp.purchase_order_id = ppo.id','left');
			$this->db3->join('penerima ps','ppo.supplier_id = ps.id','left');
			$this->db3->where("(pppp.tanggal_pembayaran between '$date1' and '$date2')");
			$this->db3->where("pppp.memo <> 'PPN' ");
			$this->db3->where("ppo.status in ('PUBLISH','CLOSED')");
			$query = $this->db3->get('pmm_pembayaran_penagihan_pembelian pppp');
			$pembayaran_pembelian_sc = $query->row_array();
			$nilai_pembayaran_pembelian_sc = $pembayaran_pembelian_sc['nilai'];

			//HUTANG_PENERIMAAN_SC
			$nilai_hutang_penerimaan_sc = $nilai_penerimaan_pembelian_sc - $nilai_pembayaran_pembelian_sc;
			//HUTANG_INVOICE_SC
			$nilai_hutang_invoice_sc = $nilai_tagihan_pembelian_sc - $nilai_pembayaran_pembelian_sc;
			?>
			<tr class="table-judul">
                <th align="center" width="5%" rowspan="2">&nbsp; <br />NO.</th>
                <th align="center" width="15%" rowspan="2">&nbsp; <br />UNIT BISNIS / PROYEK</th>
                <th align="center" width="15%" rowspan="2">&nbsp; <br />PENERIMAAN</th>
                <th align="center" width="15%" rowspan="2">&nbsp; <br />TAGIHAN</th>
				<th align="center" width="15%" rowspan="2">&nbsp; <br />TAGIHAN BRUTO</th>
				<th align="center" width="15%" rowspan="2">&nbsp; <br />PEMBAYARAN</th>
				<th align="center" width="20%" colspan="2">SISA HUTANG</th>
            </tr>
			<tr class="table-judul">
	            <th align="right">PENERIMAAN</th>
				<th align="right">INVOICE</th>
	        </tr>
			<tr class="table-baris1-bold">
				<td align="left">1.</td>
				<td align="left">TEMEF</td>
				<td align="right"><?php echo number_format($nilai_penerimaan_pembelian_temef,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_tagihan_pembelian_temef,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_tagihan_bruto_temef,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_pembayaran_pembelian_temef,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_hutang_penerimaan_temef,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_hutang_invoice_temef,0,',','.');?></td>
	        </tr>
			<tr class="table-baris1-bold">
				<td align="left">2.</td>
				<td align="left">SC</td>
				<td align="right"><?php echo number_format($nilai_penerimaan_pembelian_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_tagihan_pembelian_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_tagihan_bruto_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_pembayaran_pembelian_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_hutang_penerimaan_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_hutang_invoice_sc,0,',','.');?></td>
	        </tr>
			<tr class="table-total">
				<td align="right" colspan="2">GRAND TOTAL</td>
				<td align="right"><?php echo number_format($nilai_penerimaan_pembelian_temef + $nilai_penerimaan_pembelian_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_tagihan_pembelian_temef + $nilai_tagihan_pembelian_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_tagihan_bruto_temef + $nilai_tagihan_bruto_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_pembayaran_pembelian_temef + $nilai_pembayaran_pembelian_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_hutang_penerimaan_temef + $nilai_hutang_penerimaan_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_hutang_invoice_temef + $nilai_hutang_invoice_sc,0,',','.');?></td>
	        </tr>
		</table>
	</body>
</html>