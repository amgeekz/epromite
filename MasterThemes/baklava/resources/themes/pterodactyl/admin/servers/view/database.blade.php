{{-- Pterodactyl - Panel --}}
{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- This software is licensed under the terms of the MIT license. --}}
{{-- https://opensource.org/licenses/MIT --}}
@extends('layouts.admin')

@section('title')
    Server — {{ $server->name }}: Databases
@endsection

@section('content-header')
    <h1>{{ $server->name }}<small>Manage server databases.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li><a href="{{ route('admin.servers') }}">Servers</a></li>
        <li><a href="{{ route('admin.servers.view', $server->id) }}">{{ $server->name }}</a></li>
        <li class="active">Databases</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-md-12 mb-2">
        <a class="btn btn-md btn-primary" href="{{ route('admin.servers.view', $server->id) }}">About</a>
        @if($server->installed === 1)
            <a class="btn btn-md btn-primary" href="{{ route('admin.servers.view.details', $server->id) }}">Details</a>
            <a class="btn btn-md btn-primary" href="{{ route('admin.servers.view.build', $server->id) }}">Build Configuration</a>
            <a class="btn btn-md btn-primary" href="{{ route('admin.servers.view.startup', $server->id) }}">Startup</a>
            <a class="btn btn-md btn-info" href="{{ route('admin.servers.view.database', $server->id) }}">Database</a>
            <a class="btn btn-md btn-primary" href="{{ route('admin.servers.view.manage', $server->id) }}">Manage</a>
        @endif
        <a class="btn btn-md btn-danger" href="{{ route('admin.servers.view.delete', $server->id) }}">Delete</a>
        <a class="btn btn-md btn-success" href="{{ route('server.index', $server->uuidShort) }}"><i class="feather icon-external-link"></i></a>
    </div>
</div>
<div class="row">
    <div class="col-sm-7">
        <div class="alert alert-info p-2">
            Database passwords can be viewed when <a href="{{ route('server.databases.index', ['server' => $server->uuidShort]) }}">visiting this server</a> on the front-end.
        </div>
        <div class="card card-primary">
            <div class="card-header with-border">
                <h3 class="card-title">Active Databases</h3>
            </div>
            <div class="card-body table-responsible no-padding">
                <table class="table table-hover">
                    <tr>
                        <th>Database</th>
                        <th>Username</th>
                        <th>Connections From</th>
                        <th>Host</th>
                        <th></th>
                    </tr>
                    @foreach($server->databases as $database)
                        <tr>
                            <td>{{ $database->database }}</td>
                            <td>{{ $database->username }}</td>
                            <td>{{ $database->remote }}</td>
                            <td><code>{{ $database->host->host }}:{{ $database->host->port }}</code></td>
                            <td class="text-center">
                                <button data-action="reset-password" data-id="{{ $database->id }}" class="btn btn-sm btn-primary"><i class="fa fa-refresh"></i></button>
                                <button data-action="remove" data-id="{{ $database->id }}" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="col-sm-5">
        <div class="card card-success">
            <div class="card-header with-border">
                <h3 class="card-title">Create New Database</h3>
            </div>
            <form action="{{ route('admin.servers.view.database', $server->id) }}" method="POST">
                <div class="card-body">
                    <div class="form-group">
                        <label for="pDatabaseHostId" class="control-label">Database Host</label>
                        <select id="pDatabaseHostId" name="database_host_id" class="form-control">
                            @foreach($hosts as $host)
                                <option value="{{ $host->id }}">{{ $host->name }}</option>
                            @endforeach
                        </select>
                        <p class="text-muted small">Select the host database server that this database should be created on.</p>
                    </div>
                    <div class="form-group">
                        <label for="pDatabaseName" class="control-label">Database</label>
                        <div class="input-group">
                            <span class="input-group-addon">s{{ $server->id }}_</span>
                            <input id="pDatabaseName" type="text" name="database" class="form-control" placeholder="database" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pRemote" class="control-label">Connections</label>
                        <input id="pRemote" type="text" name="remote" class="form-control" value="%" />
                        <p class="text-muted small">This should reflect the IP address that connections are allowed from. Uses standard MySQL notation. If unsure leave as <code>%</code>.</p>
                    </div>
                </div>
                <div class="card-footer">
                    {!! csrf_field() !!}
                    <p class="text-muted small no-margin">A username and password for this database will be randomly generated after form submission.</p>
                    <input type="submit" class="btn btn-md btn-success pull-right mb-2" value="Create Database" />
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('footer-scripts')
    @parent
    <script>
    $('#pDatabaseHost').select2();
    $('[data-action="remove"]').click(function (event) {
        event.preventDefault();
        var self = $(this);
        swal({
            title: '',
            type: 'warning',
            text: 'Are you sure that you want to delete this database? There is no going back, all data will immediately be removed.',
            showCancelButton: true,
            confirmButtonText: 'Delete',
            confirmButtonColor: '#d9534f',
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        }, function () {
            $.ajax({
                method: 'DELETE',
                url: Router.route('admin.servers.view.database.delete', { server: '{{ $server->id }}', database: self.data('id') }),
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
            }).done(function () {
                self.parent().parent().slideUp();
                swal.close();
            }).fail(function (jqXHR) {
                console.error(jqXHR);
                swal({
                    type: 'error',
                    title: 'Whoops!',
                    text: (typeof jqXHR.responseJSON.error !== 'undefined') ? jqXHR.responseJSON.error : 'An error occurred while processing this request.'
                });
            });
        });
    });
    $('[data-action="reset-password"]').click(function (e) {
        e.preventDefault();
        var block = $(this);
        $(this).addClass('disabled').find('i').addClass('fa-spin');
        $.ajax({
            type: 'PATCH',
            url: Router.route('admin.servers.view.database', { server: '{{ $server->id }}' }),
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
            data: { database: $(this).data('id') },
        }).done(function (data) {
            swal({
                type: 'success',
                title: '',
                text: 'The password for this database has been reset.',
            });
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.error(jqXHR);
            var error = 'An error occurred while trying to process this request.';
            if (typeof jqXHR.responseJSON !== 'undefined' && typeof jqXHR.responseJSON.error !== 'undefined') {
                error = jqXHR.responseJSON.error;
            }
            swal({
                type: 'error',
                title: 'Whoops!',
                text: error
            });
        }).always(function () {
            block.removeClass('disabled').find('i').removeClass('fa-spin');
        });
    });
    </script>
@endsection
