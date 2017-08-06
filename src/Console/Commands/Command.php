<?php

namespace Studio\Totem\Console\Commands;

class Command extends \Illuminate\Console\Command
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPrettyName(): string
    {
        return ucwords(implode(' ', explode(':', $this->name)));
    }

    /**
     * @return string
     */
    public function getVerboseName(): string
    {
        return $this->getPrettyName().' ('.$this->getDescription().')';
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}
