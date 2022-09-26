<html>
    <head>
        <title>Test langaue</title>
    </head>

    <body>

        <div class="langList">
            <ul>
                @foreach(get_lang_list() as $l)
                   <li><a href="/set-user-lang/{!! $l->seo !!}" 
                     title="{!! $l->title !!}">{!! $l->seo !!}</a></li>
                @endforeach
            </ul>
        </div>

        <div>
            {!! lang('test_lang', 'greeting') !!}
        </div>
    </body>
</html>