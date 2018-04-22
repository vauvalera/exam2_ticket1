<?
function CheckUserCount() {
    $count = CUser::GetCount();
$lastCount = (COption::GetOptionInt("main", "last_count"))
    ? COption::GetOptionInt("main", "last_count")
    : 0;
$date = new DateTime('now');
$lastDate = (COption::GetOptionInt("main", "last_date"))
    ? new DateTime(COption::GetOptionInt("main", "last_date"))
    : new DateTime('now');
    $lastCount = $count - $lastCount;
    $d = date_diff($date, $lastDate)->days;
$mess = "на сайте зарегистрировано [".$lastCount."] пользователей за [".$d."]";
$filter = Array("GROUPS_ID"=> Array(1));
COption::SetOptionString("main","last_date", $date);
COption::SetOptionInt("main", "last_count", $count);
$rsUsers = CUser::GetList(($by="id"), ($order="desc"), array("GROUPS_ID" => Array(1))); 
$emails = [];
while ($user = $rsUsers->Fetch()) {
    $emails[] = $user['EMAIL'];
}
if (count($emails)>0) {
    $arEventFields = array(
    "MESSAGE"             => $mess,
    "EMAIL_TO"            => implode(",", $emails),
    );
CEvent::Send("CHECK_USER_COUNT,", SITE_ID, $arEventFields);
}
return "CheckUserCount();";
}