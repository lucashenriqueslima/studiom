<?php

// autoload_real.php @generated by Composer

class ComposerAutoloaderInit41c0d3fa2d14d20ab5ea11448a4e0171
{
    private static $loader;

    public static function loadClassLoader($class)
    {
        if ('Composer\Autoload\ClassLoader' === $class) {
            require __DIR__ . '/ClassLoader.php';
        }
    }

    /**
     * @return \Composer\Autoload\ClassLoader
     */
    public static function getLoader()
    {
        if (null !== self::$loader) {
            return self::$loader;
        }

        require __DIR__ . '/platform_check.php';

        spl_autoload_register(array('ComposerAutoloaderInit41c0d3fa2d14d20ab5ea11448a4e0171', 'loadClassLoader'), true, true);
        self::$loader = $loader = new \Composer\Autoload\ClassLoader(\dirname(__DIR__));
        spl_autoload_unregister(array('ComposerAutoloaderInit41c0d3fa2d14d20ab5ea11448a4e0171', 'loadClassLoader'));

        require __DIR__ . '/autoload_static.php';
        call_user_func(\Composer\Autoload\ComposerStaticInit41c0d3fa2d14d20ab5ea11448a4e0171::getInitializer($loader));

        $loader->register(true);

        $includeFiles = \Composer\Autoload\ComposerStaticInit41c0d3fa2d14d20ab5ea11448a4e0171::$files;
        foreach ($includeFiles as $fileIdentifier => $file) {
            composerRequire41c0d3fa2d14d20ab5ea11448a4e0171($fileIdentifier, $file);
        }

        return $loader;
    }
}

/**
 * @param string $fileIdentifier
 * @param string $file
 * @return void
 */
function composerRequire41c0d3fa2d14d20ab5ea11448a4e0171($fileIdentifier, $file)
{
    if (empty($GLOBALS['__composer_autoload_files'][$fileIdentifier])) {
        $GLOBALS['__composer_autoload_files'][$fileIdentifier] = true;

        require $file;
    }
}