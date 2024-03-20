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
                                            <div width="100%">
                                                <div class="panel panel-default">
                                                    <div class="col-sm-12">
                                                        <div class="panel panel-default">
                                                            <div class="panel-heading">												
                                                                <h3 class="panel-title">Laporan Pengiriman Penjualan</h3>
                                                                <a href="laporan_penjualan">Kembali</a>
                                                            </div>
                                                            <div style="margin: 20px">
                                                                <?php
                                                                $product = $this->db2->order_by('nama_produk', 'asc')->get_where('produk', array('status' => 'PUBLISH'))->result_array();
                                                                $client = $this->db2->order_by('nama', 'asc')->get_where('penerima', array('status' => 'PUBLISH', 'pelanggan' => 1))->result_array();
                                                                ?>
                                                                <div class="row">
                                                                    <form action="<?php echo site_url('laporan/cetak_pengiriman_penjualan_temef'); ?>" target="_blank">
                                                                        <div class="col-sm-3">
                                                                            <input type="text" id="filter_date_pengiriman_penjualan" name="filter_date" class="form-control dtpicker" value="<?php echo $_GET['filter_date'];?>" placeholder="Filter By Date">
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <select id="filter_client_id_pengiriman_penjualan" class="form-control select2" name="filter_client_id">
                                                                                <option value="">Pilih Pelanggan</option>
                                                                                <?php
                                                                                foreach ($client as $key => $cl) {
                                                                                ?>
                                                                                    <option value="<?php echo $cl['id']; ?>"><?php echo $cl['nama']; ?></option>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <select id="filter_product_pengiriman_penjualan" class="form-control select2" name="filter_product">
                                                                                <option value="">Pilih Produk</option>
                                                                                <?php
                                                                                foreach ($product as $key => $pro) {
                                                                                ?>
                                                                                    <option value="<?php echo $pro['id']; ?>"><?php echo $pro['nama_produk']; ?></option>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-sm-1 text-right">
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
                                                                    <table class="table table-hover table-center table-bordered" id="pengiriman-penjualan" style="display:none;">
                                                                        <thead>
                                                                            <tr class="judul">
                                                                                <th class="text-center">NO.</th>
                                                                                <th class="text-center">PELANGGAN / MUTU BETON</th>
                                                                                <th class="text-center">SATUAN</th>
                                                                                <th class="text-center">VOLUME</th>
                                                                                <th class="text-center">HARGA SATUAN</th>
                                                                                <th class="text-center">NILAI</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>

                                                                        </tbody>
                                                                        <tfoot>
                                                                    
                                                                        </tfoot>
                                                                    </table>

                                                                </div>
                                                            </div>
                                                        </div>
													</div>
                                                </div>
                                            </div>
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
            $('#filter_date_pengiriman_penjualan').daterangepicker({
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
            $('#filter_date_pengiriman_penjualan').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
                PengirimanPenjualan();
            });

            function PengirimanPenjualan() {
                $('#pengiriman-penjualan').show();
                $('#loader-table').fadeIn('fast');
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('pmm/productions/pengiriman_penjualan_temef'); ?>/" + Math.random(),
                    dataType: 'json',
                    data: {
                        filter_client_id: $('#filter_client_id_pengiriman_penjualan').val(),
                        filter_date: $('#filter_date_pengiriman_penjualan').val(),
                        filter_product: $('#filter_product_pengiriman_penjualan').val(),
                    },
                    success: function(result) {
                        if (result.data) {
                            $('#pengiriman-penjualan tbody').html('');
                              if (result.data.length > 0) {
                                $.each(result.data, function(i, val) {
                                    $('#pengiriman-penjualan tbody').append('<tr onclick="NextShow(' + val.no + ')" class="active" style="font-weight:bold;cursor:pointer;"background-color:#FF0000""><td class="text-center">' + val.no + '</td><td class="text-left" colspan="2">' + val.name + '</td><td class="text-right">' + val.real + '</td><td class="text-right"></td><td class="text-right">' + val.total_price + '</td></tr>');
                                    $.each(val.mats, function(a, row) {
                                        var a_no = a + 1;
                                        $('#pengiriman-penjualan tbody').append('<tr style="display:none;" class="mats-' + val.no + '"><td class="text-center"></td><td class="text-center">' + row.nama_produk + '</td><td class="text-center">' + row.measure + '</td><td class="text-right">' + row.real + '</td><td class="text-right">' + row.price + '</td><td class="text-right">' + row.total_price + '</td></tr>');
                                    });

                                });
                                $('#pengiriman-penjualan tbody').append('<tr style="background-color:#cccccc;"><td class="text-right" colspan="3"><b>TOTAL</b></td><td class="text-right" ><b>' + result.total_volume + '</b></td><td class="text-right" ></td><td class="text-right" ><b>' + result.total_nilai + '</b></td></tr>');
                            } else {
                                $('#pengiriman-penjualan tbody').append('<tr><td class="text-center" colspan="6"><b>Tidak Ada Data</b></td></tr>');
                            }
                            $('#loader-table').fadeOut('fast');
                        } else if (result.err) {
                            bootbox.alert(result.err);
                        }
                    }
                });
            }

            PengirimanPenjualan();

            $('#filter_product_pengiriman_penjualan').change(function() {
                PengirimanPenjualan();
            });

            $('#filter_client_id_pengiriman_penjualan').change(function() {
                PengirimanPenjualan();
            });

             function NextShow(id) {
                console.log('.mats-' + id);
                $('.mats-' + id).slideToggle();
            }
        </script>
        
</body>
</html>