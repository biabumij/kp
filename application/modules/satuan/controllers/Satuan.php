<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Satuan extends Secure_Controller {

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
			$data['satuan'] = $this->db->order_by('nama_satuan', 'asc')->select('*')->get_where('satuan', array('status' => 'PUBLISH'))->result_array();
			$this->load->view('satuan/form', $data);
		} else {
			redirect('admin');
		}
	}

	public function submit_satuan()
    {
		$nama_satuan = $this->input->post('nama_satuan');

        $arr_insert = array(
			'nama_satuan' => $nama_satuan,
            'created_by' => $this->session->userdata('admin_id'),
            'created_on' => date('Y-m-d H:i:s'),
            'status' => 'PUBLISH'
        );


        if ($this->db->insert('satuan', $arr_insert)) {
        }

        if ($this->db->trans_status() === FALSE) {
            # Something went wrong.
            $this->db->trans_rollback();
            $this->session->set_flashdata('notif_error', 'Gagal Menambahkan Satuan !!');
            redirect('satuan/satuan');
        } else {
            # Everything is Perfect. 
            # Committing data to the database.
            $this->db->trans_commit();
            $this->session->set_flashdata('notif_success', 'Berhasil Menambahkan Satuan !!');
            redirect('admin/satuan');
        }
    }

	public function table_satuan()
	{   
        $data = array();
		
        $this->db->select('s.*');
		$this->db->order_by('s.id','desc');		
		$query = $this->db->get('satuan s');
		
       if($query->num_rows() > 0){
			foreach ($query->result_array() as $key => $row) {
                $row['no'] = $key+1;
				$row['nama_satuan'] = $row['nama_satuan'];

				if($this->session->userdata('admin_group_id') == 1 || $this->session->userdata('admin_group_id') == 4 || $this->session->userdata('admin_group_id') == 5 || $this->session->userdata('admin_group_id') == 2){
					$row['delete'] = '<a href="javascript:void(0);" onclick="HapusSatuan('.$row['id'].')" class="btn btn-danger" style="font-weight:bold; border-radius:10px;"><i class="fa fa-close"></i> </a>';
				}else {
					$row['delete'] = '<button type="button" class="btn btn-danger" style="font-weight:bold; border-radius:10px;"><i class="fa fa-ban"></i> No Access</button>';
				}
				
                $data[] = $row;
            }

        }
        echo json_encode(array('data'=>$data));
    }

	public function hapus_satuan()
	{
		$output['output'] = false;
		$id = $this->input->post('id');
		if(!empty($id)){
			$this->db->delete('satuan',array('id'=>$id));
			{
				$output['output'] = true;
			}
		}
		echo json_encode($output);
	}

}
?>