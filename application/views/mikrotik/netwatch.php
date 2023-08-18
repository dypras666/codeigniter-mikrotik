<link href="<?= base_url() ?>assets/sbadmin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<div class="container-fluid">
	<h1 class="h3 mb-0 text-gray-800">Monitoring perangkat</h1>
	<p class="mb-4">menu ini digunakan untuk memonitoring perangkat jaringan dan akan mengirimkan push notifikasi ke aplikasi android.</p>

	<div class="row">
		<div class="col-xl-12">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary">Netwatch</h6>
				</div>
				<div class="card-body table-responsive">
					<table class="table table-striped table-sm" id="datatables" width="100%">
						<thead>
							<tr>
								<th scope="col" width="10">NO</th>
								<th scope="col">Host</th>
								<th scope="col">Interval</th>
								<th scope="col">Timeout</th>
								<th scope="col">Status</th>
								<th scope="col">Waktu</th>
								<th scope="col">Opsi</th>
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
			"pageLength": 15,
			"lengthMenu": [
				[15, 20, 50, -1],
				[15, 20, 50, 'Semua']
			],
			"processing": false,
			"serverSide": true,
			"ajax": "<?= base_url('router/dt_netwatch') ?>",
			"order": [
				[0, 'ASC']
			],
			"aoColumns": [{
					mData: 'no'
				},
				{
					mData: 'host'
				},
				{
					mData: 'interval'
				},
				{
					mData: 'timeout'
				},
				{
					mData: 'status'
				},
				{
					mData: 'since'
				},
				{
					mData: 'opsi'
				}
			]

		});

		setInterval(function() {
			table.ajax.reload(null, false);
		}, 10000);

		$(document).ready(function() {

			$('body').on('click', '.edit', function() {
				var id = $(this).data('id');
				$.ajax({
					url: '<?= base_url('router/netwatch') ?>',
					type: 'post',
					data: {
						id: id
					},
					success: function(response) {
						// Add response in Modal body

						var data = response[0];
						var html = '';
						html += '<form class="form-horizontal" name="form-edit" method="post">';
						html += '<div class="row"><div class="col-md-6">';
						html += '<div class="form-group"><label>Comment</label><input type="text" class="form-control" name="comment" value="' + data['comment'] + '"></div>';
						html += '<div class="form-group"><label>HOST</label><input type="text" class="form-control" name="host" value="' + data['host'] + '"></div>';
						html += '<div class="form-group"><label>interval</label><input type="text" class="form-control" name="interval" value="' + data['interval'] + '"></div>';
						html += '<div class="form-group"><label>timeout</label><input type="text" class="form-control" name="timeout" value="' + data['timeout'] + '"></div>';
						html += '</div><div class="col-md-6">';
						html += '<div class="form-group"><label>UP SCRIPT</label><textarea cols="10" rows="5" class="form-control" name="up-script">' + data['up-script'] + ' </textarea></div>';
						html += '<div class="form-group"><label>DOWN SCRIPT</label><textarea cols="10" rows="5" class="form-control" name="down-script">' + data['down-script'] + ' </textarea></div></div>';
						html += '<div class="form-group"><button id="save" class="btn btn-primary">Simpan</a></div>';
						html += '</form>';
						$('.modal-body').html(html);

						// Display Modal
						$('#show-edit').modal('show');

					}
				});
			});
		});

		$('body').on('click', '.change-status', function() {
			var id = $(this).data('id');
			var status = $(this).data('status');
			$.ajax({
				url: '<?= base_url('router/netwatch_change') ?>',
				type: 'post',
				data: {
					id: id,
					status: status
				},
				success: function(response) {
					$(".modal-title").html('Berhasil ');
					$(".modal-body").html('Perangkat dinonaktifkan dari notifikasi ');
					table.ajax.reload(null, false);
					$('#show-modal-success').modal('show');

				}
			});
		});

		$('body').on('click', '.delete', function() {
			var id = $(this).data('id');
			$.ajax({
				url: '<?= base_url('router/netwatch_delete') ?>',
				type: 'post',
				data: {
					id: id,
				},
				success: function(response) {
					$(".modal-title").html('Berhasil dihapus ');
					$(".modal-body").html('Perangkat dihapus dari notifikasi ');
					table.ajax.reload(null, false);
					$('#show-modal-success').modal('show');

				}
			});
		});
	</script>



	<div class="modal fade" id="show-edit">
		<div class="modal-dialog modal-lg">

			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Edit Netwatch</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>



	<div class="modal fade" id="show-modal-success">
		<div class="modal-dialog modal-sm">

			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">Berhasil merubah data</h4>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
			</div>
		</div>
	</div>