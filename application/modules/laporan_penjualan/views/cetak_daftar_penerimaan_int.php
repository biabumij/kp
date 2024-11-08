<!DOCTYPE html>
<?php
$this->db2 = $this->load->database('database2', TRUE);
$this->db3 = $this->load->database('database3', TRUE);
?>
<html>
	<head>
	  <title>DAFTAR PENERIMAAN</title>
	  
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
					<div style="display: block;font-weight: bold;font-size: 10px;">DAFTAR PENERIMAAN</div>
				    <div style="display: block;font-weight: bold;font-size: 10px;">PT. BIA BUMI JAYENDRA</div>
				</td>
			</tr>
		</table>	
		<table cellpadding="4" width="98%">
			<?php
			//TEMEF
			$this->db2->select('sum(pmp.total) as nilai, ps.nama');
			if(!empty($supplier_id)){
				$this->db2->where('ps.nama',$supplier_id);
			}
			$this->db2->join('pmm_penagihan_penjualan ppp', 'pmp.penagihan_id = ppp.id','left');
			$this->db2->join('penerima ps','ppp.client_id = ps.id','left');
			$this->db2->join('pmm_sales_po ppo','ppp.sales_po_id = ppo.id','left');
			$this->db2->where("(pmp.tanggal_pembayaran between '$date1' and '$date2')");
			$this->db2->where("ppo.status in ('OPEN','CLOSED')");
			$query = $this->db2->get('pmm_pembayaran pmp');
			$daftar_penerimaan_temef = $query->row_array();
			$nilai_daftar_penerimaan_temef =  $daftar_penerimaan_temef['nilai'];

			$this->db2->select('sum(pmp.total) as nilai, ps.nama');
			if(!empty($supplier_id)){
				$this->db2->where('ps.nama',$supplier_id);
			}
			$this->db2->join('pmm_penagihan_penjualan ppp', 'pmp.penagihan_id = ppp.id','left');
			$this->db2->join('penerima ps','ppp.client_id = ps.id','left');
			$this->db2->join('pmm_sales_po ppo','ppp.sales_po_id = ppo.id','left');
			$this->db2->where("(pmp.tanggal_pembayaran between '$date3' and '$date2')");
			$this->db2->where("ppo.status in ('OPEN','CLOSED')");
			$query = $this->db2->get('pmm_pembayaran pmp');
			$daftar_penerimaan_temef_all = $query->row_array();
			$nilai_daftar_penerimaan_temef_all =  $daftar_penerimaan_temef_all['nilai'];

			//SC
			$this->db3->select('sum(pmp.total) as nilai, ps.nama');
			if(!empty($supplier_id)){
				$this->db3->where('ps.nama',$supplier_id);
			}
			$this->db3->join('pmm_penagihan_penjualan ppp', 'pmp.penagihan_id = ppp.id','left');
			$this->db3->join('penerima ps','ppp.client_id = ps.id','left');
			$this->db3->join('pmm_sales_po ppo','ppp.sales_po_id = ppo.id','left');
			$this->db3->where("(pmp.tanggal_pembayaran between '$date1' and '$date2')");
			$this->db3->where("ppo.status in ('OPEN','CLOSED')");
			$query = $this->db3->get('pmm_pembayaran pmp');
			$daftar_penerimaan_sc = $query->row_array();
			$nilai_daftar_penerimaan_sc =  $daftar_penerimaan_sc['nilai'];

			$this->db3->select('sum(pmp.total) as nilai, ps.nama');
			if(!empty($supplier_id)){
				$this->db3->where('ps.nama',$supplier_id);
			}
			$this->db3->join('pmm_penagihan_penjualan ppp', 'pmp.penagihan_id = ppp.id','left');
			$this->db3->join('penerima ps','ppp.client_id = ps.id','left');
			$this->db3->join('pmm_sales_po ppo','ppp.sales_po_id = ppo.id','left');
			$this->db3->where("(pmp.tanggal_pembayaran between '$date3' and '$date2')");
			$this->db3->where("ppo.status in ('OPEN','CLOSED')");
			$query = $this->db3->get('pmm_pembayaran pmp');
			$daftar_penerimaan_sc_all = $query->row_array();
			$nilai_daftar_penerimaan_sc_all =  $daftar_penerimaan_sc_all['nilai'];
			?>
			<tr class="table-judul">
				<th align="left" width="5%">NO.</th>
				<th align="left" width="25%">UNIT BISNIS / PROYEK</th>
	            <th align="right" width="35%"><?php echo $filter_date = $filter_date = date('d/m/Y',strtotime($arr_filter_date[0])).' - '.date('d/m/Y',strtotime($arr_filter_date[1]));?></th>
				<th align="right" width="35%">SD. <?php echo $filter_date_2 = date('d/m/Y',strtotime($arr_filter_date[1]));?></th>
            </tr>
			<tr class="table-baris1-bold">
				<td align="left">1.</td>
				<td align="left">TEMEF</td>
				<td align="right"><?php echo number_format($nilai_daftar_penerimaan_temef,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_daftar_penerimaan_temef_all,0,',','.');?></td>
	        </tr>
			<tr class="table-baris1-bold">
				<td align="left">2.</td>
				<td align="left">SC</td>
				<td align="right"><?php echo number_format($nilai_daftar_penerimaan_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_daftar_penerimaan_sc_all,0,',','.');?></td>
	        </tr>
			<tr class="table-total">
				<td align="right" colspan="2">GRAND TOTAL</td>
				<td align="right"><?php echo number_format($nilai_daftar_penerimaan_temef + $nilai_daftar_penerimaan_sc,0,',','.');?></td>
				<td align="right"><?php echo number_format($nilai_daftar_penerimaan_temef_all + $nilai_daftar_penerimaan_sc_all,0,',','.');?></td>
	        </tr>
		</table>
	</body>
</html>