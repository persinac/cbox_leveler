<?php require_once('../../Connections/lol_api_challenge_conn.php');
require_once('../../keys/key.php');?>
<?php
/**
 * Created by PhpStorm.
 * User: apersinger
 * Date: 04/03/15
 * Time: 2:31 PM
 */

session_start();
include('../../CRUD/library/riot_api.php');
include('../../CRUD/library/LeagueAPIChallenge.php');
set_time_limit(0);
$lol = new Buckets('na', $my_key, $lol_host, $lol_un, $lol_pw, $lol_db);
$my_db_operations = new LeagueAPIChallenge('na', $lol_host, $lol_un, $lol_pw, $lol_db);
$time_array = array();

/**
 * These two lines retrieve the time interval to retrieve.
 * I am retrieving data by 30min intervals
 * For instance, at midnight, it will return:
 *      $retVal->hour = 0
 *      $retVal->minute = 0
 *
 * Then as the day progresses and this script gets called, the TimeTable will be updated.
 * So at 4:30am, it will return:
 *      $retVal->hour = 4
 *      $retVal->minute = 30
 *
 * At 11:59pm every night (EST), a script called: resetTimeTable will
 * be run and it will reset the time table.
 *
 * $time_checker = new TimeChecker('na', $lol_host, $lol_un, $lol_pw, $lol_db);
$retVal = $time_checker->GetTimeToUse();
 */


/**
 * Build time intervals
 */
$time_array = array();
$date_array = array();
$time = "";
for($h = 0; $h < 24; $h++) {
    for($m = 0; $m < 60; $m += 5) {
        if($h < 10) {
            $time = "0" . $h . ":";
        } else {
            $time = $h . ":";
        }
        if($m < 10) {
            $time .= "0" . $m . ":00";
        } else {
            $time .= $m . ":00";
        }
        $time_array[] = $time;
    }
}

$date = "";
for($day = 5; $day < 13; $day++) {
    //date("Y-m-d");
    if($day < 10) {
        $date =  new DateTime('04/0'.$day.'/2015');
    } else {
        $date =  new DateTime('04/'.$day.'/2015');
    }
    // echo $date;
    $date_array[] = $date;
}

// sizeof($time_array)
//$regional_endpoints = array('br','eune','euw','kr','lan','las','na','oce','ru','tr');
$regional_endpoints = array('eune','euw','kr','lan','las','na','oce','ru','tr');
for($rep = 0; $rep < sizeof($regional_endpoints); $rep++) {
    $lol->SetRegion($regional_endpoints[$rep]);
    $my_db_operations->SetRegion($regional_endpoints[$rep]);
    for ($d = 0; $d < sizeof($date_array); $d++) {
        $formatted_date = date_format($date_array[$d], 'Y-m-d');
        for ($u = 0; $u < sizeof($time_array); $u++) {
            $date2 = date("Y-m-d H:i:s", strtotime(date($formatted_date . " " . $time_array[$u] . "") . " GMT"));
            $val = strtotime($date2);
            echo "<p>TIME: " . $time_array[$u] . ", EPOCH: " . $val . ", DATE: $date2</p>";
            $lol->SetBeginDate($val);
            $matches = json_decode($lol->GetBucketOfMatches());
	    
            /**
             * 1. Get max bucketID from table
             */
            $bucketId = $my_db_operations->GetMaxBucketId() + 1;
	    
	    $count = 0;
	    if(sizeof($matches) > 5) {
		$count = 5;
	    } else { $count = sizeof($matches); }

            for ($i = 0; $i < $count; $i++) {
                $curr_matchId = $matches[$i];

                if ($my_db_operations->GetMatchID($curr_matchId) == 0) {
                    /**
                     * 2. Insert new bucket based on current MAX bucketID
                     */
                    $retVal = $my_db_operations->InsertNewBucket($bucketId, $curr_matchId, 'na');
                    /**
                     * 3. Insert new match based on matchID and current MAX bucketID
                     */
                    $match = new LeagueMatchDetails($matches[$i], $regional_endpoints[$rep], $my_key, $lol_host, $lol_un, $lol_pw, $lol_db);
                    $string = json_decode($match->GetMatchDetails());
                    /**
                     * I don't really care about the milliseconds of the date, so I
                     * divide the match creation by 1000
                     */
                    $retVal = $my_db_operations->InsertIntoMatchHeader($bucketId, $string->matchId
                        , $string->mapId, $string->region, $string->platformId, $string->matchMode
                        , $string->matchType, ($string->matchCreation / 1000), $string->matchDuration
                        , $string->queueType, $string->season, $string->matchVersion);

                    $retVal = $my_db_operations->InsertIntoMatchDetails($curr_matchId, $match->GetFrameInterval($string));

                    $test_champ = $match->ParticipantDetails($string);
                    $team_details = $match->TeamDetails($string);
                    $bans = $match->MatchBans($string, $curr_matchId);

                    $team_100_kills = 0;
                    $team_100_assists = 0;
                    $team_100_deaths = 0;
                    $team_100_goldEarned = 0;
                    $team_100_goldSpent = 0;

                    $team_200_kills = 0;
                    $team_200_assists = 0;
                    $team_200_deaths = 0;
                    $team_200_goldEarned = 0;
                    $team_200_goldSpent = 0;
                    $retVal = 0;
                    foreach ($test_champ AS $champ) {
                        /**
                         * 4. Insert participant details
                         */
                        $retVal += $my_db_operations->InsertIntoMatchParticipantDetails($curr_matchId, $champ->GetTeamID()
                            , $champ->GetParticipantID(), $champ->GetSpell1ID(), $champ->GetSpell2ID(), $champ->GetChampionID()
                            , $champ->GetHighestAchSeasonTier(), $champ->GetChampLevel(), $champ->GetItem(0)
                            , $champ->GetItem(1), $champ->GetItem(2), $champ->GetItem(3), $champ->GetItem(4)
                            , $champ->GetItem(5), $champ->GetItem(6), $champ->GetKills(), $champ->GetDoubleKills()
                            , $champ->GetTripleKills(), $champ->GetQuadraKills(), $champ->GetPentaKills(), $champ->GetUnrealKills()
                            , $champ->GetLargestKillingSpree(), $champ->GetDeaths(), $champ->GetAssists()
                            , $champ->GetTotalDamageDealt(), $champ->GetTotalDamageDealtToChampions()
                            , $champ->GetTotalDamageTaken(), $champ->GetLargestCriticalStrike(), $champ->GetTotalHeal()
                            , $champ->GetGoldEarned(), $champ->GetGoldSpent(), $champ->GetRole(), $champ->GetLane());
                        /**
                         * 5. Insert participant details extended
                         */
                        $retVal += $my_db_operations->InsertIntoMatchParticipantDetails_Extended($curr_matchId, $champ->teamId,
                            $champ->participantId,
                            $champ->minionsKilled,
                            $champ->neutralMinionsKilled,
                            $champ->neutralMinionsKilledTeamJungle,
                            $champ->neutralMinionsKilledEnemyJungle,
                            $champ->combatPlayerScore,
                            $champ->objectivePlayerScore,
                            $champ->totalPlayerScore,
                            $champ->totalScoreRank,
                            $champ->magicDamageDealtToChampions,
                            $champ->physicalDamageDealtToChampions,
                            $champ->trueDamageDealtToChampions,
                            $champ->visionWardsBoughtInGame,
                            $champ->sightWardsBoughtInGame,
                            $champ->magicDamageDealt,
                            $champ->physicalDamageDealt,
                            $champ->trueDamageDealt,
                            $champ->magicDamageTaken,
                            $champ->physicalDamageTaken,
                            $champ->trueDamageTaken,
                            $champ->firstBloodKill,
                            $champ->firstBloodAssist,
                            $champ->firstTowerKill,
                            $champ->firstTowerAssist,
                            $champ->firstInhibitorKill,
                            $champ->firstInhibitorAssist,
                            $champ->inhibitorKills,
                            $champ->towerKills,
                            $champ->wardsPlaced,
                            $champ->wardsKilled,
                            $champ->largestMultiKill,
                            $champ->killingSprees,
                            $champ->totalUnitsHealed,
                            $champ->totalTimeCrowdControlDealt);
                        if ($champ->GetTeamID() == 100) {
                            $team_100_kills += $champ->GetKills();
                            $team_100_assists += $champ->GetAssists();
                            $team_100_deaths += $champ->GetDeaths();
                            $team_100_goldEarned += $champ->GetGoldEarned();
                            $team_100_goldSpent += $champ->GetGoldSpent();
                        } else {
                            $team_200_kills += $champ->GetKills();
                            $team_200_assists += $champ->GetAssists();
                            $team_200_deaths += $champ->GetDeaths();
                            $team_200_goldEarned += $champ->GetGoldEarned();
                            $team_200_goldSpent += $champ->GetGoldSpent();
                        }
                    }
                    $team_detail_string = "";
                    $retVal = 0;
                    foreach ($team_details AS $team) {
                        /**
                         * 6. Insert team details
                         */
                        if ($team->teamId == 100) {
                            $team->SetTotalKills($team_100_kills);
                            $team->SetTotalAssists($team_100_assists);
                            $team->SetTotalDeaths($team_100_deaths);
                            $team->SetTotalGoldEarned($team_100_goldEarned);
                            $team->SetTotalGoldSpent($team_100_goldSpent);
                        } else {
                            $team->SetTotalKills($team_200_kills);
                            $team->SetTotalAssists($team_200_assists);
                            $team->SetTotalDeaths($team_200_deaths);
                            $team->SetTotalGoldEarned($team_200_goldEarned);
                            $team->SetTotalGoldSpent($team_200_goldSpent);
                        }
                        $retVal += $my_db_operations->InsertIntoMatchTeamDetails($curr_matchId,
                            $team->teamId,
                            $team->baronKills,
                            $team->dragonKills,
                            $team->totalKills,
                            $team->totalAssists,
                            $team->totalDeaths,
                            $team->totalGoldEarned,
                            $team->totalGoldSpent,
                            $team->winner,
                            $team->firstBlood,
                            $team->firstTower,
                            $team->firstInhibitor,
                            $team->firstBaron,
                            $team->firstDragon,
                            $team->vilemawKills);
                    }

                    /**
                     * 7. Insert into MatchBans
                     */
                    $retVal = 0;
                    $retVal = $my_db_operations->InsertIntoMatchBans($bans->matchId, $bans->first, $bans->second,
                        $bans->third, $bans->fourth, $bans->fifth, $bans->sixth);

                    /*
                     * 8. Get match events
                     */
                    $events = $match->MatchEvents($string);
                    foreach ($events AS $spec_events) {
                        /**
                         * 8b. Insert match events
                         */
                        $my_db_operations->InsertIntoMatchEvents($curr_matchId,
                            $spec_events->eventType,
                            $spec_events->timestamp,
                            $spec_events->skillSlot,
                            $spec_events->participantId,
                            $spec_events->levelUpType,
                            $spec_events->itemId,
                            $spec_events->creatorId,
                            $spec_events->wardType, $spec_events->killerId, $spec_events->victimId,
                            $spec_events->assistingParticipants, $spec_events->pos_x, $spec_events->pos_y,
                            $spec_events->teamId, $spec_events->laneType, $spec_events->buildingType, $spec_events->towerType);
                    }

                    /*
                     * 9. Get match events
                     */
                    $pTimeline = $match->MatchParticipantTimeline($string);
                    foreach ($pTimeline AS $spec_pTimeline) {
                        /**
                         * 9b. Insert match events
                         */
                        $my_db_operations->InsertIntoMatchParticipantTimeline($curr_matchId,
                            $spec_pTimeline->participantId,
                            $spec_pTimeline->pos_x,
                            $spec_pTimeline->pos_y,
                            $spec_pTimeline->currentGold,
                            $spec_pTimeline->totalGold,
                            $spec_pTimeline->level,
                            $spec_pTimeline->xp,
                            $spec_pTimeline->minionsKilled,
                            $spec_pTimeline->jungleMinionsKilled,
                            $spec_pTimeline->dominionScore,
                            $spec_pTimeline->teamScore,
                            $spec_pTimeline->timestamp);
                    }

                    /*
                     * 10. Get participant deltas

                    $deltas = $match->MatchParticipantDeltas($string);
                    $my_db_operations->InsertIntoMatchParticipantDeltas($curr_matchId, $deltas->creepsPerMinDeltas->teamId,
                        $deltas->creepsPerMinDeltas->participantId,
                        $deltas->creepsPerMinDeltas->zeroToTen,
                        $deltas->creepsPerMinDeltas->TenToTwenty,
                        $deltas->creepsPerMinDeltas->TwentyToThirty,
                        $deltas->creepsPerMinDeltas->ThirtyToEnd,
                        $deltas->xpPerMin->zeroToTen,
                        $deltas->xpPerMin->TenToTwenty,
                        $deltas->xpPerMin->TwentyToThirty,
                        $deltas->xpPerMin->ThirtyToEnd,
                        $deltas->goldPerMin->zeroToTen,
                        $deltas->goldPerMin->TenToTwenty,
                        $deltas->goldPerMin->TwentyToThirty,
                        $deltas->goldPerMin->ThirtyToEnd,
                        $deltas->xpDiffPerMin->zeroToTen,
                        $deltas->xpDiffPerMin->TenToTwenty,
                        $deltas->xpDiffPerMin->TwentyToThirty,
                        $deltas->xpDiffPerMin->ThirtyToEnd,
                        $deltas->damageTakenPerMin->zeroToTen,
                        $deltas->damageTakenPerMin->TenToTwenty,
                        $deltas->damageTakenPerMin->TwentyToThirty,
                        $deltas->damageTakenPerMin->ThirtyToEnd,
                        $deltas->damageTakenDiffPerMin->zeroToTen,
                        $deltas->damageTakenDiffPerMin->TenToTwenty,
                        $deltas->damageTakenDiffPerMin->TwentyToThirty,
                        $deltas->damageTakenDiffPerMin->ThirtyToEnd,
                        $deltas->csDiffPerMin->zeroToTen,
                        $deltas->csDiffPerMin->tenToTwenty,
                        $deltas->csDiffPerMin->twentyToThrity,
                        $deltas->csDiffPerMin->thirtyToEnd);
                    */
                    $match->CloseConnection();
                }
            }
            echo "Finished with " . $regional_endpoints[$rep] . "</br>";
        }
    }
}
echo "<h2>FINISHED</h2>";
$my_db_operations->CloseConnection();
$lol->CloseConnection();

function formatMilliseconds($milliseconds) {
    $seconds = floor($milliseconds / 1000);
    $minutes = floor($seconds / 60);
    $hours = floor($minutes / 60);
    $milliseconds = $milliseconds % 1000;
    $seconds = $seconds % 60;
    $minutes = $minutes % 60;

    $format = '%u:%02u:%02u.%03u';
    $time = sprintf($format, $hours, $minutes, $seconds, $milliseconds);
    return rtrim($time, '0');
}