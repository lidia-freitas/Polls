<?php
namespace Url;

class Url
{
    public function base()
    {
        return 'http://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['SCRIPT_NAME']) . '/';
    }
}
