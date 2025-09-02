@extends('layouts.master')
@section('content')
	<div class="container-fluid">
		<h1>Laporan Hasil Produksi per Jam</h1>
		<form class="form-inline" action="" method="GET" style="padding-top:20px;">
			<div class="form-group mx-sm-3 mb-2">
				<div>
					<h4>Tanggal</h4>
					<input type="date" class="form-control mr-3" id="date" name="date"
						value="{{ request('date', now()->toDateString()) }}">
				</div>
				<div class="mx-sm-3">
					<h4>Shift</h4>
					<select class="form-control" name="shift" id="shift">
						<option value="0" {{ request('shift') == '' ? 'selected' : '' }}>Semua Shift</option>
						<option value="1" {{ request('shift') == '1' ? 'selected' : '' }}>1</option>
						<option value="2" {{ request('shift') == '2' ? 'selected' : '' }}>2</option>
						<option value="3" {{ request('shift') == '3' ? 'selected' : '' }}>3</option>
					</select>
				</div>
			</div>
			<button type="submit" class="btn btn-primary mb-2">Filter</button>
		</form>

		<div class="row">
			<div class="col-xl-12 col-lg-12">
				<div class="card shadow mb-4">
					<div class="card-header">
						<h6 class="small font-weight-bold text-primary">Data Produksi per Jam</h6>
					</div>
					<div class="card-body">
						@php
							$dataProduksi = [
							    [
							        'po_id' => 80274537,
							        'po_date' => '03 March 2025',
							        'start_hour' => '08:00',
							        'material_desc' => 'SFG TILE CERTA NERO 40',
							        'hasil' => 1271,
							        'target' => 1271,
							        'keterangan' => null,
							    ],
							    [
							        'po_id' => 80274537,
							        'po_date' => '03 March 2025',
							        'start_hour' => '09:00',
							        'material_desc' => 'SFG TILE CERTA NERO 40',
							        'hasil' => 1000,
							        'target' => 1271,
							        'keterangan' => 'Mesin Bermasalah',
							    ],
							    [
							        'po_id' => 80274537,
							        'po_date' => '03 March 2025',
							        'start_hour' => '10:00',
							        'material_desc' => 'SFG TILE CERTA NERO 40',
							        'hasil' => 1300,
							        'target' => 1271,
							        'keterangan' => 'Mesin tidak bermasalah',
							    ],
							    [
							        'po_id' => 80274537,
							        'po_date' => '03 March 2025',
							        'start_hour' => '11:00',
							        'material_desc' => 'SFG TILE CERTA NERO 40',
							        'hasil' => 1271,
							        'target' => 1271,
							        'keterangan' => null,
							    ],
							    [
							        'po_id' => 80274537,
							        'po_date' => '03 March 2025',
							        'start_hour' => '12:00',
							        'material_desc' => 'SFG TILE CERTA NERO 40',
							        'hasil' => 1271,
							        'target' => 1271,
							        'keterangan' => '',
							    ],
							    [
							        'po_id' => 80274537,
							        'po_date' => '03 March 2025',
							        'start_hour' => '13:00',
							        'material_desc' => 'SFG TILE CERTA NERO 40',
							        'hasil' => 1270,
							        'target' => 1271,
							        'keterangan' => '',
							    ],
							    [
							        'po_id' => 80274533,
							        'po_date' => '03 March 2025',
							        'start_hour' => '08:00',
							        'material_desc' => 'SFG TILE CALINA PIXIE 51',
							        'hasil' => 1340,
							        'target' => 1340,
							        'keterangan' => null,
							    ],
							    [
							        'po_id' => 80274533,
							        'po_date' => '03 March 2025',
							        'start_hour' => '09:00',
							        'material_desc' => 'SFG TILE CALINA PIXIE 51',
							        'hasil' => 1340,
							        'target' => 1340,
							        'keterangan' => '',
							    ],
							    [
							        'po_id' => 80274533,
							        'po_date' => '03 March 2025',
							        'start_hour' => '10:00',
							        'material_desc' => 'SFG TILE CALINA PIXIE 51',
							        'hasil' => 1340,
							        'target' => 1340,
							        'keterangan' => '',
							    ],
							    [
							        'po_id' => 80274533,
							        'po_date' => '03 March 2025',
							        'start_hour' => '11:00',
							        'material_desc' => 'SFG TILE CALINA PIXIE 51',
							        'hasil' => 1340,
							        'target' => 1340,
							        'keterangan' => null,
							    ],
							    [
							        'po_id' => 80274533,
							        'po_date' => '03 March 2025',
							        'start_hour' => '12:00',
							        'material_desc' => 'SFG TILE CALINA PIXIE 51',
							        'hasil' => 1340,
							        'target' => 1340,
							        'keterangan' => '',
							    ],
							    [
							        'po_id' => 80274533,
							        'po_date' => '03 March 2025',
							        'start_hour' => '13:00',
							        'material_desc' => 'SFG TILE CALINA PIXIE 51',
							        'hasil' => 1340,
							        'target' => 1340,
							        'keterangan' => '',
							    ],
							];

							// Gabungkan data berdasarkan po_id
							$groupedData = [];
							foreach ($dataProduksi as $produksi) {
							    $po_id = $produksi['po_id'];

							    if (!isset($groupedData[$po_id])) {
							        $groupedData[$po_id] = [
							            'po_id' => $po_id,
							            'po_date' => $produksi['po_date'],
							            'material_desc' => $produksi['material_desc'],
							            'total_hasil' => 0,
							            'total_target' => 0,
							            'details' => [],
							        ];
							    }

							    // Total hasil dan target
							    $groupedData[$po_id]['total_hasil'] += $produksi['hasil'];
							    $groupedData[$po_id]['total_target'] += $produksi['target'];

							    // Simpan detail per jam
							    $groupedData[$po_id]['details'][] = $produksi;
							}
						@endphp

						<table class="table table-bordered table-striped">
							<thead class="bg-primary text-white">
								<tr>
									<th>No</th>
									<th>PO ID</th>
									<th>Tanggal PO</th>
									<th>Deskripsi Material</th>
									<th>Total Hasil</th>
									<th>Total Target</th>
									<th>Detail</th>
								</tr>
							</thead>
							<tbody class="text-black">
								@foreach ($groupedData as $index => $po)
									<tr style="background-color: {{ $po['total_hasil'] >= $po['total_target'] ? '#d4edda' : '#f8d7da' }};">
										<td>{{ $loop->iteration }}</td>
										<td>{{ $po['po_id'] }}</td>
										<td>{{ $po['po_date'] }}</td>
										<td>{{ $po['material_desc'] }}</td>
										<td>{{ $po['total_hasil'] }}</td>
										<td>{{ $po['total_target'] }}</td>
										<td>
											<button class="btn btn-info btn-sm toggle-detail" data-target="detail-{{ $po['po_id'] }}">Lihat
												Detail</button>
										</td>
									</tr>
									<tr id="detail-{{ $po['po_id'] }}" style="display: none; background-color: #f9f9f9;">
										<td colspan="8">
											<table class="table table-sm">
												<thead>
													<tr>
														<th>Jam</th>
														<th>Hasil</th>
														<th>Target</th>
														<th>Keterangan</th>
													</tr>
												</thead>
												<tbody>
													@foreach ($po['details'] as $detail)
														<tr class="{{ $detail['hasil'] >= $detail['target'] ? 'table-success' : 'table-danger' }}">
															<td>{{ $detail['start_hour'] }}</td>
															<td>{{ $detail['hasil'] }}</td>
															<td>{{ $detail['target'] }}</td>
															<td>{{ $detail['keterangan'] ?? '-' }}</td>
														</tr>
													@endforeach
												</tbody>
											</table>
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		document.addEventListener('DOMContentLoaded', function() {
			document.querySelectorAll('.toggle-detail').forEach(button => {
				button.addEventListener('click', function() {
					let target = document.getElementById(this.dataset.target);
					target.style.display = target.style.display === 'none' ? 'table-row' : 'none';
				});
			});
		});
	</script>
@endsection
