<?php

namespace Application\Navigation\Service;

use  Zend\Navigation\Service\AbstractNavigationFactory;

class FooterNavigationFactory extends AbstractNavigationFactory
{
    /**
     * @return string
     */
    protected function getName()
    {
        return 'footer';
    }
}
