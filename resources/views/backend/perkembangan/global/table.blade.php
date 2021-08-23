<table class="table table-sm">
	<thead class="thead-dark">
		<tr>
			<th scope="col">UNIT</th>
			<th scope="col">DROP</th>
			<th scope="col">STORTING</th>
			<th scope="col">PSP</th>
			<th scope="col">TKP</th>
			<th scope="col">IP TKP</th>
			<th scope="col">IP %</th>
			<th scope="col">DROP TUNDA</th>
			<th scope="col">STORTING TUNDA</th>
			<th scope="col">IP %</th>
		</tr>
	</thead>
	<tbody>
		@php 
			$drop = $storting = $psp = $tkp = $dropTunda = $stortingTunda = 0;
		@endphp
		@foreach($globalTable as $k => $val)
		<tr>
			<td>{{ $k }}</td>
			<td>{{ number_format($val['sum_drop']) }}</td>
			<td>{{ number_format($val['sum_storting']) }}</td>
			<td>{{ number_format($val['sum_psp']) }}</td>
			<td>{{ number_format($val['sum_tkp']) }}</td>
			<td>{{ round(($val['sum_tkp'] / $val['sum_drop']) * 100, 2) }}</td>
			<td>{{ round(($val['sum_storting'] / $val['sum_drop']) * 100, 2) }}</td>
			<td>{{ number_format($val['sum_drop_tunda']) }}</td>
			<td>{{ number_format($val['sum_storting_tunda']) }}</td>
			<td>{{ round(($val['sum_storting_tunda'] / $val['sum_drop_tunda'] ) * 100, 2) }}</td>
		</tr>
		@php 
			$drop += $val['sum_drop'];
			$storting += $val['sum_storting'];
			$psp += $val['sum_psp'];
			$tkp += $val['sum_tkp'];
			$dropTunda += $val['sum_drop_tunda'];
			$stortingTunda += $val['sum_storting_tunda'];
		@endphp
		@endforeach
	</tbody>
	<tr class="bg-success">
		<th scope="col">TOTAL</th>
		<th scope="col">{{ $drop }}</th>
		<th scope="col">{{ $storting }}</th>
		<th scope="col">{{ $psp }}</th>
		<th scope="col">{{ $tkp }}</th>
		<th scope="col">{{ round(($tkp / $drop) * 100, 2) }}</th>
		<th scope="col">{{ round(($storting / $drop) * 100, 2) }}</th>
		<th scope="col">{{ $dropTunda }}</th>
		<th scope="col">{{ $stortingTunda }}</th>
		<th scope="col">{{ round(($stortingTunda / $dropTunda ) * 100, 2) }}</th>
	</tr>
</table>