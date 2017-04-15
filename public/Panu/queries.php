<?php
function getPerson($personID){
	global $db;
	$sql = <<<SQLEND
	SELECT * FROM Person
	WHERE personID = :username;
SQLEND;
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':username', $personID, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTheses($personID){
	global $db;
	$sql = <<<SQLEND
	SELECT * FROM Thesis
	INNER JOIN Person_has_Thesis ON Person_has_Thesis.thesisID = Thesis.thesisID
	WHERE Person_has_Thesis.personID = :username;
SQLEND;
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':username', $personID, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getThesisID($personID) {
	global $db;
	$sql = <<<SQLEND
	SELECT thesisID FROM Person_has_Thesis
	WHERE personID = :username;
SQLEND;
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':username', $personID, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getNewestVersion($thesisID) {
	global $db;
	$sql = <<<SQLEND
	SELECT * FROM Version
	WHERE Version.thesisID = :thesisID
	ORDER BY Version.creationDate DESC;
SQLEND;
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':thesisID', $thesisID, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

	
function getVersion($versionID) {
	global $db;
	$sql = <<<SQLEND
	SELECT * FROM Version
	WHERE versionID = :versionID;
SQLEND;
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':versionID', $versionID, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}


function getVersions($thesisID) {
	global $db;
	$sql = <<<SQLEND
	SELECT creationDate, version, versionID FROM Version
	WHERE thesisID = :thesisID
	ORDER BY creationDate DESC;
SQLEND;
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':thesisID', $thesisID, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}



function getSupervisors($thesisID, $role) {
	global $db;
	$sql = <<<SQLEND
	SELECT * FROM Person
	INNER JOIN Person_has_Thesis ON Person_has_Thesis.personID = Person.personID
	WHERE Person_has_Thesis.thesisID = :thesisID AND Person_has_Thesis.role = :role;
SQLEND;
	$stmt = $db->prepare($sql);
	$stmt->execute(array($thesisID, $role));
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getLoginData($username, $password) {
	global $db;
	$sql = "SELECT personID, password FROM Person WHERE personID = :username AND password = :password";
	$stmt = $db->prepare($sql);
	$stmt->execute(array($username, $password));
	return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getPersonPermission($username) {
	global $db;
	$sql = "SELECT permission FROM Person WHERE personID = :username";
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':username', $username, PDO::PARAM_STR);
	$stmt->execute();
	return $stmt->fetch(PDO::FETCH_ASSOC);
}

function getPersonTheses($personID)
{
    global $db;
    $sql = <<<SQLEND
    SELECT * FROM Thesis
    JOIN Person_has_Thesis ON Person_has_Thesis.thesisID = Thesis.thesisID
    WHERE Person_has_Thesis.personID = :personID;
SQLEND;
    
    $stmt = $db->prepare($sql);
    $stmt->bindValue(":personID", $personID, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getPersonThesesByRole($personID, $role)
{
    global $db;
    $sql = <<<SQLEND
    SELECT * FROM Thesis
    JOIN Person_has_Thesis on Person_has_Thesis.thesisID = Thesis.thesisID
    WHERE Person_has_Thesis.personID = :personID AND Person_has_Thesis.role = :role;
SQLEND;
    
    $stmt = $db->prepare($sql);
    $stmt->bindValue(":personID", $personID, PDO::PARAM_STR);
    $stmt->bindValue(":role", $role, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getThesisInfo($thesisID)
{
    global $db;
    $sql = <<<SQLEND
	SELECT Person.firstName, Person.lastName, Person.personID, Person.email
	FROM Person_has_Thesis
	JOIN Person ON Person.personID = Person_has_Thesis.personID
	WHERE Person_has_Thesis.role = "student" AND Person_has_Thesis.thesisID = :thesisID;
SQLEND;

    $stmt = $db->prepare($sql);
    $stmt->bindValue(":thesisID", $thesisID, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getComments($versionID) {
	global $db;
	$sql = <<<SQLEND
	SELECT * FROM Comment
	WHERE Version_versionID = :versionID
	ORDER BY submissionDate DESC;
SQLEND;
	$stmt = $db->prepare($sql);
    $stmt->bindValue(":versionID", $versionID, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>


