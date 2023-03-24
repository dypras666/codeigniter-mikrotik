<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Data User Jaringan</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
          <div class="btn-group me-2">
            <button type="button" class="btn btn-sm btn-outline-secondary">Share</button>
            <button type="button" class="btn btn-sm btn-outline-secondary">Export</button>
          </div>
          <button type="button" class="btn btn-sm btn-outline-secondary dropdown-toggle">
            <span data-feather="calendar" class="align-text-bottom"></span>
            This week
          </button>
        </div>
      </div> 
<div class="table-responsive">
<table class="table table-striped table-sm">
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
    </main>
  </div>
</div>
