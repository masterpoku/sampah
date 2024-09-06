<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1" />

		<title>Rekap_Sensor_{{$username}}_{{$date}}</title>

		<!-- Favicon -->
		<link rel="icon" href="./images/favicon.png" type="image/x-icon" />

		<!-- Invoice styling -->
		<style>
			body {
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				text-align: center;
				color: #777;
			}

			body h1 {
				font-weight: 300;
				margin-bottom: 0px;
				padding-bottom: 0px;
				color: #000;
			}

			body h3 {
				font-weight: 300;
				margin-top: 10px;
				margin-bottom: 20px;
				font-style: italic;
				color: #555;
			}

			body a {
				color: #06f;
			}

			.invoice-box {
				max-width: 800px;
				margin: auto;
				padding: 30px;
				border: 1px solid #eee;
				box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
				font-size: 16px;
				line-height: 24px;
				font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
				color: #555;
			}

			.invoice-box table {
				width: 100%;
				border-collapse: collapse;
			}

			.invoice-box table td {
				padding: 5px;
				vertical-align: top;
			}

			/* .invoice-box table tr td:nth-child(2) {
				text-align: right;
			} */

			.invoice-box table tr.top table td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.top table td.title {
				font-size: 45px;
				line-height: 45px;
				color: #333;
			}

			.invoice-box table tr.information table td {
				padding-bottom: 40px;
			}

			.invoice-box table tr.heading td {
				background: #eee;
				border-bottom: 1px solid #ddd;
				font-weight: bold;
			}

			.invoice-box table tr.details td {
				padding-bottom: 20px;
			}

			.invoice-box table tr.item td {
				border-bottom: 1px solid #eee;
			}

			.invoice-box table tr.item.last td {
				border-bottom: none;
			}

			.invoice-box table tr.total td:nth-child(2) {
				border-top: 2px solid #eee;
				font-weight: bold;
			}

			@media only screen and (max-width: 600px) {
				.invoice-box table tr.top table td {
					width: 100%;
					display: block;
					text-align: center;
				}

				.invoice-box table tr.information table td {
					width: 100%;
					display: block;
					text-align: center;
				}
			}
		</style>
	</head>

	<body>
		<div class="invoice-box">
			<table>
				<tr class="top">
					<td colspan="2">
						<table>
							<tr>
								<td class="title">
									<img src="{{public_path('img/logo ph.jpg')}}" alt="Company logo" style="width: 70%; max-width: 200px" />
								</td>

								<td>
									Print Date : <?php echo date('d/M/Y H:s:i');?><br />
									Administrator : {{$auth}}
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="2">
						<table>
							<tr>
								<td>
									Username    : {{$username}}<br />
							        Sensor Date : {{tanggal_indonesia($date)}}   <br />
									Jumlah Data :  {{$datacount}}
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="heading">
					<td>Activity</td>

					<td>Device name</td>
				</tr>

				<tr class="details">
					<td>Cetak Data Sensor Tanggal : {{tanggal_indonesia($date)}} </td>

					<td>{{$username}}</td>
				</tr>



			</table>
            <table>
                <tr class="heading">
					<td>Rekap Sensor  {{tanggal_indonesia($date)}}</td>
					<td>Tegangan</td>
					<td>Ph</td>
					<td>Temperature</td>
				</tr>

				<tr class="item">
					<td>Rata-rata</td>
					<td>{{$tegangan}}</td>
                    <td>{{$ph}}</td>
                    <td>{{$temperature}}</td>
				</tr>
				<tr class="item">
					<td>Nilai Terbesar</td>
					<td>{{$teganganMax}}</td>
                    <td>{{$phMax}}</td>
                    <td>{{$temperatureMax}}</td>
				</tr>
				<tr class="item">
					<td>Nilai Terkecil</td>
					<td>{{$teganganMin}}</td>
                    <td>{{$phMin}}</td>
                    <td>{{$temperatureMin}}</td>
				</tr>
            </table>
            <br>

            <h5>Data Terakhir</h5>
            <table>
                <tr class="heading">
                    <td>Waktu</td>
                    <td>Tegangan</td>
                    <td>PH</td>
                    <td>Temperature</td>
                </tr>
                @foreach ($dataterakhir as $item )
                    <tr>
                        <td>{{$item->waktu}}</td>
                        <td>{{$item->tegangan}}</td>
                        <td>{{$item->ph}}</td>
                        <td>{{$item->temp}}</td>
                    </tr>
                @endforeach
            </table>
		</div>
	</body>
</html>
