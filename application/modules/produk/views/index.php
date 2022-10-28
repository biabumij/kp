<!doctype html>
<html lang="en" class="fixed">
<head>
    <?php echo $this->Templates->Header();?>
</head>

<body>
<div class="wrap">
    
    <?php echo $this->Templates->PageHeader();?>

    <div class="page-body">
        <?php echo $this->Templates->LeftBar();?>
        <div class="content">
            <div class="content-header">
                <div class="leftside-content-header">
                    <ul class="breadcrumbs">
                        <li><i class="fa fa-home" aria-hidden="true"></i><a href="<?php echo base_url();?>">Dashboard</a></li>
                        <li><a >Produk</a></li>
                    </ul>
                </div>
            </div>
            <div class="row animated fadeInUp">
                <div class="col-sm-12 col-lg-12">
                    <div class="panel">
                        <div class="panel-header">
                            <h3 class="section-subtitle">
                            	Produk
                            	<div class="pull-right">
                            		<button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-plus"></i> Buat Baru <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?php echo site_url('produk/buat_baru'); ?>">Produk Baru</a></li>
                                      </ul>
                            	</div>
                        	</h3>
                        </div>
                        <div class="panel-content">
                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#pantry" aria-controls="pantry" role="tab" data-toggle="tab">Pantry</a></li>
                                <li role="presentation"><a href="#peralatan_kantor" aria-controls="peralatan_kantor" role="tab" data-toggle="tab">Peralatan Kantor</a></li>
                            </ul>
                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane active" id="pantry">
                                	<br />
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover table-center" id="table-pantry" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th width="5%">No.</th>
                                                    <th class="text-center">Nama Produk</th>
                                                    <th class="text-center">Kategori Produk</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div role="tabpanel" class="tab-pane" id="peralatan_kantor">
                                	<br />
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover table-center" id="table-peralatan-kantor" style="width:100%;">
                                            <thead>
                                                <tr>
                                                    <th width="5%">No.</th>
                                                    <th class="text-center">Nama Produk</th>
                                                    <th class="text-center">Kategori Produk</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                               
                                            </tbody>
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
    

    <script type="text/javascript">
        var form_control = '';
    </script>
	<?php echo $this->Templates->Footer();?>

    	

	<script src="<?php echo base_url();?>assets/back/theme/vendor/bootbox.min.js"></script>

    <script src="<?php echo base_url();?>assets/back/theme/vendor/jquery.number.min.js"></script>

    <script type="text/javascript">
        $('input.numberformat').number( true, 4,',','.' );
        $('input#contract_price, input#price_value, .total').number( true, 2,',','.' );

        var table_pantry = $('#table-pantry').DataTable( {
            ajax: {
                processing: true,
                serverSide: true,
                url: '<?php echo site_url('produk/table_pantry');?>',
                type : 'POST',
                data: function ( d ) {
                }
            },
            columns: [
                { "data": "no" },
                { "data": "nama_produk" },
                { "data": "kategori_produk" }
            ],
            responsive: true,
            pageLength : 25,
            "columnDefs": [
                {
                    "targets": [0,2],
                    "className": 'text-center',
                }
            ],
        });
      
        var table_peralatan_kantor = $('#table-peralatan-kantor').DataTable( {
            ajax: {
                processing: true,
                serverSide: true,
                url: '<?php echo site_url('produk/table_peralatan_kantor');?>',
                type : 'POST',
                data: function ( d ) {
                }
            },
            columns: [
                { "data": "no" },
                { "data": "nama_produk" },
                { "data": "kategori_produk" }
            ],
            responsive: true,
            pageLength : 25,
            "columnDefs": [
                {
                    "targets": [0,2],
                    "className": 'text-center',
                }
            ],
        });

    </script>

</body>
</html>
