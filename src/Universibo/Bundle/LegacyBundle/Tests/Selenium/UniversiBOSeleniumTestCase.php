<?php
namespace Universibo\Bundle\LegacyBundle\Tests\Selenium;

/**
 * Parent class for all Selenium tests in UniversiBO
 * @author Davide Bellettini <davide.bellettini@gmail.com>
 */
use Universibo\Bundle\LegacyBundle\Tests\TestConstants;

abstract class UniversiBOSeleniumTestCase extends \PHPUnit_Extensions_Selenium2TestCase
{
    protected $base = '/app_dev.php';
    protected $screenshotUrl = 'http://www.universibo.dev/screenshots';

    protected function setUp()
    {
        $this->screenshotPath = __DIR__ . '/../../../../../../web/screenshots';
        $this->captureScreenshotOnFailure = true;

        $this->setBrowser('*firefox');
        $seleniumUrl = getenv('SELENIUM_URL') ?: TestConstants::SELENIUM_URL;
        $this->setBrowserUrl($seleniumUrl);
    }

    protected function wontCaptureScreenshot()
    {
        $this->captureScreenshotOnFailure = false;
    }

    protected function login($username, $password = null)
    {
        if (is_null($password)) {
            $password = TestConstants::DUMMY_PASSWORD;
        }

        $this->deleteAllVisibleCookies();
        $this->openPrefix('/login');
        $this->type('id=username', $username);
        $this->type('id=password', $password);
        $this->clickAndWait('id=_submit');

        if ($this->isTextPresent('Ho letto e accetto')) {
            $this->click('id=accept_check');
            $this->clickAndWait('id=accept_submit');
        }

        $this->assertTrue($this->isTextPresent('Benvenuto '.$username), 'Welcome text must be present');
    }

    protected function openPrefix($url)
    {
        return $this->open($this->base.$url);
    }

    protected function logout()
    {
        $this->openPrefix('/logout');
        $this->assertTrue($this->isTextPresent('I servizi personalizzati sono disponibili solo agli utenti che hanno effettuato il login'));
    }

    protected function assertSentence($sentence)
    {
        $this->assertSentences([$sentence]);
    }

    protected function assertNotSentence($sentence)
    {
        $this->assertNotSentences([$sentence]);
    }

    protected function assertSentences(array $sentences)
    {
        foreach ($sentences as $sentence) {
            $this->assertTrue($this->isTextPresent($sentence), 'Text: "'.$sentence.'" should be present.');
        }
    }

    protected function assertNotSentences(array $sentences)
    {
        foreach ($sentences as $sentence) {
            $this->assertFalse($this->isTextPresent($sentence), 'Text: "'.$sentence.'" should be NOT present.');
        }
    }

    protected function assertLoginRequired()
    {
        $location = $this->base . '/login';
        $this->assertEquals($location, strstr($this->getLocation(), $location));
        $this->assertSentences([
            'Login',
            'Username:',
            'Password:'
        ]);
    }
}
