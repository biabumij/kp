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
            <div class="content" style="padding:0;">
                <div class="content-header">
                    <div class="leftside-content-header">
                        <ul class="breadcrumbs">
                            <li><i class="fa fa-sitemap" aria-hidden="true"></i><a href="<?php echo site_url('admin');?>">Dashboard</a></li>
                            <li>
                                <a href="<?php echo site_url('admin/biaya');?>"> <i class="fa fa-calendar" aria-hidden="true"></i> Biaya</a></li>
                            <li><a>Detail Transakasi</a></li>
                        </ul>
                    </div>
                </div>
                <div class="row animated fadeInUp">
                    <div class="col-sm-12 col-lg-12">
                        <div class="panel">
                            <div class="panel-header"> 
                                <h3 >Detail Transaksi</h3>
                            </div>
                            <div class="panel-content">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <table class="table table-bordered table-striped table-condensed">
                                            <tr style='background-color:#cccccc; font-weight:bold;'>
                                                <th class="text-center" width="40%">JENIS TRANSAKSI</th>
                                                <td class="text-center" width="60%">NOMOR TRANSAKSI</td>
                                            </tr>
                                            <tr>
                                                <th>BIAYA</th>
                                                <td class="text-center"><a target="_blank" href="<?= base_url("pmm/biaya/detail_biaya/".$row['id_1']) ?>"><b><?= $row["no_trx_1"] ?></b></a></a></td>
                                            </tr>
                                            <tr>
                                                <th>JURNAL UMUM</th>
                                                <td class="text-center"><a target="_blank" href="<?= base_url("pmm/jurnal_umum/detailJurnal/".$row['id_2']) ?>"><b><?= $row["no_trx_2"] ?></b></a></td>
                                            </tr>
                                            <tr>
                                                <th>TERIMA</th>
                                                <td class="text-center"><a target="_blank" href="<?= base_url("pmm/finance/detailTerima/".$row['id_3']) ?>"><b><?= $row["no_trx_3"] ?></b></a></td>
                                            </tr>
                                            <tr>
                                                <th>TRANSFER</th>
                                                <td class="text-center"><a target="_blank" href="<?= base_url("pmm/finance/detailTransfer/".$row['id_4']) ?>"><b><?= $row["no_trx_4"] ?></b></a></td>
                                            </tr>
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
    <script src="<?php echo base_url();?>assets/back/theme/vendor/jquery.number.min.js"></script>
    <script src="<?php echo base_url();?>assets/back/theme/vendor/bootbox.min.js"></script>
    
</body>
</html>
