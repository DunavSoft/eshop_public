<?php
/**
 * Languages language strings Bulgarian.
 *
 * @package Languages
 * @author  Georgi Nechovski
 * @link    
 */

return [
   'menuTitle' => 'Настройка на езици',
   'pageTitle' => 'Настройка на езици',
   //form
   'identificator' => 'Идентификатор',
   'standartCode' => 'Стандартен код',
   'uri' => 'URI сегмент',
   'nativeName' => 'Нативно име',
   'englishName' => 'Английско име',
   'active' => 'Активен',
   'hidden' => 'Скрит',
   'main' => 'Основен',
   'icon' => 'Икона',
   'help_text' => 'Информация',
   'content' => 'Съдържание',
   'variable' => 'Запазена дума',
   'site' => 'Сайт',
   'success' => 'Езиците са запазени успешно!',
   
   'help' => 'Запазени променливи:
   * {locale} код на текущия език
   * {total} - брой на елементите
   * {selected} - Нативно име текущия език
   * {languages} - Масив с езици 
		-- {title} - Нативно име 
		-- {code} - Код на езика 
		-- {link} - Линк към езика 
		-- {active} - Активният език има стойност active, останалите \'\' 
		-- {i} - Пореден номер, започва от 0 
	* {/languages} - Край на Масив с езици 
	**{languages_without_selected} ... {/languages_without_selected} - Масив с езици без текущия
	{if $locale == \'bg\'} Изберете език {else}Choose language {endif} - пример за if-else
   ',
];
