
</div>
</div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; <?= date('Y')?></span>
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
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
                    <a class="btn btn-primary" href="<?= base_url('auth/logout')?>">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="<?= base_url()?>assets/sbadmin/vendor/jquery/jquery.min.js"></script>
    <script src="<?= base_url()?>assets/sbadmin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="<?= base_url()?>assets/sbadmin/vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="<?= base_url()?>assets/sbadmin/js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <!-- <script src="<?= base_url()?>assets/sbadmin/vendor/chart.js/Chart.min.js"></script>

      Page level custom scripts -->
    <!-- <script src="<?= base_url()?>assets/sbadmin/js/demo/chart-area-demo.js"></script>
    <script src="<?= base_url()?>assets/sbadmin/js/demo/chart-pie-demo.js"></script> --> 
    
    <script src="https://www.gstatic.com/firebasejs/3.7.2/firebase.js"></script>
    <script>
    // Initialize Firebase
    var config = {
        apiKey: "<?= $this->config->item('key')?>",
        authDomain: "<?= $this->config->item('firebase_domain')?>",
        databaseURL: "<?= $this->config->item('firebase_database')?>",
        storageBucket: "your storage bucket",
        messagingSenderId: "your messaging id"
    };
    firebase.initializeApp(config);

    const messaging = firebase.messaging();

    messaging.requestPermission()
    .then(function() {
    console.log('Notification permission granted.');
    return messaging.getToken();
    })
    .then(function(token) {
    console.log(token); // Display user token
    })
    .catch(function(err) { // Happen if user deney permission
    console.log('Unable to get permission to notify.', err);
    });

    messaging.onMessage(function(payload){
        console.log('onMessage',payload);
    })

    </script>
</body>

</html>