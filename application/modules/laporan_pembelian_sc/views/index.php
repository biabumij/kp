<!doctype html>
<html lang="en" class="fixed">
<?php
$this->db2 = $this->load->database('database2', TRUE);
$this->db3 = $this->load->database('database3', TRUE);
?>

<head>
    <?php echo $this->Templates->Header(); ?>
	<style type="text/css">
        body {
            font-family: helvetica;
        }
        
        table tr.judul{
            background: linear-gradient(90deg, #333333 5%, #696969 50%, #333333 100%);
            color: #ffffff;
            font-weight: bold;
            font-size: 11px;
        }
    </style>
</head>

<body>
    <div class="wrap">

        <?php echo $this->Templates->PageHeader(); ?>

        <div class="page-body">
            <?php echo $this->Templates->LeftBar(); ?>
            <div class="content">
                <div class="content-header">
                    <div class="leftside-content-header">
                        <ul class="breadcrumbs">
                            <li><i class="fa fa-bar-chart" aria-hidden="true"></i>Laporan</li>
                            <li><a><?php echo $row[0]->menu_name; ?></a></li>
                        </ul>
                    </div>
                </div>
                <div class="row animated fadeInUp">
                    <div class="col-sm-12 col-lg-12">
                        <div class="panel">
                            <div class="panel-content">
								<div class="panel-header">
									<h3 class="section-subtitle"><?php echo $row[0]->menu_name; ?></h3>
								</div>
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="pembelian">
                                        <br />
                                        <div class="row">
                                            <?php
                                            $arr_po = $this->db3->order_by('id', ' no_po', 'supplier_id', 'asc')->get_where('pmm_purchase_order', array('status' => 'PUBLISH'))->result_array();
                                            $suppliers  = $this->db3->order_by('nama', 'asc')->select('*')->get_where('penerima', array('status' => 'PUBLISH', 'rekanan' => 1))->result_array();
                                            $materials = $this->db3->order_by('nama_produk', 'asc')->get_where('produk', array('status' => 'PUBLISH'))->result_array();
                                            $kategori = $this->db3->order_by('nama_kategori_produk', 'asc')->get_where('kategori_produk', array('status' => 'PUBLISH'))->result_array();
                                            $status = $this->db3->group_by('status', 'asc')->get_where('pmm_penagihan_pembelian')->result_array();
                                            ?>
                                            <div width="100%">
                                                <div class="panel panel-default">
                                                    <div class="col-sm-12">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">												
                                                                <h3 class="panel-title">Laporan Penerimaan Pembelian</h3>
                                                                <a href="laporan_pembelian">Kembali</a>
                                                            </div>
                                                            <div style="margin: 20px">
                                                                <div class="row">
                                                                    <form action="<?php echo site_url('laporan/cetak_penerimaan_pembelian_sc'); ?>" target="_blank">
                                                                        <div class="col-sm-3">
                                                                            <input type="text" id="filter_date_penerimaan_pembelian" name="filter_date" class="form-control dtpicker" value="<?php echo $_GET['filter_date'];?>" placeholder="Filter by Date">
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <select id="filter_kategori_b" name="filter_kategori" class="form-control select2">
                                                                                <option value="">Pilih Kategori</option>
                                                                                <?php
                                                                                foreach ($kategori as $key => $kat) {
                                                                                ?>
                                                                                    <option value="<?php echo $kat['id']; ?>"><?php echo $kat['nama_kategori_produk']; ?></option>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>      
                                                                        <div class="col-sm-3">
                                                                            <select id="filter_material_penerimaan_pembelian" name="filter_material" class="form-control select2">
                                                                                <option value="">Pilih Produk</option>
                                                                                <?php
                                                                                foreach ($materials as $key => $mats) {
                                                                                ?>
                                                                                    <option value="<?php echo $mats['id']; ?>"><?php echo $mats['nama_produk']; ?></option>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <select id="filter_supplier_penerimaan_pembelian" name="supplier_id" class="form-control select2">
                                                                                <option value="">Pilih Rekanan</option>
                                                                                <?php
                                                                                foreach ($suppliers as $key => $supplier) {
                                                                                ?>
                                                                                    <option value="<?php echo $supplier['id']; ?>"><?php echo $supplier['nama']; ?></option>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <br /><br />
                                                                        <div class="col-sm-3">
                                                                            <select id="filter_kategori_bahan" name="filter_kategori_bahan" class="form-control select2">
                                                                                <option value="">Pilih Kategori Bahan</option>
                                                                                <?php
                                                                                foreach ($kategori_bahan as $key => $bahan) {
                                                                                ?>
                                                                                    <option value="<?php echo $bahan['id']; ?>"><?php echo $bahan['nama_kategori_bahan']; ?></option>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <br /><br />
                                                                        <div class="col-sm-9 text-left">
                                                                            <button class="btn btn-default" type="submit" id="btn-print" style="border-radius:10px; font-weight:bold;"><i class="fa fa-print"></i> Print</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                                <br />
                                                                <div id="box-print" class="table-responsive">
                                                                    <div id="loader-table" class="text-center" style="display:none">
                                                                        <img src="<?php echo base_url(); ?>assets/back/theme/images/loader.gif">
                                                                        <div>
                                                                            Please Wait
                                                                        </div>
                                                                    </div>
                                                                    <table class="table table-hover table-center table-bordered" id="penerimaan-pembelian" style="display:none;">
                                                                        <thead>
                                                                        <tr class="judul">
                                                                            <th class="text-center" rowspan="2" style="vertical-align:middle;">NO.</th>
                                                                            <th class="text-center">REKANAN</th>
                                                                            <th class="text-center" rowspan="2" style="vertical-align:middle;">SATUAN</th>
                                                                            <th class="text-center" rowspan="2" style="vertical-align:middle;">VOLUME</th>
                                                                            <th class="text-center" rowspan="2" style="vertical-align:middle;">HARGA SATUAN</th>
                                                                            <th class="text-center" rowspan="2" style="vertical-align:middle;">NILAI</th>
                                                                        </tr>
                                                                        <tr class="judul">
                                                                            <th class="text-center">PRODUK</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody></tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
													</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    
                                    <!-- Laporan Penerimaan Pembelian -->
                                    <div role="tabpanel" class="tab-pane" id="laporan_penerimaan_pembelian">
                                        <div class="col-sm-15">
                                            
                                        </div>
									</div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>

        <?php echo $this->Templates->Footer(); ?>

        <script src="<?php echo base_url(); ?>assets/back/theme/vendor/daterangepicker/moment.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/back/theme/vendor/daterangepicker/daterangepicker.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/back/theme/vendor/daterangepicker/daterangepicker.css">
        <script src="<?php echo base_url(); ?>assets/back/theme/vendor/bootbox.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/back/theme/vendor/jquery.number.min.js"></script>
        <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>
		
        <script type="text/javascript">
        $('input.numberformat').number(true, 4, ',', '.');
        $('#filter_date_penerimaan_pembelian').daterangepicker({
            autoUpdateInput: false,
            showDropdowns: true,
            locale: {
                format: 'DD-MM-YYYY'
            },
            ranges: {
                'Today': [moment(), moment()],
                'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        });

        $('#filter_date_penerimaan_pembelian').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
            PenerimaanPembelian();
        });

        function PenerimaanPembelian() {
            $('#penerimaan-pembelian').show();
            $('#loader-table').fadeIn('fast');
            $('#penerimaan-pembelian tbody').html('');
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('pmm/receipt_material/penerimaan_pembelian_sc'); ?>/" + Math.random(),
                dataType: 'json',
                data: {
                    purchase_order_no: $('#filter_po_id_penerimaan_pembelian').val(),
                    supplier_id: $('#filter_supplier_penerimaan_pembelian').val(),
                    filter_date: $('#filter_date_penerimaan_pembelian').val(),
                    filter_material: $('#filter_material_penerimaan_pembelian').val(),
                    filter_kategori: $('#filter_kategori_b').val(),
                    filter_kategori_bahan: $('#filter_kategori_bahan').val(),
                },
                    success: function(result) {
                    if (result.data) {
                        $('#penerimaan-pembelian tbody').html('');

                        if (result.data.length > 0) {
                            $.each(result.data, function(i, val) {
                                $('#penerimaan-pembelian tbody').append('<tr onclick="NextShowPembelian(' + val.no + ')" class="active" style="font-size:11px;font-weight:bold;cursor:pointer;background-color:#FF0000"><td class="text-center">' + val.no + '</td><td class="text-left">' + val.name + '</td><td class="text-center">' + val.measure + '</td><td class="text-right">' + val.volume + '</td><td class="text-right"></td><td class="text-right">' + val.total_price + '</td></tr>');
                                $.each(val.mats, function(a, row) {
                                    var a_no = a + 1;
                                    $('#penerimaan-pembelian tbody').append('<tr style="display:none;font-size:11px;" class="mats-' + val.no + '"><td class="text-center"></td><td class="text-left">&nbsp;&nbsp;&nbsp;' + row.nama_produk + '</td><td class="text-center">' + row.measure + '</td><td class="text-right">' + row.volume + '</td><td class="text-right">' + row.price + '</td><td class="text-right">' + row.total_price + '</td></tr>');
                                });

                            });
                            $('#penerimaan-pembelian tbody').append('<tr style="font-size:11px;background-color:#cccccc;"><td class="text-right" colspan="3"><b>TOTAL</b></td><td class="text-right" ><b>' + result.total_volume + '</b></td><td class="text-right" ></td><td class="text-right" ><b>' + result.total_nilai + '</b></td></tr>');
                        } else {
                            $('#penerimaan-pembelian tbody').append('<tr style="font-size:11px;"><td class="text-center" colspan="6"><b>Tidak Ada Data</b></td></tr>');
                        }
                        $('#loader-table').fadeOut('fast');
                    } else if (result.err) {
                        bootbox.alert(result.err);
                    }
                }
            });
        }

        function NextShowPembelian(id) {
            console.log('.mats-' + id);
            $('.mats-' + id).slideToggle();
        }

        PenerimaanPembelian();

        function GetPO() {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('pmm/receipt_material/get_po_by_supp'); ?>/" + Math.random(),
                dataType: 'json',
                data: {
                    supplier_id: $('#filter_supplier_penerimaan_pembelian').val(),
                },
                success: function(result) {
                    if (result.data) {
                        $('#filter_po_id_penerimaan_pembelian').empty();
                        $('#filter_po_id_penerimaan_pembelian').select2({
                            data: result.data
                        });
                        $('#filter_po_id_penerimaan_pembelian').trigger('change');
                    } else if (result.err) {
                        bootbox.alert(result.err);
                    }
                }
            });
        }

        $('#filter_supplier_penerimaan_pembelian').change(function() {
            PenerimaanPembelian();
            GetPO();
        });

        $('#filter_po_id_penerimaan_pembelian').change(function() {
            PenerimaanPembelian();
        });

        $('#filter_material_penerimaan_pembelian').change(function() {
            PenerimaanPembelian();
        });

        $('#filter_kategori_b').change(function() {
            PenerimaanPembelian();
        });

        $('#filter_kategori_bahan').change(function() {
            PenerimaanPembelian();
        });

    </script>
        
</body>
</html>