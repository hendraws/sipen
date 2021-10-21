	@extends('layouts.app_master')
	@section('title', 'Target Resort '.$data->first()->getResort->nama)
	@section('content-title', 'Target Resort '. $data->first()->getResort->nama)
	@section('css')
	<link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css')}}">
	<link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
	<link rel="stylesheet" href="{{ asset('plugins/jquery.datetimepicker/jquery.datetimepicker.css')}}">
	<link href="{{ asset('vendors/DataTables/datatables.min.css') }}" rel="stylesheet">
	<link href="{{ asset('vendors/bootstrap/datepicker.css') }}" rel="stylesheet">
	@endsection
	@section('js')
	<script src="{{ asset('vendors/DataTables/datatables.min.js') }}"></script>
	<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
	<script src="{{ asset('plugins/select2/js/select2.full.min.js')}}"></script>
	<script src="{{ asset('plugins/jquery.datetimepicker/jquery.datetimepicker.full.js')}}"></script>
	<script src="{{ asset('vendors/bootstrap/datepicker.js') }}"></script>

	@endsection

	@section('content')
	<div class="card card-lightblue card-body">
		<table id="data-table" class="table table-sm table-bordered">
			<thead class="text-center">
				<tr class="text-center  align-middle">
					{{-- <th scope="col" rowspan="2" class="align-middle">HK</th> --}}
					<th scope="col" rowspan="2" class="align-middle">Tanggal</th>
					<th scope="col" rowspan="2" class="align-middle">Pasaran</th>
					<th scope="col" colspan="5">Anggota</th>
					<th scope="col" colspan="4">Target Harian</th>
					<th scope="col" rowspan="2" class="align-middle"></th>
				</tr>
				<tr class="text-center">
					<th scope="col">Lalu</th>
					<th scope="col">Lama</th>
					<th scope="col">Baru</th>
					<th scope="col">Out</th>
					<th scope="col">Kini</th>
					<th scope="col">Lalu</th>
					<th scope="col">20% Drop</th>
					<th scope="col">20% Plsn</th>
					<th scope="col">Kini</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				$kini_1 = $lalu_1 = $kini_2 = $lalu_2 = $kini_3 = $lalu_3 = 0;  
				$target_kini_1 = $target_lalu_1 = $target_kini_2 = $target_lalu_2 = $target_kini_3 = $target_lalu_3 = 0;  
				?>
				@forelse ($data as $key => $val)
				@php
				if($val->pasaran == 1){
					$background = 'bg-lightblue';
					$lalu_1 = $val->anggota_lalu + $kini_1;
					$kini_1 = $val->anggota_lama + $val->anggota_baru + $lalu_1 - $val->anggota_out;
					$target_lalu_1 = $val->target_lalu + $target_kini_1;
					$target_kini_1 = $val->target_20_drop + $target_lalu_1 - $val->target_20_plnsn;
				}
				if($val->pasaran == 2){
					$background = 'bg-secondary';
					$lalu_2 = $val->anggota_lalu + $kini_2;
					$kini_2 = $val->anggota_lama + $val->anggota_baru + $lalu_2 - $val->anggota_out;
					$target_lalu_2 = $val->target_lalu + $target_kini_2;
					$target_kini_2 = $val->target_20_drop + $target_lalu_1 - $val->target_20_plnsn;
				}
				if($val->pasaran == 3){
					$background = 'bg-navy';
					$lalu_3 = $val->anggota_lalu + $kini_3;
					$kini_3 = $val->anggota_lama + $val->anggota_baru + $lalu_3 - $val->anggota_out;	
					$target_lalu_3 = $val->target_lalu + $target_kini_3;
					$target_kini_3 = $val->target_20_drop + $target_lalu_1 - $val->target_20_plnsn;
				}
				@endphp
				<tr >
					<td>{{ $val->tanggal }}</td>
					<td class="{{ $background }}">{{ $val->getPasaran->hari }}</td>
					<td class="text-right">
						@php
						if($val->pasaran == 1){
							echo number_format($lalu_1);
						}
						if($val->pasaran == 2){
							echo number_format($lalu_2);
						}
						if($val->pasaran == 3){
							echo number_format($lalu_3);
						}
						@endphp
					</td>
					<td class="text-right">{{ $val->anggota_lama }}</td>
					<td class="text-right">{{ $val->anggota_baru }}</td>
					<td class="text-right">{{ $val->anggota_out }}</td>
					<td class="text-right">
						@php
						if($val->pasaran == 1){
							echo number_format($kini_1);
						}
						if($val->pasaran == 2){
							echo number_format($kini_2);
						}
						if($val->pasaran == 3){
							echo number_format($kini_3);
						}
						@endphp
					</td>
					<td class="text-right">
						@php
						if($val->pasaran == 1){
							echo number_format($target_lalu_1);
						}
						if($val->pasaran == 2){
							echo number_format($target_lalu_2);
						}
						if($val->pasaran == 3){
							echo number_format($target_lalu_3);
						}
						@endphp
					</td>
					<td class="text-right">{{ number_format($val->target_20_drop) }}</td>
					<td class="text-right">{{ number_format($val->target_20_plnsn) }}</td>
					<td class="text-right">
						@php
						if($val->pasaran == 1){
							echo number_format($target_kini_1);
						}
						if($val->pasaran == 2){
							echo number_format($target_kini_2);
						}
						if($val->pasaran == 3){
							echo number_format($target_kini_3);
						}
						@endphp
					</td>
					<td class="text-center">
						<a class="btn btn-warning btn-sm" href="{{ action('TargetController@edit', $val->id) }}">Edit</a>
						<a class="btn btn-sm btn-danger modal-button ml-2" href="Javascript:void(0)"  data-target="ModalForm" data-url="{{ action('TargetController@delete', $val) }}"  data-toggle="tooltip" data-placement="top" title="Edit" >Hapus</a>
					</td>
				</tr>
				@empty
				<tr>
					<td colspan="12" class="text-center bg-secondary"><h5>Tidak Ada Data</h5></td>
				</tr>
				@endforelse
			</tbody>
		</table>
	</div>
	@endsection
