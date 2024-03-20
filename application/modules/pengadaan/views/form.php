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
                            <li><a>Permintaan Pengadaan Barang & Jasa</a></li>
                        </ul>
                    </div>
                </div>
                <div class="row animated fadeInUp">
                    <div class="col-sm-12 col-lg-12">
                        <div class="panel">
                            <div class="panel-header"> 
                                <div class="">
                                    <h3 class="">Permintaan Pengadaan Barang & Jasa</h3>                                
                                </div>
                            </div>
                            <div class="panel-content">
                                <form method="POST" action="<?php echo site_url('pengadaan/submit_pengadaan');?>" id="form-po" enctype="multipart/form-data" autocomplete="off">
                                    <div class="row">
                                        <div class="col-sm-2">
                                            <label>Judul</label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" name="judul" required="" value=""/>
                                        </div>
                                        <br />
                                        <br />
                                        <div class="col-sm-2">
                                            <label>Tanggal Permintaan</label>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control dtpicker" name="tanggal_permintaan" required="" value=""/>
                                        </div>             
                                    </div>
                                    <br />
                                    <div class="table-responsive">
                                        <table id="table-product" class="table table-bordered table-striped table-condensed table-center">
                                            <thead>
                                                <tr>
                                                    <th width="5%" rowspan="2" style="vertical-align:middle;">No</th>
                                                    <th width="20%" rowspan="2" style="vertical-align:middle;">Jenis Barang / Jasa</th>
                                                    <th width="15%" rowspan="2" style="vertical-align:middle;">Qty</th>
                                                    <th width="20%" rowspan="2" style="vertical-align:middle;">Satuan</th>
                                                    <th width="20%" colspan="2">Perkiraan Harga</th>
                                                    <th width="20%" rowspan="2" style="vertical-align:middle;">Keterangan</th>
                                                </tr>
                                                <tr>
                                                    <th>Harga Satuan</th>
                                                    <th>Jumlah</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <tr>
                                            <td>1.</td>
                                            <td>
                                                <select id="produk-1" class="form-control form-control form-select2" name="produk_1" onchange="changeData(1)" required="">
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
                                            </td>
                                            <td>
                                                <input type="text" name="qty_1" id="qty-1" class="form-control input-sm numberformat text-center" onchange="changeData(1)" required="" />
                                            </td>
                                            <td>
                                            <select id="satuan-1" class="form-control form-select2" name="satuan_1" required="">
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
                                            </td>
                                            <td>
                                                <input type="text" name="harga_satuan_1" id="harga_satuan-1" class="form-control numberformat tex-left input-sm text-right" onchange="changeData(1)"/>
                                            </td>
                                            <td>
                                                <input type="text" name="jumlah_1" id="jumlah-1" class="form-control numberformat tex-left input-sm text-right" readonly="" />
                                            </td>
                                            <td>
                                                <input type="text" name="keterangan_1" id="keterangan-1" class="form-control input-sm text-center"/>
                                            </td>
                                        </tr>
                                            </tbody>
                                        </table>    
                                    </div>
                                    <div class="col-sm-12">
                                        <button type="button" class="btn btn-info" onclick="tambahData()" style="font-weight:bold; border-radius:10px;">
                                            <i class="fa fa-plus"></i> Tambah Data
                                        </button>
                                    </div>
                                    
                                        <!-- TOTAL -->
                                        <input type="hidden" id="sub-total" value="0">
										<input type="hidden" id="sub-total-val" name="sub_total" value="0">
										<input type="hidden" id="total" value="0">
										<input type="hidden" id="total-val" name="total" value="0">
										<input type="hidden" name="total_product" id="total-product" value="1">
                                         <!-- TOTAL -->

                                    <div class="row">
                                        <div class="col-sm-12 text-right">
                                            <a href="<?= site_url('admin/pengadaan');?>" class="btn btn-danger" style="margin-bottom:0; font-weight:bold; width:15%; border-radius:10px;"><i class="fa fa-close"></i> Batal</a>
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
			var qty = $('#qty-'+id).val();
			var harga_satuan = $('#harga_satuan-'+id).val();
            				
			jumlah = ( qty * harga_satuan );
            $('#jumlah-'+id).val(jumlah);
            getTotal();
        }

        function getTotal()
        {
            var total_product = $('#total-product').val();
            $('#sub-total-val').val(0);
            var sub_total = $('#sub-total-val').val();
            var total_total = $('#total-val').val();
            
            for (var i = 1; i <= total_product; i++) {
                if($('#jumlah-'+i).val() > 0){
                    sub_total = parseInt(sub_total) + parseInt($('#jumlah-'+i).val());
                }
            }
            $('#sub-total-val').val(sub_total);
            $('#sub-total').text($.number( sub_total, 2,',','.' ));

            total_total = parseInt(sub_total);
            $('#total-val').val(total_total);
            $('#total').text($.number( total_total, 2,',','.' ));
        }
		
    </script>


</body>
</html>
