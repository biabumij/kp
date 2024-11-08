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
                                                                <h3 class="panel-title">Laporan Laba Rugi TEMEF</h3>
                                                                <a href="laporan_pembelian">Kembali</a>
                                                            </div>
                                                            <div style="margin: 20px">
                                                                <div class="row">
                                                                    <form action="<?php echo site_url('laporan/cetak_laporan_laba_rugi_temef'); ?>" target="_blank">
                                                                        <div class="col-sm-3">
                                                                            <input type="text" id="filter_date_laba_rugi" name="filter_date" class="form-control dtpicker" value="<?php echo $_GET['filter_date'];?>" placeholder="Filter by Date">
                                                                        </div>
                                                                        <div class="col-sm-9 text-left">
                                                                            <button class="btn btn-default" type="submit" id="btn-print" style="border-radius:10px; font-weight:bold;"><i class="fa fa-print"></i> Print</button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                                <br />
                                                                <div id="wait-laba-rugi" style=" text-align: center; align-content: center; display: none;">	
                                                                    <div>Please Wait</div>
                                                                    <div class="fa-3x">
                                                                    <i class="fa fa-spinner fa-spin"></i>
                                                                    </div>
                                                                </div>	
                                                                <div class="table-responsive" id="laba-rugi">													
													
                    
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
            $('#filter_date_laba_rugi').daterangepicker({
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

            $('#filter_date_laba_rugi').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
                LabaRugi();
            });


            function LabaRugi()
            {
                $('#wait-laba-rugi').fadeIn('fast');   
                $.ajax({
                    type    : "POST",
                    url     : "<?php echo site_url('pmm/reports/laba_rugi_temef'); ?>/"+Math.random(),
                    dataType : 'html',
                    data: {
                        filter_date : $('#filter_date_laba_rugi').val(),
                    },
                    success : function(result){
                        $('#laba-rugi').html(result);
                        $('#wait-laba-rugi').fadeOut('fast');
                    }
                });
            }

            LabaRugi();
		</script>
        
</body>
</html>