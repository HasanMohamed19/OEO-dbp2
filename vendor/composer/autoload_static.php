<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticIniteda3b7a7cfbba30693369f5392544e9e
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'PHPMailer\\PHPMailer\\' => 20,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'PHPMailer\\PHPMailer\\' => 
        array (
            0 => __DIR__ . '/..' . '/phpmailer/phpmailer/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticIniteda3b7a7cfbba30693369f5392544e9e::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticIniteda3b7a7cfbba30693369f5392544e9e::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticIniteda3b7a7cfbba30693369f5392544e9e::$classMap;

        }, null, ClassLoader::class);
    }
}
