<!doctype html>
<html lang="en" class="fixed">

<head>
    <?php echo $this->Templates->Header(); ?>
    <style type="text/css">
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
                        <div class="panel">
                            <div class="panel-header">
                                <h3 class="section-subtitle">
                                    <?php echo $row[0]->menu_name; ?>
                                    <div class="pull-right">
                                        <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa fa-plus"></i> Buat Baru <span class="caret"></span>
                                        </button>
                                        <ul class="dropdown-menu">
											<li><a href="<?= site_url('stok/form'); ?>">Buat Stok</a></li>
                                        </ul>
                                    </div>
                                </h3>

                            </div>
                            <div class="panel-content">
                                <ul class="nav nav-tabs" role="tablist">
									<li role="presentation" class="active"><a href="#stok" aria-controls="stok" role="tab" data-toggle="tab">Stok</a></li>
                                </ul>

                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="stok">
                                        <form action="<?php echo site_url('stok/cetak_stok'); ?>" target="_blank">
                                            <div class="col-sm-4">
                                                <input type="text" id="filter_date_stok" name="filter_date" class="form-control dtpickerange" autocomplete="off" placeholder="Filter By Date">
                                            </div>
                                            <div class="col-sm-1">
                                                <button type="submit" class="btn btn-info"><i class="fa fa-print"></i> Print</button>
                                            </div>
                                        </form>
										<br />
										<br />										
                                        <div class="table-responsive">
                                            <table class="table table-striped table-hover" id="table_stok" style="width:100%">
                                                <thead>
                                                    <tr>
                                                        <th width="5%" class="text-center">No.</th>
														<th width="20%" class="text-center">Tanggal</th>
                                                        <th width="20%" class="text-center">Produk</th>
                                                        <th width="10%" class="text-center">Stok</th>
                                                        <th width="10%" class="text-center">Satuan</th>
                                                        <th width="10%" class="text-center">Harga Satuan</th>
                                                        <th width="10%" class="text-center">Jumlah</th>
                                                        <th width="10%" class="text-center">Keterangan</th>
                                                        <th width="10%" class="text-center">Edit</th>
                                                        <th width="10%" class="text-center">Hapus</th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                                <tfoot>
                                                   
                                                </tfoot>
                                            </table>
                                        </div>


                                        <!-- FORM EDIT STOK -->
                                        <div class="modal fade bd-example-modal-lg" id="modalForm" tabindex="-1" role="dialog">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <span class="modal-title">Stock Opname</span>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form class="form-horizontal" style="padding: 0 10px 0 20px;">
                                                            <input type="hidden" name="id" id="id">
                                                            <div class="form-group">
                                                                <label>Tanggal Stock Opname</label>
                                                                <input type="text" id="tanggal" name="tanggal" class="form-control dtpicker" value="<?php echo date('d-m-Y'); ?>" required="">
                                                            </div>
                                                            <?php
                                                            $produk = $this->db->order_by('nama_produk', 'asc')->select('*')->get_where('produk', array('status' => 'PUBLISH'))->result_array();
                                                            $satuan = $this->db->order_by('nama_satuan', 'asc')->select('*')->get_where('satuan', array('status' => 'PUBLISH'))->result_array();
                                                            ?>
                                                            <div class="form-group">
                                                                <select id="produk" class="form-control form-control form-select2" name="produk" onchange="changeData(1)" required="">
                                                                    <option value="">Pilih Produk</option>
                                                                    <?php
                                                                    if(!empty($produk)){
                                                                        foreach ($produk as $row) {
                                                                            ?>
                                                                            <option value="<?php echo $row['id'];?>"><?php echo $row['nama_produk'];?></option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Stok</label>
                                                                <input type="text" id="jumlah_stok" name="stok" class="form-control numberformat" required="" autocomplete="off" required="" onchange="changeData(1)"/>
                                                            </div> 
                                                            <div class="form-group">
                                                                <select id="satuan" name="satuan" class="form-control form-select2" required="">
                                                                    <option value="">Pilih Satuan</option>
                                                                    <?php
                                                                    if(!empty($satuan)){
                                                                        foreach ($satuan as $sat) {
                                                                            ?>
                                                                            <option value="<?php echo $sat['id'];?>"><?php echo $sat['nama_satuan'];?></option>
                                                                            <?php
                                                                        }
                                                                    }
                                                                    ?>
                                                                    
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Harga Satuan</label>
                                                                <input type="text" id="harga_satuan" name="harga_satuan" class="form-control numberformat" required="" autocomplete="off" required="" onchange="changeData(1)"/>
                                                            </div>
                                                            <div class="form-group">
                                                                <label>Jumlah</label>
                                                                <input type="text" id="jumlah" name="jumlah" class="form-control numberformat" required="" autocomplete="off" required="" readonly=""/>
                                                            </div> 
                                                            <div class="form-group">
                                                                <button type="submit" class="btn btn-success" id="btn-form"><i class="fa fa-send"></i> Kirim</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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

    <script src="<?php echo base_url(); ?>assets/back/theme/vendor/jquery.number.min.js"></script>
    
    <script src="<?php echo base_url(); ?>assets/back/theme/vendor/bootbox.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
    <script type="text/javascript" src="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/back/theme/vendor/daterangepicker/moment.min.js"></script>
    <script src="<?php echo base_url(); ?>assets/back/theme/vendor/daterangepicker/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/back/theme/vendor/daterangepicker/daterangepicker.css">
    
    <script type="text/javascript">
	$('#filter_date_stok').daterangepicker({
        autoUpdateInput: false,
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
        },
        showDropdowns: true,
		});
		
		var table_stok = $('#table_stok').DataTable({
            ajax: {
                processing: true,
                serverSide: true,
                url: '<?php echo site_url('stok/table_stok'); ?>',
                type: 'POST',
                data: function(d) {
                    d.filter_date = $('#filter_date_stok').val();
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
                    "data": "tanggal"
                },
				{
                    "data": "produk"
                },
                {
                    "data": "stok"
                },
                {
                    "data": "satuan"
                },
                {
                    "data": "harga_satuan"
                },
                {
                    "data": "jumlah"
                },
                {
                    "data": "keterangan"
                },
                {
                    "data": "edit"
                },
                {
                    "data": "hapus"
                }
            ],
            "columnDefs": [{
                    "targets": [1, 7],
                    "className": 'text-left',
                }
            ],
            "columnDefs": [{
                    "targets": [3, 5, 6],
                    "className": 'text-right',
                }
            ],
            "columnDefs": [{
                    "targets": [0, 1, 4, 8, 9],
                    "className": 'text-center',
                }
            ],
            
        });
		
		$('#filter_date_stok').on('apply.daterangepicker', function(ev, picker) {
        $(this).val(picker.startDate.format('DD-MM-YYYY') + ' - ' + picker.endDate.format('DD-MM-YYYY'));
        table_stok.ajax.reload();
		});

        function HapusStok(id) {
        bootbox.confirm("Anda yakin akan menghapus data ini ?", function(result) {
            // console.log('This was logged in the callback: ' + result); 
            if (result) {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('stok/hapus_stok'); ?>",
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    success: function(result) {
                        if (result.output) {
                            table_stok.ajax.reload();
                            bootbox.alert('Berhasil Menghapus Stok !!');
                        } else if (result.err) {
                            bootbox.alert(result.err);
                        }
                    }
                });
            }
            });
        }

        function OpenForm(id = '') {
            $("#modalForm form").trigger("reset");
            $('#modalForm').modal('show');
            $('#id').val('');
            // table_detail.ajax.reload();
            if (id !== '') {
                $('#id').val(id);
                getData(id);
            }
        }

        function getData(id) {
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('stok/get_remaining_stok'); ?>",
                dataType: 'json',
                data: {
                    id: id
                },
                success: function(result) {
                    if (result.output) {
                        $('#id').val(result.output.id);
                        $('#tanggal').val(result.output.tanggal);
                        $('#produk').val(result.output.produk);
                        $('#jumlah_stok').val(result.output.stok);
                        $('#satuan').val(result.output.satuan);
                        $('#harga_satuan').val(result.output.harga_satuan);
                        $('#jumlah').val(result.output.jumlah);
                        $('#keterangan').val(result.output.keterangan);
                    } else if (result.err) {
                        bootbox.alert(result.err);
                    }
                }
            });
        }

        function changeData(id)
        {
			var jumlah_stok = $('#jumlah_stok').val();
			var harga_satuan = $('#harga_satuan').val();
            				
			jumlah = ( jumlah_stok * harga_satuan );
            $('#jumlah').val(jumlah);
        }

        $('#modalForm form').submit(function(event) {
            $('#btn-form').button('loading');
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('stok/update_stok'); ?>/" + Math.random(),
                dataType: 'json',
                data: $(this).serialize(),
                success: function(result) {
                    $('#btn-form').button('reset');
                    if (result.output) {
                        $("#modalForm form").trigger("reset");
                        table_stok.ajax.reload();
                        $('#modalForm').modal('hide');
                    } else if (result.err) {
                        bootbox.alert(result.err);
                    }
                }
            });

            event.preventDefault();
            window.location.reload(true);

        });

    </script>

</body>
</html>