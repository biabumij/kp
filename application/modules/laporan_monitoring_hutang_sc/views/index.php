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
                                                                <h3 class="panel-title">Laporan Hutang</h3>
                                                                <a href="laporan_pembelian">Kembali</a>
                                                            </div>
                                                            <div style="margin: 20px">
                                                                <div class="row">
                                                                    <form action="<?php echo site_url('laporan/cetak_monitoring_hutang_sc'); ?>" target="_blank">
                                                                        <div class="col-sm-3">
                                                                            <input type="text" id="filter_date_monitoring_hutang" name="filter_date" class="form-control dtpicker" value="<?php echo $_GET['filter_date'];?>" placeholder="Filter by Date">
                                                                        </div>
                                                                        <div class="col-sm-3">
                                                                            <select id="filter_kategori_monitoring_hutang" name="filter_kategori" class="form-control select2">
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
                                                                            <select id="filter_status_monitoring_hutang" name="filter_status" class="form-control select2">
                                                                                <option value="">Pilih Status</option>
                                                                                <?php
                                                                                foreach ($status as $key => $st) {
                                                                                ?>
                                                                                    <option value="<?php echo $st['status']; ?>"><?php echo $st['status']; ?></option>
                                                                                <?php
                                                                                }
                                                                                ?>
                                                                            </select>
                                                                        </div> 
                                                                        <div class="col-sm-3">
                                                                            <select id="filter_supplier_monitoring_hutang" name="supplier_id" class="form-control select2">
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
                                                                    <table class="table table-hover table-center table-bordered" id="monitoring-hutang" style="display:none" width="100%";>
                                                                        <thead>
                                                                        <tr class="judul">
                                                                            <th class="text-center" rowspan="2" style="vertical-align:middle;">NO.</th>
                                                                            <th class="text-center">REKANAN</th>
                                                                            <th class="text-center">TANGGAL</th>
                                                                            <th class="text-center">JENIS</th>
                                                                            <th class="text-center">TANGGAL</th>
                                                                            <th class="text-center">SYARAT</th>
                                                                            <th class="text-center" colspan="3">TAGIHAN</th>
                                                                            <th class="text-center" colspan="4">PEMBAYARAN</th>
                                                                            <th class="text-center" colspan="3">SISA HUTANG</th>
                                                                            <th class="text-center" rowspan="2" style="vertical-align:middle;">STATUS</th>
                                                                            <th class="text-center">TANGGAL</th>
                                                                        </tr>
                                                                        <tr class="judul">
                                                                            <th class="text-center">NO. TAGIHAN</th>
                                                                            <th class="text-center">TAGIHAN</th>
                                                                            <th class="text-center">PEMBELIAN</th>
                                                                            <th class="text-center">VERIFIKASI</th>
                                                                            <th class="text-center">PEMBAYARAN</th>
                                                                            <th class="text-center">DPP</th>
                                                                            <th class="text-center">PPN</th>
                                                                            <th class="text-center">JUMLAH</th>
                                                                            <th class="text-center">DPP</th>
                                                                            <th class="text-center">PPN</th>
                                                                            <th class="text-center">PPH</th>
                                                                            <th class="text-center">JUMLAH</th>
                                                                            <th class="text-center">DPP</th>
                                                                            <th class="text-center">PPN</th>
                                                                            <th class="text-center">JUMLAH</th>
                                                                            <th class="text-center">JATUH TEMPO</th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody></tbody>
                                                                        <tfoot class="table-hover table-center table-bordered table-condensed"></tfoot>
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
		
        <!-- Script Monitoring Hutang -->
		<script type="text/javascript">
            $('input.numberformat').number(true, 4, ',', '.');
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

            LaporanMonitoringHutang();

            function LaporanMonitoringHutang() {
                $('#monitoring-hutang').show();
                $('#loader-table').fadeIn('fast');
                $('#monitoring-hutang tbody').html('');
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('pmm/receipt_material/monitoring_hutang_sc'); ?>/" + Math.random(),
                    dataType: 'json',
                    data: {
                        filter_date: $('#filter_date_monitoring_hutang').val(),
                        filter_kategori: $('#filter_kategori_monitoring_hutang').val(),
                        filter_status: $('#filter_status_monitoring_hutang').val(),
                        supplier_id: $('#filter_supplier_monitoring_hutang').val(),
                    },
                    success: function(result) {
                        if (result.data) {
                            $('#monitoring-hutang tbody').html('');

                            if (result.data.length > 0) {
                                $.each(result.data, function(i, val) {
                                    
                                    window.jumlah_dpp_tagihan = 0;
                                    window.jumlah_ppn_tagihan = 0;
                                    window.jumlah_jumlah_tagihan = 0;
                                    window.jumlah_dpp_pembayaran = 0;
                                    window.jumlah_ppn_pembayaran = 0;
                                    window.jumlah_pph_pembayaran = 0;
                                    window.jumlah_jumlah_pembayaran = 0;
                                    window.jumlah_dpp_sisa_hutang = 0;
                                    window.jumlah_ppn_sisa_hutang = 0;
                                    window.jumlah_jumlah_sisa_hutang = 0;

                                    $.each(val.mats, function(a, row) {
                                        window.jumlah_dpp_tagihan += parseFloat(row.dpp_tagihan.replace(/\./g,'').replace(',', '.'));
                                        window.jumlah_ppn_tagihan += parseFloat(row.ppn_tagihan.replace(/\./g,'').replace(',', '.'));
                                        window.jumlah_jumlah_tagihan += parseFloat(row.jumlah_tagihan.replace(/\./g,'').replace(',', '.'));
                                        window.jumlah_dpp_pembayaran += parseFloat(row.dpp_pembayaran.replace(/\./g,'').replace(',', '.'));
                                        window.jumlah_ppn_pembayaran += parseFloat(row.ppn_pembayaran.replace(/\./g,'').replace(',', '.'));
                                        window.jumlah_pph_pembayaran += parseFloat(row.pph_pembayaran.replace(/\./g,'').replace(',', '.'));
                                        window.jumlah_jumlah_pembayaran += parseFloat(row.jumlah_pembayaran.replace(/\./g,'').replace(',', '.'));
                                        window.jumlah_dpp_sisa_hutang += parseFloat(row.dpp_sisa_hutang.replace(/\./g,'').replace(',', '.'));
                                        window.jumlah_ppn_sisa_hutang += parseFloat(row.ppn_sisa_hutang.replace(/\./g,'').replace(',', '.'));
                                        window.jumlah_jumlah_sisa_hutang += parseFloat(row.jumlah_sisa_hutang.replace(/\./g,'').replace(',', '.'));
                                    });

                                    $('#monitoring-hutang tbody').append('<tr onclick="NextShowMonitoringHutang(' + val.no + ')" class="active" style="font-size:11px;font-weight:bold;cursor:pointer;background-color:#FF0000"><td class="text-center">' + val.no + '</td><td class="text-left" colspan="5">' + val.name + '</td><td class="text-right"><b>' + formatter2.format(window.jumlah_dpp_tagihan) + '</b></td><td class="text-right"><b>' + formatter2.format(window.jumlah_ppn_tagihan) + '</b></td><td class="text-right"><b>' + formatter2.format(window.jumlah_jumlah_tagihan) + '</b></td><td class="text-right"><b>' + formatter2.format(window.jumlah_dpp_pembayaran) + '</b></td><td class="text-right"><b>' + formatter2.format(window.jumlah_ppn_pembayaran) + '</b></td><td class="text-right"><b>' + formatter2.format(window.jumlah_pph_pembayaran) + '</b></td><td class="text-right"><b>' + formatter2.format(window.jumlah_jumlah_pembayaran) + '</b></td><td class="text-right"><b>' + formatter2.format(window.jumlah_dpp_sisa_hutang) + '</b></td><td class="text-right"><b>' + formatter2.format(window.jumlah_ppn_sisa_hutang) + '</b></td><td class="text-right"><b>' + formatter2.format(window.jumlah_jumlah_sisa_hutang) + '</b></td><td class="text-right"></td></td><td class="text-right"></td></tr>');
                                    $.each(val.mats, function(a, row) {
                                        var a_no = a + 1;
                                        $('#monitoring-hutang tbody').append('<tr style="font-size:11px;display:none;" class="mats-' + val.no + '"><td class="text-center"></td><td class="text-left">' + row.nomor_invoice + '</td><td class="text-left">' + row.tanggal_invoice + '</td><td class="text-right">' + row.subject + '</td><td class="text-right">' + row.tanggal_lolos_verifikasi + '</td><td class="text-right">' + row.syarat_pembayaran + '</td><td class="text-right">' + row.dpp_tagihan + '</td><td class="text-right">' + row.ppn_tagihan + '</td><td class="text-right">' + row.jumlah_tagihan + '</td><td class="text-right">' + row.dpp_pembayaran + '</td><td class="text-right">' + row.ppn_pembayaran + '</td><td class="text-right">' + row.pph_pembayaran + '</td><td class="text-right">' + row.jumlah_pembayaran + '</td><td class="text-right">' + row.dpp_sisa_hutang + '</td><td class="text-right">' + row.ppn_sisa_hutang + '</td><td class="text-right">' + row.jumlah_sisa_hutang + '</td><td class="text-right">' + row.status + '</td><td class="text-center">' + row.jatuh_tempo + '</td></tr>');   
                                    });
                                    $('#monitoring-hutang tbody').append('<tr style="font-size:11px;display:none;" class="mats-' + val.no + '"><td class="text-right" colspan="6"><b>JUMLAH</b></td><td class="text-right"><b>' + formatter2.format(window.jumlah_dpp_tagihan) + '</b></td><td class="text-right"><b>' + formatter2.format(window.jumlah_ppn_tagihan) + '</b></td><td class="text-right"><b>' + formatter2.format(window.jumlah_jumlah_tagihan) + '</b></td><td class="text-right"><b>' + formatter2.format(window.jumlah_dpp_pembayaran) + '</b></td><td class="text-right"><b>' + formatter2.format(window.jumlah_ppn_pembayaran) + '</b></td><td class="text-right"><b>' + formatter2.format(window.jumlah_pph_pembayaran) + '</b></td><td class="text-right"><b>' + formatter2.format(window.jumlah_jumlah_pembayaran) + '</b></td><td class="text-right"><b>' + formatter2.format(window.jumlah_dpp_sisa_hutang) + '</b></td><td class="text-right"><b>' + formatter2.format(window.jumlah_ppn_sisa_hutang) + '</b></td><td class="text-right"><b>' + formatter2.format(window.jumlah_jumlah_sisa_hutang) + '</b></td></td><td class="text-right"></td>td class="text-right"></td></tr>');
                                });
                                $('#monitoring-hutang tbody').append('<tr style="font-size:11px;background-color:#cccccc;"><td class="text-right" colspan="6"><b>TOTAL</b></td><td class="text-right"><b>' + result.total_dpp_tagihan + '</b></td><td class="text-right"><b>' + result.total_ppn_tagihan + '</b></td><td class="text-right"><b>' + result.total_jumlah_tagihan + '</b></td><td class="text-right"><b>' + result.total_dpp_pembayaran + '</b></td><td class="text-right"><b>' + result.total_ppn_pembayaran + '</b></td><td class="text-right"><b>' + result.total_pph_pembayaran + '</b></td><td class="text-right"><b>' + result.total_jumlah_pembayaran + '</b></td><td class="text-right"><b>' + result.total_dpp_sisa_hutang + '</b></td><td class="text-right"><b>' + result.total_ppn_sisa_hutang + '</b></td><td class="text-right"><b>' + result.total_jumlah_sisa_hutang + '</b></td></td><td class="text-right"></td></td><td class="text-right"></td></tr>');
                            } else {
                                $('#monitoring-hutang tbody').append('<tr style="font-size:11px;><td class="text-center" colspan="18"><b>Tidak Ada Data</b></td></tr>');
                            }
                            $('#loader-table').fadeOut('fast');
                        } else if (result.err) {
                            bootbox.alert(result.err);
                        }
                    }
                });
            }

            function NextShowMonitoringHutang(id) {
                console.log('.mats-' + id);
                $('.mats-' + id).slideToggle();
            }

            $('#filter_kategori_monitoring_hutang').change(function() {
                LaporanMonitoringHutang();
            });

            $('#filter_status_monitoring_hutang').change(function() {
                LaporanMonitoringHutang();
            });

            $('#filter_supplier_monitoring_hutang').change(function() {
                LaporanMonitoringHutang();
            });

            window.formatter2 = new Intl.NumberFormat('id-ID', {
                style: 'decimal',
                currency: 'IDR',
                symbol: 'none',
				minimumFractionDigits : '0'
            });

        </script>
		
        
</body>
</html>