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
        <form method="post" action="index.php/poll/{{id}}">
            {{#getChoices}}
            <input id="choice-{{id}}" name="choice" type="radio" value="{{id}}" />
            <label for="choice-{{id}}">{{choice}}</label>
            {{/getChoices}}
            <input type="submit" value="Vote!" />
        </form>
        <a href="{{baseUrl}}index.php/poll/results/{{id}}">Results</a>
        {{/poll}}
    </body>
</html>
