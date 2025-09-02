@extends('layouts.master')

@section('content')
	<div class="container-fluid">
		<div class="row">
			<div class="col-xl-7 col-md-12 col-sm-6 mb-4">
				<div class="card shadow">
					<form class="form-inline" action="{{ route('indexFilterPengawas') }}" method="GET" style="padding-top:20px;">
						<div class="form-group mx-sm-3 mb-2">
							{{-- Select Tanggal Awal --}}
							<div>
								<h4>Tanggal Awal</h4>
								<input type="date" class="form-control mr-3" id="date_start" name="date_start" placeholder="Tanggal Awal"
									value="{{ request('date_start', $periode['startDate']) }}">
							</div>
							<div>
								<h4>Tanggal Akhir</h4>
								<input type="date" class="form-control" id="date_end" name="date_end" placeholder="Tanggal Akhir"
									value="{{ request('date_end', $periode['endDate']) }}">
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
						<button type="submit" class="btn btn-primary mb-2">Refresh</button>
					</form>
				</div>
			</div>
		</div>
		<!-- Page Heading -->

		<h1>HASIL ANALISA KUALITAS TILE</h1>
		<div class="row">
			@foreach ($dataAnalisaKualitasTile as $rowSrAnalisaKualitas)
				@if (!empty($rowSrAnalisaKualitas['top_jenis_cacat']))
					<div class="col-xl-4 col-lg-4">
						<div class="card shadow mb-4">
							<div class="card-header">
								<h6 class="small font-weight-bold text-primary">
									HASIL ANALISA KUALITAS SIZE
									<span class="float-right">{{ $rowSrAnalisaKualitas['size'] }}</span>
								</h6>
							</div>
							@foreach ($rowSrAnalisaKualitas['top_jenis_cacat'] as $rowTopJenisCacat)
								@php
									$firstLevelId =
									    'QUALITYBYSIZE' .
									    preg_replace('/[^a-zA-Z0-9]/', '', $rowSrAnalisaKualitas['size']) .
									    preg_replace('/[^a-zA-Z0-9]/', '', $rowTopJenisCacat['jenis_cacat']);
								@endphp
								<div class="card-header">
									<h6 class="small font-weight-bold">{{ $rowTopJenisCacat['jenis_cacat'] }}
										<span class="float-right">{{ $rowTopJenisCacat['percentage'] }}%</span>
									</h6>
									<div class="progress mb-4" style="cursor: pointer" onclick="toggleCollapse('{{ $firstLevelId }}')">
										<div
											class="progress-bar
                                    {{ $rowTopJenisCacat['percentage'] >= 80
																																				    ? 'bg-danger'
																																				    : ($rowTopJenisCacat['percentage'] >= 60
																																				        ? 'bg-warning'
																																				        : ($rowTopJenisCacat['percentage'] >= 40
																																				            ? 'bg-info'
																																				            : 'bg-success')) }}"
											role="progressbar" style="width: {{ $rowTopJenisCacat['percentage'] }}%"
											aria-valuenow="{{ $rowTopJenisCacat['percentage'] }}" aria-valuemin="0" aria-valuemax="100">
										</div>
									</div>
									@if (!empty($rowTopJenisCacat['grouped_posisi']))
										<div id="{{ $firstLevelId }}" class="collapsible">
											@foreach ($rowTopJenisCacat['grouped_posisi'] as $rowGroupedPosition)
												@php
													$secondLevelId = $firstLevelId . preg_replace('/[^a-zA-Z0-9]/', '', $rowGroupedPosition['material_desc']);
												@endphp
												<div class="card-header">
													<h4 class="text-dark small font-weight-bold">{{ $rowGroupedPosition['material_desc'] }}
														<span class="float-right">{{ $rowGroupedPosition['percentage'] }}%</span>
													</h4>
													<div class="progress mb-4" style="cursor: pointer" onclick="toggleCollapse('{{ $secondLevelId }}')">
														<div
															class="progress-bar
                                                    {{ $rowGroupedPosition['percentage'] >= 80
																																																				    ? 'bg-danger'
																																																				    : ($rowGroupedPosition['percentage'] >= 60
																																																				        ? 'bg-warning'
																																																				        : ($rowGroupedPosition['percentage'] >= 40
																																																				            ? 'bg-info'
																																																				            : 'bg-success')) }}"
															role="progressbar" style="width: {{ $rowGroupedPosition['percentage'] }}%"
															aria-valuenow="{{ $rowGroupedPosition['percentage'] }}" aria-valuemin="0" aria-valuemax="100">
														</div>
													</div>
													@if (!empty($rowGroupedPosition['positions']))
														<div id="{{ $secondLevelId }}" class="collapsible bg-gray-200">
															@foreach ($rowGroupedPosition['positions'] as $index => $rowPosition)
																<div class="small font-weight-bold">
																	{{ $index + 1 }}.
																	@if (!empty($rowPosition['no_ph']) && $rowPosition['no_ph'] !== 'null')
																		PH {{ $rowPosition['no_ph'] }} ➻
																	@endif

																	@if (!empty($rowPosition['no_hd']) && $rowPosition['no_hd'] !== 'null')
																		HD {{ $rowPosition['no_hd'] }} ➻
																	@endif

																	@if ($rowPosition['no_gl'])
																		GL {{ $rowPosition['no_gl'] }} ➻
																	@endif
																	@if ($rowPosition['no_kiln'])
																		KILN {{ $rowPosition['no_kiln'] }}
																	@endif
																</div>
															@endforeach
														</div>
													@endif
												</div>
											@endforeach
										</div>
									@endif
								</div>
							@endforeach
						</div>
					</div>
				@endif
			@endforeach

		</div>

	</div>
@endsection
<script>
	function toggleCollapse(id) {
		const element = document.getElementById(id);
		if (element.classList.contains('show')) {
			element.classList.remove('show');
		} else {
			element.classList.add('show');
		}
	}

	document.addEventListener('DOMContentLoaded', () => {
		document.querySelectorAll('.collapse .card-header').forEach((childHeader) => {
			childHeader.addEventListener('click', (event) => {
				event.stopPropagation();
			});
		});

	});
</script>
<style>
	.collapsible {
		max-height: 0;
		overflow: hidden;
		transition: max-height 1s ease-in-out;
	}

	.collapsible.show {
		max-height: 500px;
		/* Adjust as per your content height */
	}

	/* Style for scrollbar */
	::-webkit-scrollbar-corner {
		background-color: royalblue;
	}

	::-webkit-scrollbar {
		width: 10px;
	}
</style>
