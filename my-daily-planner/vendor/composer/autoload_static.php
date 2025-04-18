<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit2a151d2c67a7cfe6c1eca80fbb75be6d
{
    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'RalucaAdam\\MyDailyPlanner\\' => 26,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'RalucaAdam\\MyDailyPlanner\\' => 
        array (
            0 => __DIR__ . '/../..' . '/src',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'RalucaAdam\\MyDailyPlanner\\Router' => __DIR__ . '/../..' . '/src/Router.php',
        'RalucaAdam\\MyDailyPlanner\\controllers\\HomeController' => __DIR__ . '/../..' . '/src/controllers/HomeController.php',
        'RalucaAdam\\MyDailyPlanner\\models\\User' => __DIR__ . '/../..' . '/src/models/User.php',
        'RalucaAdam\\MyDailyPlanner\\views\\HomeView' => __DIR__ . '/../..' . '/src/views/HomeView.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit2a151d2c67a7cfe6c1eca80fbb75be6d::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit2a151d2c67a7cfe6c1eca80fbb75be6d::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit2a151d2c67a7cfe6c1eca80fbb75be6d::$classMap;

        }, null, ClassLoader::class);
    }
}
