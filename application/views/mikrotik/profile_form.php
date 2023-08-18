<div class="container-fluid">
	<h1 class="h3 mb-0 text-gray-800">Profile Hotspot</h1>
	<p class="mb-4">Ubah/Tambah Profile Hotspot.</p>

	<div class="row">
		<div class="col-xl-12">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary">Ubah/Tambah Profile Hotspot</h6>
				</div>
				<div class="card-body table-responsive">
					<?php
					$flashmessage = $this->session->flashdata('message');
					echo !empty($flashmessage) ? '<div class="alert alert-success alert-dismissible" role="alert">' . $flashmessage . '</div><hr>' : '';
					?>

					<a class="btn btn-primary" href="<?= base_url('router/hotspot_profile') ?>">Kembali ke home </a>
					<hr>
					<form class="form-horizontal" name="frmtambah" method="post" action="<?php echo $form_action; ?>">

						<div class="form-group row">
							<label class="col-md-4 control-label" for="txtname">Name</label>
							<div class="col-md-8">
								<input class="form-control" type="text" name="name" id="name" placeholder="Name" value="<?php if (isset($default['name'])) {
																															echo $default['name'];
																														} ?>">
								<?php echo form_error('name', '<label class="control-label" for="name">', '</label>'); ?>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-md-4 control-label" for="txtname">Iddle Timeout</label>
							<div class="col-md-8">
								<input class="form-control" type="text" name="idle-timeout" id="idle-timeout" placeholder="idle-timeout" value="<?php if (isset($default['idle-timeout'])) {
																																					echo $default['idle-timeout'];
																																				} ?>">
								<?php echo form_error('idle-timeout', '<label class="control-label" for="idle-timeout">', '</label>'); ?>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-md-4 control-label" for="txtname">Keepalive Timout</label>
							<div class="col-md-8">
								<input class="form-control" type="text" name="keepalive-timeout" id="keepalive-timeout" placeholder="keepalive-timeout" value="<?php if (isset($default['keepalive-timeout'])) {
																																									echo $default['keepalive-timeout'];
																																								} ?>">
								<?php echo form_error('keepalive-timeout', '<label class="control-label" for="keepalive-timeout">', '</label>'); ?>
							</div>
						</div>


						<div class="form-group row">
							<label class="col-md-4 control-label" for="txtname">Shared Users</label>
							<div class="col-md-8">
								<input class="form-control" type="text" name="shared-users" id="shared-users" placeholder="shared-users" value="<?php if (isset($default['shared-users'])) {
																																					echo $default['shared-users'];
																																				} ?>">
								<?php echo form_error('shared-users', '<label class="control-label" for="shared-users">', '</label>'); ?>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-md-4 control-label" for="txtname">Rate Limit</label>
							<div class="col-md-8">
								<input class="form-control" type="text" name="rate-limit" id="rate-limit" placeholder="rate-limit" value="<?php if (isset($default['rate-limit'])) {
																																				echo $default['rate-limit'];
																																			} ?>">
								<?php echo form_error('rate-limit', '<label class="control-label" for="rate-limit">', '</label>'); ?>
							</div>
						</div>


						<div class="form-group row">
							<div class="col-md-offset-2 col-md-10">
								<input type="hidden" name="jenis" value="<?= $jenis ?>">
								<button class="btn btn-primary" type="submit" name="btnsimpan">Simpan</button>
								<a class="btn btn-default" href="<?php echo base_url('hotspot_profile'); ?>">Batal</a>
							</div>
						</div>

					</form>
					</p>
				</div>
			</div>
		</div>
	</div>