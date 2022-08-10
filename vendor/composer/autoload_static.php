<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitff329d87d2419e67c245b6f06e3b2f99
{
    public static $prefixLengthsPsr4 = array (
        'T' => 
        array (
            'Twilio\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Twilio\\' => 
        array (
            0 => __DIR__ . '/..' . '/twilio/sdk/src/Twilio',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitff329d87d2419e67c245b6f06e3b2f99::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitff329d87d2419e67c245b6f06e3b2f99::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitff329d87d2419e67c245b6f06e3b2f99::$classMap;

        }, null, ClassLoader::class);
    }
}