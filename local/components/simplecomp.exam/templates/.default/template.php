<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
	<?$this->SetViewTarget('min_max');
	   ?><div style="color:red; margin: 34px 15px 35px 15px"><?=$arResult['MIN']. " - ".$arResult['MAX']?></div><?
	$this->EndViewTarget();?>
<div class="catalog">
	<p>---</p>
	<p><b>Каталог:</b></p>
	<ul>
	<?foreach($arResult['ITOG'] as $elem):?>
		<li>
			<b><?=$elem['NAME']?></b><?=" - ".$elem['ACTIVE_FROM']." (".implode(', ', $elem['SECT']).")"?>
			<ul>
			<?foreach($elem['ITEMS'] as $items):?>
			<?foreach($items['ITEMS'] as $item):?>
			<li>
				<?=$item['NAME']." - ".$item['PROPERTY_PRICE_VALUE']." - ".$item['PROPERTY_MATERIAL_VALUE']." - ".$item['PROPERTY_ARTNUMBER_VALUE']?>
			</li>
			<?endforeach;?>
			<?endforeach;?>
			</ul>
		</li>
	<?endforeach;?>
	</ul>

</div>
