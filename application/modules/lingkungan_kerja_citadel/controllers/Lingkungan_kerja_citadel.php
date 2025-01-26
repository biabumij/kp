<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lingkungan_kerja_citadel extends Secure_Controller {

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

	public function form_lingkungan_kerja_citadel()
	{
		$check = $this->m_admin->check_login();
		if ($check == true) {
			$data['supplier'] = $this->db->select('*')->order_by('nama','asc')->get_where('penerima', array('status' => 'PUBLISH', 'rekanan' => 1))->result_array();
			$this->load->view('lingkungan_kerja_citadel/form_lingkungan_kerja_citadel', $data);
		} else {
			redirect('admin');
		}
	}

	public function submit_lingkungan_kerja_citadel()
	{
		$tanggal = $this->input->post('tanggal');

		$suhu_lobby_pagi = str_replace(',', '.', $this->input->post('suhu_lobby_pagi'));
		$suhu_lobby_sore = str_replace(',', '.', $this->input->post('suhu_lobby_sore'));
		$suhu_tengah_pagi = str_replace(',', '.', $this->input->post('suhu_tengah_pagi'));
		$suhu_tengah_sore = str_replace(',', '.', $this->input->post('suhu_tengah_sore'));
		$suhu_direktur_pagi = str_replace(',', '.', $this->input->post('suhu_direktur_pagi'));
		$suhu_direktur_sore = str_replace(',', '.', $this->input->post('suhu_direktur_sore'));
		$suhu_meeting_pagi = str_replace(',', '.', $this->input->post('suhu_meeting_pagi'));
		$suhu_meeting_sore = str_replace(',', '.', $this->input->post('suhu_meeting_sore'));
		$suhu_arsip_pagi = str_replace(',', '.', $this->input->post('suhu_arsip_pagi'));
		$suhu_arsip_sore = str_replace(',', '.', $this->input->post('suhu_arsip_sore'));
		$suhu_tindakan = $this->input->post('suhu_tindakan');

		$kelembaban_lobby_pagi = str_replace(',', '.', $this->input->post('kelembaban_lobby_pagi'));
		$kelembaban_lobby_sore = str_replace(',', '.', $this->input->post('kelembaban_lobby_sore'));
		$kelembaban_tengah_pagi = str_replace(',', '.', $this->input->post('kelembaban_tengah_pagi'));
		$kelembaban_tengah_sore = str_replace(',', '.', $this->input->post('kelembaban_tengah_sore'));
		$kelembaban_direktur_pagi = str_replace(',', '.', $this->input->post('kelembaban_direktur_pagi'));
		$kelembaban_direktur_sore = str_replace(',', '.', $this->input->post('kelembaban_direktur_sore'));
		$kelembaban_meeting_pagi = str_replace(',', '.', $this->input->post('kelembaban_meeting_pagi'));
		$kelembaban_meeting_sore = str_replace(',', '.', $this->input->post('kelembaban_meeting_sore'));
		$kelembaban_arsip_pagi = str_replace(',', '.', $this->input->post('kelembaban_arsip_pagi'));
		$kelembaban_arsip_sore = str_replace(',', '.', $this->input->post('kelembaban_arsip_sore'));
		$kelembaban_tindakan = $this->input->post('kelembaban_tindakan');

		$cahaya_lobby_pagi = str_replace(',', '.', $this->input->post('cahaya_lobby_pagi'));
		$cahaya_lobby_sore = str_replace(',', '.', $this->input->post('cahaya_lobby_sore'));
		$cahaya_tengah_pagi = str_replace(',', '.', $this->input->post('cahaya_tengah_pagi'));
		$cahaya_tengah_sore = str_replace(',', '.', $this->input->post('cahaya_tengah_sore'));
		$cahaya_direktur_pagi = str_replace(',', '.', $this->input->post('cahaya_direktur_pagi'));
		$cahaya_direktur_sore = str_replace(',', '.', $this->input->post('cahaya_direktur_sore'));
		$cahaya_meeting_pagi = str_replace(',', '.', $this->input->post('cahaya_meeting_pagi'));
		$cahaya_meeting_sore = str_replace(',', '.', $this->input->post('cahaya_meeting_sore'));
		$cahaya_arsip_pagi = str_replace(',', '.', $this->input->post('cahaya_arsip_pagi'));
		$cahaya_arsip_sore = str_replace(',', '.', $this->input->post('cahaya_arsip_sore'));
		$cahaya_tindakan = $this->input->post('cahaya_tindakan');

		$udara_lobby_pagi = str_replace(',', '.', $this->input->post('udara_lobby_pagi'));
		$udara_lobby_sore = str_replace(',', '.', $this->input->post('udara_lobby_sore'));
		$udara_tengah_pagi = str_replace(',', '.', $this->input->post('udara_tengah_pagi'));
		$udara_tengah_sore = str_replace(',', '.', $this->input->post('udara_tengah_sore'));
		$udara_direktur_pagi = str_replace(',', '.', $this->input->post('udara_direktur_pagi'));
		$udara_direktur_sore = str_replace(',', '.', $this->input->post('udara_direktur_sore'));
		$udara_meeting_pagi = str_replace(',', '.', $this->input->post('udara_meeting_pagi'));
		$udara_meeting_sore = str_replace(',', '.', $this->input->post('udara_meeting_sore'));
		$udara_arsip_pagi = str_replace(',', '.', $this->input->post('udara_arsip_pagi'));
		$udara_arsip_sore = str_replace(',', '.', $this->input->post('udara_arsip_sore'));
		$udara_tindakan = $this->input->post('udara_tindakan');

		$kebisingan_lobby_pagi = str_replace(',', '.', $this->input->post('kebisingan_lobby_pagi'));
		$kebisingan_lobby_sore = str_replace(',', '.', $this->input->post('kebisingan_lobby_sore'));
		$kebisingan_tengah_pagi = str_replace(',', '.', $this->input->post('kebisingan_tengah_pagi'));
		$kebisingan_tengah_sore = str_replace(',', '.', $this->input->post('kebisingan_tengah_sore'));
		$kebisingan_direktur_pagi = str_replace(',', '.', $this->input->post('kebisingan_direktur_pagi'));
		$kebisingan_direktur_sore = str_replace(',', '.', $this->input->post('kebisingan_direktur_sore'));
		$kebisingan_meeting_pagi = str_replace(',', '.', $this->input->post('kebisingan_meeting_pagi'));
		$kebisingan_meeting_sore = str_replace(',', '.', $this->input->post('kebisingan_meeting_sore'));
		$kebisingan_arsip_pagi = str_replace(',', '.', $this->input->post('kebisingan_arsip_pagi'));
		$kebisingan_arsip_sore = str_replace(',', '.', $this->input->post('kebisingan_arsip_sore'));
		$kebisingan_tindakan = $this->input->post('kebisingan_tindakan');

		$this->db->trans_start(); # Starting Transaction
		$this->db->trans_strict(FALSE); # See Note 01. If you wish can remove as well 

		$arr_insert = array(
			'tanggal' => date('Y-m-d', strtotime($tanggal)),

			'suhu_lobby_pagi' => $suhu_lobby_pagi,
			'suhu_lobby_sore' => $suhu_lobby_sore,
			'suhu_tengah_pagi' => $suhu_tengah_pagi,
			'suhu_tengah_sore' => $suhu_tengah_sore,
			'suhu_direktur_pagi' => $suhu_direktur_pagi,
			'suhu_direktur_sore' => $suhu_direktur_sore,
			'suhu_meeting_pagi' => $suhu_meeting_pagi,
			'suhu_meeting_sore' => $suhu_meeting_sore,
			'suhu_arsip_pagi' => $suhu_arsip_pagi,
			'suhu_arsip_sore' => $suhu_arsip_sore,
			'suhu_tindakan' => $suhu_tindakan,

			'kelembaban_lobby_pagi' => $kelembaban_lobby_pagi,
			'kelembaban_lobby_sore' => $kelembaban_lobby_sore,
			'kelembaban_tengah_pagi' => $kelembaban_tengah_pagi,
			'kelembaban_tengah_sore' => $kelembaban_tengah_sore,
			'kelembaban_direktur_pagi' => $kelembaban_direktur_pagi,
			'kelembaban_direktur_sore' => $kelembaban_direktur_sore,
			'kelembaban_meeting_pagi' => $kelembaban_meeting_pagi,
			'kelembaban_meeting_sore' => $kelembaban_meeting_sore,
			'kelembaban_arsip_pagi' => $kelembaban_arsip_pagi,
			'kelembaban_arsip_sore' => $kelembaban_arsip_sore,
			'kelembaban_tindakan' => $kelembaban_tindakan,

			'cahaya_lobby_pagi' => $cahaya_lobby_pagi,
			'cahaya_lobby_sore' => $cahaya_lobby_sore,
			'cahaya_tengah_pagi' => $cahaya_tengah_pagi,
			'cahaya_tengah_sore' => $cahaya_tengah_sore,
			'cahaya_direktur_pagi' => $cahaya_direktur_pagi,
			'cahaya_direktur_sore' => $cahaya_direktur_sore,
			'cahaya_meeting_pagi' => $cahaya_meeting_pagi,
			'cahaya_meeting_sore' => $cahaya_meeting_sore,
			'cahaya_arsip_pagi' => $cahaya_arsip_pagi,
			'cahaya_arsip_sore' => $cahaya_arsip_sore,
			'cahaya_tindakan' => $cahaya_tindakan,

			'udara_lobby_pagi' => $udara_lobby_pagi,
			'udara_lobby_sore' => $udara_lobby_sore,
			'udara_tengah_pagi' => $udara_tengah_pagi,
			'udara_tengah_sore' => $udara_tengah_sore,
			'udara_direktur_pagi' => $udara_direktur_pagi,
			'udara_direktur_sore' => $udara_direktur_sore,
			'udara_meeting_pagi' => $udara_meeting_pagi,
			'udara_meeting_sore' => $udara_meeting_sore,
			'udara_arsip_pagi' => $udara_arsip_pagi,
			'udara_arsip_sore' => $udara_arsip_sore,
			'udara_tindakan' => $udara_tindakan,

			'kebisingan_lobby_pagi' => $kebisingan_lobby_pagi,
			'kebisingan_lobby_sore' => $kebisingan_lobby_sore,
			'kebisingan_tengah_pagi' => $kebisingan_tengah_pagi,
			'kebisingan_tengah_sore' => $kebisingan_tengah_sore,
			'kebisingan_direktur_pagi' => $kebisingan_direktur_pagi,
			'kebisingan_direktur_sore' => $kebisingan_direktur_sore,
			'kebisingan_meeting_pagi' => $kebisingan_meeting_pagi,
			'kebisingan_meeting_sore' => $kebisingan_meeting_sore,
			'kebisingan_arsip_pagi' => $kebisingan_arsip_pagi,
			'kebisingan_arsip_sore' => $kebisingan_arsip_sore,
			'kebisingan_tindakan' => $kebisingan_tindakan,
			
			'status' => 'PUBLISH',
			'created_by' => $this->session->userdata('admin_id'),
			'created_on' => date('Y-m-d H:i:s')
		);

		$this->db->insert('lingkungan_kerja_citadel', $arr_insert);


		if ($this->db->trans_status() === FALSE) {
			# Something went wrong.
			$this->db->trans_rollback();
			$this->session->set_flashdata('notif_error','<b>Data Gagal Disimpan</b>');
			redirect('lingkungan_kerja_citadel/lingkungan_kerja_citadel');
		} else {
			# Everything is Perfect. 
			# Committing data to the database.
			$this->db->trans_commit();
			$this->session->set_flashdata('notif_success','<b>Data Berhasil Disimpan</b>');
			redirect('admin/lingkungan_kerja_citadel');
		}
	}
	
	public function table_lingkungan_kerja_citadel()
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
		$query = $this->db->get('lingkungan_kerja_citadel lk');
		
       if($query->num_rows() > 0){
			foreach ($query->result_array() as $key => $row) {
                $row['no'] = $key+1;
                $row['tanggal'] = date('d F Y',strtotime($row['tanggal']));
                $row['admin_name'] = $this->crud_global->GetField('tbl_admin',array('admin_id'=>$row['created_by']),'admin_name');
				$row['created_on'] = date('d/m/Y H:i:s',strtotime($row['created_on']));
				$row['status'] = $this->pmm_model->GetStatus4($row['status']);
				$row['print'] = '<a href="'.site_url().'lingkungan_kerja_citadel/cetak_lingkungan_kerja_citadel/'.$row['id'].'" target="_blank" class="btn btn-info" style="font-weight:bold; border-radius:10px;"><i class="fa fa-print"></i> </a>';
				
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

	public function cetak_lingkungan_kerja_citadel($id){

		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
        $pdf->SetFont('helvetica','',7); 
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');

		$data['id'] = $id;
		$data['row'] = $this->db->get_where('lingkungan_kerja_citadel lk', array('lk.id' => $id))->row_array();
        $html = $this->load->view('lingkungan_kerja_citadel/cetak_lingkungan_kerja_citadel',$data,TRUE);
        
        $pdf->SetTitle('Lingkungan Kerja');
        $pdf->nsi_html($html);
		$pdf->Output('lingkungan_kerja_citadel.pdf', 'I');
	}

	public function delete_lingkungan_kerja_citadel()
	{
		$output['output'] = false;
		$id = $this->input->post('id');
		if(!empty($id)){
			$this->db->delete('lingkungan_kerja_citadel',array('id'=>$id));
			{
				$output['output'] = true;
			}
		}
		echo json_encode($output);
	}

}
?>