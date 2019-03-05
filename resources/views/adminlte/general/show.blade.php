<?php
$add_attribute = [
    'disabled' => 'disabled'
];
?>
@extends(env('ADMIN_TEMPLATE').'.layout.base')

@section('title', __('general.title_show', ['field' => $this_label]))
@section('body-class', 'skin-blue sidebar-mini sidebar-collapse')

@section('head')
    @parent
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('script-top')
    @parent
    <script>
        CKEDITOR_BASEPATH = '/js/ckeditor/';
    </script>
@stop

@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ __('general.title_show', ['field' => $this_label]) }}
            </h1>
            <ol class="breadcrumb">
                <li><a href="<?php echo route('admin') ?>"><i class="fa fa-dashboard"></i> {{ __('general.home') }}</a></li>
                <li><a href="<?php echo route('admin.' . $this_route . '.index') ?>"> {{ __('general.title_home', ['field' => $this_label]) }}</a></li>
                <li class="active">{{ __('general.title_show', ['field' => $this_label]) }}</li>
            </ol>
        </section>

        @include(env('ADMIN_TEMPLATE', 'adminlte').'._component.messages')

        <!-- Main content -->
        <section class="content">

            <div class="row">

                <div class="col-md-12">

                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">{{ __('general.title_show', ['field' => $this_label]) }}</h3>
                        </div>

                        {{ Form::open(['id'=>'form', 'role' => 'form', 'novalidate'=>'novalidate'])  }}
                        <div class="box-body">

                            @foreach($passing as $field_name => $field_data)
                                @php
                                    $list_passing = ['field_name' => $field_name, 'field_value' => isset($data->$field_name) ? $data->$field_name : null, 'field_lang' => $field_data->lang, 'field_message'=>$field_data->field_message, 'add_attribute'=>$add_attribute, 'show'=>1];
                                    if (in_array($field_data->type, ['select', 'select2'])) {
                                        $list_passing['list_field_name'] = $set_list[$field_name];
                                    }
                                    else if (in_array($field_data->type, ['image', 'video'])) {
                                        $list_passing['path'] = substr($field_data->path, 2);
                                    }
                                @endphp
                                @component(env('ADMIN_TEMPLATE').'._component.form.'.$field_data->type, $list_passing)
                                @endcomponent
                            @endforeach

                        </div>
                        <!-- /.box-body -->

                        <div class="box-footer">
                            @if ($permission['edit'])
                            <a href="<?php echo route('admin.' . $this_route . '.edit', $id) ?>" class="btn btn-primary" title="{{ __('general.edit') }}"><i class="fa fa-fw fa-pencil"></i><span class="hidden-sm">{{ __('general.edit') }}</span></a>
                            @endif
                            <a href="<?php echo route('admin.' . $this_route . '.index') ?>" class="btn btn-info" title="{{ __('general.back') }}"><i class="fa fa-fw fa-arrow-circle-o-left"></i><span class="hidden-sm">{{ __('general.back') }}</span></a>
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

@section('script-bottom')
    @parent
    <script>
        $(document).ready(function() {
            $('.ckEditor').each(function(i, item) {
                var editor = CKEDITOR.replace(item.id, {
                    autoParagraph: false,
                    extraAllowedContent: '*(*);*{*};div(class);span(class)',
                    extraPlugins: 'justify,format,colorbutton,font,smiley',
                });
                editor.setReadOnly( true);
            });
        });
    </script>
@stop