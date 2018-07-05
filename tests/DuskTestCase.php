<?php

namespace Tests;

use Laravel\Dusk\Browser;
use Laravel\Dusk\TestCase as BaseTestCase;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

abstract class DuskTestCase extends BaseTestCase
{
    use CreatesApplication, TestHelpers;

    protected $pause_time = 100;

    /**
     * Prepare for Dusk test execution.
     *
     * @beforeClass
     * @return void
     */
    public static function prepare()
    {
        static::startChromeDriver();
    }

    /**
     * Create the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver()
    {
        $options = (new ChromeOptions)->addArguments([
            '--disable-gpu',
            '--headless'
        ]);

        return RemoteWebDriver::create(
            'http://localhost:9515', DesiredCapabilities::chrome()->setCapability(
                ChromeOptions::CAPABILITY, $options
            )
        );
    }

    /** @throws \Throwable */
    public function setUp()
    {
        parent::setUp();

        $this->browse(function (Browser $browser) {
            $browser->maximize();
        });

        Browser::macro('scrollTo', function($selector) {
            $this->driver->executeScript("$(\"html, body\").animate({scrollTop: $(\"$selector\").offset().top}, 0);");
            return $this;
        });
    }

    /** @throws \Throwable */
    protected function tearDown()
    {
        parent::tearDown();

        $this->browse(function (Browser $browser) {
            $browser->driver->manage()->deleteAllCookies();
        });
    }
}
