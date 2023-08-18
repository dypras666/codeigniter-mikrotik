<div class="container-fluid">
	<h1 class="h3 mb-0 text-gray-800">Akun Hotspot</h1>
	<p class="mb-4">Data Akun Hotspot.</p>

	<div class="row">
		<div class="col-xl-12">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary">Manajemen Akun Hotspot</h6>
				</div>
				<div class="card-body table-responsive">
					<?php
					$flashmessage = $this->session->flashdata('message');
					echo !empty($flashmessage) ? '<div class="alert alert-success alert-dismissible" role="alert">' . $flashmessage . '</div><hr>' : '';
					?>

					<a class="btn btn-primary" href="<?= base_url('router/hotspot_user_add') ?>">Tambah </a>
					<hr>
					<table class="table table-striped table-sm" id="datatables">
						<thead>
							<tr>
								<th scope="col">NO</th>
								<th scope="col">Server</th>
								<th scope="col">Nama User</th>
								<th scope="col">Password</th>
								<th scope="col">Mac</th>
								<th scope="col">Profil</th>
								<th scope="col">Komentar</th>
								<th scope="col">###</th>
							</tr>
						</thead>
						<tbody>

						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>


	<script src="<?= base_url() ?>assets/sbadmin/vendor/datatables/jquery.dataTables.min.js"></script>
	<script src="<?= base_url() ?>assets/sbadmin/vendor/datatables/dataTables.bootstrap4.min.js"></script>
	<script>
		var table = $('#datatables').DataTable({
			"pageLength": 5,
			"lengthMenu": [
				[5, 10, 20, -1],
				[5, 10, 20, 'Semua']
			],
			"processing": false,
			"serverSide": true,
			"ajax": "<?= base_url('router/dt_users') ?>",
			"order": [
				[0, 'ASC']
			],
			"aoColumns": [{
					mData: 'no'
				},
				{
					mData: 'server'
				},
				{
					mData: 'name'
				},
				{
					mData: 'password'
				},
				{
					mData: 'mac-address'
				},
				{
					mData: 'profile'
				},
				{
					mData: 'comment'
				},
				{
					mData: 'opsi'
				}
			]

		});
	</script>