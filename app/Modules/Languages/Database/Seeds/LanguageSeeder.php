<?php
namespace App\Modules\Languages\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LanguageSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
				'side' => 'admin',
				'name' => 'english',
				'native_name' => 'English',
				'english_name' => 'English',
				'code' => 'en',
				'uri' => 'en',
				'icon' => 'en.png',
				'sequence' => '1',
				'active' => '0',
				'hidden' => '0',
				'is_default' => '0',
			],
			[
				'side' => 'admin',
				'name' => 'bulgarian',
				'native_name' => 'Български',
				'english_name' => 'Bulgarian',
				'code' => 'bg',
				'uri' => 'bg',
				'icon' => 'bg.png',
				'sequence' => '2',
				'active' => '1',
				'hidden' => '0',
				'is_default' => '1',
			],
			[
				'side' => 'site',
				'name' => 'english',
				'native_name' => 'English',
				'english_name' => 'English',
				'code' => 'en',
				'uri' => 'en',
				'icon' => 'en.png',
				'sequence' => '1',
				'active' => '0',
				'hidden' => '0',
				'is_default' => '0',
			],
			[
				'side' => 'site',
				'name' => 'bulgarian',
				'native_name' => 'Български',
				'english_name' => 'Bulgarian',
				'code' => 'bg',
				'uri' => 'bg',
				'icon' => 'bg.png',
				'sequence' => '2',
				'active' => '1',
				'hidden' => '0',
				'is_default' => '1',
			],
			[
				'side' => 'site',
				'name' => 'romanian',
				'native_name' => 'Română',
				'english_name' => 'Romanian',
				'code' => 'ro',
				'uri' => 'ro',
				'icon' => 'ro.png',
				'sequence' => '3',
				'active' => '0',
				'hidden' => '0',
				'is_default' => '0',
			],
			[
				'side' => 'site',
				'name' => 'german',
				'native_name' => 'Deutsch',
				'english_name' => 'German',
				'code' => 'de',
				'uri' => 'de',
				'icon' => 'de.png',
				'sequence' => '4',
				'active' => '0',
				'hidden' => '0',
				'is_default' => '0',
			],
        ];

		$countRecords = $this->db->table('languages')->countAllResults();
		
		if ($countRecords == 0) {
			echo 'Language Seeder run...';
			$this->db->table('languages')->insertBatch($data);
		}

		$data = [
            [
				'lang_variable' => 'lang_dropdown',
				'content' => '{if $locale == \'bg\'} Изберете език {else}Choose language {endif}
<ul>
{languages_without_selected}
<li><a class="{active}" href="{link}">{title}</a></li>
{/languages_without_selected}
</ul>',
			],
			[
				'lang_variable' => 'lang_inline',
				'content' => '{if $locale == \'de\'}
<a class="nav-link dropdown-toggle" href="#" id="langDrop" role="button" data-bs-toggle="dropdown"aria-expanded="false">DE <i class="fa fa-chevron-down"></i></a>
{else}
<a class="nav-link dropdown-toggle" href="#" id="langDrop" role="button" data-bs-toggle="dropdown"aria-expanded="false">EN <i class="fa fa-chevron-down"></i></a> 
{endif}

 <ul class="dropdown-menu text-end lang-drop-code" aria-labelledby="langDrop">

 {languages}
<li><a class="dropdown-item" href="{link}">{code}{i}</a></li>
 {/languages}
</ul>',
			],
        ];

		$countRecords = $this->db->table('languages_front')->countAllResults();
		
		if ($countRecords == 0) {
			echo 'Languages_front Seeder run...';
			$this->db->table('languages_front')->insertBatch($data);
		}
		
    }
}