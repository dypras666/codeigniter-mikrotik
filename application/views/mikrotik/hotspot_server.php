<link href="<?= base_url() ?>assets/sbadmin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<div class="container-fluid">
	<h1 class="h3 mb-0 text-gray-800">Server Hotspot </h1>
	<p class="mb-4">menampilkan semua Server yang ada diperangkat.</p>

	<div class="row">
		<div class="col-xl-12">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary">Server Hotspot</h6>
				</div>
				<div class="card-body table-responsive">
					<a class="btn btn-primary" href="<?= base_url('mikrotik/hotspot_server_add') ?>">Tambah </a>
					<hr>
					<table class="table table-striped table-sm" id="datatables" width="100%">
						<thead>
							<tr>
								<th scope="col" width="10">ID</th>
								<th scope="col">Name</th>
								<!-- <th scope="col">hotspot address</th> -->
								<th scope="col">dns name</th>
								<th scope="col">html directory</th>
								<!-- <th scope="col">html-directory-override</th>  -->
								<th scope="col">rate-limit</th>
								<!-- <th scope="col">http-proxy</th>  -->
								<!-- <th scope="col">smtp-server</th>  -->
								<!-- <th scope="col">login-by</th>  -->
								<!-- <th scope="col">http-cookie-lifetime</th>  -->
								<!-- <th scope="col">split-user-domain</th>  -->
								<!-- <th scope="col">use-radius</th>  -->
								<!-- <th scope="col">default</th>  -->
								<th scope="col">####</th>
							</tr>
						</thead>
						<tbody> </tbody>
					</table>
				</div>

			</div>
		</div>
	</div>

	<script src="<?= base_url() ?>assets/sbadmin/vendor/datatables/jquery.dataTables.min.js"></script>
	<script src="<?= base_url() ?>assets/sbadmin/vendor/datatables/dataTables.bootstrap4.min.js"></script>
	<script>
		var table = $('#datatables').DataTable({
			"pageLength": 10,
			"lengthMenu": [
				[10, 20, 50, -1],
				[10, 20, 50, 'Semua']
			],
			"processing": false,
			"serverSide": true,
			"ajax": "<?= base_url('router/dt_profile') ?>",
			"aoColumns": [{
					mData: 'id'
				},
				{
					mData: 'name'
				},
				// { mData: 'hotspot-address' },
				{
					mData: 'dns-name'
				},
				{
					mData: 'html-directory'
				},
				// { mData: 'html-directory-override' },
				{
					mData: 'rate-limit'
				},
				// { mData: 'http-proxy' },
				// { mData: 'smtp-server' },
				// { mData: 'login-by' },
				// { mData: 'http-cookie-lifetime' },
				// { mData: 'split-user-domain' },
				// { mData: 'use-radius' },
				// { mData: 'default' },
				{
					mData: 'button'
				}
			]

		});
	</script>