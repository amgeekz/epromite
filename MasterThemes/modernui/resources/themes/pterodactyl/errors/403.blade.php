{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.error')

@section('title')
    @lang('base.errors.403.header')
@endsection

@section('content-header')
@endsection

@section('content')
    <div class="flex-grow-1 w-100 d-flex align-items-center">
        <div class="col-lg-4 px-4 px-lg-0 mx-auto text-center text-black">
            <img src="/themes/pterodactyl/theme/img/illustrations/505.svg" class="w-50 mx-auto d-block my-5 img-fluid"
                 alt="">

            <h1 class="display-1 mb-3 px-4 font-weight-bold">
                403 Forbidden
            </h1>
            <h3 class="font-size-xxl line-height-sm font-weight-light d-block px-3 mb-3 text-black-50">
                Something is broken.
            </h3>
            <p>
                @lang('base.errors.403.desc')
            </p>
        </div>
    </div>
@endsection
