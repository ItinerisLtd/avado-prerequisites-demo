<?php
/**
 * Plugin Name:     Avado Prerequisites Demo
 * Plugin URI:      https://www.itineris.co.uk/
 * Description:     This is a demo!
 * Version:         0.1.0
 * Author:          Itineris Limited
 * Author URI:      https://www.itineris.co.uk/
 * License:         GPL-2.0-or-later
 * License URI:     http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:     avado-prerequisites-demo
 */

declare(strict_types=1);

namespace Itineris\AvadoPrerequisites\Demo;

use Itineris\AvadoPrerequisites\Prerequisite;
use Itineris\AvadoPrerequisites\PrerequisiteCollection;

// If this file is called directly, abort.
if (! defined('WPINC')) {
    die;
}

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

add_action('plugins_loaded', function (): void {
    $masterOrAbove = new Prerequisite(
        'masterOrAbove',
        [
            // text, textarea, select, radio, checkbox, password, etc.
            'type' => 'select',
            'required' => true,
            'label' => 'Your education level? (Demo: Select master or PhD to pass)',
            'options' => [
                'bachelor' => "Bachelor's degree",
                'master' => "Master's Degree",
                'phd' => 'Doctor of Philosophy',
            ],
        ],
        function ($value): bool {
            return in_array($value, ['master', 'phd'], true);
        }
    );

    add_action(
        'avado_prerequisites_from_wc_checkout',
        function (PrerequisiteCollection $collection) use ($masterOrAbove): void {
            $collection->add($masterOrAbove);
        }
    );

    add_action(
        'avado_prerequisites_from_wc_order',
        function (PrerequisiteCollection $collection) use ($masterOrAbove): void {
            $collection->add($masterOrAbove);
        }
    );
});
