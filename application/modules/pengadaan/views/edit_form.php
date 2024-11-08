<!doctype html>
<html lang="en" class="fixed">
<head>
    <?php echo $this->Templates->Header();?>

    <style type="text/css">
        .table-center th, .table-center td{
            text-align:center;
        }
    </style>
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
                            <li><i class="fa fa-sitemap" aria-hidden="true"></i><a href="<?php echo site_url('admin');?>">Dashboard</a></li>
                            <li>
                                <a href="<?php echo site_url('admin/produksi');?>"> <i class="fa fa-calendar-check-o" aria-hidden="true"></i> Pengadaan</a></li>
                            <li><a>Edit Permintaan Pengadaan Barang & Jasa</a></li>
                        </ul>
                    </div>
                </div>
                <div class="row animated fadeInUp">
                    <div class="col-sm-12 col-lg-12">
                        <div class="panel">
                            <div class="panel-header"> 
                                <div class="">
                                    <h3 class="">Edit Permintaan Pengadaan Barang & Jasa</h3>                                
                                </div>
                            </div>
                            <div class="panel-content">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover table-bordered" id="main-table" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Judul</th>
                                                <th>Tanggal Permintaan</th>
                                                <th>Total</th>
                                                <th>Tindakan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                        </tbody>
                                        
                                    </table>
                                </div>
                                <div class="panel-content">
                                    <form id="form-product" class="form-horizontal" action="<?php echo site_url('pengadaan/product_process'); ?>" >
                                        <input type="hidden" id="pengadaan_id" name="pengadaan_id" value="<?= $data['id'] ?>">
                                        <div class="row">
                                            <div class="col-sm-2">
                                                <label>Produk</produk>
                                                <select name="produk" class="form-control form-select2">
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
                                            <div class="col-sm-2">
                                                <label>Qty</produk>
                                                <input type="number" min="0" id="qty_add" name="qty" class="form-control input-sm text-center" onchange="changeData(1)"/>
                                            </div>
                                            <div class="col-sm-2">
                                                <label>Satuan</produk>
                                                <select name="satuan" class="form-control form-select2">
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
                                            <div class="col-sm-2">
                                                <label>Harga Satuan</produk>
                                                <input type="text" id="harga_satuan_add" name="harga_satuan" class="form-control numberformat tex-left input-sm text-right" onchange="changeData(1)"/>
                                            </div>
                                            <div class="col-sm-2">
                                                <label>Jumlah</produk>
                                                <input type="text" id="jumlah_add" name="jumlah" class="form-control numberformat tex-left input-sm text-right" readonly=""/>
                                            </div>
                                            <div class="col-sm-2">
                                                <label>Keterangan</produk>
                                                <input type="text" name="keterangan" class="form-control input-sm text-center"/>
                                            </div>
                                            <br />
                                            <br />
                                            <br />
                                            <div class="col-sm-2">
                                                <button type="submit" class="btn btn-info" id="btn-form" style="font-weight:bold; border-radius:10px;"><i class="fa fa-plus"></i> Tambah</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="panel-content">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover table-bordered" id="guest-table" width="100%">
                                            <thead>
                                                <tr>
                                                    <th width="5%">No.</th>
                                                    <th>Produk</th>
                                                    <th>Qty</th>
                                                    <th>Satuan</th>
                                                    <th>Harga Satuan</th>
                                                    <th>Jumlah</th>
                                                    <th>Keterangan</th>
                                                    <th>Tindakan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- FORM DETAIL -->
                                <div class="modal fade bd-example-modal-lg" id="modalFormDetail" role="dialog">
                                    <div class="modal-dialog" role="document" >
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <span class="modal-title">Form Edit Detail Pengadaan</span>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" style="padding: 0 10px 0 20px;">
                                                    <input type="hidden" id="id" name="pengadaan_id" value="<?= $data['id'] ?>">
                                                    <input type="hidden" id="id_detail" name="id_detail" class="form-control" required="" autocomplete="off" />
                                                    <div class="form-group">
                                                        <label>Produk</label>
                                                        <select id="produk" name="produk" class="form-control form-select2">
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
                                                        <label>Satuan</label>
                                                        <select id="satuan" name="satuan" class="form-control form-select2">
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
                                                        <label>Qty</label>
                                                        <input type="text" id="qty" name="qty" class="form-control numberformat tex-left input-sm text-left" required="" autocomplete="off" onchange="changeData(1)"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Harga Satuan</label>
                                                        <input type="text" id="harga_satuan" name="harga_satuan" class="form-control numberformat tex-left input-sm text-left" required="" autocomplete="off" onchange="changeData(1)"/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Jumlah</label>
                                                        <input type="text" id="jumlah" name="jumlah" class="form-control numberformat tex-left input-sm text-left" required="" autocomplete="off" readonly=""/>
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Keterangan</label>
                                                        <input type="text" id="keterangan" name="keterangan" class="form-control input-sm text-left" autocomplete="off" />
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-success" id="btn-form" style="font-weight:bold; width:15%; border-radius:10px;"><i class="fa fa-send"></i> Kirim</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="font-weight:bold; border-radius:10px;">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- MAIN -->
                                <div class="modal fade bd-example-modal-lg" id="modalFormMain"  role="dialog">
                                    <div class="modal-dialog" role="document" >
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <span class="modal-title">Form Edit Pengadaan</span>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" style="padding: 0 10px 0 20px;">
                                                    <input type="hidden" id="id" name="pengadaan_id" value="<?= $data['id'] ?>">
                                                    <input type="hidden" id="form_id_biaya_main" name="form_id_biaya_main" class="form-control" required="" autocomplete="off" />
                                                    <div class="form-group">
                                                        <label>Judul</label>
                                                        <input type="text" id="judul" name="judul" class="form-control" required="" autocomplete="off" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Tanggal Permintaan</label>
                                                        <input type="text" id="tanggal_permintaan" name="tanggal_permintaan" class="form-control dtpicker" required="" autocomplete="off" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Total</label>
                                                        <input type="text" id="total" name="total" class="form-control numberformat" required="" autocomplete="off" />
                                                    </div>
                                                    <div class="form-group">
                                                        <label>Keterangan</label>
                                                        <input type="text" id="keterangan" name="keterangan" class="form-control dtpicker" required="" autocomplete="off" />
                                                    </div>
                                                    <div class="form-group">
                                                        <button type="submit" class="btn btn-success" id="btn-form" style="font-weight:bold; width:200px; border-radius:10px;"><i class="fa fa-send"></i> Update Pengadaan</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal" style="font-weight:bold; border-radius:10px;">Close</button>
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
    
    <script type="text/javascript">
        var form_control = '';
    </script>
    <?php echo $this->Templates->Footer();?>

    <script src="<?php echo base_url();?>assets/back/theme/vendor/jquery.number.min.js"></script>
    
    <script src="<?php echo base_url();?>assets/back/theme/vendor/daterangepicker/moment.min.js"></script>
    <script src="<?php echo base_url();?>assets/back/theme/vendor/daterangepicker/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/back/theme/vendor/daterangepicker/daterangepicker.css">
   
    <script src="<?php echo base_url();?>assets/back/theme/vendor/bootbox.min.js"></script>

    

    <script type="text/javascript">
        
        $('.form-select2').select2();

        $('input.numberformat').number( true, 0,',','.' );
        
        $('.dtpicker').daterangepicker({
            singleDatePicker: true,
            showDropdowns : true,
            locale: {
              format: 'DD-MM-YYYY'
            }
        });
        $('.dtpicker').on('apply.daterangepicker', function(ev, picker) {
              $(this).val(picker.startDate.format('DD-MM-YYYY'));
        });

		var table = $('#main-table').DataTable( {"bAutoWidth": false,
            ajax: {
                processing: true,
                serverSide: true,
                url: '<?php echo site_url('pengadaan/main_table');?>',
                type : 'POST',
                data: function ( d ) {
                    d.id = $('#id').val();
                }
            },
            columns: [
                { "data": "judul" },
                { "data": "tanggal_permintaan" },
                { "data": "total" },
                { "data": "actions" },
            ],
            responsive: true,
            searching: false,
            lengthChange: false,
            "columnDefs": [
                { "width": "5%", "targets": 3, "className": 'text-center'},
                { "targets": 2, "className": 'text-right'},
            ],
        });

        var table = $('#guest-table').DataTable( {
            ajax: {
                processing: true,
                serverSide: true,
                url: '<?php echo site_url('pengadaan/table_detail');?>',
                type : 'POST',
                data: function ( d ) {
                    d.id = $('#id').val();
                }
            },
            columns: [
                { "data": "no" },
                { "data": "produk" },
                { "data": "qty" },
                { "data": "satuan" },
                { "data": "harga_satuan" },
                { "data": "jumlah" },
				{ "data": "keterangan" },
                { "data": "actions" },
            ],
            "columnDefs": [
                { "width": "5%", "targets": [0, 7], "className": 'text-center'},
                { "targets": [2, 4, 5], "className": 'text-right'},
            ],
            responsive: true,
        });

        function changeData(id)
        {
			var qty_add = $('#qty_add').val();
			var harga_satuan_add = $('#harga_satuan_add').val();

            var qty = $('#qty').val();
			var harga_satuan = $('#harga_satuan').val();
            				
			jumlah_add = ( qty_add * harga_satuan_add);
            $('#jumlah_add').val(jumlah_add);

            jumlah = ( qty * harga_satuan);
            $('#jumlah').val(jumlah);
        }

        function DeleteData(id)
        {
            bootbox.confirm("Apakah anda yakin untuk proses data ini ?", function(result){ 
                // console.log('This was logged in the callback: ' + result); 
                if(result){
                    $.ajax({
                        type    : "POST",
                        url     : "<?php echo site_url('pengadaan/delete_detail'); ?>",
                        dataType : 'json',
                        data: {id:id},
                        success : function(result){
                            if(result.output){
                                table.ajax.reload();
                                bootbox.alert('Berhasil Menghapus!!');
                            }else if(result.err){
                                bootbox.alert(result.err);
                            }
                        }
                    });
                }
            });
        }

        $('#form-product').submit(function(event){
            $('#btn-form').button('loading');
            $.ajax({
                type    : "POST",
                url     : $(this).attr('action')+"/"+Math.random(),
                dataType : 'json',
                data: $(this).serialize(),
                success : function(result){
                    $('#btn-form').button('reset');
                    if(result.output){
                        $('#produk').val('');
                        $('#satuan').val('');
                        $('#qty').val('');
                        $('#harga_satuan').val('');
                        $('#jumlah').val('');
                        $('#keterangan').val('');
                        table.ajax.reload();
                        $('#produk').focus();
                        // bootbox.alert('Succesfully!!!');
                    }else if(result.err){
                        bootbox.alert(result.err);
                    }
                }
            });

            event.preventDefault();
            
        });

        function OpenForm(id='')
        {   
            
            $('#modalFormDetail').modal('show');
            $('#pengadaan_id').val('');
            // table_detail.ajax.reload();
            if(id !== ''){
                $('#pengadaan_id').val(id);
                getData(id);
            }
        }

        function getData(id)
        {
            $.ajax({
                type    : "POST",
                url     : "<?php echo site_url('pengadaan/get_pengadaan'); ?>",
                dataType : 'json',
                data: {id:id},
                success : function(result){
                    if(result.output){
                        $('#id_detail').val(result.output.id).trigger('change');
                        $('#produk').val(result.output.produk).trigger('change');
                        $('#satuan').val(result.output.satuan).trigger('change');
                        $('#qty').val(result.output.qty);
                        $('#harga_satuan').val(result.output.harga_satuan);
                        $('#jumlah').val(result.output.jumlah);
                        $('#keterangan').val(result.output.keterangan);
                        
                    }else if(result.err){
                        bootbox.alert(result.err);
                    }
                }
            });
        }

        $('#modalFormDetail form').submit(function(event){
            $('#btn-form').button('loading');
            $.ajax({
                type    : "POST",
                url     : "<?php echo site_url('pengadaan/form_pengadaan'); ?>/"+Math.random(),
                dataType : 'json',
                data: $(this).serialize(),
                success : function(result){
                    $('#btn-form').button('reset');
                    if(result.output){
                        $("#modalFormDetail form").trigger("reset");
                        $('#modalFormDetail').modal('hide');
                        window.location.reload('');
                    }else if(result.err){
                        bootbox.alert(result.err);
                    }
                }
            });

            event.preventDefault();
            
        });

        function OpenFormMain(id='')
        {   
            
            $('#modalFormMain').modal('show');
            $('#id').val('');
            // table_detail.ajax.reload();
            if(id !== ''){
                $('#id').val(id);
                getDataMain(id);
            }
        }

        function getDataMain(id)
        {
            $.ajax({
                type    : "POST",
                url     : "<?php echo site_url('pengadaan/get_pengadaan_main'); ?>",
                dataType : 'json',
                data: {id:id},
                success : function(result){
                    if(result.output){
                        $('#id').val(result.output.id).trigger('change');
                        $('#judul').val(result.output.judul);
                        $('#tanggal_permintaan').val(result.output.tanggal_permintaan);
                        $('#total').val(result.output.total);
                        $('#keterangan').val(result.output.keterangan);
                        
                    }else if(result.err){
                        bootbox.alert(result.err);
                    }
                }
            });
        }

        $('#modalFormMain form').submit(function(event){
            $('#btn-form').button('loading');
            $.ajax({
                type    : "POST",
                url     : "<?php echo site_url('pengadaan/form_pengadaan_main'); ?>/"+Math.random(),
                dataType : 'json',
                data: $(this).serialize(),
                success : function(result){
                    $('#btn-form').button('reset');
                    if(result.output){
                        $("#modalFormMain form").trigger("reset");
                        $('#modalFormMain').modal('hide');
                        window.location.reload('');
                    }else if(result.err){
                        bootbox.alert(result.err);
                    }
                }
            });

            event.preventDefault();
            
        });
		
    </script>


</body>
</html>
