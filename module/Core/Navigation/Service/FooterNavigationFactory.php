<?php

namespace Core\Navigation\Service;

use  Zend\Navigation\Service\AbstractNavigationFactory;

class FooterNavigationFactory extends AbstractNavigationFactory
{
    protected function getName()
    {
        return 'footer';
    }
}
