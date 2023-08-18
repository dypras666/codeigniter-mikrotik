<div class="container-fluid">
	<h1 class="h3 mb-0 text-gray-800">Update User Hotspot</h1>
	<p class="mb-4"> penyesuaian user mikrotik .</p>

	<div class="row">
		<div class="col-xl-12">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<h6 class="m-0 font-weight-bold text-primary">Manajemen Akun Hotspot</h6>
				</div>
				<div class="card-body table-responsive">
					<form class="form-horizontal" name="frmtambah" method="post" action="<?php echo $form_action; ?>">
						<div class="form-group row">
							<label class="col-md-4 control-label" for="server">Server</label>
							<div class="col-md-8">
								<select name="server" id="server" class="form-control">
									<option value="all" <?php if (isset($default['server']) && ($default['server'] == 'all' || $default['server'] == '')) {
															echo "selected";
														} ?>>All</option>

									<option value="hotspot1" <?php if (isset($default['server']) && $default['server'] == 'hotspot1') {
																	echo "selected";
																} ?>>hotspot1</option>
								</select>
								<?php echo form_error('server', '<label class="control-label" for="server">', '</label>'); ?>
							</div>
						</div>

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
							<label class="col-md-4 control-label" for="password">Password</label>
							<div class="col-md-8">
								<input class="form-control" type="text" name="password" id="password" placeholder="Password" value="<?php if (isset($default['password'])) {
																																		echo $default['password'];
																																	} ?>">
								<?php echo form_error('password', '<label class="control-label" for="password">', '</label>'); ?>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-md-4 control-label" for="mac_address">MAC Address</label>
							<div class="col-md-8">
								<input class="form-control" type="text" name="mac_address" id="mac_address" placeholder="MAC Address" value="<?php if (isset($default['mac_address'])) {
																																					echo $default['mac_address'];
																																				} ?>">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-md-4 control-label" for="profile">Profile</label>
							<div class="col-md-8">
								<select name="profile" id="profile" class="form-control">
									<?php foreach ($profile as $v) { ?>
										<option value="<?= $v['name'] ?>" <?= (isset($default['profile']) && $default['profile'] == $v['name']) ? 'selected' : '' ?>>
											<?= $v['name'] ?>
										</option>
									<?php } ?>

								</select>
							</div>
						</div>

						<div class="form-group row">
							<label class="col-md-4 control-label" for="comment">Comment</label>
							<div class="col-md-8">
								<input class="form-control" type="text" name="comment" id="comment" placeholder="Comment" value="<?php if (isset($default['comment'])) {
																																		echo $default['comment'];
																																	} ?>">
							</div>
						</div>

						<div class="form-group row">
							<label class="col-md-4 control-label" for="disabled">Disabled</label>
							<div class="col-md-3">
								<div class="form-check">
									<input id="disabled" class="form-check-input" name="disabled" type="radio" value="yes" <?= (isset($default['disabled'])) && $default['disabled'] == 'yes' ? 'checked' : '' ?>>
									<label class="form-check-label"> Yes </label>
								</div>

								<div class="form-check">
									<input id="disabled" class="form-check-input" name="disabled" type="radio" value="no" <?= (isset($default['disabled'])) && $default['disabled'] == 'no' ? 'checked' : ''  ?>>
									<label class="form-check-label"> No </label>
									</label>
								</div>

								<?php echo form_error('disabled', '<label class="control-label" for="disabled">', '</label>'); ?>
							</div>
						</div>

						<div class="form-group row">
							<div class="col-md-offset-2 col-md-10">
								<input type="hidden" name="jenis" value="<?= $jenis ?>">
								<button class="btn btn-primary" type="submit" name="btnsimpan">Simpan</button>
								<a class="btn btn-default" href="<?php echo base_url() . 'hotspot_user'; ?>">Batal</a>
							</div>
						</div>
					</form>
					</p>
				</div>
			</div>
		</div>
	</div>