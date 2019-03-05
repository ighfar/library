<?php
$add_attribute = [
];
?>
@extends(env('ADMIN_TEMPLATE').'.layout.base')

@section('title', __('general.title_edit', ['field' => $this_label]))
@section('body-class', 'skin-blue sidebar-mini sidebar-collapse')

@section('css')
    @parent
@stop

@section('script-top')
    @parent
@stop

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ __('general.title_edit', ['field' => $this_label]) }}
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo route('admin') ?>"><i class="fa fa-dashboard"></i> {{ __('general.home') }}</a></li>
                <li class="active">{{ __('general.title_edit', ['field' => $this_label]) }}</li>
            </ol>
        </section>

        @include(env('ADMIN_TEMPLATE', 'adminlte').'._component.messages')

        <!-- Main content -->
        <section class="content">

            <div class="row">

                <div class="col-md-12">

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{ __('general.title_edit', ['field' => $this_label . ' ' . $data->name]) }}</h3>
                        </div>

                        {{ Form::open(['route' => ['admin.post_password'], 'id'=>'form', 'role' => 'form', 'novalidate'=>'novalidate'])  }}
                        <div class="box-body">

                            @foreach($passing as $field_name => $field_data)
                                @php
                                    $field_value = isset($data->$field_name) ? $data->$field_name : null;
                                    $list_passing = ['field_name' => $field_name, 'field_value' => $field_value, 'field_lang' => $field_data->lang, 'field_message'=>$field_data->field_message, 'add_attribute'=>$add_attribute];
                                    if (in_array($field_data->type, ['select', 'select2'])) {
                                        $array_passing = ['list_field_name' => $set_list[$field_name]];
                                        $list_passing = array_merge($list_passing, $array_passing);
                                    }
                                @endphp
                                @component(env('ADMIN_TEMPLATE').'._component.form.'.$field_data->type, $list_passing)
                                @endcomponent
                            @endforeach

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            <button type="submit" class="btn btn-primary" title="{{ __('general.save') }}"><i class="fa fa-fw fa-save"></i><span class="hidden-sm">{{ __('general.save') }}</span></button>
                            <a href="<?php echo route('admin.profile') ?>" class="btn btn-info" title="{{ __('general.back') }}"><i class="fa fa-fw fa-arrow-circle-o-left"></i><span class="hidden-sm">{{ __('general.back') }}</span></a>
                        </div>
                        {{ Form::close() }}
                    </div>
                    <!-- /.box -->

                </div>

            </div>

        </section>
        <!-- /.content -->
    </div>
@stop