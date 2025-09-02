@extends('layouts.master')

@section('content')
	<div class="container-fluid">
		<div class="card shadow mb-4">
			<div class="card-header py-3">
				<h4 class="m-0 font-weight-bold text-primary">Overall Equipment Effectiveness</h4>
			</div>
		</div>
		<div class="row">
			<div class="col-xl-6 col-md-6 mb-4">
				<div class="card shadow">
					<form class="form-inline" action="{{ route('indexByFilter') }}" method="GET" style="padding-top:20;">
						<div class="form-group mx-sm-3 mb-2">
							<input type="month" name="selectBulan" id="" value="{{ request('selectBulan', now()->format('Y-m')) }}"
								class="form-control">
						</div>
						<button type="submit" class="btn btn-primary mb-2">Refresh</button>
					</form>
				</div>
			</div>
		</div>
		<!-- Content Row -->
		<div class="row">
			<!-- Availability Card -->
			<div class="col-xl-3 col-md-6 mb-4">
				<div class="card border-left-info shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="font-weight-bold text-info text-uppercase mb-1">Availability
								</div>
								<div class="row no-gutters align-items-center">
									<div class="col-auto">
										<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $sumAvailability }}%
										</div>
									</div>
									<div class="col">
										<div class="progress progress-sm mr-2">
											<div class="progress-bar bg-info" role="progressbar" style="width: {{ $sumAvailability }}%"
												aria-valuenow="{{ $sumAvailability }}" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>

			<!-- Performance Card -->
			<div class="col-xl-3 col-md-6 mb-4">
				<div class="card border-left-info shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="font-weight-bold text-info text-uppercase mb-1">Performance
								</div>
								<div class="row no-gutters align-items-center">
									<div class="col-auto">
										<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $sumPerformance }}%
										</div>
									</div>
									<div class="col">
										<div class="progress progress-sm mr-2">
											<div class="progress-bar bg-info" role="progressbar" style="width: {{ $sumPerformance }}%"
												aria-valuenow="{{ $sumPerformance }}" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>

			<!-- Quality Card -->
			<div class="col-xl-3 col-md-6 mb-4">
				<div class="card border-left-info shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="font-weight-bold text-info text-uppercase mb-1">Quality
								</div>
								<div class="row no-gutters align-items-center">
									<div class="col-auto">
										<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $sumQuality }}%</div>
									</div>
									<div class="col">
										<div class="progress progress-sm mr-2">
											<div class="progress-bar bg-info" role="progressbar" style="width: {{ $sumQuality }}%"
												aria-valuenow="{{ $sumQuality }}" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>

			<!-- OEE Card -->
			<div class="col-xl-3 col-md-6 mb-4">
				<div class="card border-left-info shadow h-100 py-2">
					<div class="card-body">
						<div class="row no-gutters align-items-center">
							<div class="col mr-2">
								<div class="font-weight-bold text-info text-uppercase mb-1">OEE
								</div>
								<div class="row no-gutters align-items-center">
									<div class="col-auto">
										<div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $sumOee }}%</div>
									</div>
									<div class="col">
										<div class="progress progress-sm mr-2">
											<div class="progress-bar bg-info" role="progressbar" style="width: {{ $sumOee }}%"
												aria-valuenow="{{ $sumOee }}" aria-valuemin="0" aria-valuemax="100"></div>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</div>
		{{-- CARD ROW DETAIL --}}
		<div class="row">
			<div class="col-xl-3 col-lg-4">
				<div class="card shadow mb-4">
					<div class="card-header">
						<h6 class="small font-weight-bold text-primary">DETAIL AVAILABILITY</h6>
					</div>
					<?php for($i = 0; $i < count($availabilityByMachine); $i++): ?>
					<div class="card-header" data-toggle="collapse"
						data-target="#AVAILABILITY{{ str_replace(' ', '_', $availabilityByMachine[$i]['work_center']) }}">

						<h6 class="small font-weight-bold">{{ $availabilityByMachine[$i]['work_center'] }}<span
								class="float-right">{{ $availabilityByMachine[$i]['availability'] }}%</span></h6>
						<div class="progress mb-4">
							<div class="progress-bar <?php echo $availabilityByMachine[$i]['availability'] >= 80 ? 'bg-success' : ($availabilityByMachine[$i]['availability'] >= 60 ? 'bg-info' : ($availabilityByMachine[$i]['availability'] >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar"
								style="width: {{ $availabilityByMachine[$i]['availability'] }}%"
								aria-valuenow="{{ $availabilityByMachine[$i]['availability'] }}" aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<?php for($j = 0; $j < count($detailAvailabilityByType); $j++): ?>
						@if ($detailAvailabilityByType[$j]['work_center'] == $availabilityByMachine[$i]['work_center'])
							<div id="AVAILABILITY{{ str_replace(' ', '_', $detailAvailabilityByType[$j]['work_center']) }}"
								class="collapse">
								<div class="card-body">
									<h4 class="small font-weight-bold">{{ $detailAvailabilityByType[$j]['grund'] }}<span
											class="float-right">{{ $detailAvailabilityByType[$j]['downTimePercent'] }}%</span>
									</h4>
									<div class="progress progress-sm">
										<div class="progress-bar <?php echo $detailAvailabilityByType[$j]['downTimePercent'] >= 80 ? 'bg-success' : ($detailAvailabilityByType[$j]['downTimePercent'] >= 60 ? 'bg-info' : ($detailAvailabilityByType[$j]['downTimePercent'] >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar"
											style="width: {{ $detailAvailabilityByType[$j]['downTimePercent'] }}%"
											aria-valuenow="{{ $detailAvailabilityByType[$j]['downTimePercent'] }}" aria-valuemin="0"
											aria-valuemax="100"></div>
									</div>
								</div>
							</div>
						@endif
						<?php endfor; ?>
					</div>
					<?php endfor; ?>
				</div>
			</div>

			<div class="col-xl-3 col-lg-4">
				<div class="card shadow">
					<div class="card-header">
						<h6 class="small font-weight-bold text-primary">DETAIL PERFORMANCE</h6>
					</div>
					<?php for($i = 0; $i < count($performanceByMachine); $i++): ?>
					<div class="card-header" data-toggle="collapse"
						data-target="#PERFORMANCE{{ str_replace(' ', '_', $performanceByMachine[$i]['work_center']) }}">
						<h6 class="small font-weight-bold">{{ $performanceByMachine[$i]['work_center'] }}<span
								class="float-right">{{ $performanceByMachine[$i]['performance'] }}%</span></h6>
						<div class="progress mb-4">
							<div class="progress-bar <?php echo $performanceByMachine[$i]['performance'] >= 80 ? 'bg-success' : ($performanceByMachine[$i]['performance'] >= 60 ? 'bg-info' : ($performanceByMachine[$i]['performance'] >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar"
								style="width: {{ $performanceByMachine[$i]['performance'] }}%"
								aria-valuenow="{{ $performanceByMachine[$i]['performance'] }}" aria-valuemin="0" aria-valuemax="100">
							</div>
						</div>
						<?php for($j = 0; $j < count($detailPerformanceBySize); $j++): ?>
						@if ($detailPerformanceBySize[$j]['work_center'] == $performanceByMachine[$i]['work_center'])
							<div id="PERFORMANCE{{ str_replace(' ', '_', $detailPerformanceBySize[$j]['work_center']) }}" class="collapse">
								<div class="card-body">
									<h4 class="small font-weight-bold">{{ $detailPerformanceBySize[$j]['size'] }}<span
											class="float-right">{{ $detailPerformanceBySize[$j]['hasilPercent'] }}%</span>
									</h4>
									<div class="progress progress-sm">
										<div class="progress-bar <?php echo $detailPerformanceBySize[$j]['hasilPercent'] >= 80 ? 'bg-success' : ($detailPerformanceBySize[$j]['hasilPercent'] >= 60 ? 'bg-info' : ($detailPerformanceBySize[$j]['hasilPercent'] >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar"
											style="width: {{ $detailPerformanceBySize[$j]['hasilPercent'] }}%"
											aria-valuenow="{{ $detailPerformanceBySize[$j]['hasilPercent'] }}" aria-valuemin="0" aria-valuemax="100">
										</div>
									</div>
								</div>
							</div>
						@endif
						<?php endfor; ?>
					</div>
					<?php endfor; ?>
				</div>
			</div>

			<div class="col-xl-3 col-lg-4">
				<div class="card shadow">
					<div class="card-header">
						<h6 class="small font-weight-bold text-primary">DETAIL QUALITY</h6>
					</div>
					<?php for($i = 0; $i < count($qualityByMachine); $i++): ?>
					<div class="card-header" data-toggle="collapse"
						data-target="#QUALITY{{ str_replace(' ', '_', $qualityByMachine[$i]['work_center']) }}">
						<h6 class="small font-weight-bold">{{ $qualityByMachine[$i]['work_center'] }}<span
								class="float-right">{{ $qualityByMachine[$i]['quality'] }}%</span></h6>
						<div class="progress mb-4">
							<div class="progress-bar <?php echo $qualityByMachine[$i]['quality'] >= 80 ? 'bg-success' : ($qualityByMachine[$i]['quality'] >= 60 ? 'bg-info' : ($qualityByMachine[$i]['quality'] >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar"
								style="width: {{ $qualityByMachine[$i]['quality'] }}%" aria-valuenow="{{ $qualityByMachine[$i]['quality'] }}"
								aria-valuemin="0" aria-valuemax="100"></div>
						</div>
						<?php for($j = 0; $j < count($detailQualityByMachineGrade); $j++): ?>
						@if ($detailQualityByMachineGrade[$j]['work_center'] == $qualityByMachine[$i]['work_center'])
							<div id="QUALITY{{ str_replace(' ', '_', $detailQualityByMachineGrade[$j]['work_center']) }}" class="collapse">
								<div class="card-body">
									<h4 class="small font-weight-bold">
										{{ $detailQualityByMachineGrade[$j]['grade'] }}<span
											class="float-right">{{ $detailQualityByMachineGrade[$j]['qualityByMachineGradePercent'] }}%</span>
									</h4>
									<div class="progress progress-sm">
										<div class="progress-bar <?php echo $detailQualityByMachineGrade[$j]['qualityByMachineGradePercent'] >= 80 ? 'bg-success' : ($detailQualityByMachineGrade[$j]['qualityByMachineGradePercent'] >= 60 ? 'bg-info' : ($detailQualityByMachineGrade[$j]['qualityByMachineGradePercent'] >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar"
											style="width: {{ $detailQualityByMachineGrade[$j]['qualityByMachineGradePercent'] }}%"
											aria-valuenow="{{ $detailQualityByMachineGrade[$j]['qualityByMachineGradePercent'] }}" aria-valuemin="0"
											aria-valuemax="100"></div>
									</div>
								</div>
							</div>
						@endif
						<?php endfor; ?>
					</div>
					<?php endfor; ?>
				</div>
			</div>

			<div class="col-xl-3 col-lg-4">
				<div class="card shadow">
					<div class="card-header">
						<h6 class="small font-weight-bold text-primary">DETAIL OEE</h6>
					</div>
					<?php for($i = 0; $i < count($oeeByMachine); $i++): ?>
					<div class="card-header" data-toggle="collapse">
						<h6 class="small font-weight-bold">{{ $oeeByMachine[$i]['work_center'] }}<span
								class="float-right">{{ $oeeByMachine[$i]['oee'] }}%</span></h6>
						<div class="progress mb-4">
							<div class="progress-bar <?php echo $oeeByMachine[$i]['oee'] >= 80 ? 'bg-success' : ($oeeByMachine[$i]['oee'] >= 60 ? 'bg-info' : ($oeeByMachine[$i]['oee'] >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar"
								style="width: {{ $oeeByMachine[$i]['oee'] }}%" aria-valuenow="{{ $oeeByMachine[$i]['oee'] }}"
								aria-valuemin="0" aria-valuemax="100">
							</div>
						</div>
					</div>
					<?php endfor; ?>
				</div>
			</div>
		</div>
		{{-- CARD ROW  --}}
		<div class="row">
			{{--
<div class="col-xl-3 col-lg-4">
<div class="card shadow mb-4">
    <div class="card-header">
        <h6 class="small font-weight-bold text-primary">HASIL SORTIR BY GRADE, SIZE</h6>
    </div>
    <?php for($i = 0; $i < count($detailQualityByGrade); $i++): ?>
    <div class="card-header" data-toggle="collapse" data-target="#QUALITY{{ $detailQualityByGrade[$i]['grade'] }}">
        <h6 class="small font-weight-bold">{{ $detailQualityByGrade[$i]['grade'] }}<span class="float-right">{{ $detailQualityByGrade[$i]['qualityByGradePercent'] }}%</span></h6>
        <div class="progress mb-4">
            <div class="progress-bar <?php echo $detailQualityByGrade[$i]['qualityByGradePercent'] >= 80 ? 'bg-success' : ($detailQualityByGrade[$i]['qualityByGradePercent'] >= 60 ? 'bg-info' : ($detailQualityByGrade[$i]['qualityByGradePercent'] >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar" style="width: {{ $detailQualityByGrade[$i]['qualityByGradePercent'] }}%" aria-valuenow="{{ $detailQualityByGrade[$i]['qualityByGradePercent'] }}" aria-valuemin="0" aria-valuemax="100"></div>
        </div>
        <?php for($j = 0; $j < count($detailQualityByGradeSize); $j++): ?>
            @if ($detailQualityByGradeSize[$j]['grade'] == $detailQualityByGrade[$i]['grade'])
                <div id="QUALITY{{ $detailQualityByGradeSize[$j]['grade'] }}" class="collapse">
                    <div class="card-body">
                        <h4 class="small font-weight-bold">{{ $detailQualityByGradeSize[$j]['size'] }}<span class="float-right">{{ $detailQualityByGradeSize[$j]['qualityByGradeSizePercent'] }}%</span></h4>
                        <div class="progress progress-sm">
                            <div class="progress-bar <?php echo $detailQualityByGradeSize[$j]['qualityByGradeSizePercent'] >= 80 ? 'bg-success' : ($detailQualityByGradeSize[$j]['qualityByGradeSizePercent'] >= 60 ? 'bg-info' : ($detailQualityByGradeSize[$j]['qualityByGradeSizePercent'] >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar" style="width: {{ $detailQualityByGradeSize[$j]['qualityByGradeSizePercent'] }}%" aria-valuenow="{{ $detailQualityByGradeSize[$j]['qualityByGradeSizePercent'] }}" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            @endif
        <?php endfor; ?>
    </div>
    <?php endfor; ?>
</div>
</div>
--}}

			<div class="col-xl-3 col-lg-4">
				<div class="card shadow mb-4">
					{{-- HEADER CARD --}}
					<div class="card-header">
						<h6 class="small font-weight-bold text-primary">HASIL SORTIR BY GRADE, SIZE</h6>
					</div>
					@foreach ($qualityByGrade as $rowqualityByGrade)
						<div class="card-header" data-toggle="collapse" data-target="#QUALITYBYGRADE{{ $rowqualityByGrade['MVGR4'] }}">
							<h6 class="small font-weight-bold">{{ $rowqualityByGrade['MVGR4'] }}<span
									class="float-right">{{ $rowqualityByGrade['hasilPercentPcs'] }}%</span></h6>
							<div class="progress mb-4">
								<div class="progress-bar <?php echo $rowqualityByGrade['hasilPercentPcs'] >= 80 ? 'bg-success' : ($rowqualityByGrade['hasilPercentPcs'] >= 60 ? 'bg-info' : ($rowqualityByGrade['hasilPercentPcs'] >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar"
									style="width: {{ $rowqualityByGrade['hasilPercentPcs'] }}%"
									aria-valuenow="{{ $rowqualityByGrade['hasilPercentPcs'] }}" aria-valuemin="0" aria-valuemax="100">
								</div>
							</div>
							@foreach ($qualityByGradeSize as $rowqualityByGradeSize)
								@if ($rowqualityByGradeSize['MVGR4'] == $rowqualityByGrade['MVGR4'])
									<div id="QUALITYBYGRADE{{ $rowqualityByGradeSize['MVGR4'] }}" class="collapse">
										<div class="card-body">
											<h4 class="small font-weight-bold">{{ $rowqualityByGradeSize['size'] }}<span
													class="float-right">{{ $rowqualityByGradeSize['hasilPercentPcs'] }}%</span>
											</h4>
											<div class="progress progress-sm">
												<div class="progress-bar <?php echo $rowqualityByGradeSize['hasilPercentPcs'] >= 80 ? 'bg-success' : ($rowqualityByGradeSize['hasilPercentPcs'] >= 60 ? 'bg-info' : ($rowqualityByGradeSize['hasilPercentPcs'] >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar"
													style="width: {{ $rowqualityByGradeSize['hasilPercentPcs'] }}%"
													aria-valuenow="{{ $rowqualityByGradeSize['hasilPercentPcs'] }}" aria-valuemin="0" aria-valuemax="100">
												</div>
											</div>
										</div>
									</div>
								@endif
							@endforeach
						</div>
					@endforeach
				</div>
			</div>

			<div class="col-xl-3 col-lg-4">
				<div class="card shadow mb-4">
					<div class="card-header">
						<h6 class="small font-weight-bold text-primary">HASIL SORTIR BY SIZE, MOTIVE, KW1</h6>
					</div>
					@foreach ($qualityByGradeSize as $rowqualityByGradeSize)
						@if ($rowqualityByGradeSize['MVGR4'] == 'Q01')
							<div class="card-header" data-toggle="collapse"
								data-target="#QUALITYBYGRADE{{ $rowqualityByGradeSize['size'] }}">
								<h6 class="small font-weight-bold">{{ $rowqualityByGradeSize['size'] }}<span
										class="float-right">{{ $rowqualityByGradeSize['hasilPercentPcs'] }}%</span></h6>
								<div class="progress mb-4">
									<div class="progress-bar <?php echo $rowqualityByGradeSize['hasilPercentPcs'] >= 80 ? 'bg-success' : ($rowqualityByGradeSize['hasilPercentPcs'] >= 60 ? 'bg-info' : ($rowqualityByGradeSize['hasilPercentPcs'] >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar"
										style="width: {{ $rowqualityByGradeSize['hasilPercentPcs'] }}%"
										aria-valuenow="{{ $rowqualityByGradeSize['hasilPercentPcs'] }}" aria-valuemin="0" aria-valuemax="100">
									</div>
								</div>
								@foreach ($qualityBySizeMotive as $rowqualityBySizeMotive)
									@if ($rowqualityBySizeMotive['size'] == $rowqualityByGradeSize['size'])
										<div id="QUALITYBYGRADE{{ $rowqualityBySizeMotive['size'] }}" class="collapse">
											<div class="card-body">
												<h4 class="small font-weight-bold">
													{{ $rowqualityBySizeMotive['motive'] }}<span
														class="float-right">{{ $rowqualityBySizeMotive['hasilPercentPcs'] }}%</span>
												</h4>
												<div class="progress progress-sm">
													<div class="progress-bar <?php echo $rowqualityBySizeMotive['hasilPercentPcs'] >= 80 ? 'bg-success' : ($rowqualityBySizeMotive['hasilPercentPcs'] >= 60 ? 'bg-info' : ($rowqualityBySizeMotive['hasilPercentPcs'] >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar"
														style="width: {{ $rowqualityBySizeMotive['hasilPercentPcs'] }}%"
														aria-valuenow="{{ $rowqualityBySizeMotive['hasilPercentPcs'] }}" aria-valuemin="0" aria-valuemax="100">
													</div>
												</div>
											</div>
										</div>
									@endif
								@endforeach
							</div>
						@endif
					@endforeach
				</div>
			</div>

		</div>

		<h1>HASIL ANALISA KUALITAS TILE</h1>
		<div class="row">
			@if (count($dataAnalisaKualitasTile) > 0)
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
														<h4 class="text-dark small font-weight-bold">
															{{ $rowGroupedPosition['material_desc'] }}
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
																		@if (!empty($rowPosition['no_ph']) && $rowPosition['no_ph'] !== 'null' && $rowPosition['no_ph'] !== '-')
																			PH {{ $rowPosition['no_ph'] }} ➻
																		@endif

																		@if (!empty($rowPosition['no_hd']) && $rowPosition['no_hd'] !== 'null' && $rowPosition['no_hd'] !== '-')
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
			@else
				<div class="col-xl-4 col-lg-4">
					<div class="card shadow mb-4">
						<div class="card-header">
							<h6 class="small font-weight-bold text-primary">HASIL ANALISA KUALITAS SIZE</h6>
						</div>
						<div class="card-header">
							<h6 class="small font
        -weight-bold">Tidak ada data</h6>
						</div>
					</div>
				</div>
			@endif

		</div>

		<h1>CHART ANALISA</h1>
		<div class="row">
			<!-- Area Chart -->
			<div class="col-xl-6 col-lg-6">
				<div class="card shadow mb-4">
					<!-- Card Header - Dropdown -->
					<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
						<h6 class="m-0 font-weight-bold text-primary">Loading RK2</h6>
						<div class="dropdown no-arrow">
							<a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown"
								aria-haspopup="true" aria-expanded="false">
								<i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
							</a>
							<div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
								<div class="dropdown-header">Dropdown Header:</div>
								<a class="dropdown-item" href="#">Action</a>
								<a class="dropdown-item" href="#">Another action</a>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="#">Something else here</a>
							</div>
						</div>
					</div>
					<!-- Card Body -->
					<div class="card-body">
						<div class="line-chart">
							<canvas id="loadingRK2LineChart"></canvas>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-6 col-lg-6">
				<div class="card shadow">
					<!-- Card Header - Dropdown -->
					<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
						<h6 class="m-0 font-weight-bold text-primary">Loading RK4</h6>
					</div>
					<!-- Card Body -->
					<div class="card-body">
						<div class="line-chart">
							<canvas id="loadingRK4LineChart"></canvas>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<!-- Area Chart -->
			<div class="col-xl-6 col-lg-6">
				<div class="card shadow mb-4">
					<!-- Card Header - Dropdown -->
					<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
						<h6 class="m-0 font-weight-bold text-primary">Loading RK5</h6>
					</div>
					<!-- Card Body -->
					<div class="card-body">
						<div class="line-chart">
							<canvas id="loadingRK5LineChart"></canvas>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-6 col-lg-6">
				<div class="card shadow mb-4">
					<!-- Card Header - Dropdown -->
					<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
						<h6 class="m-0 font-weight-bold text-primary">KW 1</h6>
					</div>
					<!-- Card Body -->
					<div class="card-body">
						<div class="line-chart">
							<canvas id="kw1LineChart"></canvas>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<!-- Area Chart -->
			<div class="col-xl-6 col-lg-6">
				<div class="card shadow">
					<!-- Card Header - Dropdown -->
					<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
						<h6 class="m-0 font-weight-bold text-primary">KW 2</h6>
					</div>
					<!-- Card Body -->
					<div class="card-body">
						<div class="line-chart">
							<canvas id="kw2LineChart"></canvas>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-6 col-lg-6">
				<div class="card shadow mb-4">
					<!-- Card Header - Dropdown -->
					<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
						<h6 class="m-0 font-weight-bold text-primary">KW 3</h6>
					</div>
					<!-- Card Body -->
					<div class="card-body">
						<div class="line-chart">
							<canvas id="kw3LineChart"></canvas>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<!-- Area Chart -->
			<div class="col-xl-6 col-lg-6">
				<div class="card shadow mb-4">
					<!-- Card Header - Dropdown -->
					<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
						<h6 class="m-0 font-weight-bold text-primary">KW 4</h6>
					</div>
					<!-- Card Body -->
					<div class="card-body">
						<div class="line-chart">
							<canvas id="kw4LineChart"></canvas>
						</div>
					</div>
				</div>
			</div>
			<div class="col-xl-6 col-lg-6">
				<div class="card shadow">
					<!-- Card Header - Dropdown -->
					<div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
						<h6 class="m-0 font-weight-bold text-primary">BS</h6>
					</div>
					<!-- Card Body -->
					<div class="card-body">
						<div class="line-chart">
							<canvas id="kw5LineChart"></canvas>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Content Row -->
		{{-- <div class="row">

<!-- Content Column -->
<div class="col-lg-6 mb-4">

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">KILN Performance Detail By Size</h6>
    </div>
    <div class="card-body">
        <?php for($i = 0; $i < count($allPerformance); $i++): ?>
            <?php $performance = $allPerformance[$i]; ?>
            <h4 class="small font-weight-bold">{{ $all[$i]->size }} <span class="float-right"><?php echo $performance; ?>%</span></h4>
            <div class="progress mb-4">
                <div class="progress-bar <?php echo $performance >= 80 ? 'bg-success' : ($performance >= 60 ? 'bg-info' : ($performance >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar" style="width: <?php echo $performance; ?>%" aria-valuenow="<?php echo $performance; ?>" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        <?php endfor; ?>
    </div>
</div>
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">KILN Performance Detail By Machine</h6>
    </div>
    <div class="card-body">
        <?php for($i = 0; $i < count($allPerformanceMesin); $i++): ?>
            <?php $performanceMesin = $allPerformanceMesin[$i]; ?>
            <h4 class="small font-weight-bold">{{ $allMesin[$i]->mesin_id }} <span class="float-right"><?php echo $performanceMesin; ?>%</span></h4>
            <div class="progress mb-4">
                <div class="progress-bar <?php echo $performanceMesin >= 80 ? 'bg-success' : ($performanceMesin >= 60 ? 'bg-info' : ($performanceMesin >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar" style="width: <?php echo $performanceMesin; ?>%" aria-valuenow="<?php echo $performanceMesin; ?>" aria-valuemin="0" aria-valuemax="100"></div>
            </div>
        <?php endfor; ?>
    </div>
</div>
</div>

<div class="col-lg-6 mb-4">

<!-- Approach -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Development Approach</h6>
    </div>
    <div class="card-body">
        <p>SB Admin 2 makes extensive use of Bootstrap 4 utility classes in order to reduce
            CSS bloat and poor page performance. Custom CSS classes are used to create
            custom components and custom utility classes.</p>
        <p class="mb-0">Before working with this theme, you should become familiar with the
            Bootstrap framework, especially the utility classes.</p>
    </div>
</div>
</div>
</div> --}}

		<div class="row">
			<div class="col-md-12">
				<button id="start-button" class="btn btn-primary">
					<span id="spinner" class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
					<span id="button-text">Start Import</span>
				</button>
			</div>
		</div>

	</div>
@endsection
<script>
	var periodeReport = <?php echo json_encode($periodeReport); ?>;
	//var week[] = [periodeReport[0]["week"], periodeReport[1]["week"], periodeReport[2]["week"], periodeReport[3]["week"], periodeReport[4]["week"]];
	var hasilKilnByMachineWeek = <?php echo json_encode($hasilKilnByMachineWeek); ?>;
	var hasilSortirWeekReport = <?php echo json_encode($hasilSortirWeekReport); ?>;

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
		const startButton = document.getElementById('start-button');
		const spinner = document.getElementById('spinner');
		const buttonText = document.getElementById('button-text');

		startButton.addEventListener('click', async () => {
			startButton.disabled = true; // Disable the button during the import process
			spinner.classList.remove('d-none'); // Show the spinner
			buttonText.textContent = "Importing..."; // Change the button text

			try {
				await fetch('/api/home/addData', {
					method: 'POST',
					headers: {
						'Content-Type': 'application/json'
					},
					body: JSON.stringify({
						periodeReport
					})
				});
				alert('Import completed successfully!');
			} catch (error) {
				console.error('Error during import:', error);
				alert('An error occurred during the import process.');
			} finally {
				startButton.disabled = false; // Re-enable the button
				spinner.classList.add('d-none'); // Hide the spinner
				buttonText.textContent = "Start Import"; // Reset the button text
			}
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
</style>
