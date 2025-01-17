<?php
/**
 * Languages language strings English.
 *
 * @package Languages
 * @author  Georgi Nechovski
 * @link    
 */

return [
   'pageTitle' => 'Languages settings',
   'informations-title' => 'Informations',
   //form
   'identificator' => 'Ident',
   'standartCode' => 'Code',
   'uri' => 'URI',
   'nativeName' => 'Native name',
   'englishName' => 'English name',
   'active' => 'Active',
   'hidden' => 'Hidden',
   'main' => 'Main',
   'icon' => 'Icon',
   'help_text' => 'Help',
   'content' => 'Content',
   'variable' => 'Variable',
   'site' => 'Site',
   'success' => 'The languages are saved successfully!',
   
   'help' => 'Saved Variables:
   * {locale} code of the current language
   * {total} - total elements
   * {selected} -native name of the current language
   * {languages} - Array of languages
		-- {title} -Native Name
		-- {code} - Language Code
		-- {link} - Language Link
		-- {active} - The Active language has a value active, the remaining ones have \'\'
		-- {i} - Next Number, starts from 0
	* {/languages} - End of the Language Array
	**{languages_without_selected} ... {/languages_without_selected} - Array of Languages excluding the current one
	{if $locale == \'bg\'} Изберете език {else}Choose language {endif} - example of if-else
   ',
];
