<?php

namespace Application\Navigation\Service;

use  Zend\Navigation\Service\AbstractNavigationFactory;

class SecondaryNavigationFactory extends AbstractNavigationFactory
{
    /**
     * @return string
     */
    protected function getName()
    {
        return 'secondary';
    }
}
