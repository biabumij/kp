<!doctype html>
<html lang="en" class="fixed">
<?php

    $this->db2 = $this->load->database('database2', TRUE);
		$this->db3 = $this->load->database('database3', TRUE);
    ?>

<head>
    <?php echo $this->Templates->Header(); ?>
	<style type="text/css">
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
                                            $arr_po_temef = $this->db2->order_by('date_po', 'desc')->get_where('pmm_purchase_order')->result_array();
                                            $suppliers_temef  = $this->db2->order_by('nama', 'asc')->select('*')->get_where('penerima', array('status' => 'PUBLISH', 'rekanan' => 1))->result_array();
                                            $kategori_temef  = $this->db2->order_by('nama_kategori_produk', 'asc')->select('*')->get_where('kategori_produk', array('status' => 'PUBLISH'))->result_array();

                                            $arr_po_sc = $this->db3->order_by('date_po', 'desc')->get_where('pmm_purchase_order')->result_array();
                                            $suppliers_sc  = $this->db3->order_by('nama', 'asc')->select('*')->get_where('penerima', array('status' => 'PUBLISH', 'rekanan' => 1))->result_array();
                                            $kategori_sc  = $this->db3->order_by('nama_kategori_produk', 'asc')->select('*')->get_where('kategori_produk', array('status' => 'PUBLISH'))->result_array();
                                            ?>
                                            <div width="100%">
                                                <div class="panel panel-default">
                                                    <div class="col-sm-5">
														<p><h5>Laporan Hutang TEMEF - Kupang</h5></p>
                                                        <a href="#laporan_hutang_temef" aria-controls="laporan_hutang_temef" role="tab" data-toggle="tab" class="btn btn-primary" style="font-weight:bold; border-radius:10px;">Lihat Laporan</a>
                                                    </div>                                          
                                                    <div class="col-sm-5">
														<p><h5>Laporan Hutang SC - Tulungagung</h5></p>
                                                        <a href="#laporan_hutang_sc" aria-controls="laporan_hutang_sc" role="tab" data-toggle="tab" class="btn btn-primary" style="font-weight:bold; border-radius:10px;">Lihat Laporan</a>
                                                    </div>
                                                    <div class="col-sm-5">
														<p><h5>Laporan BP - Trenggalek</h5></p>
                                                        <a href="#laporan_hutang_bp" aria-controls="laporan_hutang_bp" role="tab" data-toggle="tab" class="btn btn-primary" style="font-weight:bold; border-radius:10px;">Lihat Laporan</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Laporan Hutang TEMEF -->
                                    <div role="tabpanel" class="tab-pane" id="laporan_hutang_temef">
                                        <div class="col-sm-15">
                                            <div class="panel panel-default">  
												<div class="panel-heading">												
                                                    <h3 class="panel-title">Laporan Hutang TEMEF</h3>
													<a href="hutang">Kembali</a>
                                                </div>
                                                <div style="margin: 20px">
                                                    <div class="row">
                                                        <form action="<?php echo site_url('laporan/cetak_laporan_hutang_temef'); ?>" target="_blank">
                                                            <div class="col-sm-3">
                                                                <input type="text" id="filter_date_hutang_temef" name="filter_date" class="form-control dtpicker" autocomplete="off" placeholder="Filter by Date">
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <select id="filter_kategori_hutang_temef" name="filter_kategori" class="form-control select2">
                                                                    <option value="">Pilih Kategori</option>
                                                                    <?php
                                                                    foreach ($kategori_temef as $key => $kat) {
                                                                    ?>
                                                                        <option value="<?php echo $kat['id']; ?>"><?php echo $kat['nama_kategori_produk']; ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div> 
                                                            <div class="col-sm-3">
                                                                <select id="filter_supplier_hutang_temef" name="supplier_id" class="form-control select2">
                                                                    <option value="">Pilih Rekanan</option>
                                                                    <?php
                                                                    foreach ($suppliers_temef as $key => $supplier) {
                                                                    ?>
                                                                        <option value="<?php echo $supplier['id']; ?>"><?php echo $supplier['nama']; ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>                                                     
                                                            <div class="col-sm-3">
                                                                <button class="btn btn-default" type="submit" id="btn-print" style="font-weight:bold; border-radius:10px;"><i class="fa fa-print"></i> Print</button>
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
                                                        <table class="mytable table table-striped table-hover table-center table-bordered table-condensed" id="laporan-hutang-temef" style="display:none" width="100%";>
                                                            <thead>
                                                            <tr>
                                                                <th class="text-center" rowspan="2" style="vertical-align:middle;">NO.</th>
                                                                <th class="text-center">REKANAN</th>
                                                                <th class="text-center" rowspan="2" style="vertical-align:middle;">PENERIMAAN</th>
                                                                <th class="text-center" rowspan="2" style="vertical-align:middle;">TAGIHAN</th>
																<th class="text-center" rowspan="2" style="vertical-align:middle;">TAGIHAN BRUTO</th>
                                                                <th class="text-center" rowspan="2" style="vertical-align:middle;">PEMBAYARAN</th>
                                                                <th class="text-center"colspan="2">SISA HUTANG</th>
                                                            </tr>
                                                            <tr>
                                                                <th class="text-center">NO. PESANAN PEMBELIAN</th>
                                                                <th class="text-center">PENERIMAAN</th>
                                                                <th class="text-center">INVOICE</th>
                                                            </tr>
															</thead>
                                                            <tbody></tbody>
															<tfoot class="mytable table-hover table-center table-bordered table-condensed"></tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
									</div>

                                    <!-- Laporan Hutang SC -->
                                    <div role="tabpanel" class="tab-pane" id="laporan_hutang_sc">
                                        <div class="col-sm-15">
                                            <div class="panel panel-default">  
												<div class="panel-heading">												
                                                    <h3 class="panel-title">Laporan Hutang SC</h3>
													<a href="hutang">Kembali</a>
                                                </div>
                                                <div style="margin: 20px">
                                                    <div class="row">
                                                        <form action="<?php echo site_url('laporan/cetak_laporan_hutang_sc'); ?>" target="_blank">
                                                            <div class="col-sm-3">
                                                                <input type="text" id="filter_date_hutang_sc" name="filter_date" class="form-control dtpicker" autocomplete="off" placeholder="Filter by Date">
                                                            </div>
                                                            <div class="col-sm-3">
                                                                <select id="filter_kategori_hutang_sc" name="filter_kategori" class="form-control select2">
                                                                    <option value="">Pilih Kategori</option>
                                                                    <?php
                                                                    foreach ($kategori_sc as $key => $kat) {
                                                                    ?>
                                                                        <option value="<?php echo $kat['id']; ?>"><?php echo $kat['nama_kategori_produk']; ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div> 
                                                            <div class="col-sm-3">
                                                                <select id="filter_supplier_hutang_sc" name="supplier_id" class="form-control select2">
                                                                    <option value="">Pilih Rekanan</option>
                                                                    <?php
                                                                    foreach ($suppliers_sc as $key => $supplier) {
                                                                    ?>
                                                                        <option value="<?php echo $supplier['id']; ?>"><?php echo $supplier['nama']; ?></option>
                                                                    <?php
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>                                                     
                                                            <div class="col-sm-3">
                                                                <button class="btn btn-default" type="submit" id="btn-print" style="font-weight:bold; border-radius:10px;"><i class="fa fa-print"></i> Print</button>
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
                                                        <table class="mytable table table-striped table-hover table-center table-bordered table-condensed" id="laporan-hutang-sc" style="display:none" width="100%";>
                                                            <thead>
                                                            <tr>
                                                                <th class="text-center" rowspan="2" style="vertical-align:middle;">NO.</th>
                                                                <th class="text-center">REKANAN</th>
                                                                <th class="text-center" rowspan="2" style="vertical-align:middle;">PENERIMAAN</th>
                                                                <th class="text-center" rowspan="2" style="vertical-align:middle;">TAGIHAN</th>
																<th class="text-center" rowspan="2" style="vertical-align:middle;">TAGIHAN BRUTO</th>
                                                                <th class="text-center" rowspan="2" style="vertical-align:middle;">PEMBAYARAN</th>
                                                                <th class="text-center"colspan="2">SISA HUTANG</th>
                                                            </tr>
                                                            <tr>
                                                                <th class="text-center">NO. PESANAN PEMBELIAN</th>
                                                                <th class="text-center">PENERIMAAN</th>
                                                                <th class="text-center">INVOICE</th>
                                                            </tr>
															</thead>
                                                            <tbody></tbody>
															<tfoot class="mytable table-hover table-center table-bordered table-condensed"></tfoot>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
									</div>
									
                                    <!-- Laporan Hutang BP -->
                                    <div role="tabpanel" class="tab-pane" id="laporan_hutang_bp">
                                        <div class="col-sm-15">
                                            <div class="panel panel-default">  
												<div class="panel-heading">												
                                                    <h3 class="panel-title">Laporan Hutang BP</h3>
													<a href="hutang">Kembali</a>
                                                </div>
                                                <div style="margin: 20px">
                                                    <div class="row">
                                                        <form action="<?php echo site_url('laporan/cetak_laporan_hutang_bp'); ?>" target="_blank">                                                    
                                                            <div class="col-sm-3">
                                                                <button class="btn btn-default" type="submit" id="btn-print" style="font-weight:bold; border-radius:10px;"><i class="fa fa-print"></i> Print</button>
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
                                                        <table class="mytable table table-striped table-hover table-center table-bordered table-condensed" style="display:true" width="100%";>
                                                            <thead>
                                                            <tr>
                                                                <th class="text-center" rowspan="2" style="vertical-align:middle;">NO.</th>
                                                                <th class="text-center" rowspan="2">REKANAN</th>
                                                                <th class="text-center" colspan="4" style="vertical-align:middle;">TAGIHAN / TERMIN</th>
                                                                <th class="text-center" colspan="5" style="vertical-align:middle;">PEMBAYARAN</th>
                                                                <th class="text-center" colspan="3" style="vertical-align:middle;">HUTANG</th>
                                                            </tr>
                                                            <tr>
                                                                <th>DPP</th>
                                                                <th>PPH</th>
                                                                <th>PPN</th>
                                                                <th>Jumlah</th>
                                                                <th>DPP</th>
                                                                <th>Pos Silang<br />Piutang / Hutang</th>
                                                                <th>PPH</th>
                                                                <th>PPN</th>
                                                                <th>Jumlah</th>
                                                                <th>DPP</th>
                                                                <th>PPN</th>
                                                                <th>Jumlah</th>
                                                            </tr>
															</thead>
                                                            <tbody>
                                                                <tr>
                                                                    <th class="text-center">1.</th>
                                                                    <th class="text-left">PT Kalitelu Teknik</th>
                                                                    <th class="text-right"><?php echo number_format(532921735,0,',','.');?></th>
                                                                    <th class="text-right">-</th>
                                                                    <th class="text-right"><?php echo number_format(265076333.8,0,',','.');?></th>
                                                                    <th class="text-right"><?php echo number_format(797998068.8,0,',','.');?></th>
                                                                    <th class="text-right"><?php echo number_format(508963335,0,',','.');?></th>
                                                                    <th class="text-right">-</th>
                                                                    <th class="text-right">-</th>
                                                                    <th class="text-right">-</th>
                                                                    <th class="text-right"><?php echo number_format(508963335,0,',','.');?></th>
                                                                    <th class="text-right"><?php echo number_format(23958400,0,',','.');?></th>
                                                                    <th class="text-right"><?php echo number_format(265076333.8,0,',','.');?></th>
                                                                    <th class="text-right"><?php echo number_format(289034733.8,0,',','.');?></th>
                                                                </tr>
                                                                <tr>
                                                                    <th class="text-center">2.</th>
                                                                    <th class="text-left">PT Heleh Westo Bene</th>
                                                                    <th class="text-right"><?php echo number_format(45484740,0,',','.');?></th>
                                                                    <th class="text-right">-</th>
                                                                    <th class="text-right">-</th>
                                                                    <th class="text-right"><?php echo number_format(45484740,0,',','.');?></th>
                                                                    <th class="text-right"><?php echo number_format(2784234,0,',','.');?></th>
                                                                    <th class="text-right">-</th>
                                                                    <th class="text-right">-</th>
                                                                    <th class="text-right">-</th>
                                                                    <th class="text-right"><?php echo number_format(2784234,0,',','.');?></th>
                                                                    <th class="text-right"><?php echo number_format(42700506,0,',','.');?></th>
                                                                    <th class="text-right">-</th>
                                                                    <th class="text-right"><?php echo number_format(42700506,0,',','.');?></th>
                                                                </tr>
                                                                <tr>
                                                                    <th class="text-center">3.</th>
                                                                    <th class="text-left">PT Bia Bumi Jayendra Div. Cutting Stone</th>
                                                                    <th class="text-right"><?php echo number_format(3280543395,0,',','.');?></th>
                                                                    <th class="text-right">-</th>
                                                                    <th class="text-right">-</th>
                                                                    <th class="text-right"><?php echo number_format(3280543395,0,',','.');?></th>
                                                                    <th class="text-right"><?php echo number_format(2643046784,0,',','.');?></th>
                                                                    <th class="text-right"><?php echo number_format(574728501,0,',','.');?></th>
                                                                    <th class="text-right">-</th>
                                                                    <th class="text-right">-</th>
                                                                    <th class="text-right"><?php echo number_format(3217775285,0,',','.');?></th>
                                                                    <th class="text-right"><?php echo number_format(62768110,0,',','.');?></th>
                                                                    <th class="text-right">-</th>
                                                                    <th class="text-right"><?php echo number_format(62768110,0,',','.');?></th>
                                                                </tr>
                                                                <tr>
                                                                    <th class="text-center">4.</th>
                                                                    <th class="text-left">PT Nindya Karya (Persero) Div. Alat</th>
                                                                    <th class="text-right"><?php echo number_format(420500000,0,',','.');?></th>
                                                                    <th class="text-right"><?php echo number_format(8410000,0,',','.');?></th>
                                                                    <th class="text-right"><?php echo number_format(42050000,0,',','.');?></th>
                                                                    <th class="text-right"><?php echo number_format(454140000,0,',','.');?></th>
                                                                    <th class="text-right"><?php echo number_format(313000000,0,',','.');?></th>
                                                                    <th class="text-right">-</th>
                                                                    <th class="text-right"><?php echo number_format(6260000,0,',','.');?></th>
                                                                    <th class="text-right">-</th>
                                                                    <th class="text-right"><?php echo number_format(306740000,0,',','.');?></th>
                                                                    <th class="text-right"><?php echo number_format(107500000,0,',','.');?></th>
                                                                    <th class="text-right"><?php echo number_format(42050000,0,',','.');?></th>
                                                                    <th class="text-right"><?php echo number_format(149550000,0,',','.');?></th>
                                                                </tr>
                                                            </tbody>
															<tfoot class="mytable table-hover table-center table-bordered table-condensed">
                                                                <tr style='background-color:#cccccc;'>
                                                                    <th class="text-center" colspan="2">TOTAL HUTANG</th>
                                                                    <th class="text-right"><?php echo number_format(4279449870,0,',','.');?></th>
                                                                    <th class="text-right"><?php echo number_format(8410000,0,',','.');?></th>
                                                                    <th class="text-right"><?php echo number_format(307126333.8,0,',','.');?></th>
                                                                    <th class="text-right"><?php echo number_format(4578166203.8,0,',','.');?></th>
                                                                    <th class="text-right"><?php echo number_format(3467794353,0,',','.');?></th>
                                                                    <th class="text-right"><?php echo number_format(574728501,0,',','.');?></th>
                                                                    <th class="text-right"><?php echo number_format(6260000,0,',','.');?></th>
                                                                    <th class="text-right">-</th>
                                                                    <th class="text-right"><?php echo number_format(4036262854,0,',','.');?></th>
                                                                    <th class="text-right"><?php echo number_format(236927016,0,',','.');?></th>
                                                                    <th class="text-right"><?php echo number_format(307126333.8,0,',','.');?></th>
                                                                    <th class="text-right"><?php echo number_format(544053349.8,0,',','.');?></th>
                                                                </tr>
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

        <?php echo $this->Templates->Footer(); ?>

        <script src="<?php echo base_url(); ?>assets/back/theme/vendor/daterangepicker/moment.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/back/theme/vendor/daterangepicker/daterangepicker.js"></script>
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/back/theme/vendor/daterangepicker/daterangepicker.css">
        <script src="<?php echo base_url(); ?>assets/back/theme/vendor/bootbox.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/back/theme/vendor/jquery.number.min.js"></script>
        <script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>
		

        <!-- Script Hutang TEMEF-->
		<script type="text/javascript">
            $('input.numberformat').number(true, 4, ',', '.');
            $('#filter_date_hutang_temef').daterangepicker({
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

            $('#filter_date_hutang_temef').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('01-01-2021') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
                LaporanHutangTEMEF();
            });

            function LaporanHutangTEMEF() {
                $('#laporan-hutang-temef').show();
                $('#loader-table').fadeIn('fast');
                $('#laporan-hutang-temef tbody').html('');
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('pmm/receipt_material/laporan_hutang_temef'); ?>/" + Math.random(),
                    dataType: 'json',
                    data: {
                        filter_date: $('#filter_date_hutang_temef').val(),
                        filter_kategori: $('#filter_kategori_hutang_temef').val(),
                        supplier_id: $('#filter_supplier_hutang_temef').val(),
                    },
                    success: function(result) {
                        if (result.data) {
                            $('#laporan-hutang-temef tbody').html('');

                            if (result.data.length > 0) {
                                $.each(result.data, function(i, val) {
                                    
                                    window.jumlah_penerimaan = 0;
                                    window.jumlah_tagihan = 0;
                                    window.jumlah_tagihan_bruto = 0;
                                    window.jumlah_pembayaran = 0;
                                    window.jumlah_sisa_hutang_penerimaan = 0;
                                    window.jumlah_sisa_hutang_tagihan = 0;

                                    $.each(val.mats, function(a, row) {
                                        window.jumlah_penerimaan += parseFloat(row.penerimaan.replace(/\./g,'').replace(',', '.'));
                                        window.jumlah_tagihan += parseFloat(row.tagihan.replace(/\./g,'').replace(',', '.'));
                                        window.jumlah_tagihan_bruto += parseFloat(row.tagihan_bruto.replace(/\./g,'').replace(',', '.'));
                                        window.jumlah_pembayaran += parseFloat(row.pembayaran.replace(/\./g,'').replace(',', '.'));
                                        window.jumlah_sisa_hutang_penerimaan += parseFloat(row.sisa_hutang_penerimaan.replace(/\./g,'').replace(',', '.'));
                                        window.jumlah_sisa_hutang_tagihan += parseFloat(row.sisa_hutang_tagihan.replace(/\./g,'').replace(',', '.'));
                                    });

                                    $('#laporan-hutang-temef tbody').append('<tr onclick="NextShowHutangTEMEF(' + val.no + ')" class="active" style="font-weight:bold;cursor:pointer;background-color:#FF0000"><td class="text-center">' + val.no + '</td><td class="text-left">' + val.name + '</td><td class="text-right"><b>' + formatter.format(window.jumlah_penerimaan) + '</b></td><td class="text-right"><b>' + formatter.format(window.jumlah_tagihan) + '</b></td><td class="text-right"><b>' + formatter.format(window.jumlah_tagihan_bruto) + '</b></td><td class="text-right"><b>' + formatter.format(window.jumlah_pembayaran) + '</b></td><td class="text-right"><b>' + formatter.format(window.jumlah_sisa_hutang_penerimaan) + '</b></td><td class="text-right"><b>' + formatter.format(window.jumlah_sisa_hutang_tagihan) + '</b></td></tr>');
                                    //$('#laporan-hutang-temef tbody').append('<tr onclick="NextShowHutang(' + val.no + ')" class="active" style="font-weight:bold;cursor:pointer;background-color:#FF0000"><td class="text-center">' + val.no + '</td><td class="text-left" colspan="2">' + val.name + '</td><td class="text-right">' + val.total_penerimaan + '</td><td class="text-right">' + val.total_tagihan + '</td><td class="text-right"></td><td class="text-right"></td><td class="text-right"></td></tr>');
                                    $.each(val.mats, function(a, row) {
                                        var a_no = a + 1;
                                        $('#laporan-hutang-temef tbody').append('<tr style="display:none;" class="mats-' + val.no + '"><td class="text-center"></td><td class="text-left">' + row.purchase_order_id + '</td><td class="text-right">' + row.penerimaan + '</td><td class="text-right">' + row.tagihan + '</td><td class="text-right">' + row.tagihan_bruto + '</td><td class="text-right">' + row.pembayaran + '</td><td class="text-right">' + row.sisa_hutang_penerimaan + '</td><td class="text-right">' + row.sisa_hutang_tagihan + '</td></tr>');   
                                    });
                                    $('#laporan-hutang-temef tbody').append('<tr style="display:none;" class="mats-' + val.no + '"><td class="text-right" colspan="2"><b>JUMLAH</b></td><td class="text-right"><b>' + formatter.format(window.jumlah_penerimaan) + '</b></td><td class="text-right"><b>' + formatter.format(window.jumlah_tagihan) + '</b></td><td class="text-right"><b>' + formatter.format(window.jumlah_tagihan_bruto) + '</b></td><td class="text-right"><b>' + formatter.format(window.jumlah_pembayaran) + '</b></td><td class="text-right"><b>' + formatter.format(window.jumlah_sisa_hutang_penerimaan) + '</b></td><td class="text-right"><b>' + formatter.format(window.jumlah_sisa_hutang_tagihan) + '</b></td></tr>');
                                });
                                $('#laporan-hutang-temef tbody').append('<tr><td class="text-right" colspan="2"><b>TOTAL</b></td><td class="text-right"><b>' + result.total_penerimaan + '</b></td><td class="text-right"><b>' + result.total_tagihan + '</b></td><td class="text-right"><b>' + result.total_tagihan_bruto + '</b></td><td class="text-right"><b>' + result.total_pembayaran + '</b></td><td class="text-right"><b>' + result.total_sisa_hutang_penerimaan + '</b></td><td class="text-right"><b>' + result.total_sisa_hutang_tagihan + '</b></td></tr>');
                                $('#laporan-hutang-temef tbody').append('<tr><td class="text-center" style="background-color:red;color:white;"colspan="8"><blink><b>* Exclude PPN & PPH</b></blink></td></tr>');
                            } else {
                                $('#laporan-hutang-temef tbody').append('<tr><td class="text-center" colspan="8"><b>Tidak Ada Data</b></td></tr>');
                            }
                            $('#loader-table').fadeOut('fast');
                        } else if (result.err) {
                            bootbox.alert(result.err);
                        }
                    }
                });
            }

            function NextShowHutangTEMEF(id) {
                console.log('.mats-' + id);
                $('.mats-' + id).slideToggle();
            }

            $('#filter_kategori_hutang_temef').change(function() {
                LaporanHutangTEMEF();
            });

            $('#filter_supplier_hutang_temef').change(function() {
                LaporanHutangTEMEF();
            });

            window.formatter = new Intl.NumberFormat('id-ID', {
                style: 'decimal',
                currency: 'IDR',
                symbol: 'none',
				minimumFractionDigits : '0'
            });

        </script>

		<!-- Script Hutang SC-->
		<script type="text/javascript">
            $('input.numberformat').number(true, 4, ',', '.');
            $('#filter_date_hutang_sc').daterangepicker({
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

            $('#filter_date_hutang_sc').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('01-01-2021') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
                LaporanHutangSC();
            });

            function LaporanHutangSC() {
                $('#laporan-hutang-sc').show();
                $('#loader-table').fadeIn('fast');
                $('#laporan-hutang-sc tbody').html('');
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('pmm/receipt_material/laporan_hutang_sc'); ?>/" + Math.random(),
                    dataType: 'json',
                    data: {
                        filter_date: $('#filter_date_hutang_sc').val(),
                        filter_kategori: $('#filter_kategori_hutang_sc').val(),
                        supplier_id: $('#filter_supplier_hutang_sc').val(),
                    },
                    success: function(result) {
                        if (result.data) {
                            $('#laporan-hutang-sc tbody').html('');

                            if (result.data.length > 0) {
                                $.each(result.data, function(i, val) {
                                    
                                    window.jumlah_penerimaan = 0;
                                    window.jumlah_tagihan = 0;
                                    window.jumlah_tagihan_bruto = 0;
                                    window.jumlah_pembayaran = 0;
                                    window.jumlah_sisa_hutang_penerimaan = 0;
                                    window.jumlah_sisa_hutang_tagihan = 0;

                                    $.each(val.mats, function(a, row) {
                                        window.jumlah_penerimaan += parseFloat(row.penerimaan.replace(/\./g,'').replace(',', '.'));
                                        window.jumlah_tagihan += parseFloat(row.tagihan.replace(/\./g,'').replace(',', '.'));
                                        window.jumlah_tagihan_bruto += parseFloat(row.tagihan_bruto.replace(/\./g,'').replace(',', '.'));
                                        window.jumlah_pembayaran += parseFloat(row.pembayaran.replace(/\./g,'').replace(',', '.'));
                                        window.jumlah_sisa_hutang_penerimaan += parseFloat(row.sisa_hutang_penerimaan.replace(/\./g,'').replace(',', '.'));
                                        window.jumlah_sisa_hutang_tagihan += parseFloat(row.sisa_hutang_tagihan.replace(/\./g,'').replace(',', '.'));
                                    });

                                    $('#laporan-hutang-sc tbody').append('<tr onclick="NextShowHutangSC(' + val.no + ')" class="active" style="font-weight:bold;cursor:pointer;background-color:#FF0000"><td class="text-center">' + val.no + '</td><td class="text-left">' + val.name + '</td><td class="text-right"><b>' + formatter.format(window.jumlah_penerimaan) + '</b></td><td class="text-right"><b>' + formatter.format(window.jumlah_tagihan) + '</b></td><td class="text-right"><b>' + formatter.format(window.jumlah_tagihan_bruto) + '</b></td><td class="text-right"><b>' + formatter.format(window.jumlah_pembayaran) + '</b></td><td class="text-right"><b>' + formatter.format(window.jumlah_sisa_hutang_penerimaan) + '</b></td><td class="text-right"><b>' + formatter.format(window.jumlah_sisa_hutang_tagihan) + '</b></td></tr>');
                                    //$('#laporan-hutang-sc tbody').append('<tr onclick="NextShowHutang(' + val.no + ')" class="active" style="font-weight:bold;cursor:pointer;background-color:#FF0000"><td class="text-center">' + val.no + '</td><td class="text-left" colspan="2">' + val.name + '</td><td class="text-right">' + val.total_penerimaan + '</td><td class="text-right">' + val.total_tagihan + '</td><td class="text-right"></td><td class="text-right"></td><td class="text-right"></td></tr>');
                                    $.each(val.mats, function(a, row) {
                                        var a_no = a + 1;
                                        $('#laporan-hutang-sc tbody').append('<tr style="display:none;" class="mats-' + val.no + '"><td class="text-center"></td><td class="text-left">' + row.purchase_order_id + '</td><td class="text-right">' + row.penerimaan + '</td><td class="text-right">' + row.tagihan + '</td><td class="text-right">' + row.tagihan_bruto + '</td><td class="text-right">' + row.pembayaran + '</td><td class="text-right">' + row.sisa_hutang_penerimaan + '</td><td class="text-right">' + row.sisa_hutang_tagihan + '</td></tr>');   
                                    });
                                    $('#laporan-hutang-sc tbody').append('<tr style="display:none;" class="mats-' + val.no + '"><td class="text-right" colspan="2"><b>JUMLAH</b></td><td class="text-right"><b>' + formatter.format(window.jumlah_penerimaan) + '</b></td><td class="text-right"><b>' + formatter.format(window.jumlah_tagihan) + '</b></td><td class="text-right"><b>' + formatter.format(window.jumlah_tagihan_bruto) + '</b></td><td class="text-right"><b>' + formatter.format(window.jumlah_pembayaran) + '</b></td><td class="text-right"><b>' + formatter.format(window.jumlah_sisa_hutang_penerimaan) + '</b></td><td class="text-right"><b>' + formatter.format(window.jumlah_sisa_hutang_tagihan) + '</b></td></tr>');
                                });
                                $('#laporan-hutang-sc tbody').append('<tr><td class="text-right" colspan="2"><b>TOTAL</b></td><td class="text-right"><b>' + result.total_penerimaan + '</b></td><td class="text-right"><b>' + result.total_tagihan + '</b></td><td class="text-right"><b>' + result.total_tagihan_bruto + '</b></td><td class="text-right"><b>' + result.total_pembayaran + '</b></td><td class="text-right"><b>' + result.total_sisa_hutang_penerimaan + '</b></td><td class="text-right"><b>' + result.total_sisa_hutang_tagihan + '</b></td></tr>');
                                $('#laporan-hutang-sc tbody').append('<tr><td class="text-center" style="background-color:red;color:white;"colspan="8"><blink><b>* Exclude PPN & PPH</b></blink></td></tr>');
                            } else {
                                $('#laporan-hutang-sc tbody').append('<tr><td class="text-center" colspan="8"><b>Tidak Ada Data</b></td></tr>');
                            }
                            $('#loader-table').fadeOut('fast');
                        } else if (result.err) {
                            bootbox.alert(result.err);
                        }
                    }
                });
            }

            function NextShowHutangSC(id) {
                console.log('.mats-' + id);
                $('.mats-' + id).slideToggle();
            }

            $('#filter_kategori_hutang_sc').change(function() {
                LaporanHutangSC();
            });

            $('#filter_supplier_hutang_sc').change(function() {
                LaporanHutangSC();
            });

            window.formatter = new Intl.NumberFormat('id-ID', {
                style: 'decimal',
                currency: 'IDR',
                symbol: 'none',
				minimumFractionDigits : '0'
            });

        </script>
        
</body>
</html>