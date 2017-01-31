<?php

echo 'Success again!';

$db = new SQLite3('friendme.db');

echo "<br ><br >";

$results = $db->query('SELECT * FROM incentive_actions');
while ($row = $results->fetchArray()) {
    echo $row["user_name"] . " " . $row["action"] . " " . $row["action_datetime"] . " " . $row["tweet_id"] . " " . "<br >";
}

echo "<br ><br >";

$results = $db->query('SELECT * FROM my_daily_followers');
while ($row = $results->fetchArray()) {
    echo $row["followers"] . " " . $row["list_date"] . " " .  "<br >";
}

echo "<br ><br >";

$results = $db->query('SELECT * FROM daily_keywords');
while ($row = $results->fetchArray()) {
    echo $row["keywords"] . " " . $row["keywords_date"] . " " . "<br >";
}

$follower_results = $db->query('SELECT followers FROM my_daily_followers WHERE list_date = (SELECT MAX(list_date) FROM my_daily_followers)');
while ($row = $follower_results->fetchArray()) {
    echo $row["followers"] . "<br >";
}

$follower_results_array = $follower_results->fetchArray();

$fra = explode(',', $follower_results_array[0]);

$fra_query = '"' . implode('", "', $fra) . '", "testingaccount1", "testingaccount2"';

echo $fra_query;

echo "<table><th>Count</th><th>Action</th>";
$results = $db->query('SELECT user_name, action, count(user_name) as counted_usernames FROM incentive_actions WHERE user_name IN (' . $fra_query . ') GROUP BY action');
while ($row = $results->fetchArray()) {
    echo "<tr><td>" . $row["counted_usernames"] . "</td><td>" . $row["action"] . "</td></tr>";
}
echo "</table>";

echo "<table><th>User name</th><th>Action</th>";
$results = $db->query('SELECT user_name, action FROM incentive_actions WHERE user_name IN (' . $fra_query . ')');
while ($row = $results->fetchArray()) {
    echo "<tr><td>" . $row["user_name"] . "</td><td>" . $row["action"] . "</td></tr>";
}
echo "</table>";

?>
