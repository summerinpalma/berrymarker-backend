<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitd751713988987e9331980363e24189ce
{
    public static $prefixLengthsPsr4 = array (
        'P' => 
        array (
            'Presentation\\' => 13,
        ),
        'E' => 
        array (
            'Exceptions\\' => 11,
            'Entities\\' => 9,
        ),
        'D' => 
        array (
            'Data\\' => 5,
        ),
        'B' => 
        array (
            'Business\\' => 9,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Presentation\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Presentation',
        ),
        'Exceptions\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Exceptions',
        ),
        'Entities\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Entities',
        ),
        'Data\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Data',
        ),
        'Business\\' => 
        array (
            0 => __DIR__ . '/../..' . '/Business',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitd751713988987e9331980363e24189ce::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitd751713988987e9331980363e24189ce::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitd751713988987e9331980363e24189ce::$classMap;

        }, null, ClassLoader::class);
    }
}