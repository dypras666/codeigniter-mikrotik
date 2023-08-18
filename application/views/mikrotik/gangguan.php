<div class="container-fluid">
	<h1 class="h3 mb-0 text-gray-800">Laporan</h1>
	<p class="mb-4">Laporan notifikasi perangkat monitoring.</p>

	<div class="row">
		<div class="col-xl-12">
			<div class="card shadow mb-4">

				<div class="card-body table-responsive">

					<a class="btn btn-primary" href="<?= base_url('router/dhcp_leases') ?>">Tambah </a>
					<hr>
					<table class="table table-striped table-sm" id="datatables">
						<thead>
							<tr>
								<th scope="col">NO</th>
								<th scope="col">IP</th>
								<th scope="col">PERANGKAT</th>
								<th scope="col">STATUS</th>
								<th scope="col">PESAN</th>
								<th scope="col">TGL/JAM</th>
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
			"ajax": "<?= base_url('router/dt_gangguan') ?>",
			"order": [
				[0, 'DESC']
			],
			"aoColumns": [{
					mData: 'no'
				},
				{
					mData: 'ip'
				},
				{
					mData: 'perangkat'
				},
				{
					mData: 'status'
				},
				{
					mData: 'body'
				},
				{
					mData: 'datetime'
				}

			]

		});
	</script>