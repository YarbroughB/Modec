<?php

namespace Core\Navigation\Service;

use Zend\Navigation\Service\AbstractNavigationFactory as ZendAbstractNavigationFactory;

class AdminNavigationFactory extends ZendAbstractNavigationFactory
{
    protected function getName()
    {
        return 'admin';
    }
}
