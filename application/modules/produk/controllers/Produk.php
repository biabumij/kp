<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Produk extends Secure_Controller {

	public function __construct()
	{
        parent::__construct();
        // Your own constructor code
        $this->load->model(array('admin/m_admin','crud_global','m_themes','pages/m_pages','menu/m_menu','admin_access/m_admin_access','DB_model','member_back/m_member_back','m_member','pmm/pmm_model','admin/Templates','pmm/pmm_finance','m_produk'));
        $this->load->library('enkrip');
		$this->load->library('filter');
		$this->load->library('waktu');
		$this->load->library('session');
    }

	public function table_pantry()
	{	
		$data = array();
		
		$this->db->where('kategori_produk','Pantry');
		$this->db->where('status','PUBLISH');
		$this->db->order_by('nama_produk','asc');
		$query = $this->db->get('produk');
		if($query->num_rows() > 0){
			foreach ($query->result_array() as $key => $row) {
				$row['no'] = $key+1;
				$row['nama_produk'] = '<a href="'.site_url('produk/detail/'.$row['id']).'" >'.$row['nama_produk'].'</a>';
				$row['kategori_produk'] = $row['kategori_produk'];
				$row['admin_name'] = $this->crud_global->GetField('tbl_admin',array('admin_id'=>$row['created_by']),'admin_name');
                $row['created_on'] = date('d/m/Y H:i:s',strtotime($row['created_on']));
				
				$data[] = $row;
			}

		}
		echo json_encode(array('data'=>$data));
	}
    
	public function table_peralatan_kantor()
	{	
		$data = array();
		
		$this->db->where('kategori_produk','Peralatan Kantor');
		$this->db->where('status','PUBLISH');
		$this->db->order_by('nama_produk','asc');
		$query = $this->db->get('produk');
		if($query->num_rows() > 0){
			foreach ($query->result_array() as $key => $row) {
				$row['no'] = $key+1;
				$row['nama_produk'] = '<a href="'.site_url('produk/detail/'.$row['id']).'" >'.$row['nama_produk'].'</a>';
				$row['kategori_produk'] = $row['kategori_produk'];
				$row['admin_name'] = $this->crud_global->GetField('tbl_admin',array('admin_id'=>$row['created_by']),'admin_name');
                $row['created_on'] = date('d/m/Y H:i:s',strtotime($row['created_on']));
				
				$data[] = $row;
			}

		}
		echo json_encode(array('data'=>$data));
	}

    public function buat_baru()
    {

    	$id = $this->uri->segment(3);
    	$data['kategori'] = $this->m_produk->getKategori();

    	if(!empty($id)){
    		$data['edit'] = $this->db->get_where('produk',array('id'=>$id))->row_array();
    	}
		$this->load->view('produk/add',$data);
    }



    public function tambah_kategori_produk()
    {
    	$output['output'] = false;

        $nama_kategori_produk = $this->input->post('nama_kategori_produk');
        $status = 'PUBLISH';

        $data = array(
            'nama_kategori_produk' => $nama_kategori_produk,
            'status' => $status
        );

        $data['created_by'] = $this->session->userdata('admin_id');
        $data['created_on'] = date('Y-m-d H:i:s');
        if($this->db->insert('kategori_produk',$data)){
            $output['output'] = true;

            $query = $this->m_produk->getKategori();
            $data = array();
            $data[0] = array('id'=>'','text'=>'Pilih Kategori');
            foreach ($query as $key => $row) {

                $data[] = array('id'=>$row['id'],'text'=>$row['nama_kategori_produk']);
            }
            $output['data'] = $data;
        }   
        
        echo json_encode($output); 
    }

    public function form_produk()
    {
    	$this->db->trans_start(); # Starting Transaction

    	$id = $this->input->post('id');
    	$nama_produk = $this->input->post('nama_produk');
		$kategori_produk = $this->input->post('kategori_produk');
    	$data = array(
    		'nama_produk' => $nama_produk,
			'kategori_produk' => $kategori_produk
    	);

    	if(!empty($id)){
			$data['updated_by'] = $this->session->userdata('admin_id');
			$data['updated_on'] = date('Y-m-d H:i:s');
			$this->db->update('produk',$data,array('id'=>$id));
		}else{
			$data['created_by'] = $this->session->userdata('admin_id');
			$data['created_on'] = date('Y-m-d H:i:s');
			$this->db->insert('produk',$data);
		}

		if ($this->db->trans_status() === FALSE) {
            # Something went wrong.
            $this->db->trans_rollback();
            $this->session->set_flashdata('notif_error','Gagal Menambahkan Produk');
            redirect('produk/buat_baru');
        } 
        else {
            # Everything is Perfect. 
            # Committing data to the database.
            $this->db->trans_commit();
            $this->session->set_flashdata('notif_success','Berhasil Menambahkan Produk');
            redirect('admin/produk');
        }
    }

    public function hapus($id)
    {
    	$this->db->trans_start(); # Starting Transaction

    	$this->db->delete('produk',array('id'=>$id));

		if ($this->db->trans_status() === FALSE) {
            # Something went wrong.
            $this->db->trans_rollback();
            $this->session->set_flashdata('notif_error','Gagal Hapus Produk');
            redirect('produk/detail/'.$id);
        } 
        else {
            # Everything is Perfect. 
            # Committing data to the database.
            $this->db->trans_commit();
            $this->session->set_flashdata('notif_success','Berhasil Menghapus Produk');
            redirect('admin/produk');
        }
    }

    public function detail($id)
    {
    	$row = $this->db->get_where('produk',array('id'=>$id))->row_array();
    	if(!empty($id)){
    		$data['row'] = $row;
    		$this->load->view('produk/detail',$data);
    	}else {
    		$this->session->set_flashdata('notif_error','Produk Tidak Tersedia');
            redirect('admin/produk');
    	}

		
    }




 }
 ?>