@extends('layouts.master')

@section('content')
	<div class="container-fluid">
		<h1>Laporan Absensi</h1>
		<form class="form-inline" action="" method="GET" style="padding-top:20px;">
			<div class="form-group mx-sm-3 mb-2">
				<div>
					<h4>Tanggal Awal</h4>
					<input type="date" class="form-control mr-3" id="date_start" name="date_start"
						value="{{ request('date_start', now()->startOfMonth()->toDateString()) }}">
				</div>
				<div>
					<h4>Tanggal Akhir</h4>
					<input type="date" class="form-control" id="date_end" name="date_end"
						value="{{ request('date_end', now()->endOfMonth()->toDateString()) }}">
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

		<!-- Data Absensi -->
		<div class="row">
			<div class="col-xl-12 col-lg-12">
				<div class="card shadow mb-4">
					<div class="card-header">
						<h6 class="small font-weight-bold text-primary">Data Absensi Karyawan</h6>
					</div>
					<div class="card-body">
						@php
							$dataDummy = [
							    [
							        'nama' => 'Budi Santoso',
							        'tanggal' => '2025-03-10',
							        'kode_area' => 'M3-RK05-LO',
							        'kode_grup' => 'PROD - D',
							        'jumlah_absensi' => 22,
							        'pindah_area' => 2,
							        'persentase' => '90%',
							    ],
							    [
							        'nama' => 'Siti Aminah',
							        'tanggal' => '2025-03-10',
							        'kode_area' => 'M3-RK05-UN',
							        'kode_grup' => 'PROD - A',
							        'jumlah_absensi' => 20,
							        'pindah_area' => 1,
							        'persentase' => '95%',
							    ],
							    [
							        'nama' => 'Andi Saputra',
							        'tanggal' => '2025-03-10',
							        'kode_area' => 'M3-RK05-LO',
							        'kode_grup' => 'PROD - C',
							        'jumlah_absensi' => 25,
							        'pindah_area' => 0,
							        'persentase' => '100%',
							    ],
							    [
							        'nama' => 'Rina Melati',
							        'tanggal' => '2025-03-10',
							        'kode_area' => 'RK-0204-UN',
							        'kode_grup' => 'PROD - A',
							        'jumlah_absensi' => 18,
							        'pindah_area' => 3,
							        'persentase' => '85%',
							    ],
							    [
							        'nama' => 'Dedi Irawan',
							        'tanggal' => '2025-03-10',
							        'kode_area' => 'M2-RK04-LO',
							        'kode_grup' => 'PROD - C',
							        'jumlah_absensi' => 23,
							        'pindah_area' => 1,
							        'persentase' => '95%',
							    ],
							    [
							        'nama' => 'Lina Permata',
							        'tanggal' => '2025-03-10',
							        'kode_area' => 'M3-RK05-UN',
							        'kode_grup' => 'PROD - D',
							        'jumlah_absensi' => 21,
							        'pindah_area' => 2,
							        'persentase' => '88%',
							    ],
							    [
							        'nama' => 'Rahmat Hidayat',
							        'tanggal' => '2025-03-10',
							        'kode_area' => 'M2-RK04-UN',
							        'kode_grup' => 'PROD - D',
							        'jumlah_absensi' => 24,
							        'pindah_area' => 0,
							        'persentase' => '100%',
							    ],
							];
						@endphp

						<table class="table table-bordered table-striped">
							<thead class="bg-primary text-white">
								<tr>
									<th>No</th>
									<th>Nama Karyawan</th>
									<th>Kode Area</th>
									<th>Kode Grup</th>
									<th>Jumlah Absensi</th>
									<th>Pindah Area Kerja</th>
									<th>Persentase</th>
								</tr>
							</thead>
							<tbody class="text-black">
								@foreach ($dataDummy as $index => $absensi)
									<tr>
										<td>{{ $index + 1 }}</td>
										<td>{{ $absensi['nama'] }}</td>
										<td>{{ $absensi['kode_area'] }}</td>
										<td>{{ $absensi['kode_grup'] }}</td>
										<td>{{ $absensi['jumlah_absensi'] }}</td>
										<td>{{ $absensi['pindah_area'] }}</td>
										<td>{{ intval((($absensi['jumlah_absensi'] - $absensi['pindah_area']) / $absensi['jumlah_absensi']) * 100) }}%
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
@endsection
