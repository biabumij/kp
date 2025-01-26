<!DOCTYPE html>
<html>
	<head>
	  <?= include 'lib.php'; ?>
	  <title>LINGKUNGAN KERJA</title>
	  
	  <style type="text/css">
		body {
			font-size: 8.5px;
			font-family: "Open Sans", Arial, sans-serif;
		}
	  </style>

	</head>
	<body>
	<br /><br />
		<table width="98%" border="1" cellpadding="3">
			<tr>
				<td align="center" rowspan="3" width="70%" style="font-weight:bold; font-size:14px;">&nbsp; <br />CHECKLIST LINGKUNGAN KERJA</td>
				<td align="left" width="15%">Nama Dok.</td>
				<td align="left" width="15%">FM-CK.LK</td>
			</tr>
			<tr>
				<td align="left">No. Revisi</td>
				<td align="left">-</td>
			</tr>
			<tr>
				<td align="left">Tahun</td>
				<td align="left">2023</td>
			</tr>
		</table>
		<br /><br /><br /><br />
		<table width="98%" border="0" cellpadding="3">
			<tr>
				<td align="left" width="15%">Nama Pemeriksa</td>
				<td align="center" width="3%">:</td>
				<td align="left" width="25%"><?php echo $this->crud_global->GetField('tbl_admin',array('admin_id'=>$row['created_by']),'admin_name');?></td>
			</tr>
			<?php
			$tanggal = $row['tanggal'];
			function tgl_indo($tanggal){
				$bulan = array (
					1 =>   'Januari',
					'Februari',
					'Maret',
					'April',
					'Mei',
					'Juni',
					'Juli',
					'Agustus',
					'September',
					'Oktober',
					'November',
					'Desember'
				);
				$pecahkan = explode('-', $tanggal);
				
				// variabel pecahkan 0 = tanggal
				// variabel pecahkan 1 = bulan
				// variabel pecahkan 2 = tahun
			
				return  '' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
				
			}
			?>
			<tr>
				<td align="left" width="15%">Periode Pengukuran</td>
				<td align="center" width="3%">:</td>
				<td align="left" width="25%"><?= tgl_indo(date($tanggal)); ?></td>
			</tr>
			<tr>
				<td align="left" width="15%">Tanggal</td>
				<td align="center" width="3%">:</td>
				<td align="left" width="25%"><?= date('d/m/Y',strtotime($row['tanggal']));?></td>
			</tr>
		</table>
		<br />
		<br />
		<table width="98%" border="1" cellpadding="3">
			<tr>
				<th align="center" rowspan="2" width="20%" style="font-weight:bold; background-color:#f1c232;">&nbsp; <br />Jenis Parameter</th>
				<th align="center" width="12%" colspan="2" style="font-weight:bold; background-color:#f1c232;">Lobby</th>
				<th align="center" width="12%" colspan="2" style="font-weight:bold; background-color:#f1c232;">Ruang Tengah</th>
				<th align="center" width="12%" colspan="2" style="font-weight:bold; background-color:#f1c232;">Ruang Direktur</th>
				<th align="center" width="12%" colspan="2" style="font-weight:bold; background-color:#f1c232;">Ruang Meeting</th>
				<th align="center" width="12%" colspan="2" style="font-weight:bold; background-color:#f1c232;">Ruang Arsip</th>
				<th align="center" rowspan="2" width="20%" style="font-weight:bold; background-color:#f1c232;">&nbsp; <br />Tindakan Koreksi</th>
            </tr>
			<tr>
				<th align="center" style="font-weight:bold; background-color:#f1c232;">Pagi</th>
				<th align="center" style="font-weight:bold; background-color:#f1c232;">Sore</th>
				<th align="center" style="font-weight:bold; background-color:#f1c232;">Pagi</th>
				<th align="center" style="font-weight:bold; background-color:#f1c232;">Sore</th>
				<th align="center" style="font-weight:bold; background-color:#f1c232;">Pagi</th>
				<th align="center" style="font-weight:bold; background-color:#f1c232;">Sore</th>
				<th align="center" style="font-weight:bold; background-color:#f1c232;">Pagi</th>
				<th align="center" style="font-weight:bold; background-color:#f1c232;">Sore</th>
				<th align="center" style="font-weight:bold; background-color:#f1c232;">Pagi</th>
				<th align="center" style="font-weight:bold; background-color:#f1c232;">Sore</th>
            </tr>
			<tr>
				<td align="left">Suhu Ruangan °C</td>
				<td align="right"><?php echo number_format($row['suhu_lobby_pagi'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['suhu_lobby_sore'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['suhu_tengah_pagi'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['suhu_tengah_sore'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['suhu_direktur_pagi'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['suhu_direktur_sore'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['suhu_meeting_pagi'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['suhu_meeting_sore'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['suhu_arsip_pagi'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['suhu_arsip_sore'],1,',','.');?></td>
				<td align="left"><?php echo $row['suhu_tindakan'];?></td>
			</tr>
			<tr>
				<td align="left">Kelembaban Ruangan %</td>
				<td align="right"><?php echo number_format($row['kelembaban_lobby_pagi'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['kelembaban_lobby_sore'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['kelembaban_tengah_pagi'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['kelembaban_tengah_sore'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['kelembaban_direktur_pagi'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['kelembaban_direktur_sore'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['kelembaban_meeting_pagi'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['kelembaban_meeting_sore'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['kelembaban_arsip_pagi'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['kelembaban_arsip_sore'],1,',','.');?></td>
				<td align="left"><?php echo $row['kelembaban_tindakan'];?></td>
			</tr>
			<tr>
				<td align="left">Intensitas Cahaya</td>
				<td align="right"><?php echo number_format($row['cahaya_lobby_pagi'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['cahaya_lobby_sore'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['cahaya_tengah_pagi'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['cahaya_tengah_sore'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['cahaya_direktur_pagi'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['cahaya_direktur_sore'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['cahaya_meeting_pagi'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['cahaya_meeting_sore'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['cahaya_arsip_pagi'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['cahaya_arsip_sore'],1,',','.');?></td>
				<td align="left"><?php echo $row['cahaya_tindakan'];?></td>
			</tr>
			<tr>
				<td align="left">Sirkulasi Udara</td>
				<td align="right"><?php echo number_format($row['udara_lobby_pagi'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['udara_lobby_sore'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['udara_tengah_pagi'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['udara_tengah_sore'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['udara_direktur_pagi'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['udara_direktur_sore'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['udara_meeting_pagi'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['udara_meeting_sore'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['udara_arsip_pagi'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['udara_arsip_sore'],1,',','.');?></td>
				<td align="left"><?php echo $row['udara_tindakan'];?></td>
			</tr>
			<tr>
				<td align="left">Tingkat Kebisingan</td>
				<td align="right"><?php echo number_format($row['kebisingan_lobby_pagi'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['kebisingan_lobby_sore'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['kebisingan_tengah_pagi'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['kebisingan_tengah_sore'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['kebisingan_direktur_pagi'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['kebisingan_direktur_sore'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['kebisingan_meeting_pagi'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['kebisingan_meeting_sore'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['kebisingan_arsip_pagi'],1,',','.');?></td>
				<td align="right"><?php echo number_format($row['kebisingan_arsip_sore'],1,',','.');?></td>
				<td align="left"><?php echo $row['kebisingan_tindakan'];?></td>
			</tr>
		</table>
		<br /><br />
		<table width="98%" border="0" cellpadding="1">
			<tr>
				<td style="font-weight:bold;">NILAI NORMAL / AMBANG BATAS</td>
			</tr>
		</table>
		<table width="98%" border="1" cellpadding="1">
			<tr>
				<td width="3%" align="center" style="font-weight:bold;">No.</td>
				<td width="15%" align="center" style="font-weight:bold;">Jenis Parameter</td>
				<td width="10%" align="center" style="font-weight:bold;">Satuan</td>
				<td width="20%" align="center" style="font-weight:bold;">Kadar Dipersyaratkan</td>
			</tr>
			<tr>
				<td align="center">1.</td>
				<td align="center">Suhu</td>
				<td align="center">°C</td>
				<td align="center">18-30</td>
			</tr>
			<tr>
				<td align="center">2.</td>
				<td align="center">Kelembaban</td>
				<td align="center">% Rh</td>
				<td align="center">40-60</td>
			</tr>
			<tr>
				<td align="center">3.</td>
				<td align="center">Intensitas Cahaya</td>
				<td align="center">Lux</td>
				<td align="center">Minimal 60</td>
			</tr>
			<tr>
				<td align="center">4.</td>
				<td align="center">Sirkulasi Udara</td>
				<td align="center">m / dtk</td>
				<td align="center">0.15 - 0.25</td>
			</tr>
			<tr>
				<td align="center">5.</td>
				<td align="center">Tingkat Kebisingan</td>
				<td align="center">dBA</td>
				<td align="center">Maksimal 85</td>
			</tr>
		</table>
		<table width="98%" border="0" cellpadding="1">
			<tr>
				<td style="font-weight:bold;"><i>* PerMenKes RI No. 1077/MENKES/PER/V/2011 dan PerMenKes RI No. 70 Tahun 2016</i></td>
			</tr>
		</table>
		<br /><br /><br /><br />
		<?php
			$this->db->select('a.admin_name, g.admin_group_name, a.admin_ttd');
			$this->db->join('tbl_admin_group g','a.admin_group_id = g.admin_group_id','left');
			$this->db->where('a.admin_id',$row['created_by']);
			$created = $this->db->get('tbl_admin a')->row_array();
		?>
		<table width="98%" border="1" cellpadding="3">	
			<tr>
				<td align="left" width="25%">Lokasi <br /><br /> The Citadel, Jl. Dewi Sartika No.3 Lt. 3, Cililitan, Kec. Kramat Jati, Kota Jakarta Timur</td>
				<td align="center" width="25%">Diketahui: <br /><br /><br /><br /><br />
				<b><u>Deddy Sarwobiso</u><br />
				Direktur Utama</b></td>
				<td align="center" width="25%">Diperiksa: <br /><br /><br /><br /><br />
				<b><u>Erika Sinaga</u><br />
				Direktur Keu & SDM</b></td>
				<td align="center" width="25%">Dibuat: <br /><br /><br /><br /><br />
				<b><u><?= $created['admin_name']?></u><br />
				<?= $created['admin_group_name']?></b></td>
			</tr>
		</table>
	</body>
</html>