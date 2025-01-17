<?php namespace App\Config;

use CodeIgniter\Config\BaseConfig;

class ShopSettings extends BaseConfig
{
	//@param array ['type', 'name', 'language description']
	public $generalShopSettings = [
		
	];

//	public $campaignShopSettings = [
//		['textarea_edit', 'delivery', 'Доставка'],
//		['textarea_edit', 'return', 'Връщане'],
//	];

	public $cartShopSettings = [
		['input', 'empty_cart', 'Празна количка'],
//		['input', 'empty_favorites_list', 'Празен списък любими'],
	];

	public $checkoutSettings = [
		['input', 'warn', 'Разр. за обработка на лични данни'],
		['input', 'gdpr', 'GDPR'],
		['input', 'news', 'Текст за абониране'],
		['input', 'thank_you', 'Главен текст при приета поръчка'],
		['input', 'orderTaken', 'Под текст при приета поръчка'],
		['input', 'subMessage', 'Малко текстово съобщение при приета поръчка'],
//		['textarea_edit', 'bank_payment_text', 'Текст за плащане по банков път'],
	];
	
	public $emailsShopSettings = [
		['input', 'email_from_order_placed', 'Изпратена поръчка - email на изпращача <small>Получава копие на поръчката</small>'],
		['input', 'email_from_name_order_placed', 'Изпратена поръчка - ИМЕ на изпращача'],
		['input', 'email_subject_order_placed', 'Изпратена поръчка - тема'],
		['textarea_edit', 'email_content_order_placed', 'Изпратена поръчка - съдържание <small>{{cart_contents}} -съдържание на количката</small>'],
	];
	
	public $subscriptionsSettings = [
		['input', 'email_from_subscribe', 'Абонамент - email на изпращача'],
		['input', 'name_from_subscribe', 'Абонамент - ИМЕ на изпращача'],
		['input', 'subject_subscribe', 'Абонамент - тема'],
		['textarea_edit', 'content_subscribe', 'Абонамент съдържание <small>{{unsubscribe}} - линк за отписване</small>'],
		['input', 'promocode', 'Промокод за отстъпка - value|percent,fixed (10|percent)'],
		['input', 'subject_promocode', 'Промокод - тема'],
		['textarea_edit', 'content_promocode', 'промокод съдържание'],
	];
	
	public $statusesSettings = [
		['input', 'email_from_status', 'Статус Поръчка - email на изпращача'],
		['input', 'name_from_status', 'Статус Поръчка - ИМЕ на изпращача'],
		
		['input', 'subject_registered', 'Регистрирана - тема'],
		['textarea_edit', 'content_registered', 'Регистрирана - съдържание'],
		
		['input', 'subject_processing', 'В процес на обработка - тема'],
		['textarea_edit', 'content_processing', 'В процес на обработка - съдържание'],
		
		['input', 'subject_hold', 'Задържана поръчка - тема'],
		['textarea_edit', 'content_hold', 'Задържана поръчка - съдържание'],
		
		['input', 'subject_confirmed', 'Потвърдена - тема'],
		['textarea_edit', 'content_confirmed', 'Потвърдена - съдържание'],
		
		['input', 'subject_payment_received', 'Плащането е получено - тема'],
		['textarea_edit', 'content_payment_received', 'Плащането е получено - съдържание'],
		
		['input', 'subject_preparing_for_shippment', 'Подготвя се за изпращане - тема'],
		['textarea_edit', 'content_preparing_for_shippment', 'Подготвя се за изпращане - съдържание'],
		
		['input', 'subject_cancelled', 'Отказана - тема'],
		['textarea_edit', 'content_cancelled', 'Отказана - съдържание'],
		
		['input', 'subject_shipped', 'Изпратена - тема'],
		['textarea_edit', 'content_shipped', 'Изпратена - съдържание<br /><small>{{shipping_number}} - номер на товарителница</small>'],
		
		['input', 'subject_delivered', 'Доставена - тема'],
		['textarea_edit', 'content_delivered', 'Доставена - съдържание'],
		
		['input', 'subject_returned', 'Върната - тема'],
		['textarea_edit', 'content_returned', 'Върната - съдържание'],
		
		['input', 'subject_refunded', 'Възстановена сума - тема'],
		['textarea_edit', 'content_refunded', 'Възстановена сума - съдържание'],
		
		['input', 'subject_failed', 'Неуспешна - тема'],
		['textarea_edit', 'content_failed', 'Неуспешна - съдържание'],

		['input', 'subject_completed', 'Приключена - тема'],
		['textarea_edit', 'content_completed', 'Приключена - съдържание'],
	];

	public $speedySettings = [
		['input', 'speedy_base_url', 'Линк на Speedy'],
		['input', 'speedy_user_name', 'API потребителско име'],
		['input', 'speedy_password', 'API парола'],
		['input', 'speedy_language', 'Език(BG, EN)'],
		['input', 'speedy_client_ID', 'ID на клиента'],
		['input', 'speedy_service_ID', 'ID на услугата'],
		['input', 'speedy_contents', 'Съдържание'],
		['input', 'speedy_package', 'Вид на опаковка'],
	];

	public $feedSettings = [
		
	];
}
?>
