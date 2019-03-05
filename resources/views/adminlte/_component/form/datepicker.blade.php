<div class="form-group @if($errors->has($field_name)) has-error @endif">
    <label for="{{$field_name}}">{{ __($field_lang) }}</label>
    <div class="input-group date">
        <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
        </div>
        {{ Form::text($field_name, old($field_name, $field_value), array_merge(['id'=>$field_name, 'class'=>'form-control pull-right datePicker', 'autocomplete'=>'off'], $add_attribute)) }}
    </div>
    @if(isset($field_message)) <span>{{ $field_message }}</span> @endif
    @if($errors->has($field_name)) <span class="help-block">{{ $errors->first($field_name) }}</span> @endif
</div>