<html>
<head>
	<title>IMPORT EXCEL CI 3</title>
</head>
<body>
	<h1>Data Promo</h1><hr>
	<a href="<?php echo base_url("promex/form"); ?>">Import Data</a><br><br>

	<table border="1" cellpadding="8">
	<tr>
		<th>Nama Akun</th>
		<th>Nama Promo</th>
		<th>tgl_durasi_start</th>
		<th>tgl_durasi_end</th>
		<th>tgl_sell_out_total</th>
		<th>sku_total</th>
		<th>quantity_total</th>
		<th>price_total</th>
		<th>tgl_sell_out_onpromo</th>
		<th>sku</th>
		<th>quantity</th>
		<th>price</th>
		<th>biaya_fixed</th>
		<th>biaya_variable</th>
		<th>gp</th>
		<th>target_budget_tahunan</th>
		<th>budget_terpakai</th>
		<th>total_budget_terpakai</th>
		<th>margin</th>
	</tr>

	<?php
	if( ! empty($promex)){ // Jika data pada database tidak sama dengan empty (alias ada datanya)
		foreach($promex as $data){ // Lakukan looping pada variabel siswa dari controller
			echo "<tr>";
			echo "<td>".$data->nama_akun."</td>";
			echo "<td>".$data->nama_promo."</td>";
			echo "<td>".$data->tgl_durasi_start."</td>";
			echo "<td>".$data->tgl_durasi_end."</td>";
			echo "<td>".$data->tgl_sell_out_total."</td>";
			echo "<td>".$data->sku_total."</td>";
			echo "<td>".$data->quantity_total."</td>";
			echo "<td>".$data->price_total."</td>";
			echo "<td>".$data->tgl_sell_out_onpromo."</td>";
			echo "<td>".$data->sku."</td>";
			echo "<td>".$data->quantity."</td>";
			echo "<td>".$data->price."</td>";
			echo "<td>".$data->biaya_fixed."</td>";
			echo "<td>".$data->biaya_variable."</td>";
			echo "<td>".$data->gp."</td>";
			echo "<td>".$data->target_budget_tahunan."</td>";
			echo "<td>".$data->budget_terpakai."</td>";
			echo "<td>".$data->total_budget_terpakai."</td>";
			echo "<td>".$data->margin."</td>";
			echo "</tr>";
		}
	}else{ // Jika data tidak ada
		echo "<tr><td colspan='4'>Data tidak ada</td></tr>";
	}
	?>
	</table>
</body>
</html>
