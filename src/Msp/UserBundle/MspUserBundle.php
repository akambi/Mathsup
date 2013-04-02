<?php

namespace Msp\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class MspUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
