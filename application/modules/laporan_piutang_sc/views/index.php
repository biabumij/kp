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
                                                                <h3 class="panel-title">Laporan Piutang</h3>
                                                                <a href="laporan_pembelian">Kembali</a>
                                                            </div>
                                                            <div style="margin: 20px">
                                                                <div class="row">
                                                                    <form action="<?php echo site_url('laporan/cetak_laporan_piutang_sc'); ?>" target="_blank">
                                                                        <div class="col-sm-3">
                                                                            <input type="text" id="filter_date_piutang" name="filter_date" class="form-control dtpicker" value="<?php echo $_GET['filter_date'];?>" placeholder="Filter by Date">
                                                                        </div>                                             
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
                                                                    <table class="table table-hover table-center table-bordered" id="laporan-piutang" style="display:none" width="100%";>
                                                                        <thead>
                                                                            <tr class="judul">
                                                                                <th class="text-center" rowspan="2" style="vertical-align:middle;">NO.</th>
                                                                                <th class="text-center">REKANAN</th>
                                                                                <th class="text-center" rowspan="2" style="vertical-align:middle;">PENJUALAN</th>
                                                                                <th class="text-center" rowspan="2" style="vertical-align:middle;">TAGIHAN</th>
                                                                                <th class="text-center" rowspan="2" style="vertical-align:middle;">TAGIHAN BRUTO</th>
                                                                                <th class="text-center" rowspan="2" style="vertical-align:middle;">PENERIMAAN PEMBAYARAN</th>
                                                                                <th class="text-center"colspan="2">SISA PIUTANG</th>
                                                                            </tr>
                                                                            <tr class="judul">
                                                                                <th class="text-center">NO. PESANAN PEMBELIAN</th>
                                                                                <th class="text-center">PENJUALAN</th>
                                                                                <th class="text-center">TAGIHAN</th>
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
		
		<script type="text/javascript">
            $('input.numberformat').number(true, 4, ',', '.');
            $('#filter_date_piutang').daterangepicker({
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

            $('#filter_date_piutang').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('01-01-2021') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
                LaporanPiutang();
            });

            LaporanPiutang();

            function LaporanPiutang() {
                $('#laporan-piutang').show();
                $('#loader-table').fadeIn('fast');
                $('#laporan-piutang tbody').html('');
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('pmm/productions/laporan_piutang_sc'); ?>/" + Math.random(),
                    dataType: 'json',
                    data: {
                        filter_date: $('#filter_date_piutang').val(),
                    },
                    success: function(result) {
                        if (result.data) {
                            $('#laporan-piutang tbody').html('');

                            if (result.data.length > 0) {
                                $.each(result.data, function(i, val) {
                                    
                                    window.jumlah_penerimaan = 0;
                                    window.jumlah_tagihan = 0;
                                    window.jumlah_tagihan_bruto = 0;
                                    window.jumlah_pembayaran = 0;
                                    window.jumlah_sisa_piutang_penerimaan = 0;
                                    window.jumlah_sisa_piutang_tagihan = 0;

                                    $.each(val.mats, function(a, row) {
                                        window.jumlah_penerimaan += parseFloat(row.penerimaan.replace(/\./g,'').replace(',', '.'));
                                        window.jumlah_tagihan += parseFloat(row.tagihan.replace(/\./g,'').replace(',', '.'));
                                        window.jumlah_tagihan_bruto += parseFloat(row.tagihan_bruto.replace(/\./g,'').replace(',', '.'));
                                        window.jumlah_pembayaran += parseFloat(row.pembayaran.replace(/\./g,'').replace(',', '.'));
                                        window.jumlah_sisa_piutang_penerimaan += parseFloat(row.sisa_piutang_penerimaan.replace(/\./g,'').replace(',', '.'));
                                        window.jumlah_sisa_piutang_tagihan += parseFloat(row.sisa_piutang_tagihan.replace(/\./g,'').replace(',', '.'));
                                    });

                                    $('#laporan-piutang tbody').append('<tr onclick="NextShowPiutang(' + val.no + ')" class="active" style="font-weight:bold;cursor:pointer;background-color:#FF0000"><td class="text-center">' + val.no + '</td><td class="text-left">' + val.name + '</td><td class="text-right"><b>' + formatter.format(window.jumlah_penerimaan) + '</b></td><td class="text-right"><b>' + formatter.format(window.jumlah_tagihan) + '</b></td><td class="text-right"><b>' + formatter.format(window.jumlah_tagihan_bruto) + '</b></td><td class="text-right"><b>' + formatter.format(window.jumlah_pembayaran) + '</b></td><td class="text-right"><b>' + formatter.format(window.jumlah_sisa_piutang_penerimaan) + '</b></td><td class="text-right"><b>' + formatter.format(window.jumlah_sisa_piutang_tagihan) + '</b></td></tr>');
                                    //$('#laporan-piutang tbody').append('<tr onclick="NextShowPiutang(' + val.no + ')" class="active" style="font-weight:bold;cursor:pointer;background-color:#FF0000"><td class="text-center">' + val.no + '</td><td class="text-left" colspan="2">' + val.name + '</td><td class="text-right">' + val.total_penerimaan + '</td><td class="text-right">' + val.total_tagihan + '</td><td class="text-right"></td><td class="text-right"></td><td class="text-right"></td></tr>');
                                    $.each(val.mats, function(a, row) {
                                        var a_no = a + 1;
                                        $('#laporan-piutang tbody').append('<tr style="display:none;" class="mats-' + val.no + '"><td class="text-center"></td><td class="text-left">' + row.salesPo_id + '</td><td class="text-right">' + row.penerimaan + '</td><td class="text-right">' + row.tagihan + '</td><td class="text-right">' + row.tagihan_bruto + '</td><td class="text-right">' + row.pembayaran + '</td><td class="text-right">' + row.sisa_piutang_penerimaan + '</td><td class="text-right">' + row.sisa_piutang_tagihan + '</td></tr>');   
                                    });
                                    $('#laporan-piutang tbody').append('<tr style="display:none;" class="mats-' + val.no + '"><td class="text-right" colspan="2"><b>JUMLAH</b></td><td class="text-right"><b>' + formatter.format(window.jumlah_penerimaan) + '</b></td><td class="text-right"><b>' + formatter.format(window.jumlah_tagihan) + '</b></td><td class="text-right"><b>' + formatter.format(window.jumlah_tagihan_bruto) + '</b></td><td class="text-right"><b>' + formatter.format(window.jumlah_pembayaran) + '</b></td><td class="text-right"><b>' + formatter.format(window.jumlah_sisa_piutang_penerimaan) + '</b></td><td class="text-right"><b></b></td></tr>');
                                });
                                $('#laporan-piutang tbody').append('<tr style="background-color:#cccccc;"><td class="text-right" colspan="2"><b>TOTAL</b></td><td class="text-right"><b>' + result.total_penerimaan + '</b></td><td class="text-right"><b>' + result.total_tagihan + '</b></td><td class="text-right"><b>' + result.total_tagihan_bruto + '</b></td><td class="text-right"><b>' + result.total_pembayaran + '</b></td><td class="text-right"><b>' + result.total_sisa_piutang_penerimaan + '</b></td><td class="text-right"><b>' + result.total_sisa_piutang_tagihan + '</b></td></tr>');
                            } else {
                                $('#laporan-piutang tbody').append('<tr><td class="text-center" colspan="8"><b>Tidak Ada Data</b></td></tr>');
                            }
                            $('#loader-table').fadeOut('fast');
                        } else if (result.err) {
                            bootbox.alert(result.err);
                        }
                    }
                });
            }

            function NextShowPiutang(id) {
                console.log('.mats-' + id);
                $('.mats-' + id).slideToggle();
            }

            window.formatter = new Intl.NumberFormat('id-ID', {
                style: 'decimal',
                currency: 'IDR',
                symbol: 'none',
				minimumFractionDigits : '0'
            });

        </script>
        
</body>
</html>