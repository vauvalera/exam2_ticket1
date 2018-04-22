<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
    if ($arParams["SPEC"] == 'Y') {
    if (isset($arResult["SPEC"])) {
        global $APPLICATION;
        $APPLICATION->SetPageProperty('specialdate', $arResult["SPEC"]);
    }
}