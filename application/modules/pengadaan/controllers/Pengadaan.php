<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pengadaan extends Secure_Controller {

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
			$this->load->view('pengadaan/form', $data);
		} else {
			redirect('admin');
		}
	}

	public function add_produk()
    {
        $no = $this->input->post('no');
        $produk = $this->db->order_by('nama_produk', 'asc')->select('*')->get_where('produk', array('status' => 'PUBLISH'))->result_array();
		$satuan = $this->db->order_by('nama_satuan', 'asc')->select('*')->get_where('satuan', array('status' => 'PUBLISH'))->result_array();
	?>
        <tr>
            <td><?php echo $no; ?>.</td>
            <td>
				<select id="produk-<?php echo $no; ?>" onchange="changeData(<?php echo $no; ?>)" class="form-control form-select2" name="produk_<?php echo $no; ?>">
					<option value="">Pilih Produk</option>
					<?php
					if(!empty($produk)){
						foreach ($produk as $row) {
							?>
							<option value="<?php echo $row['nama_produk'];?>"><?php echo $row['nama_produk'];?></option>
							<?php
						}
					}
					?>
				</select>
			</td>
            <td>
				<input type="number" min="0" name="qty_<?php echo $no; ?>" id="qty-<?php echo $no; ?>" onchange="changeData(<?php echo $no; ?>)" class="form-control input-sm text-center" />
			</td>
			<td>
				<select id="satuan-<?php echo $no; ?>" class="form-control form-select2" name="satuan_<?php echo $no; ?>" required="">
						<option value="">Pilih Satuan</option>
						<?php
						if(!empty($satuan)){
							foreach ($satuan as $sat) {
								?>
								<option value="<?php echo $sat['nama_satuan'];?>"><?php echo $sat['nama_satuan'];?></option>
								<?php
							}
						}
						?>
					</select>
				</td>
			<td>
				<input type="text" name="harga_satuan_<?php echo $no; ?>" id="harga_satuan-<?php echo $no; ?>" class="form-control numberformat tex-left input-sm text-right" onchange="changeData(<?php echo $no; ?>)" />
			</td>
			<td>
				<input type="text" name="jumlah_<?php echo $no; ?>" id="jumlah-<?php echo $no; ?>" class="form-control numberformat tex-left input-sm text-right" readonly="" />
			</td>
			<td>
				<input type="text" name="keterangan_<?php echo $no; ?>" id="keterangan-<?php echo $no; ?>" class="form-control input-sm text-center"/>
			</td>
		</tr>

        <script type="text/javascript">
            $('.form-select2').select2();
            $('input.numberformat').number(true, 0, ',', '.');
        </script>
    <?php
    }

	public function submit_pengadaan()
    {
		$judul = $this->input->post('judul');
		$tanggal_permintaan = $this->input->post('tanggal_permintaan');
        $total_product = $this->input->post('total_product');
        $total = $this->input->post('total');

        $arr_insert = array(
			'judul' => $judul,
            'tanggal_permintaan' => date('Y-m-d', strtotime($tanggal_permintaan)),
            'total' => $total,
            'created_by' => $this->session->userdata('admin_id'),
            'created_on' => date('Y-m-d H:i:s'),
            'status' => 'PUBLISH'
        );


        if ($this->db->insert('pengadaan', $arr_insert)) {
            $pengadaan_id = $this->db->insert_id();

            for ($i = 1; $i <= $total_product; $i++) {
				$produk = $this->input->post('produk_' . $i);
				$qty = $this->input->post('qty_' . $i);
				$satuan = $this->input->post('satuan_' . $i);
				$keterangan = $this->input->post('keterangan_' . $i);


				$harga_satuan = $this->input->post('harga_satuan_' . $i);
				$harga_satuan = str_replace('.', '', $harga_satuan);
				$harga_satuan = str_replace(',', '.', $harga_satuan);

				$jumlah_pro = $this->input->post('jumlah_' . $i);
				$jumlah_pro = str_replace('.', '', $jumlah_pro);
				$jumlah_pro = str_replace(',', '.', $jumlah_pro);

				if (!empty($produk)) {

                    $arr_detail = array(
                        'pengadaan_id' => $pengadaan_id,
                        'produk' => $produk,
                        'qty' => $qty,
                        'satuan' => $satuan,
                        'harga_satuan' => $harga_satuan,
                        'jumlah' => $jumlah_pro,
						'keterangan' => $keterangan
                    );

                    $this->db->insert('pengadaan_detail', $arr_detail);
                } else {
                    redirect('produksi/pengadaan');
                    exit();
                }
            }
        }

        if ($this->db->trans_status() === FALSE) {
            # Something went wrong.
            $this->db->trans_rollback();
            $this->session->set_flashdata('notif_error', 'Gagal Menambahkan Penawaran Pembelian !!');
            redirect('pengadaan/pengadaan');
        } else {
            # Everything is Perfect. 
            # Committing data to the database.
            $this->db->trans_commit();
            $this->session->set_flashdata('notif_success', 'Berhasil Menambahkan Penawaran Pembelian !!');
            redirect('admin/pengadaan');
        }
    }

	public function table_pengadaan()
	{   
        $data = array();
		$filter_date = $this->input->post('filter_date');
		if(!empty($filter_date)){
			$arr_date = explode(' - ', $filter_date);
			$this->db->where('p.tanggal_permintaan >=',date('Y-m-d',strtotime($arr_date[0])));
			$this->db->where('p.tanggal_permintaan <=',date('Y-m-d',strtotime($arr_date[1])));
		}
        $this->db->select('p.*');
		$this->db->order_by('p.tanggal_permintaan','desc');
		$this->db->order_by('p.id','desc');		
		$query = $this->db->get('pengadaan p');
		
       if($query->num_rows() > 0){
			foreach ($query->result_array() as $key => $row) {
                $row['no'] = $key+1;
				$row['judul'] = "<a href=" . base_url('pengadaan/cetak_pengadaan/' . $row["id"]) .' target="_blank">'. $row["judul"] . "</a>";
				$row['tanggal_permintaan'] = date('d F Y', strtotime($row['tanggal_permintaan']));
				$row['hapus'] = '<a href="javascript:void(0);" onclick="HapusPengadaan('.$row['id'].')" class="btn btn-danger"><i class="fa fa-close"></i> </a>';
				
                $data[] = $row;
            }

        }
        echo json_encode(array('data'=>$data));
    }

	public function cetak_pengadaan($id){

		$this->load->library('pdf');
	

		$pdf = new Pdf('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(true);
        $pdf->SetFont('helvetica','',7); 
        $tagvs = array('div' => array(0 => array('h' => 0, 'n' => 0), 1 => array('h' => 0, 'n'=> 0)));
		$pdf->setHtmlVSpace($tagvs);
		$pdf->AddPage('P');

		$data['id'] = $id;
        $html = $this->load->view('pengadaan/cetak_pengadaan',$data,TRUE);
        
        $pdf->SetTitle('BBJ - Pengadaan Barang & Jasa');
        $pdf->nsi_html($html);
		$pdf->Output('pengadaan-barang-jasa.pdf', 'I');
	}

	public function hapus_pengadaan()
	{
		$output['output'] = false;
		$id = $this->input->post('id');
		if(!empty($id)){
			$this->db->delete('pengadaan',array('id'=>$id));
			$this->db->delete('pengadaan_detail',array('pengadaan_id'=>$id));
			{
				$output['output'] = true;
			}
		}
		echo json_encode($output);
	}

}
?>