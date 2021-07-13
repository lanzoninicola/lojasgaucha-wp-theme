<?php


/**
 *  START BROWSER DETECTION
 */

// Browser class
// Thanks to: https://github.com/cbschuld/Browser.php
require_once get_stylesheet_directory() . '/includes/trww-archive-product/includes/class-browser.php';


// function isAndroid(object $browser)
// {
//     return $browser->getPlatform() === Browser::PLATFORM_ANDROID ? true : false;
// }

// function isIphone(object $browser)
// {
//     return $browser->getPlatform() === Browser::PLATFORM_IPHONE ? true : false;
// }
/**
 *  END BROWSER DETECTION
 */


class BrowserDetector
{

    private object $browserInstance;

    public function __construct()
    {
        $this->setBrowserInstance(new Browser());
    }

    private function setBrowserInstance($browser)
    {
        $this->browserInstance = $browser;
    }

    public function isIphone()
    {
        return $this->browserInstance->getPlatform() === Browser::PLATFORM_IPHONE ? true : false;
    }

    public function isAndroid()
    {
        return $this->browserInstance->getPlatform() === Browser::PLATFORM_ANDROID ? true : false;
    }
}
