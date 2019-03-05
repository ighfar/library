@php
    $list_field_name = isset($list_field_name) ? $list_field_name : [];
@endphp
<div class="form-group @if($errors->has($field_name)) has-error @endif">
    <label for="{{$field_name}}">{{ __($field_lang) }}</label>
    {{ Form::select($field_name, $list_field_name, old($field_name, $field_value), array_merge(['id'=>$field_name, 'class'=>'form-control select2'], $add_attribute)) }}
    @if(isset($field_message)) <span>{{ $field_message }}</span> @endif
    @if($errors->has($field_name)) <span class="help-block">{{ $errors->first($field_name) }}</span> @endif
</div>