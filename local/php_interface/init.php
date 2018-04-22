<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
require_once($_SERVER['DOCUMENT_ROOT'].'/local/php_interface/include/agent.php');

AddEventHandler("main", "OnBeforeEventAdd", array("MyClass", "OnBeforeEventAddHandler"));
class MyClass
{
	function OnBeforeEventAddHandler(&$event, &$lid, &$arFields)
	{
        if ($event == 'FEEDBACK_FORM') {
            global $USER;
            if ($USER->IsAuthorized()) {
                 $arFields['AUTHOR'] = 'Пользователь авторизован: '.$USER->GetID().' ('.$USER->GetLogin().') '.$USER->GetFullName().', данные
из формы: '.$arFields['AUTHOR'];
            } else {
                $arFields['AUTHOR'] = 'Пользователь не авторизован, данные из
формы: '.$arFields['AUTHOR'];
            }
            CEventLog::Add(array(
            "SEVERITY" => "SECURITY",
            "AUDIT_TYPE_ID" => "FEEDBACK_FORM",
            "MODULE_ID" => "main",
            "ITEM_ID" => $USER->GetLogin(),
            "DESCRIPTION" => "Замена данных в отсылаемом письме – ".$arFields['AUTHOR'],
      ));
        }
	}
}
?>