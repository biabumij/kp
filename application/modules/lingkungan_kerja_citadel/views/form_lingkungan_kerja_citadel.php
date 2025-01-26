<!doctype html>
<html lang="en" class="fixed">
<head>
    <?php echo $this->Templates->Header();?>

	<style type="text/css">
        .table-center th{
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
                            <li><a href="<?php echo site_url('admin/evaluasi#evaluasi_supplier');?>">Evaluasi Supplier</a></li>
                            <li><a>Buat Check List</a></li>
                        </ul>
                    </div>
                </div>
                <div class="row animated fadeInUp">
                    <div class="col-sm-12 col-lg-12">
                        <div class="panel">
                            <div class="panel-header"> 
                                <div class="">
                                    <h3 class="">Check List Lingkungan Kerja</h3>                                
                                </div>
                            </div>
                            <div class="panel-content">
                                <form method="POST" action="<?php echo site_url('lingkungan_kerja_citadel/submit_lingkungan_kerja_citadel');?>" id="form-po" enctype="multipart/form-data" autocomplete="off">
                                    <div class="row">
										<div class="col-sm-2">
                                            <label>Tanggal<span class="required" aria-required="true">*</span></label>
                                        </div>
										<div class="col-sm-6">
                                            <input type="text" class="form-control dtpicker" name="tanggal" required="" value=""/>
                                        </div>               
                                    </div>
									<br /><br />
									<div class="table-responsive">
										<table id="table-product" class="table table-bordered table-striped table-condensed table-center">
											<thead>
												<tr>
													<th width="5%">No</th>
													<th width="15%">Jenis Parameter</th>
													<th colspan="2">Lobby</th>
													<th colspan="2">Ruang Tengah</th>
													<th colspan="2">Ruang Direktur</th>
													<th colspan="2">Ruang Meeting</th>
													<th colspan="2">Ruang Arsip</th>
													<th>Tindakan</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td align="center">1.</td>
													<td align="left">Suhu Ruangan <br />(°Celcius)</td>
													<td align="center"><input type="text" class="form-control" name="suhu_lobby_pagi" value="" placeholder="Pagi"></td>
													<td align="center"><input type="text" class="form-control" name="suhu_lobby_sore" value="" placeholder="Sore"></td>
													<td align="center"><input type="text" class="form-control" name="suhu_tengah_pagi" value="" placeholder="Pagi"></td>
													<td align="center"><input type="text" class="form-control" name="suhu_tengah_sore" value="" placeholder="Sore"></td>
													<td align="center"><input type="text" class="form-control" name="suhu_direktur_pagi" value="" placeholder="Pagi"></td>
													<td align="center"><input type="text" class="form-control" name="suhu_direktur_sore" value="" placeholder="Sore"></td>
													<td align="center"><input type="text" class="form-control" name="suhu_meeting_pagi" value="" placeholder="Pagi"></td>
													<td align="center"><input type="text" class="form-control" name="suhu_meeting_sore" value="" placeholder="Sore"></td>
													<td align="center"><input type="text" class="form-control" name="suhu_arsip_pagi" value="" placeholder="Pagi"></td>
													<td align="center"><input type="text" class="form-control" name="suhu_arsip_sore" value="" placeholder="Sore"></td>
													<td align="center"><input type="text" class="form-control" name="suhu_tindakan" placeholder="Tindakan"/></td>
												</tr>
												<tr>
													<td align="center">2.</td>
													<td align="left">Kelembaban Ruangan <br />(%)</td>
													<td align="center"><input type="text" class="form-control" name="kelembaban_lobby_pagi" value="" placeholder="Pagi"></td>
													<td align="center"><input type="text" class="form-control" name="kelembaban_lobby_sore" value="" placeholder="Sore"></td>
													<td align="center"><input type="text" class="form-control" name="kelembaban_tengah_pagi" value="" placeholder="Pagi"></td>
													<td align="center"><input type="text" class="form-control" name="kelembaban_tengah_sore" value="" placeholder="Sore"></td>
													<td align="center"><input type="text" class="form-control" name="kelembaban_direktur_pagi" value="" placeholder="Pagi"></td>
													<td align="center"><input type="text" class="form-control" name="kelembaban_direktur_sore" value="" placeholder="Sore"></td>
													<td align="center"><input type="text" class="form-control" name="kelembaban_meeting_pagi" value="" placeholder="Pagi"></td>
													<td align="center"><input type="text" class="form-control" name="kelembaban_meeting_sore" value="" placeholder="Sore"></td>
													<td align="center"><input type="text" class="form-control" name="kelembaban_arsip_pagi" value="" placeholder="Pagi"></td>
													<td align="center"><input type="text" class="form-control" name="kelembaban_arsip_sore" value="" placeholder="Sore"></td>
													<td align="center"><input type="text" class="form-control" name="kelembaban_tindakan" placeholder="Tindakan"/></td>
												</tr>
												<tr>
													<td align="center">3.</td>
													<td align="left">Intensitas Cahaya</td>
													<td align="center"><input type="text" class="form-control" name="cahaya_lobby_pagi" value="" placeholder="Pagi"></td>
													<td align="center"><input type="text" class="form-control" name="cahaya_lobby_sore" value="" placeholder="Sore"></td>
													<td align="center"><input type="text" class="form-control" name="cahaya_tengah_pagi" value="" placeholder="Pagi"></td>
													<td align="center"><input type="text" class="form-control" name="cahaya_tengah_sore" value="" placeholder="Sore"></td>
													<td align="center"><input type="text" class="form-control" name="cahaya_direktur_pagi" value="" placeholder="Pagi"></td>
													<td align="center"><input type="text" class="form-control" name="cahaya_direktur_sore" value="" placeholder="Sore"></td>
													<td align="center"><input type="text" class="form-control" name="cahaya_meeting_pagi" value="" placeholder="Pagi"></td>
													<td align="center"><input type="text" class="form-control" name="cahaya_meeting_sore" value="" placeholder="Sore"></td>
													<td align="center"><input type="text" class="form-control" name="cahaya_arsip_pagi" value="" placeholder="Pagi"></td>
													<td align="center"><input type="text" class="form-control" name="cahaya_arsip_sore" value="" placeholder="Sore"></td>
													<td align="center"><input type="text" class="form-control" name="cahaya_tindakan" placeholder="Tindakan"/></td>
												</tr>
												<tr>
													<td align="center">4.</td>
													<td align="left">Sirkulasi Udara</td>
													<td align="center"><input type="text" class="form-control" name="udara_lobby_pagi" value="" placeholder="Pagi"></td>
													<td align="center"><input type="text" class="form-control" name="udara_lobby_sore" value="" placeholder="Sore"></td>
													<td align="center"><input type="text" class="form-control" name="udara_tengah_pagi" value="" placeholder="Pagi"></td>
													<td align="center"><input type="text" class="form-control" name="udara_tengah_sore" value="" placeholder="Sore"></td>
													<td align="center"><input type="text" class="form-control" name="udara_direktur_pagi" value="" placeholder="Pagi"></td>
													<td align="center"><input type="text" class="form-control" name="udara_direktur_sore" value="" placeholder="Sore"></td>
													<td align="center"><input type="text" class="form-control" name="udara_meeting_pagi" value="" placeholder="Pagi"></td>
													<td align="center"><input type="text" class="form-control" name="udara_meeting_sore" value="" placeholder="Sore"></td>
													<td align="center"><input type="text" class="form-control" name="udara_arsip_pagi" value="" placeholder="Pagi"></td>
													<td align="center"><input type="text" class="form-control" name="udara_arsip_sore" value="" placeholder="Sore"></td>
													<td align="center"><input type="text" class="form-control" name="udara_tindakan" placeholder="Tindakan"/></td>
												</tr>
												<tr>
													<td align="center">5.</td>
													<td align="left">Tingkat Kebisingan</td>
													<td align="center"><input type="text" class="form-control" name="kebisingan_lobby_pagi" value="" placeholder="Pagi"></td>
													<td align="center"><input type="text" class="form-control" name="kebisingan_lobby_sore" value="" placeholder="Sore"></td>
													<td align="center"><input type="text" class="form-control" name="kebisingan_tengah_pagi" value="" placeholder="Pagi"></td>
													<td align="center"><input type="text" class="form-control" name="kebisingan_tengah_sore" value="" placeholder="Sore"></td>
													<td align="center"><input type="text" class="form-control" name="kebisingan_direktur_pagi" value="" placeholder="Pagi"></td>
													<td align="center"><input type="text" class="form-control" name="kebisingan_direktur_sore" value="" placeholder="Sore"></td>
													<td align="center"><input type="text" class="form-control" name="kebisingan_meeting_pagi" value="" placeholder="Pagi"></td>
													<td align="center"><input type="text" class="form-control" name="kebisingan_meeting_sore" value="" placeholder="Sore"></td>
													<td align="center"><input type="text" class="form-control" name="kebisingan_arsip_pagi" value="" placeholder="Pagi"></td>
													<td align="center"><input type="text" class="form-control" name="kebisingan_arsip_sore" value="" placeholder="Sore"></td>
													<td align="center"><input type="text" class="form-control" name="kebisingan_tindakan" placeholder="Tindakan"/></td>
												</tr>
											</tbody>
											<tfoot>
											</tfoot>
										</table>
										<br />
										<div class="col-sm-12">
											<div class="text-center">
												<a href="<?= site_url('admin/lingkungan_kerja');?>" class="btn btn-info" style="width:10%; margin-bottom:0px; font-weight:bold; border-radius:10px;"><i class="fa fa-arrow-left"></i> Kembali</a>
												<button type="submit" class="btn btn-success" style="width:10%; font-weight:bold; border-radius:10px;"><i class="fa fa-send"></i> Kirim</button>
											</div>
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
        $('input.numberformat').number( true, 2,',','.' );
		$('input.rupiahformat').number( true, 0,',','.' );

        tinymce.init({
          selector: 'textarea#about_text',
          height: 200,
          menubar: false,
        });
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
    </script>

	<script>
	$('#supplier_id').on('change', function() {
		var address = $(this).find(':selected').attr('data-address')
		var idSupplier = $(this).find(':selected').attr('data-idSupplier')
		var kontak = $(this).find(':selected').attr('data-kontak')
		var telepon = $(this).find(':selected').attr('data-telepon')
		var email = $(this).find(':selected').attr('data-email')
		$("#alamat_supplier").val(address);
		$("#nama_kontak").val(kontak);
		$("#nomor_kontak").val(telepon);
		$("#email").val(email);
	});
	
	</script>


</body>
</html>
