@extends('backend.layout.template')
@section('content')
    <div class="pcoded-main-container">
        <div class="pcoded-wrapper">
            <div class="pcoded-content">
                <div class="pcoded-inner-content">
                    <div class="main-body">
                        <div class="page-wrapper">
                            <!-- [ breadcrumb ] start -->
                            <div class="page-header">
                                <div class="page-block">
                                    <div class="row align-items-center">
                                        <div class="col-md-12">
                                            <div class="page-header-title">
                                                <h5>Home</h5>
                                            </div>
                                            <ul class="breadcrumb">
                                                <li class="breadcrumb-item"><a href="index.html"><i
                                                            class="feather icon-home"></i></a></li>
                                                <li class="breadcrumb-item"><a href="#!">Analytics Dashboard</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- [ breadcrumb ] end -->
                            <!-- [ Main Content ] start -->
                            <div class="row">
                                <div class="card">
                                    <div class="card-header">
                                        <h3>Click Counts</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 mb-5">
                                                <div id="click-counts" style="width: 100%; height: 400px;"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <a href="#detailed-table">
                                                    <div class="btn btn-primary">
                                                        <span >Lihat Selengkapnya</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="card">
                                    <div class="card-header">
                                        <h3>Order Click Counts</h3>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12 mb-5">
                                                <div id="order-click-counts" style="height: 400px"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer text-center">
                                        <div class="row align-items-center">
                                            <div class="col">
                                                <a href="#order-detailed-table">
                                                    <div class="btn btn-primary">
                                                        <span >Lihat Selengkapnya</span>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card bg-c-green order-card">
                                            <div class="card-body">
                                                <h6 class="m-b-20">Total Product</h6>
                                                <h2 class="text-start"><span>{{ $totalProduct }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card bg-c-blue order-card">
                                            <div class="card-body">
                                                <h6 class="m-b-20">Total Partner</h6>
                                                <h2 class="text-start"><span>{{ $totalPartner }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card" id="detailed-table">
                                        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center">
                                            <h4>Product Click Count Page Table</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="dt-responsive table-responsive">
                                                <table id="simpletable" class="table table-striped table-bordered nowrap">
                                                    <thead>
                                                        <tr>
                                                            <th>Product Name</th>
                                                            <th>Product Click</th>
                                                            <th>Order Click</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach ($products as $product)
                                                            <tr>
                                                                <td>{{ $product->name }}</td>
                                                                <td>{{ $product->click_count }}</td>
                                                                <td>{{ $product->order_click_count }}</td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
@endsection

@section('scripts')
            <script>
                window.chartData = {
                    "name": "Product Types",
                    "children": @json($clickCount->map(function ($type) {
        return [
            'type' => $type->name,
            'clicks' => $type->total_clicks
        ];
    }))
                }
            </script>

            <script>
                window.orderChartData = {
                    "name": "Product Types for Order",
                    "children": @json($orderClickCount->map(function ($type) {
        return [
            'type' => $type->name,
            'clicks' => $type->total_clicks
        ];
    }))
                }
            </script>

            {{-- <script src="{{asset('backend/plugins/chart-am4/js/charts.js')}}"></script> --}}
            <script src="{{ asset('backend/plugins/chart-highchart/js/highcharts.js') }}"></script>
            {{-- <script src="{{asset('backend/js/pages/chart-am.js')}}"></script> --}}
            <script src="{{asset('backend/js/pages/chart-highchart-custom.js')}}"></script>
@endsection