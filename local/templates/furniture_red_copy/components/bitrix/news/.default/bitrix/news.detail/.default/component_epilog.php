<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>
<?
if ($_GET['TYPE'] == 'AJAX_RESULT') {
    if ($_GET['ID']) {
        echo '
        <script>
            var text = document.getElementById("text-ajax");
            text.innerHTML = "Ваше мнение учтено, №' . $_GET['ID'] . '"
            window.hustore.pushState(null, null, "'.$APPLICATION->GetCurPage() .'")
        </script>
        ';
    } else {
        echo '
        <script>
            var text = document.getElementById("text-ajax");
            text.innerHTML = "Ошибка"
            window.hustore.pushState(null, null, "'.$APPLICATION->GetCurPage() .'")
        </script>
        ';
    }
} else if (isset($_GET['ID']) && CModule::IncludeModule('iblock')) {
    $user = 'Не авторизован';
    global $USER;
    if ($USER->IsAuthorized()) {
        $user = $USER->GetID()." (".$USER->GetLogin().") ".$USER->GetFullName();
    }
    $now = new DateTime('now');
    $PROP = array();
    $PROP['NEWS'] = $_GET['ID'];
    $PROP['USER'] = $user;
    $arLoadProductArray = Array(  
        'IBLOCK_ID' => 5,
        'NAME' => 'Жалоба на новость',
        'DATE_ACTIVE_FROM' => date('d.m.Y'),
        'PROPERTY_VALUES' => $PROP,  
        'ACTIVE' => 'Y',
     );
    $el = new CIBlockElement();
    if($PRODUCT_ID = $el->Add($arLoadProductArray)) {
        if ($_GET['TYPE'] == 'AJAX') {
            $APPLICATION->RestartBuffer();
            $jsonObject['ID'] = $PRODUCT_ID;
            echo json_encode($jsonObject);
            die();
        } else if ($_GET['TYPE'] == 'GET') {
            LocalRedirect($APPLICATION->GetCurPage() . "?TYPE=AJAX_RESULT&ID=" . $PRODUCT_ID);
        }
        
    } else {
        LocalRedirect($APPLICATION->GetCurPage() . "?TYPE=AJAX_RESULT");
    }
}
