<div class="container-fluid">
	<h1 class="h3 mb-0 text-gray-800">Pengaturan Sistem</h1>
	<p class="mb-4"> penyesuaian perangkat mikrotik dan api firebase .</p>

	<div class="row">
		<div class="col-xl-12">
			<div class="card shadow mb-4">


				<form action="<?= base_url('setting') ?>" method="POST">
					<div class="card-body">
						<?php if ($this->session->flashdata('success')) {
							echo "<div class='alert alert-success'>Berhasil menyimpan data</div>";
						} ?>
						<div class="row">
							<div class="col-md-12">
								<h4>Mikrotik</h4>
								<hr>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>IP LOKAL aplikasi yang terhubung dengan jaringan mikrotik </label>
									<input type="text" value="<?= $this->config->item('ip_aplikasi') ?>" name="ip_aplikasi" class="form-control">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>Folder aplikasi </label>
									<input type="text" value="<?= $this->config->item('folder_aplikasi') ?>" name="folder_aplikasi" class="form-control">
								</div>
							</div>


							<div class="col-md-3">
								<div class="form-group">
									<label>IP Mikrotik</label>
									<input type="text" value="<?= $this->config->item('mikrotik_ip') ?>" name="mikrotik_ip" class="form-control">
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Default Interface</label>
									<input type="text" value="<?= $this->config->item('mikrotik_default_interface') ?>" name="mikrotik_default_interface" class="form-control">
								</div>
							</div>
							<div class="col-md-2">
								<div class="form-group">
									<label>Mikrotik PORT</label>
									<input type="text" value="<?= $this->config->item('mikrotik_port') ?>" name="mikrotik_port" class="form-control">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Mikrotik User</label>
									<input type="text" value="<?= $this->config->item('mikrotik_user') ?>" name="mikrotik_user" class="form-control">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label>Mikrotik Password</label>
									<input type="text" value="<?= $this->config->item('mikrotik_pass') ?>" name="mikrotik_pass" class="form-control">
								</div>
							</div>

							<div class="col-md-12">
								<h4 class="m-0 p-0">Firebase</h4>
								<span>untuk push notifikasi aplikasi desktop dan mobile</span>
								<hr>
							</div>
							<div class="col-md-3">
								<div class="form-group">
									<label>Key</label>
									<input type="text" value="<?= $this->config->item('key') ?>" name="key" class="form-control">
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>FCM Url</label>
									<input type="text" value="<?= $this->config->item('fcm_url') ?>" name="fcm_url" class="form-control">
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>Firebase Domain</label>
									<input type="text" value="<?= $this->config->item('firebase_domain') ?>" name="firebase_domain" class="form-control">
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>Firebase Database</label>
									<input type="text" value="<?= $this->config->item('firebase_database') ?>" name="firebase_database" class="form-control">
								</div>
							</div>


							<div class="col-md-3">
								<div class="form-group">
									<label>Firebase Api</label>
									<input type="text" value="<?= $this->config->item('firebase_api') ?>" name="firebase_api" class="form-control">
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>Firebase Project ID</label>
									<input type="text" value="<?= $this->config->item('firebase_projectID') ?>" name="firebase_projectID" class="form-control">
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>Firebase Bucket</label>
									<input type="text" value="<?= $this->config->item('firebase_bucket') ?>" name="firebase_bucket" class="form-control">
								</div>
							</div>

							<div class="col-md-3">
								<div class="form-group">
									<label>Firebase Sender</label>
									<input type="text" value="<?= $this->config->item('firebase_sender') ?>" name="firebase_sender" class="form-control">
								</div>
							</div>

							<div class="col-md-6">
								<div class="form-group">
									<label>Firebase Appid</label>
									<input value="<?= $this->config->item('firebase_appid') ?>" type="text" name="firebase_appid" class="form-control">
								</div>
							</div>


							<div class="col-md-6">
								<div class="form-group">
									<label>Firebase Measure</label>
									<input type="text" value="<?= $this->config->item('firebase_measure') ?>" name="firebase_measure" class="form-control">
								</div>
							</div>



							<div class="col-md-12">
								<h4>User sistem</h4>
								<hr>
							</div>


							<div class="col-md-6">
								<div class="form-group">
									<label>Username</label>
									<input type="text" value="<?= $this->config->item('user') ?>" name="user" class="form-control">
								</div>
							</div>


							<div class="col-md-6">
								<div class="form-group">
									<label>Password</label>
									<input type="text" value="<?= $this->config->item('pass') ?>" name="pass" class="form-control">
								</div>
							</div>



						</div>
					</div>
					<div class="card-footer">
						<button type="submit" name="submit" class="btn btn-block btn-primary">Simpan</button>
					</div>
				</form>

			</div>
		</div>
	</div>