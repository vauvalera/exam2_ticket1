<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if ($arParams["SPEC"] == 'Y') {
    $cp = $this->__component;
    $arResult['SPEC'] = $arResult['ITEMS'][0]['ACTIVE_FROM'];
    $cp->SetResultCacheKeys(array(
        "SPEC",
     ));
}