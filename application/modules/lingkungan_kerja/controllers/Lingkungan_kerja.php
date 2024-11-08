<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lingkungan_kerja extends Secure_Controller {

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

	public function form_lingkungan_kerja()
	{
		$check = $this->m_admin->check_login();
		if ($check == true) {
			$data['supplier'] = $this->db->select('*')->order_by('nama','asc')->get_where('penerima', array('status' => 'PUBLISH', 'rekanan' => 1))->result_array();
			$this->load->view('lingkungan_kerja/form_lingkungan_kerja', $data);
		} else {
			redirect('admin');
		}
	}

	public function submit_lingkungan_kerja()
	{
		$tanggal = $this->input->post('tanggal');

		$suhu_direksi_1_pagi = str_replace(',', '.', $this->input->post('suhu_direksi_1_pagi'));
		$suhu_direksi_1_sore = str_replace(',', '.', $this->input->post('suhu_direksi_1_sore'));
		$suhu_direksi_2_pagi = str_replace(',', '.', $this->input->post('suhu_direksi_2_pagi'));
		$suhu_direksi_2_sore = str_replace(',', '.', $this->input->post('suhu_direksi_2_sore'));
		$suhu_staff_pagi = str_replace(',', '.', $this->input->post('suhu_staff_pagi'));
		$suhu_staff_sore = str_replace(',', '.', $this->input->post('suhu_staff_sore'));
		$suhu_pantry_pagi = str_replace(',', '.', $this->input->post('suhu_pantry_pagi'));
		$suhu_pantry_sore = str_replace(',', '.', $this->input->post('suhu_pantry_sore'));
		$suhu_tindakan = $this->input->post('suhu_tindakan');

		$kelembaban_direksi_1_pagi = str_replace(',', '.', $this->input->post('kelembaban_direksi_1_pagi'));
		$kelembaban_direksi_1_sore = str_replace(',', '.', $this->input->post('kelembaban_direksi_1_sore'));
		$kelembaban_direksi_2_pagi = str_replace(',', '.', $this->input->post('kelembaban_direksi_2_pagi'));
		$kelembaban_direksi_2_sore = str_replace(',', '.', $this->input->post('kelembaban_direksi_2_sore'));
		$kelembaban_staff_pagi = str_replace(',', '.', $this->input->post('kelembaban_staff_pagi'));
		$kelembaban_staff_sore = str_replace(',', '.', $this->input->post('kelembaban_staff_sore'));
		$kelembaban_pantry_pagi = str_replace(',', '.', $this->input->post('kelembaban_pantry_pagi'));
		$kelembaban_pantry_sore = str_replace(',', '.', $this->input->post('kelembaban_pantry_sore'));
		$kelembaban_tindakan = $this->input->post('kelembaban_tindakan');

		$cahaya_direksi_1_pagi = str_replace(',', '.', $this->input->post('cahaya_direksi_1_pagi'));
		$cahaya_direksi_1_sore = str_replace(',', '.', $this->input->post('cahaya_direksi_1_sore'));
		$cahaya_direksi_2_pagi = str_replace(',', '.', $this->input->post('cahaya_direksi_2_pagi'));
		$cahaya_direksi_2_sore = str_replace(',', '.', $this->input->post('cahaya_direksi_2_sore'));
		$cahaya_staff_pagi = str_replace(',', '.', $this->input->post('cahaya_staff_pagi'));
		$cahaya_staff_sore = str_replace(',', '.', $this->input->post('cahaya_staff_sore'));
		$cahaya_pantry_pagi = str_replace(',', '.', $this->input->post('cahaya_pantry_pagi'));
		$cahaya_pantry_sore = str_replace(',', '.', $this->input->post('cahaya_pantry_sore'));
		$cahaya_tindakan = $this->input->post('cahaya_tindakan');

		$udara_direksi_1_pagi = str_replace(',', '.', $this->input->post('udara_direksi_1_pagi'));
		$udara_direksi_1_sore = str_replace(',', '.', $this->input->post('udara_direksi_1_sore'));
		$udara_direksi_2_pagi = str_replace(',', '.', $this->input->post('udara_direksi_2_pagi'));
		$udara_direksi_2_sore = str_replace(',', '.', $this->input->post('udara_direksi_2_sore'));
		$udara_staff_pagi = str_replace(',', '.', $this->input->post('udara_staff_pagi'));
		$udara_staff_sore = str_replace(',', '.', $this->input->post('udara_staff_sore'));
		$udara_pantry_pagi = str_replace(',', '.', $this->input->post('udara_pantry_pagi'));
		$udara_pantry_sore = str_replace(',', '.', $this->input->post('udara_pantry_sore'));
		$udara_tindakan = $this->input->post('udara_tindakan');

		$kebisingan_direksi_1_pagi = str_replace(',', '.', $this->input->post('kebisingan_direksi_1_pagi'));
		$kebisingan_direksi_1_sore = str_replace(',', '.', $this->input->post('kebisingan_direksi_1_sore'));
		$kebisingan_direksi_2_pagi = str_replace(',', '.', $this->input->post('kebisingan_direksi_2_pagi'));
		$kebisingan_direksi_2_sore = str_replace(',', '.', $this->input->post('kebisingan_direksi_2_sore'));
		$kebisingan_staff_pagi = str_replace(',', '.', $this->input->post('kebisingan_staff_pagi'));
		$kebisingan_staff_sore = str_replace(',', '.', $this->input->post('kebisingan_staff_sore'));
		$kebisingan_pantry_pagi = str_replace(',', '.', $this->input->post('kebisingan_pantry_pagi'));
		$kebisingan_pantry_sore = str_replace(',', '.', $this->input->post('kebisingan_pantry_sore'));
		$kebisingan_tindakan = $this->input->post('kebisingan_tindakan');

		$this->db->trans_start(); # Starting Transaction
		$this->db->trans_strict(FALSE); # See Note 01. If you wish can remove as well 

		$arr_insert = array(
			'tanggal' => date('Y-m-d', strtotime($tanggal)),

			'suhu_direksi_1_pagi' => $suhu_direksi_1_pagi,
			'suhu_direksi_1_sore' => $suhu_direksi_1_sore,
			'suhu_direksi_2_pagi' => $suhu_direksi_2_pagi,
			'suhu_direksi_2_sore' => $suhu_direksi_2_sore,
			'suhu_staff_pagi' => $suhu_staff_pagi,
			'suhu_staff_sore' => $suhu_staff_sore,
			'suhu_pantry_pagi' => $suhu_pantry_pagi,
			'suhu_pantry_sore' => $suhu_pantry_sore,
			'suhu_tindakan' => $suhu_tindakan,

			'kelembaban_direksi_1_pagi' => $kelembaban_direksi_1_pagi,
			'kelembaban_direksi_1_sore' => $kelembaban_direksi_1_sore,
			'kelembaban_direksi_2_pagi' => $kelembaban_direksi_2_pagi,
			'kelembaban_direksi_2_sore' => $kelembaban_direksi_2_sore,
			'kelembaban_staff_pagi' => $kelembaban_staff_pagi,
			'kelembaban_staff_sore' => $kelembaban_staff_sore,
			'kelembaban_pantry_pagi' => $kelembaban_pantry_pagi,
			'kelembaban_pantry_sore' => $kelembaban_pantry_sore,
			'kelembaban_tindakan' => $kelembaban_tindakan,

			'cahaya_direksi_1_pagi' => $cahaya_direksi_1_pagi,
			'cahaya_direksi_1_sore' => $cahaya_direksi_1_sore,
			'cahaya_direksi_2_pagi' => $cahaya_direksi_2_pagi,
			'cahaya_direksi_2_sore' => $cahaya_direksi_2_sore,
			'cahaya_staff_pagi' => $cahaya_staff_pagi,
			'cahaya_staff_sore' => $cahaya_staff_sore,
			'cahaya_pantry_pagi' => $cahaya_pantry_pagi,
			'cahaya_pantry_sore' => $cahaya_pantry_sore,
			'cahaya_tindakan' => $cahaya_tindakan,

			'udara_direksi_1_pagi' => $udara_direksi_1_pagi,
			'udara_direksi_1_sore' => $udara_direksi_1_sore,
			'udara_direksi_2_pagi' => $udara_direksi_2_pagi,
			'udara_direksi_2_sore' => $udara_direksi_2_sore,
			'udara_staff_pagi' => $udara_staff_pagi,
			'udara_staff_sore' => $udara_staff_sore,
			'udara_pantry_pagi' => $udara_pantry_pagi,
			'udara_pantry_sore' => $udara_pantry_sore,
			'udara_tindakan' => $udara_tindakan,

			'kebisingan_direksi_1_pagi' => $kebisingan_direksi_1_pagi,
			'kebisingan_direksi_1_sore' => $kebisingan_direksi_1_sore,
			'kebisingan_direksi_2_pagi' => $kebisingan_direksi_2_pagi,
			'kebisingan_direksi_2_sore' => $kebisingan_direksi_2_sore,
			'kebisingan_staff_pagi' => $kebisingan_staff_pagi,
			'kebisingan_staff_sore' => $kebisingan_staff_sore,
			'kebisingan_pantry_pagi' => $kebisingan_pantry_pagi,
			'kebisingan_pantry_sore' => $kebisingan_pantry_sore,
			'kebisingan_tindakan' => $kebisingan_tindakan,
			
			'status' => 'PUBLISH',
			'created_by' => $this->session->userdata('admin_id'),
			'created_on' => date('Y-m-d H:i:s')
		);

		$this->db->insert('lingkungan_kerja', $arr_insert);


		if ($this->db->trans_status() === FALSE) {
			# Something went wrong.
			$this->db->trans_rollback();
			$this->session->set_flashdata('notif_error','<b>Data Gagal Disimpan</b>');
			redirect('lingkungan_kerja/lingkungan_kerja');
		} else {
			# Everything is Perfect. 
			# Committing data to the database.
			$this->db->trans_commit();
			$this->session->set_flashdata('notif_success','<b>Data Berhasil Disimpan</b>');
			redirect('admin/lingkungan_kerja');
		}
	}
	
	public function table_lingkungan_kerja()
	{   
        $data = array();
		$filter_date = $this->input->post('filter_date');
		if(!empty($filter_date)){
			$arr_date = explode(' - ', $filter_date);
			$this->db->where('lk.tanggal >=',date('Y-m-d',strtotime($arr_date[0])));
			$this->db->where('lk.tanggal <=',date('Y-m-d',strtotime($arr_date[1])));
		}
        $this->db->select('lk.*');
		$this->db->order_by('lk.created_on','desc');
		$query = $this->db->get('lingkungan_kerja lk');
		
       if($query->num_rows() > 0){
			foreach ($query->result_array() as $key => $row) {
                $row['no'] = $key+1;
                $row['tanggal'] = date('d F Y',strtotime($row['tanggal']));
                $row['admin_name'] = $this->crud_global->GetField('tbl_admin',array('admin_id'=>$row['created_by']),'admin_name');
				$row['created_on'] = date('d/m/Y H:i:s',strtotime($row['created_on']));
				$row['status'] = $this->pmm_model->GetStatus4($row['status']);
				$row['print'] = '<a href="'.site_url().'lingkungan_kerja/cetak_lingkungan_kerja/'.$row['id'].'" target="_blank" class="btn btn-info" style="font-weight:bold; border-radius:10px;"><i class="fa fa-print"></i> </a>';
				
				if($this->session->userdata('admin_group_id') == 1 || $this->session->userdata('admin_group_id') == 4 || $this->session->userdata('admin_group_id') == 5 || $this->session->userdata('admin_group_id') == 2){
					$row['delete'] = '<a href="javascript:void(0);" onclick="DeleteLingkunganKerja('.$row['id'].')" class="btn btn-danger" style="font-weight:bold; border-radius:10px;"><i class="fa fa-close"></i> </a>';
				}else {
					$row['delete'] = '<button type="button" class="btn btn-danger" style="font-weight:bold; border-radius:10px;"><i class="fa fa-ban"></i> No Access</button>';
				}
		
				$data[] = $row;
            }

        }
        echo json_encode(array('data'=>$data));
    }

	public function cetak_lingkungan_kerja($id){

		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
        $pdf->SetFont('helvetica','',7); 
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');

		$data['id'] = $id;
		$data['row'] = $this->db->get_where('lingkungan_kerja lk', array('lk.id' => $id))->row_array();
        $html = $this->load->view('lingkungan_kerja/cetak_lingkungan_kerja',$data,TRUE);
        
        $pdf->SetTitle('Lingkungan Kerja');
        $pdf->nsi_html($html);
		$pdf->Output('lingkungan_kerja.pdf', 'I');
	}

	public function delete_lingkungan_kerja()
	{
		$output['output'] = false;
		$id = $this->input->post('id');
		if(!empty($id)){
			$this->db->delete('lingkungan_kerja',array('id'=>$id));
			{
				$output['output'] = true;
			}
		}
		echo json_encode($output);
	}

}
?>