<?php
require_once 'vendor/autoload.php';

use Slim\Extras\Views\Mustache;
use Slim\Slim;
use Slim\Route;
use Polls\Url\Url;

Mustache::$mustacheDirectory = __DIR__ . '/vendor/mustache/mustache/src/Mustache';
$view = new Mustache();

$app = new Slim([
    'view' => $view,
    'templates.path' => 'templates',
    'debug' => true,
]);
$app->setName('Polls');

$app->hook('slim.before', function () use ($app) {
    $baseUrl = (new Url())->base();
    $app->view()->appendData(['baseUrl' => $baseUrl,]);
});

Route::setDefaultConditions(['id' => '[0-9]+']);

$app->get('/', function () use ($app) {
    $polls = (new Polls\Persistence\Gateway\Poll())->all();
    $app->render('index.tpl', ['polls' => $polls,]);
});

$app->get('/poll/:id', function ($id) use ($app) {
    $poll = (new Polls\Persistence\Gateway\Poll())->load($id);
    if (!$poll) {
        $app->notFound();
    }
    $app->render('poll.html', ['poll' => $poll,]);
})->name('poll');

$app->post('/poll/:id', function ($id) use ($app) {
    $poll = (new Polls\Persistence\Gateway\Poll())->load($id);
    if (!$poll) {
        $app->notFound();
    }
    (new Polls\Persistence\Gateway\Vote())->add($_POST['choice'], $_SERVER['REMOTE_ADDR']);
    $app->redirect((new Url())->base() . 'index.php/poll/results/' . $id);
})->name('poll');

$app->get('/poll/results/:id', function ($id) use ($app) {
    $poll = (new Polls\Persistence\Gateway\Poll())->load($id);
    if (!$poll) {
        $app->notFound();
    }
    $app->render('results.html', ['poll' => $poll,]);
});

$app->run();
