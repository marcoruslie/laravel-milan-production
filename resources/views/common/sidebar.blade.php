<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

	<!-- Sidebar - Brand -->

	@if (Auth::user()->is_admin == 1)
		<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
			<div class="sidebar-brand-icon rotate-n-15">
				<i></i>
			</div>
			<div class="sidebar-brand-text mx-3">Milan Produksi<sup></sup></div>
		</a>
	@else
		<a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard') }}">
			<div class="sidebar-brand-icon rotate-n-15">
				<i></i>
			</div>
			<div class="sidebar-brand-text mx-3">Milan Produksi<sup></sup></div>
		</a>
	@endif
	<!-- Divider -->
	<hr class="sidebar-divider my-0">

	<!-- Nav Item - Dashboard -->
	<li class="nav-item active">
		@if (Auth::user()->is_admin == 1)
			<a class="nav-link" href="{{ route('home') }}">
			@else
				<a class="nav-link" href="{{ route('dashboard') }}">
		@endif
		<i class="fas fa-fw fa-tachometer-alt"></i>
		<span>Dashboard</span></a>
	</li>

	<!-- Divider -->
	@if (Auth::user()->is_admin == 1)
		<hr class="sidebar-divider">
		<!-- Heading -->
		<div class="sidebar-heading">
			Admin
		</div>

		<!-- User Menu -->
		<li class="nav-item">
			<a class="nav-link" href="{{ route('users.index') }}">
				<i class="fa fa-user"></i>
				<span>Users Management</span></a>
		</li>

		<!-- Shift Menu -->
		<li class="nav-item">
			<a class="nav-link" href="{{ route('shifts.index') }}">
				<i class="fa fa-clock"></i>
				<span>Shift Management</span></a>
		</li>

		<!-- Cars Menu -->
		<li class="nav-item">
			<a class="nav-link" href="{{ route('cars.index') }}">
				<i class="fa fa-car"></i>
				<span>Cars Management</span></a>
		</li>

		<!-- Itp Menu -->
		<li class="nav-item">
			<a class="nav-link" href="{{ route('itps.index') }}">
				<i class="fa fa-signal"></i>
				<span>ITP Management</span></a>
		</li>
		<!-- Divider -->
		<hr class="sidebar-divider">

		<!-- Heading -->
		<div class="sidebar-heading">
			Report
		</div>

		<!-- BP Menu -->
		<li class="nav-item">
			<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBp" aria-expanded="true"
				aria-controls="collapseTwo">
				<i class="fas fa-fw fa-cog"></i>
				<span>Report BP</span>
			</a>
			<div id="collapseBp" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
				<div class="bg-white py-2 collapse-inner rounded">
					<h6 class="collapse-header">Report BP</h6>
					<a class="collapse-item" href="{{ route('bp.proccessControl.index') }}">Proccess Control</a>
					<a class="collapse-item" href="{{ route('bp.pengendalianSlip.index') }}">Pengendalian Slip</a>
					<a class="collapse-item" href="{{ route('bp.pengendalianPowder.index') }}">Pengendalian Powder</a>
					<a class="collapse-item" href="{{ route('bp.rekapSlip.index') }}">Rekap Slip</a>
					<a class="collapse-item" href="{{ route('bp.rekapPowder.index') }}">Rekap Powder</a>
				</div>
			</div>
		</li>

		<!-- PH Menu -->
		<li class="nav-item">
			<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePH" aria-expanded="true"
				aria-controls="collapseTwo">
				<i class="fas fa-fw fa-cog"></i>
				<span>Report PH</span>
			</a>
			<div id="collapsePH" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
				<div class="bg-white py-2 collapse-inner rounded">
					<h6 class="collapse-header">Report PH</h6>
					<a class="collapse-item" href="{{ route('ph.proccessControl.index') }}">Proccess Control</a>
					<a class="collapse-item" href="{{ route('ph.control.index') }}">Control</a>
					<a class="collapse-item" href="{{ route('ph.temps.index') }}">Suhu</a>
					<a class="collapse-item" href="{{ route('ph.dimensi.index') }}">Dimensi</a>
					<a class="collapse-item" href="{{ route('ph.counter.index') }}">Counter</a>
					<a class="collapse-item" href="{{ route('ph.tebal.index') }}">Tebal</a>
					<a class="collapse-item" href="{{ route('ph.dryer.index') }}">Dryer</a>
				</div>
			</div>
		</li>

		<!-- GL Menu -->
		<li class="nav-item">
			<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseGL" aria-expanded="true"
				aria-controls="collapseTwo">
				<i class="fas fa-fw fa-cog"></i>
				<span>Report GL</span>
			</a>
			<div id="collapseGL" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
				<div class="bg-white py-2 collapse-inner rounded">
					<h6 class="collapse-header">Report GL</h6>
					<a class="collapse-item" href="{{ route('gl.proccessControl.index') }}">Proccess Control</a>
					<a class="collapse-item" href="{{ route('gl.analisa.index') }}">Analisa Tes Bakar</a>
					<a class="collapse-item" href="{{ route('gl.pengendalian.index') }}">Pengendalian Proses</a>
					<a class="collapse-item" href="#" data-toggle="collapse" data-target="#loadingSubMenu"
						aria-expanded="true" aria-controls="loadingSubMenu">Loading</a>
					<div id="loadingSubMenu" class="collapse" aria-labelledby="headingLoading" data-parent="#collapseGL">
						<h6 class="collapse-header">Loading</h6>
						<a class="collapse-item" href="{{ route('gl.loading.index') }}">List</a>
						<a class="collapse-item" href="{{ route('gl.loading.recap') }}">Recap</a>
					</div>
				</div>
			</div>
		</li>

		<!-- RK Menu -->
		<li class="nav-item">
			<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseRK"
				aria-expanded="true" aria-controls="collapseRK">
				<i class="fas fa-fw fa-cog"></i>
				<span>Report RK</span>
			</a>
			<div id="collapseRK" class="collapse" aria-labelledby="headingRK" data-parent="#accordionSidebar">
				<div class="bg-white py-2 collapse-inner rounded">
					<h6 class="collapse-header">Report RK</h6>
					<a class="collapse-item" href="{{ route('rk.proccessControl.index') }}">Proccess Control</a>
					<a class="collapse-item" href="" data-toggle="collapse" data-target="#unloadingSubMenu"
						aria-expanded="true" aria-controls="unloadingSubMenu">Unloading</a>
					<div id="unloadingSubMenu" class="collapse" aria-labelledby="headingUnloading" data-parent="#collapseRK">
						<a class="collapse-item" href="{{ route('rk.unloading.index') }}">List</a>
						<a class="collapse-item" href="{{ route('rk.unloading.recap') }}">Recap</a>
					</div>
					<a class="collapse-item" href="" data-toggle="collapse" data-target="#loadingSubMenu"
						aria-expanded="true" aria-controls="loadingSubMenu">Loading</a>
					<div id="loadingSubMenu" class="collapse" aria-labelledby="headingLoading" data-parent="#collapseRK">
						<a class="collapse-item" href="{{ route('rk.loading.index') }}">List</a>
						<a class="collapse-item" href="{{ route('rk.loading.recap') }}">Recap</a>
					</div>
					<a class="collapse-item" href="{{ route('rk.pengendalian.index') }}">Pengendalian Proses</a>
					<a class="collapse-item" href="{{ route('rk.koreksi.index') }}">Koreksi Tiles</a>
				</div>
			</div>
		</li>

		<!-- SR Menu -->
		<li class="nav-item">
			<a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSR"
				aria-expanded="true" aria-controls="collapseSR">
				<i class="fas fa-fw fa-cog"></i>
				<span>Report SR</span>
			</a>
			<div id="collapseSR" class="collapse" aria-labelledby="headingSR" data-parent="#accordionSidebar">
				<div class="bg-white py-2 collapse-inner rounded">
					<h6 class="collapse-header">Report SR</h6>
					{{-- <a class="collapse-item" href="" data-toggle="collapse" data-target="#unloadingSubMenu"
                    aria-expanded="true" aria-controls="unloadingSubMenu">Unloading</a>
                <div id="unloadingSubMenu" class="collapse" aria-labelledby="headingUnloading" data-parent="#collapseSR">
                    <a class="collapse-item" href="{{ route('sr.unloading.index') }}">List</a>
                    <a class="collapse-item" href="#">Recap</a>
                </div> --}}
					<a class="collapse-item" href="{{ route('sr.proccessControl.index') }}">Procces Control</a>
					<a class="collapse-item" href="{{ route('sr.hasilProduksi.index') }}">Hasil Produksi</a>
					<a class="collapse-item" href="{{ route('sr.hasilSortir.index') }}">Hasil Sortir</a>
					<a class="collapse-item" href="{{ route('sr.cekMesin.index') }}">Cek Mesin</a>
				</div>
			</div>
		</li>

		<!-- Divider -->
		<hr class="sidebar-divider d-none d-md-block">
	@endif

	<!-- Sidebar Toggler (Sidebar) -->
	<div class="text-center d-none d-md-inline">
		<button class="rounded-circle border-0" id="sidebarToggle"></button>
	</div>

</ul>
