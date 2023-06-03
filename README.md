"# codeigniter-mikrotik" 
#PANDUAN INSTALASI ini masih versi beta belum fix yang mau coba dulu silahkan
- Run composer install di terminal
- Ubah config mikrotik di folder application/fcm.php
sesuaikan dengan ip router kalian
###
$config['mikrotik_ip'] = '192.168.88.1'; <br>
$config['mikrotik_port'] = 8278; <br>
$config['mikrotik_default_interface'] = 'SESUAIKAN DENGAN INTERFACE UTAMA'; <br>
$config['mikrotik_user'] ='admin'; <br>
$config['mikrotik_pass'] = ''; <br>
###

