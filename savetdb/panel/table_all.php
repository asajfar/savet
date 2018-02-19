<?php

  session_start();
  require_once '../login/class.user.php';

  $panel_home = new USER();

  if(!$panel_home->is_logged_in_admin())
  {
    $panel_home->redirect('../login/index.php');
  }

  // Uskladjivanje vremenske zone sa bazom
  date_default_timezone_set('Europe/Belgrade');
  // $settimezone = $user_home->runQuery("SET SESSION time_zone = '+2:00'");
  // $settimezone->execute();

  // sql upit za odabir potrebnih kolona iz jedne i druge tabele
  $stmt = $panel_home->runQuery("SELECT * FROM tbl_comments LEFT JOIN tbl_members ON tbl_comments.memberID=tbl_members.memberID");
  $stmt->execute();

?>

<html>
    <head>
        <meta charset="utf-8">
    </head>

	<table id="tabela-all" border="1">
        <thead>
          <tr>
              <th>Ime</th>
              <th>Prezime</th>
              <th>Deo grada</th>
              <th>Adresa</th>
              <th>Mobilni</th>
              <th>Email</th>
              <th>Korisničko ime</th>
			  <th>Oblast</th>
              <th>Komentar</th>
              <th>Datum</th>
          </tr>
        </thead>
        <tbody>
          <?php      
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            echo "<tr>";
            echo "<td>" . $row['memberName'] . "</td>";
            echo "<td>" . $row['memberLastname'] . "</td>";
            echo "<td>" . $row['memberLocation'] . "</td>";
            echo "<td>" . $row['memberStreet'] . "</td>";
            echo "<td>" . $row['memberMobile'] . "</td>";
            echo "<td>" . $row['memberEmail'] . "</td>";
            echo "<td>" . $row['memberUsername'] . "</td>";
            echo "<td>" . $row['commentSection'] . "</td>";
            echo "<td>" . $row['commentContent'] . "</td>";
            echo "<td>" . $row['commentDate'] . "</td>";
            echo "</tr>";               
          }//end while
          ?>
        </tbody>
        <tfoot>
          <tr>
              <th>Ime</th>
              <th>Prezime</th>
              <th>Deo grada</th>
              <th>Adresa</th>
              <th>Mobilni</th>
              <th>Email</th>
              <th>Korisničko ime</th>
			  <th>Oblast</th>
              <th>Komentar</th>
              <th>Datum</th>
          </tr>
        </tfoot>
    </table>
</html>