<!DOCTYPE html>
<?php
$this->db2 = $this->load->database('database2', TRUE);
$this->db3 = $this->load->database('database3', TRUE);
?>
<html>
	<head>
	  <title>LAPORAN PIUTANG</title>
	  
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
					<div style="display: block;font-weight: bold;font-size: 10px;">LAPORAN PIUTANG</div>
				    <div style="display: block;font-weight: bold;font-size: 10px;">PT. BIA BUMI JAYENDRA</div>
					<div style="display: block;font-weight: bold;font-size: 10px; text-transform: uppercase;">PERIODE <?php echo str_replace($search, $replace, $subject);?></div>
				</td>
			</tr>
		</table>	
		<table cellpadding="4" width="98%">
			<?php
			//TEMEF
			//PENGIRIMAN_TEMEF
			$this->db2->select('sum(pp.display_price) as nilai, ps.nama');
			if(!empty($supplier_id)){
				$this->db2->where('ps.nama',$supplier_id);
			}
			$this->db2->join('pmm_sales_po ppo','pp.salesPo_id = ppo.id','left');
			$this->db2->join('penerima ps','ppo.client_id = ps.id','left');
			$this->db2->where("(pp.date_production between '$date1' and '$date2')");
			$this->db2->where('pp.status','PUBLISH');
			$this->db2->where("ppo.status in ('OPEN','CLOSED')");
			$query = $this->db2->get('pmm_productions pp');
			$pengiriman_penjualan_temef = $query->row_array();
			$nilai_pengiriman_penjualan_temef =  $pengiriman_penjualan_temef['nilai'];

			//TAGIHAN_TEMEF
			$this->db2->select('sum(ppd.total) as nilai, ps.nama');
			if(!empty($supplier_id)){
				$this->db2->where('ps.nama',$supplier_id);
			}
			$this->db2->join('pmm_penagihan_penjualan_detail ppd','ppp.id = ppd.penagihan_id','left');
			$this->db2->join('pmm_sales_po ppo','ppp.sales_po_id = ppo.id','left');
			$this->db2->join('penerima ps','ppo.client_id = ps.id','left');
			$this->db2->where("(ppp.tanggal_invoice between '$date1' and '$date2')");
			$this->db2->where("ppo.status in ('OPEN','CLOSED')");
			$query = $this->db2->get('pmm_penagihan_penjualan ppp');
			$tagihan_penjualan_temef = $query->row_array();
			$nilai_tagihan_penjualan_temef =  $tagihan_penjualan_temef['nilai'];

			//TAGIHAN_BRUTO_TEMEF
			$nilai_tagihan_bruto_temef =  $nilai_pengiriman_penjualan_temef - $nilai_tagihan_penjualan_temef;

			//PEMBAYARAN_TEMEF
			$this->db2->select('sum(pppp.total) as nilai, pppp.nama_pelanggan, ps.nama');
			if(!empty($supplier_id)){
				$this->db2->where('ps.nama',$supplier_id);
			}
			$this->db2->join('pmm_penagihan_penjualan ppp','pppp.penagihan_id = ppp.id','left');
			$this->db2->join('pmm_sales_po ppo','ppp.sales_po_id = ppo.id','left');
			$this->db2->join('penerima ps','ppo.client_id = ps.id','left');
			$this->db2->where("(pppp.tanggal_pembayaran between '$date1' and '$date2')");
			$this->db2->where("pppp.memo <> 'PPN' ");
			$this->db2->where("ppo.status in ('OPEN','CLOSED')");
			$query = $this->db2->get('pmm_pembayaran pppp');
			$pembayaran_penjualan_temef = $query->row_array();
			$nilai_pembayaran_penjualan_temef = $pembayaran_penjualan_temef['nilai'];

			//PIUTANG_PENERIMAAN_TEMEF
			$nilai_piutang_penerimaan_temef = $nilai_pengiriman_penjualan_temef - $nilai_pembayaran_penjualan_temef;
			//PIUTANG_INVOICE_TEMEF
			$nilai_piutang_invoice_temef = $nilai_tagihan_penjualan_temef - $nilai_pembayaran_penjualan_temef;

			//SC
			//PENGIRIMAN_SC
			$this->db3->select('sum(pp.display_price) as nilai, ps.nama');
			if(!empty($supplier_id)){
				$this->db3->where('ps.nama',$supplier_id);
			}
			$this->db3->join('pmm_sales_po ppo','pp.salesPo_id = ppo.id','left');
			$this->db3->join('penerima ps','ppo.client_id = ps.id','left');
			$this->db3->where("(pp.date_production between '$date1' and '$date2')");
			$this->db3->where('pp.status','PUBLISH');
			$this->db3->where("ppo.status in ('OPEN','CLOSED')");
			$query = $this->db3->get('pmm_productions pp');
			$pengiriman_penjualan_sc = $query->row_array();
			$nilai_pengiriman_penjualan_sc =  $pengiriman_penjualan_sc['nilai'];

			//TAGIHAN_SC
			$this->db3->select('sum(ppd.total) as nilai, ps.nama');
			if(!empty($supplier_id)){
				$this->db3->where('ps.nama',$supplier_id);
			}
			$this->db3->join('pmm_penagihan_penjualan_detail ppd','ppp.id = ppd.penagihan_id','left');
			$this->db3->join('pmm_sales_po ppo','ppp.sales_po_id = ppo.id','left');
			$this->db3->join('penerima ps','ppo.client_id = ps.id','left');
			$this->db3->where("(ppp.tanggal_invoice between '$date1' and '$date2')");
			$this->db3->where("ppo.status in ('OPEN','CLOSED')");
			$query = $this->db3->get('pmm_penagihan_penjualan ppp');
			$tagihan_penjualan_sc = $query->row_array();
			$nilai_tagihan_penjualan_sc =  $tagihan_penjualan_sc['nilai'];

			//TAGIHAN_BRUTO_SC
			$nilai_tagihan_bruto_sc =  $nilai_pengiriman_penjualan_sc - $nilai_tagihan_penjualan_sc;

			//PEMBAYARAN_SC
			$this->db3->select('sum(pppp.total) as nilai, pppp.nama_pelanggan, ps.nama');
			if(!empty($supplier_id)){
				$this->db3->where('ps.nama',$supplier_id);
			}
			$this->db3->join('pmm_penagihan_penjualan ppp','pppp.penagihan_id = ppp.id','left');
			$this->db3->join('pmm_sales_po ppo','ppp.sales_po_id = ppo.id','left');
			$this->db3->join('penerima ps','ppo.client_id = ps.id','left');
			$this->db3->where("(pppp.tanggal_pembayaran between '$date1' and '$date2')");
			$this->db3->where("pppp.memo <> 'PPN' ");
			$this->db3->where("ppo.status in ('OPEN','CLOSED')");
			$query = $this->db3->get('pmm_pembayaran pppp');
			$pembayaran_penjualan_sc = $query->row_array();
			$nilai_pembayaran_penjualan_sc = $pembayaran_penjualan_sc['nilai'];

			//PIUTANG_PENERIMAAN_SC
			$nilai_piutang_penerimaan_sc = $nilai_pengiriman_penjualan_sc - $nilai_pembayaran_penjualan_sc;
			//PIUTANG_INVOICE_SC
			$nilai_piutang_invoice_sc = $nilai_tagihan_penjualan_sc - $nilai_pembayaran_penjualan_sc;
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
				<td align="right"><?php echo number_format($nilai_pengiriman_penjualan_temef,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_tagihan_penjualan_temef,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_tagihan_bruto_temef,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_pembayaran_penjualan_temef,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_piutang_penerimaan_temef,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_piutang_invoice_temef,0,',','.');?></td>
	        </tr>
			<tr class="table-baris1-bold">
				<td align="left">2.</td>
				<td align="left">SC</td>
				<td align="right"><?php echo number_format($nilai_pengiriman_penjualan_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_tagihan_penjualan_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_tagihan_bruto_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_pembayaran_penjualan_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_piutang_penerimaan_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_piutang_invoice_sc,0,',','.');?></td>
	        </tr>
			<tr class="table-total">
				<td align="right" colspan="2">GRAND TOTAL</td>
				<td align="right"><?php echo number_format($nilai_pengiriman_penjualan_temef + $nilai_pengiriman_penjualan_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_tagihan_penjualan_temef + $nilai_tagihan_penjualan_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_tagihan_bruto_temef + $nilai_tagihan_bruto_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_pembayaran_penjualan_temef + $nilai_pembayaran_penjualan_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_piutang_penerimaan_temef + $nilai_piutang_penerimaan_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_piutang_invoice_temef + $nilai_piutang_invoice_sc,0,',','.');?></td>
	        </tr>
		</table>
	</body>
</html>