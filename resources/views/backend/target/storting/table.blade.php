<div class="card card-success card-outline">
	<div class="card-body">
		<div class="row">
			<div class="col-md-6">
				<div class="text-bold">
					Pasaran : {{ $psrn_name }}
				</div>
				{{-- <h6>Tanggal : {{date_format(date_create_from_format('Y-m-d', $getTanggal), 'd F Y')}}</h6> --}}
			</div>
			<div class="col-md-6">
				{{-- <h6 class="float-right">Pasaran : Senin - Kamis</h6> --}}
			</div>
		</div>
		<div class="table-responsive">
			<table id="data-table" class="table table-sm table-bordered">
				<thead class="text-center">
					<tr class="text-center  align-middle">
						{{-- <th scope="col" rowspan="2" class="align-middle">HK</th> --}}
						<th scope="col" rowspan="2" class="align-middle">Resort</th>
						<th scope="col" colspan="4">PERKEMBANGAN STORTING</th>
						<th scope="col" colspan="4">PERBANDINGAN BULAN LALU</th>
					</tr>
					<tr class="text-center">
						<th scope="col">LALU</th>
						<th scope="col">KINI</th>
						<th scope="col">BERJALAN</th>
						<th scope="col">TOTAL</th>
						<th scope="col">BERJALAN</th>
						<th scope="col">EVALUASI</th>
						<th scope="col">TOTAL</th>
						<th scope="col">EVALUASI</th>

					</tr>
				</thead>
				<tbody>

					@forelse ($data as $key => $val)
					<tr>
						<td>{{ $key }}</td>
						@php
						$stortingLalu = $stortingKini = $stortingBerjalan = $stortingTotal = 0;	
						@endphp

						@foreach($val as $v)
						@php
						$stortingLalu = $stortingBerjalan;
						$stortingKini = $v['storting_kini'];
						$stortingBerjalan = $stortingLalu + $v['storting_kini'];
						$stortingTotal = $v['total_storting'];	
						$resort = $v['resort_id']; 
						$pasaran = $v['pasaran']; 
						$tanggal = $v['tanggal'];
						@endphp
						@endforeach
						@php
						$bulan = \Carbon\Carbon::parse($tanggal)->subMonth()->month;
						$perbandingan = App\Target::where('resort_id',$resort)
						->where('pasaran', $pasaran)
						->whereMonth('tanggal', $bulan)
						->take($val->count())->get();
						$stortingBerjalanPerbandingan = $perbandingan->sum('storting_kini') ?? 0;
						$evaluasiBerjalan = $stortingBerjalan -  $stortingBerjalanPerbandingan;

						$perbandinganTotal =  App\Target::where('resort_id',$resort)
						->whereMonth('tanggal', $bulan)
						->take($val->count())->get();
						$stortingBerjalanTotalGlobal = $perbandinganTotal->sum('storting_kini') ?? 0;
						$evaluasiBerjalanTotalGlobal = $stortingTotal - $stortingBerjalanTotalGlobal; 
						if($evaluasiBerjalan >= 0){
							$color = 'bg-success'; 
						}else{
							$color = 'bg-danger'; 
						}
						if($evaluasiBerjalanTotalGlobal >= 0){
							$color2 = 'bg-success';
						}else{
							$color2 = 'bg-danger'; 
						}
						$lalu = $val->sum('storting_kini') - $stortingKini;
						@endphp
						<td class="text-right">{{ number_format($lalu)  }}</td>
						<td class="text-right">{{ number_format($stortingKini) }}</td>
						<td class="text-right">{{ number_format($val->sum('storting_kini')) }}</td>
						<td class="text-right">{{ number_format($stortingTotal) }}</td>
						<td class="text-right">{{ number_format($stortingBerjalanPerbandingan) }}</td>
						<td class="{{ $color }} text-right">{{ number_format($evaluasiBerjalan) }}</td>
						<td class="text-right">{{ number_format($stortingBerjalanTotalGlobal) }}</td>
						<td class="{{ $color2 }} text-right">{{ number_format($evaluasiBerjalanTotalGlobal) }}</td>
						@php
						$jumlahLalu[] = $lalu;
						$jumlahKini[] = $stortingKini;
						$jumlahBerjalan[] =  $val->sum('storting_kini');
						$jumlahTotal[] = $stortingTotal;
						$jumlahPerbandinganBerjalan[] = $stortingBerjalanPerbandingan;
						$jumlahPerbandinganEvaluasi[] = $evaluasiBerjalan;
						$jumlahPerbandinganTotal[] = $stortingBerjalanTotalGlobal;
						$jumlahPerbandinganEvaluasiTotal[] = $evaluasiBerjalanTotalGlobal;
						@endphp
					</tr>
					@empty
					<tr>
						<td colspan="12" class="text-center bg-secondary"><h5>Tidak Ada Data</h5></td>
					</tr>
					@endforelse
					@if(count($data) > 0)
					<tr class="text-bold">
						<td>Jumlah</td>
						<td class="text-right">{{ number_format(array_sum($jumlahLalu)) }}</td>
						<td class="text-right">{{ number_format(array_sum($jumlahKini)) }}</td>
						<td class="text-right">{{ number_format(array_sum($jumlahBerjalan)) }}</td>
						<td class="text-right">{{ number_format(array_sum($jumlahTotal)) }}</td>
						<td class="text-right">{{ number_format(array_sum($jumlahPerbandinganBerjalan)) }}</td>
						<td class="text-right">{{ number_format(array_sum($jumlahPerbandinganEvaluasi)) }}</td>
						<td class="text-right">{{ number_format(array_sum($jumlahPerbandinganTotal)) }}</td>
						<td class="text-right">{{ number_format(array_sum($jumlahPerbandinganEvaluasiTotal)) }}</td>
					</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div><!-- /.card-body -->
</div>

<div class="card card-success card-outline">
	<div class="card-body">
		<div class="row">
			<div class="col-md-6">
				{{-- <h6>Tanggal : {{date_format(date_create_from_format('Y-m-d', $getTanggal), 'd F Y')}}</h6> --}}
			</div>
			<div class="col-md-6">
				{{-- <h6 class="float-right">Pasaran : Senin - Kamis</h6> --}}
			</div>
		</div>
		<div class="table-responsive">
			<table id="data-table" class="table table-sm table-bordered">
				<thead class="text-center">
					<tr class="text-center  align-middle">
						{{-- <th scope="col" rowspan="2" class="align-middle">HK</th> --}}
						<th scope="col" rowspan="2" class="align-middle">Resort</th>
						<th scope="col" colspan="4">PERKEMBANGAN STORTING</th>
						<th scope="col" colspan="4">PENCAPAIAN PROGRAM KERJA</th>
					</tr>
					<tr class="text-center">
						<th scope="col">LALU</th>
						<th scope="col">KINI</th>
						<th scope="col">BERJALAN</th>
						<th scope="col">TOTAL</th>
						<th scope="col">TARGET</th>
						<th scope="col">EVALUASI</th>
						<th scope="col">IP</th>
					</tr>
				</thead>
				<tbody>
					@forelse ($data as $key => $val)
					@php
					$stortingLalu = $stortingKini = $stortingBerjalan = $stortingTotal = 0;	
					@endphp
					<tr>
						<td>{{ $key }}</td>
						@foreach($val as $v)
						@php
						$stortingLalu = $stortingBerjalan;
						$stortingKini = $v['storting_kini'];
						$stortingBerjalan = $stortingLalu + $v['storting_kini'];
						$stortingTotal = $v['total_storting'];	
						$resort = $v['resort_id']; 
						$pasaran = $v['pasaran']; 
						$tanggal = $v['tanggal'];
						@endphp
						@endforeach
						@php
						$targetProgram =  !empty($programKerja) ?  $programKerja->storting / 6 : 0;
						$evaluasi = $stortingTotal - $targetProgram;
						$ip = !empty($programKerja) ? ($stortingTotal / $targetProgram) * 100 : 0; 
						if($evaluasi >= 0){
							$color = 'bg-success'; 
						}else{
							$color = 'bg-danger'; 
						}
						$jumlahLalu[] = $val->sum('storting_kini') - $stortingKini;
						$jumlahKini[] = $stortingKini;
						$jumlahBerjalan[] = $val->sum('storting_kini');
						$jumlahTotal[] = $stortingTotal;
						$totalTargetProgram[] = $targetProgram;
						$totalEvaluasiProgram[] = $evaluasi;
						$totalIp[] = $ip;
						@endphp
						<td class="text-right">{{ number_format($val->sum('storting_kini') - $stortingKini)  }}</td>
						<td class="text-right">{{ number_format($stortingKini) }}</td>
						<td class="text-right">{{ number_format($val->sum('storting_kini')) }}</td>
						<td class="text-right">{{ number_format($stortingTotal) }}</td>
						<td class="text-right">{{ number_format($targetProgram) }}</td>
						<td class="{{ $color }} text-right">{{ number_format($evaluasi) }}</td>
						<td class="text-right">{{ round($ip,3) }} %</td>
					</tr>
					@empty
					<tr>
						<td colspan="12" class="text-center bg-secondary"><h5>Tidak Ada Data</h5></td>
					</tr>
					@endforelse
					@if(count($data) > 0)
					<tr class="text-bold">
						<td>Jumlah</td>
						<td class="text-right">{{ number_format(array_sum($jumlahLalu)) }}</td>
						<td class="text-right">{{ number_format(array_sum($jumlahKini)) }}</td>
						<td class="text-right">{{ number_format(array_sum($jumlahBerjalan)) }}</td>
						<td class="text-right">{{ number_format(array_sum($jumlahTotal)) }}</td>
						<td class="text-right">{{ number_format(array_sum($totalTargetProgram)) }}</td>
						<td class="text-right">{{ number_format(array_sum($totalEvaluasiProgram)) }}</td>
						<td class="text-right">{{ round(array_sum($totalIp), 3) }} %</td>
					</tr>
					@endif
				</tbody>
			</table>
		</div>
	</div><!-- /.card-body -->
</div>