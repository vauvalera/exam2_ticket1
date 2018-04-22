<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Форма обратной связи");
?><?$APPLICATION->IncludeComponent(
	"bitrix:main.feedback", 
	".default", 
	array(
		"COMPONENT_TEMPLATE" => ".default",
		"USE_CAPTCHA" => "Y",
		"OK_TEXT" => "Спасибо, ваше сообщение принято.",
		"EMAIL_TO" => "va@va.com",
		"REQUIRED_FIELDS" => array(
			0 => "NAME",
			1 => "EMAIL",
		),
		"EVENT_MESSAGE_ID" => array(
			0 => "7",
		)
	),
	false
);?><?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>