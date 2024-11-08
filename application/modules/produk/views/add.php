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
                            <a href="<?php echo site_url('admin/productions');?>"> <i class="fa fa-calendar" aria-hidden="true"></i> Produk</a></li>
                        <li><a>Produk Baru</a></li>
                    </ul>
                </div>
            </div>
            <div class="row animated fadeInUp">
                <div class="col-sm-12 col-lg-12">
                    <div class="panel">
                        <div class="panel-header"> 
                            <div class="">
                                <h3 >Produk</h3>
                            </div>
                        </div>
                        <div class="panel-content">
                            
                            <form class="form-horizontal form-new" action="<?= site_url('produk/form_produk');?>" method="POST">
                                <input type="hidden" name="id" value="<?= (isset($edit)) ? $edit['id'] : '' ;?>">
                                <div class="row">
                                    <div class="col-sm-8">
                                        <h5>Informasi Produk</h5>
                                        <hr />
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Nama Produk</label>
                                            <div class="col-sm-8">
                                              <input type="text" class="form-control input-sm" name="nama_produk" placeholder="Masukan Nama Produk" value="<?= (isset($edit)) ? $edit['nama_produk'] : '' ;?>" />
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4 control-label">Kategori Produk</label>
                                            <div class="col-sm-5">
                                                <select id="kategori_produk" class="form-control form-select2" name="kategori_produk">
                                                    <option>Pilih Kategori Produk</option>
                                                    <?php
                                                    if($kategori){
                                                        foreach ($kategori as $key => $kat) {
                                                            $selected = false;
                                                            if(isset($edit) && $edit['kategori_produk'] == $kat['nama_kategori_produk']){
                                                                $selected = 'selected';
                                                            }
                                                            ?>
                                                            <option value="<?= $kat['nama_kategori_produk'];?>" <?= $selected;?> ><?= $kat['nama_kategori_produk'];?></option>
                                                            <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <button type="button" class="btn btn-xs btn-info" onclick="TambahKategori()" style="font-weight:bold; border-radius:10px;"><i class="fa fa-plus"></i> Kategori Produk</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <br />
                                <div class="row">
                                    <div class="col-sm-8 text-right">
                                        <a href="<?= site_url('admin/produk');?>" class="btn btn-danger" style="margin-bottom:0; font-weight:bold; border-radius:10px;"><i class="fa fa-close"></i> Batal</a>
                                        <button type="submit" class="btn btn-success" style="font-weight:bold; border-radius:10px;"><i class="fa fa-send"></i> Kirim</button>
                                    </div>
                                </div>
                            </form>

                            <div class="modal fade bd-example-modal-lg" id="modalForm" tabindex="-1" role="dialog">
                                <div class="modal-dialog" role="document" >
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <span class="modal-title">Tambah Kategori Produk</span>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <form id="form-kategori-produk" class="form-horizontal" action="<?= site_url('produk/tambah_kategori_produk');?>" >
                                                <div class="form-group">
                                                    <label class="col-sm-4">Kategori Produk</label>
                                                    <div class="col-sm-8">
                                                    <input type="text" name="nama_kategori_produk" class="form-control input-sm" placeholder="Masukan Nama Produk" required="" >
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="col-sm-12 text-right">
                                                        <button type="submit" class="btn btn-success btn-sm" id="btn-form"><i class="fa fa-send"></i> Kirim</button>
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

    function TambahKategori()
        {
            $('#modalForm').modal('show');
        }

        $('#form-kategori-produk').submit(function(event){
            $.ajax({
                type    : "POST",
                url     : $(this).attr('action')+"/"+Math.random(),
                dataType : 'json',
                data: $(this).serialize(),
                success : function(result){
                    if(result.output){
                        $("#form-kategori-produk").trigger("reset");
                        $('#kategori').empty();
                        $('#kategori').select2({data:result.data});
                        $('#modalForm').modal('hide');
                    }else if(result.err){
                        bootbox.alert(result.err);
                    }
                }
            });

            event.preventDefault();
            
        });

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

</script>

</body>
</html>
