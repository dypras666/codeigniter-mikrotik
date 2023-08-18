<link href="<?= base_url() ?>assets/sbadmin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<div class="container-fluid">
	<h1 class="h3 mb-0 text-gray-800">Monitoring Pengguna</h1>
	<p class="mb-4">Perangkat yang terhubung dengan jaringan mikrotik.</p>

	<div class="row">
		<div class="col-xl-12">
			<div class="alert alert-info">
				Klik <a class="btn btn-sm btn-primary disabled"><i class="fa fa-plus-circle"></i> monitoring</a> untuk menambahkan perangkat ke daftar notifikasi
			</div>
			<div class="card shadow mb-4">

				<div class="card-body table-responsive">
					<table class="table table-striped table-sm" id="datatables" width="100%">
						<thead>
							<tr>
								<th scope="col" width="10">NO</th>
								<th scope="col">Address</th>
								<th scope="col">Mac Address</th>
								<!-- <th scope="col">Server</th> -->
								<th scope="col">Last Seen</th>
								<th scope="col">Hostname</th>
								<th scope="col">Status</th>
								<th scope="col">Dynamic</th>
								<th scope="col" width="100">OPSI</th>
							</tr>
						</thead>
						<tbody> </tbody>
					</table>
				</div>

			</div>
		</div>
	</div>
	<div class="modal fade" id="show-form">
		<div class="modal-dialog ">

			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Monitoring Perangkat <span id="ip-host"></span></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					Perangkat <span id="ip-hosts"></span> akan ditambahkan ke daftar notifikasi monitoring jaringan?
					<hr>
					<div class="form-group">
						<label>Komentar</label>
						<input type="text" class="form-control" id="comment" value="">
					</div>
					<div class="form-group">
						<label> INTERVAL , default : 10detik</label>
						<input type="text" class="form-control" id="interval" value="00:00:10">
					</div>

					<div class="form-group">
						<label> TIMEOUT , default : 10detik</label>
						<input type="text" class="form-control" id="timeout" value="00:00:10">
					</div>
					<input type="text" class="form-control" readonly id="val-ip">
				</div>
				<div class=" modal-footer">
					<button type="button" class="btn btn-sm btn-success proses-monitoring"><i class="fa fa-check-circle"></i> Ya</button>
					<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close"> <i class="fa fa-times-circle"></i> Tidak</button>
				</div>
			</div>
		</div>
	</div>

	<div class="modal fade" id="show-modal-success">
		<div class="modal-dialog modal-sm ">

			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title">Berhasil</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					Perangkat <span id="ip-host-success"></span> berhasil ditambahkan
				</div>
				<div class=" modal-footer">
					<button type="button" class="btn btn-sm btn-danger" data-dismiss="modal" aria-label="Close"> <i class="fa fa-times-circle"></i> Tutup</button>
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
				[10, 15, 20, -1],
				[10, 15, 20, 'Semua']
			],
			"processing": false,
			"serverSide": true,
			"ajax": "<?= base_url('router/dt_dhcp') ?>",
			"order": [
				[0, 'ASC']
			],
			"aoColumns": [{
					mData: 'no'
				},
				{
					mData: 'address'
				},
				{
					mData: 'mac-address'
				},
				// {
				// 	mData: 'server'
				// },
				{
					mData: 'last-seen'
				},
				{
					mData: 'host-name'
				},
				{
					mData: 'status'
				},
				{
					mData: 'dynamic'
				},
				{
					mData: 'opsi'
				},
			]

		});

		setInterval(function() {
			table.ajax.reload(null, false);
		}, 10000);


		$(document).ready(function() {

			$('body').on('click', '.add-monitoring', function() {
				var ip = $(this).data('ip');
				$('#show-form').modal('show');
				$('#ip-host').html(ip);
				$('#ip-hosts').html('<b>' + ip + '</b>');
				$('#val-ip').val(ip);
			});

			$('body').on('click', '.proses-monitoring', function() {
				var ip = $('#val-ip').val();
				var interval = $('#interval').val();
				var timeout = $('#timeout').val();
				var comment = $('#comment').val();
				$.ajax({
					url: '<?= base_url('router/netwatch_save') ?>',
					type: 'post',
					data: {
						host: ip,
						interval: interval,
						timeout: timeout,
						comment: comment,
					},
					success: function(response) {
						$('#ip-host-success').html('<b>' + ip + '</b>');
						$('#show-modal-success').modal('show');
						table.ajax.reload(null, false);
						$('#show-form').modal('hide');

					}
				});
			});
		});
	</script>