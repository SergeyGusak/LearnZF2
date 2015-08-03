<?php

namespace LearnZF2Captcha;

class Module
{
    public function getConfig()
    {
        $moduleConfig  = include __DIR__.'/config/module.config.php';
        $captchaConfig = include __DIR__.'/config/captcha.config.php';

        return array_merge($moduleConfig, $captchaConfig);
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__.'/src/'.__NAMESPACE__,
                ),
            ),
        );
    }
}
