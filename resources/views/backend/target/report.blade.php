<!DOCTYPE html>
<html>
<head>
	<title>report</title>
	<style>
		.page-break {
			page-break-after: always;
		}
		.row {
			margin-right: -15px;
			margin-left: -15px;
		}
		.col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
			position: relative;
			min-height: 1px;
			padding-right: 15px;
			padding-left: 15px;
		}

		.col-lg-12 {
			width: 100%;
		}

		.text-center {
			text-align: center;
		}
		.text-right {
			text-align: right;
			vertical-align: center;
		}

		body {
			font-family: Helvetica, Arial, sans-serif;
			font-size: 12px;
			line-height: 1.42857143;
			color: #333;
			background-color: #fff;
		}
		table{
			margin-bottom: 20px;
		}
		table, th, tr, td{
			font-size: 11px;
			font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
			border-collapse: collapse;
			border-spacing: 0;
			width: 100%;
			border: 1px solid #dee2e6;
		}
		tr {
			display: table-row;
			vertical-align: inherit;
			border-color: inherit;
		}
		th{
			font-weight: bold;
		}
		(...) the list goes on a little longer for some other bootstrap styles and other site-specific ones made by yours truly.
	</style>
</head>
<body>

	<div class="row">
		<h4 class="text-center">SIRKULASI PERKEMBANGAN KSP SATRIA MULIA ARTHOMORO
			<br>CABANG JAKARTA<br>PRIODE : {{ $tanggal_awal }} s/d {{ $tanggal_akhir }}
		</h4> 
	</div>
	<?php 
	$list = [];
	$anggota_kini = [];
	$target_kini = []; 
	$target_kini = []; 
	$break = 1;
	$totalDrop = 0;
	$totalStorting = 0;
	?>
	@foreach($data as $tanggal => $items)
	@php
	$cekWeekend = date('w', strtotime($tanggal));
	if($cekWeekend == 1 || $cekWeekend == 4){
		$psrn = "Senin - Kamis";
	}

	if($cekWeekend == 2 || $cekWeekend == 5){
		$psrn = "Selasa - Jum'at";
	}

	if($cekWeekend == 3 || $cekWeekend == 6){
		$psrn = "Rabu - Sabtu"; 
	}	
	@endphp
	<table class="table table-sm table-bordered">
		<tr class="bg-secondary">
			<th scope="col" colspan="2">Hari Kerja : {{ $loop->index + 1 }}</th>
			<th scope="col" colspan="13">Tanggal : {{ date('d M Y', strtotime($tanggal)) }}</th>
			<th scope="col" colspan="4">Pasaran : {{ $psrn }} </th>
		</tr>
		<tr class="bg-secondary">
			<th scope="col" rowspan="2" style="width: 20px">No</th>
			<th scope="col" rowspan="2">Resort</th>
			<th scope="col" colspan="5">Anggota</th>
			<th scope="col" colspan="4">Target Harian</th>
			<th scope="col" colspan="4">Perkembangan Drop</th>
			<th scope="col" colspan="4">Perkembangan Storting</th>
			{{-- <th scope="col" rowspan="2">TKP</th> --}}
			{{-- <th scope="col" rowspan="2">IP%</th> --}}
		</tr>
		<tr class="bg-secondary">
			<th>Lalu</th>
			<th>Lama</th>
			<th>Baru</th>
			<th>Out</th>
			<th>Kini</th>
			<th>Lalu</th>
			<th>20% Drop</th>
			<th>20% Plnsn</th>
			<th>Total</th>
			<th>Lalu</th>
			<th>Kini</th>
			<th>Berjalan</th>
			<th>Total</th>
			<th>Lalu</th>
			<th>Kini</th>
			<th>Berjalan</th>
			<th>Total</th>
		</tr>
		<?php $no = 1; $total = []; $break++; ?>
		@foreach($items as $item)
		@foreach($item as $resort => $value)
		@php

		if(!array_key_exists($resort, $list) || !array_key_exists($value->pasaran, $list[$resort])){
			// anggota
			$list[$resort][$value->pasaran]['anggota_lalu'] = $anggota_lalu[$resort][$value->pasaran];
			$list[$resort][$value->pasaran]['anggota_lama'] = $value->anggota_lama;
			$list[$resort][$value->pasaran]['anggota_baru'] = $value->anggota_baru;
			$list[$resort][$value->pasaran]['anggota_out'] = $value->anggota_out;
			$list[$resort][$value->pasaran]['anggota_kini'] = $anggota_lalu[$resort][$value->pasaran] + $value->anggota_lama + $value->anggota_baru - $value->anggota_out ;
			// target

			$list[$resort][$value->pasaran]['target_lalu'] = $target_lalu[$resort][$value->pasaran];
			$list[$resort][$value->pasaran]['target_drop'] = $value->target_20_drop;
			$list[$resort][$value->pasaran]['target_plnsn'] = $value->target_20_plnsn;
			$list[$resort][$value->pasaran]['target_kini'] = $target_lalu[$resort][$value->pasaran] + $value->target_20_drop - $value->target_20_plnsn ;
		
			// perkembangan Drop
			$list[$resort][$value->pasaran]['drop_lalu'] = $value->drop_lalu;
			$list[$resort][$value->pasaran]['drop_kini'] = $value->drop_kini;
			$list[$resort][$value->pasaran]['drop_berjalan'] = $value->drop_lalu + $value->drop_kini;
			$list[$resort]['drop_total'][] = $value->drop_lalu + $value->drop_kini;
			// perkemabangan storting
			$list[$resort][$value->pasaran]['storting_lalu'] = $value->storting_lalu;
			$list[$resort][$value->pasaran]['storting_kini'] = $value->storting_kini;
			$list[$resort][$value->pasaran]['storting_berjalan'] = $value->storting_lalu + $value->storting_kini;
			$list[$resort]['storting_total'][] = $value->storting_lalu + $value->storting_kini;


		}else{
			// anggota
			$list[$resort][$value->pasaran]['anggota_lalu'] = $list[$resort][$value->pasaran]['anggota_kini'];

			// dd($list[$resort][$value->pasaran]['anggota_lalu']);
			$list[$resort][$value->pasaran]['anggota_lama'] = $value->anggota_lama;
			$list[$resort][$value->pasaran]['anggota_baru'] = $value->anggota_baru;
			$list[$resort][$value->pasaran]['anggota_out'] = $value->anggota_out;

			$list[$resort][$value->pasaran]['anggota_kini'] = $list[$resort][$value->pasaran]['anggota_lalu'] + $value->anggota_lama + $value->anggota_baru - $value->anggota_out ;

			// target
			$list[$resort][$value->pasaran]['target_lalu'] = $list[$resort][$value->pasaran]['target_kini'];
			$list[$resort][$value->pasaran]['target_drop'] = $value->target_20_drop;
			$list[$resort][$value->pasaran]['target_plnsn'] = $value->target_20_plnsn;
			$list[$resort][$value->pasaran]['target_kini'] = $list[$resort][$value->pasaran]['target_lalu'] + $value->target_20_drop - $value->target_20_plnsn ;
		
			// perkembangan Drop
			$list[$resort][$value->pasaran]['drop_lalu'] = $list[$resort][$value->pasaran]['drop_berjalan'];
			$list[$resort][$value->pasaran]['drop_kini'] = $value->drop_kini;
			$list[$resort][$value->pasaran]['drop_berjalan'] = $value->drop_lalu + $value->drop_kini;
			$list[$resort]['drop_total'][] = $value->drop_kini;
			// perkemabangan storting
			$list[$resort][$value->pasaran]['storting_lalu'] = $list[$resort][$value->pasaran]['storting_berjalan'];
			$list[$resort][$value->pasaran]['storting_kini'] = $value->storting_kini;
			$list[$resort][$value->pasaran]['storting_berjalan'] = $value->storting_lalu + $value->storting_kini;
			$list[$resort]['storting_total'][] =  $value->storting_kini;

		}

		// $list[$resort]['anggota_kini'] = $list[$resort]['anggota_lalu'] + $value->anggota_lama + $value->anggota_baru - $value->anggota_out;
		// $list[$resort]['target_kini'] = $list[$resort]['target_lalu'] + $value->target_20_drop - $value->target_20_plnsn;
		// $list[$resort]['drop_berjalan'] = $list[$resort]['drop_lalu'] + $value->drop_kini - $value->drop_berjalan;
		// $list[$resort]['storting_berjalan'] = $list[$resort]['storting_lalu'] + $value->storting_kini - $value->storting_berjalan;

		$total['anggota_lalu'][] = $list[$resort][$value->pasaran]['anggota_lalu'];
		$total['anggota_lama'][] = $value->anggota_lama;
		$total['anggota_baru'][] = $value->anggota_baru;
		$total['anggota_out'][] = $value->anggota_out;
		$total['anggota_kini'][] = $list[$resort][$value->pasaran]['anggota_kini'] ;
		$total['target_lalu'][] = $list[$resort][$value->pasaran]['target_lalu'] ;
		$total['20_drop'][] = $value->target_20_drop;
		$total['20_plnsn'][] = $value->target_20_plnsn;
		$total['target_kini'][] = $list[$resort][$value->pasaran]['target_kini'];
		$total['drop_lalu'][] = $list[$resort][$value->pasaran]['drop_lalu'];
		$total['drop_kini'][] = $value->drop_kini;
		$total['drop_berjalan'][] = $list[$resort][$value->pasaran]['drop_berjalan'];
		$total['storting_lalu'][] = $list[$resort][$value->pasaran]['storting_lalu'];
		$total['storting_kini'][] = $value->storting_kini;
		$total['storting_berjalan'][] = $list[$resort][$value->pasaran]['storting_berjalan'];
		$totalDrop += $value->drop_kini;
		$totalStorting += $value->storting_kini;
		@endphp
		<tr>
			<td>{{ $no++ }}</td>
			<td>{{ $resort }}</td>
			<td class="text-right">{{ number_format($list[$resort][$value->pasaran]['anggota_lalu'] )  }}</td>
			<td class="text-right">{{ number_format($list[$resort][$value->pasaran]['anggota_lama'] )  }}</td>
			<td class="text-right">{{ number_format($list[$resort][$value->pasaran]['anggota_baru'] )  }}</td>
			<td class="text-right">{{ number_format($list[$resort][$value->pasaran]['anggota_out'] )  }}</td>
			<td class="text-right">{{ number_format($list[$resort][$value->pasaran]['anggota_kini'] )  }}</td>
			<td class="text-right">{{ number_format($list[$resort][$value->pasaran]['target_lalu'] )  }}</td>
			<td class="text-right">{{ number_format($list[$resort][$value->pasaran]['target_drop'] )  }}</td>
			<td class="text-right">{{ number_format($list[$resort][$value->pasaran]['target_plnsn'] )  }}</td>
			<td class="text-right">{{ number_format($list[$resort][$value->pasaran]['target_kini'] )  }}</td>
			<td class="text-right">{{ number_format($list[$resort][$value->pasaran]['drop_lalu'] )  }}</td>
			<td class="text-right">{{ number_format($list[$resort][$value->pasaran]['drop_kini'] )  }}</td>
			<td class="text-right">{{ number_format($list[$resort][$value->pasaran]['drop_berjalan'] )  }}</td>
			<td class="text-right">{{ number_format(array_sum($list[$resort]['drop_total'])  ) }}</td>
			<td class="text-right">{{ number_format($list[$resort][$value->pasaran]['storting_lalu'] )  }}</td>
			<td class="text-right">{{ number_format($list[$resort][$value->pasaran]['storting_kini'] )  }}</td>
			<td class="text-right">{{ number_format($list[$resort][$value->pasaran]['storting_berjalan'] )  }}</td>
			<td class="text-right">{{ number_format(array_sum($list[$resort]['storting_total'])  ) }}</td>
		</tr>
		@endforeach
		@endforeach

		<tr>
			<th colspan="2"> Jumlah</th>
			<th class="text-right">{{ number_format(array_sum($total['anggota_lalu'])) }}</th>
			<th class="text-right">{{ number_format(array_sum($total['anggota_lama'])) }}</th>
			<th class="text-right">{{ number_format(array_sum($total['anggota_baru'])) }}</th>
			<th class="text-right">{{ number_format(array_sum($total['anggota_out'])) }}</th>
			<th class="text-right">{{ number_format(array_sum($total['anggota_kini'])) }}</th>
			<th class="text-right">{{ number_format(array_sum($total['target_lalu'])) }}</th>
			<th class="text-right">{{ number_format(array_sum($total['20_drop'])) }}</th>
			<th class="text-right">{{ number_format(array_sum($total['20_plnsn'])) }}</th>
			<th class="text-right">{{ number_format(array_sum($total['target_kini'])) }}</th>
			<th class="text-right">{{ number_format(array_sum($total['drop_lalu'])) }}</th>
			<th class="text-right">{{ number_format(array_sum($total['drop_kini'])) }}</th>
			<th class="text-right">{{ number_format(array_sum($total['drop_berjalan'])) }}</th>
			<th class="text-right">{{ number_format($totalDrop) }}</th>
			<th class="text-right">{{ number_format(array_sum($total['storting_lalu'])) }}</th>
			<th class="text-right">{{ number_format(array_sum($total['storting_kini'])) }}</th>
			<th class="text-right">{{ number_format(array_sum($total['storting_berjalan'])) }}</th>
			<th class="text-right">{{ number_format($totalStorting) }}</th>
		</tr>
	</table>
	@if($break % 3 == 0)
	<div class="page-break"></div>
	@endif
	@endforeach
</body>
</html>