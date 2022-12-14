<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stok extends Secure_Controller {

	public function __construct()
	{
        parent::__construct();
        // Your own constructor code
        $this->load->model(array('admin/m_admin','crud_global','m_themes','pages/m_pages','menu/m_menu','admin_access/m_admin_access','DB_model','member_back/m_member_back','m_member','pmm/pmm_model','admin/Templates','pmm/pmm_finance','produk/m_produk'));
        $this->load->library('enkrip');
		$this->load->library('filter');
		$this->load->library('waktu');
		$this->load->library('session');
    }

	public function form()
	{
		$check = $this->m_admin->check_login();
		if ($check == true) {
			$data['produk'] = $this->db->order_by('nama_produk', 'asc')->select('*')->get_where('produk', array('status' => 'PUBLISH'))->result_array();
			$data['satuan'] = $this->db->order_by('nama_satuan', 'asc')->select('*')->get_where('satuan', array('status' => 'PUBLISH'))->result_array();
			$this->load->view('stok/form', $data);
		} else {
			redirect('admin');
		}
	}

	public function submit_stok()
    {
		$tanggal = $this->input->post('tanggal');
		$produk = $this->input->post('produk');

		$stok = $this->input->post('stok');
		$stok = str_replace('.', '', $stok);
		$stok = str_replace(',', '.', $stok);

		$satuan = $this->input->post('satuan');

		$harga_satuan = $this->input->post('harga_satuan');
		$harga_satuan = str_replace('.', '', $harga_satuan);
		$harga_satuan = str_replace(',', '.', $harga_satuan);

		$jumlah = $this->input->post('jumlah');
		$jumlah = str_replace('.', '', $jumlah);
		$jumlah = str_replace(',', '.', $jumlah);

		$keterangan = $this->input->post('keterangan');

        $arr_insert = array(
			'produk' => $produk,
            'tanggal' => date('Y-m-d', strtotime($tanggal)),
            'stok' => $stok,
			'satuan' => $satuan,
			'harga_satuan' => $harga_satuan,
			'jumlah' => $jumlah,
			'keterangan' => $keterangan,
            'created_by' => $this->session->userdata('admin_id'),
            'created_on' => date('Y-m-d H:i:s'),
            'status' => 'PUBLISH'
        );


        if ($this->db->insert('stok', $arr_insert)) {
           
        }

        if ($this->db->trans_status() === FALSE) {
            # Something went wrong.
            $this->db->trans_rollback();
            $this->session->set_flashdata('notif_error', 'Gagal Stok !!');
            redirect('stok/stok');
        } else {
            # Everything is Perfect. 
            # Committing data to the database.
            $this->db->trans_commit();
            $this->session->set_flashdata('notif_success', 'Berhasil Menambahkan Stok !!');
            redirect('admin/stok');
        }
    }

	public function table_stok()
	{   
        $data = array();
		$filter_date = $this->input->post('filter_date');
		if(!empty($filter_date)){
			$arr_date = explode(' - ', $filter_date);
			$this->db->where('s.tanggal >=',date('Y-m-d',strtotime($arr_date[0])));
			$this->db->where('s.tanggal <=',date('Y-m-d',strtotime($arr_date[1])));
		}
        $this->db->select('s.*');
		$this->db->join('produk p','s.produk = p.id','left');
		$this->db->order_by('s.tanggal','desc');
		$this->db->order_by('p.nama_produk','asc');
		$query = $this->db->get('stok s');
		
       if($query->num_rows() > 0){
			foreach ($query->result_array() as $key => $row) {
                $row['no'] = $key+1;
				$row['tanggal'] = date('d F Y', strtotime($row['tanggal']));
				$row['produk'] = $this->crud_global->GetField('produk',array('id'=>$row['produk']),'nama_produk');
				$row['stok'] = number_format($row['stok'],0,',','.');
				$row['satuan'] = $this->crud_global->GetField('satuan',array('id'=>$row['satuan']),'nama_satuan');
				$row['harga_satuan'] = number_format($row['harga_satuan'],0,',','.');
				$row['jumlah'] = number_format($row['jumlah'],0,',','.');
				$row['keterangan'] = $row['keterangan'];
				$row['edit'] = '<a href="javascript:void(0);" onclick="OpenForm('.$row['id'].')" class="btn btn-primary"><i class="fa fa-edit"></i> </a>';
				$row['hapus'] = '<a href="javascript:void(0);" onclick="HapusStok('.$row['id'].')" class="btn btn-danger"><i class="fa fa-close"></i> </a>';


                $data[] = $row;
            }

        }
        echo json_encode(array('data'=>$data));
    }

	public function cetak_stok()
	{
		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
        
        $pdf->SetFont('helvetica','',7); 
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		        $pdf->AddPage('P');

		$arr_date = $this->input->get('filter_date');
		if(empty($arr_date)){
			$date1 = '-';
			$date2 = '-';
			$filter_date = '-';
		}else {
			$arr_filter_date = explode(' - ', $arr_date);
			$filter_date = date('d F Y',strtotime($arr_filter_date[0])).' - '.date('d F Y',strtotime($arr_filter_date[1]));
			$date1 = date('d F Y',strtotime($arr_filter_date[0]));
			$date2 = date('d F Y',strtotime($arr_filter_date[1]));
		}
		$data['filter_date'] = $filter_date;

		$this->db->where('status','PUBLISH');
		$this->db->order_by('tanggal','desc');
		$this->db->order_by('id','desc');
		if(!empty($this->input->get('produk'))){
			$this->db->where('produk',$this->input->post('produk'));
		}
		$filter_date = $this->input->get('filter_date');
		if(!empty($filter_date)){
			$arr_date = explode(' - ', $filter_date);
			$this->db->where('tanggal >=',date('Y-m-d',strtotime($arr_date[0])));
			$this->db->where('tanggal <=',date('Y-m-d',strtotime($arr_date[1])));
		}
		$query = $this->db->get('stok');
		$data['data'] = $query->result_array();
		$data['custom_date'] = $this->input->get('custom_date');
		$data['date1'] = $date1 = date('Y-m-d',strtotime($date1));
		$data['date2'] = $date2 = date('Y-m-d',strtotime($date2));
        $html = $this->load->view('stok/cetak_stok',$data,TRUE);

        
        $pdf->SetTitle('Stok');
        $pdf->nsi_html($html);
        $pdf->Output('Stok.pdf', 'I');
	
	}

	public function hapus_stok()
	{
		$output['output'] = false;
		$id = $this->input->post('id');
		if(!empty($id)){
			$this->db->delete('stok',array('id'=>$id));
			{
				$output['output'] = true;
			}
		}
		echo json_encode($output);
	}

	public function dashboard_stok($arr_date)
	{
		$data = array();
		
		$arr_date = $this->input->post('filter_date');
		$arr_filter_date = explode(' - ', $arr_date);

		$last_production = $this->db->select('tanggal')->group_by('tanggal')->order_by('tanggal','desc')->limit(1)->get_where('stok',array('status'=>'PUBLISH'))->row_array();
		$last_production_2 = $this->db->select('tanggal')->group_by('tanggal')->order_by('tanggal','asc')->limit(1)->get_where('stok',array('status'=>'PUBLISH'))->row_array();
		
		$date1 = date('Y-m-d', strtotime('+1 days', strtotime($last_production_2['tanggal'])));
		$date2 =  date('Y-m-d', strtotime($last_production['tanggal']));
		$date1_filter = date('d F Y', strtotime($date1));
		$date2_filter = date('d F Y', strtotime($date2));
		

		if(count($arr_filter_date) == 2){
			$date1 	= date('Y-m-d',strtotime($arr_filter_date[0]));
			$date2 	= date('Y-m-d',strtotime($arr_filter_date[1]));
			$filter_date = date('d F Y',strtotime($arr_filter_date[0])).' - '.date('d F Y',strtotime($arr_filter_date[1]));
			$date1_filter = date('d F Y',strtotime($arr_filter_date[0]));
			$date2_filter = date('d F Y',strtotime($arr_filter_date[1]));
		}
		
		?>
		
		<table class="table table-bordered" width="100%">
			<style type="text/css">
				table tr.table-active{
				background-color: red;
				color: white;
			}
			blink {
			-webkit-animation: 2s linear infinite kedip; /* for Safari 4.0 - 8.0 */
			animation: 2s linear infinite kedip;
			}
			/* for Safari 4.0 - 8.0 */
			@-webkit-keyframes kedip { 
			0% {
				visibility: hidden;
			}
			50% {
				visibility: hidden;
			}
			100% {
				visibility: visible;
			}
			}
			@keyframes kedip {
			0% {
				visibility: hidden;
			}
			50% {
				visibility: hidden;
			}
			100% {
				visibility: visible;
			}
			}
			</style>

			<?php

			$stok = $this->db->select('*')
			->from('stok')
			->where("tanggal between '$date1' and '$date2'")
			->where('status','PUBLISH')
			->where("stok = 0")
			->group_by("id")
			->get()->result_array();

	        ?>

			<tr class="table-active">
				<th class="text-center" colspan="5" style="text-transform:uppercase"><blink>STOK TIDAK TERSEDIA !!</blink></th>
			</tr>
			<tr>
				<th width="5%" class="text-center" style='background-color:rgb(0,206,209); color:black'>NO.</th>
				<th class="text-center" style='background-color:rgb(0,206,209); color:black'>TANGGAL OPNAME TERAKHIR</th>
				<th class="text-center" style='background-color:rgb(0,206,209); color:black'>PRODUK</th>
				<th class="text-center" style='background-color:rgb(0,206,209); color:black'>STOK</th>
	        </tr>
			<?php foreach ($stok as $key => $x): ?>
			<tr>
				<th width="5%" class="text-center" style='color:red;'><?php echo $key + 1;?></th>			
				<th width="25%" class="text-center" style='color:red;'><?= $x['tanggal'] ?></th>
				<th width="40%" class="text-left" style='color:red;'><?= $x['produk'] ?></th>
				<th width="30%" class="text-center" style='color:red;'><?= $x['stok'] ?></th>
	        </tr>
			<?php endforeach; ?>
	    </table>
		<?php
	}

	public function get_remaining_stok()
	{
		$output['output'] = false;
		$id = $this->input->post('id');
		if(!empty($id)){

			$this->db->where('id',$id);
			$data = $this->db->get('stok')->row_array();
			$data['tanggal'] = date('d-m-Y',strtotime($data['tanggal']));
			$output['output'] = $data;
		}
		echo json_encode($output);
	}

	public function update_stok()
    {
		$id = $this->input->post('id');
		$tanggal = $this->input->post('tanggal');
		$produk = $this->input->post('produk');

		$stok = $this->input->post('stok');
		$stok = str_replace('.', '', $stok);
		$stok = str_replace(',', '.', $stok);

		$satuan = $this->input->post('satuan');

		$harga_satuan = $this->input->post('harga_satuan');
		$harga_satuan = str_replace('.', '', $harga_satuan);
		$harga_satuan = str_replace(',', '.', $harga_satuan);

		$jumlah = $this->input->post('jumlah');
		$jumlah = str_replace('.', '', $jumlah);
		$jumlah = str_replace(',', '.', $jumlah);

		$keterangan = $this->input->post('keterangan');

        $data = array(
			'id' => $id,
			'produk' => $produk,
            'tanggal' => date('Y-m-d', strtotime($tanggal)),
            'stok' => $stok,
			'satuan' => $satuan,
			'harga_satuan' => $harga_satuan,
			'jumlah' => $jumlah,
			'keterangan' => $keterangan,
            'status' => 'PUBLISH'
        );


        if(!empty($id)){
			//$data['created_by'] = $this->session->userdata('admin_id');
            //$data['created_on'] = date('Y-m-d H:i:s');
			if($this->db->update('stok',$data,array('id'=>$id))){
				$output['output'] = true;
			}
		}else{
           //$data['updated_by'] = $this->session->userdata('admin_id');
			if($this->db->update('stok',$data,array('id'=>$id))){
				$output['output'] = true;
			}
		}

        if ($this->db->trans_status() === FALSE) {
            # Something went wrong.
            $this->db->trans_rollback();
            $this->session->set_flashdata('notif_error', 'Gagal Update Stok !!');
            redirect('stok/stok');
        } else {
            # Everything is Perfect. 
            # Committing data to the database.
            $this->db->trans_commit();
            $this->session->set_flashdata('notif_success', 'Berhasil Update Stok !!');
            redirect('admin/stok');
        }
    }

}
?>