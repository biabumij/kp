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
                                                                <div class="row">
                                                                <form action="<?php echo site_url('laporan/cetak_daftar_penerimaan_sc'); ?>" target="_blank">
                                                                    <div class="col-sm-3">
                                                                        <input type="text" id="filter_date_penerimaan" name="filter_date" class="form-control dtpicker" value="<?php echo $_GET['filter_date'];?>" placeholder="Filter by Date">
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
                                                                    <table class="table table-striped table-hover table-center table-bordered table-condensed" id="daftar-penerimaan" style="display:none" width="100%";>
                                                                        <thead>
                                                                        <tr class="judul">
                                                                            <th class="text-center" rowspan="2" style="vertical-align:middle;">NO.</th>
                                                                            <th class="text-center">PELANGGAN</th>
                                                                            <th class="text-center" rowspan="2" style="vertical-align:middle;">NO. TRANSAKSI</th>
                                                                            <th class="text-center" rowspan="2" style="vertical-align:middle;">NO. TAGIHAN</th>
                                                                            <th class="text-center" rowspan="2" style="vertical-align:middle;">PEMBAYARAN</th>
                                                                        </tr>
                                                                        <tr class="judul">
                                                                            <th class="text-center">TGL. BAYAR</th>
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
        $('#filter_date_penerimaan').daterangepicker({
            autoUpdateInput: false,
            showDropdowns : true,
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

        $('#filter_date_penerimaan').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
            DaftarPenerimaan();
        });

        DaftarPenerimaan();

        function DaftarPenerimaan() {
            $('#daftar-penerimaan').show();
            $('#loader-table').fadeIn('fast');
            $('#daftar-penerimaan tbody').html('');
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('pmm/productions/daftar_penerimaan_sc'); ?>/" + Math.random(),
                dataType: 'json',
                data: {
                    filter_date: $('#filter_date_penerimaan').val(),
                },
                success: function(result) {
                    if (result.data) {
                        $('#daftar-penerimaan tbody').html('');

                        if (result.data.length > 0) {
                            $.each(result.data, function(i, val) {
                                    window.jumlah_penerimaan = 0;
                                $.each(val.mats, function(a, row) {
                                    window.jumlah_penerimaan += parseFloat(row.penerimaan.replace(/\./g,'').replace(',', '.'));
                                });
                                $('#daftar-penerimaan tbody').append('<tr onclick="NextShowPenerimaan(' + val.no + ')" class="active" style="font-weight:bold;cursor:pointer;"><td class="text-center">' + val.no + '</td><td class="text-left">' + val.nama + '</td><td></td><td></td><td class="text-right"><b>' + formatter.format(window.jumlah_penerimaan) + '</b></td></tr>');
                                $.each(val.mats, function(a, row) {
                                    var a_no = a + 1;
                                    $('#daftar-penerimaan tbody').append('<tr style="display:none;" class="mats-' + val.no + '"><td class="text-center"></td><td class="text-center">' + row.tanggal_pembayaran + '</td><td class="text-left">' + row.nomor_transaksi + '</td></td><td class="text-left">' + row.nomor_invoice + '</td><td class="text-right">' + row.penerimaan + '</td></tr>');
                                });
                            });
                            $('#daftar-penerimaan tbody').append('<tr><td class="text-right" colspan="4"><b>TOTAL</b></td><td class="text-right" ><b>' + result.total + '</b></td></tr>');
                        } else {
                            $('#daftar-penerimaan tbody').append('<tr><td class="text-center" colspan="5"><b>Tidak Ada Data</b></td></tr>');
                        }
                        $('#loader-table').fadeOut('fast');
                    } else if (result.err) {
                        bootbox.alert(result.err);
                    }
                }
            });
        }

        function NextShowPenerimaan(id) {
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