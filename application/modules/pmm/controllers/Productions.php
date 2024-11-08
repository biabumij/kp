<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Productions extends Secure_Controller {
	private $db2;
    private $db3;

	public function __construct()
	{
        parent::__construct();
        // Your own constructor code
        $this->load->model(array('admin/m_admin','crud_global','m_themes','pages/m_pages','menu/m_menu','admin_access/m_admin_access','DB_model','member_back/m_member_back','m_member','pmm_model','admin/Templates','pmm_finance'));
        $this->load->library('enkrip');
		$this->load->library('filter');
		$this->load->library('waktu');
		$this->load->library('session');
		$this->db2 = $this->load->database('database2', TRUE);
		$this->db3 = $this->load->database('database3', TRUE);
		$this->m_admin->check_login();
	}	

	public function add()
	{	
		$check = $this->m_admin->check_login();
		if($check == true){
			$po_id =  $this->input->get('po_id');
			$data['po_id'] = $po_id;
			$client_id = $this->input->get('client_id');
			$data['client_id'] = $client_id;
			$data['clients'] = $this->db->select('id,nama')->order_by('nama','asc')->get_where('penerima',array('pelanggan'=>1))->result_array();
			$data['komposisi'] = $this->db->select('id, jobs_type,date_agregat')->order_by('date_agregat','desc')->get_where('pmm_agregat',array('status'=>'PUBLISH'))->result_array();
			$get_data = $this->db->get_where('pmm_sales_po',array('id'=>$po_id,'status'=>'OPEN'))->row_array();
			$data['contract_number'] = $this->db->get_where('pmm_sales_po',array('client_id'=>$get_data['client_id'],'status'=>'OPEN'))->result_array();
			$data['data'] = $get_data;
			$this->load->view('pmm/productions_add',$data);
			
		}else {
			redirect('admin');
		}
	}

	public function table()
	{	
		$data = array();
		$client_id = $this->input->post('client_id');
		$product_id = $this->input->post('product_id');
		$sales_po_id = $this->input->post('salesPo_id');
		$w_date = $this->input->post('filter_date');
		$date_now = date('Y-m-d');
		$awal_bulan = date('Y-m-01', strtotime('-1 months', strtotime($date_now)));
		$akhir_bulan = date('Y-m-d', strtotime($date_now));

		$this->db->select('*');
		if (!empty($client_id)) {
			$this->db->where('client_id', $client_id);
		}
		if(!empty($product_id)){
			$this->db->where('product_id',$product_id);
		}
		if(!empty($sales_po_id)){
			$this->db->where('salesPo_id',$sales_po_id);
		}
		if(!empty($w_date)){
			$arr_date = explode(' - ', $w_date);
			$start_date = $arr_date[0];
			$end_date = $arr_date[1];
			$this->db->where('date_production  >=',date('Y-m-d',strtotime($start_date)));	
			$this->db->where('date_production <=',date('Y-m-d',strtotime($end_date)));	
		}
		//$this->db->where("(date_production between '$awal_bulan' and '$akhir_bulan')");
		$this->db->where('status_payment','UNCREATED');
		$this->db->order_by('date_production','desc');
		$this->db->order_by('created_on','desc');
		$query = $this->db->get('pmm_productions');
		if($query->num_rows() > 0){
			foreach ($query->result_array() as $key => $row) {
				$row['no'] = $key+1;
				$row['status'] = $this->pmm_model->GetStatus($row['status']);
				$row['salesPo_id'] = $this->crud_global->GetField('pmm_sales_po',array('id'=>$row['salesPo_id']),'contract_number');
				$row['product_id'] = $this->crud_global->GetField('produk',array('id'=>$row['product_id']),'nama_produk');
				$row['client_id'] = $this->crud_global->GetField('penerima',array('id'=>$row['client_id']),'nama');
				$row['date_production'] =  date('d F Y',strtotime($row['date_production']));
				$row['volume'] = number_format($row['volume'],2,',','.');
				$row['measure'] = $row['measure'];
				$row['harga_satuan'] = number_format($row['harga_satuan'],0,',','.');
				$row['price'] = number_format($row['price'],0,',','.');
				$row['komposisi_id'] = $this->crud_global->GetField('pmm_agregat',array('id'=>$row['komposisi_id']),'jobs_type');
				$row['surat_jalan'] = '<a href="'.base_url().'uploads/surat_jalan_penjualan/'.$row['surat_jalan'].'" target="_blank">'.$row['surat_jalan'].'</a>';
				$row['edit_komposisi'] = '<a href="'.site_url().'pmm/productions/sunting_komposisi/'.$row['id'].'" class="btn btn-warning"><i class="fa fa-edit"></i> </a>';
				
				$edit = false;
				if($this->session->userdata('admin_group_id') == 1){
					$edit = '<a href="javascript:void(0);" onclick="EditData('.$row['id'].')" class="btn btn-primary"><i class="fa fa-edit"></i> </a>';			
				}
				if($this->session->userdata('admin_group_id') == 1 || $this->session->userdata('admin_group_id') == 5 || $this->session->userdata('admin_group_id') == 6 || $this->session->userdata('admin_group_id') == 16){
					$row['delete'] = $edit.'<a href="javascript:void(0);" onclick="DeleteData('.$row['id'].')" class="btn btn-danger"><i class="fa fa-close"></i> </a>';
				}else {
					$row['delete'] = '-';
				}
				
				$data[] = $row;
			}

		}
		echo json_encode(array('data'=>$data));
	}

	public function sunting_komposisi($id)
	{
		$check = $this->m_admin->check_login();
		if ($check == true) {

			$this->db->select('pp.*');
            $data['row'] = $this->db->get_where('pmm_productions pp', array('pp.id' => $id))->row_array();
			$data['komposisi'] = $this->db->select('id, jobs_type,date_agregat')->order_by('date_agregat','desc')->get_where('pmm_agregat',array('status'=>'PUBLISH'))->result_array();
			$this->load->view('penjualan/edit_komposisi', $data);
		} else {
			redirect('admin');
		}
	}

	public function total_pro()
	{	
		$data = array();
		$client_id = $this->input->post('client_id');
		$product_id = $this->input->post('product_id');
		$w_date = $this->input->post('filter_date');

		$this->db->select('SUM(volume) as total');
		$this->db->where('status !=','DELETED');
		if(!empty($client_id)){
			$this->db->where('client_id',$client_id);
		}
		if(!empty($product_id)){
			$this->db->where('product_id',$product_id);
		}
		if(!empty($w_date)){
			$arr_date = explode(' - ', $w_date);
			$start_date = $arr_date[0];
			$end_date = $arr_date[1];
			$this->db->where('date_production  >=',date('Y-m-d',strtotime($start_date)));	
			$this->db->where('date_production <=',date('Y-m-d',strtotime($end_date)));	
		}
		$this->db->order_by('date_production','desc');
		$query = $this->db->get('pmm_productions');
		if($query->num_rows() > 0){
			$row = $query->row_array();
			$data =  number_format($row['total'],2,',','.');
		}
		echo json_encode(array('data'=>$data));
	}


	function process()
	{
		$output['output'] = false;

		$this->db->trans_start(); # Starting Transaction
		$this->db->trans_strict(FALSE); # See Note 01. If you wish can remove as well 
		$production_id = 0;
		$id = $this->input->post('id');
		$sales_po_id = $this->input->post('po_penjualan');
		$komposisi_id = $this->input->post('komposisi_id');
		$product_id = $this->input->post('product_id');
		$volume = str_replace(',', '.', $this->input->post('volume'));
		$price = $this->pmm_model->GetPriceProductions($sales_po_id,$product_id,$volume);
		$no_production = $this->input->post('no_production');
		
		$surat_jalan = $this->input->post('surat_jalan_val');

		$config['upload_path']          = 'uploads/surat_jalan_penjualan/';
        $config['allowed_types']        = 'jpg|png|jpeg|JPG|PNG|JPEG|pdf';
	   
		$production = $this->db->get_where("pmm_productions",["no_production" => $no_production])->num_rows();

		$this->load->library('upload', $config);
		

		if ($production > 1) {
			$output['output'] = false;
			$output['err'] = 'No. Surat Jalan Telah Terdaftar !!';
		}else{
			if(isset($_FILES["data_lab"])){
				if($_FILES["data_lab"]["error"] == 0) {
					$config['file_name'] = $no_production.'_'.$_FILES["data_lab"]['name'];
					$this->upload->initialize($config);
					if (!$this->upload->do_upload('data_lab'))
					{
							$error = $this->upload->display_errors();
							$file = $error;
							$error_file = true;
					}else{
							$data_file = $this->upload->data();
							$file = $data_file['file_name'];
					}
				}
			}
			
	
			
			if($_FILES["surat_jalan"]["error"] == 0) {
				$config['file_name'] = $no_production.'_'.$_FILES["surat_jalan"]['name'];
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('surat_jalan'))
				{
						$error = $this->upload->display_errors();
						$file = $error;
						$error_file = true;
				}else{
						$data_file = $this->upload->data();
						$surat_jalan = $data_file['file_name'];
				}
			}
	
			$data = array(
				'date_production' => date('Y-m-d',strtotime($this->input->post('date'))),
				'no_production' => $no_production,
				'product_id' => $product_id,
				'tax_id' => $this->input->post('tax_id'),
				'client_id' => $this->input->post('client_id'),
				'no_production' => $this->input->post('no_production'),
				'volume' => $volume,
				'convert_value' => 1,
				'display_volume' => $volume,
				'measure' => $this->input->post('measure'),
				'convert_measure' => $this->input->post('measure'),
				'komposisi_id' => $this->input->post('komposisi_id'),
				'nopol_truck' => $this->input->post('nopol_truck'),
				'driver' => $this->input->post('driver'),
				'lokasi' => $this->input->post('lokasi'),
				'price' => $price,
				'salesPo_id' => $this->input->post('po_penjualan'),
				'status' => 'PUBLISH',
				'status_payment' => 'UNCREATED',
				'surat_jalan' => $surat_jalan,
				'memo' => $this->input->post('memo'),
				'harga_satuan' => $price /  $volume,
				'display_price' => $price,
				'display_harga_satuan' => $price /  $volume,
			);
	
	
			if(empty($id)){
				$data['created_by'] = $this->session->userdata('admin_id');
				$data['created_on'] = date('Y-m-d H:i:s');
				if($this->db->insert('pmm_productions',$data)){
					$production_id = $this->db->insert_id();
					
					// Insert COA
					$coa_description = 'Production Nomor '.$no_production;
					$this->pmm_finance->InsertTransactions(4,$coa_description,$price,0);

	
				}
			}else {
				$data['updated_by'] = $this->session->userdata('admin_id');
				$data['updated_on'] = date('Y-m-d H:i:s');
				$this->db->update('pmm_productions',$data,array('id'=>$id));
	
				$check_pro = $this->db->get_where('pmm_productions',array('id'=>$id,'product_id'=>$product_id))->num_rows();
				if($check_pro == 0){
				}
				
			}
	
			if ($this->db->trans_status() === FALSE) {
				# Something went wrong.
				$this->db->trans_rollback();
				$output['output'] = false;
			} 
			else {
				# Everything is Perfect. 
				# Committing data to the database.
				$this->db->trans_commit();
				$output['id'] = $production_id;
				$output['output'] = true;	
				// $output['no_production'] = $this->pmm_model->ProductionsNo();
			}

			
		}
        

		
		echo json_encode($output);
	}


	public function approve_po()
	{
		$output['output'] = false;
		$id = $this->input->post('id');
		if(!empty($id)){
			$data = array(
				'date_po' => date('Y-m-d',strtotime($this->input->post('date_po'))),
				'subject' => $this->input->post('subject'),
				'date_pkp' => date('Y-m-d',strtotime($this->input->post('date_pkp'))),
				'supplier_id' => $this->input->post('supplier_id'),
				'total' => $this->input->post('total'),
				'approved_by' => $this->session->userdata('admin_id'),
				'approved_on' => date('Y-m-d H:i:s'),
				'status' => 'PUBLISH'
			);
			if($this->db->update('pmm_productions',$data,array('id'=>$id))){
				$output['output'] = true;
				$output['url'] = site_url('admin/productions');
			}
		}
		echo json_encode($output);
	}

	public function get_composition()
	{
		$output['output'] = true;
		$product_id = $this->input->post('product_id');
		if(!empty($product_id)){
			$query = $this->db->select('id, product_id,composition_name as text')->get_where('pmm_composition',array('product_id'=>$product_id,'status'=>'PUBLISH'))->result_array();
			if(!empty($query)){
				$data = array();
				$data[0] = array('id'=>'','text'=>'Pilih Composition');
				foreach ($query as $key => $row) {

					$data[] = array('id'=>$row['id'],'text'=>$row['text']);
				}
				$output['output'] = true;
				$output['data'] = $data;
			}
		}
		echo json_encode($output);
	}

	public function get_po_products()
	{
		$output['output'] = true;
		$id = $this->input->post('id');
		if(!empty($id)){
			$client_id = $this->crud_global->GetField('pmm_sales_po',array('id'=>$id),'client_id');
			$query = $this->db->select('product_id')->get_where('pmm_sales_po_detail',array('sales_po_id'=>$id))->result_array();
			if(!empty($query)){
				$data = array();
				$data[0] = array('id'=>'','text'=>'Pilih Produk');
				foreach ($query as $key => $row) {
					$product_name = $this->crud_global->GetField('produk',array('id'=>$row['product_id']),'nama_produk');
					$data[] = array('id'=>$row['product_id'],'text'=>$product_name);
				}
				$output['products'] = $data;
			}
			$client = array();
			$client_name = $this->crud_global->GetField('penerima',array('id'=>$client_id),'nama');
			$client[0] = array('id'=>$client_id,'text'=>$client_name);
			$output['client'] = $client;
			$output['output'] = true;
		}
		echo json_encode($output);
	}

	public function get_po_penjualan(){

		$response = [
			'output' => true,
			'po' => null
		];

		try {

			$id = $this->input->post('id');

			$this->db->select('psp.id, psp.contract_number, psp.client_id');
			$this->db->from('pmm_sales_po psp');
			$this->db->where('psp.client_id = ' . intval($id));
			$this->db->where('psp.status','OPEN');
			$this->db->group_by('psp.id');
			$query = $this->db->get()->result_array();

			$data = [];
			//$data[0] = ['id'=>'','text'=>'Pilih No. Sales Order'];

			if (!empty($query)){
				foreach ($query as $row){
					$data[] = ['id' => $row['id'], 'text' => $row['contract_number']];
				}
			}

			$response['po'] = $data;

		} catch (Throwable $e){
			$response['output'] = false;
		} finally {
			echo json_encode($response);
		}
			
	}

	public function get_materials(){

		$response = [
			'output' => true,
			'po' => null
		];

		try {

			$id = $this->input->post('id');

			$this->db->select('p.id, p.nama_produk, pspd.measure, pspd.tax_id');
			$this->db->from('produk p ');
			$this->db->join('pmm_sales_po_detail pspd','p.id = pspd.product_id','left');
			$this->db->join('pmm_sales_po psp ','pspd.sales_po_id = psp.id','left');
			$this->db->where("psp.id = " . intval($id));
			$query = $this->db->get()->result_array();

			$data = [];
			//$data[0] = ['id'=>'','text'=>'Pilih Produk'];

			if (!empty($query)){
				foreach ($query as $row){
					$data[] = ['id' => $row['id'], 'text' => $row['nama_produk']];
					$tax_id[] = ['id' => $row['id'], 'text' => $row['tax_id']];
					$measure[] = ['id' => $row['id'], 'text' => $row['measure']];
				}
			}

			$response['products'] = $data;
			$response['measure'] = $measure;
			$response['tax_id'] = $tax_id;

		} catch (Throwable $e){
			$response['output'] = false;
		} finally {
			echo json_encode($response);
		}
			
	}

	public function get_pdf()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        // $pdf->set_header_title('Laporan'
		// $pdf->set_nsi_header(FALSE);
        $pdf->setPrintHeader(false);
        $pdf->SetTopMargin(0);
        $pdf->SetFont('helvetica','',7); 
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
        $pdf->AddPage('P');

        $id = $this->uri->segment(4);

		$row = $this->db->get_where('pmm_productions',array('id'=>$id))->row_array();
		$row['product'] = $this->crud_global->GetField('pmm_product',array('id'=>$row['product_id']),'product');
		$row['client'] = $this->crud_global->GetField('pmm_client',array('id'=>$row['client_id']),'client_name');
		$data['row'] = $row;
		$data['id'] = $id;
        $html = $this->load->view('pmm/productions_pdf',$data,TRUE);

        
        $pdf->SetTitle($row['no_production']);
        $pdf->nsi_html($html);
        $pdf->Output($row['no_production'].'.pdf', 'I');
	
	}

	public function delete()
	{
		$output['output'] = false;
		$id = $this->input->post('id');

		$file = $this->db->select('pp.surat_jalan')
		->from('pmm_productions pp')
		->where("pp.id = $id")
		->get()->row_array();

		$path = './uploads/surat_jalan_penjualan/'.$file['surat_jalan'];
		chmod($path, 0777);
		unlink($path);
		
		$this->db->delete('pmm_productions',array('id'=>$id));
		$output['output'] = true;
			
		
		echo json_encode($output);
	}

	public function table_dashboard()
	{
		$data = $this->pmm_model->DashboardProductions();

		echo json_encode(array('data'=>$data));
	}

	
	public function table_dashboard_mu()
	{
		$data = array();
		$arr_date = explode(' - ', $this->input->post('date'));
		$material = $this->input->post('material');

		$this->db->select('pm.material_name,pms.measure_name,pm.id');
		$this->db->join('pmm_measures pms','pm.measure = pms.id','left');
		if(!empty($material)){
			$this->db->where('pm.id',$material);
		}	
		$this->db->group_by('pm.id');
		$query = $this->db->get('pmm_materials pm');
		if($query->num_rows() > 0){
			foreach ($query->result_array() as $key => $row) {

				$this->db->select('SUM(pp.volume) as volume,ppm.koef');
				$this->db->join('pmm_productions pp','ppm.production_id = pp.id');
				if(!empty($arr_date)){
					$this->db->where('pp.date_production >=',date('Y-m-d',strtotime($arr_date[0])));
					$this->db->where('pp.date_production <=',date('Y-m-d',strtotime($arr_date[1])));
				}
				$this->db->where('pp.status','PUBLISH');
				$this->db->where('ppm.material_id',$row['id']);
				$get_volume = $this->db->get('pmm_production_material ppm')->row_array();

				$row['no'] = $key+1;
				$row['material_name'] = $row['material_name'].' <b>('.$row['measure_name'].')</b>';
				$total = $get_volume['volume'] * $get_volume['koef'];
				
				$total_pakai = $this->pmm_model->GetTotalSisa($row['id'],$arr_date[0]);
				$row['total'] = number_format($total_pakai - $total,2,',','.');
		  //       $pemakaian = $total_pakai * $row['koef'];
		        // $row['total'] = $pemakaian;
				$data[] = $row;
			}
		}

		echo json_encode(array('data'=>$data,'a'=>$arr_date));
	}


	function table_date()
	{
		$data = array();
		$client_id = $this->input->post('client_id');
		$filter_product = $this->input->post('filter_product');
		$start_date = false;
		$end_date = false;
		$date = $this->input->post('filter_date');
		$date_text = '';
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));

			$date_text = date('d F Y',strtotime($start_date)).' - '.date('d F Y',strtotime($end_date));
		}

		$arr_filter_prods = array();
		if(!empty($filter_product)){
			$query_mats = $this->db->select('id')->get_where('pmm_product',array('status'=>'PUBLISH','tag_id'=>$filter_product))->result_array();
			foreach ($query_mats as $key => $row) {
				$arr_filter_prods[] = $row['id'];
			}
		}

		// $products = $this->db->select('id,product')->get_where('pmm_product',array('status'=>'PUBLISH'))->result_array();
		$total_real = 0;
		$total_cost = 0;
		$no =1;


		$this->db->select('pc.client_name,pp.client_id, SUM(volume) as total, SUM(price) as cost');
		$this->db->join('pmm_client pc','pp.client_id = pc.id','left');
		if(!empty($start_date) && !empty($end_date)){
            $this->db->where('pp.date_production >=',$start_date);
            $this->db->where('pp.date_production <=',$end_date);
        }
        if(!empty($client_id)){
        	$this->db->where('pp.client_id',$client_id);
        }
        if(!empty($arr_filter_prods)){
        	$this->db->where_in('pp.product_id',$arr_filter_prods);
        }
		$this->db->where('pc.status','PUBLISH');
		$this->db->where('pp.status','PUBLISH');
		$this->db->group_by('pp.client_id');
		$clients = $this->db->get('pmm_productions pp')->result_array();
		if(!empty($clients)){
			foreach ($clients as $key => $row) {

				$this->db->select('SUM(pp.volume) as total, SUM(pp.price) as cost, pc.product');
		        $this->db->join('pmm_product pc','pp.product_id = pc.id','left');
		        if(!empty($start_date) && !empty($end_date)){
		            $this->db->where('pp.date_production >=',$start_date);
		            $this->db->where('pp.date_production <=',$end_date);
		        }
		        if(!empty($client_id)){
		            $this->db->where('pp.client_id',$client_id);
		        }
		        if(!empty($arr_filter_prods)){
		        	$this->db->where_in('pp.product_id',$arr_filter_prods);
		        }
		        $this->db->where('pp.client_id',$row['client_id']);
		        $this->db->where('pp.status','PUBLISH');
		        $this->db->where('pc.status','PUBLISH');
		        $this->db->group_by('pp.product_id');
		        $arr_products = $this->db->get_where('pmm_productions pp')->result_array();


				$arr['no'] = $no;
				$arr['products'] = $arr_products;
				$arr['total'] = $row['total'];
				$arr['cost'] = $row['cost'];
				$arr['client'] = $row['client_name'];
				$total_real += $row['total'];
				$total_cost += $row['cost'];
				$data[] = $arr;
				$no++;
			}
		}

		// foreach ($products as $key => $row) {
		// 	$get_real = $this->pmm_model->GetRealProd($row['id'],$start_date,$end_date,$client_id);
		// 	if($get_real['total'] > 0){
		// 		$arr_clients = $this->pmm_model->GetRealProdByClient($row['id'],$start_date,$end_date,$client_id);
		// 		
		// 	}
			
		// }

		echo json_encode(array('data'=>$data,'date_text'=> $date_text,'total_real'=>$total_real,'total_cost'=>$total_cost));	
	}

	function table_date2()
	{
		$data = array();
		$client_id = $this->input->post('client_id');
		$filter_product = $this->input->post('filter_product');
		$start_date = false;
		$end_date = false;
		$date = $this->input->post('filter_date');
		$date_text = '';
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));

			$date_text = date('d F Y',strtotime($start_date)).' - '.date('d F Y',strtotime($end_date));
		}
		
		$total_real = 0;
		$total_cost = 0;
		$no =1;


		$this->db->select('pc.nama,pp.client_id, SUM(volume) as total, SUM(price) as cost');
		$this->db->join('penerima pc','pp.client_id = pc.id and pc.pelanggan = 1','left');
		if(!empty($start_date) && !empty($end_date)){
            $this->db->where('pp.date_production >=',$start_date);
            $this->db->where('pp.date_production <=',$end_date);
        }
        if(!empty($client_id)){
        	$this->db->where('pp.client_id',$client_id);
        }
        if(!empty($filter_product)){
        	$this->db->where_in('pp.product_id',$filter_product);
        }
		$this->db->where('pc.status','PUBLISH');
		$this->db->where('pp.status','PUBLISH');
		$this->db->group_by('pp.client_id');
		$clients = $this->db->get('pmm_productions pp')->result_array();	
		
		if(!empty($clients)){
			foreach ($clients as $key => $row) {

				$this->db->select('SUM(pp.volume) as total, SUM(pp.price) / SUM(pp.volume) as price, SUM(pp.volume) * SUM(pp.price) / SUM(pp.volume) as cost, pc.nama_produk as product, pp.measure');
		        $this->db->join('produk pc','pp.product_id = pc.id','left');
				$this->db->join('pmm_sales_po po','pp.salesPo_id = po.id');
				//$this->db->join('pmm_sales_po_detail pod','po.id = pod.sales_po_id');
		        if(!empty($start_date) && !empty($end_date)){
		            $this->db->where('pp.date_production >=',$start_date);
		            $this->db->where('pp.date_production <=',$end_date);
		        }
		        if(!empty($client_id)){
		            $this->db->where('pp.client_id',$client_id);
		        }
		        if(!empty($filter_product)){
		        	$this->db->where_in('pp.product_id',$filter_product);
		        }
		        $this->db->where('pp.client_id',$row['client_id']);
		        $this->db->where('pp.status','PUBLISH');
		        $this->db->where('pc.status','PUBLISH');
		        $this->db->group_by('pp.product_id');
		        $arr_products = $this->db->get_where('pmm_productions pp')->result_array();
				

				$arr['no'] = $no;
				$arr['products'] = $arr_products;
				$arr['total'] = $row['total'];
				$arr['cost'] = $row['cost'];
				$arr['client'] = $row['nama'];
				$total_real += $row['total'];
				$total_cost += $row['cost'];
				$data[] = $arr;
				$no++;
			}
		}


		echo json_encode(array('data'=>$data,'date_text'=> $date_text,'total_real'=>$total_real,'total_cost'=>$total_cost));	
	}


	public function edit_data_detail()
	{
		$id = $this->input->post('id');

		$data = $this->db->get_where('pmm_productions prm',array('prm.id'=>$id))->row_array();
		$data['date_production'] = date('d-m-Y',strtotime($data['date_production']));
		echo json_encode(array('data'=>$data));		
	}

	public function print_pdf()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
        $pdf->SetTopMargin(5);
        $pdf->SetFont('helvetica','',7); 
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		        $pdf->AddPage('L');

		$w_date = $this->input->get('filter_date');
		$product_id = $this->input->get('product_id');
		$client_id = $this->input->get('client_id');
		$salesPo_id = $this->input->get('salesPo_id');
		$filter_date = false;

		$this->db->select('pp.*,pc.nama');
		if(!empty($client_id)){
			$this->db->where('pp.client_id',$client_id);
		}
		if(!empty($product_id) || $product_id != 0){
			$this->db->where('pp.product_id',$product_id);
		}
		if(!empty($salesPo_id) || $salesPo_id != 0){
			$this->db->where('pp.salesPo_id',$salesPo_id);
		}
		if(!empty($w_date)){
			$arr_date = explode(' - ', $w_date);
			$start_date = $arr_date[0];
			$end_date = $arr_date[1];
			$this->db->where('pp.date_production  >=',date('Y-m-d',strtotime($start_date)));	
			$this->db->where('pp.date_production <=',date('Y-m-d',strtotime($end_date)));	
			$filter_date = date('d F Y',strtotime($start_date)).' - '.date('d F Y',strtotime($end_date));
		}
		$this->db->join('penerima pc','pp.client_id = pc.id','left');
		$this->db->order_by('pp.date_production','asc');
		$this->db->order_by('pp.created_on','asc');
		$this->db->group_by('pp.id');
		$query = $this->db->get('pmm_productions pp');

		$data['data'] = $query->result_array();
		$data['filter_date'] = $filter_date;
        $html = $this->load->view('pmm/productions_print',$data,TRUE);

        
        $pdf->SetTitle('Rekap Pengiriman');
        $pdf->nsi_html($html);
        $pdf->Output('rekap_surat_jalan_penjualan.pdf', 'I');
	
	}

	function post_price()
	{
		$this->db->where('product_id !=',5);
		$arr = $this->db->get('pmm_productions');
		foreach ($arr->result_array() as $row) {
			$contract_price = $this->crud_global->GetField('pmm_product',array('id'=>$row['product_id']),'contract_price');
			$price = $row['volume'] * $contract_price;
			$this->db->update('pmm_productions',array('price'=>$price),array('id'=>$row['id']));
		}
	}
	
	//BATAS RUMUS LAMA//
	
	function pengiriman_penjualan()
	{
		$data = array();
		$filter_client_id = $this->input->post('filter_client_id');
		$purchase_order_no = $this->input->post('salesPo_id');
		$filter_product = $this->input->post('filter_product');
		$start_date = false;
		$end_date = false;
		$total_nilai = 0;
		$total_volume = 0;
		$date = $this->input->post('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
		}

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
		$this->db->join('pmm_productions pp','ppo.id = pp.salesPo_id','left');
		$this->db->where("ppo.status in ('OPEN','CLOSED')");
		$this->db->where('pp.status','PUBLISH');
		$this->db->group_by('ppo.client_id');
		$query = $this->db->get('pmm_sales_po ppo');
		
		$no = 1;
		if($query->num_rows() > 0){

			foreach ($query->result_array() as $key => $sups) {

				$mats = array();
				$materials = $this->pmm_model->GetPengirimanPenjualan($sups['client_id'],$purchase_order_no,$start_date,$end_date,$filter_product);
				if(!empty($materials)){
					foreach ($materials as $key => $row) {
						$arr['no'] = $key + 1;
						$arr['measure'] = $row['measure'];
						$arr['nama_produk'] = $row['nama_produk'];
						$arr['salesPo_id'] = '<a href="'.base_url().'penjualan/dataSalesPO/'.$row['salesPo_id'].'" target="_blank">'.$row['salesPo_id'] = $this->crud_global->GetField('pmm_sales_po',array('id'=>$row['salesPo_id']),'contract_number').'</a>';
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
					$sups['price'] = number_format($sups['price'],0,',','.');
					$sups['total_price'] = number_format($sups['total_price'],0,',','.');
					
					$data[] = $sups;
					$no++;
				}	
				
			}
		}

		echo json_encode(array('data'=>$data,
		'total_volume'=>number_format($total_volume,2,',','.'),
		'total_nilai'=>number_format($total_nilai,0,',','.')
	));		
	}

	function laporan_piutang()
	{
		$data = array();
		$client_id = $this->input->post('client_id');
		$start_date = false;
		$end_date = false;
		$total_penerimaan = 0;
		$total_tagihan = 0;
		$total_tagihan_bruto = 0;
		$total_pembayaran = 0;
		$total_sisa_piutang_penerimaan = 0;
		$total_sisa_piutang_tagihan = 0;
		$date = $this->input->post('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
		}

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
						$arr['salesPo_id'] = '<a href="'.base_url().'penjualan/dataSalesPO/'.$row['salesPo_id'].'" target="_blank">'.$row['salesPo_id'] = $this->crud_global->GetField('pmm_sales_po',array('id'=>$row['salesPo_id']),'contract_number').'</a>';
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

					$data[] = $sups;
					$no++;
				}
				
				
			}
		}

		echo json_encode(array('data'=>$data,
		'total_penerimaan'=>number_format($total_penerimaan,0,',','.'),
		'total_tagihan'=>number_format($total_tagihan,0,',','.'),
		'total_tagihan_bruto'=>number_format($total_tagihan_bruto,0,',','.'),
		'total_pembayaran'=>number_format($total_pembayaran,0,',','.'),
		'total_sisa_piutang_penerimaan'=>number_format($total_sisa_piutang_penerimaan,0,',','.'),
		'total_sisa_piutang_tagihan'=>number_format($total_sisa_piutang_tagihan,0,',','.')
	));	
	}

	function monitoring_piutang()
	{
		$data = array();
		$client_id = $this->input->post('client_id');
		$filter_kategori = $this->input->post('filter_kategori');
		$filter_status = $this->input->post('filter_status');
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
		$date = $this->input->post('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
		}

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
						$arr['syarat_pembayaran'] = $diff->days . '';
						$arr['nomor_invoice'] = '<a href="'.base_url().'penjualan/detailPenagihan/'.$row['id'].'" target="_blank">'.$row['nomor_invoice'].'</a>';
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

					$data[] = $sups;
					$no++;
				}
				
				
			}
		}

		echo json_encode(array('data'=>$data,
		'total_dpp_tagihan'=>number_format($total_dpp_tagihan,0,',','.'),
		'total_ppn_tagihan'=>number_format($total_ppn_tagihan,0,',','.'),
		'total_jumlah_tagihan'=>number_format($total_jumlah_tagihan,0,',','.'),
		'total_dpp_pembayaran'=>number_format($total_dpp_pembayaran,0,',','.'),
		'total_ppn_pembayaran'=>number_format($total_ppn_pembayaran,0,',','.'),
		'total_jumlah_pembayaran'=>number_format($total_jumlah_pembayaran,0,',','.'),
		'total_dpp_sisa_piutang'=>number_format($total_dpp_sisa_piutang,0,',','.'),
		'total_ppn_sisa_piutang'=>number_format($total_ppn_sisa_piutang,0,',','.'),
		'total_jumlah_sisa_piutang'=>number_format($total_jumlah_sisa_piutang,0,',','.')
	));	
	}

	public function cetak_surat_jalan()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
        $pdf->SetTopMargin(5);
        $pdf->SetFont('helvetica','',7); 
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		
		// add a page
		$pdf->AddPage('P');
		$pdf->setPrintHeader(false);
		$pdf->setPrintFooter(false);
		$pdf->SetY(45);
		$pdf->SetX(6);
		$pdf->SetMargins(10, 10);

		$w_date = $this->input->get('filter_date');
		$product_id = $this->input->get('product_id');
		$client_id = $this->input->get('supplier_id');
		$salesPo_id = $this->input->get('sales_po_id');
		$filter_date = false;

		$this->db->select('pp.*, pc.nama, p.nama_produk');
		if(!empty($client_id) || $client_id != 0){
			$this->db->where('pp.client_id',$client_id);
		}
		if(!empty($product_id) || $product_id != 0){
			$this->db->where('pp.product_id',$product_id);
		}
		if(!empty($salesPo_id) || $salesPo_id != 0){
			$this->db->where('pp.salesPo_id',$salesPo_id);
		}
		if(!empty($w_date)){
			$arr_date = explode(' - ', $w_date);
			$start_date = $arr_date[0];
			$end_date = $arr_date[1];
			$this->db->where('pp.date_production  >=',date('Y-m-d',strtotime($start_date)));	
			$this->db->where('pp.date_production <=',date('Y-m-d',strtotime($end_date)));	
			$filter_date = date('d F Y',strtotime($start_date)).' - '.date('d F Y',strtotime($end_date));
		}
		$this->db->join('penerima pc','pp.client_id = pc.id','left');
		$this->db->join('produk p','pp.product_id = p.id','left');
		$this->db->group_by('pp.id');
		$this->db->order_by('pp.date_production','asc');
		$this->db->order_by('p.nama_produk','asc');
		$this->db->order_by('pp.created_on','asc');
		$query = $this->db->get('pmm_productions pp');

		$data['data'] = $query->result_array();
		$data['filter_date'] = $filter_date;
		$data['salesPo_id'] = $salesPo_id;
        $html = $this->load->view('penjualan/cetak_surat_jalan',$data,TRUE);
        
        $pdf->SetTitle('Rekap Pengiriman');
        $pdf->nsi_html($html);
        $pdf->Output('rekap_surat_jalan_pengiriman.pdf', 'I');
	
	}

	function get_mat_penjualan()
	{
		$data = array();
		$sales_po_id = $this->input->post('sales_po_id');
		$this->db->select('pp.salesPo_id as po_id, pp.product_id as id_new, p.nama_produk');
		$this->db->from('pmm_productions pp');
		$this->db->join('produk p','pp.product_id = p.id','left');
		$this->db->where('pp.salesPo_id',$sales_po_id);
		$this->db->group_by('pp.product_id');
		$this->db->order_by('p.nama_produk','asc');
		$query = $this->db->get()->result_array();
		
		$data[0]['id'] = '0';
		$data[0]['text'] = 'Pilih Produk';
		if (!empty($query)){
			foreach ($query as $row){
				$data[] = ['id' => $row['id_new'], 'text' => $row['nama_produk']];
			}
		}
		
		echo json_encode(array('data'=>$data));
	}

	//RUMUS BARU
	public function pengiriman_penjualan_int($arr_date)
	{
		$data = array();
		
		$supplier_id = $this->input->post('supplier_id');

		$arr_date = $this->input->post('filter_date');
		$arr_filter_date = explode(' - ', $arr_date);
		$date3 = '';
		$date1 = '';
		$date2 = '';

		if(count($arr_filter_date) == 2){
			$date3 	= date('2020-01-01',strtotime($date3));
			$date1 	= date('Y-m-d',strtotime($arr_filter_date[0]));
			$date2 	= date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('Y-m-d',strtotime($arr_filter_date[0])).' - '.date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date_2 = date('Y-m-d',strtotime($date3)).' - '.date('Y-m-d',strtotime($arr_filter_date[1]));
		}
		
		?>
		
		<table class="table table-bordered" width="100%">
		 <style type="text/css">
			body {
				font-family: helvetica;
			}
			
			table tr.judul{
				background: linear-gradient(90deg, #333333 5%, #696969 50%, #333333 100%);
				color: #ffffff;
				font-size: 11px;
				font-weight: bold;
			}
				
			table tr.baris{
				background-color: #f4f4f4;
				font-size: 11px;
				font-weight: bold;
			}
				
			table tr.total{
				background-color: #eeeeee;
				font-size: 11px;
				font-weight: bold;
			}
		 </style>
		 <?php
		 //TEMEF
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

		 $this->db2->select('sum(pp.display_price) as nilai, ps.nama');
		 if(!empty($supplier_id)){
            $this->db2->where('ps.nama',$supplier_id);
         }
		 $this->db2->join('pmm_sales_po ppo','pp.salesPo_id = ppo.id','left');
		 $this->db2->join('penerima ps','ppo.client_id = ps.id','left');
		 $this->db2->where("(pp.date_production between '$date3' and '$date2')");
		 $this->db2->where('pp.status','PUBLISH');
       	 $this->db2->where("ppo.status in ('OPEN','CLOSED')");
		 $query = $this->db2->get('pmm_productions pp');
		 $pengiriman_penjualan_temef_all = $query->row_array();
		 $nilai_pengiriman_penjualan_temef_all =  $pengiriman_penjualan_temef_all['nilai'];

		 //SC
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

		 $this->db3->select('sum(pp.display_price) as nilai, ps.nama');
		 if(!empty($supplier_id)){
            $this->db3->where('ps.nama',$supplier_id);
         }
		 $this->db3->join('pmm_sales_po ppo','pp.salesPo_id = ppo.id','left');
		 $this->db3->join('penerima ps','ppo.client_id = ps.id','left');
		 $this->db3->where("(pp.date_production between '$date3' and '$date2')");
		 $this->db3->where('pp.status','PUBLISH');
       	 $this->db3->where("ppo.status in ('OPEN','CLOSED')");
		 $this->db3->where("pp.product_id in (3,4,7,8,9,14,24)");
		 $query = $this->db3->get('pmm_productions pp');
		 $pengiriman_penjualan_sc_all = $query->row_array();
		 $nilai_pengiriman_penjualan_sc_all =  $pengiriman_penjualan_sc_all['nilai'];
		 ?>
	        <tr class="judul">
	            <th class="text-left" width="5%">NO.</th>
				<th class="text-left">UNIT BISNIS / PROYEK</th>
	            <th class="text-right"><?php echo $filter_date = $filter_date = date('d/m/Y',strtotime($arr_filter_date[0])).' - '.date('d/m/Y',strtotime($arr_filter_date[1]));?></th>
				<th class="text-right">SD. <?php echo $filter_date_2 = date('d/m/Y',strtotime($arr_filter_date[1]));?></th>
	        </tr>
			<tr class="baris">
				<th class="text-left">1.</th>
				<th class="text-left">TEMEF</th>
				<th class="text-right"><a target="_blank" href="<?= base_url("admin/laporan_penjualan_temef?filter_date=".$filter_date = date('d-m-Y',strtotime($arr_filter_date[0])).' - '.date('d-m-Y',strtotime($arr_filter_date[1]))."&supplier_id=".$supplier_id) ?>"><?php echo number_format($nilai_pengiriman_penjualan_temef,0,',','.');?></a></th>
				<th class="text-right"><a target="_blank" href="<?= base_url("admin/laporan_penjualan_temef?filter_date=".$filter_date_2 = date('d-m-Y',strtotime($date3)).' - '.date('d-m-Y',strtotime($arr_filter_date[1]))."&supplier_id=".$supplier_id) ?>"><?php echo number_format($nilai_pengiriman_penjualan_temef_all,0,',','.');?></a></th>
	        </tr>
			<tr class="baris">
				<th class="text-left">2.</th>
				<th class="text-left">SC</th>
				<th class="text-right"><a target="_blank" href="<?= base_url("admin/laporan_penjualan_sc?filter_date=".$filter_date = date('d-m-Y',strtotime($arr_filter_date[0])).' - '.date('d-m-Y',strtotime($arr_filter_date[1]))."&supplier_id=".$supplier_id) ?>"><?php echo number_format($nilai_pengiriman_penjualan_sc,0,',','.');?></a></th>
				<th class="text-right"><a target="_blank" href="<?= base_url("admin/laporan_penjualan_sc?filter_date=".$filter_date_2 = date('d-m-Y',strtotime($date3)).' - '.date('d-m-Y',strtotime($arr_filter_date[1]))."&supplier_id=".$supplier_id) ?>"><?php echo number_format($nilai_pengiriman_penjualan_sc_all,0,',','.');?></a></th>
	        </tr>
			<tr class="total">
				<th class="text-right" colspan="2">GRAND TOTAL</th>
				<th class="text-right"><?php echo number_format($nilai_pengiriman_penjualan_temef + $nilai_pengiriman_penjualan_temef_all,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($nilai_pengiriman_penjualan_sc + $nilai_pengiriman_penjualan_sc_all,0,',','.');?></th>
	        </tr>
	    </table>
		<?php
	}

	function pengiriman_penjualan_temef()
	{
		$data = array();
		$filter_client_id = $this->input->post('filter_client_id');
		$purchase_order_no = $this->input->post('salesPo_id');
		$filter_product = $this->input->post('filter_product');
		$start_date = false;
		$end_date = false;
		$total_nilai = 0;
		$total_volume = 0;
		$date = $this->input->post('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
		}

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
		$this->db2->join('pmm_productions pp','ppo.id = pp.salesPo_id','left');
		$this->db2->where("ppo.status in ('OPEN','CLOSED')");
		$this->db2->where('pp.status','PUBLISH');
		$this->db2->group_by('ppo.client_id');
		$query = $this->db2->get('pmm_sales_po ppo');
		
		$no = 1;
		if($query->num_rows() > 0){

			foreach ($query->result_array() as $key => $sups) {

				$mats = array();
				$materials = $this->pmm_model->GetPengirimanPenjualanTEMEF($sups['client_id'],$purchase_order_no,$start_date,$end_date,$filter_product);
				if(!empty($materials)){
					foreach ($materials as $key => $row) {
						$arr['no'] = $key + 1;
						$arr['measure'] = $row['measure'];
						$arr['nama_produk'] = $row['nama_produk'];
						$arr['salesPo_id'] = '<a href="'.base_url().'penjualan/dataSalesPO/'.$row['salesPo_id'].'" target="_blank">'.$row['salesPo_id'] = $this->crud_global->GetField('pmm_sales_po',array('id'=>$row['salesPo_id']),'contract_number').'</a>';
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
					$sups['price'] = number_format($sups['price'],0,',','.');
					$sups['total_price'] = number_format($sups['total_price'],0,',','.');
					
					$data[] = $sups;
					$no++;
				}	
				
			}
		}

		echo json_encode(array('data'=>$data,
		'total_volume'=>number_format($total_volume,2,',','.'),
		'total_nilai'=>number_format($total_nilai,0,',','.')
	));		
	}

	function table_date_lap_penjualan_sc()
	{
		$data = array();
		$filter_client_id = $this->input->post('filter_client_id');
		$purchase_order_no = $this->input->post('salesPo_id');
		$filter_product = $this->input->post('filter_product');
		$start_date = false;
		$end_date = false;
		$total_nilai = 0;
		$total_volume = 0;
		$date = $this->input->post('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
		}

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
						$arr['salesPo_id'] = '<a href="'.base_url().'penjualan/dataSalesPO/'.$row['salesPo_id'].'" target="_blank">'.$row['salesPo_id'] = $this->crud_global->GetField('pmm_sales_po',array('id'=>$row['salesPo_id']),'contract_number').'</a>';
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
					
					$data[] = $sups;
					$no++;
				}
			}
		}

		echo json_encode(array('data'=>$data,
		'total_volume'=>number_format($total_volume,2,',','.'),
		'total_nilai'=>number_format($total_nilai,0,',','.')
	));	
	}

	public function laporan_piutang_int($arr_date)
	{
		$data = array();
		
		$supplier_id = $this->input->post('supplier_id');

		$arr_date = $this->input->post('filter_date');
		$arr_filter_date = explode(' - ', $arr_date);
		$date3 = '';
		$date1 = '';
		$date2 = '';

		if(count($arr_filter_date) == 2){
			$date3 	= date('2020-01-01',strtotime($date3));
			$date1 	= date('Y-m-d',strtotime($arr_filter_date[0]));
			$date2 	= date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('Y-m-d',strtotime($arr_filter_date[0])).' - '.date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date_2 = date('Y-m-d',strtotime($date3)).' - '.date('Y-m-d',strtotime($arr_filter_date[1]));
		}
		
		?>
		
		<table class="table table-bordered" width="100%">
		 <style type="text/css">
			body {
				font-family: helvetica;
			}
			
			table tr.judul{
				background: linear-gradient(90deg, #333333 5%, #696969 50%, #333333 100%);
				color: #ffffff;
				font-size: 11px;
				font-weight: bold;
			}
				
			table tr.baris{
				background-color: #f4f4f4;
				font-size: 11px;
				font-weight: bold;
			}
				
			table tr.total{
				background-color: #eeeeee;
				font-size: 11px;
				font-weight: bold;
			}
		 </style>
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
	        <tr class="judul">
	            <th class="text-left" width="5%" rowspan="2" style="vertical-align:middle;">NO.</th>
				<th class="text-left" rowspan="2" style="vertical-align:middle;">UNIT BISNIS / PROYEK</th>
				<th class="text-right" rowspan="2" style="vertical-align:middle;">PENERIMAAN</th>
				<th class="text-right" rowspan="2" style="vertical-align:middle;">TAGIHAN</th>
				<th class="text-right" rowspan="2" style="vertical-align:middle;">TAGIHAN BRUTO</th>
				<th class="text-right" rowspan="2" style="vertical-align:middle;">PEMBAYARAN</th>
	            <th class="text-right" colspan="2">SISA HUTANG</th>
	        </tr>
			<tr class="judul">
	            <th class="text-right">PENERIMAAN</th>
				<th class="text-right">INVOICE</th>
	        </tr>
			<tr class="baris">
				<th class="text-left">1.</th>
				<th class="text-left"><a target="_blank" href="<?= base_url("admin/laporan_piutang_temef?filter_date=".$filter_date = date('d-m-Y',strtotime($arr_filter_date[0])).' - '.date('d-m-Y',strtotime($arr_filter_date[1]))."&supplier_id=".$supplier_id) ?>">TEMEF</a></th>
				<th class="text-right"><?php echo number_format($nilai_pengiriman_penjualan_temef,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($nilai_tagihan_penjualan_temef,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($nilai_tagihan_bruto_temef,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($nilai_pembayaran_penjualan_temef,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($nilai_piutang_penerimaan_temef,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($nilai_piutang_invoice_temef,0,',','.');?></th>
	        </tr>
			<tr class="baris">
				<th class="text-left">2.</th>
				<th class="text-left"><a target="_blank" href="<?= base_url("admin/laporan_piutang_sc?filter_date=".$filter_date = date('d-m-Y',strtotime($arr_filter_date[0])).' - '.date('d-m-Y',strtotime($arr_filter_date[1]))."&supplier_id=".$supplier_id) ?>">SC</a></th>
				<th class="text-right"><?php echo number_format($nilai_pengiriman_penjualan_sc,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($nilai_tagihan_penjualan_sc,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($nilai_tagihan_bruto_sc,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($nilai_pembayaran_penjualan_sc,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($nilai_piutang_penerimaan_sc,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($nilai_piutang_invoice_sc,0,',','.');?></th>
	        </tr>
			<tr class="total">
				<th class="text-right" colspan="2">GRAND TOTAL</th>
				<th class="text-right"><?php echo number_format($nilai_pengiriman_penjualan_temef + $nilai_pengiriman_penjualan_sc,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($nilai_tagihan_penjualan_temef + $nilai_tagihan_penjualan_sc,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($nilai_tagihan_bruto_temef + $nilai_tagihan_bruto_sc,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($nilai_pembayaran_penjualan_temef + $nilai_pembayaran_penjualan_sc,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($nilai_piutang_penerimaan_temef + $nilai_piutang_penerimaan_sc,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($nilai_piutang_invoice_temef + $nilai_piutang_invoice_sc,0,',','.');?></th>
	        </tr>
	    </table>
		<?php
	}

	function laporan_piutang_temef()
	{
		$data = array();
		$client_id = $this->input->post('client_id');
		$start_date = false;
		$end_date = false;
		$total_penerimaan = 0;
		$total_tagihan = 0;
		$total_tagihan_bruto = 0;
		$total_pembayaran = 0;
		$total_sisa_piutang_penerimaan = 0;
		$total_sisa_piutang_tagihan = 0;
		$date = $this->input->post('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
		}

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
						$arr['salesPo_id'] = '<a href="'.base_url().'penjualan/dataSalesPO/'.$row['salesPo_id'].'" target="_blank">'.$row['salesPo_id'] = $this->crud_global->GetField('pmm_sales_po',array('id'=>$row['salesPo_id']),'contract_number').'</a>';
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

					$data[] = $sups;
					$no++;
				}
				
				
			}
		}

		echo json_encode(array('data'=>$data,
		'total_penerimaan'=>number_format($total_penerimaan,0,',','.'),
		'total_tagihan'=>number_format($total_tagihan,0,',','.'),
		'total_tagihan_bruto'=>number_format($total_tagihan_bruto,0,',','.'),
		'total_pembayaran'=>number_format($total_pembayaran,0,',','.'),
		'total_sisa_piutang_penerimaan'=>number_format($total_sisa_piutang_penerimaan,0,',','.'),
		'total_sisa_piutang_tagihan'=>number_format($total_sisa_piutang_tagihan,0,',','.')
	));	
	}

	function laporan_piutang_sc()
	{
		$data = array();
		$client_id = $this->input->post('client_id');
		$start_date = false;
		$end_date = false;
		$total_penerimaan = 0;
		$total_tagihan = 0;
		$total_tagihan_bruto = 0;
		$total_pembayaran = 0;
		$total_sisa_piutang_penerimaan = 0;
		$total_sisa_piutang_tagihan = 0;
		$date = $this->input->post('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
		}

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
						$arr['salesPo_id'] = '<a href="'.base_url().'penjualan/dataSalesPO/'.$row['salesPo_id'].'" target="_blank">'.$row['salesPo_id'] = $this->crud_global->GetField('pmm_sales_po',array('id'=>$row['salesPo_id']),'contract_number').'</a>';
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

					$data[] = $sups;
					$no++;
				}
			}
		}

		echo json_encode(array('data'=>$data,
		'total_penerimaan'=>number_format($total_penerimaan,0,',','.'),
		'total_tagihan'=>number_format($total_tagihan,0,',','.'),
		'total_tagihan_bruto'=>number_format($total_tagihan_bruto,0,',','.'),
		'total_pembayaran'=>number_format($total_pembayaran,0,',','.'),
		'total_sisa_piutang_penerimaan'=>number_format($total_sisa_piutang_penerimaan,0,',','.'),
		'total_sisa_piutang_tagihan'=>number_format($total_sisa_piutang_tagihan,0,',','.')
	));	
	}

	function monitoring_piutang_sc()
	{
		$data = array();
		$client_id = $this->input->post('client_id');
		$filter_kategori = $this->input->post('filter_kategori');
		$filter_status = $this->input->post('filter_status');
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
		$date = $this->input->post('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
		}

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
						$arr['syarat_pembayaran'] = $diff->days . '';
						$arr['nomor_invoice'] = '<a href="'.base_url().'penjualan/detailPenagihan/'.$row['id'].'" target="_blank">'.$row['nomor_invoice'].'</a>';
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

					$data[] = $sups;
					$no++;
				}
				
				
			}
		}

		echo json_encode(array('data'=>$data,
		'total_dpp_tagihan'=>number_format($total_dpp_tagihan,0,',','.'),
		'total_ppn_tagihan'=>number_format($total_ppn_tagihan,0,',','.'),
		'total_jumlah_tagihan'=>number_format($total_jumlah_tagihan,0,',','.'),
		'total_dpp_pembayaran'=>number_format($total_dpp_pembayaran,0,',','.'),
		'total_ppn_pembayaran'=>number_format($total_ppn_pembayaran,0,',','.'),
		'total_jumlah_pembayaran'=>number_format($total_jumlah_pembayaran,0,',','.'),
		'total_dpp_sisa_piutang'=>number_format($total_dpp_sisa_piutang,0,',','.'),
		'total_ppn_sisa_piutang'=>number_format($total_ppn_sisa_piutang,0,',','.'),
		'total_jumlah_sisa_piutang'=>number_format($total_jumlah_sisa_piutang,0,',','.')
	));	
	}

	public function monitoring_piutang_int($arr_date)
	{
		$data = array();
		
		$supplier_id = $this->input->post('supplier_id');

		$arr_date = $this->input->post('filter_date');
		$arr_filter_date = explode(' - ', $arr_date);
		$date3 = '';
		$date1 = '';
		$date2 = '';

		if(count($arr_filter_date) == 2){
			$date3 	= date('2020-01-01',strtotime($date3));
			$date1 	= date('Y-m-d',strtotime($arr_filter_date[0]));
			$date2 	= date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('Y-m-d',strtotime($arr_filter_date[0])).' - '.date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date_2 = date('Y-m-d',strtotime($date3)).' - '.date('Y-m-d',strtotime($arr_filter_date[1]));
		}
		
		?>
		
		<table class="table table-bordered" width="100%">
		 <style type="text/css">
			body {
				font-family: helvetica;
			}
			
			table tr.judul{
				background: linear-gradient(90deg, #333333 5%, #696969 50%, #333333 100%);
				color: #ffffff;
				font-size: 11px;
				font-weight: bold;
			}
				
			table tr.baris{
				background-color: #f4f4f4;
				font-size: 11px;
				font-weight: bold;
			}
				
			table tr.total{
				background-color: #eeeeee;
				font-size: 11px;
				font-weight: bold;
			}
		 </style>
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
	        <tr class="judul">
	            <th class="text-left" width="5%" rowspan="2" style="vertical-align:middle;">NO.</th>
				<th class="text-left" rowspan="2" style="vertical-align:middle;">UNIT BISNIS / PROYEK</th>
	            <th class="text-right" colspan="3">TAGIHAN</th>
				<th class="text-right" colspan="3">PENERIMAAN</th>
				<th class="text-right" colspan="3">SISA PIUTANG</th>
	        </tr>
			<tr class="judul">
	            <th class="text-right">DPP</th>
				<th class="text-right">PPN</th>
				<th class="text-right">JUMLAH</th>
				<th class="text-right">DPP</th>
				<th class="text-right">PPN</th>
				<th class="text-right">JUMLAH</th>
				<th class="text-right">DPP</th>
				<th class="text-right">PPN</th>
				<th class="text-right">JUMLAH</th>
	        </tr>
			<tr class="baris">
				<th class="text-left">1.</th>
				<th class="text-left"><a target="_blank" href="<?= base_url("admin/laporan_monitoring_piutang_temef?filter_date=".$filter_date = date('d-m-Y',strtotime($arr_filter_date[0])).' - '.date('d-m-Y',strtotime($arr_filter_date[1]))."&supplier_id=".$supplier_id) ?>">TEMEF</a></</th>
				<th class="text-right"><?php echo number_format($nilai_dpp_tagihan_penjualan_temef,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($nilai_ppn_tagihan_penjualan_temef,0,',','.');?><th>
				<th class="text-right"><?php echo number_format($nilai_tagihan_penjualan_temef,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($nilai_pembayaran_dpp_penjualan_temef,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($nilai_pembayaran_ppn_penjualan_temef,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($nilai_pembayaran_penjualan_temef,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($dpp_sisa_piutang_temef,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($ppn_sisa_piutang_temef,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($jumlah_sisa_piutang_temef,0,',','.');?></th>
	        </tr>
			<tr class="baris">
				<th class="text-left">2.</th>
				<th class="text-left"><a target="_blank" href="<?= base_url("admin/laporan_monitoring_piutang_sc?filter_date=".$filter_date = date('d-m-Y',strtotime($arr_filter_date[0])).' - '.date('d-m-Y',strtotime($arr_filter_date[1]))."&supplier_id=".$supplier_id) ?>">SC</a></th>
				<th class="text-right"><?php echo number_format($nilai_dpp_tagihan_penjualan_sc,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($nilai_ppn_tagihan_penjualan_sc,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($nilai_tagihan_penjualan_sc,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($nilai_pembayaran_dpp_penjualan_sc,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($nilai_pembayaran_ppn_penjualan_sc,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($nilai_pembayaran_penjualan_sc,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($dpp_sisa_piutang_sc,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($ppn_sisa_piutang_sc,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($jumlah_sisa_piutang_sc,0,',','.');?></th>
	        </tr>
			<tr class="total">
				<th class="text-right" colspan="2">GRAND TOTAL</th>
				<th class="text-right"><?php echo number_format($nilai_dpp_tagihan_penjualan_temef + $nilai_dpp_tagihan_penjualan_sc,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($nilai_ppn_tagihan_penjualan_temef + $nilai_ppn_tagihan_penjualan_sc,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($nilai_tagihan_penjualan_temef + $nilai_tagihan_penjualan_sc,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($nilai_pembayaran_dpp_penjualan_temef + $nilai_pembayaran_dpp_penjualan_sc,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($nilai_pembayaran_ppn_penjualan_temef + $nilai_pembayaran_ppn_penjualan_sc,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($nilai_pembayaran_penjualan_temef + $nilai_pembayaran_penjualan_sc,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($dpp_sisa_piutang_temef + $dpp_sisa_piutang_sc,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($ppn_sisa_piutang_temef + $ppn_sisa_piutang_sc,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($jumlah_sisa_piutang_temef + $jumlah_sisa_piutang_sc,0,',','.');?></th>
	        </tr>
	    </table>
		<?php
	}

	function monitoring_piutang_temef()
	{
		$data = array();
		$client_id = $this->input->post('client_id');
		$filter_kategori = $this->input->post('filter_kategori');
		$filter_status = $this->input->post('filter_status');
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
		$date = $this->input->post('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
		}

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
						$arr['syarat_pembayaran'] = $diff->days . '';
						$arr['nomor_invoice'] = '<a href="'.base_url().'penjualan/detailPenagihan/'.$row['id'].'" target="_blank">'.$row['nomor_invoice'].'</a>';
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

					$data[] = $sups;
					$no++;
				}
				
				
			}
		}

		echo json_encode(array('data'=>$data,
		'total_dpp_tagihan'=>number_format($total_dpp_tagihan,0,',','.'),
		'total_ppn_tagihan'=>number_format($total_ppn_tagihan,0,',','.'),
		'total_jumlah_tagihan'=>number_format($total_jumlah_tagihan,0,',','.'),
		'total_dpp_pembayaran'=>number_format($total_dpp_pembayaran,0,',','.'),
		'total_ppn_pembayaran'=>number_format($total_ppn_pembayaran,0,',','.'),
		'total_jumlah_pembayaran'=>number_format($total_jumlah_pembayaran,0,',','.'),
		'total_dpp_sisa_piutang'=>number_format($total_dpp_sisa_piutang,0,',','.'),
		'total_ppn_sisa_piutang'=>number_format($total_ppn_sisa_piutang,0,',','.'),
		'total_jumlah_sisa_piutang'=>number_format($total_jumlah_sisa_piutang,0,',','.')
	));	
	}

	public function daftar_penerimaan_int($arr_date)
	{
		$data = array();
		
		$supplier_id = $this->input->post('supplier_id');

		$arr_date = $this->input->post('filter_date');
		$arr_filter_date = explode(' - ', $arr_date);
		$date3 = '';
		$date1 = '';
		$date2 = '';

		if(count($arr_filter_date) == 2){
			$date3 	= date('2020-01-01',strtotime($date3));
			$date1 	= date('Y-m-d',strtotime($arr_filter_date[0]));
			$date2 	= date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('Y-m-d',strtotime($arr_filter_date[0])).' - '.date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date_2 = date('Y-m-d',strtotime($date3)).' - '.date('Y-m-d',strtotime($arr_filter_date[1]));
		}
		
		?>
		
		<table class="table table-bordered" width="100%">
		 <style type="text/css">
			body {
				font-family: helvetica;
			}
			
			table tr.judul{
				background: linear-gradient(90deg, #333333 5%, #696969 50%, #333333 100%);
				color: #ffffff;
				font-size: 11px;
				font-weight: bold;
			}
				
			table tr.baris{
				background-color: #f4f4f4;
				font-size: 11px;
				font-weight: bold;
			}
				
			table tr.total{
				background-color: #eeeeee;
				font-size: 11px;
				font-weight: bold;
			}
		 </style>
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
	        <tr class="judul">
	            <th class="text-left" width="5%">NO.</th>
				<th class="text-left">UNIT BISNIS / PROYEK</th>
	            <th class="text-right"><?php echo $filter_date = $filter_date = date('d/m/Y',strtotime($arr_filter_date[0])).' - '.date('d/m/Y',strtotime($arr_filter_date[1]));?></th>
				<th class="text-right">SD. <?php echo $filter_date_2 = date('d/m/Y',strtotime($arr_filter_date[1]));?></th>
	        </tr>
			<tr class="baris">
				<th class="text-left">1.</th>
				<th class="text-left">TEMEF</th>
				<th class="text-right"><a target="_blank" href="<?= base_url("admin/daftar_penerimaan_temef?filter_date=".$filter_date = date('d-m-Y',strtotime($arr_filter_date[0])).' - '.date('d-m-Y',strtotime($arr_filter_date[1]))."&supplier_id=".$supplier_id) ?>"><?php echo number_format($nilai_daftar_penerimaan_temef,0,',','.');?></a></th>
				<th class="text-right"><a target="_blank" href="<?= base_url("admin/daftar_penerimaan_temef?filter_date=".$filter_date_2 = date('d-m-Y',strtotime($date3)).' - '.date('d-m-Y',strtotime($arr_filter_date[1]))."&supplier_id=".$supplier_id) ?>"><?php echo number_format($nilai_daftar_penerimaan_temef_all,0,',','.');?></a></th>
	        </tr>
			<tr class="baris">
				<th class="text-left">2.</th>
				<th class="text-left">SC</th>
				<th class="text-right"><a target="_blank" href="<?= base_url("admin/daftar_penerimaan_sc?filter_date=".$filter_date = date('d-m-Y',strtotime($arr_filter_date[0])).' - '.date('d-m-Y',strtotime($arr_filter_date[1]))."&supplier_id=".$supplier_id) ?>"><?php echo number_format($nilai_daftar_penerimaan_sc,0,',','.');?></a></th>
				<th class="text-right"><a target="_blank" href="<?= base_url("admin/daftar_penerimaan_sc?filter_date=".$filter_date_2 = date('d-m-Y',strtotime($date3)).' - '.date('d-m-Y',strtotime($arr_filter_date[1]))."&supplier_id=".$supplier_id) ?>"><?php echo number_format($nilai_daftar_penerimaan_sc_all,0,',','.');?></a></th>
	        </tr>
			<tr class="total">
				<th class="text-right" colspan="2">GRAND TOTAL</th>
				<th class="text-right"><?php echo number_format($nilai_daftar_penerimaan_temef + $nilai_daftar_penerimaan_sc,0,',','.');?></th>
				<th class="text-right"><?php echo number_format($nilai_daftar_penerimaan_temef_all + $nilai_daftar_penerimaan_sc_all,0,',','.');?></th>
	        </tr>
	    </table>
		<?php
	}

	function daftar_penerimaan_temef()
	{
		$data = array();
		$supplier_id = $this->input->post('supplier_name');
		$purchase_order_no = $this->input->post('purchase_order_no');
		$filter_material = $this->input->post('filter_material');
		$start_date = false;
		$end_date = false;
		$total = 0;
		$date = $this->input->post('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
		}
		
		$this->db2->select('pmp.client_id, pmp.nama_pelanggan as nama, SUM(pmp.total) AS total_bayar');
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
					

					$data[] = $sups;
					$no++;
					
				}		
				
			}
		}

		echo json_encode(array('data'=>$data,'total'=>number_format($total,0,',','.')));	
	}

	function daftar_penerimaan_sc()
	{
		$data = array();
		$supplier_id = $this->input->post('supplier_name');
		$purchase_order_no = $this->input->post('purchase_order_no');
		$filter_material = $this->input->post('filter_material');
		$start_date = false;
		$end_date = false;
		$total = 0;
		$date = $this->input->post('filter_date');
		if(!empty($date)){
			$arr_date = explode(' - ',$date);
			$start_date = date('Y-m-d',strtotime($arr_date[0]));
			$end_date = date('Y-m-d',strtotime($arr_date[1]));
		}
		
		$this->db3->select('pmp.client_id, pmp.nama_pelanggan as nama, SUM(pmp.total) AS total_bayar');
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
					

					$data[] = $sups;
					$no++;
					
				}		
				
			}
		}

		echo json_encode(array('data'=>$data,'total'=>number_format($total,0,',','.')));	
	}

}