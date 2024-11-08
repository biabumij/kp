<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Laporan extends Secure_Controller {
	private $db2;
    private $db3;

	public function __construct()
	{
        parent::__construct();
        // Your own constructor code
        $this->load->model(array('admin/m_admin','crud_global','m_themes','pages/m_pages','menu/m_menu','admin_access/m_admin_access','DB_model','member_back/m_member_back','m_member','pmm/pmm_model','admin/Templates','pmm/pmm_finance','m_laporan'));
        $this->load->library('enkrip');
		$this->load->library('filter');
		$this->load->library('waktu');
		$this->load->library('session');
		$this->db2 = $this->load->database('database2', TRUE);
		$this->db3 = $this->load->database('database3', TRUE);
	}

	public function cetak_laporan_laba_rugi()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true); 
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');

		$arr_date = $this->input->get('filter_date');
		if(empty($arr_date)){
			$filter_date = '-';
		}else {
			$arr_filter_date = explode(' - ', $arr_date);
			$start_date = date('Y-m-d',strtotime($arr_filter_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('d F Y',strtotime($arr_filter_date[0])).' - '.date('d F Y',strtotime($arr_filter_date[1]));
		}
		$data['filter_date'] = $filter_date;
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
        $html = $this->load->view('laporan_keuangan/cetak_laporan_laba_rugi',$data,TRUE);

        
        $pdf->SetTitle('BBJ - Laporan Laba Rugi');
        $pdf->nsi_html($html);
        $pdf->Output('laporan-laba-rugi.pdf', 'I');
	
	}

	public function cetak_bahan()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true); 
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		        $pdf->AddPage('P');

		$arr_date = $this->input->get('filter_date');
		if(empty($arr_date)){
			$filter_date = '-';
		}else {
			$arr_filter_date = explode(' - ', $arr_date);
			$start_date = date('Y-m-d',strtotime($arr_filter_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('d F Y',strtotime($arr_filter_date[0])).' - '.date('d F Y',strtotime($arr_filter_date[1]));
		}
		$data['filter_date'] = $filter_date;
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
        $html = $this->load->view('laporan_keuangan/cetak_bahan',$data,TRUE);

        
        $pdf->SetTitle('BBJ - Bahan');
        $pdf->nsi_html($html);
        $pdf->Output('bahan.pdf', 'I');
	}

	public function cetak_bahan_akumulasi()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true); 
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		        $pdf->AddPage('P');

		$arr_date = $this->input->get('filter_date');
		if(empty($arr_date)){
			$filter_date = '-';
		}else {
			$arr_filter_date = explode(' - ', $arr_date);
			$filter_date = date('d F Y',strtotime($arr_filter_date[0])).' - '.date('d F Y',strtotime($arr_filter_date[1]));
		}
		$data['filter_date'] = $filter_date;
        $html = $this->load->view('laporan_keuangan/cetak_bahan_akumulasi',$data,TRUE);

        
        $pdf->SetTitle('BBJ - Bahan');
        $pdf->nsi_html($html);
        $pdf->Output('bahan.pdf', 'I');
	}

	public function cetak_alat()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true); 
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		        $pdf->AddPage('P');

		$arr_date = $this->input->get('filter_date');
		if(empty($arr_date)){
			$filter_date = '-';
		}else {
			$arr_filter_date = explode(' - ', $arr_date);
			$start_date = date('Y-m-d',strtotime($arr_filter_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('d F Y',strtotime($arr_filter_date[0])).' - '.date('d F Y',strtotime($arr_filter_date[1]));
		}
		$data['filter_date'] = $filter_date;
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
        $html = $this->load->view('laporan_keuangan/cetak_alat',$data,TRUE);

        
        $pdf->SetTitle('BBJ - Alat');
        $pdf->nsi_html($html);
        $pdf->Output('alat.pdf', 'I');
	}

	public function cetak_overhead()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true); 
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		        $pdf->AddPage('P');

		$arr_date = $this->input->get('filter_date');
		if(empty($arr_date)){
			$filter_date = '-';
		}else {
			$arr_filter_date = explode(' - ', $arr_date);
			$start_date = date('Y-m-d',strtotime($arr_filter_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('d F Y',strtotime($arr_filter_date[0])).' - '.date('d F Y',strtotime($arr_filter_date[1]));
		}
		$data['filter_date'] = $filter_date;
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
		$data['date1'] = date('Y-m-d',strtotime($arr_filter_date[0]));
		$data['date2'] = date('Y-m-d',strtotime($arr_filter_date[1]));
		$data['biaya_langsung_parent'] = $this->m_laporan->biaya_langsung_print_parent($arr_date);
		$data['biaya_langsung'] = $this->m_laporan->biaya_langsung_print($arr_date);
		$data['biaya_langsung_jurnal_parent'] = $this->m_laporan->biaya_langsung_jurnal_print_parent($arr_date);
		$data['biaya_langsung_jurnal'] = $this->m_laporan->biaya_langsung_jurnal_print($arr_date);
		$data['biaya_parent'] = $this->m_laporan->showBiaya_print_parent($arr_date);
        $data['biaya'] = $this->m_laporan->showBiaya_print($arr_date);
		$data['biaya_jurnal_parent'] = $this->m_laporan->showBiayaJurnal_print_parent($arr_date);
		$data['biaya_jurnal'] = $this->m_laporan->showBiayaJurnal_print($arr_date);
		$data['biaya_lainnya_parent'] = $this->m_laporan->showBiayaLainnya_print_parent($arr_date);
        $data['biaya_lainnya'] = $this->m_laporan->showBiayaLainnya_print($arr_date);
		$data['biaya_lainnya_jurnal_parent'] = $this->m_laporan->showBiayaLainnyaJurnal_print_parent($arr_date);
		$data['biaya_lainnya_jurnal'] = $this->m_laporan->showBiayaLainnyaJurnal_print($arr_date);
		$data['biaya_persiapan_parent'] = $this->m_laporan->showPersiapanBiaya_print_parent($arr_date);
		$data['biaya_persiapan'] = $this->m_laporan->showPersiapanBiaya_print($arr_date);
		$data['biaya_persiapan_jurnal_parent'] = $this->m_laporan->showPersiapanJurnal_print_parent($arr_date);
		$data['biaya_persiapan_jurnal'] = $this->m_laporan->showPersiapanJurnal($arr_date);

        $html = $this->load->view('laporan_keuangan/cetak_overhead',$data,TRUE);

        
        $pdf->SetTitle('BBJ - Overhead');
        $pdf->nsi_html($html);
        $pdf->Output('alat.pdf', 'I');
	}

	public function cetak_diskonto()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true); 
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		        $pdf->AddPage('P');

		$arr_date = $this->input->get('filter_date');
		if(empty($arr_date)){
			$filter_date = '-';
		}else {
			$arr_filter_date = explode(' - ', $arr_date);
			$start_date = date('Y-m-d',strtotime($arr_filter_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('d F Y',strtotime($arr_filter_date[0])).' - '.date('d F Y',strtotime($arr_filter_date[1]));
		}
		$data['filter_date'] = $filter_date;
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
		$data['date1'] = date('Y-m-d',strtotime($arr_filter_date[0]));
		$data['date2'] = date('Y-m-d',strtotime($arr_filter_date[1]));
		$data['biaya_langsung_parent'] = $this->m_laporan->biaya_langsung_print_parent($arr_date);
		$data['biaya_langsung'] = $this->m_laporan->biaya_langsung_print($arr_date);
		$data['biaya_langsung_jurnal_parent'] = $this->m_laporan->biaya_langsung_jurnal_print_parent($arr_date);
		$data['biaya_langsung_jurnal'] = $this->m_laporan->biaya_langsung_jurnal_print($arr_date);
		$data['biaya_parent'] = $this->m_laporan->showBiaya_print_parent($arr_date);
        $data['biaya'] = $this->m_laporan->showBiaya_print($arr_date);
		$data['biaya_jurnal_parent'] = $this->m_laporan->showBiayaJurnal_print_parent($arr_date);
		$data['biaya_jurnal'] = $this->m_laporan->showBiayaJurnal_print($arr_date);
		$data['biaya_lainnya_parent'] = $this->m_laporan->showBiayaLainnya_print_parent($arr_date);
        $data['biaya_lainnya'] = $this->m_laporan->showBiayaLainnya_print($arr_date);
		$data['biaya_lainnya_jurnal_parent'] = $this->m_laporan->showBiayaLainnyaJurnal_print_parent($arr_date);
		$data['biaya_lainnya_jurnal'] = $this->m_laporan->showBiayaLainnyaJurnal_print($arr_date);
		$data['biaya_persiapan_parent'] = $this->m_laporan->showPersiapanBiaya_print_parent($arr_date);
		$data['biaya_persiapan'] = $this->m_laporan->showPersiapanBiaya_print($arr_date);
		$data['biaya_persiapan_jurnal_parent'] = $this->m_laporan->showPersiapanJurnal_print_parent($arr_date);
		$data['biaya_persiapan_jurnal'] = $this->m_laporan->showPersiapanJurnal($arr_date);
        $html = $this->load->view('laporan_keuangan/cetak_diskonto',$data,TRUE);

        
        $pdf->SetTitle('BBJ - Diskonto');
        $pdf->nsi_html($html);
        $pdf->Output('diskonto.pdf', 'I');
	}

	public function cetak_cash_flow()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetMargins(5, 5, 5);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);

		$pdf->AddPage('L');
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		//$pdf->SetY(45);
		//$pdf->SetX(6);
		//$pdf->SetMargins(10, 10);    

		$arr_date = $this->input->get('filter_date');
		if(empty($arr_date)){
			$filter_date = '-';
		}else {
			$arr_filter_date = explode(' - ', $arr_date);
			$filter_date = date('d F Y',strtotime($arr_filter_date[0])).' - '.date('d F Y',strtotime($arr_filter_date[1]));
		}
		$data['filter_date'] = $filter_date;
        $html = $this->load->view('laporan_keuangan/cetak_cash_flow',$data,TRUE);

        
        $pdf->SetTitle('BBJ - Cash Flow');
        $pdf->nsi_html($html);
        $pdf->Output('cash-flow.pdf', 'I');
	
	}

	public function cetak_pemakaian_dana()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true); 
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		        $pdf->AddPage('P');

		$arr_date = $this->input->get('filter_date');
		if(empty($arr_date)){
			$filter_date = '-';
		}else {
			$arr_filter_date = explode(' - ', $arr_date);
			$filter_date = date('d F Y',strtotime($arr_filter_date[0])).' - '.date('d F Y',strtotime($arr_filter_date[1]));
		}
		$data['filter_date'] = $filter_date;
		$data['date1'] = date('Y-m-d',strtotime($arr_filter_date[0]));
		$data['date2'] = date('Y-m-d',strtotime($arr_filter_date[1]));
		$data['pemakaian_dana_parent'] = $this->m_laporan->showBiayaPemakaianDanaParent($arr_date);
        $data['pemakaian_dana'] = $this->m_laporan->showBiayaPemakaianDana($arr_date);
		$data['pemakaian_dana_jurnal_parent'] = $this->m_laporan->showBiayaPemakaianDanaJurnalParent($arr_date);
		$data['pemakaian_dana_jurnal'] = $this->m_laporan->showBiayaPemakaianDanaJurnal($arr_date);
		
		$html = $this->load->view('laporan_keuangan/cetak_pemakaian_dana',$data,TRUE);
        
        $pdf->SetTitle('BBJ - Pemakaian Dana');
        $pdf->nsi_html($html);
        $pdf->Output('pemakaian_dana.pdf', 'I');
	}

	public function cetak_penerimaan_pembelian()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
		$pdf->setPrintFooter(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');

		$arr_data = array();
		$supplier_id = $this->input->get('supplier_id');
		$purchase_order_no = $this->input->get('purchase_order_no');
		$filter_material = $this->input->get('filter_material');
		$filter_kategori = $this->input->get('filter_kategori');
		$start_date = false;
		$end_date = false;
		$total = 0;
		$date = $this->input->get('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
			$filter_date = date('d F Y',strtotime($arr_date[0])).' - '.date('d F Y',strtotime($arr_date[1]));

			
			$data['filter_date'] = $filter_date;
			$data['start_date'] = $start_date;
			$data['end_date'] = $end_date;

			$this->db->select('ppo.supplier_id,prm.display_measure as measure,ps.nama as name, prm.display_harga_satuan as price,SUM(prm.display_volume) as volume, SUM(prm.display_price) as total_price');
			
			if(!empty($start_date) && !empty($end_date)){
				$this->db->where('prm.date_receipt >=',$start_date);
				$this->db->where('prm.date_receipt <=',$end_date);
			}
			if(!empty($supplier_id)){
				$this->db->where('ppo.supplier_id',$supplier_id);
			}
			if(!empty($filter_material)){
				$this->db->where_in('prm.material_id',$filter_material);
			}
			if(!empty($purchase_order_no)){
				$this->db->where('prm.purchase_order_id',$purchase_order_no);
			}
			if(!empty($filter_kategori)){
				$this->db->where('ppo.kategori_id',$filter_kategori);
			}

			$this->db->join('penerima ps','ppo.supplier_id = ps.id','left');
			$this->db->join('pmm_receipt_material prm','ppo.id = prm.purchase_order_id');
			$this->db->where("ppo.status in ('PUBLISH','CLOSED')");
			$this->db->group_by('ppo.supplier_id');
			$this->db->order_by('ps.nama','asc');
			$query = $this->db->get('pmm_purchase_order ppo');

			$no = 1;
			if($query->num_rows() > 0){

				foreach ($query->result_array() as $key => $sups) {

					$mats = array();
					$materials = $this->pmm_model->GetPenerimaanPembelianPrint($sups['supplier_id'],$purchase_order_no,$start_date,$end_date,$filter_material,$filter_kategori);
					if(!empty($materials)){
						foreach ($materials as $key => $row) {
							$arr['no'] = $key + 1;
							$arr['measure'] = $row['measure'];
							$arr['nama_produk'] = $row['nama_produk'];
							$arr['volume'] = number_format($row['volume'],2,',','.');
							$arr['price'] = number_format($row['price'],0,',','.');
							$arr['total_price'] = number_format($row['total_price'],0,',','.');
							
							
							$arr['name'] = $sups['name'];
							$mats[] = $arr;
						}
						$sups['mats'] = $mats;
						$total += $sups['total_price'];
						$sups['no'] =$no;
						$sups['volume'] = number_format($sups['volume'],2,',','.');
						$sups['total_price'] = number_format($sups['total_price'],0,',','.');

						$arr_data[] = $sups;
						$no++;
					}
					
					
				}
			}

			
			$data['data'] = $arr_data;
			$data['total'] = $total;
	        $html = $this->load->view('laporan_pembelian/cetak_penerimaan_pembelian',$data,TRUE);

	        
	        $pdf->SetTitle('BBJ - Laporan Pembelian');
	        $pdf->nsi_html($html);
	        $pdf->Output('laporan-pembelian.pdf', 'I');
	        
		}else {
			echo 'Please Filter Date First';
		}
	
	}

	public function cetak_laporan_hutang()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
		$pdf->setPrintFooter(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');

		$arr_data = array();
		$supplier_id = $this->input->get('supplier_id');
		$filter_kategori = $this->input->get('filter_kategori');
		$start_date = false;
		$end_date = false;
		$total_penerimaan = 0;
		$total_tagihan = 0;
		$total_tagihan_bruto = 0;
		$total_pembayaran = 0;
		$total_sisa_hutang_penerimaan = 0;
		$total_sisa_hutang_tagihan = 0;
		$date = $this->input->get('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
			$filter_date = date('d F Y',strtotime($arr_date[0])).' - '.date('d F Y',strtotime($arr_date[1]));

			
			$data['filter_date'] = $filter_date;
			$data['date2'] = $end_date;

			$this->db->select('ppo.id, ppo.supplier_id, ps.nama as name');
			$this->db->join('pmm_purchase_order ppo','prm.purchase_order_id = ppo.id','left');
			
			if(!empty($start_date) && !empty($end_date)){
				$this->db->where('prm.date_receipt >=',$start_date);
				$this->db->where('prm.date_receipt <=',$end_date);
			}
			if(!empty($supplier_id)){
				$this->db->where('ppo.supplier_id',$supplier_id);
			}
			if(!empty($filter_kategori)){
				$this->db->where('ppo.kategori_id',$filter_kategori);
			}

		$this->db->join('penerima ps','ppo.supplier_id = ps.id','left');
		$this->db->where("ppo.status in ('PUBLISH','CLOSED')");
		$this->db->group_by('ppo.supplier_id');
		$this->db->order_by('ps.nama','asc');
		$query = $this->db->get('pmm_receipt_material prm');

			$no = 1;
			if($query->num_rows() > 0){

				foreach ($query->result_array() as $key => $sups) {

					$mats = array();
					$materials = $this->pmm_model->GetLaporanHutang($sups['supplier_id'],$start_date,$end_date,$filter_kategori);
					if(!empty($materials)){
						foreach ($materials as $key => $row) {
							$arr['no'] = $key + 1;
							$arr['nama_produk'] = $row['nama_produk'];
							$arr['purchase_order_id'] = '<a href="'.base_url().'pmm/purchase_order/manage/'.$row['purchase_order_id'].'" target="_blank">'.$row['purchase_order_id'] = $this->crud_global->GetField('pmm_purchase_order',array('id'=>$row['purchase_order_id']),'no_po').'</a>';
							$arr['penerimaan'] = number_format($row['penerimaan'],0,',','.');
							$arr['tagihan'] = number_format($row['tagihan'],0,',','.');
							$arr['tagihan_bruto'] = number_format($row['tagihan_bruto'],0,',','.');
							$arr['pembayaran'] = number_format($row['pembayaran'],0,',','.');
							$arr['sisa_hutang_penerimaan'] = number_format($row['sisa_hutang_penerimaan'],0,',','.');
							$arr['sisa_hutang_tagihan'] = number_format($row['sisa_hutang_tagihan'],0,',','.');

							$total_penerimaan += $row['penerimaan'];
							$total_tagihan += $row['tagihan'];
							$total_tagihan_bruto += $row['tagihan_bruto'];
							$total_pembayaran += $row['pembayaran'];
							$total_sisa_hutang_penerimaan += $row['sisa_hutang_penerimaan'];
							$total_sisa_hutang_tagihan += $row['sisa_hutang_tagihan'];
							
							
							$arr['name'] = $sups['name'];
							$mats[] = $arr;
						}
						$sups['mats'] = $mats;
						$sups['no'] =$no;

						$arr_data[] = $sups;
						$no++;
					}
					
					
				}
			}

			
			$data['data'] = $arr_data;
			$data['total_penerimaan'] = $total_penerimaan;
			$data['total_tagihan'] = $total_tagihan;
			$data['total_tagihan_bruto'] = $total_tagihan_bruto;
			$data['total_pembayaran'] = $total_pembayaran;
			$data['total_sisa_hutang_penerimaan'] = $total_sisa_hutang_penerimaan;
			$data['total_sisa_hutang_tagihan'] = $total_sisa_hutang_tagihan;
	        $html = $this->load->view('laporan_pembelian/cetak_laporan_hutang',$data,TRUE);

	        
	        $pdf->SetTitle('BBJ - Laporan Hutang');
	        $pdf->nsi_html($html);
	        $pdf->Output('laporan-hutang.pdf', 'I');
	        
		}else {
			echo 'Please Filter Date First';
		}
	
	}

	public function cetak_monitoring_hutang()
	{
		$this->load->library('pdf');
	
		$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
		$pdf->setPrintFooter(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('L');
		$pdf->setPrintHeader(false);

		//Page2
		$pdf->AddPage('L', 'A4');
		$pdf->SetY(23);
		$pdf->SetX(6);
		$html =
		'<style type="text/css">
		 body {
			font-family: helvetica;
		}

		table.table-border-atas-full, th.table-border-atas-full, td.table-border-atas-full {
			border-top: 1px solid black;
			border-bottom: 1px solid black;
		}

		table.table-border-atas-only, th.table-border-atas-only, td.table-border-atas-only {
			border-top: 1px solid black;
		}

		table.table-border-bawah-only, th.table-border-bawah-only, td.table-border-bawah-only {
			border-bottom: 1px solid black;
		}

		table tr.table-judul{
			border: 1px solid;
			background-color: #e69500;
			font-weight: bold;
			font-size: 5px;
			color: black;
		}
			
		table tr.table-baris1{
			background-color: none;
			font-size: 5px;
		}

		table tr.table-baris1-bold{
			background-color: none;
			font-size: 5px;
			font-weight: bold;
		}
			
		table tr.table-total{
			background-color: #FFFF00;
			font-weight: bold;
			font-size: 5px;
			color: black;
		}

		table tr.table-total2{
			background-color: #eeeeee;
			font-weight: bold;
			font-size: 5px;
			color: black;
		}
	  	</style>
		<table width="98%" border="0" cellpadding="2">
			<tr class="table-judul">
				<th width="3%" align="center" rowspan="2" class="table-border-atas-full">&nbsp; <br />NO.</th>
				<th width="12%" align="center" rowspan="2" class="table-border-atas-full">&nbsp; <br />REKANAN / NO. TAGIHAN</th>
				<th width="6%" align="center" rowspan="2" class="table-border-atas-full">&nbsp; <br />TGL. TAGIHAN</th>
				<th width="9%" align="center" rowspan="2" class="table-border-atas-full">&nbsp; <br />JENIS PEMBELIAN</th>
				<th width="5%" align="center" rowspan="2" class="table-border-atas-full">TGL. VERIFIKASI</th>
				<th width="5%" align="center" rowspan="2" class="table-border-atas-full">SYARAT PEMBAYARAN</th>
				<th width="15%" align="center" colspan="3" class="table-border-atas-only">TAGIHAN</th>
				<th width="20%" align="center" colspan="4" class="table-border-atas-only">PEMBAYARAN</th>
				<th width="15%" align="center" colspan="3" class="table-border-atas-only">SISA HUTANG</th>
				<th width="5%" align="center" rowspan="2" class="table-border-atas-full">&nbsp; <br />STATUS</th>
				<th width="5%" align="center" rowspan="2" class="table-border-atas-full">TGL. JATUH TEMPO</th>
			</tr>
			<tr class="table-judul">
				<th align="center" class="table-border-bawah-only">DPP</th>
				<th align="center" class="table-border-bawah-only">PPN</th>
				<th align="center" class="table-border-bawah-only">JUMLAH</th>
				<th align="center" class="table-border-bawah-only">DPP</th>
				<th align="center" class="table-border-bawah-only">PPN</th>
				<th align="center" class="table-border-bawah-only">PPH</th>
				<th align="center" class="table-border-bawah-only">JUMLAH</th>
				<th align="center" class="table-border-bawah-only">DPP</th>
				<th align="center" class="table-border-bawah-only">PPN</th>
				<th align="center" class="table-border-bawah-only">JUMLAH</th>
			</tr>		
		</table>';
		$pdf->writeHTML($html, true, false, true, false, '');

		//Page3
		$pdf->AddPage();
		$pdf->SetY(23);
		$pdf->SetX(6);
		$pdf->WriteHTML($html);

		//Page4
		$pdf->AddPage();
		$pdf->SetY(23);
		$pdf->SetX(6);
		$pdf->WriteHTML($html);

		//Page5
		$pdf->AddPage();
		$pdf->SetY(23);
		$pdf->SetX(6);
		$pdf->WriteHTML($html);

		//Page6
		$pdf->AddPage();
		$pdf->SetY(23);
		$pdf->SetX(6);
		$pdf->WriteHTML($html);

		//Page1
		$pdf->setPage(1, true);
		$pdf->SetY(35);
		$pdf->Cell(0, 0, '', 0, 0, 'C');

		$arr_data = array();
		$supplier_id = $this->input->get('supplier_id');
		$filter_kategori = $this->input->get('filter_kategori');
		$filter_status = $this->input->get('filter_status');
		$start_date = false;
		$end_date = false;
		$total_dpp_tagihan = 0;
		$total_ppn_tagihan = 0;
		$total_jumlah_tagihan = 0;
		$total_dpp_pembayaran = 0;
		$total_ppn_pembayaran = 0;
		$total_pph_pembayaran = 0;
		$total_jumlah_pembayaran = 0;
		$total_dpp_sisa_hutang = 0;
		$total_ppn_sisa_hutang = 0;
		$total_jumlah_sisa_hutang = 0;
		$date = $this->input->get('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
			$filter_date = date('d F Y',strtotime($arr_date[0])).' - '.date('d F Y',strtotime($arr_date[1]));

			
			$data['filter_date'] = $filter_date;
			$data['date2'] = $end_date;

			$this->db->select('ppp.id, ppp.supplier_id, ps.nama as name');
			$this->db->join('penerima ps','ppp.supplier_id = ps.id','left');
			$this->db->join('pmm_purchase_order ppo','ppp.purchase_order_id = ppo.id','left');
			
			if(!empty($start_date) && !empty($end_date)){
				$this->db->where('ppp.created_on >=',$start_date.' 23:59:59');
           		$this->db->where('ppp.created_on <=',$end_date.' 23:59:59');
			}
			if(!empty($supplier_id)){
				$this->db->where('ppo.supplier_id',$supplier_id);
			}
			if(!empty($filter_kategori)){
				$this->db->where('ppo.kategori_id',$filter_kategori);
			}
			if(!empty($filter_status)){
				$this->db->where('ppp.status',$filter_status);
			}

			$this->db->where("ppp.verifikasi_dok in ('SUDAH','LENGKAP')");
			$this->db->group_by('ppp.supplier_id');
			$this->db->order_by('ps.nama','asc');
			$query = $this->db->get('pmm_penagihan_pembelian ppp');

			$no = 1;
			if($query->num_rows() > 0){

				foreach ($query->result_array() as $key => $sups) {

					$mats = array();
					$materials = $this->pmm_model->GetLaporanMonitoringHutang($sups['supplier_id'],$start_date,$end_date,$filter_kategori,$filter_status);
					if(!empty($materials)){
						foreach ($materials as $key => $row) {
							$awal  = date_create($row['status_umur_hutang']);
							$akhir = date_create($end_date);
							$diff  = date_diff( $awal, $akhir );

							$tanggal_tempo = date('Y-m-d', strtotime(+$row['syarat_pembayaran'].'days', strtotime($row['tanggal_lolos_verifikasi'])));

							$awal_tempo =date_create($tanggal_tempo);
							$akhir_tempo =date_create($end_date);
							$diff_tempo =date_diff($awal_tempo,$akhir_tempo);

							$arr['no'] = $key + 1;
							$arr['nama'] = $row['nama'];
							$arr['subject'] = $row['subject'];
							$arr['status'] = $row['status'];
							$arr['syarat_pembayaran'] = $row['syarat_pembayaran'];
							//$arr['syarat_pembayaran'] = $diff->days . ' Hari';
							//$arr['syarat_pembayaran'] = $diff->days . ' ';
							//$arr['jatuh_tempo'] =  $diff_tempo->format("%R%a");
							$arr['jatuh_tempo'] =  date('d-m-Y',strtotime($tanggal_tempo));
							$arr['nomor_invoice'] = $row['nomor_invoice'];
							$arr['tanggal_invoice'] = date('d-m-Y',strtotime($row['tanggal_invoice']));
							$arr['tanggal_lolos_verifikasi'] = date('d-m-Y',strtotime($row['tanggal_lolos_verifikasi']));
							$arr['dpp_tagihan'] = number_format($row['dpp_tagihan'],0,',','.');
							$arr['ppn_tagihan'] = number_format($row['ppn_tagihan'],0,',','.');
							$arr['jumlah_tagihan'] = number_format($row['jumlah_tagihan'],0,',','.');
							$arr['dpp_pembayaran'] = number_format($row['dpp_pembayaran'],0,',','.');
							$arr['ppn_pembayaran'] = number_format($row['ppn_pembayaran'],0,',','.');
							$arr['pph_pembayaran'] = number_format($row['pph_pembayaran'],0,',','.');
							$arr['jumlah_pembayaran'] = number_format($row['jumlah_pembayaran'],0,',','.');
							$arr['dpp_sisa_hutang'] = number_format($row['dpp_sisa_hutang'],0,',','.');
							$arr['ppn_sisa_hutang'] = number_format($row['ppn_sisa_hutang'],0,',','.');
							$arr['jumlah_sisa_hutang'] = number_format($row['jumlah_sisa_hutang'],0,',','.');

							$total_dpp_tagihan += $row['dpp_tagihan'];
							$total_ppn_tagihan += $row['ppn_tagihan'];
							$total_jumlah_tagihan += $row['jumlah_tagihan'];
							$total_dpp_pembayaran += $row['dpp_pembayaran'];
							$total_ppn_pembayaran += $row['ppn_pembayaran'];
							$total_pph_pembayaran += $row['pph_pembayaran'];
							$total_jumlah_pembayaran += $row['jumlah_pembayaran'];
							$total_dpp_sisa_hutang += $row['dpp_sisa_hutang'];
							$total_ppn_sisa_hutang += $row['ppn_sisa_hutang'];
							$total_jumlah_sisa_hutang += $row['jumlah_sisa_hutang'];
							
							
							$arr['name'] = $sups['name'];
							$mats[] = $arr;
						}
						$sups['mats'] = $mats;
						$sups['no'] =$no;

						$arr_data[] = $sups;
						$no++;
					}
					
					
				}
			}

			
			$data['data'] = $arr_data;
			$data['total_dpp_tagihan'] = $total_dpp_tagihan;
			$data['total_ppn_tagihan'] = $total_ppn_tagihan;
			$data['total_jumlah_tagihan'] = $total_jumlah_tagihan;
			$data['total_dpp_pembayaran'] = $total_dpp_pembayaran;
			$data['total_ppn_pembayaran'] = $total_ppn_pembayaran;
			$data['total_pph_pembayaran'] = $total_pph_pembayaran;
			$data['total_jumlah_pembayaran'] = $total_jumlah_pembayaran;
			$data['total_dpp_sisa_hutang'] = $total_dpp_sisa_hutang;
			$data['total_ppn_sisa_hutang'] = $total_ppn_sisa_hutang;
			$data['total_jumlah_sisa_hutang'] = $total_jumlah_sisa_hutang;
	        $html = $this->load->view('laporan_pembelian/cetak_monitoring_hutang',$data,TRUE);

	        
	        $pdf->SetTitle('BBJ - Laporan Monitoring Hutang');
	        $pdf->nsi_html($html);
	        $pdf->Output('monitoring-hutang.pdf', 'I');
	        
		}else {
			echo 'Please Filter Date First';
		}
	
	}

	public function cetak_monitoring_hutang_bahan_alat()
	{
		$this->load->library('pdf');
	
		$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
		$pdf->setPrintFooter(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('L');
		$pdf->setPrintHeader(false);

		//Page2
		$pdf->AddPage('L', 'A4');
		$pdf->SetY(23);
		$pdf->SetX(6);
		$html =
		'<style type="text/css">
		 body {
			font-family: helvetica;
		}

		table.table-border-atas-full, th.table-border-atas-full, td.table-border-atas-full {
			border-top: 1px solid black;
			border-bottom: 1px solid black;
		}

		table.table-border-atas-only, th.table-border-atas-only, td.table-border-atas-only {
			border-top: 1px solid black;
		}

		table.table-border-bawah-only, th.table-border-bawah-only, td.table-border-bawah-only {
			border-bottom: 1px solid black;
		}

		table tr.table-judul{
			border: 1px solid;
			background-color: #e69500;
			font-weight: bold;
			font-size: 5px;
			color: black;
		}
			
		table tr.table-baris1{
			background-color: none;
			font-size: 5px;
		}

		table tr.table-baris1-bold{
			background-color: none;
			font-size: 5px;
			font-weight: bold;
		}
			
		table tr.table-total{
			background-color: #FFFF00;
			font-weight: bold;
			font-size: 5px;
			color: black;
		}

		table tr.table-total2{
			background-color: #eeeeee;
			font-weight: bold;
			font-size: 5px;
			color: black;
		}
	  	</style>
		<table width="98%" border="0" cellpadding="2">
			<tr class="table-judul">
				<th width="3%" align="center" rowspan="2" class="table-border-atas-full">&nbsp; <br />NO.</th>
				<th width="12%" align="center" rowspan="2" class="table-border-atas-full">&nbsp; <br />REKANAN / NO. TAGIHAN</th>
				<th width="6%" align="center" rowspan="2" class="table-border-atas-full">&nbsp; <br />TGL. TAGIHAN</th>
				<th width="9%" align="center" rowspan="2" class="table-border-atas-full">&nbsp; <br />JENIS PEMBELIAN</th>
				<th width="5%" align="center" rowspan="2" class="table-border-atas-full">TGL. VERIFIKASI</th>
				<th width="5%" align="center" rowspan="2" class="table-border-atas-full">SYARAT PEMBAYARAN</th>
				<th width="15%" align="center" colspan="3" class="table-border-atas-only">TAGIHAN</th>
				<th width="20%" align="center" colspan="4" class="table-border-atas-only">PEMBAYARAN</th>
				<th width="15%" align="center" colspan="3" class="table-border-atas-only">SISA HUTANG</th>
				<th width="5%" align="center" rowspan="2" class="table-border-atas-full">&nbsp; <br />STATUS</th>
				<th width="5%" align="center" rowspan="2" class="table-border-atas-full">TGL. JATUH TEMPO</th>
			</tr>
			<tr class="table-judul">
				<th align="center" class="table-border-bawah-only">DPP</th>
				<th align="center" class="table-border-bawah-only">PPN</th>
				<th align="center" class="table-border-bawah-only">JUMLAH</th>
				<th align="center" class="table-border-bawah-only">DPP</th>
				<th align="center" class="table-border-bawah-only">PPN</th>
				<th align="center" class="table-border-bawah-only">PPH</th>
				<th align="center" class="table-border-bawah-only">JUMLAH</th>
				<th align="center" class="table-border-bawah-only">DPP</th>
				<th align="center" class="table-border-bawah-only">PPN</th>
				<th align="center" class="table-border-bawah-only">JUMLAH</th>
			</tr>	
		</table>';
		$pdf->writeHTML($html, true, false, true, false, '');

		//Page3
		$pdf->AddPage();
		$pdf->SetY(23);
		$pdf->SetX(6);
		$pdf->WriteHTML($html);

		//Page4
		$pdf->AddPage();
		$pdf->SetY(23);
		$pdf->SetX(6);
		$pdf->WriteHTML($html);

		//Page5
		$pdf->AddPage();
		$pdf->SetY(23);
		$pdf->SetX(6);
		$pdf->WriteHTML($html);

		//Page6
		$pdf->AddPage();
		$pdf->SetY(23);
		$pdf->SetX(6);
		$pdf->WriteHTML($html);

		//Page1
		$pdf->setPage(1, true);
		$pdf->SetY(35);
		$pdf->Cell(0, 0, '', 0, 0, 'C');

		$arr_data = array();
		$supplier_id = $this->input->get('supplier_id');
		$filter_kategori = $this->input->get('filter_kategori');
		$filter_status = $this->input->get('filter_status');
		$start_date = false;
		$end_date = false;
		$total_dpp_tagihan = 0;
		$total_ppn_tagihan = 0;
		$total_jumlah_tagihan = 0;
		$total_dpp_pembayaran = 0;
		$total_ppn_pembayaran = 0;
		$total_pph_pembayaran = 0;
		$total_jumlah_pembayaran = 0;
		$total_dpp_sisa_hutang = 0;
		$total_ppn_sisa_hutang = 0;
		$total_jumlah_sisa_hutang = 0;
		$date = $this->input->get('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
			$filter_date = date('d F Y',strtotime($arr_date[0])).' - '.date('d F Y',strtotime($arr_date[1]));

			
			$data['filter_date'] = $filter_date;
			$data['date2'] = $end_date;

			$this->db->select('ppp.id, ppp.supplier_id, ps.nama as name');
			$this->db->join('penerima ps','ppp.supplier_id = ps.id','left');
			$this->db->join('pmm_purchase_order ppo','ppp.purchase_order_id = ppo.id','left');
			$this->db->where("ppo.kategori_id in (1,5)");
			
			if(!empty($start_date) && !empty($end_date)){
				$this->db->where('ppp.tanggal_invoice >=',$start_date);
				$this->db->where('ppp.tanggal_invoice <=',$end_date);
			}
			if(!empty($supplier_id)){
				$this->db->where('ppo.supplier_id',$supplier_id);
			}
			if(!empty($filter_kategori)){
				$this->db->where('ppo.kategori_id',$filter_kategori);
			}
			if(!empty($filter_status)){
				$this->db->where('ppp.status',$filter_status);
			}

			$this->db->where("ppp.verifikasi_dok in ('SUDAH','LENGKAP')");
			$this->db->group_by('ppp.supplier_id');
			$this->db->order_by('ps.nama','asc');
			$query = $this->db->get('pmm_penagihan_pembelian ppp');

			$no = 1;
			if($query->num_rows() > 0){

				foreach ($query->result_array() as $key => $sups) {

					$mats = array();
					$materials = $this->pmm_model->GetLaporanMonitoringHutangBahanAlat($sups['supplier_id'],$start_date,$end_date,$filter_kategori,$filter_status);
					if(!empty($materials)){
						foreach ($materials as $key => $row) {
							$awal  = date_create($row['status_umur_hutang']);
							$akhir = date_create($end_date);
							$diff  = date_diff( $awal, $akhir );

							$tanggal_tempo = date('Y-m-d', strtotime(+$row['syarat_pembayaran'].'days', strtotime($row['tanggal_lolos_verifikasi'])));

							$awal_tempo =date_create($tanggal_tempo);
							$akhir_tempo =date_create($end_date);
							$diff_tempo =date_diff($awal_tempo,$akhir_tempo);

							$arr['no'] = $key + 1;
							$arr['nama'] = $row['nama'];
							$arr['subject'] = $row['subject'];
							$arr['kategori_id'] = $row['kategori_id'];
							$arr['status'] = $row['status'];
							$arr['syarat_pembayaran'] = $row['syarat_pembayaran'];
							//$arr['syarat_pembayaran'] = $diff->days . ' Hari';
							//$arr['syarat_pembayaran'] = $diff->days . ' ';
							//$arr['jatuh_tempo'] =  $diff_tempo->format("%R%a");
							$arr['jatuh_tempo'] =  date('d-m-Y',strtotime($tanggal_tempo));
							$arr['nomor_invoice'] = $row['nomor_invoice'];
							$arr['tanggal_invoice'] = date('d-m-Y',strtotime($row['tanggal_invoice']));
							$arr['tanggal_lolos_verifikasi'] = date('d-m-Y',strtotime($row['tanggal_lolos_verifikasi']));
							$arr['dpp_tagihan'] = number_format($row['dpp_tagihan'],0,',','.');
							$arr['ppn_tagihan'] = number_format($row['ppn_tagihan'],0,',','.');
							$arr['jumlah_tagihan'] = number_format($row['jumlah_tagihan'],0,',','.');
							$arr['dpp_pembayaran'] = number_format($row['dpp_pembayaran'],0,',','.');
							$arr['ppn_pembayaran'] = number_format($row['ppn_pembayaran'],0,',','.');
							$arr['pph_pembayaran'] = number_format($row['pph_pembayaran'],0,',','.');
							$arr['jumlah_pembayaran'] = number_format($row['jumlah_pembayaran'],0,',','.');
							$arr['dpp_sisa_hutang'] = number_format($row['dpp_sisa_hutang'],0,',','.');
							$arr['ppn_sisa_hutang'] = number_format($row['ppn_sisa_hutang'],0,',','.');
							$arr['jumlah_sisa_hutang'] = number_format($row['jumlah_sisa_hutang'],0,',','.');

							$total_dpp_tagihan += $row['dpp_tagihan'];
							$total_ppn_tagihan += $row['ppn_tagihan'];
							$total_jumlah_tagihan += $row['jumlah_tagihan'];
							$total_dpp_pembayaran += $row['dpp_pembayaran'];
							$total_ppn_pembayaran += $row['ppn_pembayaran'];
							$total_pph_pembayaran += $row['pph_pembayaran'];
							$total_jumlah_pembayaran += $row['jumlah_pembayaran'];
							$total_dpp_sisa_hutang += $row['dpp_sisa_hutang'];
							$total_ppn_sisa_hutang += $row['ppn_sisa_hutang'];
							$total_jumlah_sisa_hutang += $row['jumlah_sisa_hutang'];
							
							
							$arr['name'] = $sups['name'];
							$mats[] = $arr;
						}
						$sups['mats'] = $mats;
						$sups['no'] =$no;

						$arr_data[] = $sups;
						$no++;
					}
					
					
				}
			}

			
			$data['data'] = $arr_data;
			$data['total_dpp_tagihan'] = $total_dpp_tagihan;
			$data['total_ppn_tagihan'] = $total_ppn_tagihan;
			$data['total_jumlah_tagihan'] = $total_jumlah_tagihan;
			$data['total_dpp_pembayaran'] = $total_dpp_pembayaran;
			$data['total_ppn_pembayaran'] = $total_ppn_pembayaran;
			$data['total_pph_pembayaran'] = $total_pph_pembayaran;
			$data['total_jumlah_pembayaran'] = $total_jumlah_pembayaran;
			$data['total_dpp_sisa_hutang'] = $total_dpp_sisa_hutang;
			$data['total_ppn_sisa_hutang'] = $total_ppn_sisa_hutang;
			$data['total_jumlah_sisa_hutang'] = $total_jumlah_sisa_hutang;
	        $html = $this->load->view('laporan_pembelian/cetak_monitoring_hutang_bahan_alat',$data,TRUE);

	        
	        $pdf->SetTitle('BBJ - Laporan Monitoring Hutang');
	        $pdf->nsi_html($html);
	        $pdf->Output('monitoring-hutang.pdf', 'I');
	        
		}else {
			echo 'Please Filter Date First';
		}
	
	}

	public function cetak_pengiriman_penjualan()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
		$pdf->setPrintFooter(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');

		$arr_data = array();
		$filter_client_id = $this->input->get('filter_client_id');
		$purchase_order_no = $this->input->get('purchase_order_no');
		$filter_product = $this->input->get('filter_product');
		$start_date = false;
		$end_date = false;
		$total = 0;
		$date = $this->input->get('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
			$filter_date = date('d F Y',strtotime($arr_date[0])).' - '.date('d F Y',strtotime($arr_date[1]));

			
			$data['filter_date'] = $filter_date;
			$data['start_date'] = $start_date;
			$data['end_date'] = $end_date;
		
			$this->db->select('ppo.client_id, pp.convert_measure as convert_measure, ps.nama as name, SUM(pp.display_price) / SUM(pp.display_volume) as price, SUM(pp.display_volume) as total, SUM(pp.display_price) as total_price');
		if(!empty($start_date) && !empty($end_date)){
            $this->db->where('pp.date_production >=',$start_date);
            $this->db->where('pp.date_production <=',$end_date);
        }
        if(!empty($filter_client_id)){
            $this->db->where('ppo.client_id',$filter_client_id);
        }
        if(!empty($filter_product)){
            $this->db->where_in('pp.product_id',$filter_product);
        }
        if(!empty($purchase_order_no)){
            $this->db->where('pp.salesPo_id',$purchase_order_no);
        }
		
		$this->db->join('penerima ps','ppo.client_id = ps.id','left');
		$this->db->join('pmm_productions pp','ppo.id = pp.salesPo_id');
		$this->db->where("ppo.status in ('OPEN','CLOSED')");
		$this->db->where('pp.status','PUBLISH');
		$this->db->group_by('ppo.client_id');
		$query = $this->db->get('pmm_sales_po ppo');
		
		$no = 1;
		if($query->num_rows() > 0){

			foreach ($query->result_array() as $key => $sups) {

				$mats = array();
				$materials = $this->pmm_model->GetPengirimanPenjualanPrint($sups['client_id'],$purchase_order_no,$start_date,$end_date,$filter_product);
				if(!empty($materials)){
					foreach ($materials as $key => $row) {
						$arr['no'] = $key + 1;
						$arr['measure'] = $row['measure'];
						$arr['nama_produk'] = $row['nama_produk'];
						$arr['salesPo_id'] = $row['salesPo_id'] = $this->crud_global->GetField('pmm_sales_po',array('id'=>$row['salesPo_id']),'contract_number');
						$arr['real'] = number_format($row['total'],2,',','.');
						$arr['price'] = number_format($row['price'],0,',','.');
						$arr['total_price'] = number_format($row['total_price'],0,',','.');
						
						
						$arr['name'] = $sups['name'];
						$mats[] = $arr;
					}
					$sups['mats'] = $mats;
					$total += $sups['total_price'];
					$sups['no'] =$no;
					$sups['real'] = number_format($sups['total'],2,',','.');
					$sups['price'] = number_format($sups['price'],0,',','.');
					$sups['total_price'] = number_format($sups['total_price'],0,',','.');

					$arr_data[] = $sups;
					$no++;
				}
				
				
			}
		}

			$data['data'] = $arr_data;
			$data['total'] = $total;
	        $html = $this->load->view('laporan_penjualan/cetak_pengiriman_penjualan',$data,TRUE);

	        
	        
	        $pdf->SetTitle('BBJ - Laporan Penjualan');
	        $pdf->nsi_html($html);
	        $pdf->Output('laporan-penjualan.pdf', 'I');
	        
		}else {
			echo 'Please Filter Date First';
		}
	
	}

	public function cetak_laporan_piutang()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
		$pdf->setPrintFooter(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');

		$arr_data = array();
		$client_id = $this->input->get('client_id');
		$start_date = false;
		$end_date = false;
		$total_penerimaan = 0;
		$total_tagihan = 0;
		$total_tagihan_bruto = 0;
		$total_pembayaran = 0;
		$total_sisa_piutang_penerimaan = 0;
		$total_sisa_piutang_tagihan = 0;
		$date = $this->input->get('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
			$filter_date = date('d F Y',strtotime($arr_date[0])).' - '.date('d F Y',strtotime($arr_date[1]));

			
			$data['filter_date'] = $filter_date;
			$data['date2'] = $end_date;

		$this->db->select('po.id, po.client_id, ps.nama as name');
		$this->db->join('pmm_sales_po po','pp.salesPo_id = po.id','left');

		if(!empty($start_date) && !empty($end_date)){
            $this->db->where('pp.date_production >=',$start_date);
            $this->db->where('pp.date_production <=',$end_date);
        }
        if(!empty($client_id)){
            $this->db->where('po.client_id',$client_id);
        }
		
		$this->db->join('penerima ps','po.client_id = ps.id','left');
		$this->db->where("po.status in ('OPEN','CLOSED')");
		$this->db->group_by('po.client_id');
		$this->db->order_by('ps.nama','asc');
		$query = $this->db->get('pmm_productions pp');

			$no = 1;
			if($query->num_rows() > 0){

				foreach ($query->result_array() as $key => $sups) {

					$mats = array();
					$materials = $this->pmm_model->GetLaporanPiutang($sups['client_id'],$start_date,$end_date);
					if(!empty($materials)){
						foreach ($materials as $key => $row) {
							$arr['no'] = $key + 1;
                            $arr['nama_produk'] = $row['nama_produk'];
                            $arr['salesPo_id'] = $this->crud_global->GetField('pmm_sales_po',array('id'=>$row['salesPo_id']),'contract_number');
                            $arr['penerimaan'] = number_format($row['penerimaan'],0,',','.');
                            $arr['tagihan'] = number_format($row['tagihan'],0,',','.');
                            $arr['tagihan_bruto'] = number_format($row['tagihan_bruto'],0,',','.');
                            $arr['pembayaran'] = number_format($row['pembayaran'],0,',','.');
                            $arr['sisa_piutang_penerimaan'] = number_format($row['sisa_piutang_penerimaan'],0,',','.');
                            $arr['sisa_piutang_tagihan'] = number_format($row['sisa_piutang_tagihan'],0,',','.');

                            $total_penerimaan += $row['penerimaan'];
                            $total_tagihan += $row['tagihan'];
                            $total_tagihan_bruto += $row['tagihan_bruto'];
                            $total_pembayaran += $row['pembayaran'];
                            $total_sisa_piutang_penerimaan += $row['sisa_piutang_penerimaan'];
                            $total_sisa_piutang_tagihan += $row['sisa_piutang_tagihan'];
							
							
							$arr['name'] = $sups['name'];
							$mats[] = $arr;
						}
						$sups['mats'] = $mats;
						$sups['no'] =$no;

						$arr_data[] = $sups;
						$no++;
					}
					
					
				}
			}

			
			$data['data'] = $arr_data;
			$data['total_penerimaan'] = $total_penerimaan;
			$data['total_tagihan'] = $total_tagihan;
			$data['total_tagihan_bruto'] = $total_tagihan_bruto;
			$data['total_pembayaran'] = $total_pembayaran;
			$data['total_sisa_piutang_penerimaan'] = $total_sisa_piutang_penerimaan;
			$data['total_sisa_piutang_tagihan'] = $total_sisa_piutang_tagihan;
	        $html = $this->load->view('laporan_penjualan/cetak_laporan_piutang',$data,TRUE);

	        
	        $pdf->SetTitle('BBJ - Laporan Piutang');
	        $pdf->nsi_html($html);
	        $pdf->Output('laporan-piutang.pdf', 'I');
	        
		}else {
			echo 'Please Filter Date First';
		}
	
	}

	public function cetak_monitoring_piutang()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
		$pdf->setPrintFooter(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('L');

		$arr_data = array();
		$client_id = $this->input->get('client_id');
		$filter_kategori = $this->input->get('filter_kategori');
		$filter_status = $this->input->get('filter_status');
		$start_date = false;
		$end_date = false;
		$total_dpp_tagihan = 0;
		$total_ppn_tagihan = 0;
		$total_jumlah_tagihan = 0;
		$total_dpp_pembayaran = 0;
		$total_ppn_pembayaran = 0;
		$total_jumlah_pembayaran = 0;
		$total_dpp_sisa_piutang = 0;
		$total_ppn_sisa_piutang = 0;
		$total_jumlah_sisa_piutang = 0;
		$date = $this->input->get('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
			$filter_date = date('d F Y',strtotime($arr_date[0])).' - '.date('d F Y',strtotime($arr_date[1]));

			
			$data['filter_date'] = $filter_date;
			$data['date2'] = $end_date;

			$this->db->select('ppp.id, ppp.client_id, ps.nama as name');
            $this->db->join('penerima ps','ppp.client_id = ps.id','left');
            $this->db->join('pmm_sales_po po','ppp.sales_po_id = po.id','left');

            if(!empty($start_date) && !empty($end_date)){
                $this->db->where('ppp.tanggal_invoice >=',$start_date);
                $this->db->where('ppp.tanggal_invoice <=',$end_date);
            }
            if(!empty($client_id)){
                $this->db->where('ppp.client_id',$client_id);
            }
			if(!empty($filter_status)){
                $this->db->where('ppp.status_pembayaran',$filter_status);
            }
            
            $this->db->group_by('ppp.client_id');
            $this->db->order_by('ps.nama','asc');
            $query = $this->db->get('pmm_penagihan_penjualan ppp');

			$no = 1;
			if($query->num_rows() > 0){

				foreach ($query->result_array() as $key => $sups) {

					$mats = array();
					$materials = $this->pmm_model->GetLaporanMonitoringPiutang($sups['client_id'],$start_date,$end_date,$filter_kategori,$filter_status);
					if(!empty($materials)){
						foreach ($materials as $key => $row) {
							
							$awal  = date_create($row['status_umur_hutang']);
							$akhir = date_create($end_date);
							$diff  = date_diff($awal, $akhir);

							$arr['no'] = $key + 1;
                            $arr['nama'] = $row['nama'];
                            $arr['subject'] = $row['subject'];
                            $arr['status_pembayaran'] = $row['status_pembayaran'];
                            $arr['syarat_pembayaran'] = $diff->days;
                            $arr['nomor_invoice'] = $row['nomor_invoice'];
                            $arr['tanggal_invoice'] =  date('d-m-Y',strtotime($row['tanggal_invoice']));
                            $arr['dpp_tagihan'] = number_format($row['dpp_tagihan'],0,',','.');
                            $arr['ppn_tagihan'] = number_format($row['ppn_tagihan'],0,',','.');
                            $arr['jumlah_tagihan'] = number_format($row['jumlah_tagihan'],0,',','.');
                            $arr['dpp_pembayaran'] = number_format($row['dpp_pembayaran'],0,',','.');
                            $arr['ppn_pembayaran'] = number_format($row['ppn_pembayaran'],0,',','.');
                            $arr['jumlah_pembayaran'] = number_format($row['jumlah_pembayaran'],0,',','.');
                            $arr['dpp_sisa_piutang'] = number_format($row['dpp_sisa_piutang'],0,',','.');
                            $arr['ppn_sisa_piutang'] = number_format($row['ppn_sisa_piutang'],0,',','.');
                            $arr['jumlah_sisa_piutang'] = number_format($row['jumlah_sisa_piutang'],0,',','.');

							$total_dpp_tagihan += $row['dpp_tagihan'];
							$total_ppn_tagihan += $row['ppn_tagihan'];
							$total_jumlah_tagihan += $row['jumlah_tagihan'];
							$total_dpp_pembayaran += $row['dpp_pembayaran'];
							$total_ppn_pembayaran += $row['ppn_pembayaran'];
							$total_jumlah_pembayaran += $row['jumlah_pembayaran'];
							$total_dpp_sisa_piutang += $row['dpp_sisa_piutang'];
							$total_ppn_sisa_piutang += $row['ppn_sisa_piutang'];
							$total_jumlah_sisa_piutang += $row['jumlah_sisa_piutang'];
							
							
							$arr['name'] = $sups['name'];
							$mats[] = $arr;
						}
						$sups['mats'] = $mats;
						$sups['no'] =$no;

						$arr_data[] = $sups;
						$no++;
					}
					
					
				}
			}

			
			$data['data'] = $arr_data;
			$data['total_dpp_tagihan'] = $total_dpp_tagihan;
			$data['total_ppn_tagihan'] = $total_ppn_tagihan;
			$data['total_jumlah_tagihan'] = $total_jumlah_tagihan;
			$data['total_dpp_pembayaran'] = $total_dpp_pembayaran;
			$data['total_ppn_pembayaran'] = $total_ppn_pembayaran;
			$data['total_jumlah_pembayaran'] = $total_jumlah_pembayaran;
			$data['total_dpp_sisa_piutang'] = $total_dpp_sisa_piutang;
			$data['total_ppn_sisa_piutang'] = $total_ppn_sisa_piutang;
			$data['total_jumlah_sisa_piutang'] = $total_jumlah_sisa_piutang;
	        $html = $this->load->view('laporan_penjualan/cetak_monitoring_piutang',$data,TRUE);

	        
	        $pdf->SetTitle('BBJ - Laporan Monitoring Piutang');
	        $pdf->nsi_html($html);
	        $pdf->Output('monitoring-piutang.pdf', 'I');
	        
		}else {
			echo 'Please Filter Date First';
		}
	
	}

	public function cetak_evaluasi_bahan()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');

		$arr_date = $this->input->get('filter_date');
		if(empty($arr_date)){
			$filter_date = '-';
		}else {
			$arr_filter_date = explode(' - ', $arr_date);
			$start_date = date('Y-m-d',strtotime($arr_filter_date[0]));
    		$end_date = date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('d F Y',strtotime($arr_filter_date[0])).' - '.date('d F Y',strtotime($arr_filter_date[1]));
		}
		$data['filter_date'] = $filter_date;
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
        $html = $this->load->view('laporan_produksi/cetak_laporan_evaluasi',$data,TRUE);

        
        $pdf->SetTitle('BBJ - Laporan Evaluasi Pemakaian Bahan Baku');
        $pdf->nsi_html($html);
        $pdf->Output('laporan_evaluasi_pemakaian_bahan_baku.pdf', 'I');
	
	}

	public function cetak_laporan_evaluasi_alat()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');

		$arr_date = $this->input->get('filter_date');
		if(empty($arr_date)){
			$filter_date = '-';
		}else {
			$arr_filter_date = explode(' - ', $arr_date);
			$start_date = date('Y-m-d',strtotime($arr_filter_date[0]));
    		$end_date = date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('d F Y',strtotime($arr_filter_date[0])).' - '.date('d F Y',strtotime($arr_filter_date[1]));
		}
		$data['filter_date'] = $filter_date;
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
        $html = $this->load->view('laporan_produksi/cetak_laporan_evaluasi_alat',$data,TRUE);

        
        $pdf->SetTitle('BBJ - Laporan Evaluasi Pemakaian Bahan Baku');
        $pdf->nsi_html($html);
        $pdf->Output('laporan_evaluasi_pemakaian_bahan_baku.pdf', 'I');
	
	}

	public function cetak_laporan_evaluasi_bua()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');

		$arr_date = $this->input->get('filter_date');
		if(empty($arr_date)){
			$filter_date = '-';
		}else {
			$arr_filter_date = explode(' - ', $arr_date);
			$start_date = date('Y-m-d',strtotime($arr_filter_date[0]));
    		$end_date = date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('d F Y',strtotime($arr_filter_date[0])).' - '.date('d F Y',strtotime($arr_filter_date[1]));
		}
		$data['filter_date'] = $filter_date;
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
        $html = $this->load->view('laporan_produksi/cetak_laporan_evaluasi_bua',$data,TRUE);

        
        $pdf->SetTitle('BBJ - Laporan Evaluasi BUA');
        $pdf->nsi_html($html);
        $pdf->Output('laporan_evaluasi_bua.pdf', 'I');
	
	}

	public function cetak_evaluasi_target_produksi()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');

		$arr_date = $this->input->get('filter_date');
		if(empty($arr_date)){
			$filter_date = '-';
		}else {
			$arr_filter_date = explode(' - ', $arr_date);
			$start_date = date('Y-m-d',strtotime($arr_filter_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('d F Y',strtotime($arr_filter_date[0])).' - '.date('d F Y',strtotime($arr_filter_date[1]));
		}
		$data['filter_date'] = $filter_date;
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
        $html = $this->load->view('laporan_produksi/cetak_evaluasi_target_produksi',$data,TRUE);

        
        $pdf->SetTitle('BBJ - Evaluasi Target Produksi');
        $pdf->nsi_html($html);
        $pdf->Output('evaluasi-target-produksi.pdf', 'I');
	
	}

	public function cetak_biaya_bahan()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true); 
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		        $pdf->AddPage('P');

		$arr_date = $this->input->get('filter_date');
		if(empty($arr_date)){
			$filter_date = '-';
		}else {
			$arr_filter_date = explode(' - ', $arr_date);
			$start_date = date('Y-m-d',strtotime($arr_filter_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('d F Y',strtotime($arr_filter_date[0])).' - '.date('d F Y',strtotime($arr_filter_date[1]));
		}
		$data['filter_date'] = $filter_date;
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
        $html = $this->load->view('biaya_bahan/cetak_biaya_bahan',$data,TRUE);

        
        $pdf->SetTitle('BBJ - Biaya (Bahan)');
        $pdf->nsi_html($html);
        $pdf->Output('biaya-bahan.pdf', 'I');
	
	}

	public function cetak_pergerakan_bahan_baku()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true); 
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		        $pdf->AddPage('P');

		$arr_date = $this->input->get('filter_date');
		if(empty($arr_date)){
			$filter_date = '-';
		}else {
			$arr_filter_date = explode(' - ', $arr_date);
			$start_date = date('Y-m-d',strtotime($arr_filter_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('d F Y',strtotime($arr_filter_date[0])).' - '.date('d F Y',strtotime($arr_filter_date[1]));
		}
		$data['filter_date'] = $filter_date;
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
        $html = $this->load->view('biaya_bahan/cetak_pergerakan_bahan_baku',$data,TRUE);

        
        $pdf->SetTitle('BBJ - Pergerakan Bahan Baku');
        $pdf->nsi_html($html);
        $pdf->Output('pergerakan-bahan-baku.pdf', 'I');
	
	}

	public function cetak_biaya_alat()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true); 
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		        $pdf->AddPage('P');

		$arr_date = $this->input->get('filter_date');
		if(empty($arr_date)){
			$filter_date = '-';
		}else {
			$arr_filter_date = explode(' - ', $arr_date);
			$start_date = date('Y-m-d',strtotime($arr_filter_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('d F Y',strtotime($arr_filter_date[0])).' - '.date('d F Y',strtotime($arr_filter_date[1]));
		}
		$data['filter_date'] = $filter_date;
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
        $html = $this->load->view('biaya_alat/cetak_biaya_alat',$data,TRUE);

        
		$pdf->SetTitle('BBJ - Biaya (Alat)');
        $pdf->nsi_html($html);
        $pdf->Output('biaya-alat.pdf', 'I');
	
	}

	public function cetak_pergerakan_bahan_baku_solar()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		        $pdf->AddPage('P');

		$arr_date = $this->input->get('filter_date');
		if(empty($arr_date)){
			$filter_date = '-';
		}else {
			$arr_filter_date = explode(' - ', $arr_date);
			$start_date = date('Y-m-d',strtotime($arr_filter_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('d F Y',strtotime($arr_filter_date[0])).' - '.date('d F Y',strtotime($arr_filter_date[1]));
		}
		$data['filter_date'] = $filter_date;
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
        $html = $this->load->view('biaya_alat/cetak_pergerakan_bahan_baku_solar',$data,TRUE);

        
        $pdf->SetTitle('BBJ - Pergerakan Bahan Baku');
        $pdf->nsi_html($html);
        $pdf->Output('pergerakan-bahan-baku.pdf', 'I');
	
	}

    public function laporan_biaya()
    {
        $data['asd'] = false;
        $this->load->view('laporan_biaya/laporan_biaya',$data);
    }

    public function ajax_laporan_biaya()
    {

        $filter_date = $this->input->post('filter_date');

        $data['filter_date'] = $filter_date;
		$data['biaya_langsung'] = $this->m_laporan->biaya_langsung($filter_date);
		$data['biaya_langsung_jurnal'] = $this->m_laporan->biaya_langsung_jurnal($filter_date);
        $data['biaya'] = $this->m_laporan->showBiaya($filter_date);
		$data['biaya_jurnal'] = $this->m_laporan->showBiayaJurnal($filter_date);
        $data['biaya_lainnya'] = $this->m_laporan->showBiayaLainnya($filter_date);
		$data['biaya_lainnya_jurnal'] = $this->m_laporan->showBiayaLainnyaJurnal($filter_date);
		$data['biaya_persiapan'] = $this->m_laporan->showPersiapanBiaya($filter_date);
		$data['biaya_persiapan_jurnal'] = $this->m_laporan->showPersiapanJurnal($filter_date);

        $this->load->view('laporan_biaya/ajax/ajax_biaya',$data);
    }

	public function print_biaya()
    {
        $this->load->library('pdf');
    

        $pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
		$pdf->setPrintFooter(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
        $pdf->setHtmlVSpace($tagvs);
        $pdf->AddPage('P');

        $arr_date = $this->input->get('filter_date');

        $dt = explode(' - ', $arr_date);
        $start_date = date('Y-m-d',strtotime($dt[0]));
        $end_date = date('Y-m-d',strtotime($dt[1]));

        $date = array($start_date,$end_date);
        $data['filter_date'] = $arr_date;
		$data['biaya_langsung_parent'] = $this->m_laporan->biaya_langsung_print_parent($arr_date);
		$data['biaya_langsung'] = $this->m_laporan->biaya_langsung_print($arr_date);
		$data['biaya_langsung_jurnal_parent'] = $this->m_laporan->biaya_langsung_jurnal_print_parent($arr_date);
		$data['biaya_langsung_jurnal'] = $this->m_laporan->biaya_langsung_jurnal_print($arr_date);
		$data['biaya_parent'] = $this->m_laporan->showBiaya_print_parent($arr_date);
        $data['biaya'] = $this->m_laporan->showBiaya_print($arr_date);
		$data['biaya_jurnal_parent'] = $this->m_laporan->showBiayaJurnal_print_parent($arr_date);
		$data['biaya_jurnal'] = $this->m_laporan->showBiayaJurnal_print($arr_date);
		$data['biaya_lainnya_parent'] = $this->m_laporan->showBiayaLainnya_print_parent($arr_date);
        $data['biaya_lainnya'] = $this->m_laporan->showBiayaLainnya_print($arr_date);
		$data['biaya_lainnya_jurnal_parent'] = $this->m_laporan->showBiayaLainnyaJurnal_print_parent($arr_date);
		$data['biaya_lainnya_jurnal'] = $this->m_laporan->showBiayaLainnyaJurnal_print($arr_date);
		$data['biaya_persiapan_parent'] = $this->m_laporan->showPersiapanBiaya_print_parent($arr_date);
		$data['biaya_persiapan'] = $this->m_laporan->showPersiapanBiaya_print($arr_date);
		$data['biaya_persiapan_jurnal_parent'] = $this->m_laporan->showPersiapanJurnal_print_parent($arr_date);
		$data['biaya_persiapan_jurnal'] = $this->m_laporan->showPersiapanJurnal($arr_date);

        $html = $this->load->view('laporan_biaya/print_biaya',$data,TRUE);

        
        $pdf->SetTitle('BBJ - Laporan Biaya');
        $pdf->nsi_html($html);
        $pdf->Output('laporan-biaya.pdf', 'I');
    
    }

	public function cetak_prognosa_produksi()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('L');

		$arr_date = $this->input->get('filter_date');
		if(empty($arr_date)){
			$filter_date = '-';
		}else {
			$arr_filter_date = explode(' - ', $arr_date);
			$filter_date = date('d F Y',strtotime($arr_filter_date[0])).' - '.date('d F Y',strtotime($arr_filter_date[1]));
		}
		$data['filter_date'] = $filter_date;
        $html = $this->load->view('laporan_rencana_kerja/cetak_prognosa_produksi',$data,TRUE);

        
        $pdf->SetTitle('BBJ - Prognosa Produksi');
        $pdf->nsi_html($html);
        $pdf->Output('prognosa_produksi.pdf', 'I');
	
	}

	public function cetak_bahan_rap_2022()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true); 
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		        $pdf->AddPage('P');

		$arr_date = $this->input->get('filter_date');
		if(empty($arr_date)){
			$filter_date = '-';
		}else {
			$arr_filter_date = explode(' - ', $arr_date);
			$filter_date = date('d F Y',strtotime($arr_filter_date[0])).' - '.date('d F Y',strtotime($arr_filter_date[1]));
		}
		$data['filter_date'] = $filter_date;
        $html = $this->load->view('laporan_rencana_kerja/cetak_bahan_rap_2022',$data,TRUE);

        
        $pdf->SetTitle('BBJ - Kebutuhan Bahan RAP 2022');
        $pdf->nsi_html($html);
        $pdf->Output('kebutuhan_bahan_rap_2022.pdf', 'I');
	}

	public function cetak_kebutuhan_bahan_alat($rencana_kerja_1)
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
		$pdf->setPrintFooter(true);
        $pdf->SetFont('helvetica','',7); 
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');

		$data['rak'] = $this->db->get_where('rak',array('id'=>$rencana_kerja_1))->row_array();
        $html = $this->load->view('laporan_rencana_kerja/cetak_kebutuhan_bahan_alat',$data,TRUE);
        $rak = $this->db->get_where('rak',array('id'=>$rencana_kerja_1))->row_array();

        $pdf->SetTitle('BBJ - Kebutuhan Bahan & Alat');
        $pdf->nsi_html($html);
        $pdf->Output('kebutuhan_bahan_alat.pdf', 'I');
	}

	public function cetak_rencana_kerja()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true); 
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		        $pdf->AddPage('L');

		$arr_date = $this->input->get('filter_date');
		if(empty($arr_date)){
			$filter_date = '-';
		}else {
			$arr_filter_date = explode(' - ', $arr_date);
			$filter_date = date('Y-m-d',strtotime($arr_filter_date[0])).' - '.date('Y-m-d',strtotime($arr_filter_date[1]));
		}
		$data['filter_date'] = $filter_date;
        $html = $this->load->view('laporan_rencana_kerja/cetak_rencana_kerja',$data,TRUE);

        
        $pdf->SetTitle('BBJ - Rencana Kerja Produksi');
        $pdf->nsi_html($html);
        $pdf->Output('rencana_kerja_produksi.pdf', 'I');
	}

	public function pesanan_pembelian($rencana_kerja_1,$date_1_awal,$date_1_akhir,$kebutuhan,$material_id)
    {
        $check = $this->m_admin->check_login();
        if ($check == true) {
			$data['row'] = $this->db->get_where('pmm_penawaran_pembelian pp', array('pp.id' => $rencana_kerja_1))->row_array();
			$data['details'] = $this->db->get_where('pmm_penawaran_pembelian_detail ppd', array('ppd.penawaran_pembelian_id' => $rencana_kerja_1))->row_array();
			$data['no_po'] = $this->pmm_model->GetNoPONew();
			$data['request_no'] = $this->pmm_model->GetNoRMNew();
			$data['produk'] = $this->pmm_model->getMatByPenawaranRencanaKerjaAll();

			$data['stock_opname'] = $this->db->select('(cat.display_volume) as display_volume')
			->from('pmm_remaining_materials_cat cat ')
			->where("(cat.date < '$date_1_awal')")
			->where("cat.material_id = $material_id")
			->where("cat.status = 'PUBLISH'")
			->order_by('cat.date','desc')->limit(1)
			->get()->row_array();

			$total_po = $this->db->select('sum(pod.volume) as volume')
			->from('pmm_purchase_order ppo')
			->join('pmm_purchase_order_detail pod','ppo.id = pod.purchase_order_id','left')
			->where("(ppo.date_po between '$date_1_awal' and '$date_1_akhir')")
			->where("pod.material_id = $material_id")
			->get()->row_array();
			
			$data['purchase_order'] = $total_po['volume'];
			$data['kebutuhan'] = $kebutuhan;

			$total_penerimaan = $this->db->select('sum(prm.volume) as volume')
			->from('pmm_receipt_material prm')
			->where("(prm.date_receipt between '$date_1_awal' and '$date_1_akhir')")
			->where("prm.material_id = $material_id")
			->get()->row_array();

			$data['total_receipt'] = $total_penerimaan['volume'];

			$this->load->view('laporan_rencana_kerja/pesanan_pembelian', $data);
        } else {
            redirect('admin');
        }
    }

	public function cetak_daftar_tagihan_pembelian()
	{
		
		$this->load->library('pdf');
	
		$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
		$pdf->setPrintFooter(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('L');
		$pdf->setPrintHeader(false);

		//Page2
		$pdf->AddPage('L', 'A4');
		$pdf->SetY(30);
		$pdf->SetX(6);
		$html =
		'<style type="text/css">
		body {
			font-family: helvetica;
		}

		table.table-border-atas-kiri, th.table-border-atas-kiri, td.table-border-atas-kiri {
			border-top: 1px solid black;
			border-bottom: 1px solid black;
		}

		table.table-border-atas-tengah, th.table-border-atas-tengah, td.table-border-atas-tengah {
			border-top: 1px solid black;
			border-bottom: 1px solid black;
		}

		table.table-border-atas-kanan, th.table-border-atas-kanan, td.table-border-atas-kanan {
			border-top: 1px solid black;
			border-bottom: 1px solid black;
		}

		table.table-border-pojok-kiri, th.table-border-pojok-kiri, td.table-border-pojok-kiri {
			border-top: 1px solid black;
		}

		table.table-border-pojok-tengah, th.table-border-pojok-tengah, td.table-border-pojok-tengah {
			border-top: 1px solid black;
		}

		table.table-border-pojok-kanan, th.table-border-pojok-kanan, td.table-border-pojok-kanan {
			border-top: 1px solid black;
		}

		table tr.table-judul{
			border: 1px solid;
			background-color: #e69500;
			font-weight: bold;
			font-size: 8px;
			color: black;
		}
			
		table tr.table-baris1{
			background-color: none;
			font-size: 8px;
		}

		table tr.table-baris1-bold{
			background-color: none;
			font-size: 8px;
			font-weight: bold;
		}
			
		table tr.table-total{
			background-color: #FFFF00;
			font-weight: bold;
			font-size: 8px;
			color: black;
		}

		table tr.table-total2{
			background-color: #eeeeee;
			font-weight: bold;
			font-size: 8px;
			color: black;
		}
	 	 </style>
		<table width="98%" border="0" cellpadding="2">
			<tr class="table-total">
				<th align="center" width="5%" class="table-border-atas-kiri">NO.</th>
				<th align="center" width="25%" class="table-border-atas-tengah">REKANAN / NOMOR INVOICE</th>
				<th align="center" width="14%" class="table-border-atas-tengah">TGL. INVOICE</th>
				<th align="center" width="6%" class="table-border-atas-tengah">VOLUME</th>
				<th align="center" width="10%" class="table-border-atas-tengah">SATUAN</th>
				<th align="center" width="10%" class="table-border-atas-tengah">HARGA SATUAN</th>
				<th align="center" width="10%" class="table-border-atas-tengah">DPP</th>
				<th align="center" width="10%" class="table-border-atas-tengah">PPN</th>
				<th align="center" width="10%" class="table-border-atas-kanan">TOTAL</th>
			</tr>
		</table>';
		$pdf->writeHTML($html, true, false, true, false, '');

		//Page3
		$pdf->AddPage();
		$pdf->SetY(30);
		$pdf->SetX(6);
		$pdf->WriteHTML($html);

		//Page1
		$pdf->setPage(1, true);
		$pdf->SetY(35);
		$pdf->Cell(0, 0, '', 0, 0, 'C');
		
		$arr_data = array();
		$supplier_id = $this->input->get('supplier_id');
		$start_date = false;
		$end_date = false;
		$total = 0;
		$jumlah_all = 0;
		$date = $this->input->get('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
			$filter_date = date('d F Y',strtotime($arr_date[0])).' - '.date('d F Y',strtotime($arr_date[1]));

			
			$data['filter_date'] = $filter_date;

		$this->db->select('ppp.supplier_id, ps.nama');
		if(!empty($start_date) && !empty($end_date)){
            $this->db->where('ppp.created_on >=',$start_date.' 23:59:59');
            $this->db->where('ppp.created_on <=',$end_date.' 23:59:59');
        }
        if(!empty($supplier_id)){
            $this->db->where('ppp.supplier_id',$supplier_id);
        }
		
		$this->db->join('penerima ps', 'ppp.supplier_id = ps.id');
		$this->db->group_by('ppp.supplier_id');
		$this->db->order_by('ps.nama','asc');
		$query = $this->db->get('pmm_penagihan_pembelian ppp');
		

			$no = 1;
			if($query->num_rows() > 0){

				foreach ($query->result_array() as $key => $sups) {

				$mats = array();
				$materials = $this->pmm_model->GetReceiptTagihanPembelian($sups['supplier_id'],$start_date,$end_date);
				
				if(!empty($materials)){
					foreach ($materials as $key => $row) {
						$arr['no'] = $key + 1;
						$arr['tanggal_invoice'] = date('d-m-Y',strtotime($row['tanggal_invoice']));
						$arr['nomor_invoice'] = $row['nomor_invoice'];
						$arr['memo'] = $row['memo'];
						$arr['volume'] =  number_format($row['volume'],2,',','.');
						$arr['measure'] = $row['measure'];
						$arr['harsat'] = number_format($row['harsat'],0,',','.');
						$arr['dpp'] = number_format($row['dpp'],0,',','.');
						$arr['tax_ppn'] = number_format($row['tax_ppn'],0,',','.');
						//$arr['tax_pph'] = number_format($row['tax_pph'],0,',','.');
						$arr['total'] = number_format(($row['volume'] * $row['harsat']) + $row['tax_ppn'],0,',','.');
						
						
						$arr['nama'] = $sups['nama'];

						$total_dpp += $row['dpp'];
						$total_ppn += $row['tax_ppn'];
						//$total_pph += $row['tax_pph'];
						$total_total += ($row['dpp'] + $row['tax_ppn']);

						$mats[] = $arr;
					}
					$sups['mats'] = $mats;
					$sups['no'] =$no;
					$total = $total_dpp;
					$total_2 = $total_ppn;
					//$total_3 = $total_pph;
					$total_4 = $total_total;

					$arr_data[] = $sups;
					$no++;
					}
					
					
				}
			}

			
			$data['data'] = $arr_data;
			$data['total'] = $total;
			$data['total_2'] = $total_2;
			$data['total_3'] = $total_3;
			$data['total_4'] = $total_4;
	        $html = $this->load->view('pembelian/cetak_daftar_tagihan_pembelian',$data,TRUE);

	        
	        $pdf->SetTitle('BBJ - Daftar Tagihan Pembelian');
	        $pdf->nsi_html($html);
	        $pdf->Output('daftar-tagihan-pembelian.pdf', 'I');
	        
		}else {
			echo 'Please Filter Date First';
		}
	
	}

	public function cetak_daftar_tagihan_penjualan()
	{
		$this->load->library('pdf');
	
		$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
		$pdf->setPrintFooter(true);
		//$pdf->SetMargins(10, 10, 5);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);

		$pdf->AddPage('L');
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		//$pdf->SetY(45);
		//$pdf->SetX(6);
		//$pdf->SetMargins(10, 10);
		
		$arr_data = array();
		$supplier_id = $this->input->get('supplier_id');
		$start_date = false;
		$end_date = false;
		$total = 0;
		$jumlah_all = 0;
		$date = $this->input->get('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
			$filter_date = date('d F Y',strtotime($arr_date[0])).' - '.date('d F Y',strtotime($arr_date[1]));

			
			$data['filter_date'] = $filter_date;

		$this->db->select('ppp.client_id, ps.nama');
		if(!empty($start_date) && !empty($end_date)){
            $this->db->where('ppp.created_on >=',$start_date);
            $this->db->where('ppp.created_on <=',$end_date);
        }
        if(!empty($supplier_id)){
            $this->db->where('ppp.client_id',$supplier_id);
        }
		
		$this->db->join('penerima ps', 'ppp.client_id = ps.id');
		$this->db->group_by('ppp.client_id');
		$this->db->order_by('ps.nama','asc');
		$query = $this->db->get('pmm_penagihan_penjualan ppp');
		

			$no = 1;
			if($query->num_rows() > 0){

				foreach ($query->result_array() as $key => $sups) {

				$mats = array();
				$materials = $this->pmm_model->GetReceiptTagihanPenjualan($sups['client_id'],$start_date,$end_date);
				
				if(!empty($materials)){
					foreach ($materials as $key => $row) {
						$arr['no'] = $key + 1;
						$arr['tanggal_invoice'] = date('d-m-Y',strtotime($row['tanggal_invoice']));
						$arr['nomor_invoice'] = $row['nomor_invoice'];
						$arr['memo'] = $row['memo'];
						$arr['volume'] =  number_format($row['volume'],2,',','.');
						$arr['measure'] = $row['measure'];
						$arr['harsat'] = number_format($row['harsat'],0,',','.');
						$arr['dpp'] = number_format($row['dpp'],0,',','.');
						$arr['tax'] = number_format($row['tax'],0,',','.');
						$arr['total'] = number_format(($row['volume'] * $row['harsat']) + $row['tax'],0,',','.');
						
						
						$arr['nama'] = $sups['nama'];

						$total_dpp += $row['dpp'];
						$total_ppn += $row['tax'];
						$total_total += $row['dpp'] + $row['tax'];

						$mats[] = $arr;
					}
					$sups['mats'] = $mats;
					$sups['no'] =$no;
					$total = $total_dpp;
					$total_2 = $total_ppn;
					$total_3 = $total_total;

					$arr_data[] = $sups;
					$no++;
					}
					
					
				}
			}

			
			$data['data'] = $arr_data;
			$data['total'] = $total;
			$data['total_2'] = $total_2;
			$data['total_3'] = $total_3;
	        $html = $this->load->view('penjualan/cetak_daftar_tagihan_penjualan',$data,TRUE);

	        
	        $pdf->SetTitle('BBJ - Daftar Tagihan Penjualan');
	        $pdf->nsi_html($html);
	        $pdf->Output('daftar-tagihan-penjualan.pdf', 'I');
	        
		}else {
			echo 'Please Filter Date First';
		}
	
	}

	//RUMUS BARU

	public function cetak_penerimaan_pembelian_int()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');

		$arr_date = $this->input->get('filter_date');
		if(empty($arr_date)){
			$filter_date = '-';
		}else {
			$arr_filter_date = explode(' - ', $arr_date);
			$start_date = date('Y-m-d',strtotime($arr_filter_date[0]));
    		$end_date = date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('d F Y',strtotime($arr_filter_date[0])).' - '.date('d F Y',strtotime($arr_filter_date[1]));
		}
		$data['filter_date'] = $filter_date;
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
        $html = $this->load->view('laporan_pembelian/cetak_penerimaan_pembelian_int',$data,TRUE);

        
        $pdf->SetTitle('BBJ - Laporan Penerimaan');
        $pdf->nsi_html($html);
        $pdf->Output('laporan_penerimaan.pdf', 'I');
	
	}

	public function cetak_laporan_hutang_int()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('L');

		$arr_date = $this->input->get('filter_date');
		if(empty($arr_date)){
			$filter_date = '-';
		}else {
			$arr_filter_date = explode(' - ', $arr_date);
			$start_date = date('Y-m-d',strtotime($arr_filter_date[0]));
    		$end_date = date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('d F Y',strtotime($arr_filter_date[0])).' - '.date('d F Y',strtotime($arr_filter_date[1]));
		}
		$data['filter_date'] = $filter_date;
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
        $html = $this->load->view('laporan_pembelian/cetak_laporan_hutang_int',$data,TRUE);

        
        $pdf->SetTitle('BBJ - Laporan Hutang');
        $pdf->nsi_html($html);
        $pdf->Output('laporan_hutang.pdf', 'I');
	
	}

	public function cetak_laporan_monitoring_hutang_int()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('L');

		$arr_date = $this->input->get('filter_date');
		if(empty($arr_date)){
			$filter_date = '-';
		}else {
			$arr_filter_date = explode(' - ', $arr_date);
			$start_date = date('Y-m-d',strtotime($arr_filter_date[0]));
    		$end_date = date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('d F Y',strtotime($arr_filter_date[0])).' - '.date('d F Y',strtotime($arr_filter_date[1]));
		}
		$data['filter_date'] = $filter_date;
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
        $html = $this->load->view('laporan_pembelian/cetak_laporan_monitoring_hutang_int',$data,TRUE);

        
        $pdf->SetTitle('BBJ - Laporan Monitoring Hutang');
        $pdf->nsi_html($html);
        $pdf->Output('laporan_monitoring_hutang.pdf', 'I');
	
	}

	public function cetak_daftar_pembayaran_int()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');

		$arr_date = $this->input->get('filter_date');
		if(empty($arr_date)){
			$filter_date = '-';
		}else {
			$arr_filter_date = explode(' - ', $arr_date);
			$start_date = date('Y-m-d',strtotime($arr_filter_date[0]));
    		$end_date = date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('d F Y',strtotime($arr_filter_date[0])).' - '.date('d F Y',strtotime($arr_filter_date[1]));
		}
		$data['filter_date'] = $filter_date;
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
        $html = $this->load->view('laporan_pembelian/cetak_daftar_pembayaran_int',$data,TRUE);

        
        $pdf->SetTitle('BBJ - Daftar Pembayaran');
        $pdf->nsi_html($html);
        $pdf->Output('daftar_pembayaran.pdf', 'I');
	
	}

	public function cetak_penerimaan_pembelian_temef()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
		$pdf->setPrintFooter(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');

		$arr_data = array();
		$supplier_id = $this->input->get('supplier_id');
		$purchase_order_no = $this->input->get('purchase_order_no');
		$filter_material = $this->input->get('filter_material');
		$filter_kategori = $this->input->get('filter_kategori');
		$start_date = false;
		$end_date = false;
		$total = 0;
		$date = $this->input->get('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
			$filter_date = date('d F Y',strtotime($arr_date[0])).' - '.date('d F Y',strtotime($arr_date[1]));

			
			$data['filter_date'] = $filter_date;
			$data['start_date'] = $start_date;
			$data['end_date'] = $end_date;

			$this->db2->select('ppo.supplier_id,prm.display_measure as measure,ps.nama as name, prm.display_harga_satuan as price,SUM(prm.display_volume) as volume, SUM(prm.display_price) as total_price');
			
			if(!empty($start_date) && !empty($end_date)){
				$this->db2->where('prm.date_receipt >=',$start_date);
				$this->db2->where('prm.date_receipt <=',$end_date);
			}
			if(!empty($supplier_id)){
				$this->db2->where('ppo.supplier_id',$supplier_id);
			}
			if(!empty($filter_material)){
				$this->db2->where_in('prm.material_id',$filter_material);
			}
			if(!empty($purchase_order_no)){
				$this->db2->where('prm.purchase_order_id',$purchase_order_no);
			}
			if(!empty($filter_kategori)){
				$this->db2->where('ppo.kategori_id',$filter_kategori);
			}

			$this->db2->join('penerima ps','ppo.supplier_id = ps.id','left');
			$this->db2->join('pmm_receipt_material prm','ppo.id = prm.purchase_order_id');
			$this->db2->where("ppo.status in ('PUBLISH','CLOSED')");
			$this->db2->group_by('ppo.supplier_id');
			$this->db2->order_by('ps.nama','asc');
			$query = $this->db2->get('pmm_purchase_order ppo');

			$no = 1;
			if($query->num_rows() > 0){

				foreach ($query->result_array() as $key => $sups) {

					$mats = array();
					$materials = $this->pmm_model->GetPenerimaanPembelianTEMEFPrint($sups['supplier_id'],$purchase_order_no,$start_date,$end_date,$filter_material,$filter_kategori);
					if(!empty($materials)){
						foreach ($materials as $key => $row) {
							$arr['no'] = $key + 1;
							$arr['measure'] = $row['measure'];
							$arr['nama_produk'] = $row['nama_produk'];
							$arr['volume'] = number_format($row['volume'],2,',','.');
							$arr['price'] = number_format($row['price'],0,',','.');
							$arr['total_price'] = number_format($row['total_price'],0,',','.');
							
							
							$arr['name'] = $sups['name'];
							$mats[] = $arr;
						}
						$sups['mats'] = $mats;
						$total += $sups['total_price'];
						$sups['no'] =$no;
						$sups['volume'] = number_format($sups['volume'],2,',','.');
						$sups['total_price'] = number_format($sups['total_price'],0,',','.');

						$arr_data[] = $sups;
						$no++;
					}
					
					
				}
			}

			
			$data['data'] = $arr_data;
			$data['total'] = $total;
	        $html = $this->load->view('laporan_pembelian_temef/cetak_penerimaan_pembelian',$data,TRUE);

	        
	        $pdf->SetTitle('BBJ - Laporan Pembelian');
	        $pdf->nsi_html($html);
	        $pdf->Output('laporan-pembelian.pdf', 'I');
	        
		}else {
			echo 'Please Filter Date First';
		}
	}

	public function cetak_penerimaan_pembelian_sc()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
		$pdf->setPrintFooter(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');

		$arr_data = array();
		$supplier_id = $this->input->get('supplier_id');
		$purchase_order_no = $this->input->get('purchase_order_no');
		$filter_material = $this->input->get('filter_material');
		$filter_kategori = $this->input->get('filter_kategori');
		$start_date = false;
		$end_date = false;
		$total = 0;
		$date = $this->input->get('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
			$filter_date = date('d F Y',strtotime($arr_date[0])).' - '.date('d F Y',strtotime($arr_date[1]));

			
			$data['filter_date'] = $filter_date;
			$data['start_date'] = $start_date;
			$data['end_date'] = $end_date;

			$this->db3->select('ppo.supplier_id,prm.display_measure as measure,ps.nama as name, prm.display_harga_satuan as price,SUM(prm.display_volume) as volume, SUM(prm.display_price) as total_price');
			
			if(!empty($start_date) && !empty($end_date)){
				$this->db3->where('prm.date_receipt >=',$start_date);
				$this->db3->where('prm.date_receipt <=',$end_date);
			}
			if(!empty($supplier_id)){
				$this->db3->where('ppo.supplier_id',$supplier_id);
			}
			if(!empty($filter_material)){
				$this->db3->where_in('prm.material_id',$filter_material);
			}
			if(!empty($purchase_order_no)){
				$this->db3->where('prm.purchase_order_id',$purchase_order_no);
			}
			if(!empty($filter_kategori)){
				$this->db3->where('ppo.kategori_id',$filter_kategori);
			}

			$this->db3->join('penerima ps','ppo.supplier_id = ps.id','left');
			$this->db3->join('pmm_receipt_material prm','ppo.id = prm.purchase_order_id');
			$this->db3->where("ppo.status in ('PUBLISH','CLOSED')");
			$this->db3->group_by('ppo.supplier_id');
			$this->db3->order_by('ps.nama','asc');
			$query = $this->db3->get('pmm_purchase_order ppo');

			$no = 1;
			if($query->num_rows() > 0){

				foreach ($query->result_array() as $key => $sups) {

					$mats = array();
					$materials = $this->pmm_model->GetPenerimaanPembelianSCPrint($sups['supplier_id'],$purchase_order_no,$start_date,$end_date,$filter_material,$filter_kategori);
					if(!empty($materials)){
						foreach ($materials as $key => $row) {
							$arr['no'] = $key + 1;
							$arr['measure'] = $row['measure'];
							$arr['nama_produk'] = $row['nama_produk'];
							$arr['volume'] = number_format($row['volume'],2,',','.');
							$arr['price'] = number_format($row['price'],0,',','.');
							$arr['total_price'] = number_format($row['total_price'],0,',','.');
							
							
							$arr['name'] = $sups['name'];
							$mats[] = $arr;
						}
						$sups['mats'] = $mats;
						$total += $sups['total_price'];
						$sups['no'] =$no;
						$sups['volume'] = number_format($sups['volume'],2,',','.');
						$sups['total_price'] = number_format($sups['total_price'],0,',','.');

						$arr_data[] = $sups;
						$no++;
					}
					
					
				}
			}

			
			$data['data'] = $arr_data;
			$data['total'] = $total;
	        $html = $this->load->view('laporan_pembelian_sc/cetak_penerimaan_pembelian',$data,TRUE);

	        
	        $pdf->SetTitle('BBJ - Laporan Pembelian');
	        $pdf->nsi_html($html);
	        $pdf->Output('laporan-pembelian.pdf', 'I');
	        
		}else {
			echo 'Please Filter Date First';
		}
	}

	public function cetak_laporan_hutang_temef()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
		$pdf->setPrintFooter(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');

		$arr_data = array();
		$supplier_id = $this->input->get('supplier_id');
		$filter_kategori = $this->input->get('filter_kategori');
		$start_date = false;
		$end_date = false;
		$total_penerimaan = 0;
		$total_tagihan = 0;
		$total_tagihan_bruto = 0;
		$total_pembayaran = 0;
		$total_sisa_hutang_penerimaan = 0;
		$total_sisa_hutang_tagihan = 0;
		$date = $this->input->get('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
			$filter_date = date('d F Y',strtotime($arr_date[0])).' - '.date('d F Y',strtotime($arr_date[1]));

			
			$data['filter_date'] = $filter_date;
			$data['date2'] = $end_date;

			$this->db2->select('ppo.id, ppo.supplier_id, ps.nama as name');
			$this->db2->join('pmm_purchase_order ppo','prm.purchase_order_id = ppo.id','left');
			
			if(!empty($start_date) && !empty($end_date)){
				$this->db2->where('prm.date_receipt >=',$start_date);
				$this->db2->where('prm.date_receipt <=',$end_date);
			}
			if(!empty($supplier_id)){
				$this->db2->where('ppo.supplier_id',$supplier_id);
			}
			if(!empty($filter_kategori)){
				$this->db2->where('ppo.kategori_id',$filter_kategori);
			}

		$this->db2->join('penerima ps','ppo.supplier_id = ps.id','left');
		$this->db2->where("ppo.status in ('PUBLISH','CLOSED')");
		$this->db2->group_by('ppo.supplier_id');
		$this->db2->order_by('ps.nama','asc');
		$query = $this->db2->get('pmm_receipt_material prm');

			$no = 1;
			if($query->num_rows() > 0){

				foreach ($query->result_array() as $key => $sups) {

					$mats = array();
					$materials = $this->pmm_model->GetLaporanHutangTEMEF($sups['supplier_id'],$start_date,$end_date,$filter_kategori);
					if(!empty($materials)){
						foreach ($materials as $key => $row) {
							$arr['no'] = $key + 1;
							$arr['nama_produk'] = $row['nama_produk'];
							$arr['purchase_order_id'] = '<a href="'.base_url().'pmm/purchase_order/manage/'.$row['purchase_order_id'].'" target="_blank">'.$row['purchase_order_id'] = $this->crud_global->GetField('pmm_purchase_order',array('id'=>$row['purchase_order_id']),'no_po').'</a>';
							$arr['penerimaan'] = number_format($row['penerimaan'],0,',','.');
							$arr['tagihan'] = number_format($row['tagihan'],0,',','.');
							$arr['tagihan_bruto'] = number_format($row['tagihan_bruto'],0,',','.');
							$arr['pembayaran'] = number_format($row['pembayaran'],0,',','.');
							$arr['sisa_hutang_penerimaan'] = number_format($row['sisa_hutang_penerimaan'],0,',','.');
							$arr['sisa_hutang_tagihan'] = number_format($row['sisa_hutang_tagihan'],0,',','.');

							$total_penerimaan += $row['penerimaan'];
							$total_tagihan += $row['tagihan'];
							$total_tagihan_bruto += $row['tagihan_bruto'];
							$total_pembayaran += $row['pembayaran'];
							$total_sisa_hutang_penerimaan += $row['sisa_hutang_penerimaan'];
							$total_sisa_hutang_tagihan += $row['sisa_hutang_tagihan'];
							
							
							$arr['name'] = $sups['name'];
							$mats[] = $arr;
						}
						$sups['mats'] = $mats;
						$sups['no'] =$no;

						$arr_data[] = $sups;
						$no++;
					}
					
					
				}
			}

			
			$data['data'] = $arr_data;
			$data['total_penerimaan'] = $total_penerimaan;
			$data['total_tagihan'] = $total_tagihan;
			$data['total_tagihan_bruto'] = $total_tagihan_bruto;
			$data['total_pembayaran'] = $total_pembayaran;
			$data['total_sisa_hutang_penerimaan'] = $total_sisa_hutang_penerimaan;
			$data['total_sisa_hutang_tagihan'] = $total_sisa_hutang_tagihan;
	        $html = $this->load->view('laporan_hutang_temef/cetak_laporan_hutang',$data,TRUE);

	        
	        $pdf->SetTitle('BBJ - Laporan Hutang');
	        $pdf->nsi_html($html);
	        $pdf->Output('laporan-hutang.pdf', 'I');
	        
		}else {
			echo 'Please Filter Date First';
		}
	
	}

	public function cetak_laporan_hutang_sc()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
		$pdf->setPrintFooter(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');

		$arr_data = array();
		$supplier_id = $this->input->get('supplier_id');
		$filter_kategori = $this->input->get('filter_kategori');
		$start_date = false;
		$end_date = false;
		$total_penerimaan = 0;
		$total_tagihan = 0;
		$total_tagihan_bruto = 0;
		$total_pembayaran = 0;
		$total_sisa_hutang_penerimaan = 0;
		$total_sisa_hutang_tagihan = 0;
		$date = $this->input->get('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
			$filter_date = date('d F Y',strtotime($arr_date[0])).' - '.date('d F Y',strtotime($arr_date[1]));

			
			$data['filter_date'] = $filter_date;
			$data['date2'] = $end_date;

			$this->db3->select('ppo.id, ppo.supplier_id, ps.nama as name');
			$this->db3->join('pmm_purchase_order ppo','prm.purchase_order_id = ppo.id','left');
			
			if(!empty($start_date) && !empty($end_date)){
				$this->db3->where('prm.date_receipt >=',$start_date);
				$this->db3->where('prm.date_receipt <=',$end_date);
			}
			if(!empty($supplier_id)){
				$this->db3->where('ppo.supplier_id',$supplier_id);
			}
			if(!empty($filter_kategori)){
				$this->db3->where('ppo.kategori_id',$filter_kategori);
			}

		$this->db3->join('penerima ps','ppo.supplier_id = ps.id','left');
		$this->db3->where("ppo.status in ('PUBLISH','CLOSED')");
		$this->db3->group_by('ppo.supplier_id');
		$this->db3->order_by('ps.nama','asc');
		$query = $this->db3->get('pmm_receipt_material prm');

			$no = 1;
			if($query->num_rows() > 0){

				foreach ($query->result_array() as $key => $sups) {

					$mats = array();
					$materials = $this->pmm_model->GetLaporanHutangSC($sups['supplier_id'],$start_date,$end_date,$filter_kategori);
					if(!empty($materials)){
						foreach ($materials as $key => $row) {
							$arr['no'] = $key + 1;
							$arr['nama_produk'] = $row['nama_produk'];
							$arr['purchase_order_id'] = '<a href="'.base_url().'pmm/purchase_order/manage/'.$row['purchase_order_id'].'" target="_blank">'.$row['purchase_order_id'] = $this->crud_global->GetField('pmm_purchase_order',array('id'=>$row['purchase_order_id']),'no_po').'</a>';
							$arr['penerimaan'] = number_format($row['penerimaan'],0,',','.');
							$arr['tagihan'] = number_format($row['tagihan'],0,',','.');
							$arr['tagihan_bruto'] = number_format($row['tagihan_bruto'],0,',','.');
							$arr['pembayaran'] = number_format($row['pembayaran'],0,',','.');
							$arr['sisa_hutang_penerimaan'] = number_format($row['sisa_hutang_penerimaan'],0,',','.');
							$arr['sisa_hutang_tagihan'] = number_format($row['sisa_hutang_tagihan'],0,',','.');

							$total_penerimaan += $row['penerimaan'];
							$total_tagihan += $row['tagihan'];
							$total_tagihan_bruto += $row['tagihan_bruto'];
							$total_pembayaran += $row['pembayaran'];
							$total_sisa_hutang_penerimaan += $row['sisa_hutang_penerimaan'];
							$total_sisa_hutang_tagihan += $row['sisa_hutang_tagihan'];
							
							
							$arr['name'] = $sups['name'];
							$mats[] = $arr;
						}
						$sups['mats'] = $mats;
						$sups['no'] =$no;

						$arr_data[] = $sups;
						$no++;
					}
					
					
				}
			}

			
			$data['data'] = $arr_data;
			$data['total_penerimaan'] = $total_penerimaan;
			$data['total_tagihan'] = $total_tagihan;
			$data['total_tagihan_bruto'] = $total_tagihan_bruto;
			$data['total_pembayaran'] = $total_pembayaran;
			$data['total_sisa_hutang_penerimaan'] = $total_sisa_hutang_penerimaan;
			$data['total_sisa_hutang_tagihan'] = $total_sisa_hutang_tagihan;
	        $html = $this->load->view('laporan_hutang_sc/cetak_laporan_hutang',$data,TRUE);

	        
	        $pdf->SetTitle('BBJ - Laporan Hutang');
	        $pdf->nsi_html($html);
	        $pdf->Output('laporan-hutang.pdf', 'I');
	        
		}else {
			echo 'Please Filter Date First';
		}
	
	}

	public function cetak_monitoring_hutang_temef()
	{
		$this->load->library('pdf');
	
		$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
		$pdf->setPrintFooter(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('L');
		$pdf->setPrintHeader(false);

		//Page2
		$pdf->AddPage('L', 'A4');
		$pdf->SetY(23);
		$pdf->SetX(6);
		$html =
		'<style type="text/css">
		 body {
			font-family: helvetica;
		}

		table.table-border-atas-full, th.table-border-atas-full, td.table-border-atas-full {
			border-top: 1px solid black;
			border-bottom: 1px solid black;
		}

		table.table-border-atas-only, th.table-border-atas-only, td.table-border-atas-only {
			border-top: 1px solid black;
		}

		table.table-border-bawah-only, th.table-border-bawah-only, td.table-border-bawah-only {
			border-bottom: 1px solid black;
		}

		table tr.table-judul{
			border: 1px solid;
			background-color: #e69500;
			font-weight: bold;
			font-size: 5px;
			color: black;
		}
			
		table tr.table-baris1{
			background-color: none;
			font-size: 5px;
		}

		table tr.table-baris1-bold{
			background-color: none;
			font-size: 5px;
			font-weight: bold;
		}
			
		table tr.table-total{
			background-color: #FFFF00;
			font-weight: bold;
			font-size: 5px;
			color: black;
		}

		table tr.table-total2{
			background-color: #eeeeee;
			font-weight: bold;
			font-size: 5px;
			color: black;
		}
	  	</style>
		<table width="98%" border="0" cellpadding="2">
			<tr class="table-judul">
				<th width="3%" align="center" rowspan="2" class="table-border-atas-full">&nbsp; <br />NO.</th>
				<th width="12%" align="center" rowspan="2" class="table-border-atas-full">&nbsp; <br />REKANAN / NO. TAGIHAN</th>
				<th width="6%" align="center" rowspan="2" class="table-border-atas-full">&nbsp; <br />TGL. TAGIHAN</th>
				<th width="9%" align="center" rowspan="2" class="table-border-atas-full">&nbsp; <br />JENIS PEMBELIAN</th>
				<th width="5%" align="center" rowspan="2" class="table-border-atas-full">TGL. VERIFIKASI</th>
				<th width="5%" align="center" rowspan="2" class="table-border-atas-full">SYARAT PEMBAYARAN</th>
				<th width="15%" align="center" colspan="3" class="table-border-atas-only">TAGIHAN</th>
				<th width="20%" align="center" colspan="4" class="table-border-atas-only">PEMBAYARAN</th>
				<th width="15%" align="center" colspan="3" class="table-border-atas-only">SISA HUTANG</th>
				<th width="5%" align="center" rowspan="2" class="table-border-atas-full">&nbsp; <br />STATUS</th>
				<th width="5%" align="center" rowspan="2" class="table-border-atas-full">TGL. JATUH TEMPO</th>
			</tr>
			<tr class="table-judul">
				<th align="center" class="table-border-bawah-only">DPP</th>
				<th align="center" class="table-border-bawah-only">PPN</th>
				<th align="center" class="table-border-bawah-only">JUMLAH</th>
				<th align="center" class="table-border-bawah-only">DPP</th>
				<th align="center" class="table-border-bawah-only">PPN</th>
				<th align="center" class="table-border-bawah-only">PPH</th>
				<th align="center" class="table-border-bawah-only">JUMLAH</th>
				<th align="center" class="table-border-bawah-only">DPP</th>
				<th align="center" class="table-border-bawah-only">PPN</th>
				<th align="center" class="table-border-bawah-only">JUMLAH</th>
			</tr>		
		</table>';
		$pdf->writeHTML($html, true, false, true, false, '');

		//Page3
		$pdf->AddPage();
		$pdf->SetY(23);
		$pdf->SetX(6);
		$pdf->WriteHTML($html);

		//Page4
		$pdf->AddPage();
		$pdf->SetY(23);
		$pdf->SetX(6);
		$pdf->WriteHTML($html);

		//Page5
		$pdf->AddPage();
		$pdf->SetY(23);
		$pdf->SetX(6);
		$pdf->WriteHTML($html);

		//Page6
		$pdf->AddPage();
		$pdf->SetY(23);
		$pdf->SetX(6);
		$pdf->WriteHTML($html);

		//Page1
		$pdf->setPage(1, true);
		$pdf->SetY(35);
		$pdf->Cell(0, 0, '', 0, 0, 'C');

		$arr_data = array();
		$supplier_id = $this->input->get('supplier_id');
		$filter_kategori = $this->input->get('filter_kategori');
		$filter_status = $this->input->get('filter_status');
		$start_date = false;
		$end_date = false;
		$total_dpp_tagihan = 0;
		$total_ppn_tagihan = 0;
		$total_jumlah_tagihan = 0;
		$total_dpp_pembayaran = 0;
		$total_ppn_pembayaran = 0;
		$total_pph_pembayaran = 0;
		$total_jumlah_pembayaran = 0;
		$total_dpp_sisa_hutang = 0;
		$total_ppn_sisa_hutang = 0;
		$total_jumlah_sisa_hutang = 0;
		$date = $this->input->get('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
			$filter_date = date('d F Y',strtotime($arr_date[0])).' - '.date('d F Y',strtotime($arr_date[1]));

			$data['filter_date'] = $filter_date;
			$data['date2'] = $end_date;

			$this->db2->select('ppp.id, ppp.supplier_id, ps.nama as name');
			$this->db2->join('penerima ps','ppp.supplier_id = ps.id','left');
			$this->db2->join('pmm_purchase_order ppo','ppp.purchase_order_id = ppo.id','left');
			
			if(!empty($start_date) && !empty($end_date)){
				$this->db2->where('ppp.created_on >=',$start_date.' 23:59:59');
           		$this->db2->where('ppp.created_on <=',$end_date.' 23:59:59');
			}
			if(!empty($supplier_id) || $supplier_id != 0){
				$this->db2->where('ppo.supplier_id',$supplier_id);
			}
			if(!empty($filter_kategori) || $filter_kategori != 0){
				$this->db2->where('ppo.kategori_id',$filter_kategori);
			}
			if(!empty($filter_status) || $filter_status != 0){
				$this->db2->where('ppp.status',$filter_status);
			}

			$this->db2->where("ppp.verifikasi_dok in ('SUDAH','LENGKAP')");
			$this->db2->group_by('ppp.supplier_id');
			$this->db2->order_by('ps.nama','asc');
			$query = $this->db2->get('pmm_penagihan_pembelian ppp');

			$no = 1;
			if($query->num_rows() > 0){

				foreach ($query->result_array() as $key => $sups) {

					$mats = array();
					$materials = $this->pmm_model->GetLaporanMonitoringHutangTEMEF($sups['supplier_id'],$start_date,$end_date,$filter_kategori,$filter_status);
					if(!empty($materials)){
						foreach ($materials as $key => $row) {
							$awal  = date_create($row['status_umur_hutang']);
							$akhir = date_create($end_date);
							$diff  = date_diff( $awal, $akhir );

							$tanggal_tempo = date('Y-m-d', strtotime(+$row['syarat_pembayaran'].'days', strtotime($row['tanggal_lolos_verifikasi'])));

							$awal_tempo =date_create($tanggal_tempo);
							$akhir_tempo =date_create($end_date);
							$diff_tempo =date_diff($awal_tempo,$akhir_tempo);

							$arr['no'] = $key + 1;
							$arr['nama'] = $row['nama'];
							$arr['subject'] = $row['subject'];
							$arr['status'] = $row['status'];
							$arr['syarat_pembayaran'] = $row['syarat_pembayaran'];
							//$arr['syarat_pembayaran'] = $diff->days . ' Hari';
							//$arr['syarat_pembayaran'] = $diff->days . ' ';
							//$arr['jatuh_tempo'] =  $diff_tempo->format("%R%a");
							$arr['jatuh_tempo'] =  date('d-m-Y',strtotime($tanggal_tempo));
							$arr['nomor_invoice'] = $row['nomor_invoice'];
							$arr['tanggal_invoice'] = date('d-m-Y',strtotime($row['tanggal_invoice']));
							$arr['tanggal_lolos_verifikasi'] = date('d-m-Y',strtotime($row['tanggal_lolos_verifikasi']));
							$arr['dpp_tagihan'] = number_format($row['dpp_tagihan'],0,',','.');
							$arr['ppn_tagihan'] = number_format($row['ppn_tagihan'],0,',','.');
							$arr['jumlah_tagihan'] = number_format($row['jumlah_tagihan'],0,',','.');
							$arr['dpp_pembayaran'] = number_format($row['dpp_pembayaran'],0,',','.');
							$arr['ppn_pembayaran'] = number_format($row['ppn_pembayaran'],0,',','.');
							$arr['pph_pembayaran'] = number_format($row['pph_pembayaran'],0,',','.');
							$arr['jumlah_pembayaran'] = number_format($row['jumlah_pembayaran'],0,',','.');
							$arr['dpp_sisa_hutang'] = number_format($row['dpp_sisa_hutang'],0,',','.');
							$arr['ppn_sisa_hutang'] = number_format($row['ppn_sisa_hutang'],0,',','.');
							$arr['jumlah_sisa_hutang'] = number_format($row['jumlah_sisa_hutang'],0,',','.');

							$total_dpp_tagihan += $row['dpp_tagihan'];
							$total_ppn_tagihan += $row['ppn_tagihan'];
							$total_jumlah_tagihan += $row['jumlah_tagihan'];
							$total_dpp_pembayaran += $row['dpp_pembayaran'];
							$total_ppn_pembayaran += $row['ppn_pembayaran'];
							$total_pph_pembayaran += $row['pph_pembayaran'];
							$total_jumlah_pembayaran += $row['jumlah_pembayaran'];
							$total_dpp_sisa_hutang += $row['dpp_sisa_hutang'];
							$total_ppn_sisa_hutang += $row['ppn_sisa_hutang'];
							$total_jumlah_sisa_hutang += $row['jumlah_sisa_hutang'];
							
							
							$arr['name'] = $sups['name'];
							$mats[] = $arr;
						}
						$sups['mats'] = $mats;
						$sups['no'] =$no;

						$arr_data[] = $sups;
						$no++;
					}
				}
			}
			
			$data['data'] = $arr_data;
			$data['total_dpp_tagihan'] = $total_dpp_tagihan;
			$data['total_ppn_tagihan'] = $total_ppn_tagihan;
			$data['total_jumlah_tagihan'] = $total_jumlah_tagihan;
			$data['total_dpp_pembayaran'] = $total_dpp_pembayaran;
			$data['total_ppn_pembayaran'] = $total_ppn_pembayaran;
			$data['total_pph_pembayaran'] = $total_pph_pembayaran;
			$data['total_jumlah_pembayaran'] = $total_jumlah_pembayaran;
			$data['total_dpp_sisa_hutang'] = $total_dpp_sisa_hutang;
			$data['total_ppn_sisa_hutang'] = $total_ppn_sisa_hutang;
			$data['total_jumlah_sisa_hutang'] = $total_jumlah_sisa_hutang;
	        $html = $this->load->view('laporan_monitoring_hutang_temef/cetak_monitoring_hutang',$data,TRUE);

	        $pdf->SetTitle('BBJ - Laporan Monitoring Hutang');
	        $pdf->nsi_html($html);
	        $pdf->Output('monitoring-hutang.pdf', 'I');
	        
		}else {
			echo 'Please Filter Date First';
		}
	
	}

	public function cetak_monitoring_hutang_sc()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
		$pdf->setPrintFooter(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('L');
		$pdf->setPrintHeader(false);

		//Page2
		$pdf->AddPage('L', 'A4');
		$pdf->SetY(29);
		$pdf->SetX(6);
		$html =
		'<style type="text/css">
			body {
			font-family: helvetica;
		}

		table.table-border-atas-full, th.table-border-atas-full, td.table-border-atas-full {
			border-top: 1px solid black;
			border-bottom: 1px solid black;
		}

		table.table-border-atas-only, th.table-border-atas-only, td.table-border-atas-only {
			border-top: 1px solid black;
		}

		table.table-border-bawah-only, th.table-border-bawah-only, td.table-border-bawah-only {
			border-bottom: 1px solid black;
		}

		table tr.table-judul{
			border: 1px solid;
			background-color: #e69500;
			font-weight: bold;
			font-size: 5px;
			color: black;
		}
			
		table tr.table-baris1{
			background-color: none;
			font-size: 5px;
		}

		table tr.table-baris1-bold{
			background-color: none;
			font-size: 5px;
			font-weight: bold;
		}
			
		table tr.table-total{
			background-color: #FFFF00;
			font-weight: bold;
			font-size: 5px;
			color: black;
		}

		table tr.table-total2{
			background-color: #eeeeee;
			font-weight: bold;
			font-size: 5px;
			color: black;
		}
		</style>
		 <table width="98%" border="0" cellpadding="2">
		 <tr class="table-judul">
			<th width="3%" align="center" rowspan="2" class="table-border-atas-full">&nbsp; <br />NO.</th>
			<th width="12%" align="center" rowspan="2" class="table-border-atas-full">&nbsp; <br />REKANAN / NO. TAGIHAN</th>
			<th width="6%" align="center" rowspan="2" class="table-border-atas-full">&nbsp; <br />TGL. TAGIHAN</th>
			<th width="9%" align="center" rowspan="2" class="table-border-atas-full">&nbsp; <br />JENIS PEMBELIAN</th>
			<th width="5%" align="center" rowspan="2" class="table-border-atas-full">TGL. VERIFIKASI</th>
			<th width="5%" align="center" rowspan="2" class="table-border-atas-full">SYARAT PEMBAYARAN</th>
			<th width="15%" align="center" colspan="3" class="table-border-atas-only">TAGIHAN</th>
			<th width="20%" align="center" colspan="4" class="table-border-atas-only">PEMBAYARAN</th>
			<th width="15%" align="center" colspan="3" class="table-border-atas-only">SISA HUTANG</th>
			<th width="5%" align="center" rowspan="2" class="table-border-atas-full">&nbsp; <br />STATUS</th>
			<th width="5%" align="center" rowspan="2" class="table-border-atas-full">TGL. JATUH TEMPO</th>
		</tr>
		<tr class="table-judul">
			<th align="center" class="table-border-bawah-only">DPP</th>
			<th align="center" class="table-border-bawah-only">PPN</th>
			<th align="center" class="table-border-bawah-only">JUMLAH</th>
			<th align="center" class="table-border-bawah-only">DPP</th>
			<th align="center" class="table-border-bawah-only">PPN</th>
			<th align="center" class="table-border-bawah-only">PPH</th>
			<th align="center" class="table-border-bawah-only">JUMLAH</th>
			<th align="center" class="table-border-bawah-only">DPP</th>
			<th align="center" class="table-border-bawah-only">PPN</th>
			<th align="center" class="table-border-bawah-only">JUMLAH</th>
		</tr>	
		</table>';
		$pdf->writeHTML($html, true, false, true, false, '');

		//Page3
		$pdf->AddPage();
		$pdf->SetY(29);
		$pdf->SetX(6);
		$pdf->WriteHTML($html);

		//Page1
		$pdf->setPage(1, true);
		$pdf->SetY(35);
		$pdf->Cell(0, 0, '', 0, 0, 'C');

		$arr_data = array();
		$supplier_id = $this->input->get('supplier_id');
		$filter_kategori = $this->input->get('filter_kategori');
		$filter_status = $this->input->get('filter_status');
		$start_date = false;
		$end_date = false;
		$total_dpp_tagihan = 0;
		$total_ppn_tagihan = 0;
		$total_pph_tagihan = 0;
		$total_jumlah_tagihan = 0;
		$total_dpp_pembayaran = 0;
		$total_ppn_pembayaran = 0;
		$total_pph_pembayaran = 0;
		$total_jumlah_pembayaran = 0;
		$total_dpp_sisa_hutang = 0;
		$total_ppn_sisa_hutang = 0;
		$total_pph_sisa_hutang = 0;
		$total_jumlah_sisa_hutang = 0;
		$date = $this->input->get('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
			$filter_date = date('d F Y',strtotime($arr_date[0])).' - '.date('d F Y',strtotime($arr_date[1]));

			$data['filter_date'] = $filter_date;
			$data['date2'] = $end_date;
			$data['start_date'] = $start_date;
			$data['end_date'] = $end_date;

			$this->db3->select('ppp.id, ppp.supplier_id, ps.nama as name');
			$this->db3->join('penerima ps','ppp.supplier_id = ps.id','left');
			$this->db3->join('pmm_purchase_order ppo','ppp.purchase_order_id = ppo.id','left');
			
			if(!empty($start_date) && !empty($end_date)){
				$this->db3->where('ppp.created_on >=',$start_date.' 23:59:59');
           		$this->db3->where('ppp.created_on <=',$end_date.' 23:59:59');
			}
			if(!empty($supplier_id) || $supplier_id != 0){
				$this->db3->where('ppo.supplier_id',$supplier_id);
			}
			if(!empty($filter_kategori) || $filter_kategori != 0){
				$this->db3->where('ppo.kategori_id',$filter_kategori);
			}
			if(!empty($filter_status) || $filter_status != 0){
				$this->db3->where('ppp.status',$filter_status);
			}

			$this->db3->where("ppp.verifikasi_dok in ('SUDAH','LENGKAP')");
			$this->db3->group_by('ppp.supplier_id');
			$this->db3->order_by('ps.nama','asc');
			$query = $this->db3->get('pmm_penagihan_pembelian ppp');

			$no = 1;
			if($query->num_rows() > 0){

				foreach ($query->result_array() as $key => $sups) {

					$mats = array();
					$materials = $this->pmm_model->GetLaporanMonitoringHutangSC($sups['supplier_id'],$start_date,$end_date,$filter_kategori,$filter_status);
					if(!empty($materials)){
						foreach ($materials as $key => $row) {
							$awal  = date_create($row['status_umur_hutang']);
							$akhir = date_create($end_date);
							$diff  = date_diff( $awal, $akhir );

							$tanggal_tempo = date('Y-m-d', strtotime(+$row['syarat_pembayaran'].'days', strtotime($row['tanggal_lolos_verifikasi'])));

							$awal_tempo =date_create($tanggal_tempo);
							$akhir_tempo =date_create($end_date);
							$diff_tempo =date_diff($awal_tempo,$akhir_tempo);

							$arr['no'] = $key + 1;
							$arr['nama'] = $row['nama'];
							$arr['subject'] = $row['subject'];
							$arr['status'] = $row['status'];
							$arr['syarat_pembayaran'] = $row['syarat_pembayaran'];
							//$arr['syarat_pembayaran'] = $diff->days . ' Hari';
							//$arr['syarat_pembayaran'] = $diff->days . ' ';
							//$arr['jatuh_tempo'] =  $diff_tempo->format("%R%a");
							$arr['jatuh_tempo'] =  date('d-m-Y',strtotime($tanggal_tempo));
							$arr['nomor_invoice'] = $row['nomor_invoice'];
							$arr['tanggal_invoice'] = date('d-m-Y',strtotime($row['tanggal_invoice']));
							$arr['tanggal_lolos_verifikasi'] = date('d-m-Y',strtotime($row['tanggal_lolos_verifikasi']));
							$arr['dpp_tagihan'] = number_format($row['dpp_tagihan'],0,',','.');
							$arr['ppn_tagihan'] = number_format($row['ppn_tagihan'],0,',','.');
							$arr['jumlah_tagihan'] = number_format($row['jumlah_tagihan'],0,',','.');
							$arr['dpp_pembayaran'] = number_format($row['dpp_pembayaran'],0,',','.');
							$arr['ppn_pembayaran'] = number_format($row['ppn_pembayaran'],0,',','.');
							$arr['pph_pembayaran'] = number_format($row['pph_pembayaran'],0,',','.');
							$arr['jumlah_pembayaran'] = number_format($row['jumlah_pembayaran'],0,',','.');
							$arr['dpp_sisa_hutang'] = number_format($row['dpp_sisa_hutang'],0,',','.');
							$arr['ppn_sisa_hutang'] = number_format($row['ppn_sisa_hutang'],0,',','.');
							$arr['jumlah_sisa_hutang'] = number_format($row['jumlah_sisa_hutang'],0,',','.');

							$total_dpp_tagihan += $row['dpp_tagihan'];
							$total_ppn_tagihan += $row['ppn_tagihan'];
							$total_jumlah_tagihan += $row['jumlah_tagihan'];
							$total_dpp_pembayaran += $row['dpp_pembayaran'];
							$total_ppn_pembayaran += $row['ppn_pembayaran'];
							$total_pph_pembayaran += $row['pph_pembayaran'];
							$total_jumlah_pembayaran += $row['jumlah_pembayaran'];
							$total_dpp_sisa_hutang += $row['dpp_sisa_hutang'];
							$total_ppn_sisa_hutang += $row['ppn_sisa_hutang'];
							$total_jumlah_sisa_hutang += $row['jumlah_sisa_hutang'];
							
							$arr['name'] = $sups['name'];
							$mats[] = $arr;
						}
						$sups['mats'] = $mats;
						$sups['no'] =$no;

						$arr_data[] = $sups;
						$no++;
					}
					
					
				}
			}

			
			$data['data'] = $arr_data;
			$data['total_dpp_tagihan'] = $total_dpp_tagihan;
			$data['total_ppn_tagihan'] = $total_ppn_tagihan;
			$data['total_jumlah_tagihan'] = $total_jumlah_tagihan;
			$data['total_dpp_pembayaran'] = $total_dpp_pembayaran;
			$data['total_ppn_pembayaran'] = $total_ppn_pembayaran;
			$data['total_pph_pembayaran'] = $total_pph_pembayaran;
			$data['total_jumlah_pembayaran'] = $total_jumlah_pembayaran;
			$data['total_dpp_sisa_hutang'] = $total_dpp_sisa_hutang;
			$data['total_ppn_sisa_hutang'] = $total_ppn_sisa_hutang;
			$data['total_jumlah_sisa_hutang'] = $total_jumlah_sisa_hutang;
	        $html = $this->load->view('laporan_monitoring_hutang_sc/cetak_monitoring_hutang',$data,TRUE);

	        $pdf->SetTitle('BBJ - Laporan Monitoring Hutang');
	        $pdf->nsi_html($html);
	        $pdf->Output('monitoring-hutang.pdf', 'I');
	        
		}else {
			echo 'Please Filter Date First';
		}
	
	}

	public function cetak_daftar_pembayaran_temef()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetPrintHeader(true);
		$pdf->SetPrintFooter(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');
		
		$arr_data = array();
		$supplier_id = $this->input->get('supplier_id');
		$purchase_order_no = $this->input->get('purchase_order_no');
		$filter_material = $this->input->get('filter_material');
		$start_date = false;
		$end_date = false;
		$total = 0;
		$date = $this->input->get('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
			$filter_date = date('d F Y',strtotime($arr_date[0])).' - '.date('d F Y',strtotime($arr_date[1]));
			
			$data['filter_date'] = $filter_date;
		
		$this->db2->select('pmp.supplier_name, SUM(pmp.total) AS total_bayar');
		if(!empty($start_date) && !empty($end_date)){
            $this->db2->where('pmp.tanggal_pembayaran >=',$start_date);
            $this->db2->where('pmp.tanggal_pembayaran <=',$end_date);
        }
        if(!empty($supplier_id)){
            $this->db2->where('pmp.supplier_name',$supplier_id);
        }
        if(!empty($filter_material)){
            $this->db2->where_in('ppd.material_id',$filter_material);
        }
        if(!empty($purchase_order_no)){
            $this->db2->where('pmp.penagihan_pembelian_id',$purchase_order_no);
        }
		
		$this->db2->join('pmm_penagihan_pembelian ppp', 'pmp.penagihan_pembelian_id = ppp.id','left');
		$this->db2->group_by('pmp.supplier_name');
		$this->db2->where('pmp.status','DISETUJUI');
		$query = $this->db2->get('pmm_pembayaran_penagihan_pembelian pmp');
		
		$no = 1;
		if($query->num_rows() > 0){

			foreach ($query->result_array() as $key => $sups) {

				$mats = array();
				$materials = $this->pmm_model->GetDaftarPembayaranTEMEF($sups['supplier_name'],$purchase_order_no,$start_date,$end_date,$filter_material);
				
				if(!empty($materials)){
					foreach ($materials as $key => $row) {
						$arr['no'] = $key + 1;
						$arr['tanggal_pembayaran'] = date('d-m-Y',strtotime($row['tanggal_pembayaran']));
						$arr['nomor_transaksi'] = $row['nomor_transaksi'];
						$arr['tanggal_invoice'] = $row['tanggal_invoice'];
						$arr['nomor_invoice'] = $row['nomor_invoice'];
						$arr['pembayaran'] = number_format($row['pembayaran'],0,',','.');								
						
						$arr['supplier_name'] = $sups['supplier_name'];
						$mats[] = $arr;
					}
					
					
					$sups['mats'] = $mats;
					$total += $sups['total_bayar'];
					$sups['no'] =$no;
					$sups['total_bayar'] = number_format($sups['total_bayar'],0,',','.');
					

					$arr_data[] = $sups;
					$no++;
					
					}	
					
					
				}
			}

			$data['data'] = $arr_data;
			$data['total'] = $total;
	        $html = $this->load->view('daftar_pembayaran_temef/cetak_daftar_pembayaran',$data,TRUE);
	        
	        $pdf->SetTitle('BBJ - Daftar Pembayaran');
	        $pdf->nsi_html($html);
	        $pdf->Output('daftar-pembayaran.pdf', 'I');
	        
		}else {
			echo 'Please Filter Date First';
		}
	
	}

	public function cetak_daftar_pembayaran_sc()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetPrintHeader(true);
		$pdf->SetPrintFooter(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');
		
		$arr_data = array();
		$supplier_id = $this->input->get('supplier_id');
		$purchase_order_no = $this->input->get('purchase_order_no');
		$filter_material = $this->input->get('filter_material');
		$start_date = false;
		$end_date = false;
		$total = 0;
		$date = $this->input->get('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
			$filter_date = date('d F Y',strtotime($arr_date[0])).' - '.date('d F Y',strtotime($arr_date[1]));
			
			$data['filter_date'] = $filter_date;
		
		$this->db3->select('pmp.supplier_name, SUM(pmp.total) AS total_bayar');
		if(!empty($start_date) && !empty($end_date)){
            $this->db3->where('pmp.tanggal_pembayaran >=',$start_date);
            $this->db3->where('pmp.tanggal_pembayaran <=',$end_date);
        }
        if(!empty($supplier_id)){
            $this->db3->where('pmp.supplier_name',$supplier_id);
        }
        if(!empty($filter_material)){
            $this->db3->where_in('ppd.material_id',$filter_material);
        }
        if(!empty($purchase_order_no)){
            $this->db3->where('pmp.penagihan_pembelian_id',$purchase_order_no);
        }
		
		$this->db3->join('pmm_penagihan_pembelian ppp', 'pmp.penagihan_pembelian_id = ppp.id','left');
		$this->db3->group_by('pmp.supplier_name');
		$this->db3->where('pmp.status','DISETUJUI');
		$query = $this->db3->get('pmm_pembayaran_penagihan_pembelian pmp');
		
		$no = 1;
		if($query->num_rows() > 0){

			foreach ($query->result_array() as $key => $sups) {

				$mats = array();
				$materials = $this->pmm_model->GetDaftarPembayaranSC($sups['supplier_name'],$purchase_order_no,$start_date,$end_date,$filter_material);
				
				if(!empty($materials)){
					foreach ($materials as $key => $row) {
						$arr['no'] = $key + 1;
						$arr['tanggal_pembayaran'] = date('d-m-Y',strtotime($row['tanggal_pembayaran']));
						$arr['nomor_transaksi'] = $row['nomor_transaksi'];
						$arr['tanggal_invoice'] = $row['tanggal_invoice'];
						$arr['nomor_invoice'] = $row['nomor_invoice'];
						$arr['pembayaran'] = number_format($row['pembayaran'],0,',','.');								
						
						$arr['supplier_name'] = $sups['supplier_name'];
						$mats[] = $arr;
					}
					
					
					$sups['mats'] = $mats;
					$total += $sups['total_bayar'];
					$sups['no'] =$no;
					$sups['total_bayar'] = number_format($sups['total_bayar'],0,',','.');
					

					$arr_data[] = $sups;
					$no++;
					
					}	
					
					
				}
			}

			$data['data'] = $arr_data;
			$data['total'] = $total;
	        $html = $this->load->view('daftar_pembayaran_sc/cetak_daftar_pembayaran',$data,TRUE);
	        
	        $pdf->SetTitle('BBJ - Daftar Pembayaran');
	        $pdf->nsi_html($html);
	        $pdf->Output('daftar-pembayaran.pdf', 'I');
	        
		}else {
			echo 'Please Filter Date First';
		}
	
	}

	public function cetak_pengiriman_penjualan_int()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');

		$arr_date = $this->input->get('filter_date');
		if(empty($arr_date)){
			$filter_date = '-';
		}else {
			$arr_filter_date = explode(' - ', $arr_date);
			$start_date = date('Y-m-d',strtotime($arr_filter_date[0]));
    		$end_date = date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('d F Y',strtotime($arr_filter_date[0])).' - '.date('d F Y',strtotime($arr_filter_date[1]));
		}
		$data['filter_date'] = $filter_date;
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
        $html = $this->load->view('laporan_penjualan/cetak_pengiriman_penjualan_int',$data,TRUE);

        
        $pdf->SetTitle('BBJ - Laporan Pengiriman Penjualan');
        $pdf->nsi_html($html);
        $pdf->Output('laporan_pengiriman_penjualan.pdf', 'I');
	
	}

	public function cetak_laporan_piutang_int()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('L');

		$arr_date = $this->input->get('filter_date');
		if(empty($arr_date)){
			$filter_date = '-';
		}else {
			$arr_filter_date = explode(' - ', $arr_date);
			$start_date = date('Y-m-d',strtotime($arr_filter_date[0]));
    		$end_date = date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('d F Y',strtotime($arr_filter_date[0])).' - '.date('d F Y',strtotime($arr_filter_date[1]));
		}
		$data['filter_date'] = $filter_date;
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
        $html = $this->load->view('laporan_penjualan/cetak_laporan_piutang_int',$data,TRUE);

        
        $pdf->SetTitle('BBJ - Laporan Piutang');
        $pdf->nsi_html($html);
        $pdf->Output('laporan_piutang.pdf', 'I');
	
	}

	public function cetak_laporan_monitoring_piutang_int()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('L');

		$arr_date = $this->input->get('filter_date');
		if(empty($arr_date)){
			$filter_date = '-';
		}else {
			$arr_filter_date = explode(' - ', $arr_date);
			$start_date = date('Y-m-d',strtotime($arr_filter_date[0]));
    		$end_date = date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('d F Y',strtotime($arr_filter_date[0])).' - '.date('d F Y',strtotime($arr_filter_date[1]));
		}
		$data['filter_date'] = $filter_date;
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
        $html = $this->load->view('laporan_penjualan/cetak_laporan_monitoring_piutang_int',$data,TRUE);

        
        $pdf->SetTitle('BBJ - Laporan Monitoring Piutang');
        $pdf->nsi_html($html);
        $pdf->Output('laporan_monitoring_piutang.pdf', 'I');
	
	}

	public function cetak_daftar_penerimaan_int()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');

		$arr_date = $this->input->get('filter_date');
		if(empty($arr_date)){
			$filter_date = '-';
		}else {
			$arr_filter_date = explode(' - ', $arr_date);
			$start_date = date('Y-m-d',strtotime($arr_filter_date[0]));
    		$end_date = date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('d F Y',strtotime($arr_filter_date[0])).' - '.date('d F Y',strtotime($arr_filter_date[1]));
		}
		$data['filter_date'] = $filter_date;
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
        $html = $this->load->view('laporan_penjualan/cetak_daftar_penerimaan_int',$data,TRUE);

        
        $pdf->SetTitle('BBJ - Daftar Penerimaan');
        $pdf->nsi_html($html);
        $pdf->Output('daftar_penerimaan.pdf', 'I');
	
	}

	public function cetak_pengiriman_penjualan_temef()
	{
		$this->load->library('pdf');

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
		$pdf->setPrintFooter(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');

		$arr_data = array();
		$filter_client_id = $this->input->get('filter_client_id');
		$purchase_order_no = $this->input->get('purchase_order_no');
		$filter_product = $this->input->get('filter_product');
		$start_date = false;
		$end_date = false;
		$total = 0;
		$date = $this->input->get('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
			$filter_date = date('d F Y',strtotime($arr_date[0])).' - '.date('d F Y',strtotime($arr_date[1]));

			$data['filter_date'] = $filter_date;
			$data['start_date'] = $start_date;
			$data['end_date'] = $end_date;
		
			$this->db2->select('ppo.client_id, pp.convert_measure as convert_measure, ps.nama as name, SUM(pp.display_price) / SUM(pp.display_volume) as price, SUM(pp.display_volume) as total, SUM(pp.display_price) as total_price');
		if(!empty($start_date) && !empty($end_date)){
            $this->db2->where('pp.date_production >=',$start_date);
            $this->db2->where('pp.date_production <=',$end_date);
        }
        if(!empty($filter_client_id)){
            $this->db2->where('ppo.client_id',$filter_client_id);
        }
        if(!empty($filter_product)){
            $this->db2->where_in('pp.product_id',$filter_product);
        }
        if(!empty($purchase_order_no)){
            $this->db2->where('pp.salesPo_id',$purchase_order_no);
        }
		
		$this->db2->join('penerima ps','ppo.client_id = ps.id','left');
		$this->db2->join('pmm_productions pp','ppo.id = pp.salesPo_id');
		$this->db2->where("ppo.status in ('OPEN','CLOSED')");
		$this->db2->where('pp.status','PUBLISH');
		$this->db2->group_by('ppo.client_id');
		$query = $this->db2->get('pmm_sales_po ppo');
		
		$no = 1;
		if($query->num_rows() > 0){

			foreach ($query->result_array() as $key => $sups) {

				$mats = array();
				$materials = $this->pmm_model->GetPengirimanPenjualanTEMEFPrint($sups['client_id'],$purchase_order_no,$start_date,$end_date,$filter_product);
				if(!empty($materials)){
					foreach ($materials as $key => $row) {
						$arr['no'] = $key + 1;
						$arr['measure'] = $row['measure'];
						$arr['nama_produk'] = $row['nama_produk'];
						$arr['salesPo_id'] = $row['salesPo_id'] = $this->crud_global->GetField('pmm_sales_po',array('id'=>$row['salesPo_id']),'contract_number');
						$arr['real'] = number_format($row['total'],2,',','.');
						$arr['price'] = number_format($row['price'],0,',','.');
						$arr['total_price'] = number_format($row['total_price'],0,',','.');
						
						
						$arr['name'] = $sups['name'];
						$mats[] = $arr;
					}
					$sups['mats'] = $mats;
					$total += $sups['total_price'];
					$sups['no'] =$no;
					$sups['real'] = number_format($sups['total'],2,',','.');
					$sups['price'] = number_format($sups['price'],0,',','.');
					$sups['total_price'] = number_format($sups['total_price'],0,',','.');

					$arr_data[] = $sups;
					$no++;
				}
			}
		}

		$data['data'] = $arr_data;
		$data['total'] = $total;
		$html = $this->load->view('laporan_penjualan_temef/cetak_pengiriman_penjualan',$data,TRUE);
		
		$pdf->SetTitle('BBJ - Laporan Penjualan');
		$pdf->nsi_html($html);
		$pdf->Output('laporan-penjualan.pdf', 'I');
	        
		}else {
			echo 'Please Filter Date First';
		}
	
	}

	public function cetak_pengiriman_penjualan_sc()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
        $pdf->setPrintFooter(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');

		$arr_data = array();
		$filter_client_id = $this->input->get('filter_client_id');
		$purchase_order_no = $this->input->get('purchase_order_no');
		$filter_product = $this->input->get('filter_product');
		$start_date = false;
		$end_date = false;
		$total = 0;
		$total_nilai = 0;
		$total_volume = 0;
		$date = $this->input->get('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
			$filter_date = date('d F Y',strtotime($arr_date[0])).' - '.date('d F Y',strtotime($arr_date[1]));

			
		$data['filter_date'] = $filter_date;
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
		
		$this->db3->select('ppo.client_id, pp.convert_measure as convert_measure, ps.nama as name, SUM(pp.display_volume) as total, SUM(pp.display_price) as total_price');
		if(!empty($start_date) && !empty($end_date)){
            $this->db3->where('pp.date_production >=',$start_date);
            $this->db3->where('pp.date_production <=',$end_date);
        }
        if(!empty($filter_client_id)){
            $this->db3->where('ppo.client_id',$filter_client_id);
        }
        if(!empty($filter_product)){
            $this->db3->where_in('pp.product_id',$filter_product);
        }
        if(!empty($purchase_order_no)){
            $this->db3->where('pp.salesPo_id',$purchase_order_no);
        }
		
		$this->db3->join('penerima ps','ppo.client_id = ps.id','left');
		$this->db3->join('pmm_productions pp','ppo.id = pp.salesPo_id','left');
		$this->db3->where("ppo.status in ('OPEN','CLOSED')");
		$this->db3->where('pp.status','PUBLISH');
		$this->db3->where("pp.product_id in (3,4,7,8,9,14,24)");
		$this->db3->group_by('ppo.client_id');
		$query = $this->db3->get('pmm_sales_po ppo');
		
		$no = 1;
		if($query->num_rows() > 0){

			foreach ($query->result_array() as $key => $sups) {

				$mats = array();
				$materials = $this->pmm_model->GetPengirimanPenjualanSC($sups['client_id'],$purchase_order_no,$start_date,$end_date,$filter_product);
				if(!empty($materials)){
					foreach ($materials as $key => $row) {
						$arr['no'] = $key + 1;
						$arr['measure'] = $row['measure'];
						$arr['nama_produk'] = $row['nama_produk'];
						$arr['real'] = number_format($row['total'],2,',','.');
						$arr['price'] = number_format($row['price'],0,',','.');
						$arr['total_price'] = number_format($row['total_price'],0,',','.');
						
						
						$arr['name'] = $sups['name'];
						$mats[] = $arr;
					}
					$sups['mats'] = $mats;
					$total_volume += $sups['total'];
					$total_nilai += $sups['total_price'];
					$sups['no'] = $no;
					$sups['real'] = number_format($sups['total'],2,',','.');
					$sups['total_price'] = number_format($sups['total_price'],0,',','.');

					$arr_data[] = $sups;
					$no++;
				}
				
				
			}
		}

			$data['data'] = $arr_data;
			$data['total'] = $total;
	        $html = $this->load->view('laporan_penjualan_sc/cetak_pengiriman_penjualan',$data,TRUE);
	        
	        $pdf->SetTitle('BBJ - Laporan Penjualan');
	        $pdf->nsi_html($html);
	        $pdf->Output('laporan-penjualan.pdf', 'I');
	        
		}else {
			echo 'Please Filter Date First';
		}
	
	}

	public function cetak_laporan_piutang_temef()
	{
		$this->load->library('pdf');
	
		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
		$pdf->setPrintFooter(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');

		$arr_data = array();
		$client_id = $this->input->get('client_id');
		$start_date = false;
		$end_date = false;
		$total_penerimaan = 0;
		$total_tagihan = 0;
		$total_tagihan_bruto = 0;
		$total_pembayaran = 0;
		$total_sisa_piutang_penerimaan = 0;
		$total_sisa_piutang_tagihan = 0;
		$date = $this->input->get('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
			$filter_date = date('d F Y',strtotime($arr_date[0])).' - '.date('d F Y',strtotime($arr_date[1]));

			$data['filter_date'] = $filter_date;
			$data['date2'] = $end_date;

		$this->db2->select('po.id, po.client_id, ps.nama as name');
		$this->db2->join('pmm_sales_po po','pp.salesPo_id = po.id','left');

		if(!empty($start_date) && !empty($end_date)){
            $this->db2->where('pp.date_production >=',$start_date);
            $this->db2->where('pp.date_production <=',$end_date);
        }
        if(!empty($client_id)){
            $this->db2->where('po.client_id',$client_id);
        }
		
		$this->db2->join('penerima ps','po.client_id = ps.id','left');
		$this->db2->where("po.status in ('OPEN','CLOSED')");
		$this->db2->group_by('po.client_id');
		$this->db2->order_by('ps.nama','asc');
		$query = $this->db2->get('pmm_productions pp');

			$no = 1;
			if($query->num_rows() > 0){

				foreach ($query->result_array() as $key => $sups) {

					$mats = array();
					$materials = $this->pmm_model->GetLaporanPiutangTEMEF($sups['client_id'],$start_date,$end_date);
					if(!empty($materials)){
						foreach ($materials as $key => $row) {
							$arr['no'] = $key + 1;
                            $arr['nama_produk'] = $row['nama_produk'];
                            $arr['salesPo_id'] = $this->crud_global->GetField('pmm_sales_po',array('id'=>$row['salesPo_id']),'contract_number');
                            $arr['penerimaan'] = number_format($row['penerimaan'],0,',','.');
                            $arr['tagihan'] = number_format($row['tagihan'],0,',','.');
                            $arr['tagihan_bruto'] = number_format($row['tagihan_bruto'],0,',','.');
                            $arr['pembayaran'] = number_format($row['pembayaran'],0,',','.');
                            $arr['sisa_piutang_penerimaan'] = number_format($row['sisa_piutang_penerimaan'],0,',','.');
                            $arr['sisa_piutang_tagihan'] = number_format($row['sisa_piutang_tagihan'],0,',','.');

                            $total_penerimaan += $row['penerimaan'];
                            $total_tagihan += $row['tagihan'];
                            $total_tagihan_bruto += $row['tagihan_bruto'];
                            $total_pembayaran += $row['pembayaran'];
                            $total_sisa_piutang_penerimaan += $row['sisa_piutang_penerimaan'];
                            $total_sisa_piutang_tagihan += $row['sisa_piutang_tagihan'];
							
							$arr['name'] = $sups['name'];
							$mats[] = $arr;
						}
						$sups['mats'] = $mats;
						$sups['no'] =$no;

						$arr_data[] = $sups;
						$no++;
					}
				}
			}
			
			$data['data'] = $arr_data;
			$data['total_penerimaan'] = $total_penerimaan;
			$data['total_tagihan'] = $total_tagihan;
			$data['total_tagihan_bruto'] = $total_tagihan_bruto;
			$data['total_pembayaran'] = $total_pembayaran;
			$data['total_sisa_piutang_penerimaan'] = $total_sisa_piutang_penerimaan;
			$data['total_sisa_piutang_tagihan'] = $total_sisa_piutang_tagihan;
	        $html = $this->load->view('laporan_piutang_temef/cetak_laporan_piutang',$data,TRUE);

	        $pdf->SetTitle('BBJ - Laporan Piutang');
	        $pdf->nsi_html($html);
	        $pdf->Output('laporan-piutang.pdf', 'I');
	        
		}else {
			echo 'Please Filter Date First';
		}
	
	}

	public function cetak_laporan_piutang_sc()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
		$pdf->setPrintFooter(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');

		$arr_data = array();
		$client_id = $this->input->get('client_id');
		$start_date = false;
		$end_date = false;
		$total_penerimaan = 0;
		$total_tagihan = 0;
		$total_tagihan_bruto = 0;
		$total_pembayaran = 0;
		$total_sisa_piutang_penerimaan = 0;
		$total_sisa_piutang_tagihan = 0;
		$date = $this->input->get('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
			$filter_date = date('d F Y',strtotime($arr_date[0])).' - '.date('d F Y',strtotime($arr_date[1]));

			$data['filter_date'] = $filter_date;
			$data['date2'] = $end_date;
			$data['start_date'] = $start_date;
			$data['end_date'] = $end_date;

		$this->db3->select('po.id, po.client_id, ps.nama as name');
		$this->db3->join('pmm_sales_po po','pp.salesPo_id = po.id','left');

		if(!empty($start_date) && !empty($end_date)){
            $this->db3->where('pp.date_production >=',$start_date);
            $this->db3->where('pp.date_production <=',$end_date);
        }
        if(!empty($client_id)){
            $this->db3->where('po.client_id',$client_id);
        }
		
		$this->db3->join('penerima ps','po.client_id = ps.id','left');
		$this->db3->where("po.status in ('OPEN','CLOSED')");
		$this->db3->group_by('po.client_id');
		$this->db3->order_by('ps.nama','asc');
		$query = $this->db3->get('pmm_productions pp');

			$no = 1;
			if($query->num_rows() > 0){

				foreach ($query->result_array() as $key => $sups) {

					$mats = array();
					$materials = $this->pmm_model->GetLaporanPiutangSC($sups['client_id'],$start_date,$end_date);
					if(!empty($materials)){
						foreach ($materials as $key => $row) {
							$arr['no'] = $key + 1;
                            $arr['nama_produk'] = $row['nama_produk'];
                            $arr['salesPo_id'] = $this->crud_global->GetField('pmm_sales_po',array('id'=>$row['salesPo_id']),'contract_number');
                            $arr['penerimaan'] = number_format($row['penerimaan'],0,',','.');
                            $arr['tagihan'] = number_format($row['tagihan'],0,',','.');
                            $arr['tagihan_bruto'] = number_format($row['tagihan_bruto'],0,',','.');
                            $arr['pembayaran'] = number_format($row['pembayaran'],0,',','.');
                            $arr['sisa_piutang_penerimaan'] = number_format($row['sisa_piutang_penerimaan'],0,',','.');
                            $arr['sisa_piutang_tagihan'] = number_format($row['sisa_piutang_tagihan'],0,',','.');

                            $total_penerimaan += $row['penerimaan'];
                            $total_tagihan += $row['tagihan'];
                            $total_tagihan_bruto += $row['tagihan_bruto'];
                            $total_pembayaran += $row['pembayaran'];
                            $total_sisa_piutang_penerimaan += $row['sisa_piutang_penerimaan'];
                            $total_sisa_piutang_tagihan += $row['sisa_piutang_tagihan'];
							
							
							$arr['name'] = $sups['name'];
							$mats[] = $arr;
						}
						$sups['mats'] = $mats;
						$sups['no'] =$no;

						$arr_data[] = $sups;
						$no++;
					}
					
					
				}
			}

			$data['data'] = $arr_data;
			$data['total_penerimaan'] = $total_penerimaan;
			$data['total_tagihan'] = $total_tagihan;
			$data['total_tagihan_bruto'] = $total_tagihan_bruto;
			$data['total_pembayaran'] = $total_pembayaran;
			$data['total_sisa_piutang_penerimaan'] = $total_sisa_piutang_penerimaan;
			$data['total_sisa_piutang_tagihan'] = $total_sisa_piutang_tagihan;
	        $html = $this->load->view('laporan_piutang_sc/cetak_laporan_piutang',$data,TRUE);

	        $pdf->SetTitle('BBJ - Laporan Piutang');
	        $pdf->nsi_html($html);
	        $pdf->Output('laporan-piutang.pdf', 'I');
	        
		}else {
			echo 'Please Filter Date First';
		}
	
	}

	public function cetak_monitoring_piutang_temef()
	{
		$this->load->library('pdf');
	
		$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
		$pdf->setPrintFooter(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('L');

		$arr_data = array();
		$client_id = $this->input->get('client_id');
		$filter_kategori = $this->input->get('filter_kategori');
		$filter_status = $this->input->get('filter_status');
		$start_date = false;
		$end_date = false;
		$total_dpp_tagihan = 0;
		$total_ppn_tagihan = 0;
		$total_jumlah_tagihan = 0;
		$total_dpp_pembayaran = 0;
		$total_ppn_pembayaran = 0;
		$total_jumlah_pembayaran = 0;
		$total_dpp_sisa_piutang = 0;
		$total_ppn_sisa_piutang = 0;
		$total_jumlah_sisa_piutang = 0;
		$date = $this->input->get('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
			$filter_date = date('d F Y',strtotime($arr_date[0])).' - '.date('d F Y',strtotime($arr_date[1]));

			$data['filter_date'] = $filter_date;
			$data['date2'] = $end_date;

			$this->db2->select('ppp.id, ppp.client_id, ps.nama as name');
            $this->db2->join('penerima ps','ppp.client_id = ps.id','left');
            $this->db2->join('pmm_sales_po po','ppp.sales_po_id = po.id','left');

            if(!empty($start_date) && !empty($end_date)){
                $this->db2->where('ppp.tanggal_invoice >=',$start_date);
                $this->db2->where('ppp.tanggal_invoice <=',$end_date);
            }
            if(!empty($client_id) || $client_id != 0){
                $this->db2->where('ppp.client_id',$client_id);
            }
			if(!empty($filter_status) || $filter_status != 0){
                $this->db2->where('ppp.status_pembayaran',$filter_status);
            }
            
            $this->db2->group_by('ppp.client_id');
            $this->db2->order_by('ps.nama','asc');
            $query = $this->db2->get('pmm_penagihan_penjualan ppp');

			$no = 1;
			if($query->num_rows() > 0){

				foreach ($query->result_array() as $key => $sups) {

					$mats = array();
					$materials = $this->pmm_model->GetLaporanMonitoringPiutangTEMEF($sups['client_id'],$start_date,$end_date,$filter_kategori,$filter_status);
					if(!empty($materials)){
						foreach ($materials as $key => $row) {
							
							$awal  = date_create($row['status_umur_hutang']);
							$akhir = date_create($end_date);
							$diff  = date_diff($awal, $akhir);

							$arr['no'] = $key + 1;
                            $arr['nama'] = $row['nama'];
                            $arr['subject'] = $row['subject'];
                            $arr['status_pembayaran'] = $row['status_pembayaran'];
                            $arr['syarat_pembayaran'] = $diff->days;
                            $arr['nomor_invoice'] = $row['nomor_invoice'];
                            $arr['tanggal_invoice'] =  date('d-m-Y',strtotime($row['tanggal_invoice']));
                            $arr['dpp_tagihan'] = number_format($row['dpp_tagihan'],0,',','.');
                            $arr['ppn_tagihan'] = number_format($row['ppn_tagihan'],0,',','.');
                            $arr['jumlah_tagihan'] = number_format($row['jumlah_tagihan'],0,',','.');
                            $arr['dpp_pembayaran'] = number_format($row['dpp_pembayaran'],0,',','.');
                            $arr['ppn_pembayaran'] = number_format($row['ppn_pembayaran'],0,',','.');
                            $arr['jumlah_pembayaran'] = number_format($row['jumlah_pembayaran'],0,',','.');
                            $arr['dpp_sisa_piutang'] = number_format($row['dpp_sisa_piutang'],0,',','.');
                            $arr['ppn_sisa_piutang'] = number_format($row['ppn_sisa_piutang'],0,',','.');
                            $arr['jumlah_sisa_piutang'] = number_format($row['jumlah_sisa_piutang'],0,',','.');

							$total_dpp_tagihan += $row['dpp_tagihan'];
							$total_ppn_tagihan += $row['ppn_tagihan'];
							$total_jumlah_tagihan += $row['jumlah_tagihan'];
							$total_dpp_pembayaran += $row['dpp_pembayaran'];
							$total_ppn_pembayaran += $row['ppn_pembayaran'];
							$total_jumlah_pembayaran += $row['jumlah_pembayaran'];
							$total_dpp_sisa_piutang += $row['dpp_sisa_piutang'];
							$total_ppn_sisa_piutang += $row['ppn_sisa_piutang'];
							$total_jumlah_sisa_piutang += $row['jumlah_sisa_piutang'];
							
							
							$arr['name'] = $sups['name'];
							$mats[] = $arr;
						}
						$sups['mats'] = $mats;
						$sups['no'] =$no;

						$arr_data[] = $sups;
						$no++;
					}
				}
			}
			
			$data['data'] = $arr_data;
			$data['total_dpp_tagihan'] = $total_dpp_tagihan;
			$data['total_ppn_tagihan'] = $total_ppn_tagihan;
			$data['total_jumlah_tagihan'] = $total_jumlah_tagihan;
			$data['total_dpp_pembayaran'] = $total_dpp_pembayaran;
			$data['total_ppn_pembayaran'] = $total_ppn_pembayaran;
			$data['total_jumlah_pembayaran'] = $total_jumlah_pembayaran;
			$data['total_dpp_sisa_piutang'] = $total_dpp_sisa_piutang;
			$data['total_ppn_sisa_piutang'] = $total_ppn_sisa_piutang;
			$data['total_jumlah_sisa_piutang'] = $total_jumlah_sisa_piutang;
	        $html = $this->load->view('laporan_monitoring_piutang_temef/cetak_monitoring_piutang',$data,TRUE);
	        
	        $pdf->SetTitle('BBJ - Laporan Monitoring Piutang');
	        $pdf->nsi_html($html);
	        $pdf->Output('monitoring-piutang.pdf', 'I');
	        
		}else {
			echo 'Please Filter Date First';
		}
	
	}

	public function cetak_monitoring_piutang_sc()
	{
		$this->load->library('pdf');
	
		$pdf = new Pdf('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
		$pdf->setPrintFooter(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('L');

		$arr_data = array();
		$client_id = $this->input->get('client_id');
		$filter_kategori = $this->input->get('filter_kategori');
		$filter_status = $this->input->get('filter_status');
		$start_date = false;
		$end_date = false;
		$total_dpp_tagihan = 0;
		$total_ppn_tagihan = 0;
		$total_jumlah_tagihan = 0;
		$total_dpp_pembayaran = 0;
		$total_ppn_pembayaran = 0;
		$total_jumlah_pembayaran = 0;
		$total_dpp_sisa_piutang = 0;
		$total_ppn_sisa_piutang = 0;
		$total_jumlah_sisa_piutang = 0;
		$date = $this->input->get('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
			$filter_date = date('d F Y',strtotime($arr_date[0])).' - '.date('d F Y',strtotime($arr_date[1]));

			$data['filter_date'] = $filter_date;
			$data['date2'] = $end_date;

			$this->db3->select('ppp.id, ppp.client_id, ps.nama as name');
            $this->db3->join('penerima ps','ppp.client_id = ps.id','left');
            $this->db3->join('pmm_sales_po po','ppp.sales_po_id = po.id','left');

            if(!empty($start_date) && !empty($end_date)){
                $this->db3->where('ppp.tanggal_invoice >=',$start_date);
                $this->db3->where('ppp.tanggal_invoice <=',$end_date);
            }
            if(!empty($client_id) || $client_id != 0){
                $this->db3->where('ppp.client_id',$client_id);
            }
			if(!empty($filter_status) || $filter_status != 0){
                $this->db3->where('ppp.status_pembayaran',$filter_status);
            }
            
            $this->db3->group_by('ppp.client_id');
            $this->db3->order_by('ps.nama','asc');
            $query = $this->db3->get('pmm_penagihan_penjualan ppp');

			$no = 1;
			if($query->num_rows() > 0){

				foreach ($query->result_array() as $key => $sups) {

					$mats = array();
					$materials = $this->pmm_model->GetLaporanMonitoringPiutangSC($sups['client_id'],$start_date,$end_date,$filter_kategori,$filter_status);
					if(!empty($materials)){
						foreach ($materials as $key => $row) {
							
							$awal  = date_create($row['status_umur_hutang']);
							$akhir = date_create($end_date);
							$diff  = date_diff($awal, $akhir);

							$arr['no'] = $key + 1;
                            $arr['nama'] = $row['nama'];
                            $arr['subject'] = $row['subject'];
                            $arr['status_pembayaran'] = $row['status_pembayaran'];
                            $arr['syarat_pembayaran'] = $diff->days;
                            $arr['nomor_invoice'] = $row['nomor_invoice'];
                            $arr['tanggal_invoice'] =  date('d-m-Y',strtotime($row['tanggal_invoice']));
                            $arr['dpp_tagihan'] = number_format($row['dpp_tagihan'],0,',','.');
                            $arr['ppn_tagihan'] = number_format($row['ppn_tagihan'],0,',','.');
                            $arr['jumlah_tagihan'] = number_format($row['jumlah_tagihan'],0,',','.');
                            $arr['dpp_pembayaran'] = number_format($row['dpp_pembayaran'],0,',','.');
                            $arr['ppn_pembayaran'] = number_format($row['ppn_pembayaran'],0,',','.');
                            $arr['jumlah_pembayaran'] = number_format($row['jumlah_pembayaran'],0,',','.');
                            $arr['dpp_sisa_piutang'] = number_format($row['dpp_sisa_piutang'],0,',','.');
                            $arr['ppn_sisa_piutang'] = number_format($row['ppn_sisa_piutang'],0,',','.');
                            $arr['jumlah_sisa_piutang'] = number_format($row['jumlah_sisa_piutang'],0,',','.');

							$total_dpp_tagihan += $row['dpp_tagihan'];
							$total_ppn_tagihan += $row['ppn_tagihan'];
							$total_jumlah_tagihan += $row['jumlah_tagihan'];
							$total_dpp_pembayaran += $row['dpp_pembayaran'];
							$total_ppn_pembayaran += $row['ppn_pembayaran'];
							$total_jumlah_pembayaran += $row['jumlah_pembayaran'];
							$total_dpp_sisa_piutang += $row['dpp_sisa_piutang'];
							$total_ppn_sisa_piutang += $row['ppn_sisa_piutang'];
							$total_jumlah_sisa_piutang += $row['jumlah_sisa_piutang'];
							
							
							$arr['name'] = $sups['name'];
							$mats[] = $arr;
						}
						$sups['mats'] = $mats;
						$sups['no'] =$no;

						$arr_data[] = $sups;
						$no++;
					}
				}
			}
			
			$data['data'] = $arr_data;
			$data['total_dpp_tagihan'] = $total_dpp_tagihan;
			$data['total_ppn_tagihan'] = $total_ppn_tagihan;
			$data['total_jumlah_tagihan'] = $total_jumlah_tagihan;
			$data['total_dpp_pembayaran'] = $total_dpp_pembayaran;
			$data['total_ppn_pembayaran'] = $total_ppn_pembayaran;
			$data['total_jumlah_pembayaran'] = $total_jumlah_pembayaran;
			$data['total_dpp_sisa_piutang'] = $total_dpp_sisa_piutang;
			$data['total_ppn_sisa_piutang'] = $total_ppn_sisa_piutang;
			$data['total_jumlah_sisa_piutang'] = $total_jumlah_sisa_piutang;
	        $html = $this->load->view('laporan_monitoring_piutang_sc/cetak_monitoring_piutang',$data,TRUE);
	        
	        $pdf->SetTitle('BBJ - Laporan Monitoring Piutang');
	        $pdf->nsi_html($html);
	        $pdf->Output('monitoring-piutang.pdf', 'I');
	        
		}else {
			echo 'Please Filter Date First';
		}
	
	}

	public function cetak_daftar_penerimaan_temef()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetPrintHeader(true);
		$pdf->SetPrintFooter(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');
		
		$arr_data = array();
		$supplier_id = $this->input->get('client_id');
		$purchase_order_no = $this->input->get('purchase_order_no');
		$filter_material = $this->input->get('filter_material');
		$start_date = false;
		$end_date = false;
		$total = 0;
		$date = $this->input->get('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
			$filter_date = date('d F Y',strtotime($arr_date[0])).' - '.date('d F Y',strtotime($arr_date[1]));

			
			$data['filter_date'] = $filter_date;
		
		
		$this->db2->select('pmp.client_id, pmp.nama_pelanggan as nama, SUM(pmp.total) as total_bayar');
		if(!empty($start_date) && !empty($end_date)){
            $this->db2->where('pmp.tanggal_pembayaran >=',$start_date);
            $this->db2->where('pmp.tanggal_pembayaran <=',$end_date);
        }
        if(!empty($supplier_id)){
            $this->db2->where('pmp.client_id',$supplier_id);
        }
        if(!empty($filter_material)){
            $this->db2->where_in('ppd.material_id',$filter_material);
        }
        if(!empty($purchase_order_no)){
            $this->db2->where('pmp.penagihan_id',$purchase_order_no);
        }
		
		$this->db2->join('pmm_penagihan_penjualan ppp', 'pmp.penagihan_id = ppp.id','left');
		$this->db2->join('pmm_sales_po ppo', 'ppp.sales_po_id = ppo.id','left');
		$this->db2->where("ppo.status in ('OPEN','CLOSED')");
		$this->db2->group_by('pmp.client_id');
		$this->db2->order_by('pmp.nama_pelanggan','asc');
		$query = $this->db2->get('pmm_pembayaran pmp');
		
		$no = 1;
		if($query->num_rows() > 0){

			foreach ($query->result_array() as $key => $sups) {

				$mats = array();
				$materials = $this->pmm_model->GetDaftarPenerimaanTEMEF($sups['client_id'],$purchase_order_no,$start_date,$end_date,$filter_material);
				
				if(!empty($materials)){
					foreach ($materials as $key => $row) {
						$arr['no'] = $key + 1;
						$arr['tanggal_pembayaran'] =  date('d-m-Y',strtotime($row['tanggal_pembayaran']));
						$arr['nomor_transaksi'] = $row['nomor_transaksi'];
						$arr['tanggal_invoice'] = date('d-m-Y',strtotime($row['tanggal_invoice']));
						$arr['nomor_invoice'] = $row['nomor_invoice'];
						$arr['penerimaan'] = number_format($row['penerimaan'],0,',','.');								
						
						$arr['nama'] = $sups['nama'];
						$mats[] = $arr;
					}
					
					
					$sups['mats'] = $mats;
					$total += $sups['total_bayar'];
					$sups['no'] =$no;
					$sups['total_bayar'] = number_format($sups['total_bayar'],0,',','.');
					

					$arr_data[] = $sups;
					$no++;
					
					}	
					
					
				}
			}

			
			$data['data'] = $arr_data;
			$data['total'] = $total;
	        $html = $this->load->view('daftar_penerimaan_temef/cetak_daftar_penerimaan',$data,TRUE);

	        
	        $pdf->SetTitle('BBJ - Daftar Penerimaan');
	        $pdf->nsi_html($html);
	        $pdf->Output('daftar-penerimaan.pdf', 'I');
	        
		}else {
			echo 'Please Filter Date First';
		}
	
	}

	public function cetak_daftar_penerimaan_sc()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->SetPrintHeader(true);
		$pdf->SetPrintFooter(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');
		
		$arr_data = array();
		$supplier_id = $this->input->get('client_id');
		$purchase_order_no = $this->input->get('purchase_order_no');
		$filter_material = $this->input->get('filter_material');
		$start_date = false;
		$end_date = false;
		$total = 0;
		$date = $this->input->get('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
			$filter_date = date('d F Y',strtotime($arr_date[0])).' - '.date('d F Y',strtotime($arr_date[1]));

			
			$data['filter_date'] = $filter_date;
		
		
		$this->db3->select('pmp.client_id, pmp.nama_pelanggan as nama, SUM(pmp.total) as total_bayar');
		if(!empty($start_date) && !empty($end_date)){
            $this->db3->where('pmp.tanggal_pembayaran >=',$start_date);
            $this->db3->where('pmp.tanggal_pembayaran <=',$end_date);
        }
        if(!empty($supplier_id)){
            $this->db3->where('pmp.client_id',$supplier_id);
        }
        if(!empty($filter_material)){
            $this->db3->where_in('ppd.material_id',$filter_material);
        }
        if(!empty($purchase_order_no)){
            $this->db3->where('pmp.penagihan_id',$purchase_order_no);
        }
		
		$this->db3->join('pmm_penagihan_penjualan ppp', 'pmp.penagihan_id = ppp.id','left');
		$this->db3->join('pmm_sales_po ppo', 'ppp.sales_po_id = ppo.id','left');
		$this->db3->where("ppo.status in ('OPEN','CLOSED')");
		$this->db3->group_by('pmp.client_id');
		$this->db3->order_by('pmp.nama_pelanggan','asc');
		$query = $this->db3->get('pmm_pembayaran pmp');
		
		$no = 1;
		if($query->num_rows() > 0){

			foreach ($query->result_array() as $key => $sups) {

				$mats = array();
				$materials = $this->pmm_model->GetDaftarPenerimaanSC($sups['client_id'],$purchase_order_no,$start_date,$end_date,$filter_material);
				
				if(!empty($materials)){
					foreach ($materials as $key => $row) {
						$arr['no'] = $key + 1;
						$arr['tanggal_pembayaran'] =  date('d-m-Y',strtotime($row['tanggal_pembayaran']));
						$arr['nomor_transaksi'] = $row['nomor_transaksi'];
						$arr['tanggal_invoice'] = date('d-m-Y',strtotime($row['tanggal_invoice']));
						$arr['nomor_invoice'] = $row['nomor_invoice'];
						$arr['penerimaan'] = number_format($row['penerimaan'],0,',','.');								
						
						$arr['nama'] = $sups['nama'];
						$mats[] = $arr;
					}
					
					
					$sups['mats'] = $mats;
					$total += $sups['total_bayar'];
					$sups['no'] =$no;
					$sups['total_bayar'] = number_format($sups['total_bayar'],0,',','.');
					

					$arr_data[] = $sups;
					$no++;
					
					}	
					
					
				}
			}

			
			$data['data'] = $arr_data;
			$data['total'] = $total;
	        $html = $this->load->view('daftar_penerimaan_sc/cetak_daftar_penerimaan',$data,TRUE);

	        
	        $pdf->SetTitle('BBJ - Daftar Penerimaan');
	        $pdf->nsi_html($html);
	        $pdf->Output('daftar-penerimaan.pdf', 'I');
	        
		}else {
			echo 'Please Filter Date First';
		}
	
	}

	public function cetak_laporan_laba_rugi_temef()
	{
		$this->load->library('pdf');
	
		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true); 
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');

		$arr_date = $this->input->get('filter_date');
		if(empty($arr_date)){
			$filter_date = '-';
		}else {
			$arr_filter_date = explode(' - ', $arr_date);
			$start_date = date('Y-m-d',strtotime($arr_filter_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('d F Y',strtotime($arr_filter_date[0])).' - '.date('d F Y',strtotime($arr_filter_date[1]));
		}
		$data['filter_date'] = $filter_date;
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
        $html = $this->load->view('laba_rugi_temef/cetak_laporan_laba_rugi',$data,TRUE);
        
        $pdf->SetTitle('BBJ - Laporan Laba Rugi');
        $pdf->nsi_html($html);
        $pdf->Output('laporan-laba-rugi.pdf', 'I');
	
	}

	public function cetak_laba_rugi_int()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');

		$arr_date = $this->input->get('filter_date');
		if(empty($arr_date)){
			$filter_date = '-';
		}else {
			$arr_filter_date = explode(' - ', $arr_date);
			$start_date = date('Y-m-d',strtotime($arr_filter_date[0]));
    		$end_date = date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('d F Y',strtotime($arr_filter_date[0])).' - '.date('d F Y',strtotime($arr_filter_date[1]));
		}
		$data['filter_date'] = $filter_date;
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;
        $html = $this->load->view('laporan_keuangan/cetak_laba_rugi_int',$data,TRUE);

        
        $pdf->SetTitle('BBJ - Laporan Laba Rugi');
        $pdf->nsi_html($html);
        $pdf->Output('laporan_laba_rugi.pdf', 'I');
	
	}

}