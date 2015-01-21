<?php

require_once "../class/DBClass.php";


//
//
//
//  modeled from here
//  http://slaout.linux62.org/php/db.overview.html
//
//
//
// Open the base (construct the object):
$db = new Database();
$db->connect();
echo "work: [" . $db->getDBState() . "]\n";


if ($db->getDBState())
{
	// Commonly, you can copy/paste this code for one query at a time:
	$result = $db->query("SELECT * FROM test_dna");
	if ($result)
	{
		while ($row = $db->fetchNextObject()) {
			echo $row->test_name, " " , $row->test_description, "\n";
		}
	}
	else
	{
		echo "query  error: " , $db->getLastError();	
	}

	$sql = "delete from test_dna where test_idx = 6";
	$result = $db->execute($sql);
	if ($result)
	{
		echo "deleted record\n";
	}
	else
	{
		echo "delete FAILED\n";
	}
	
	
	// the following example to get a single row
	// determine if a user/password combo valid
	$user = "dean";
	$password = "5opr0n";
	$sql = "SELECT * FROM siteAccount WHERE myname = :user AND mypasswd = :password";
    $db->bind($sql, array('user' => $user, 'password' => $password));
	$result = $db->queryUniqueObject($sql);

	if ($result)
	{
		$numRows = $db->numRows($result);
		echo "num rows: " . $numRows;
		if ($numRows > 0)
		{
			$line = $db->fetchNextObject();
			echo "\n" .$line->siteAccId . " -- " . $line->mynickname;
		}
		else
		{
			// no match 
			echo "user not found, FAILED\n". $db->getLastError();
		}
	
	}
	else
	{
		echo "query error: ". $db->getLastError();		
	}


	// Close the connexion to the base:
	$db->close();

}
else
{
	echo "hey dean dbase error: " , $db->getLastError();
}

?>

