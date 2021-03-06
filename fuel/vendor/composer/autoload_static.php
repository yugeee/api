<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitc0a38bc743e8a878e0dfcef53613f7cd
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Psr\\Log\\' => 8,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Psr\\Log\\' => 
        array (
            0 => __DIR__ . '/..' . '/psr/log/Psr/Log',
        ),
    );

    public static $prefixesPsr0 = array (
        'M' => 
        array (
            'Monolog' => 
            array (
                0 => __DIR__ . '/..' . '/monolog/monolog/src',
            ),
        ),
        'F' => 
        array (
            'Fuel\\Upload' => 
            array (
                0 => __DIR__ . '/..' . '/fuelphp/upload/src',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitc0a38bc743e8a878e0dfcef53613f7cd::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitc0a38bc743e8a878e0dfcef53613f7cd::$prefixDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInitc0a38bc743e8a878e0dfcef53613f7cd::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
