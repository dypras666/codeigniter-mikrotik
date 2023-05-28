<div class="container-fluid">
          <h1 class="h3 mb-0 text-gray-800">User</h1>
          <p class="mb-4">Data User pengguna jaringan.</p>
     
<div class="row">
<div class="col-xl-12">
  <a class="btn btn-primary" href="#">Tambah User</a>
  <div class="card shadow mb-4">
  <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Manajemen User</h6>
  </div>
  <div class="card-body">
<div class="table-responsive">
<table class="table table-striped table-sm" id="datatables">
<thead>
<tr>
    <th scope="col">NO</th>
    <th scope="col">Server</th>
    <th scope="col">Nama User</th>
    <th scope="col">Password</th>
    <th scope="col">Mac</th>
    <th scope="col">Profil</th>
    <th scope="col">Komentar</th>
</tr>
</thead>
<tbody>
<?php $i =1; foreach ($hotspot_users as $user){  
					echo '<tr>';
					echo '<td class="col-md-1 text-center">'.$i.'.</td>';
					if (isset($user['server'])){
						echo '<td>'.$user['server'].'</td>';
					}else{
						echo '<td>&nbsp;</td>';
					}
					echo '<td class="col-md-1 text-center">'.$user['name'].'</td>';
					echo '<td class="col-md-1 text-center">'.@$user['password'].'</td>';
					if (isset($user['mac-address'])){
						echo '<td>'.$user['mac-address'].'</td>';
					}else{
						echo '<td>&nbsp;</td>';
					}
					echo '<td class="col-md-1 text-center">'.@$user['profile'].'</td>';
					if (isset($user['comment'])){
						echo '<td>'.$user['comment'].'</td>';					
					}else{
						echo '<td>&nbsp;</td>';
					}
				 
					echo '</td>';
					echo '</tr>';
					$i++;
}?>
</tbody>
</table>
</div> 
  </div>
</div>
  </div>
</div>
