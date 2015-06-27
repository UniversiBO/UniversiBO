<?php
namespace Universibo\Bundle\LegacyBundle\Template;

use MySmarty;

final class TemplateEngineFactory
{
    private $cacheDirectory;
    private $debugging;

    public function __construct($cacheDirectory, $debugging)
    {
        $this->cacheDirectory = $cacheDirectory;
        $this->debugging = $debugging;
    }

    public function create()
    {
        $templateEngine = new MySmarty();

        $root = $this->cacheDirectory;

        $templateEngine->template_dir  = realpath(__DIR__.'/../Resources/views/');
        $templateEngine->compile_dir   = $root . '/smarty/compile';
        $templateEngine->config_dir    = realpath(__DIR__.'/../Resources/views-config/');
        $templateEngine->cache_dir     = $root . '/smarty/cache';
        $templateEngine->compile_check = true;
        $templateEngine->debugging     = $this->debugging;

        return $templateEngine;
    }
}
