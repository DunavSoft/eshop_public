<?php

namespace App\Config;

use CodeIgniter\Config\BaseConfig;

class Settings extends BaseConfig
{
	//@param array ['type', 'name', 'language description']
	public $generalSettings = [
		['input', 'meta_site_title', 'Заглавие'],
		['input', 'meta_site_name', 'Име'],
		['input', 'meta_site_description', 'Мета Описание на сайта'],
		['input', 'site_email', 'Основен имейл за изпращане'],
		['textarea', 'google_analytics_one', 'Google Analytics'],
		['textarea_edit', '404_text', 'Текст за 404'],
		['input', 'text_copyrights', 'Текст copyrights'],
		['textarea', 'text_privacy', 'Политика за поверителност'],
		['input', 'text_search', 'Търсене'],
		['textarea_edit', 'promo_strip', 'Лета за промоции'],
//		['input', 'site_phone', 'Телефон на сайта'],
//		['input', 'facebook', 'Facebook'],
//		['input', 'instagram', 'Instagram'],
	];

	public $homepageSettings = [
		['textarea_edit', 'section-1', 'Home - Икони под слайдер'],
		['textarea_edit', 'section-2', 'Home - Банери'],
		['textarea_edit', 'section-3', 'Home - Категории'],
		['textarea_edit', 'subs-1', 'Абонамент-текст'],
		['textarea_edit', 'subs-2', 'Абонамент-Съгласие'],
		['input', 'subs-3', 'Абонамент-Бутон'],
		['input', 'text-subscribe-success', 'Абонамент-Текст за успешно абониране.'],
	];

	public $Articles = [
		['input', 'news-home-title', 'Home - Заглавие'],
		['input', 'news-home-btn-all', 'Виж всичко'],
		['input', 'text_back', 'Назад към'],
		['input', 'text_coming_soon', 'Очаквайте скоро'],
	];

	public $footerSettings = [
		['textarea_edit', 'footer_contacts', 'Свържете се с нас'],
	];

	public $emailsSettings = [
		['textarea_edit', 'password_reset_email_template', 'Имейл темплейт за смяна на парола<br><small>{{token}} - линк за потвърждение</small>'],
		['input', 'title_activate_account', 'Заглавие за активация на акаунта!'],
		['textarea_edit', 'activate_account_email_template', 'Имейл темплейт за активация на акаунта<br><small>{{token}} - линк за активация</small>'],
	];

	public $gdpr = [
		['input', 'gdpr_title', 'Настройки'],
		['textarea_edit', 'gdpr_text', 'Текст'],
		['input', 'ad_storage', 'ad_storage'],
		['input', 'ad_user_data', 'ad_user_data'],
		['input', 'ad_personalization', 'ad_personalization'],
		['input', 'analytics_storage', 'analytics_storage'],
		['input', 'accept_cookies', 'Разрешавам избраните'],
		['input', 'accept_all', 'Разрешавам всички'],
		['input', 'reject_all', 'Отказвам всички'],
	]; 
}
