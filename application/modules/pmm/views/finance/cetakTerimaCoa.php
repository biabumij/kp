<!DOCTYPE html>
<html>
    <head>
      <title>PEMBERITAHUAN PEMBAYARAN</title>
      
      <style type="text/css">
        body{
            font-family: "Open Sans", Arial, sans-serif;
        }
        table.minimalistBlack {
          /*border: 1px solid #cccccc;*/
          width: 100%;
          text-align: left;
        }
        table.minimalistBlack td, table.minimalistBlack th {
          border: 0.5px solid #cccccc;
          padding: 5px 4px;
        }
        table.minimalistBlack tr td {
          /*font-size: 13px;*/
          /*text-align:center;*/
        }
        table.minimalistBlack tr th {
          /*font-size: 14px;*/
          font-weight: bold;
          padding: 10px;
        }
        table.minimalistBlack .table-akun{
            background-color: #668d98;
            color: #fff;
        }
        table.minimalistBlack .table-akun th{
            color: #fff;
        }

        table tr.table-active{
            background-color: #b5b5b5;
        }
        table tr.table-active2{
            background-color: #cac8c8;
        }
        table tr.table-active3{
            font-weight: bold;
        }
        hr{
            margin-top:0;
            margin-bottom:30px;
        }
        h3{
            margin-top:0;
        }
      </style>

    </head>
    <body>
        <table width="100%" border="0" cellpadding="3">
            <tr >
                <td align="center">
                    <div style=";font-weight: bold;font-size: 14px;border-bottom: 1px solid #000;border-top: 1px solid #000;text-transform: uppercase;">BUKTI PENERIMAAN</div>
                </td>
            </tr>
        </table>
        <br /><br />
        <table width="100%" border="0" cellpadding="3">
            <tr>
                <th width="25%">Terima Dari</th>
                <th width="2%">:</th>
                <th width="73%" align="left"><?= $detail["terima_dari"] ?></th>
            </tr>
            <tr>
                <th>Setor Ke</th>
                <th >:</th>
                <th align="left"><?= $detail["setor_ke"] ?></th>
            </tr>
            <tr>
                <th>Nomor Transaksi</th>
                <th >:</th>
                <th align="left"><?= $detail["nomor_transaksi"] ?></th>
            </tr>
            <tr>
                <th>Tanggal Transaksi</th>
                <th >:</th>
                <th align="left"><?= date('d F Y',strtotime($detail["tanggal_transaksi"])) ?></th>
            </tr>
        </table>
        <table width="100%" border="0" cellpadding="3">
            <tr>
                <th width="25%">Jumlah</th>
                <th width="2%">:</th>
                <th width="73%" align="left">Rp. <?= $this->filter->Rupiah($detail['jumlah']);?></th>
            </tr>
            <tr>
                <th width="25%">TERBILANG</th>
                <th width="2%">:</th>
                <th width="73%" align="left"><?= $this->filter->terbilang($detail['jumlah']);?></th>
            </tr>
        </table>
        <br />
        <br />
        <table width="98%" border="0" cellpadding="0">
            <tr>
                <td width="100%">
                    <table width="100%" border="1" cellpadding="2">
                        <tr class="">
                            <td align="center">
                                Dibuat Oleh
                            </td>
                            <td align="center">
                                Diperiksa Oleh
                            </td>
                            <td align="center" >
                                Disetujui Oleh
                            </td>
                            <td align="center" >
                                Diketahui Oleh
                            </td>
                        </tr>
                        <tr class="">
                            <td align="center" height="75px">
                                
                            </td>
                            <td align="center">
                                
                            </td>
                            <td align="center">
                                
                            </td>
                            <td align="center">
                                
                            </td>
                        </tr>
                        <tr class="table-active3">
                            <?php
                            $kasir = $this->pmm_model->GetNameGroup(19);
                            $ka_plant = $this->pmm_model->GetNameGroup(15);
                            $pj_keuangan = $this->pmm_model->GetNameGroup(14);
                            $direksi = $this->pmm_model->GetNameGroup(6);
                            ?>  
                            <td align="center">
                                <?=  $kasir['admin_name'];?>
                            </td>
                            <td align="center">
                                <?=  $pj_keuangan['admin_name'];?>
                            </td>
                            <td align="center">
                                <?=  $ka_plant['admin_name'];?>
                            </td>
                            <td align="center">
                                
                            </td>
                        </tr>
                         <tr class="table-active3">
                            <td align="center">
                                <?= $kasir['admin_group_name']?>
                            </td>
                            <td align="center">
                                <?=  $pj_keuangan['admin_group_name'];?>
                            </td>
                            <td align="center">
                                <?=  $ka_plant['admin_group_name'];?>
                            </td>
                            <td align="center">
                                Penerima
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

    </body>
</html>