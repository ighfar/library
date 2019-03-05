@if(Session::has('message'))
    <?php
    switch (Session::get('message_alert')) {
        case 2 : $message_class = ' callout-success'; $message_word = 'Success!'; break;
        case 3 : $message_class = ' callout-info'; $message_word = 'Warning!'; break;
        default : $message_class = ' callout-danger'; $message_word = 'Error!'; break;
    }
    ?>
    <div class="pad margin no-print">
        <div class="callout {{$message_class}}">
            <p>{{$message_word}}, {{ Session::get('message')  }}</p>
        </div>
    </div>

@endif
<?php /*
@if($errors->any())

    <div class="pad margin no-print">
        <div class="callout callout-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    </div>

@endif

*/ ?>