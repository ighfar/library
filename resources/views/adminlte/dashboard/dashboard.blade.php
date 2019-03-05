<?php
$add_attribute = [];
?>
@extends(env('ADMIN_TEMPLATE').'.layout.base')

@section('title', __('general.dashboard'))
@section('body-class', 'skin-blue sidebar-mini sidebar-collapse')

@section('css')
    @parent
    <link rel="stylesheet" href="{{ asset('css/morris.css') }}">
@show

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>
                @lang('general.dashboard')
            </h1>
            <ol class="breadcrumb">
                <li><i class="fa fa-dashboard"></i> {{ __('general.home') }}</li>
            </ol>
        </section>

    @include(env('ADMIN_TEMPLATE', 'adminlte').'._component.messages')

    <!-- Main content -->
        <section class="content container-fluid">
            <div class="row">
                <div class="col-lg-12 col-xs-12">
                    Dashboard
                </div>
            </div>
        </section>
    <!-- /.content -->
    </div>
@stop

@section('script-bottom')
    @parent
@stop