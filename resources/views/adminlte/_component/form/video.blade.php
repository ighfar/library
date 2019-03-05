<div class="form-group @if($errors->has($field_name)) has-error @endif">
    <label for="{{$field_name}}">{{ __($field_lang) }}</label>
    @if($field_value)
        <?php
        $getExt = explode('.', $field_value);
        $ext = end($getExt);
        ?>
        <video width="320" height="240" controls>
            <source src="{{ asset($path.$field_value) }}" type="video/{{ $ext }}">
            Your browser does not support the video tag.
        </video>
    @endif
    @if(!isset($show))
    {{ Form::file($field_name, array_merge(['id'=>$field_name], $add_attribute)) }}
    @endif
    @if(isset($field_message)) <span>{{ $field_message }}</span> @endif
    @if($errors->has($field_name)) <span class="help-block">{{ $errors->first($field_name) }}</span> @endif
</div>