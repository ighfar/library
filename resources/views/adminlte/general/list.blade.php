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
                <li class="active">{{ __('general.title_home', ['field' => $this_label]) }}</li>
            </ol>
        </section>

        @include(env('ADMIN_TEMPLATE', 'adminlte').'._component.messages')

        <section class="content">
            <div class="row">
                <div class="col-xs-12">

                    <div class="box">

                        @if ($permission['create'])
                        <div class="box-header">
                            <a href="<?php echo route('admin.' . $this_route . '.create') ?>" class="btn btn-success" title="{{ __('general.create') }}"><i class="fa fa-fw fa-plus-square-o"></i><span class="hidden-sm">{{ __('general.create') }}</span></a>
                        </div>
                        <!-- /.box-header -->
                        @endif

                        <div class="box-body">
                            <table id="data1" class="table table-bordered table-striped">
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                    <!-- /.box -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>

    </div>
@stop

@section('script-bottom')
    @parent
    <script>
        var table;
        table = jQuery('#data1').DataTable({
            serverSide: true,
            processing: true,
            autoWidth: false,
            scrollX: true,
            // pageLength: 25,
            // lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],
            ajax: '{{ route('admin.' . $this_route . '.dataTable') }}',
            aaSorting: [ [0,'asc']],
            columns: [
                @foreach($passing as $field_name => $field_data)
                {data: '{{ $field_name }}', title: "{{ __($field_data->lang) }}" <?php echo strlen($field_data->custom) > 0 ? $field_data->custom : ''; ?> },
                @endforeach
            ]
        });

        function actionData(link, method) {

            if(confirm('{{ __('general.ask_delete') }}')) {
                var test_split = link.split('/');
                var url = '';
                for(var i=3; i<test_split.length; i++) {
                    url += '/'+test_split[i];
                }

                jQuery.ajax({
                    url: url,
                    type: method,
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(result) {

                    },
                    complete: function(){
                        table.ajax.reload();
                    }
                });
            }
        }

    </script>
@stop