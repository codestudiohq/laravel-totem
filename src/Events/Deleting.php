<?php

namespace Studio\Totem\Events;

class Deleting extends Event
{
    public $taskId;

    /**
     * Deleting constructor.
     *
     * @param $taskId
     */
    public function __construct($taskId)
    {
        $this->taskId = $taskId;
    }
}
