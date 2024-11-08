<!doctype html>
<html lang="en" class="fixed">
<head>
<?php echo $this->Templates->Header();?>
<style>
    body {
        font-family: helvetica;
    }
    
    blink {
    -webkit-animation: 2s linear infinite kedip; /* for Safari 4.0 - 8.0 */
    animation: 2s linear infinite kedip;
    }
    /* for Safari 4.0 - 8.0 */
    @-webkit-keyframes kedip { 
    0% {
        visibility: hidden;
    }
    50% {
        visibility: hidden;
    }
    100% {
        visibility: visible;
    }
    }
    @keyframes kedip {
    0% {
        visibility: hidden;
    }
    50% {
        visibility: hidden;
    }
    100% {
        visibility: visible;
    }
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
                        <li><i class="fa fa-home" aria-hidden="true"></i><a href="#">Dashboard</a></li>
                    </ul>
                </div>
            </div>

            <div class="content-body">
                <div class="row animated fadeInUp">
                    <div role="tabpanel" class="tab-pane" id="welcome">
                        <div class="col-sm-12">
                            <div>
                                <p style="font-size: 24px; font-weight:bold;">SELAMAT DATANG<br />
                                DI WEB SISTEM KANTOR PUSAT<br />
                                </p>

                                <p style="font-size: 16px; font-weight:bold;">
                                    <i class="fa fa-home"> STONE CRUSHER - TULUNGAGUNG</i><br />
                                    <i class="fa fa-home"> BENDUNGAN TEMEF</i>
                                </p>
                                
                                <!--<img src=<?php echo base_url('uploads/welcome.jpg');?> style="width:100%; border-radius:20px;">-->
                                <br /><br /><br />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<?php echo $this->Templates->Footer();?>
<script src="<?php echo base_url();?>assets/back/theme/vendor/toastr/toastr.min.js"></script>
<script src="<?php echo base_url();?>assets/back/theme/vendor/chart-js/chart.min.js"></script>
<script src="<?php echo base_url();?>assets/back/theme/vendor/magnific-popup/jquery.magnific-popup.min.js"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.5.1/css/buttons.dataTables.min.css">
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script src="<?php echo base_url();?>assets/back/theme/vendor/daterangepicker/moment.min.js"></script>
<script src="<?php echo base_url();?>assets/back/theme/vendor/number_format.js"></script>
<script src="<?php echo base_url();?>assets/back/theme/vendor/daterangepicker/daterangepicker.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/back/theme/vendor/daterangepicker/daterangepicker.css">
<script type="text/javascript" src="<?php echo base_url();?>assets/back/theme/vendor/chart-js/chart.min.js"></script>

<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>


<!--Start of Tawk.to Script-->
<script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
    var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
    s1.async=true;
    s1.src='https://embed.tawk.to/64e6c76694cf5d49dc6c2cd7/1h8inlra1';
    s1.charset='UTF-8';
    s1.setAttribute('crossorigin','*');
    s0.parentNode.insertBefore(s1,s0);
    })();
</script>
<!--End of Tawk.to Script-->

</body>
</html>
