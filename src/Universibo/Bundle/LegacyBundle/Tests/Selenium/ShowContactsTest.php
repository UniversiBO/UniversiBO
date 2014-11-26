<?php
namespace Universibo\Bundle\LegacyBundle\Tests\Selenium;

class ShowContactsTest extends UniversiBOSeleniumTestCase
{
    protected function setUp()
    {
        parent::setUp();
    }

    public function testSimple()
    {
        $sentences = [
            'admin',
            'moderator',
        ];

        $this->openPrefix('/chi-siamo');
        $this->assertSentences($sentences);
    }
}
