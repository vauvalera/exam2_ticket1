<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/** @var CBitrixComponent $this */
/** @var array $arParams */
/** @var array $arResult */
/** @var string $componentPath */
/** @var string $componentName */
/** @var string $componentTemplate */
/** @global CDatabase $DB */
/** @global CUser $USER */
/** @global CMain $APPLICATION */

/** @global CIntranetToolbar $INTRANET_TOOLBAR */
global $INTRANET_TOOLBAR;

use Bitrix\Main\Context;
use Bitrix\Main\Type\DateTime;

CPageOption::SetOptionString("main", "nav_page_in_session", "N");

if(!isset($arParams["CACHE_TIME"]))
	$arParams["CACHE_TIME"] = 36000000;


if($this->StartResultCache(false, false))
{
	if(!CModule::IncludeModule("iblock"))
	{
		$this->AbortResultCache();
		ShowError(GetMessage("IBLOCK_MODULE_NOT_INSTALLED"));
		return;
	}
	
	if(isset($arParams['IBLOCK_CAT_ID']) && isset($arParams['IBLOCK_NEWS_ID']) && isset($arParams['PROP_USER']))
	{
		$arFilter = array('IBLOCK_ID' => $arParams['IBLOCK_CAT_ID']); 

		$arSelect = array(
			"ID",
			"NAME",
			$arParams['PROP_USER']
		);
		
		$rsSect = CIBlockSection::GetList( Array("SORT"=>"ASC"), $arFilter, false, $arSelect);
		//WHERE

		$sections = [];
		while($sect = $rsSect->Fetch())
		{
			$sections[] = $sect;
		}
		
		$arFilter2 = array(
			'IBLOCK_ID' => $arParams['IBLOCK_CAT_ID'],
			'!ACTIVE' => 'N'
		); 

		$arSelect2 = array(
			"ID",
			"NAME",
			'IBLOCK_SECTION_ID',
			'PROPERTY_PRICE',
			'PROPERTY_ARTNUMBER',
			'PROPERTY_MATERIAL',
		);
		$count = 0;
		$max_min = [];
		$res = CIBlockElement::GetList(Array(), $arFilter2, false, false, $arSelect2);
		while($elem = $res->Fetch())
		{
			foreach ($sections as &$sect) {
				if ($sect['ID'] == $elem['IBLOCK_SECTION_ID']) {
					$sect['ITEMS'][] = $elem;
					$max_min[] = $elem['PROPERTY_PRICE_VALUE'];
					$count++;
				}
			}
		}
		
		$arResult['MIN'] = min($max_min);
		$arResult['MAX'] = max($max_min);
				

		$arFilter3 = array(
			'IBLOCK_ID' => $arParams['IBLOCK_NEWS_ID'],
			'!ACTIVE' => 'N'
		); 

		$arSelect3 = array(
			"ID",
			"NAME",
			'ACTIVE_FROM'
		);
		
		$news = CIBlockElement::GetList(Array(), $arFilter3, false, false, $arSelect3);
		$arResult['ITOG'] = [];
		$tek = 0;
		while($elem = $news->Fetch())
		{
			$arResult['ITOG'][] = $elem;
			foreach ($sections as &$sect) {
				foreach ($sect['UF_NEWS_LINK'] as $link)
				if ($link == $elem['ID']) {
					$arResult['ITOG'][$tek]['ITEMS'][] = $sect;
					$arResult['ITOG'][$tek]['SECT'][] = $sect['NAME'];
				}
			}
			$tek++;
		}
		$arResult['COUNT'] = $count;
		//echo '<pre>'; print_r($arResult['ITOG']);  echo '<pre>';
		$this->SetResultCacheKeys(array(
			"COUNT",
			"MIN",
			"MAX"
		));
		$this->IncludeComponentTemplate();
	}
	else
	{
		$this->AbortResultCache();
	}
}
	global $APPLICATION;
	$APPLICATION->SetTitle("В каталоге товаров представлено
товаров: [".$arResult['COUNT']."]");

