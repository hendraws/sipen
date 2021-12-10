@extends('layouts.app_master')
@section('title', 'Target Resort '.$data->first()->getResort->nama)
@section('content-title', 'Target Resort '. $data->first()->getResort->nama)
@section('button-title')
<a href="{{ action('TargetController@index') }}" class="btn btn-info float-right">Kembali</a>
@endsection
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
				$target = [];
			?>
			@forelse ($data as $key => $val)
			@php
			if(!array_key_exists($val->pasaran, $target)){
				$target[$val->pasaran]['anggota_lalu'] = $anggotaLalu[$val->pasaran];
				$target[$val->pasaran]['anggota_kini'] = $target[$val->pasaran]['anggota_lalu'] + $val->anggota_lama + $val->anggota_baru - $val->anggota_out;
				$target[$val->pasaran]['target_lalu'] = $targetLalu[$val->pasaran];
				$target[$val->pasaran]['target_kini'] = $target[$val->pasaran]['target_lalu'] + $val->target_20_drop - $val->target_20_plnsn;
				$target[$val->pasaran]['background'] = 'bg-lightblue';
			}else{
				$target[$val->pasaran]['anggota_lalu'] = $anggotaLalu[$val->pasaran];
				$target[$val->pasaran]['anggota_kini'] = $anggotaLalu[$val->pasaran] + $val->anggota_lama + $val->anggota_baru - $val->anggota_out;
				$target[$val->pasaran]['target_lalu'] = $targetLalu[$val->pasaran];
				$target[$val->pasaran]['target_kini'] = $targetLalu[$val->pasaran] + $val->target_20_drop - $val->target_20_plnsn;
				$target[$val->pasaran]['background'] = 'bg-lightblue';
			}
			@endphp
			<tr >
				<td>{{ $val->tanggal }}</td>
				<td class="">{{ $val->getPasaran->hari }}</td>
				<td class="text-right">
					 {{ number_format($target[$val->pasaran]['anggota_lalu']) }}
					
				</td>
				<td class="text-right">{{ $val->anggota_lama }}</td>
				<td class="text-right">{{ $val->anggota_baru }}</td>
				<td class="text-right">{{ $val->anggota_out }}</td>
				<td class="text-right">
					 {{ number_format($target[$val->pasaran]['anggota_kini']) }}
				</td>
				<td class="text-right">
					 {{ number_format($target[$val->pasaran]['target_lalu']) }}
				</td>
				<td class="text-right">{{ number_format($val->target_20_drop) }}</td>
				<td class="text-right">{{ number_format($val->target_20_plnsn) }}</td>
				<td class="text-right">
					 {{ number_format($target[$val->pasaran]['target_kini']) }}
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
