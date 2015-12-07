<?php
namespace Codeliner\CargoFeature;

use Behat\Behat\Context\ClosuredContextInterface,
    Behat\Behat\Context\TranslatedContextInterface,
    Behat\Behat\Context\BehatContext,
    Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode,
    Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Zend\Mvc\Application;
use Zend\ServiceManager\ServiceManager;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Features context.
 */
class FeatureContext extends MinkContext
{
    /**
     * @var \Interop\Container\ContainerInterface
     */
    private static $container;
    
    /**
     * Initializes context.
     * Every scenario gets it's own context object.
     *
     * @param array $parameters context parameters (set them up through behat.yml)
     */
    public function __construct()
    {
        // Initialize your context here
    }

    /**
     * @BeforeSuite
     */
    static public function iniializeContainer()
    {
        if (self::$container === null) {
            self::$container = require __DIR__ . '/../../config/container.php';
        }
    }
    
    /**
     * @BeforeFeature
     */
    public static function clearDatabase()
    {
        $em = self::$container->get('doctrine.entitymanager.orm_default');
        $q = $em->createQuery('delete from Codeliner\CargoBackend\Model\Cargo\Cargo');
        $q->execute();
    }
    
    /**
     * @Given /^I click the submit button$/
     */
    public function iClickTheSubmitButton()
    {
        $session = $this->getSession();
        $page = $session->getPage();
        
        $submit = $page->find('css', 'form input[type=submit]');
        
        if ($submit) {
            $submit->click();
        } else {
            throw new \RuntimeException("Can not find the submit btn");
        }
    }

    /**
     * @Then /^I should wait until I see "([^"]*)"$/
     */
    public function iShouldSeeAvailableRoutes($arg1)
    {
        $this->getSession()->wait(5000, '(0 === jQuery.active)');

        $this->assertElementOnPage($arg1);
    }
    
    /**
     * @When /^I click on first item in the list "([^"]*)"$/
     */
    public function iClickOnFirstItemInTheList($arg1)
    {
        $session = $this->getSession();
        $page = $session->getPage();
        
        $ul = $page->find('css', '#cargo-list');
        
        $li = $ul->find('css', 'li');
        
        $li->find('css', 'a')->click();
    }

    /**
     * @When /^I follow first "([^"]*)" link$/
     */
    public function iFollowFirstLink($arg1)
    {
        $page = $this->getSession()->getPage();

        $link = $page->find('css', $arg1);

        if ($link) {
            $link->click();
        }
    }
    
    /**
     * @Given /^I wait until I am on page "(?P<page>[^"]+)"$/
     */
    public function iWaitUntilIAmOnPage($page)
    {
        $matchingFound = false;
        
        for($i=1;$i++;$i<=5) {
            if (strpos($this->getSession()->getCurrentUrl(), $this->locatePath($page)) !== false) {
                $matchingFound = true;
                break;
            }
            sleep(1);
        }
        
        if (!$matchingFound) {
            throw new \Exception('Stoped waiting, timelimit reached!');
        }
    }

}
