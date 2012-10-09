<?php
namespace Polls\Model;

class Poll
{
    private $question;
    private $icon;
    private $choices;

    public function getQuestion()
    {
        return $this->question;
    }

    public function getIcon()
    {
        return $this->icon;
    }

    public function getChoices()
    {
        return $this->choices;
    }

    public function setChoices(array $choices)
    {
        $this->choices = $choices;
    }
}
