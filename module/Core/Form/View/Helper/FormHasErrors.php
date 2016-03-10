<?php

namespace Core\Form\View\Helper;

use Zend\Form\ElementInterface;
use Zend\Form\View\Helper\AbstractHelper;

class FormHasErrors extends AbstractHelper
{
	public function __invoke(ElementInterface $element)
	{
		return !empty($element->getMessages());
	}
}
