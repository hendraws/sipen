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
				<h6 class="float-right">Pasaran : Senin - Kamis</h6>
			</div>
		</div>
		<div class="table-responsive">
			<table id="data-table" class="table table-sm table-bordered">
				<thead class="text-center">
					<tr class="text-center  align-middle">
						{{-- <th scope="col" rowspan="2" class="align-middle">HK</th> --}}
						<th scope="col" rowspan="2" class="align-middle">Resort</th>
						<th scope="col" colspan="4">PERKEMBANGAN DROP</th>
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
						$dropLalu = $dropKini = $dropBerjalan = $dropTotal = 0;	
						@endphp

						@foreach($val as $v)
						@php
						$dropLalu = $dropBerjalan;
						$dropKini = $v['drop_kini'];
						$dropBerjalan = $dropLalu + $v['drop_kini'];
						$dropTotal = $v['total_drops'];	
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
						$dropBerjalanPerbandingan = $perbandingan->sum('drop_kini') ?? 0;
						$evaluasiBerjalan = $dropBerjalan -  $dropBerjalanPerbandingan;

						$perbandinganTotal =  App\Target::where('resort_id',$resort)
						->whereMonth('tanggal', $bulan)
						->take($val->count())->get();
						$dropBerjalanTotalGlobal = $perbandinganTotal->sum('drop_kini') ?? 0;
						$evaluasiBerjalanTotalGlobal = $dropTotal - $dropBerjalanTotalGlobal; 
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
						$lalu = $val->sum('drop_kini') - $dropKini;
						@endphp
						<td class="text-right">{{ number_format($lalu)  }}</td>
						<td class="text-right">{{ number_format($dropKini) }}</td>
						<td class="text-right">{{ number_format($val->sum('drop_kini')) }}</td>
						<td class="text-right">{{ number_format($dropTotal) }}</td>
						<td class="text-right">{{ number_format($dropBerjalanPerbandingan) }}</td>
						<td class="{{ $color }} text-right">{{ number_format($evaluasiBerjalan) }}</td>
						<td class="text-right">{{ number_format($dropBerjalanTotalGlobal) }}</td>
						<td class="{{ $color2 }} text-right">{{ number_format($evaluasiBerjalanTotalGlobal) }}</td>
						@php
						$jumlahLalu[] = $lalu;
						$jumlahKini[] = $dropKini;
						$jumlahBerjalan[] =  $val->sum('drop_kini');
						$jumlahTotal[] = $dropTotal;
						$jumlahPerbandinganBerjalan[] = $dropBerjalanPerbandingan;
						$jumlahPerbandinganEvaluasi[] = $evaluasiBerjalan;
						$jumlahPerbandinganTotal[] = $dropBerjalanTotalGlobal;
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

<div class="card card-primary card-outline">
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
						<th scope="col" colspan="4">PERKEMBANGAN DROP</th>
						<th scope="col" colspan="3">PERBANDINGAN PROGRAM KERJA</th>
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
					$dropLalu = $dropKini = $dropBerjalan = $dropTotal = 0;	
					@endphp
					<tr>
						<td>{{ $key }}</td>
						@foreach($val as $v)
						@php
						$dropLalu = $dropBerjalan;
						$dropKini = $v['drop_kini'];
						$dropBerjalan = $dropLalu + $v['drop_kini'];
						$dropTotal = $v['total_drops'];	
						$resort = $v['resort_id']; 
						$pasaran = $v['pasaran']; 
						$tanggal = $v['tanggal'];
						@endphp
						@endforeach
						@php
						$targetProgram =  !empty($programKerja) ? $programKerja->drops / 6 : 0;
						$evaluasi = $dropTotal - $targetProgram;
						$ip = !empty($programKerja) ? ($dropTotal / $targetProgram) * 100 : 0; 
						if($evaluasi >= 0){
							$color = 'bg-success'; 
						}else{
							$color = 'bg-danger'; 
						}
						$totalTargetProgram[] = $targetProgram;
						$totalEvaluasiProgram[] = $evaluasi;
						$totalIp[] = $ip;
						@endphp
						<td class="text-right">{{ number_format($val->sum('drop_kini') - $dropKini)  }}</td>
						<td class="text-right">{{ number_format($dropKini) }}</td>
						<td class="text-right">{{ number_format($val->sum('drop_kini')) }}</td>
						<td class="text-right">{{ number_format($dropTotal) }}</td>
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