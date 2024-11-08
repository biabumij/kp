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
                                <a href="<?php echo site_url('admin/produksi');?>"> <i class="fa fa-calendar-check-o" aria-hidden="true"></i> Stok</a></li>
                            <li><a>Buat Stok</a></li>
                        </ul>
                    </div>
                </div>
                <div class="row animated fadeInUp">
                    <div class="col-sm-12 col-lg-12">
                        <div class="panel">
                            <div class="panel-header"> 
                                <div class="">
                                    <h3 class="">Buat Stok</h3>                                
                                </div>
                            </div>
                            <div class="panel-content">
                                <form method="POST" action="<?php echo site_url('stok/submit_stok');?>" id="form-po" enctype="multipart/form-data" autocomplete="off">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label>Tanggal</label>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control dtpicker" name="tanggal" required="" value=""/>
                                        </div>             
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label>Produk</label>
                                        </div>
                                        <div class="col-sm-3">
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
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label>Stok</label>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" name="stok" id="stok" class="form-control input-sm numberformat text-left input-sm" onchange="changeData(1)" required="" />
                                        </div>             
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label>Satuan</label>
                                        </div>
                                        <div class="col-sm-3">
                                            <select id="satuan" class="form-control form-select2" name="satuan" required="">
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
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label>Harga Satuan</label>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" name="harga_satuan" id="harga_satuan" class="form-control numberformat text-left input-sm" onchange="changeData(1)" required=""/>
                                        </div>             
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label>Jumlah</label>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" name="jumlah" id="jumlah" class="form-control numberformat text-left input-sm" required="" readonly=""/>
                                        </div>             
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label>Keterangan</label>
                                        </div>
                                        <div class="col-sm-8">
                                        <input type="text" name="keterangan" id="keterangan" class="form-control input-sm"/>
                                        </div>             
                                    </div>
                                    <br />
                                    <div class="row">
                                        <div class="col-sm-12 text-left">
                                            <a href="<?= site_url('admin/stok');?>" class="btn btn-danger" style="margin-bottom:0; font-weight:bold; width:15%; border-radius:10px;"><i class="fa fa-close"></i> Batal</a>
                                            <button type="submit" class="btn btn-success" style="font-weight:bold; width:15%; border-radius:10px;"><i class="fa fa-send"></i> Kirim</button>
                                        </div>
                                    </div>
                                </form>
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

		function tambahData()
        {
            var number = parseInt($('#total-product').val()) + 1;

            $.ajax({
                type    : "POST",
                url     : "<?php echo site_url('pengadaan/add_produk'); ?>/"+Math.random(),
                data: {no:number},
                success : function(result){
                    $('#table-product tbody').append(result);
                    $('#total-product').val(parseInt(number));
                }
            });
        }

        $('#form-po').submit(function(e){
            e.preventDefault();
            var currentForm = this;
            bootbox.confirm({
                message: "Apakah anda yakin untuk proses data ini ?",
                buttons: {
                    confirm: {
                        label: 'Yes',
                        className: 'btn-success'
                    },
                    cancel: {
                        label: 'No',
                        className: 'btn-danger'
                    }
                },
                callback: function (result) {
                    if(result){
                        currentForm.submit();
                    }
                    
                }
            });
            
        });
		
		function changeData(id)
        {
			var stok = $('#stok').val();
			var harga_satuan = $('#harga_satuan').val();
            				
			jumlah = ( stok * harga_satuan );
            $('#jumlah').val(jumlah);
        }
		
    </script>


</body>
</html>