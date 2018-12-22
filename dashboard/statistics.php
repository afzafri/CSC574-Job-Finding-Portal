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

}
catch(PDOException $e)
{
  echo "Connection failed : " . $e->getMessage();
}

?>
