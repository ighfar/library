@if ($permission['show'])
<a href="{{ route('admin.' . $this_route . '.show', $query->id) }}" class="btn btn-info btn-xs" title="{{ __('general.show') }}"><i class="fa fa-fw fa-eye"></i><span class="hidden-sm">{{ __('general.show') }}</span></a>
@endif
@if ($permission['edit'])
<a href="{{ route('admin.' . $this_route . '.edit', $query->id) }}" class="btn btn-primary btn-xs" title="{{ __('general.edit') }}"><i class="fa fa-fw fa-pencil"></i><span class="hidden-sm">{{ __('general.edit') }}</span></a>
@endif
@if ($permission['delete'])
<a href="#" class="btn btn-danger btn-xs" onclick="return actionData('{{ route('admin.' . $this_route . '.destroy', $query->id) }}', 'delete')" title="{{ __('general.delete') }}"><i class="fa fa-fw fa-trash"></i> <span class="hidden-sm">{{ __('general.delete') }}</span></a>
@endif
