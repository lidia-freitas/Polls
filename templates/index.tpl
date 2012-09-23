<html>
    <head>
        <meta charset="utf-8" />
        <title>Polls</title>
    </head>
    <body>
        <h1>Polls</h1>
        {{#polls}}
        <article>
            <h1>
                <a href="index.php/poll/{{id}}">{{question}}</a>
            </h1>
            <img src="{{icon}}" alt="" />
        </article>
        {{/polls}}
    </body>
</html>
