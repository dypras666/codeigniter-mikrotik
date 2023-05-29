
<link href="<?= base_url()?>assets/sbadmin/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
<div class="container-fluid">
          <h1 class="h3 mb-0 text-gray-800">Log </h1>
          <p class="mb-4">menampilkan semua log aktivitas yang ada diperangkat.</p>
     
<div class="row">
<div class="col-xl-12">
  <div class="card shadow mb-4">
  <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">log Aktivitas</h6>
  </div>
  <div class="card-body table-responsive">
  <table class="table table-striped table-sm" id="datatables" width="100%">
      <thead>
      <tr>
          <th scope="col" width="10">ID</th>
          <th scope="col">Waktu</th>
          <th scope="col">Jenis</th>
          <th scope="col">Pesan</th> 
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
    "pageLength" : 10,
    "lengthMenu": [[10, 20, 50, -1], [10, 20, 50, 'Semua']],
    "processing": false,
    "serverSide": true,
    "ajax": "<?=base_url('mikrotik/dt_log')?>",
    // "order": [['id','DESC']], 
    "aoColumns": [
            { mData: 'id' },
            { mData: 'time' },
            { mData: 'topics' },
            { mData: 'message' }
    ]
    // "columnDefs": [
    // { "targets": 0, "name": "id", 'searchable':false, 'orderable':true},
    // { "targets": 1, "name": "interface", 'searchable':false, 'orderable':false},
    // { "targets": 2, "name": "rx", 'searchable':false, 'orderable':false},
    // { "targets": 3, "name": "tx", 'searchable':false, 'orderable':false},
    // ]
  });

//   setInterval( function () {
//     table.ajax.reload(null,false);
// }, 1000 );
    </script>

