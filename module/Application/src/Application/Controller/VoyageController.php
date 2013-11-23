<?php
/*
 * This file is part of the codeliner/php-ddd-cargo-sample package.
 * (c) Alexander Miertsch <kontakt@codeliner.ws>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Application\Controller;

use Application\Domain\Model\Voyage;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
/**
 * MVC Controller for Voyage management
 * 
 * @author Alexander Miertsch <kontakt@codeliner.ws>
 */
class VoyageController extends AbstractActionController 
{
    /**
     *
     * @var Voyage\VoyageRepositoryInterface 
     */
    protected $voyageRepository;
    
    
}
