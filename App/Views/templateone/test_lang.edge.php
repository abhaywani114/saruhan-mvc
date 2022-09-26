<html>
    <head>
        <title>Test lang</title>
    </head>

    <body>

        <div class="langList">
            <ul>
                @foreach(get_lang_list() as $l)
                   <li><a href="set-user-lang/{!! $l->seo !!}/link_test" 
                     title="{!! $l->title !!}">{!! $l->seo !!}</a></li>
                @endforeach
            </ul>
        </div>

        <div>
            {!! lang('test_lang', 'greeting') !!}
            <br/>
            <b>Link translation</b>
            <a href="/{{lang('test_lang', 'link')}}">{{lang('test_lang', 'link')}}</a>
        </div>
    </body>
</html>
