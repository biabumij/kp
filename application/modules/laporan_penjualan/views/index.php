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
                                            $this->db2->where("ps.pelanggan = '1'");
                                            $this->db2->where("ps.status = 'PUBLISH'");
                                            $this->db2->order_by('ps.nama','asc');
                                            $query_temef = $this->db2->get('penerima ps');

                                            $this->db3->select('ps.nama');
                                            $this->db3->where("ps.pelanggan = '1'");
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
														<p><h5><b>Laporan Pengiriman Penjualan</b></h5></p>
                                                        <a href="#pengiriman_penjualan" aria-controls="pengiriman_penjualan" role="tab" data-toggle="tab" class="btn btn-primary" style="font-weight:bold; border-radius:10px;">Lihat Laporan</a>
                                                    </div>
                                                    <div class="col-sm-5">
														<p><h5><b>Laporan Piutang</b></h5></p>
                                                        <a href="#laporan_piutang" aria-controls="laporan_piutang" role="tab" data-toggle="tab" class="btn btn-primary" style="font-weight:bold; border-radius:10px;">Lihat Laporan</a>
                                                    </div>
                                                    <div class="col-sm-5">
														<p><h5><b>Laporan Monitoring Piutang</b></h5></p>
                                                        <a href="#laporan_monitoring_piutang" aria-controls="laporan_monitoring_piutang" role="tab" data-toggle="tab" class="btn btn-primary" style="font-weight:bold; border-radius:10px;">Lihat Laporan</a>
                                                    </div>
                                                    <div class="col-sm-5">
														<p><h5><b>Daftar Penerimaan</b></h5></p>
                                                        <a href="#daftar_penerimaan" aria-controls="daftar_penerimaan" role="tab" data-toggle="tab" class="btn btn-primary" style="font-weight:bold; border-radius:10px;">Lihat Laporan</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Laporan Pengiriman Penjualan -->
                                    <div role="tabpanel" class="tab-pane" id="pengiriman_penjualan">
                                        <div class="col-sm-15">
										    <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title"><b>Laporan Pengiriman Penjualan</b></h3>
													<a href="laporan_penjualan">Kembali</a>
                                                </div>
												<div style="margin: 20px">
													<div class="row">
														<form action="<?php echo site_url('laporan/cetak_pengiriman_penjualan_int');?>" target="_blank">
															<div class="col-sm-3">
																<input type="text" id="filter_date_pengiriman_penjualan" name="filter_date" class="form-control dtpicker"  autocomplete="off" placeholder="Filter By Date">
															</div>
                                                            <div class="col-sm-3">
                                                                <select id="filter_supplier_pengiriman_penjualan" name="supplier_id" class="form-control select2">
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
													<div id="wait-pengiriman-penjualan" style=" text-align: center; align-content: center; display: none;">	
														<div>Please Wait</div>
														<div class="fa-3x">
														  <i class="fa fa-spinner fa-spin"></i>
														</div>
													</div>				
													<div class="table-responsive" id="pengiriman-penjualan">													
													
                    
													</div>
												</div>
										    </div>
										</div>
                                    </div>

                                    <!-- Laporan Piutang -->
                                    <div role="tabpanel" class="tab-pane" id="laporan_piutang">
                                        <div class="col-sm-15">
										    <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title"><b>Laporan Piutang</b></h3>
													<a href="laporan_penjualan">Kembali</a>
                                                </div>
												<div style="margin: 20px">
													<div class="row">
														<form action="<?php echo site_url('laporan/cetak_laporan_piutang_int');?>" target="_blank">
															<div class="col-sm-3">
																<input type="text" id="filter_date_laporan_piutang" name="filter_date" class="form-control dtpicker"  autocomplete="off" placeholder="Filter By Date">
															</div>
                                                            <div class="col-sm-3">
                                                                <select id="filter_supplier_laporan_piutang" name="supplier_id" class="form-control select2">
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
													<div id="wait-laporan-piutang" style=" text-align: center; align-content: center; display: none;">	
														<div>Please Wait</div>
														<div class="fa-3x">
														  <i class="fa fa-spinner fa-spin"></i>
														</div>
													</div>				
													<div class="table-responsive" id="laporan-piutang">													
													
                    
													</div>
												</div>
										    </div>
										</div>
                                    </div>

                                    <!-- Laporan Monitoring Piutang -->
                                    <div role="tabpanel" class="tab-pane" id="laporan_monitoring_piutang">
                                        <div class="col-sm-15">
										    <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title"><b>Laporan Monitoring Piutang</b></h3>
													<a href="laporan_penjualan">Kembali</a>
                                                </div>
												<div style="margin: 20px">
													<div class="row">
														<form action="<?php echo site_url('laporan/cetak_laporan_monitoring_piutang_int');?>" target="_blank">
															<div class="col-sm-3">
																<input type="text" id="filter_date_monitoring_piutang" name="filter_date" class="form-control dtpicker"  autocomplete="off" placeholder="Filter By Date">
															</div>
                                                            <div class="col-sm-3">
                                                                <select id="filter_supplier_monitoring_piutang" name="supplier_id" class="form-control select2">
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
													<div id="wait-monitoring-piutang" style=" text-align: center; align-content: center; display: none;">	
														<div>Please Wait</div>
														<div class="fa-3x">
														  <i class="fa fa-spinner fa-spin"></i>
														</div>
													</div>				
													<div class="table-responsive" id="monitoring-piutang">													
													
                    
													</div>
												</div>
										    </div>
										</div>
                                    </div>

                                    <!-- Daftar Penerimaan -->
                                    <div role="tabpanel" class="tab-pane" id="daftar_penerimaan">
                                        <div class="col-sm-15">
										    <div class="panel panel-default">
                                                <div class="panel-heading">
                                                    <h3 class="panel-title"><b>Daftar Penerimaan</b></h3>
													<a href="laporan_penjualan">Kembali</a>
                                                </div>
												<div style="margin: 20px">
													<div class="row">
														<form action="<?php echo site_url('laporan/cetak_daftar_penerimaan_int');?>" target="_blank">
															<div class="col-sm-3">
																<input type="text" id="filter_date_daftar_penerimaan" name="filter_date" class="form-control dtpicker"  autocomplete="off" placeholder="Filter By Date">
															</div>
                                                            <div class="col-sm-3">
                                                                <select id="filter_supplier_daftar_penerimaan" name="supplier_id" class="form-control select2">
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
													<div id="wait-daftar-penerimaan" style=" text-align: center; align-content: center; display: none;">	
														<div>Please Wait</div>
														<div class="fa-3x">
														  <i class="fa fa-spinner fa-spin"></i>
														</div>
													</div>				
													<div class="table-responsive" id="daftar-penerimaan">													
													
                    
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
            $('#filter_date_pengiriman_penjualan').daterangepicker({
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

            $('#filter_date_pengiriman_penjualan').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
                PengirimanPenjualan();
            });


            function PengirimanPenjualan()
            {
                $('#wait-pengiriman-penjualan').fadeIn('fast');   
                $.ajax({
                    type    : "POST",
                    url     : "<?php echo site_url('pmm/productions/pengiriman_penjualan_int'); ?>/"+Math.random(),
                    dataType : 'html',
                    data: {
                        filter_date : $('#filter_date_pengiriman_penjualan').val(),
                        supplier_id : $('#filter_supplier_pengiriman_penjualan').val(),
                    },
                    success : function(result){
                        $('#pengiriman-penjualan').html(result);
                        $('#wait-pengiriman-penjualan').fadeOut('fast');
                    }
                });
            }

            //PengirimanPenjualan();
            
            $('#filter_supplier_pengiriman_penjualan').change(function() {
                PengirimanPenjualan();
            });

        </script>

        <!-- Script Laporan Piutang -->
        <script type="text/javascript">
            $('#filter_date_laporan_piutang').daterangepicker({
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
                'Last 30 Days': [moment().subtract(30, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            });

            $('#filter_date_laporan_piutang').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('01-01-2021') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
            LaporanPiutang();
        });


            function LaporanPiutang()
            {
                $('#wait-laporan-piutang').fadeIn('fast');   
                $.ajax({
                    type    : "POST",
                    url     : "<?php echo site_url('pmm/productions/laporan_piutang_int'); ?>/"+Math.random(),
                    dataType : 'html',
                    data: {
                        filter_date : $('#filter_date_laporan_piutang').val(),
                        supplier_id : $('#filter_supplier_laporan_piutang').val(),
                    },
                    success : function(result){
                        $('#laporan-piutang').html(result);
                        $('#wait-laporan-piutang').fadeOut('fast');
                    }
                });
            }

            //LaporanPiutang();
            
            $('#filter_supplier_laporan_piutang').change(function() {
                LaporanPiutang();
            });

        </script>

        <!-- Script Monitoring Piutang -->
        <script type="text/javascript">
            $('#filter_date_monitoring_piutang').daterangepicker({
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
                'Last 30 Days': [moment().subtract(30, 'days'), moment()],
                'This Month': [moment().startOf('month'), moment().endOf('month')],
                'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
                }
            });

            $('#filter_date_monitoring_piutang').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('01-01-2021') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
                MonitoringPiutang();
            });


            function MonitoringPiutang()
            {
                $('#wait-laporan-piutang').fadeIn('fast');   
                $.ajax({
                    type    : "POST",
                    url     : "<?php echo site_url('pmm/productions/monitoring_piutang_int'); ?>/"+Math.random(),
                    dataType : 'html',
                    data: {
                        filter_date : $('#filter_date_monitoring_piutang').val(),
                        supplier_id : $('#filter_supplier_monitoring_piutang').val(),
                    },
                    success : function(result){
                        $('#monitoring-piutang').html(result);
                        $('#wait-monitoring-piutang').fadeOut('fast');
                    }
                });
            }

            //MonitoringPiutang();
            
            $('#filter_supplier_monitoring_piutang').change(function() {
                MonitoringPiutang();
            });

        </script>

        <!-- Script Daftar Penerimaan -->
        <script type="text/javascript">
            $('#filter_date_daftar_penerimaan').daterangepicker({
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

            $('#filter_date_daftar_penerimaan').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
                DaftarPenerimaan();
            });


            function DaftarPenerimaan()
            {
                $('#wait-pengiriman-penjualan').fadeIn('fast');   
                $.ajax({
                    type    : "POST",
                    url     : "<?php echo site_url('pmm/productions/daftar_penerimaan_int'); ?>/"+Math.random(),
                    dataType : 'html',
                    data: {
                        filter_date : $('#filter_date_daftar_penerimaan').val(),
                        supplier_id : $('#filter_supplier_daftar_penerimaan').val(),
                    },
                    success : function(result){
                        $('#daftar-penerimaan').html(result);
                        $('#wait-daftar-penerimaan').fadeOut('fast');
                    }
                });
            }

            //DaftarPenerimaan();
            
            $('#filter_supplier_daftar_penerimaan').change(function() {
                DaftarPenerimaan();
            });

        </script>

    </div>
</body>
</html>