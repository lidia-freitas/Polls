<?php
require_once 'Slim/Slim.php';
require_once 'vendor/mustache/mustache/src/Mustache/Autoloader.php';
require_once 'vendor/slim/extras/Views/MustacheView.php';
require_once 'Library/Persistence/Gateway/Poll.php';
require_once 'Library/Persistence/Gateway/Vote.php';
require_once 'Library/Model/Poll.php';
require_once 'Library/Url/Url.php';

Mustache_Autoloader::register();
$view = new MustacheView();

$app = new Slim([
    'view' => $view,
    'templates.path' => 'templates',
    'debug' => true,
]);
$app->setName('Polls');

$app->hook('slim.before', function () use ($app) {
    $baseUrl = (new Url\Url())->base();
    $app->view()->appendData(['baseUrl' => $baseUrl,]);
});

Slim_Route::setDefaultConditions(['id' => '[0-9]+']);

$app->get('/', function () use ($app) {
    $polls = (new Persistence\Gateway\Poll())->all();
    $app->render('index.html', ['polls' => $polls,]);
});

$app->get('/poll/:id', function ($id) use ($app) {
    $poll = (new Persistence\Gateway\Poll())->load($id);
    if (!$poll) {
        $app->notFound();
    }
    $app->render('poll.html', ['poll' => $poll,]);
})->name('poll');

$app->post('/poll/:id', function ($id) use ($app) {
    $poll = (new Persistence\Gateway\Poll())->load($id);
    if (!$poll) {
        $app->notFound();
    }
    (new Persistence\Gateway\Vote())->add($_POST['choice'], $_SERVER['REMOTE_ADDR']);
    $app->redirect((new Url\Url())->base() . 'index.php/poll/results/' . $id);
})->name('poll');

$app->get('/poll/results/:id', function ($id) use ($app) {
    $poll = (new Persistence\Gateway\Poll())->load($id);
    if (!$poll) {
        $app->notFound();
    }
    $app->render('results.html', ['poll' => $poll,]);
});

$app->run();
