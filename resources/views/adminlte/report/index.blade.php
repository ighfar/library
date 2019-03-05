@extends(env('ADMIN_TEMPLATE').'.layout.base')

@section('title', __('general.title_home', ['field' => $this_label]))
@section('body-class', 'skin-blue sidebar-mini sidebar-collapse')

@section('head')
	@parent
	<meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('content')
	<div class="content-wrapper">
		<!-- Content Header (Page header) -->
		<section class="content-header">
			<h1>
				{{ __('general.title_home', ['field' => $this_label]) }}
			</h1>
			<ol class="breadcrumb">
				<li><a href="<?php echo route('admin') ?>"><i class="fa fa-dashboard"></i> {{ __('general.home') }}</a></li>
				<li><a href="<?php echo route('admin.' . $this_route . '.index') ?>">{{ __('general.purchase') }}</a></li>
				<li class="active">{{ __('general.title_home', ['field' => $this_label]) }}</li>
			</ol>
		</section>

		@include(env('ADMIN_TEMPLATE', 'adminlte').'._component.messages')

		<section class="content container-fluid">
			<div class="row">

				<div class="col-md-4">
					<div class="box box-primary">
						<div class="box-header with-border">
							<h3 class="box-title">{{ __('general.title_home', ['field' => 'Laporan Pembelian']) }}</h3>
						</div>
						<div class="box-body pad">
							{{ Form::open(['route' => ['admin.report.index'], 'method'=>'GET', 'id'=>'form', 'role' => 'form', 'novalidate'=>'novalidate'])  }}

							<div class="row">
								<div class="col-md-6">
									<label for="date_start">{{ __('general.date_start') }}</label>
									<div class="input-group date">
										<div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</div>
										{{ Form::text('date_start', old('date_start'), ['id'=>'date_start', 'class'=>'form-control pull-right datePicker', 'autocomplete'=>'off']) }}
									</div>
								</div>
								<div class="col-md-6">
									<label for="date_end">{{ __('general.date_end') }}</label>
									<div class="input-group date">
										<div class="input-group-addon">
											<i class="fa fa-calendar"></i>
										</div>
										{{ Form::text('date_end', old('date_end'), ['id'=>'date_end', 'class'=>'form-control pull-right datePicker', 'autocomplete'=>'off']) }}
									</div>
								</div>
								<div class="col-md-6">
									<label for="supplier">{{ __('general.judul') }}</label>
									<div class="input-group">
										{{ Form::select('', $list_judul, old('judul'), ['id'=>'buku', 'class'=>'form-control']) }}
									</div>
								</div></div>
		

							<input type="hidden" name="export" value="export_buku_report">
							<br/>
							<button type="submit" class="btn btn-block btn-primary btn-lg">{{ __('Buat') }}</button>
							{{ Form::close() }}
						</div>
					</div>
				</div>
			
			<!-- /.row -->
		</section>
	</div>
@stop

@section('script-bottom')
	@parent
	<script>
		$('.datePicker').datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true,
			orientation: "bottom auto"
		});
	</script>
@stop