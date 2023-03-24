 
<div class="container-fluid">
  <div class="row">
    <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
      <div class="position-sticky pt-3 sidebar-sticky">
        <ul class="nav flex-column">
          <li class="nav-item">
            <a class="nav-link <?= $this->uri->segment(1) == "" ? "active" : ""?>" aria-current="page" href="<?= base_url()?>">
              <span data-feather="home" class="align-text-bottom"></span>
              Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $this->uri->segment(1) == "user" ? "active" : ""?>" href="<?= base_url('user')?>">
              <span data-feather="user" class="align-text-bottom"></span>
              User
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $this->uri->segment(1) == "monitoring" ? "active" : ""?>" href="<?= base_url('monitoring')?>">
              <span data-feather="bar-chart" class="align-text-bottom"></span>
              Monitoring 
            </a>
          </li>
           
        </ul>

        <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted text-uppercase">
          <span>Laporan</span>
          <a class="link-secondary" href="#" aria-label="Add a new report">
            <span data-feather="plus-circle" class="align-text-bottom"></span>
          </a>
        </h6>
        <ul class="nav flex-column mb-2">
          <li class="nav-item">
            <a class="nav-link <?= $this->uri->segment(1) == "bandwidth" ? "active" : ""?>" href="<?= base_url('bandwidth')?>">
              <span data-feather="cast" class="align-text-bottom"></span>
             Bandwidth
            </a>
          </li>
          
        </ul>
      </div>
    </nav>