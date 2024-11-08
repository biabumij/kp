<!DOCTYPE html>
<?php
$this->db2 = $this->load->database('database2', TRUE);
$this->db3 = $this->load->database('database3', TRUE);
?>
<html>
	<head>
	  <title>LAPORAN MONITORING PIUTANG</title>
	  
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
			font-size: 7px;
			color: black;
		}
			
		table tr.table-baris1{
			background-color: #F0F0F0;
			font-size: 7px;
		}

		table tr.table-baris1-bold{
			background-color: #F0F0F0;
			font-size: 7px;
			font-weight: bold;
		}
			
		table tr.table-baris2{
			font-size: 7px;
			background-color: #E8E8E8;
		}

		table tr.table-baris2-bold{
			font-size: 7px;
			background-color: #E8E8E8;
			font-weight: bold;
		}
			
		table tr.table-total{
			background-color: #cccccc;
			font-weight: bold;
			font-size: 7px;
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
					<div style="display: block;font-weight: bold;font-size: 10px;">LAPORAN MONITORING PIUTANG</div>
				    <div style="display: block;font-weight: bold;font-size: 10px;">PT. BIA BUMI JAYENDRA</div>
					<div style="display: block;font-weight: bold;font-size: 10px; text-transform: uppercase;">PERIODE <?php echo str_replace($search, $replace, $subject);?></div>
				</td>
			</tr>
		</table>	
		<table cellpadding="4" width="98%">
			<?php
			//TEMEF
			//DPP_TAGIHAN_TEMEF
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
			$dpp_tagihan_penjualan_temef = $query->row_array();
			$nilai_dpp_tagihan_penjualan_temef =  $dpp_tagihan_penjualan_temef['nilai'];

			//PPN_TAGIHAN_TEMEF
			$this->db2->select('sum(ppd.tax) as nilai, ps.nama');
			if(!empty($supplier_id)){
				$this->db2->where('ps.nama',$supplier_id);
			}
			$this->db2->join('pmm_penagihan_penjualan_detail ppd','ppp.id = ppd.penagihan_id','left');
			$this->db2->join('pmm_sales_po ppo','ppp.sales_po_id = ppo.id','left');
			$this->db2->join('penerima ps','ppo.client_id = ps.id','left');
			$this->db2->where("(ppp.tanggal_invoice between '$date1' and '$date2')");
			$this->db2->where("ppo.status in ('OPEN','CLOSED')");
			$query = $this->db2->get('pmm_penagihan_penjualan ppp');
			$ppn_tagihan_penjualan_temef = $query->row_array();
			$nilai_ppn_tagihan_penjualan_temef =  $ppn_tagihan_penjualan_temef['nilai'];

			//JUMLAH_TAGIHAN_TEMEF
			$nilai_tagihan_penjualan_temef =  $nilai_dpp_tagihan_penjualan_temef + $nilai_ppn_tagihan_penjualan_temef;		 

			//PEMBAYARAN_DPP_TEMEF
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
			$pembayaran_dpp_penjualan_temef = $query->row_array();
			$nilai_pembayaran_dpp_penjualan_temef = $pembayaran_dpp_penjualan_temef['nilai'];

			//PEMBAYARAN_PPN_TEMEF
			$this->db2->select('sum(pppp.total) as nilai, pppp.nama_pelanggan, ps.nama');
			if(!empty($supplier_id)){
				$this->db2->where('ps.nama',$supplier_id);
			}
			$this->db2->join('pmm_penagihan_penjualan ppp','pppp.penagihan_id = ppp.id','left');
			$this->db2->join('pmm_sales_po ppo','ppp.sales_po_id = ppo.id','left');
			$this->db2->join('penerima ps','ppo.client_id = ps.id','left');
			$this->db2->where("(pppp.tanggal_pembayaran between '$date1' and '$date2')");
			$this->db2->where("pppp.memo = 'PPN' ");
			$this->db2->where("ppo.status in ('OPEN','CLOSED')");
			$query = $this->db2->get('pmm_pembayaran pppp');
			$pembayaran_ppn_penjualan_temef = $query->row_array();
			$nilai_pembayaran_ppn_penjualan_temef = $pembayaran_ppn_penjualan_temef['nilai'];

			//JUMLAH_PEMBAYARAN_TEMEF
			$nilai_pembayaran_penjualan_temef = $nilai_pembayaran_dpp_penjualan_temef + $nilai_pembayaran_ppn_penjualan_temef;
			
			//DPP_SISA_PIUTANG
			$dpp_sisa_piutang_temef = $nilai_dpp_tagihan_penjualan_temef - $nilai_pembayaran_dpp_penjualan_temef;
			$ppn_sisa_piutang_temef = $nilai_ppn_tagihan_penjualan_temef - $nilai_pembayaran_ppn_penjualan_temef;
			$jumlah_sisa_piutang_temef = $dpp_sisa_piutang_temef + $ppn_sisa_piutang_temef;

			//SC
			//DPP_TAGIHAN_SC
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
			$dpp_tagihan_penjualan_sc = $query->row_array();
			$nilai_dpp_tagihan_penjualan_sc =  $dpp_tagihan_penjualan_sc['nilai'];

			//PPN_TAGIHAN_SC
			$this->db3->select('sum(ppd.tax) as nilai, ps.nama');
			if(!empty($supplier_id)){
				$this->db3->where('ps.nama',$supplier_id);
			}
			$this->db3->join('pmm_penagihan_penjualan_detail ppd','ppp.id = ppd.penagihan_id','left');
			$this->db3->join('pmm_sales_po ppo','ppp.sales_po_id = ppo.id','left');
			$this->db3->join('penerima ps','ppo.client_id = ps.id','left');
			$this->db3->where("(ppp.tanggal_invoice between '$date1' and '$date2')");
			$this->db3->where("ppo.status in ('OPEN','CLOSED')");
			$query = $this->db3->get('pmm_penagihan_penjualan ppp');
			$ppn_tagihan_penjualan_sc = $query->row_array();
			$nilai_ppn_tagihan_penjualan_sc =  $ppn_tagihan_penjualan_sc['nilai'];

			//JUMLAH_TAGIHAN_SC
			$nilai_tagihan_penjualan_sc =  $nilai_dpp_tagihan_penjualan_sc + $nilai_ppn_tagihan_penjualan_sc;		 

			//PEMBAYARAN_DPP_SC
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
			$pembayaran_dpp_penjualan_sc = $query->row_array();
			$nilai_pembayaran_dpp_penjualan_sc = $pembayaran_dpp_penjualan_sc['nilai'];

			//PEMBAYARAN_PPN_SC
			$this->db3->select('sum(pppp.total) as nilai, pppp.nama_pelanggan, ps.nama');
			if(!empty($supplier_id)){
				$this->db3->where('ps.nama',$supplier_id);
			}
			$this->db3->join('pmm_penagihan_penjualan ppp','pppp.penagihan_id = ppp.id','left');
			$this->db3->join('pmm_sales_po ppo','ppp.sales_po_id = ppo.id','left');
			$this->db3->join('penerima ps','ppo.client_id = ps.id','left');
			$this->db3->where("(pppp.tanggal_pembayaran between '$date1' and '$date2')");
			$this->db3->where("pppp.memo = 'PPN' ");
			$this->db3->where("ppo.status in ('OPEN','CLOSED')");
			$query = $this->db3->get('pmm_pembayaran pppp');
			$pembayaran_ppn_penjualan_sc = $query->row_array();
			$nilai_pembayaran_ppn_penjualan_sc = $pembayaran_ppn_penjualan_sc['nilai'];

			//JUMLAH_PEMBAYARAN_SC
			$nilai_pembayaran_penjualan_sc = $nilai_pembayaran_dpp_penjualan_sc + $nilai_pembayaran_ppn_penjualan_sc;
			
			//DPP_SISA_PIUTANG
			$dpp_sisa_piutang_sc = $nilai_dpp_tagihan_penjualan_sc - $nilai_pembayaran_dpp_penjualan_sc;
			$ppn_sisa_piutang_sc = $nilai_ppn_tagihan_penjualan_sc - $nilai_pembayaran_ppn_penjualan_sc;
			$jumlah_sisa_piutang_sc = $dpp_sisa_piutang_sc + $ppn_sisa_piutang_sc;
			?>
			<tr class="table-judul">
                <th align="center" width="5%" rowspan="2">&nbsp; <br />NO.</th>
                <th align="center" width="11%" rowspan="2">&nbsp; <br />UNIT BISNIS / PROYEK</th>
                <th align="center" width="24%" colspan="3">&nbsp; <br />TAGIHAN</th>
                <th align="center" width="28%" colspan="4">&nbsp; <br />PENERIMAAN</th>
				<th align="center" width="28%" colspan="3">&nbsp; <br />SISA HUTANG</th>
            </tr>
			<tr class="table-judul">
				<th align="right" width="8%">DPP</th>
				<th align="right" width="8%">PPN</th>
				<th align="right" width="8%">JUMLAH</th>
				<th align="right" width="8%">DPP</th>
				<th align="right" width="10%">PPN</th>
				<th align="right" width="10%">JUMLAH</th>
				<th align="right" width="8%">DPP</th>
				<th align="right" width="10%">PPN</th>
				<th align="right" width="10%">JUMLAH</th>
	        </tr>
			<tr class="table-baris1-bold">
				<td align="left">1.</td>
				<td align="left">TEMEF</td>
				<td align="right"><?php echo number_format($nilai_dpp_tagihan_penjualan_temef,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_ppn_tagihan_penjualan_temef,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_tagihan_penjualan_temef,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_pembayaran_dpp_penjualan_temef,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_pembayaran_ppn_penjualan_temef,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_pembayaran_penjualan_temef,0,',','.');?></td>
				<td align="right"><?php echo number_format($dpp_sisa_piutang_temef,0,',','.');?></td>
				<td align="right"><?php echo number_format($ppn_sisa_piutang_temef,0,',','.');?></td>
				<td align="right"><?php echo number_format($jumlah_sisa_piutang_temef,0,',','.');?></td>
	        </tr>
			<tr class="table-baris1-bold">
				<td align="left">2.</td>
				<td align="left">SC</td>
				<td align="right"><?php echo number_format($nilai_dpp_tagihan_penjualan_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_ppn_tagihan_penjualan_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_tagihan_penjualan_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_pembayaran_dpp_penjualan_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_pembayaran_ppn_penjualan_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_pembayaran_penjualan_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($dpp_sisa_piutang_sc - $nilai_pembayaran_pph_penjualan_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($ppn_sisa_piutang_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($jumlah_sisa_piutang_sc,0,',','.');?></td>
	        </tr>
			<tr class="table-total">
				<td align="right" colspan="2">GRAND TOTAL</td>
				<td align="right"><?php echo number_format($nilai_dpp_tagihan_penjualan_temef + $nilai_dpp_tagihan_penjualan_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_ppn_tagihan_penjualan_temef + $nilai_ppn_tagihan_penjualan_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_tagihan_penjualan_temef + $nilai_tagihan_penjualan_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_pembayaran_dpp_penjualan_temef + $nilai_pembayaran_dpp_penjualan_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_pembayaran_ppn_penjualan_temef + $nilai_pembayaran_ppn_penjualan_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_pembayaran_penjualan_temef + $nilai_pembayaran_penjualan_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($dpp_sisa_piutang_temef + $dpp_sisa_piutang_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($ppn_sisa_piutang_temef + $ppn_sisa_piutang_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($jumlah_sisa_piutang_temef + $jumlah_sisa_piutang_sc,0,',','.');?></td>
	        </tr>
		</table>
	</body>
</html>