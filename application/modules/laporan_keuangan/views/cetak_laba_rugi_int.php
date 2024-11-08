<!DOCTYPE html>
<?php
$this->db2 = $this->load->database('database2', TRUE);
$this->db3 = $this->load->database('database3', TRUE);
?>
<html>
	<head>
	  <title>LAPORAN LABA RUGI</title>
	  
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
					<div style="display: block;font-weight: bold;font-size: 10px;">LAPORAN LABA RUGI</div>
				    <div style="display: block;font-weight: bold;font-size: 10px;">PT. BIA BUMI JAYENDRA</div>
				</td>
			</tr>
		</table>	
		<table cellpadding="4" width="98%">
			<?php
			//PENJUALAN
			$penjualan = $this->db2->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
			->from('pmm_productions pp')
			->join('penerima p', 'pp.client_id = p.id','left')
			->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
			->where("pp.date_production between '$date1' and '$date2'")
			->where("pp.status = 'PUBLISH'")
			->where("ppo.status in ('OPEN','CLOSED')")
			->group_by("pp.client_id")
			->get()->result_array();
			
			$total_penjualan = 0;
			$total_volume = 0;

			foreach ($penjualan as $x){
				$total_penjualan += $x['price'];
				$total_volume += $x['volume'];
			}

			$total_penjualan_all = 0;
			$total_penjualan_all = $total_penjualan;
			//PENJUALAN

			//PENJUALAN_2
			$penjualan_2 = $this->db2->select('p.nama, pp.client_id, SUM(pp.display_price) as price, SUM(pp.display_volume) as volume, pp.convert_measure as measure')
			->from('pmm_productions pp')
			->join('penerima p', 'pp.client_id = p.id','left')
			->join('pmm_sales_po ppo', 'pp.salesPo_id = ppo.id','left')
			->where("pp.date_production between '$date3' and '$date2'")
			->where("pp.status = 'PUBLISH'")
			->where("ppo.status in ('OPEN','CLOSED')")
			->group_by("pp.client_id")
			->get()->result_array();
			
			$total_penjualan_2 = 0;
			$total_volume_2 = 0;

			foreach ($penjualan_2 as $x){
				$total_penjualan_2 += $x['price'];
				$total_volume_2 += $x['volume'];
			}

			$total_penjualan_all_2 = 0;
			$total_penjualan_all_2 = $total_penjualan_2;
			//PENJUALAN_2

			//BAHAN		
			$akumulasi = $this->db2->select('pp.date_akumulasi, SUM(pp.total_nilai_keluar) as total_nilai_keluar')
			->from('akumulasi pp')
			->where("(pp.date_akumulasi between '$date1' and '$date2')")
			->get()->result_array();

			$total_akumulasi = 0;

			foreach ($akumulasi as $a){
				$total_akumulasi += $a['total_nilai_keluar'];
			}

			$total_nilai = $total_akumulasi;
			//END BAHAN

			//BAHAN_2		
			$akumulasi_2 = $this->db2->select('pp.date_akumulasi, (pp.total_nilai_keluar) as total_nilai_keluar')
			->from('akumulasi pp')
			->where("(pp.date_akumulasi between '$date3' and '$date2')")
			->get()->result_array();

			$total_akumulasi_2 = 0;

			foreach ($akumulasi_2 as $a){
				$total_akumulasi_2 += $a['total_nilai_keluar'];
			}

			$total_nilai_2 = $total_akumulasi_2;
			//END BAHAN_2

			//ALAT
			$nilai_alat = $this->db2->select('SUM(prm.display_price) as nilai')
			->from('pmm_receipt_material prm')
			->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
			->join('produk p', 'prm.material_id = p.id','left')
			->where("prm.date_receipt between '$date1' and '$date2'")
			->where("p.kategori_alat in ('1','2','3','4','5','6','7','8','9','10','11')")
			->where("po.status in ('PUBLISH','CLOSED')")
			->get()->row_array();

			$akumulasi_bbm = $this->db2->select('pp.date_akumulasi, SUM(pp.total_nilai_keluar_2) as total_nilai_keluar_2')
			->from('akumulasi pp')
			->where("(pp.date_akumulasi between '$date1' and '$date2')")
			->get()->result_array();

			$total_akumulasi_bbm = 0;

			foreach ($akumulasi_bbm as $b){
				$total_akumulasi_bbm += $b['total_nilai_keluar_2'];
			}

			$total_nilai_bbm = $total_akumulasi_bbm;

			$total_insentif_tm = 0;
			$insentif_tm = $this->db2->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun = 220")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
			$total_insentif_tm = $insentif_tm['total'];

			$total_insentif_wl = 0;
			$insentif_wl = $this->db2->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun = 221")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();
			$total_insentif_wl = $insentif_wl['total'];

			$alat = $nilai_alat['nilai'] + $total_akumulasi_bbm + $total_insentif_tm + $total_insentif_wl;
			//END ALAT

			//ALAT_2
			$nilai_alat_2 = $this->db2->select('SUM(prm.display_price) as nilai')
			->from('pmm_receipt_material prm')
			->join('pmm_purchase_order po', 'prm.purchase_order_id = po.id','left')
			->join('produk p', 'prm.material_id = p.id','left')
			->where("prm.date_receipt between '$date3' and '$date2'")
			->where("p.kategori_alat in ('1','2','3','4','5','6','7','8','9','10','11')")
			->where("po.status in ('PUBLISH','CLOSED')")
			->get()->row_array();

			$akumulasi_bbm_2 = $this->db2->select('pp.date_akumulasi, SUM(pp.total_nilai_keluar_2) as total_nilai_keluar_2')
			->from('akumulasi pp')
			->where("(pp.date_akumulasi between '$date3' and '$date2')")
			->get()->result_array();

			$total_akumulasi_bbm_2 = 0;

			foreach ($akumulasi_bbm_2 as $b){
				$total_akumulasi_bbm_2 += $b['total_nilai_keluar_2'];
			}

			$total_nilai_bbm_2 = $total_akumulasi_bbm_2;

			$total_insentif_tm_2 = 0;
			$insentif_tm_2 = $this->db2->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun = 220")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date3' and '$date2')")
			->get()->row_array();
			$total_insentif_tm_2 = $insentif_tm_2['total'];

			$total_insentif_wl_2 = 0;
			$insentif_wl_2 = $this->db2->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->where("pdb.akun = 221")
			->where("status = 'PAID'")
			->where("(tanggal_transaksi between '$date3' and '$date2')")
			->get()->row_array();
			$total_insentif_wl_2 = $insentif_wl_2['total'];

			$alat_2 = $nilai_alat_2['nilai'] + $total_akumulasi_bbm_2 + $total_insentif_tm_2 + $total_insentif_wl_2;
			//END_ALAT_2

			//OVERHEAD
			$overhead_15 = $this->db2->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->join('pmm_coa c','pdb.akun = c.id','left')
			->where('c.coa_category',15)
			->where("c.id <> 168 ") //Biaya Diskonto Bank
			->where("c.id <> 219 ") //Biaya Alat Batching Plant 
			->where("c.id <> 220 ") //Biaya Alat Truck Mixer
			->where("c.id <> 221 ") //Biaya Alat Wheel Loader
			->where("c.id <> 228 ") //Biaya Persiapan
			->where("c.id <> 505 ") //Biaya Oli
			->where("pb.status = 'PAID'")
			->where("(pb.tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();

			$overhead_jurnal_15 = $this->db2->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->join('pmm_coa c','pdb.akun = c.id','left')
			->where('c.coa_category',15)
			->where("c.id <> 168 ") //Biaya Diskonto Bank
			->where("c.id <> 219 ") //Biaya Alat Batching Plant 
			->where("c.id <> 220 ") //Biaya Alat Truck Mixer
			->where("c.id <> 221 ") //Biaya Alat Wheel Loader
			->where("c.id <> 228 ") //Biaya Persiapan
			->where("c.id <> 505 ") //Biaya Oli
			->where("pb.status = 'PAID'")
			->where("(pb.tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();

			$overhead =  $overhead_15['total'] + $overhead_jurnal_15['total'];
			//END OVERHEAD

			//OVERHEAD_2
			$overhead_15_2 = $this->db2->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->join('pmm_coa c','pdb.akun = c.id','left')
			->where('c.coa_category',15)
			->where("c.id <> 168 ") //Biaya Diskonto Bank
			->where("c.id <> 219 ") //Biaya Alat Batching Plant 
			->where("c.id <> 220 ") //Biaya Alat Truck Mixer
			->where("c.id <> 221 ") //Biaya Alat Wheel Loader
			->where("c.id <> 228 ") //Biaya Persiapan
			->where("c.id <> 505 ") //Biaya Oli
			->where("pb.status = 'PAID'")
			->where("(pb.tanggal_transaksi between '$date3' and '$date2')")
			->get()->row_array();

			$overhead_jurnal_15_2 = $this->db2->select('sum(pdb.debit) as total')
			->from('pmm_jurnal_umum pb ')
			->join('pmm_detail_jurnal pdb','pb.id = pdb.jurnal_id','left')
			->join('pmm_coa c','pdb.akun = c.id','left')
			->where('c.coa_category',15)
			->where("c.id <> 168 ") //Biaya Diskonto Bank
			->where("c.id <> 219 ") //Biaya Alat Batching Plant 
			->where("c.id <> 220 ") //Biaya Alat Truck Mixer
			->where("c.id <> 221 ") //Biaya Alat Wheel Loader
			->where("c.id <> 228 ") //Biaya Persiapan
			->where("c.id <> 505 ") //Biaya Oli
			->where("pb.status = 'PAID'")
			->where("(pb.tanggal_transaksi between '$date3' and '$date2')")
			->get()->row_array();

			$overhead_2 =  $overhead_15_2['total'] + $overhead_jurnal_15_2['total'];
			//END_OVERHEAD_2

			//DISKONTO
			$diskonto = $this->db2->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->join('pmm_coa c','pdb.akun = c.id','left')
			->where("pdb.akun = 168")
			->where("pb.status = 'PAID'")
			->where("(pb.tanggal_transaksi between '$date1' and '$date2')")
			->get()->row_array();

			$diskonto = $diskonto['total'];
			//END DISKONTO

			//DISKONTO_2
			$diskonto_2 = $this->db2->select('sum(pdb.jumlah) as total')
			->from('pmm_biaya pb ')
			->join('pmm_detail_biaya pdb','pb.id = pdb.biaya_id','left')
			->join('pmm_coa c','pdb.akun = c.id','left')
			->where("pdb.akun = 168")
			->where("pb.status = 'PAID'")
			->where("(pb.tanggal_transaksi between '$date3' and '$date2')")
			->get()->row_array();

			$diskonto_2 = $diskonto_2['total'];
			//END_DISKONTO_2

			$bahan = $total_nilai;
			$alat = $alat;
			$overhead = $overhead;
			$diskonto = $diskonto;
			$total_biaya_operasional = $bahan + $alat + $overhead + $diskonto;
			$laba_kotor = $total_penjualan_all - $total_biaya_operasional;
			$laba_usaha = $laba_kotor;
			$persentase_laba_sebelum_pajak = ($total_penjualan_all!=0)?($laba_usaha / $total_penjualan_all) * 100:0;

			$bahan_2 = $total_nilai_2;
			$alat_2 = $alat_2;
			$overhead_2 = $overhead_2;
			$diskonto_2 = $diskonto_2;
			$total_biaya_operasional_2 = $bahan_2 + $alat_2 + $overhead_2 + $diskonto_2;
			$laba_kotor_2 = $total_penjualan_all_2 - $total_biaya_operasional_2;
			$laba_usaha_2 = $laba_kotor_2;
			$persentase_laba_sebelum_pajak_2 = ($total_penjualan_all_2!=0)?($laba_usaha_2 / $total_penjualan_all_2) * 100:0;
			?>
			<tr class="table-judul">
                <th align="center" width="5%">NO.</th>
                <th align="left" width="35%">UNIT BISNIS / PROYEK</th>
                <th align="right" width="30%"><?php echo $filter_date = $filter_date = date('d/m/Y',strtotime($arr_filter_date[0])).' - '.date('d/m/Y',strtotime($arr_filter_date[1]));?></th>
                <th align="right" width="30%">SD. <?php echo $filter_date_2 = date('d/m/Y',strtotime($arr_filter_date[1]));?></th>
            </tr>
			<tr class="table-baris1-bold">
				<td class="text-left">1.</td>
				<td align="left">TEMEF</td>
				<td align="right"><?php echo number_format($laba_usaha,0,',','.');?></td>
				<td align="right"><?php echo number_format($laba_usaha_2,0,',','.');?></td>
	        </tr>
			<tr class="table-baris1-bold">
				<td align="left">2.</td>
				<td class="text-left">SC</td>
				<td align="right"><?php echo number_format(0,0,',','.');?></td>
				<td align="right"><?php echo number_format(0,0,',','.');?></td>
	        </tr>
			<tr class="table-total">
				<td align="right" colspan="2">GRAND TOTAL</td>
				<td align="right"><?php echo number_format($laba_usaha,0,',','.');?></td>
				<td align="right"><?php echo number_format($laba_usaha_2,0,',','.');?></td>
	        </tr>
		</table>
	</body>
</html>