<?php

namespace Application\Navigation\Service;

use  Zend\Navigation\Service\AbstractNavigationFactory;

class PrimaryNavigationFactory extends AbstractNavigationFactory
{
    /**
     * @return string
     */
    protected function getName()
    {
        return 'primary';
    }
}
