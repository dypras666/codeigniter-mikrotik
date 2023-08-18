<body id="page-top">

	<!-- Page Wrapper -->
	<div id="wrapper">

		<!-- Sidebar -->
		<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

			<!-- Sidebar - Brand -->
			<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
				<div class="sidebar-brand-icon rotate-n-15">
					<i class="fas  fa-network-wired"></i>
				</div>
				<div class="sidebar-brand-text mx-3">Mikrotik <sup>app</sup></div>
			</a>

			<!-- Divider -->
			<hr class="sidebar-divider my-0">

			<!-- Nav Item - Dashboard -->
			<li class="nav-item active">
				<a class="nav-link" href="<?= base_url() ?>">
					<i class="fas fa-fw fa-tachometer-alt"></i>
					<span>Dashboard</span></a>
			</li>

			<!-- Divider -->
			<hr class="sidebar-divider">

			<!-- Heading -->
			<div class="sidebar-heading">
				Menu Utama
			</div>

			<!-- Nav Item - Pages Collapse Menu -->
			<li class="nav-item  <?= $this->uri->segment(1) == "monitoring" ? "active" : "" ?>">
				<a class="nav-link   " href="<?= base_url('monitoring') ?>">
					<i class="fas fa-fw fa-chart-area"></i>
					<span>Perangkat</span>
				</a>
			</li>
			<li class="nav-item <?= $this->uri->segment(1) == "dhcp_leases" ? "active" : "" ?>">
				<a class="nav-link   " href="<?= base_url('dhcp_leases') ?>">
					<i class="fas fa-fw fa-wifi"></i>
					<span>Perangkat Aktif</span>
				</a>
			</li>
			<li class="nav-item <?= $this->uri->segment(1) == "netwatch" ? "active" : "" ?>">
				<a class="nav-link   " href="<?= base_url('netwatch') ?>">
					<i class="fas fa-fw fa-eye"></i>
					<span>Netwatch</span>
				</a>
			</li>
			<li class="nav-item <?= $this->uri->segment(1) == "hotspot_user" ? "active" : "" ?>">
				<a class="nav-link   " href="<?= base_url('hotspot_user') ?>">
					<i class="fas fa-fw fa-users"></i>
					<span>User Hotspot</span>
				</a>
			</li>
			<li class="nav-item <?= $this->uri->segment(1) == "hotspot_profile" ? "active" : "" ?>">
				<a class="nav-link   " href="<?= base_url('hotspot_profile') ?>">
					<i class="fas fa-fw fa-user-md"></i>
					<span>User Profil</span>
				</a>
			</li>



			<li class="nav-item <?= $this->uri->segment(1) == "log" ? "active" : "" ?>">
				<a class="nav-link   " href="<?= base_url('log') ?>">
					<i class="fas fa-fw fa-file-pdf"></i>
					<span>Log Aktivitas</span>
				</a>

			</li>
			<li class="nav-item <?= $this->uri->segment(1) == "setting" ? "active" : "" ?>">
				<a class="nav-link   " href="<?= base_url('setting') ?>">
					<i class="fas fa-fw fa-cog"></i>
					<span>Setting Sistem</span>
				</a>

			</li>




			<!-- Divider -->
			<hr class="sidebar-divider d-none d-md-block">

			<!-- Sidebar Toggler (Sidebar) -->
			<div class="text-center d-none d-md-inline">
				<button class="rounded-circle border-0" id="sidebarToggle"></button>
			</div>

			<!-- Sidebar Message -->


		</ul>
		<!-- End of Sidebar -->


		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">