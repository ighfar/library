<div class="form-group @if($errors->has($field_name)) has-error @endif">
    <label for="{{$field_name}}">{{ __($field_lang) }}</label>
    @if($field_value)
        <img src="{{ asset($path.$field_value) }}" class="img-responsive max-image-preview" alt="{{$field_name}}"/>
    @endif
    @if(!isset($show))
    {{ Form::file($field_name, array_merge(['id'=>$field_name, 'accept'=>'image/*'], $add_attribute)) }}
    @endif
    @if(isset($field_message)) <span>{{ $field_message }}</span> @endif
    @if($errors->has($field_name)) <span class="help-block">{{ $errors->first($field_name) }}</span> @endif
</div>