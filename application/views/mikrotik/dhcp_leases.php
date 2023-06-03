
<link href="<?= base_url()?>assets/sbadmin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<div class="container-fluid">
          <h1 class="h3 mb-0 text-gray-800">Monitoring Pengguna</h1>
          <p class="mb-4">LOG User Jaringan.</p>
     
<div class="row">
<div class="col-xl-12">
  <div class="card shadow mb-4">
  <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">LOG User Jaringan</h6>
  </div>
  <div class="card-body">
      <table class="table table-striped table-sm" id="datatables" width="100%">
      <thead>
      <tr>
          <th scope="col" width="10">NO</th>
          <th scope="col">Address</th>
          <th scope="col">Mac Address</th>
          <th scope="col">Server</th> 
          <th scope="col">Last Seen</th> 
          <th scope="col">Hostname</th> 
          <th scope="col">Status</th> 
          <th scope="col">Dynamic</th> 
      </tr>
      </thead>
      <tbody>  </tbody>
      </table> 
  </div>

  </div>
  </div>
</div> 

<script src="<?= base_url()?>assets/sbadmin/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= base_url()?>assets/sbadmin/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script>
var table = $('#datatables').DataTable( {
    "pageLength" : 5,
    "lengthMenu": [[5, 10, 20, -1], [5, 10, 20, 'Semua']],
    "processing": false,
    "serverSide": true,
    "ajax": "<?=base_url('mikrotik/dt_dhcp')?>",
    "order": [[0,'ASC']], 
    "aoColumns": [
            { mData: 'no' },
            { mData: 'address' },
            { mData: 'mac-address' },
            { mData: 'server' },
            { mData: 'last-seen' },
            { mData: 'host-name' },
            { mData: 'status' },
            { mData: 'dynamic' },
    ]
   
  });

  setInterval( function () {
    table.ajax.reload(null,false);
}, 1000 );
    </script>


