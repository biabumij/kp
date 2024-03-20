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
		.mytable thead th {
		  background-color:	#e69500;
		  color: #000000;
		  text-align: center;
		  vertical-align: middle;
		  padding: 5px;
		}
		
		.mytable tbody td {
		  padding: 5px;
		}
		
		.mytable tfoot td {
		  background-color:	#e69500;
		  color: #000000;
		  padding: 5px;
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
                        <div class="panel" style="background: linear-gradient(90deg, #f8f8f8 20%, #dddddd 40%, #f8f8f8 80%);">
                            <div class="panel-content">
								<div class="panel-header">
									<h3 class="section-subtitle"><b><?php echo $row[0]->menu_name; ?></b></h3>
								</div>
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="pembelian">
                                        <br />
                                        <div class="row">
                                            <?php

                                            $this->db2->select('ps.nama');
                                            $this->db2->where("ps.rekanan = '1'");
                                            $this->db2->where("ps.status = 'PUBLISH'");
                                            $this->db2->order_by('ps.nama','asc');
                                            $query_temef = $this->db2->get('penerima ps');

                                            $this->db3->select('ps.nama');
                                            $this->db3->where("ps.rekanan = '1'");
                                            $this->db3->where("ps.status = 'PUBLISH'");
                                            $this->db3->order_by('ps.nama','asc');
                                            $query_sc = $this->db3->get('penerima ps');

                                            $results1 = $query_temef->result_array();
                                            $results2 = $query_sc->result_array();

                                            $suppliers = array_merge($results1,$results2);
                                            sort($suppliers);

                                            ?>
                                            <div width="100%">
                                                <div class="panel panel-default">
                                                    <div class="col-sm-5">
														<p><h5><b>Laporan Penerimaan</b></h5></p>
                                                        <a href="#penerimaan_pembelian" aria-controls="penerimaan_pembelian" role="tab" data-toggle="tab" class="btn btn-primary" style="font-weight:bold; border-radius:10px;">Lihat Laporan</a>
                                                    </div>
                                                    <div class="col-sm-5">
														<p><h5><b>Laporan Hutang</b></h5></p>
                                                        <a href="#laporan_hutang" aria-controls="laporan_hutang" role="tab" data-toggle="tab" class="btn btn-primary" style="font-weight:bold; border-radius:10px;">Lihat Laporan</a>
                                                    </div>
                                                    <div class="col-sm-5">
														<p><h5><b>Laporan Monitoring Hutang</b></h5></p>
                                                        <a href="#laporan_monitoring_hutang" aria-controls="laporan_monitoring_hutang" role="tab" data-toggle="tab" class="btn btn-primary" style="font-weight:bold; border-radius:10px;">Lihat Laporan</a>
                                                    </div>
                                                    <div class="col-sm-5">
														<p><h5><b>Daftar Pembayaran</b></h5></p>
                                                        <a href="#daftar_pembayaran" aria-controls="daftar_pembayaran" role="tab" data-toggle="tab" class="btn btn-primary" style="font-weight:bold; border-radius:10px;">Lihat Laporan</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Laporan Penerimaan Pembelian -->
                                    <div role="tabpanel" class="tab-pane" id="penerimaan_pembelian">
                                        <div class="col-sm-15">
										    <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title"><b>Laporan Penerimaan Pembelian</b></h3>
													<a href="laporan_pembelian">Kembali</a>
                                                </div>
												<div style="margin: 20px">
													<div class="row">
														<form action="<?php echo site_url('laporan/cetak_penerimaan_pembelian_int');?>" target="_blank">
															<div class="col-sm-3">
																<input type="text" id="filter_date_penerimaan_pembelian" name="filter_date" class="form-control dtpicker"  autocomplete="off" placeholder="Filter By Date">
															</div>
                                                            <div class="col-sm-3">
                                                                <select id="filter_supplier_penerimaan_pembelian" name="supplier_id" class="form-control select2">
                                                                    <option value="">Pilih Rekanan</option>
                                                                    <?php
                                                                    foreach ($suppliers as $key => $supplier) {
                                                                    ?>
                                                                        <option value="<?php echo $supplier['nama']; ?>"><?php echo $supplier['nama']; ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
															<div class="col-sm-3">
																<button type="submit" class="btn btn-default" style="border-radius:10px; font-weight:bold;"><i class="fa fa-print"></i>  Print</button>
															</div>
														</form>
														
													</div>
													<br />
													<div id="wait-penerimaan-pembelian" style=" text-align: center; align-content: center; display: none;">	
														<div>Please Wait</div>
														<div class="fa-3x">
														  <i class="fa fa-spinner fa-spin"></i>
														</div>
													</div>				
													<div class="table-responsive" id="penerimaan-pembelian">													
													
                    
													</div>
												</div>
										    </div>
										</div>
                                    </div>

                                    <!-- Laporan Hutang -->
                                    <div role="tabpanel" class="tab-pane" id="laporan_hutang">
                                        <div class="col-sm-15">
										    <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title"><b>Laporan Hutang</b></h3>
													<a href="laporan_pembelian">Kembali</a>
                                                </div>
												<div style="margin: 20px">
													<div class="row">
														<form action="<?php echo site_url('laporan/cetak_laporan_hutang_int');?>" target="_blank">
															<div class="col-sm-3">
																<input type="text" id="filter_date_laporan_hutang" name="filter_date" class="form-control dtpicker"  autocomplete="off" placeholder="Filter By Date">
															</div>
                                                            <div class="col-sm-3">
                                                                <select id="filter_supplier_laporan_hutang" name="supplier_id" class="form-control select2">
                                                                    <option value="">Pilih Rekanan</option>
                                                                    <?php
                                                                    foreach ($suppliers as $key => $supplier) {
                                                                    ?>
                                                                        <option value="<?php echo $supplier['nama']; ?>"><?php echo $supplier['nama']; ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
															<div class="col-sm-3">
																<button type="submit" class="btn btn-default" style="border-radius:10px; font-weight:bold;"><i class="fa fa-print"></i>  Print</button>
															</div>
														</form>
														
													</div>
													<br />
													<div id="wait-laporan_hutang-pembelian" style=" text-align: center; align-content: center; display: none;">	
														<div>Please Wait</div>
														<div class="fa-3x">
														  <i class="fa fa-spinner fa-spin"></i>
														</div>
													</div>				
													<div class="table-responsive" id="laporan-hutang">													
													
                    
													</div>
												</div>
										    </div>
										</div>
                                    </div>

                                    <!-- Laporan Monitoring Hutang -->
                                    <div role="tabpanel" class="tab-pane" id="laporan_monitoring_hutang">
                                        <div class="col-sm-15">
										    <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title"><b>Laporan Monitoring Hutang</b></h3>
													<a href="laporan_pembelian">Kembali</a>
                                                </div>
												<div style="margin: 20px">
													<div class="row">
														<form action="<?php echo site_url('laporan/cetak_laporan_monitoring_hutang_int');?>" target="_blank">
															<div class="col-sm-3">
																<input type="text" id="filter_date_monitoring_hutang" name="filter_date" class="form-control dtpicker"  autocomplete="off" placeholder="Filter By Date">
															</div>
                                                            <div class="col-sm-3">
                                                                <select id="filter_supplier_monitoring_hutang" name="supplier_id" class="form-control select2">
                                                                    <option value="">Pilih Rekanan</option>
                                                                    <?php
                                                                    foreach ($suppliers as $key => $supplier) {
                                                                    ?>
                                                                        <option value="<?php echo $supplier['nama']; ?>"><?php echo $supplier['nama']; ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
															<div class="col-sm-3">
																<button type="submit" class="btn btn-default" style="border-radius:10px; font-weight:bold;"><i class="fa fa-print"></i>  Print</button>
															</div>
														</form>
														
													</div>
													<br />
													<div id="wait-monitoring-hutang" style=" text-align: center; align-content: center; display: none;">	
														<div>Please Wait</div>
														<div class="fa-3x">
														  <i class="fa fa-spinner fa-spin"></i>
														</div>
													</div>				
													<div class="table-responsive" id="monitoring-hutang">													
													
                    
													</div>
												</div>
										    </div>
										</div>
                                    </div>

                                    <!-- Daftar Pembayaran -->
                                    <div role="tabpanel" class="tab-pane" id="daftar_pembayaran">
                                        <div class="col-sm-15">
										    <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title"><b>Daftar Pembayaran</b></h3>
													<a href="laporan_pembelian">Kembali</a>
                                                </div>
												<div style="margin: 20px">
													<div class="row">
														<form action="<?php echo site_url('laporan/cetak_daftar_pembayaran_int');?>" target="_blank">
															<div class="col-sm-3">
																<input type="text" id="filter_date_daftar_pembayaran" name="filter_date" class="form-control dtpicker"  autocomplete="off" placeholder="Filter By Date">
															</div>
                                                            <div class="col-sm-3">
                                                                <select id="filter_supplier_daftar_pembayaran" name="supplier_id" class="form-control select2">
                                                                    <option value="">Pilih Rekanan</option>
                                                                    <?php
                                                                    foreach ($suppliers as $key => $supplier) {
                                                                    ?>
                                                                        <option value="<?php echo $supplier['nama']; ?>"><?php echo $supplier['nama']; ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
															<div class="col-sm-3">
																<button type="submit" class="btn btn-default" style="border-radius:10px; font-weight:bold;"><i class="fa fa-print"></i>  Print</button>
															</div>
														</form>
														
													</div>
													<br />
													<div id="wait-daftar-pembayaran" style=" text-align: center; align-content: center; display: none;">	
														<div>Please Wait</div>
														<div class="fa-3x">
														  <i class="fa fa-spinner fa-spin"></i>
														</div>
													</div>				
													<div class="table-responsive" id="daftar-pembayaran">													
													
                    
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
		
            <!-- Script Penerimaan Pembelian -->
            <script type="text/javascript">

            $('#filter_date_penerimaan_pembelian').daterangepicker({
            autoUpdateInput : false,
            showDropdowns: true,
            locale: {
            format: 'DD-MM-YYYY'
            },
            ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(30, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            }
        });

        $('#filter_date_penerimaan_pembelian').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
            PenerimaanPembelian();
        });


        function PenerimaanPembelian()
        {
            $('#wait-penerimaan-pembelian').fadeIn('fast');   
            $.ajax({
                type    : "POST",
                url     : "<?php echo site_url('pmm/receipt_material/penerimaan_pembelian_int'); ?>/"+Math.random(),
                dataType : 'html',
                data: {
                    filter_date : $('#filter_date_penerimaan_pembelian').val(),
                    supplier_id : $('#filter_supplier_penerimaan_pembelian').val(),
                },
                success : function(result){
                    $('#penerimaan-pembelian').html(result);
                    $('#wait-penerimaan-pembelian').fadeOut('fast');
                }
            });
        }

        //PenerimaanPembelian();
        
        $('#filter_supplier_penerimaan_pembelian').change(function() {
            PenerimaanPembelian();
        });

        </script>

        <!-- Script Laporan Hutang -->
		<script type="text/javascript">

        $('#filter_date_laporan_hutang').daterangepicker({
            autoUpdateInput: false,
            showDropdowns : true,
            singleDatePicker: true,
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

        $('#filter_date_laporan_hutang').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('01-01-2021') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
            LaporanHutang();
        });


        function LaporanHutang()
        {
            $('#wait-laporan-hutang').fadeIn('fast');   
            $.ajax({
                type    : "POST",
                url     : "<?php echo site_url('pmm/receipt_material/laporan_hutang_int'); ?>/"+Math.random(),
                dataType : 'html',
                data: {
                    filter_date : $('#filter_date_laporan_hutang').val(),
                    supplier_id : $('#filter_supplier_laporan_hutang').val(),
                },
                success : function(result){
                    $('#laporan-hutang').html(result);
                    $('#wait-laporan-hutang').fadeOut('fast');
                }
            });
        }

        //LaporanHutang();

        $('#filter_supplier_laporan_hutang').change(function() {
            LaporanHutang();
        });

        </script>

        <!-- Script Laporan Hutang -->
		<script type="text/javascript">

        $('#filter_date_monitoring_hutang').daterangepicker({
            autoUpdateInput: false,
            showDropdowns : true,
            singleDatePicker: true,
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

        $('#filter_date_monitoring_hutang').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('01-01-2021') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
            LaporanMonitoringHutang();
        });


        function LaporanMonitoringHutang()
        {
            $('#wait-monitoring-hutang').fadeIn('fast');   
            $.ajax({
                type    : "POST",
                url     : "<?php echo site_url('pmm/receipt_material/monitoring_hutang_int'); ?>/"+Math.random(),
                dataType : 'html',
                data: {
                    filter_date : $('#filter_date_monitoring_hutang').val(),
                    supplier_id : $('#filter_supplier_monitoring_hutang').val(),
                },
                success : function(result){
                    $('#monitoring-hutang').html(result);
                    $('#wait-monitoring-hutang').fadeOut('fast');
                }
            });
        }

        //LaporanMonitoringHutang();

        $('#filter_supplier_monitoring_hutang').change(function() {
            LaporanMonitoringHutang();
        });

        </script>

        <!-- Script Laporan Hutang -->
		<script type="text/javascript">

        $('#filter_date_monitoring_hutang').daterangepicker({
            autoUpdateInput: false,
            showDropdowns : true,
            singleDatePicker: true,
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

        $('#filter_date_monitoring_hutang').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('01-01-2021') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
            LaporanMonitoringHutang();
        });


        function LaporanMonitoringHutang()
        {
            $('#wait-monitoring-hutang').fadeIn('fast');   
            $.ajax({
                type    : "POST",
                url     : "<?php echo site_url('pmm/receipt_material/monitoring_hutang_int'); ?>/"+Math.random(),
                dataType : 'html',
                data: {
                    filter_date : $('#filter_date_monitoring_hutang').val(),
                    supplier_id : $('#filter_supplier_monitoring_hutang').val(),
                },
                success : function(result){
                    $('#monitoring-hutang').html(result);
                    $('#wait-monitoring-hutang').fadeOut('fast');
                }
            });
        }

        //LaporanMonitoringHutang();

        $('#filter_supplier_monitoring_hutang').change(function() {
            LaporanMonitoringHutang();
        });

        </script>

        <!-- Script Daftar Pembayaran -->
        <script type="text/javascript">

        $('#filter_date_daftar_pembayaran').daterangepicker({
        autoUpdateInput : false,
        showDropdowns: true,
        locale: {
        format: 'DD-MM-YYYY'
        },
        ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(30, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
        });

        $('#filter_date_daftar_pembayaran').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
        DaftarPembayaran();
        });


        function DaftarPembayaran()
        {
        $('#wait-daftar-pembayaran').fadeIn('fast');   
        $.ajax({
            type    : "POST",
            url     : "<?php echo site_url('pmm/receipt_material/daftar_pembayaran_int'); ?>/"+Math.random(),
            dataType : 'html',
            data: {
                filter_date : $('#filter_date_daftar_pembayaran').val(),
                supplier_id : $('#filter_supplier_daftar_pembayaran').val(),
            },
            success : function(result){
                $('#daftar-pembayaran').html(result);
                $('#wait-daftar-pembayaran').fadeOut('fast');
            }
        });
        }

        //DaftarPembayaran();

        $('#filter_supplier_daftar_pembayaran').change(function() {
            DaftarPembayaran();
        });

        </script>

    </div>
</body>
</html>