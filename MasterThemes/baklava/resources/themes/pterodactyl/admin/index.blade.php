{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    Administration
@endsection

@section('content-header')
    <h1>Administrative Overview<small>A quick glance at your system.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li class="active">Index</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card
            @if($version->isLatestPanel())
                card-success
            @else
                card-danger
            @endif
        ">
            <div class="card-header with-border">
                <h3 class="card-title">System Information</h3>
            </div>
            <div class="card-body">
                @if ($version->isLatestPanel())
                    You are running Pterodactyl Panel version <code>{{ config('app.version') }}</code>. Your panel is up-to-date!
                @else
                    Your panel is <strong>not up-to-date!</strong> The latest version is <a href="https://github.com/Pterodactyl/Panel/releases/v{{ $version->getPanel() }}" target="_blank"><code>{{ $version->getPanel() }}</code></a> and you are currently running version <code>{{ config('app.version') }}</code>.
                @endif

                <div class="row mt-2">
                    <div class="col-xs-6 col-sm-3 text-center">
                        <a href="{{ $version->getDiscord() }}"><button class="btn btn-warning" style="width:100%;"><i class="fa fa-fw fa-support"></i> Get Help <small>(via Discord)</small></button></a>
                    </div>
                    <div class="col-xs-6 col-sm-3 text-center">
                        <a href="https://pterodactyl.io/project/introduction.html"><button class="btn btn-primary" style="width:100%;"><i class="fa fa-fw fa-link"></i> Documentation</button></a>
                    </div>
                    <div class="col-xs-6 col-sm-3 text-center">
                        <a href="https://github.com/Pterodactyl/Panel"><button class="btn btn-primary" style="width:100%;"><i class="fa fa-fw fa-support"></i> Github</button></a>
                    </div>
                    <div class="col-xs-6 col-sm-3 text-center">
                        <a href="https://www.paypal.me/PterodactylSoftware"><button class="btn btn-success" style="width:100%;"><i class="fa fa-fw fa-money"></i> Support the Project</button></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
