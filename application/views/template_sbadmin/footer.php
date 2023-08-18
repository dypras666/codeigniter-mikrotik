</div>
</div>
<!-- End of Main Content -->

<!-- Footer -->
<footer class="sticky-footer bg-white">
	<div class="container my-auto">
		<div class="copyright text-center my-auto">
			<span>Copyright &copy; <?= date('Y') ?></span>
		</div>
	</div>
</footer>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
	<i class="fas fa-angle-up"></i>
</a>

<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Keluar Sistem?</h5>
				<button class="close" type="button" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">×</span>
				</button>
			</div>
			<div class="modal-body">Anda akan diarahkan kehalaman login </div>
			<div class="modal-footer">
				<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
				<a class="btn btn-primary" href="<?= base_url('auth/logout') ?>">Logout</a>
			</div>
		</div>
	</div>
</div>

<!-- Bootstrap core JavaScript-->
<script src="<?= base_url() ?>assets/sbadmin/vendor/jquery/jquery.min.js"></script>
<script src="<?= base_url() ?>assets/sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= base_url() ?>assets/sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= base_url() ?>assets/sbadmin/js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<!-- <script src="<?= base_url() ?>assets/sbadmin/vendor/chart.js/Chart.min.js"></script>

      Page level custom scripts -->
<!-- <script src="<?= base_url() ?>assets/sbadmin/js/demo/chart-area-demo.js"></script>
    <script src="<?= base_url() ?>assets/sbadmin/js/demo/chart-pie-demo.js"></script> -->

<script src="https://www.gstatic.com/firebasejs/7.23.0/firebase.js"></script>
<script>
	var firebaseConfig = {
		apiKey: "<?= $this->config->item('key') ?>",
		authDomain: "<?= $this->config->item('firebase_domain') ?>",
		databaseURL: "<?= $this->config->item('firebase_database') ?>",
		projectId: "<?= $this->config->item('firebase_projectID') ?>",
		storageBucket: "<?= $this->config->item('firebase_bucket') ?>",
		messagingSenderId: "<?= $this->config->item('firebase_sender') ?>",
		appId: "<?= $this->config->item('firebase_appid') ?>",
		measurementId: "<?= $this->config->item('firebase_measure') ?>"
	};
	// measurementId: G-R1KQTR3JBN
	// Initialize Firebase
	firebase.initializeApp(firebaseConfig);
	const messaging = firebase.messaging();
	initFirebaseMessagingRegistration()


	function initFirebaseMessagingRegistration() {
		messaging
			.requestPermission()
			.then(function() {
				return messaging.getToken()
			})
			.then(function(token) {
				console.log(token);

				$.ajaxSetup({
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				});

				$.ajax({
					url: '<?= base_url('setting/save_token') ?>',
					type: 'POST',
					data: {
						firebase_token: token

					},
					dataType: 'JSON',
					success: function(response) {
						// alert('Token saved successfully.');
					},
					error: function(err) {
						// alert('User Chat Token Error' + err);
					},
				});

			}).catch(function(err) {
				alert(err);
			});
	}


	messaging.onMessage(function(payload) {
		const noteTitle = payload.notification.title;
		const noteOptions = {
			body: payload.notification.body,
			icon: payload.notification.icon,
		};
		new Notification(noteTitle, noteOptions);
	});

	if (localStorage.collapsed_menu === "true") {
		$('body').addClass('sidebar-toggled');
		$('ul#accordionSidebar').addClass('toggled');
	} else {
		$('body').removeClass('sidebar-toggled');
		$('ul#accordionSidebar').removeClass('toggled');
	}

	$('#sidebarToggle').click(function() {
		toggle_leftbar();
	});

	function toggle_leftbar() {
		var menuCollapsed = localStorage.getItem('collapsed_menu');

		if (menuCollapsed == "true")
			localStorage.setItem('collapsed_menu', "false");
		else if (menuCollapsed == "false")
			localStorage.setItem('collapsed_menu', "true");
		else
			localStorage.setItem('collapsed_menu', "true");

	}

	function copy() {
		var copyText = document.getElementById("fb-token-header");
		copyText.select();
		copyText.setSelectionRange(0, 99999);
		navigator.clipboard.writeText(copyText.value);
		alert("Token : " + copyText.value);
	}
</script>
</body>

</html>