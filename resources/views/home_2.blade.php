@extends('layouts.master')

@section('content')
<div class="container-fluid">
    {{-- <div class="row">
        <div class="col-md-12">
            <a href="{{ route('add') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Add Data
            </a>
        </div>
    </div> --}}
    <!-- Content Row -->
    {{-- <div class="row">

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Availability
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">100%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: 100%" aria-valuenow="100"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-cogs fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Performance
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $performanceMesin }}%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: {{ $performanceMesin }}%" aria-valuenow="{{ $performanceMesin }}"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Quality
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $quality }}%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: {{ $quality }}%" aria-valuenow="{{ $quality }}"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">OEE
                            </div>
                            <div class="row no-gutters align-items-center">
                                <div class="col-auto">
                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ $oee }}%</div>
                                </div>
                                <div class="col">
                                    <div class="progress progress-sm mr-2">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: {{ $oee }}%" aria-valuenow="{{ $oee }}"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
{{--
    <!-- Content Row -->

    <div class="row">

        <!-- Area Chart -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Earnings Overview</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
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
                    <div class="chart-area">
                        <canvas id="myAreaChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div
                    class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Revenue Sources</h6>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                            aria-labelledby="dropdownMenuLink">
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
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="myPieChart"></canvas>
                    </div>
                    <div class="mt-4 text-center small">
                        <span class="mr-2">
                            <i class="fas fa-circle text-primary"></i> Direct
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-success"></i> Social
                        </span>
                        <span class="mr-2">
                            <i class="fas fa-circle text-info"></i> Referral
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <!-- Content Row -->
    <div class="row">

        <!-- Content Column -->
        <div class="col-lg-6 mb-4">
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3" data-toggle="collapse" data-target="#gl1Detail">
                            <h4 class="small font-weight-bold">GL 1 <span class="float-right"><?php echo $performance; ?>%</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar <?php echo $performance >= 80 ? 'bg-success' : ($performance >= 60 ? 'bg-info' : ($performance >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar" style="width: <?php echo $performance; ?>%" aria-valuenow="<?php echo $performance; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div id="gl1Detail" class="collapse">
                            <div class="card-body">
                                <?php for($i = 0; $i < count($detailPerformanceSize); $i++): ?>
                                <?php $performance = $detailPerformanceSize[$i]; ?>
                                <div style="margin-left: 1.5rem;">
                                    <h4 class="small font-weight-bold">{{ $all[$i]->size }} <span class="float-right"><?php echo $performance; ?>%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar <?php echo $performance >= 80 ? 'bg-success' : ($performance >= 60 ? 'bg-info' : ($performance >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar" style="width: <?php echo $performance; ?>%" aria-valuenow="<?php echo $performance; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3" data-toggle="collapse" data-target="#gl2Detail">
                            <h4 class="small font-weight-bold">GL 2 <span class="float-right"><?php echo $performance; ?>%</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar <?php echo $performance >= 80 ? 'bg-success' : ($performance >= 60 ? 'bg-info' : ($performance >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar" style="width: <?php echo $performance; ?>%" aria-valuenow="<?php echo $performance; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div id="gl2Detail" class="collapse">
                            <div class="card-body">
                                <?php for($i = 0; $i < count($detailPerformanceSize); $i++): ?>
                                <?php $performance = $detailPerformanceSize[$i]; ?>
                                <div style="margin-left: 1.5rem;">
                                    <h4 class="small font-weight-bold">{{ $all[$i]->size }} <span class="float-right"><?php echo $performance; ?>%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar <?php echo $performance >= 80 ? 'bg-success' : ($performance >= 60 ? 'bg-info' : ($performance >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar" style="width: <?php echo $performance; ?>%" aria-valuenow="<?php echo $performance; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3" data-toggle="collapse" data-target="#gl3Detail">
                            <h4 class="small font-weight-bold">GL 3 <span class="float-right"><?php echo $performance; ?>%</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar <?php echo $performance >= 80 ? 'bg-success' : ($performance >= 60 ? 'bg-info' : ($performance >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar" style="width: <?php echo $performance; ?>%" aria-valuenow="<?php echo $performance; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div id="gl3Detail" class="collapse">
                            <div class="card-body">
                                <?php for($i = 0; $i < count($detailPerformanceSize); $i++): ?>
                                <?php $performance = $detailPerformanceSize[$i]; ?>
                                <div style="margin-left: 1.5rem;">
                                    <h4 class="small font-weight-bold">{{ $all[$i]->size }} <span class="float-right"><?php echo $performance; ?>%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar <?php echo $performance >= 80 ? 'bg-success' : ($performance >= 60 ? 'bg-info' : ($performance >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar" style="width: <?php echo $performance; ?>%" aria-valuenow="<?php echo $performance; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3" data-toggle="collapse" data-target="#gl4Detail">
                            <h4 class="small font-weight-bold">GL 4 <span class="float-right"><?php echo $performance; ?>%</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar <?php echo $performance >= 80 ? 'bg-success' : ($performance >= 60 ? 'bg-info' : ($performance >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar" style="width: <?php echo $performance; ?>%" aria-valuenow="<?php echo $performance; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div id="gl4Detail" class="collapse">
                            <div class="card-body">
                                <?php for($i = 0; $i < count($detailPerformanceSize); $i++): ?>
                                <?php $performance = $detailPerformanceSize[$i]; ?>
                                <div style="margin-left: 1.5rem;">
                                    <h4 class="small font-weight-bold">{{ $all[$i]->size }} <span class="float-right"><?php echo $performance; ?>%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar <?php echo $performance >= 80 ? 'bg-success' : ($performance >= 60 ? 'bg-info' : ($performance >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar" style="width: <?php echo $performance; ?>%" aria-valuenow="<?php echo $performance; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3" data-toggle="collapse" data-target="#gl5Detail">
                            <h4 class="small font-weight-bold">GL 5 <span class="float-right"><?php echo $performance; ?>%</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar <?php echo $performance >= 80 ? 'bg-success' : ($performance >= 60 ? 'bg-info' : ($performance >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar" style="width: <?php echo $performance; ?>%" aria-valuenow="<?php echo $performance; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div id="gl5Detail" class="collapse">
                            <div class="card-body">
                                <?php for($i = 0; $i < count($detailPerformanceSize); $i++): ?>
                                <?php $performance = $detailPerformanceSize[$i]; ?>
                                <div style="margin-left: 1.5rem;">
                                    <h4 class="small font-weight-bold">{{ $all[$i]->size }} <span class="float-right"><?php echo $performance; ?>%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar <?php echo $performance >= 80 ? 'bg-success' : ($performance >= 60 ? 'bg-info' : ($performance >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar" style="width: <?php echo $performance; ?>%" aria-valuenow="<?php echo $performance; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-6 mb-4">
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3" data-toggle="collapse" data-target="#rk1Detail">
                            <h4 class="small font-weight-bold">RK 1 <span class="float-right"><?php echo $detailPerformanceMesin[0]; ?>%</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar <?php echo $detailPerformanceMesin[0] >= 80 ? 'bg-success' : ($detailPerformanceMesin[0] >= 60 ? 'bg-info' : ($detailPerformanceMesin[0] >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar" style="width: <?php echo $detailPerformanceMesin[0]; ?>%" aria-valuenow="<?php echo $detailPerformanceMesin[0]; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div id="rk1Detail" class="collapse">
                            <div class="card-body">
                                <?php if (!empty($detailPerformanceSize[0])): ?>
                                <?php for($i = 0; $i < count($detailPerformanceSize[0]->size); $i++): ?>
                                    <h4 class="small font-weight-bold">{{ $detailPerformanceSize[0]->size[$i] }} <span class="float-right"><?php echo $detailPerformanceSize[0]->performance[$i]; ?>%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar <?php echo $detailPerformanceSize[0]->performance[$i] >= 80 ? 'bg-success' : ($detailPerformanceSize[0]->performance[$i] >= 60 ? 'bg-info' : ($detailPerformanceSize[0]->performance[$i] >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar" style="width: <?php echo $detailPerformanceSize[0]->performance[$i]; ?>%" aria-valuenow="<?php echo $detailPerformanceSize[0]->performance[$i]; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                <?php endfor; ?>
                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3" data-toggle="collapse" data-target="#rk2Detail">
                            <h4 class="small font-weight-bold">RK 2 <span class="float-right"><?php echo $detailPerformanceMesin[1]; ?>%</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar <?php echo $detailPerformanceMesin[1] >= 80 ? 'bg-success' : ($detailPerformanceMesin[1] >= 60 ? 'bg-info' : ($detailPerformanceMesin[1] >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar" style="width: <?php echo $detailPerformanceMesin[1]; ?>%" aria-valuenow="<?php echo $detailPerformanceMesin[1]; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div id="rk2Detail" class="collapse">
                            <div class="card-body">
                                <?php if (!empty($detailPerformanceSize[1])): ?>
                                <?php for($i = 0; $i < count($detailPerformanceSize[1]->size); $i++): ?>
                                    <h4 class="small font-weight-bold">{{ $detailPerformanceSize[1]->size[$i] }} <span class="float-right"><?php echo $detailPerformanceSize[1]->performance[$i]; ?>%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar <?php echo $detailPerformanceSize[1]->performance[$i] >= 80 ? 'bg-success' : ($detailPerformanceSize[1]->performance[$i] >= 60 ? 'bg-info' : ($detailPerformanceSize[1]->performance[$i] >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar" style="width: <?php echo $detailPerformanceSize[1]->performance[$i]; ?>%" aria-valuenow="<?php echo $detailPerformanceSize[1]->performance[$i]; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                <?php endfor; ?>
                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3" data-toggle="collapse" data-target="#rk3Detail">
                            <h4 class="small font-weight-bold">RK 3 <span class="float-right"><?php echo $detailPerformanceMesin[2]; ?>%</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar <?php echo $detailPerformanceMesin[2] >= 80 ? 'bg-success' : ($detailPerformanceMesin[2] >= 60 ? 'bg-info' : ($detailPerformanceMesin[2] >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar" style="width: <?php echo $detailPerformanceMesin[2]; ?>%" aria-valuenow="<?php echo $detailPerformanceMesin[2]; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div id="rk3Detail" class="collapse">
                            <div class="card-body">
                                <?php if (!empty($detailPerformanceSize[2])): ?>
                                <?php for($i = 0; $i < count($detailPerformanceSize[2]->size); $i++): ?>
                                    <h4 class="small font-weight-bold">{{ $detailPerformanceSize[2]->size[$i] }} <span class="float-right"><?php echo $detailPerformanceSize[2]->performance[$i]; ?>%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar <?php echo $detailPerformanceSize[2]->performance[$i] >= 80 ? 'bg-success' : ($detailPerformanceSize[2]->performance[$i] >= 60 ? 'bg-info' : ($detailPerformanceSize[2]->performance[$i] >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar" style="width: <?php echo $detailPerformanceSize[2]->performance[$i]; ?>%" aria-valuenow="<?php echo $detailPerformanceSize[2]->performance[$i]; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                <?php endfor; ?>
                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3" data-toggle="collapse" data-target="#rk4Detail">
                            <h4 class="small font-weight-bold">RK 4 <span class="float-right"><?php echo $detailPerformanceMesin[3]; ?>%</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar <?php echo $detailPerformanceMesin[3] >= 80 ? 'bg-success' : ($detailPerformanceMesin[3] >= 60 ? 'bg-info' : ($detailPerformanceMesin[3] >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar" style="width: <?php echo $detailPerformanceMesin[3]; ?>%" aria-valuenow="<?php echo $detailPerformanceMesin[3]; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div id="rk4Detail" class="collapse">
                            <div class="card-body">
                                <?php if (!empty($detailPerformanceSize[3])): ?>
                                <?php for($i = 0; $i < count($detailPerformanceSize[3]->size); $i++): ?>
                                    <h4 class="small font-weight-bold">{{ $detailPerformanceSize[3]->size[$i] }} <span class="float-right"><?php echo $detailPerformanceSize[3]->performance[$i]; ?>%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar <?php echo $detailPerformanceSize[3]->performance[$i] >= 80 ? 'bg-success' : ($detailPerformanceSize[3]->performance[$i] >= 60 ? 'bg-info' : ($detailPerformanceSize[3]->performance[$i] >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar" style="width: <?php echo $detailPerformanceSize[3]->performance[$i]; ?>%" aria-valuenow="<?php echo $detailPerformanceSize[3]->performance[$i]; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                <?php endfor; ?>
                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3" data-toggle="collapse" data-target="#rk5Detail">
                            <h4 class="small font-weight-bold">RK 5 <span class="float-right"><?php echo $detailPerformanceMesin[4]; ?>%</span></h4>
                            <div class="progress mb-4">
                                <div class="progress-bar <?php echo $detailPerformanceMesin[4] >= 80 ? 'bg-success' : ($detailPerformanceMesin[4] >= 60 ? 'bg-info' : ($detailPerformanceMesin[4] >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar" style="width: <?php echo $detailPerformanceMesin[4]; ?>%" aria-valuenow="<?php echo $detailPerformanceMesin[4]; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                        <div id="rk5Detail" class="collapse">
                            <div class="card-body">
                                <?php if (!empty($detailPerformanceSize[4])): ?>
                                <?php for($i = 0; $i < count($detailPerformanceSize[4]->size); $i++): ?>
                                    <h4 class="small font-weight-bold">{{ $detailPerformanceSize[4]->size[$i] }} <span class="float-right"><?php echo $detailPerformanceSize[4]->performance[$i]; ?>%</span></h4>
                                    <div class="progress mb-4">
                                        <div class="progress-bar <?php echo $detailPerformanceSize[4]->performance[$i] >= 80 ? 'bg-success' : ($detailPerformanceSize[4]->performance[$i] >= 60 ? 'bg-info' : ($detailPerformanceSize[4]->performance[$i] >= 40 ? 'bg-warning' : 'bg-danger')); ?>" role="progressbar" style="width: <?php echo $detailPerformanceSize[4]->performance[$i]; ?>%" aria-valuenow="<?php echo $detailPerformanceSize[4]->performance[$i]; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                <?php endfor; ?>
                            <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12 mb-4">

            <!-- Illustrations -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Milan Ceramic Tiles</h6>
                </div>
                <div class="card-body">
                    <div class="text-center">
                        <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;"
                            src="images/home.jpeg" alt="...">
                    </div>
                    <p>In 1991, Milan Ceramics Tile was established by PT. Wings Surya, well-known brand for consumer goods, under the name of PT. Adyabuana Persada which located in Surabaya. In 1997, as market demand increases, a new plant was founded under the name of PT. Saranagriya Lestari Keramik and was built in Eastern Jakarta. Mainly focused on producing high quality tiles and fulfilling the demand for ceramic tile nationally is our global manufacture goal with total production capacity of more than 24,000,000 m2 per year.
                        PT. Adyabuana Persada and PT. Saranagriya Lestari Keramik have very well-known brands namely Milan Ceramics Tile, Habitat, Habitat Gress and Herkules. We produce floor and wall tiles with nearly 1,000 motives in various sizes, surfaces, and styles. This complete variety will make it easier for you to choose and find the combination that suit your taste and personality. All Milan Ceramics Tile products are manufactured using the latest technology and the best materials from both domestic and international.</p>
                    <a target="_blank" rel="nofollow" href="https://www.milantiles.com/">Milan Ceramic Official &rarr;</a>
                </div>
            </div>

            {{-- <!-- Approach -->
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
            </div> --}}

        </div>

    </div>

</div>
@endsection
