<?php

try
{
  // ----- STATISTICS -----
  // Job Offers
  $joboffers = $conn->prepare("
                              SELECT COUNT(*) AS TOTAL
                              FROM JOB
                              WHERE DATE(J_START) = DATE(NOW())

                              UNION ALL

                              SELECT COUNT(*) AS TOTAL
                              FROM JOB
                              WHERE MONTH(J_START) = MONTH(NOW())

                              UNION ALL

                              SELECT COUNT(*) AS TOTAL
                              FROM JOB
                              WHERE YEAR(J_START) = YEAR(NOW())
                          ");

  $joboffers->execute();
  $resjob = $joboffers->fetchAll();

  $offersDaily = $resjob[0]['TOTAL'];
  $offersMonthly = $resjob[1]['TOTAL'];
  $offersYearly = $resjob[2]['TOTAL'];

  // Job Applications
  $jobapplications = $conn->prepare("
                              SELECT COUNT(*) AS TOTAL
                              FROM JOB_APPLICATION
                              WHERE DATE(APPLY_DATE) = DATE(NOW())

                              UNION ALL

                              SELECT COUNT(*) AS TOTAL
                              FROM JOB_APPLICATION
                              WHERE MONTH(APPLY_DATE) = MONTH(NOW())

                              UNION ALL

                              SELECT COUNT(*) AS TOTAL
                              FROM JOB_APPLICATION
                              WHERE YEAR(APPLY_DATE) = YEAR(NOW())
                          ");

  $jobapplications->execute();
  $resapply = $jobapplications->fetchAll();

  $applyDaily = $resapply[0]['TOTAL'];
  $applyMonthly = $resapply[1]['TOTAL'];
  $applyYearly = $resapply[2]['TOTAL'];

  // New Posts
  $posts = $conn->prepare("
                            SELECT COUNT(*) AS TOTAL
                            FROM JOB_DONE
                            WHERE DATE(POST_TIME) = DATE(NOW())

                            UNION ALL

                            SELECT COUNT(*) AS TOTAL
                            FROM JOB_DONE
                            WHERE MONTH(POST_TIME) = MONTH(NOW())

                            UNION ALL

                            SELECT COUNT(*) AS TOTAL
                            FROM JOB_DONE
                            WHERE YEAR(POST_TIME) = YEAR(NOW())
                          ");

  $posts->execute();
  $resposts = $posts->fetchAll();

  $postsDaily = $resposts[0]['TOTAL'];
  $postsMonthly = $resposts[1]['TOTAL'];
  $postsYearly = $resposts[2]['TOTAL'];

  // Top 10 Job Provider with Most Job
  $topjp = $conn->prepare("
                            SELECT P.JP_ID, P.JP_NAME, COUNT(*) AS TOTAL
                            FROM JOB J, JOB_PROVIDER P
                            WHERE J.JP_ID = P.JP_ID
                            GROUP BY J.JP_ID
                            ORDER BY TOTAL DESC
                            LIMIT 10
                          ");

  $topjp->execute();

  // Top 10 Seeker with Most Job Accepted
  $topjs = $conn->prepare("
                            SELECT S.JS_ID, S.JS_NAME, COUNT(*) AS TOTAL
                            FROM JOB_APPLICATION A, JOB_SEEKER S, JOB J
                            WHERE S.JS_ID = A.JS_ID
                            AND J.J_ID = A.J_ID
                            AND A.STATUS = 1
                            GROUP BY A.JS_ID
                            ORDER BY TOTAL DESC
                            LIMIT 10
                          ");

  $topjs->execute();

  // Top 10 Job With Most Applications
  $topjob = $conn->prepare("
                              SELECT J.J_ID, J.J_TITLE, J.J_DESC, P.JP_NAME, COUNT(*) AS TOTAL
                              FROM JOB_APPLICATION A, JOB J, JOB_PROVIDER P
                              WHERE J.J_ID = A.J_ID
                              AND P.JP_ID = J.JP_ID
                              GROUP BY J.J_ID
                              ORDER BY TOTAL DESC
                              LIMIT 10
                          ");

  $topjob->execute();

  // List Countries with No of Jobs
  $jobLocArr = array();
  // loop states, to find total of jobs
  $listnegeri = ["JOHOR","KEDAH","KELANTAN","MELAKA","NEGERI SEMBILAN","PAHANG","PERLIS","PULAU PINANG","PERAK","SABAH","SELANGOR","KUALA LUMPUR","PUTRAJAYA","SARAWAK","TERENGGANU","LABUAN"];
  $totalEachCountry = array();
  foreach ($listnegeri as $negeri)
  {
    $stmtJobLoc = $conn->prepare("SELECT COUNT(*) TOTAL FROM JOB WHERE J_ADDRESS LIKE ?");
    $stmtJobLoc->execute(array("%$negeri%"));
    $resJobLoc = $stmtJobLoc->fetch(PDO::FETCH_ASSOC);
    $totalJobLoc = $resJobLoc['TOTAL'];

    $totalEachCountry[] = $totalJobLoc;
    $jobLocArr[] = array('state' => $negeri, 'total' => $totalJobLoc);
  }
  // sort the array by descending order by total jobs
  array_multisort(array_column($jobLocArr, "total"), SORT_DESC, $jobLocArr);

  // List Job Categories Tags
  $tagsArr = array();
  // loop tags, to find total of jobs
  $listAreaTags = array();
  $totalEachTags = array();
  $stmtTags = $conn->prepare("SELECT J_AREA FROM JOB WHERE J_STATUS = 1");
  $stmtTags->execute();
  while($result = $stmtTags->fetch(PDO::FETCH_ASSOC)) {
    $arrarea = explode(",", $result['J_AREA']);

    foreach ($arrarea as $arrarea) {
      if(!in_array($arrarea, $listAreaTags)){
        $listAreaTags[]=$arrarea;
      }
    }
  }
  foreach ($listAreaTags as $artag)
  {
    $stmtArTag = $conn->prepare("SELECT COUNT(*) TOTAL FROM JOB WHERE J_AREA LIKE ?");
    $stmtArTag->execute(array("%$artag%"));
    $resArTag = $stmtArTag->fetch(PDO::FETCH_ASSOC);
    $totalArTag = $resArTag['TOTAL'];

    $totalEachTags[] = $totalArTag;
    $tagsArr[] = array('tag' => $artag, 'total' => $totalArTag);
  }
  // sort the array by descending order by total jobs
  array_multisort(array_column($tagsArr, "total"), SORT_DESC, $tagsArr);

}
catch(PDOException $e)
{
  echo "Connection failed : " . $e->getMessage();
}

?>
