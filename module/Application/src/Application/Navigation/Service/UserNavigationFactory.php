<?php

namespace Application\Navigation\Service;

use  Zend\Navigation\Service\AbstractNavigationFactory;

class UserNavigationFactory extends AbstractNavigationFactory
{
    /**
     * @return string
     */
    protected function getName()
    {
        return 'user';
    }
}
