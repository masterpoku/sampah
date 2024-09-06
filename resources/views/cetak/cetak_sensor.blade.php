<html>
<head>
<title>Invoice</title>
<style type="text/css">
  @page {
     margin: 80px 25px;
    }
	#page-wrap {
		width: 700px;
		margin: 0 auto;
	}
	.center-justified {
		text-align: justify;
		margin: 0 auto;
		width: 30em;
	}
	table.outline-table {
		border: 1px solid;
		border-spacing: 0;
	}
	tr.border-bottom td, td.border-bottom {
		border-bottom: 1px solid;
	}
	tr.border-top td, td.border-top {
		border-top: 1px solid;
	}
	tr.border-right td, td.border-right {
		border-right: 1px solid;
	}
	tr.border-right td:last-child {
		border-right: 0px;
	}
	tr.center td, td.center {
		text-align: center;
		vertical-align: text-top;
	}
	td.pad-left {
		padding-left: 5px;
	}
	tr.right-center td, td.right-center {
		text-align: right;
		padding-right: 50px;
	}
	tr.right td, td.right {
		text-align: right;
	}
	.grey {
		background:grey;
	}
    footer {
                position: fixed;
                bottom: -60px;
                left: 0px;
                right: 0px;
                height: 50px;
                font-size: 20px !important;
                background-color: #ffffff;
                color: rgb(5, 5, 5);
                text-align: center;
                line-height: 35px;
            }
</style>
</head>
<body>
    <footer>
            Copyright © <?php echo date("Y");?> - SmartpH Monitoring & Control
    </footer>
	<div id="page-wrap">
		<table width="100%">
			<tbody>
				<tr>
					<td width="30%">
						<img src="{{public_path('img/logo ph.jpg')}}" width="180"> <!-- your logo here -->
					</td>
					<td width="70%">
						<h2>Report Data Sensor : {{$tanggal}}</h2><br>
						<strong>Tanggal Cetak:</strong> <?php echo date('d/M/Y');?><br>
					</td>
				</tr>
				<tr>
					<td colspan="2">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="2">
						<div class="center-justified">
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		<p>&nbsp;</p>
		<table width="100%" class="outline-table">
			<tbody>
				<tr class="border-bottom border-right grey">
					<td colspan="3"><strong>Device 1</strong></td>
				</tr>
				<tr class="border-bottom border-right center">
					<td width="45%"><strong>Activity</strong></td>
					<td width="25%"><strong>pH Sensor</strong></td>
					<td width="30%"><strong>Temperature Sensor</strong></td>
				</tr>
				<tr class="border-right">
					<td class="pad-left">Cetak Data : {{$tanggal}}</td>
					<td class="center">Rata-rata ({{$rata_ph}})</td>
					<td class="right-center">Rata-rata {{$rata_temp}}</td>
				</tr>
                @foreach ($data_control as $items )
                <tr class="border-right">
                    <td class="pad-left">&nbsp;</td>
                    <td class="right border-top">{{$items->nama_device}}</td>
                    <td class="right border-top">
                        @if ($items->state == 0)
                            OFF
                        @else
                            ON
                        @endif
                    </td>
                </tr>
                @endforeach
			</tbody>
		</table>
		<p>&nbsp;</p>
		<table width="100%" class="outline-table">
			<tbody>
				<tr class="border-bottom border-right grey">
					<td colspan="3"><strong>Usage Line Item 1</strong></td>
				</tr>
				<tr class="border-bottom border-right center">
					<td width="45%"><strong>Tanggal</strong></td>
					<td width="25%"><strong>pH</strong></td>
					<td width="30%"><strong>Temperature</strong></td>
				</tr>
                @foreach ($data as $item )
				<tr class="border-bottom border-right">
					<td class="pad-left">{{$item->waktu}}</td>
					<td class="center">{{$item->ph}}<sup>pH</sup></td>
					<td class="right-center">{{$item->temp}} C<sup>o</sup></td>
				</tr>
                @endforeach


			</tbody>
		</table>
		<p>&nbsp;</p>

		<p>&nbsp;</p>
		<table>
			<tbody>
				<tr>
					<td>
						No human was involved in creating this invoice, so, no signature is needed
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</body>
</html>
