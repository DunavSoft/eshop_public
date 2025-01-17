<?php

/**
 * Migration language strings.
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
	// Migration Runner
   'missingTable'       => 'Таблицата за миграции трябва да бъде зададена.',
   'disabled'           => 'Миграциите са заредени, но са деактивирани или настроени неправилно.',
   'notFound'           => 'Файлът за мигриране не е намерен: ',
   'batchNotFound'      => 'Целевата партида не е намерена: ',
   'empty'              => 'Няма намерени файлове за мигриране',
   'gap'                => 'Има пропуск в последователността за мигриране близо до номера на версията: ',
   'classNotFound'      => 'Класът за миграция "%s" не може да бъде намерен.',
   'missingMethod'      => 'В класа за миграция липсва метод "%s".',

	// Migration Command
   'migHelpLatest'      => "\t\t Мигрира базата данни към последната налична миграция.",
   'migHelpCurrent'     => "\t\t Мигрира базата данни към версия, зададена като 'текуща' в конфигурацията.",
   'migHelpVersion'     => "\t Мигрира базата данни към версия {v}.",
   'migHelpRollback'    => "\t Изпълнява всички миграции „надолу“ до версия 0.",
   'migHelpRefresh'     => "\t\t Деинсталира и стартира отново всички миграции за опресняване на базата данни.",
   'migHelpSeed'        => "\t Изпълнява seeder с име [name].",
   'migCreate'          => "\t Създава нова миграция с име [name].",
   'nameMigration'      => 'Име на файла за мигриране',
   'badCreateName'      => 'Трябва да предоставите име на файл за мигриране.',
   'writeError'         => 'Грешка при опит за създаване на {0} файл, проверете дали директорията може да се записва.',
   'migNumberError'     => 'Миграционният номер трябва да е трицифрен и не трябва да има пропуски в последователността.',
   'rollBackConfirm'    => 'Сигурни ли сте, че искате да върнете назад?',
   'refreshConfirm'     => 'Сигурни ли сте, че искате да обновите?',

   'latest'            => 'Изпълняват се всички нови миграции...',
   'generalFault'      => 'Мигрирането е неуспешно!',
   'migInvalidVersion' => 'Предоставен е невалиден номер на версията.',
   'toVersionPH'       => 'Мигриране към версия %s...',
   'toVersion'         => 'Мигриране към текущата версия...',
   'rollingBack'       => 'Връщане на миграции към партида: ',
   'noneFound'         => 'Не бяха намерени миграции.',
   'on'                => 'Мигрирано на: ',
   'migSeeder'         => 'Име на seeder-а',
   'migMissingSeeder'  => 'Трябва да предоставите име на seeder.',
   'removed'           => 'Връщане назад: ',
   'added'             => 'В процес: ',

   'version'           => 'Версоя',
   'filename'          => 'Име на файл',
];
