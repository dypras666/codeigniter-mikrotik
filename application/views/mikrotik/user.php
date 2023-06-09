<div class="container-fluid">
          <h1 class="h3 mb-0 text-gray-800">Akun Hotspot</h1>
          <p class="mb-4">Data Akun Hotspot.</p>
     
<div class="row">
<div class="col-xl-12">
  <div class="card shadow mb-4">
  <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Manajemen Akun Hotspot</h6>
  </div>
  <div class="card-body table-responsive"> 
  <?php
	$flashmessage = $this->session->flashdata('message');
	echo !empty($flashmessage) ? '<div class="alert alert-success alert-dismissible" role="alert">' . $flashmessage . '</div><hr>': '';
?>	

  <a class="btn btn-primary" href="<?= base_url('mikrotik/hotspot_user_add')?>">Tambah  </a>
  <hr>
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
    <th scope="col">###</th>
</tr>
</thead>
<tbody>
<?php $i =1; foreach ($hotspot_users as $user){  
					$btn_update = @$user['disabled'] == 'true' ? '<a class="btn btn-sm btn-success" href="'.base_url('mikrotik/user_enable/'.$user['.id']).'">Enable</a>' :  '<a class="btn btn-sm btn-warning" href="'.base_url('mikrotik/user_disable/'.$user['.id']).'">Disable</a>';
			
					$btn = "<div class='btn-group'>
					<a class='btn btn-sm btn-primary' href='".base_url('mikrotik/hotspot_user_edit/'.$user['.id'])."'>Update</a>
					$btn_update
					<a class='btn btn-sm btn-danger' href='".base_url('mikrotik/hotspot_user_delete/'.$user['.id'])."'>Delete</a>
					</div>";
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
				 
					echo '</td><td>'.$btn .'</td>';
					echo '</tr>';
					$i++;
}?>
</tbody>
</table>
</div>  
</div>
  </div>
</div>
