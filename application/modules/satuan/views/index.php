<!doctype html>
<html lang="en" class="fixed">

<head>
    <?php echo $this->Templates->Header(); ?>
    <style type="text/css">
        body {
            font-family: helvetica;
        }

        .tab-pane {
            padding-top: 20px;
        }

        .select2-container--default .select2-results__option[aria-disabled=true] {
            display: none;
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
                            <li><i class="fa fa-sitemap" aria-hidden="true"></i><a href="<?php echo site_url('admin'); ?>">Dashboard</a></li>
                            <li><a><?php echo $row[0]->menu_name; ?></a></li>
                        </ul>
                    </div>
                </div>
                <div class="row animated fadeInUp">
                    <div class="col-sm-12 col-lg-12">
                        <div class="panel" style="background: linear-gradient(90deg, #f8f8f8 20%, #dddddd 40%, #f8f8f8 80%);">
                            <div class="panel-header">
                                <h3 class="section-subtitle">
                                    <?php echo $row[0]->menu_name; ?>
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="font-weight:bold; border-radius:10px;">
                                            <i class="fa fa-plus"></i> Buat Baru <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
											<li><a href="<?= site_url('satuan/form'); ?>"> Satuan</a></li>
                                        </ul>
                                    </div>
                                </h3>

                            </div>
                            <div class="panel-content">
                                <ul class="nav nav-tabs" role="tablist">
									<li role="presentation" class="active"><a href="#satuan" aria-controls="satuan" role="tab" data-toggle="tab" style="font-weight:bold; border-radius:10px 0px 10px 0px;">Satuan</a></li>
                                </ul>

                                <div class="tab-content">
									
                                    <div role="tabpanel" class="tab-pane active" id="satuan">									
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover" id="table_satuan" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Satuan</th>
                                                        <th>Hapus</th>
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

    <?php echo $this->Templates->Footer(); ?>

    <script src="<?php echo base_url(); ?>assets/back/theme/vendor/jquery.number.min.js"></script>
    
    <script src="<?php echo base_url(); ?>assets/back/theme/vendor/bootbox.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
    <script type="text/javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/back/theme/vendor/daterangepicker/moment.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/back/theme/vendor/daterangepicker/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/back/theme/vendor/daterangepicker/daterangepicker.css">
    
    <script type="text/javascript">

		var table_satuan = $('#table_satuan').DataTable( {"bAutoWidth": false,
            ajax: {
                processing: true,
                serverSide: true,
                url: '<?php echo site_url('satuan/table_satuan'); ?>',
                type: 'POST',
                data: function(d) {
                }
            },
            responsive: true,
            "deferRender": true,
            "language": {
                processing: '<i class="fa fa-spinner fa-spin fa-3x fa-fw"></i><span class="sr-only">Loading...</span> '
            },
            columns: [
				{
                    "data": "no"
                },
                {
                    "data": "nama_satuan"
                },
                {
                    "data": "delete"
                }
            ],
            "columnDefs": [
                { "width": "5%", "targets": 0, "className": 'text-center'},
            ],
        });

        function HapusSatuan(id) {
        bootbox.confirm("Anda yakin akan menghapus data ini ?", function(result) {
            // console.log('This was logged in the callback: ' + result); 
            if (result) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('satuan/hapus_satuan'); ?>",
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    success: function(result) {
                        if (result.output) {
                            table_satuan.ajax.reload();
                            bootbox.alert('Berhasil Menghapus Satuan !!');
                        } else if (result.err) {
                            bootbox.alert(result.err);
                        }
                    }
                });
            }
            });
        }
	
    </script>

</body>

</html>