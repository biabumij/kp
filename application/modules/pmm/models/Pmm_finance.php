<?php

class Pmm_finance extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
        $this->load->model('crud_global');
    }


    function NoInvoice()
    {
    	$no_invoice = '';
    	$get_last = $this->db->select('id')->order_by('id','desc')->get('pmm_penagihan_penjualan')->row_array();	
    	$id = 0;
    	if(!empty($get_last)){
    		$id = $get_last['id'] + 1;
    	}else {
    		$id = 1;
    	}
    	$no_invoice = str_pad($id, 3, '0', STR_PAD_LEFT).'/INV/BIABUMI-PRM/'.date('m').'/'.date('Y');
    	return $no_invoice;
    }


    function InsertTransactions($akun,$description,$debit,$kredit)
    {
        $data = array(
            'coa_id' => $akun,
            'description' => $description,
            'debit' => $debit,
            'credit' => $kredit,
            'created_by' => $this->session->userdata('admin_id')
        );
        $this->db->insert('transactions',$data);
    }

    function InsertLogs($log_type,$table_name,$table_id,$description)
    {
        $data = array(
            'log_type' => $log_type,
            'table_name' => $table_name,
            'table_id' => $table_id,
            'description' => $description,
            'created_by' => $this->session->userdata('admin_id')
        );
        $this->db->insert('logs',$data);
    }

    function getSalesPoPpn($id)
    {
        $total = 0;

        $this->db->select('SUM(tax) as tax');
        $this->db->where('sales_po_id',$id);
        //$this->db->where('tax_id',3);
        $this->db->where("tax_id in (3,6)");
        $query = $this->db->get('pmm_sales_po_detail')->row_array();
        //file_put_contents("D:\\getSalesPoPpn.txt", $this->db->last_query());
        if(!empty($query)){
            $total = $query['tax'];
        }
        return $total;
    }


    function getTotalPembayaranPenagihanPenjualan($id)
    {   
        $total = 0;

        $this->db->select('SUM(total) as total');
        $this->db->where('penagihan_id',$id);
        $this->db->where('status','Disetujui');
        $query = $this->db->get('pmm_pembayaran')->row_array();
        if(!empty($query)){
            $total = $query['total'];
        }
        return $total;
    }

    
    function getTotalPembayaranPenagihanPembelian($id)
    {   
        $total = 0;

        $this->db->select('SUM(total) as total');
        $this->db->where('penagihan_pembelian_id',$id);
        $this->db->where('status','Disetujui');
        $query = $this->db->get('pmm_pembayaran_penagihan_pembelian')->row_array();
        if(!empty($query)){
            $total = $query['total'];
        }
        return $total;
    }

    function getVerifDokumen($id)
    {
        $data = array();
        $this->db->select('pvp.*, (pvp.nilai_tagihan + pvp.ppn - pvp.pph) as total_tagihan, ps.nama as supplier_name');
        $this->db->join('pmm_penagihan_pembelian pp','pvp.penagihan_pembelian_id = pp.id','left');
        $this->db->join('penerima ps','ps.id = pp.supplier_id','left');
        $query = $this->db->get_where('pmm_verifikasi_penagihan_pembelian pvp',array('pvp.penagihan_pembelian_id'=>$id))->row_array();

        if(!empty($query)){
            $query['tanggal_po'] = date('d/m/Y',strtotime($query['tanggal_po']));
            $query['tanggal_invoice'] = date('d/m/Y',strtotime($query['tanggal_invoice']));
            $query['tanggal_diterima_office'] = date('d/m/Y',strtotime($query['tanggal_diterima_office']));
            $query['tanggal_diterima_proyek'] = date('d/m/Y',strtotime($query['tanggal_diterima_proyek']));
            $query['nilai_kontrak'] = number_format($query['nilai_kontrak'],0,',','.');
            $query['nilai_tagihan'] =  number_format($query['nilai_tagihan'],0,',','.');
            $query['ppn'] =  number_format($query['ppn'],0,',','.');
            $query['pph'] =  number_format($query['pph'],0,',','.');
            $query['total_tagihan'] =  number_format($query['total_tagihan'],0,',','.');
            $query['verifikator'] = $this->crud_global->GetField('tbl_admin',array('admin_id'=>$query['created_by']),'admin_name');
            $data = $query;
        }

        return $data;
    }

    function getVerifDokumenById($id)
    {
        $data = array();
        $this->db->select('pvp.*, (pvp.nilai_tagihan + pvp.ppn - pvp.pph) as total_tagihan, ps.nama as supplier_name');
        $this->db->join('pmm_penagihan_pembelian pp','pvp.penagihan_pembelian_id = pp.id','left');
        $this->db->join('penerima ps','ps.id = pp.supplier_id','left');
        $query = $this->db->get_where('pmm_verifikasi_penagihan_pembelian pvp',array('pvp.id'=>$id))->row_array();
        

        if(!empty($query)){
            $query['tanggal_po'] = date('d/m/Y',strtotime($query['tanggal_po']));
            $query['tanggal_invoice'] = date('d/m/Y',strtotime($query['tanggal_invoice']));
            $query['tanggal_diterima_proyek'] = date('d/m/Y',strtotime($query['tanggal_diterima_proyek']));
            $query['tanggal_diterima_office'] = date('d/m/Y',strtotime($query['tanggal_diterima_office']));
            $query['nilai_kontrak'] = number_format($query['nilai_kontrak'],0,',','.');
            $query['nilai_tagihan'] = number_format($query['nilai_tagihan'],0,',','.');
            $query['ppn'] = number_format($query['ppn'],0,',','.');
            $query['pph'] = number_format($query['pph'],0,',','.');
            $query['total_tagihan'] = number_format($query['total_tagihan'],0,',','.');
            $query['verifikator'] = $this->crud_global->GetField('tbl_admin',array('admin_id'=>$query['created_by']),'admin_name');
            $data = $query;
        }

        return $data;
    }

    function CheckorNo($id)
    {
        $output = 'X';

        if(!empty($id)){
            if($id == 1){
                $output = 'V';
            }
        }
        return $output;
    }

    function CheckorNoNew($id)
    {
        $output = '';

        if(!empty($id)){
            if($id >= 0){
                $output = 'V';
            }
        }
        return $output;
    }

    function CheckorNoNew2($id)
    {
        $output = '';

        if(!empty($id)){
            if($id >= 65){
                $output = 'V';
            }
        }
        return $output;
    }

    function CheckorNoNew3($id)
    {
        $output = '';

        if(!empty($id)){
            if($id >= 56 && $id <= 65){
                $output = 'V';
            }
        }
        return $output;
    }

    function CheckorNoNew4($id)
    {
        $output = '';

        if(!empty($id)){
            if($id <= 55){
                $output = 'V';
            }
        }
        return $output;
    }


    function BankCash()
    {
        $output = array();
        // Setor Bank
        $this->db->select('c.*');
        $this->db->where('c.coa_category',3);
        $this->db->where('c.status','PUBLISH');
        $this->db->order_by('c.coa_number','asc');
        $query = $this->db->get('pmm_coa c');
        $output = $query->result_array();
        return $output;
    }

    function getAkunCoa()
    {
        $output = array();
        // Setor Bank
        $this->db->select('c.*');
        // $this->db->where('c.coa_category',3);
        $this->db->where('c.status','PUBLISH');
        $this->db->order_by('c.coa_number','asc');
        $query = $this->db->get('pmm_coa c');
        $output = $query->result_array();
        return $output;
    }


    function GetSaldoKasBank($id)
    {
        $output = 0;

        $this->db->select('(SUM(debit) - SUM(credit)) as total');
        $this->db->where('coa_id',$id);
        $query = $this->db->get('transactions')->row_array();

        // print_r($query);
        if(!empty($query['total'])){
            $output = $query['total'];
        }
        return $output;
    }

}