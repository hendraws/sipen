<div class="sidebar">
	<!-- Sidebar Menu -->
	<nav class="mt-2">
		<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
			<li class="nav-item">
				<a href="#" class="nav-link">
					<i class="nav-icon fa fa-tachometer-alt"></i>
					<p>
						Dashboard
					</p>
				</a>
			</li>		
			<li class="nav-item">
				<a href="#" class="nav-link">
					<i class="nav-icon fa fa-chart-line"></i>
					<p>
						Perkembangan
					</p>
				</a>
			</li>
			<li class="nav-item">
				<a href="#" class="nav-link">
					<i class="nav-icon fas fa-list-ul"></i>
					<p>
						Program Kerja
					</p>
				</a>
			</li>
			<li class="nav-item has-treeview">
				<a href="#" class="nav-link">
					<i class="nav-icon fas fa-database"></i>
					<p>
						Master
						<i class="right fas fa-angle-left"></i>
					</p>
				</a>
				<ul class="nav nav-treeview" style="display: none;">
					<li class="nav-item">
						<a href="pages/charts/chartjs.html" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Report</p>
						</a>
					</li>
					<li class="nav-item">
						<a href="{{ action('KantorCabangController@index') }}" class="nav-link">
							<i class="far fa-circle nav-icon"></i>
							<p>Kantor Cabang</p>
						</a>
					</li>
				</ul>
			</li>
			<li class="nav-item">
				<a href="#" class="nav-link">
					<i class="nav-icon fas fa-users"></i>
					<p>
						Data Pengguna
					</p>
				</a>
			</li>
		</ul>

	</nav>
	<!-- /.sidebar-menu -->
</div>