<?php

namespace Core\Navigation\Service;

use Zend\Navigation\Service\AbstractNavigationFactory;

class PrimaryNavigationFactory extends AbstractNavigationFactory
{
    protected function getName()
    {
        return 'primary';
    }
}
