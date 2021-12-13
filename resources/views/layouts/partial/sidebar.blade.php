<div class="sidebar">
	<!-- Sidebar Menu -->
	<nav class="mt-2">
		<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
			@can('dashboard')
			<li class="nav-item">
				<a href="{{ url('/home') }}" class="nav-link">
					<i class="nav-icon fa fa-tachometer-alt"></i>
					<p>
						Dashboard
					</p>
				</a>
			</li>
			@endcan
			@can('data-master')
			<li class="nav-item has-treeview">
				<a href="#" class="nav-link">
					<i class="nav-icon fas fa-database"></i>
					<p>
						Data Master
						<i class="right fas fa-angle-left"></i>
					</p>
				</a>
				<ul class="nav nav-treeview" style="display: none;">
					<li class="nav-item">
						<a href="{{ action('KantorCabangController@index') }}" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Kantor Cabang</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="{{ action('ProgramKerjaController@index') }}" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Program Kerja</p>
						</a>
					</li>
				</ul>
			</li>
			@endcan
			@role('user')
			<li class="nav-item has-treeview">
				<a href="#" class="nav-link">
					<i class="nav-icon fas fa-database"></i>
					<p>
						Data Master
						<i class="right fas fa-angle-left"></i>
					</p>
				</a>
				<ul class="nav nav-treeview" style="display: none;">
					<li class="nav-item">
						<a href="{{ action('KemacetanController@index') }}" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Kemacetan</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="{{ action('CalonMacetController@index') }}" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Calon Macet</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="{{ action('AnggotaLaluController@index') }}" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Anggota Lalu</p>
						</a>
					</li>	
					<li class="nav-item">
						<a href="{{ action('TargetLaluController@index') }}" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Target Lalu</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="{{ action('ResortController@index') }}" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Resort</p>
						</a>
					</li>
				</ul>
			</li>
			@endrole
			@can('perkembangan')
			<li class="nav-item has-treeview">
				<a href="#" class="nav-link">
					<i class="nav-icon fa fa-chart-line"></i>
					<p>
						Perkembangan
						<i class="right fas fa-angle-left"></i>
					</p>
				</a>
				<ul class="nav nav-treeview" style="display: none;">
					<li class="nav-item">
						<a href="{{ action('PerkembanganController@global') }}" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Global</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="{{ action('PerkembanganController@cabang') }}" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Kantor Cabang</p>
						</a>
					</li>
				</ul>
			</li>
			{{-- <li class="nav-item">
				<a href="{{ url('/perkembangan') }}" class="nav-link">
					<i class="nav-icon fa fa-chart-line"></i>
					<p>
						Perkembangan
					</p>
				</a>
			</li>
			<li class="nav-item">
				<a href="{{ action('ProgramKerjaController@index') }}" class="nav-link">
					<i class="nav-icon fas fa-list-ul"></i>
					<p>
						Program Kerja
					</p>
				</a>
			</li>		
			<li class="nav-item">
				<a href="{{ action('KantorCabangController@index') }}" class="nav-link">
					<i class="nav-icon fas fa-database"></i>
					<p>
						Master
					</p>
				</a>
			</li> --}}
			@endcan
			@can('input-data')
			<li class="nav-item has-treeview">
				<a href="#" class="nav-link">
					<i class="nav-icon fa fa-list"></i>
					<p>
						Input Data
						<i class="right fas fa-angle-left"></i>
					</p>
				</a>
				<ul class="nav nav-treeview" style="display: none;">
					<li class="nav-item">
						<a href="{{ action('PerkembanganController@create') }}" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>
								Perkembangan
							</p>
						</a>
					</li>	
					<li class="nav-item">
						<a href="{{ action('AngsuranKemacetanController@index') }}" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Angsuran Kemacetan</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="{{ action('AngsuranCalonMacetController@index') }}" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Angsuran Calon Macet</p>
						</a>
					</li>
				</ul>
			</li>
			@endcan
			@role('user')
			<li class="nav-item">
				<a href="{{ action('TargetController@index') }}" class="nav-link">
					<i class="nav-icon fa fa-bullseye"></i>
					<p>
						Target
					</p>
				</a>
			</li>
			@endrole
			@role('admin')
			<li class="nav-item">
				<a href="{{ action('TargetController@index2') }}" class="nav-link">
					<i class="nav-icon fa fa-bullseye"></i>
					<p>
						Target
					</p>
				</a>
			</li>
			@endrole
			@can('management-user')
			<li class="nav-item">
				<a href="{{ action('UserController@index') }}" class="nav-link">
					<i class="nav-icon fas fa-users"></i>
					<p>
						User
					</p>
				</a>
			</li>
			@endcan
		</ul>

	</nav>
	<!-- /.sidebar-menu -->
</div>