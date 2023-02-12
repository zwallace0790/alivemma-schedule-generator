<?
header('Content-Type: application/json');

// From URL to get webpage contents.
$url = "https://api.mindbodyonline.com/public/v6/class/classes";
$api_key = "API_KEY";
$site_id = "-99";
$headers = array(
    "API-Key: $api_key",
    "Content-Type: application/json",
    "siteId: $site_id"
);

$ch = curl_init();

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_URL, $url);

$result = curl_exec($ch);

curl_close($ch);

$result_arr = json_decode($result, true);
$schedule = [];

usort($result_arr['Classes'], function ($a, $b) {
    if ($a['StartDateTime'] === $b['StartDateTime']) {
        return 0;
    }

    return ($a['StartDateTime'] < $b['StartDateTime']) ? -1 : 1;
});

foreach ($result_arr['Classes'] as $class) {
    $weekday = date('l', strtotime($class['StartDateTime']));
    $schedule[$weekday][] = array(
        'name' => $class['ClassDescription']['Name'],
        'coach' => $class['Staff']['Name'],
        'start' => date('g:i A', strtotime($class['StartDateTime'])),
        'end' => date('g:i A', strtotime($class['EndDateTime'])),
    );
}

echo json_encode($schedule);
