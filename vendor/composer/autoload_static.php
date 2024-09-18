<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit496ac3467c6debbf21b886640f800a89
{
    public static $files = array (
        '5ff2501974ebd86c0be698ddfca6451e' => __DIR__ . '/..' . '/yahnis-elsts/plugin-update-checker/load-v5p0.php',
    );

    public static $classMap = array (
        'Blokki\\ACF_Field_Multiple_Taxonomy_Terms' => __DIR__ . '/../..' . '/includes/class-acf-field-multiple-taxonomy.php',
        'Blokki\\AcfBlocks' => __DIR__ . '/../..' . '/includes/class-acf-blocks.php',
        'Blokki\\Activator' => __DIR__ . '/../..' . '/includes/class-activator.php',
        'Blokki\\Admin' => __DIR__ . '/../..' . '/admin/class-admin.php',
        'Blokki\\Api' => __DIR__ . '/../..' . '/includes/class-api.php',
        'Blokki\\Blocks' => __DIR__ . '/../..' . '/includes/class-blocks.php',
        'Blokki\\Deactivator' => __DIR__ . '/../..' . '/includes/class-deactivator.php',
        'Blokki\\Front' => __DIR__ . '/../..' . '/public/class-front.php',
        'Blokki\\Globals' => __DIR__ . '/../..' . '/includes/class-globals.php',
        'Blokki\\Init' => __DIR__ . '/../..' . '/includes/class-init.php',
        'Blokki\\Loader' => __DIR__ . '/../..' . '/includes/class-loader.php',
        'Blokki\\Schema' => __DIR__ . '/../..' . '/schema/class-schema.php',
        'Blokki\\Schema\\BaseSchemaType' => __DIR__ . '/../..' . '/schema/class-BaseSchemaType.php',
        'Blokki\\Schema\\FAQPage' => __DIR__ . '/../..' . '/schema/class-FAQPage.php',
        'Blokki\\Schema\\ItemList' => __DIR__ . '/../..' . '/schema/class-ItemList.php',
        'Blokki\\Schema\\ListItem' => __DIR__ . '/../..' . '/schema/class-ListItem.php',
        'Blokki\\Schema\\Question' => __DIR__ . '/../..' . '/schema/class-Question.php',
        'Blokki\\Template' => __DIR__ . '/../..' . '/includes/class-template.php',
        'Blokki\\Updater' => __DIR__ . '/../..' . '/includes/class-updater.php',
        'Blokki\\i18N' => __DIR__ . '/../..' . '/includes/class-i18n.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Gamajo_Template_Loader' => __DIR__ . '/..' . '/gamajo/template-loader/class-gamajo-template-loader.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->classMap = ComposerStaticInit496ac3467c6debbf21b886640f800a89::$classMap;

        }, null, ClassLoader::class);
    }
}
