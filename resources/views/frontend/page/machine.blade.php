@extends('layout.WebLayout')

@section('title', __('machine.page_title'))

@section('content')
    @include('layout.partials.navbar')

    <!-- breadcrumb-area start -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="row breadcrumb_box  align-items-center">
                        <div class="col-lg-6 col-md-6 col-sm-12 text-center text-md-start">
                            <h2 class="breadcrumb-title">{{ __('machine.breadcrumb_title') }}</h2>
                        </div>
                        <div class="col-lg-6  col-md-6 col-sm-12">
                            <!-- breadcrumb-list start -->
                            <ul class="breadcrumb-list text-center text-md-end">
                                <li class="breadcrumb-item"><a href="/">{{ __('machine.breadcrumb_home') }}</a></li>
                               <li class="breadcrumb-item">{{ __('machine.breadcrumb_machine') }}</li>
                            </ul>
                            <!-- breadcrumb-list end -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Shop Category pages -->
    <div class="shop-category-area pb-100px pt-70px">
        <div class="container">
            <div class="row">
                <div class="col-lg-12  col-md-12">
                   {{-- !-- Shop Bottom Area Start --> --}}
                    <div class="shop-bottom-area">
                        <div class="row">
                                @foreach($machine as $item)
                                    <div class="col-lg-4 col-md-6 col-sm-6 col-6 mb-20px" data-aos="fade-up">
                                        <div class="product">
                                            <div class="thumb">
                                                <a href="#" class="image">
                                                    <img src="{{ asset('storage/machine_picture/' . $item->image_url) }}"
                                                         alt="{{ $item->title }}"
                                                         loading="lazy" width="600" height="338" />
                                                </a>
                                            </div>
                                            <div class="content">
                                                <h5 class="title"><a href="#">{{ $item->title }}</a></h5>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                {{-- {{ $machine->withQueryString()->links('vendor.pagination.bootstrap-5') }} --}}
                            
                        </div>
                    </div>
                    <!-- Shop Bottom Area End --> 
                   
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Shop Category pages -->
@endsection