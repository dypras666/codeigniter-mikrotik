<!-- Begin Page Content -->
<div class="container-fluid">

	<!-- Page Heading -->
	<div class="d-sm-flex align-items-center justify-content-between mb-4">
		<h1 class="h3 mb-0 text-gray-800">Dashboard</h1>


	</div>

	<div class="row">
		<div class="col-md-4"> <select name="interface" class="form-control" id="interface" onchange="filter()">
				<?php foreach ($interface as $v) {
					echo '<option data-interface="' . $v['name'] . '" value="' . $v['name'] . '">' . $v['name'] . '</option>';
				}
				?>
			</select>

		</div>
		<div class="col-md-8"></div>
		<div class="col-12">

			<div id="trafficMonitor" class="trafficMonitor"></div>
		</div>

		<!-- Earnings (Monthly) Card Example -->
		<div class="col-xl-4 col-md-6 mb-4">
			<div class="card border-left-primary shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
								Jumlah Gangguan Internet</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?= $gangguan_internet ?></div>
						</div>
						<div class="col-auto">
							<i class="fas fa-times fa-2x text-gray-300"></i>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Earnings (Monthly) Card Example -->
		<div class="col-xl-4 col-md-6 mb-4">
			<div class="card border-left-danger shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
								User Offline</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><span class="device-offline"></span></div>
						</div>
						<div class="col-auto">
							<i class="fas fa-wifi fa-2x text-gray-300"></i>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Earnings (Monthly) Card Example -->
		<div class="col-xl-4 col-md-6 mb-4">
			<div class="card border-left-info shadow h-100 py-2">
				<div class="card-body">
					<div class="row no-gutters align-items-center">
						<div class="col mr-2">
							<div class="text-xs font-weight-bold text-success text-uppercase mb-1">
								Jumlah Perangkat</div>
							<div class="h5 mb-0 font-weight-bold text-gray-800"><?= $total ?> </div>
						</div>
						<div class="col-auto">
							<i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
						</div>
					</div>
				</div>
			</div>
		</div>


	</div>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/highcharts/11.0.1/highcharts.js"></script>

	<script>
		var interface = "<?= $this->session->userdata('interface') ?>";

		function filter() {
			var interface = $('#interface option:selected').data('interface');
			$.post('<?= base_url("router/index") ?>', {
					interface: interface
				},
				function(data) {
					requestDatta('', interface);

				});



		}
		var chart;
		var sessiondata = "";


		var n = 1000;

		function requestDatta(session, iface) {
			$.ajax({
				url: '<?= base_url('router/json_traffic') ?>',
				datatype: "json",
				type: 'post',
				data: {
					interface: iface
				},
				success: function(data) {
					var midata = JSON.parse(data);
					if (midata.length > 0) {
						var TX = parseInt(midata[0].data);
						var RX = parseInt(midata[1].data);
						var x = (new Date()).getTime();
						shift = chart.series[0].data.length > 19;
						chart.series[0].addPoint([x, TX], true, shift);
						chart.series[1].addPoint([x, RX], true, shift);
					}
				},
				error: function(XMLHttpRequest, textStatus, errorThrown) {
					console.error("Status: " + textStatus + " request: " + XMLHttpRequest);
					console.error("Error: " + errorThrown);
				}
			});
		}

		$(document).ready(function() {
			Highcharts.setOptions({
				global: {
					useUTC: false
				}
			});

			Highcharts.addEvent(Highcharts.Series, 'afterInit', function() {
				this.symbolUnicode = {
					circle: '●',
					diamond: '♦',
					square: '■',
					triangle: '▲',
					'triangle-down': '▼'
				} [this.symbol] || '●';
			});

			chart = new Highcharts.Chart({
				chart: {
					renderTo: 'trafficMonitor',
					animation: Highcharts.svg,
					type: 'areaspline',
					events: {
						load: function() {
							setInterval(function() {
								requestDatta(sessiondata, interface);
							}, 2000);

						}
					}
				},
				title: {
					text: 'Grafik monitoring perangkat '
				},

				xAxis: {
					type: 'datetime',
					tickPixelInterval: 150,
					maxZoom: 20 * 1000,
				},
				yAxis: {
					minPadding: 0.2,
					maxPadding: 0.2,
					title: {
						text: null
					},
					labels: {
						formatter: function() {
							var bytes = this.value;
							var sizes = ['bps', 'kbps', 'Mbps', 'Gbps', 'Tbps'];
							if (bytes == 0) return '0 bps';
							var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
							return parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i];
						},
					},
				},

				series: [{
					name: 'Tx',
					data: [],
					marker: {
						symbol: 'circle'
					}
				}, {
					name: 'Rx',
					data: [],
					marker: {
						symbol: 'circle'
					}
				}],
				tooltip: {
					formatter: function() {
						const judul = '<b>Monitoring Jaringan ' + $('#interface option:selected').data('interface') + '</b>'
						const x = 'Rx : ' + tobyte(this.points[1]['y'])
						const y = 'Tx : ' + tobyte(this.points[0]['y'])
						return judul + '<hr><br>' + y + '<br>' + x
					},
					shared: true
				}

			});
		});

		function tobyte(point) {
			var bytes = point;
			var sizes = ['bps', 'kbps', 'Mbps', 'Gbps', 'Tbps'];
			if (bytes == 0) return '0 bps';
			var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
			return parseFloat((bytes / Math.pow(1024, i)).toFixed(2)) + ' ' + sizes[i];
		}

		setInterval(function() {
			device_offline()
		}, 1000);

		function device_offline() {
			$.post('<?= base_url("router/json_device_offline") ?>', {
					interface: interface
				},
				function(data) {
					$(".device-offline").html(data)
				});
		}
	</script>