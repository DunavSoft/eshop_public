<?php

/**
 * Session language strings.
 *
 * @package    CodeIgniter
 * @author     CodeIgniter Dev Team
 * @copyright  2022 CodeIgniter Foundation
 * @license    https://opensource.org/licenses/MIT	MIT License
 * @link       https://codeigniter.com
 * @since      Version 4.0.0
 * @filesource
 *
 * @codeCoverageIgnore
 */

return [
   'missingDatabaseTable'     => '`sessionSavePath` трябва да има името на таблицата, за да работи манипулаторът на сесии на базата данни.',
   'invalidSavePath'          => 'Сесия: Конфигурираният път за запис "{0}" не е директория, не съществува или не може да бъде създаден.',
   'writeProtectedSavePath'   => 'Сесия: Конфигурираният път за запис "{0}" не може да се записва от PHP процеса.',
   'emptySavePath'            => 'Сесия: Няма конфигуриран път за запис.',
   'invalidSavePathFormat'    => 'Сесия: Невалиден формат на пътя за запис на Redis: {0}',
];
