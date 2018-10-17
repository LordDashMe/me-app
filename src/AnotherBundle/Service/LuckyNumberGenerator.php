<?php

namespace AnotherBundle\Service;

class LuckyNumberGenerator
{
    public function get()
    {
        return random_int(0, 100);
    }
}
