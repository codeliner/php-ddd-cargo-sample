<?php
namespace Codeliner\CargoFeature;

use Behat\MinkExtension\Context\MinkContext;

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
    static public function iniializeContainer(): void
    {
        if (self::$container === null) {
            self::$container = require __DIR__ . '/../../config/container.php';
        }
    }
    
    /**
     * @BeforeFeature
     */
    public static function clearDatabase(): void
    {
        $em = self::$container->get('doctrine.entitymanager.orm_default');
        $q = $em->createQuery('delete from Codeliner\CargoBackend\Model\Cargo\Cargo');
        $q->execute();
    }
    
    /**
     * @Given /^I click the submit button$/
     */
    public function iClickTheSubmitButton(): void
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
    public function iShouldSeeAvailableRoutes(string $arg1): void
    {
        $this->getSession()->wait(5000, '(0 === jQuery.active)');

        $this->assertElementOnPage($arg1);
    }
    
    /**
     * @When /^I click on first item in the list "([^"]*)"$/
     */
    public function iClickOnFirstItemInTheList(string $arg1): void
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
    public function iFollowFirstLink(string $arg1): void
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
    public function iWaitUntilIAmOnPage(string $page): void
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
