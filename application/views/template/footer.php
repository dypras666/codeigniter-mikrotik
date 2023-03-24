<script src="<?= base_url()?>assets/bootstrap/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>

<script src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js" integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE" crossorigin="anonymous"></script>
<script src="<?= base_url()?>assets/bootstrap/dashboard.js"></script>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="<?= base_url()?>assets/datatables/datatables.min.js"></script>
<script>

var table = $('#datatables').DataTable( {
    "processing": false,
    "serverSide": true,
    "ajax": "<?=base_url('live_stat')?>",
    "order": [[0,'ASC']],
    "columnDefs": [
    { "targets": 0, "name": "id", 'searchable':false, 'orderable':true},
    { "targets": 1, "name": "interface", 'searchable':false, 'orderable':false},
    { "targets": 2, "name": "rx", 'searchable':false, 'orderable':false},
    { "targets": 3, "name": "tx", 'searchable':false, 'orderable':false},
    ]
  });

  setInterval( function () {
    table.ajax.reload();
}, 5000 );
    </script>

</body>
</html>
