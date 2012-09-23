<html>
    <head>
        <meta charset="utf-8" />
        <title>Poll</title>
        <base href="{{baseUrl}}" />
    </head>
    <body>
        <nav>
            <ul>
                <li><a href="{{baseUrl}}">Home</a></li>
            </ul>
        </nav>
        {{#poll}}
        <h1>{{getQuestion}}</h1>
        <img src="{{getIcon}}" alt="" />
        <ul>
            {{#getChoices}}
            <li>{{choice}} - {{votes}} votes</li>
            {{/getChoices}}
        </ul>
        {{/poll}}
    </body>
</html>
