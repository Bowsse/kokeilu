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

function getThesis($thesisID) {
	global $db;
	$sql = <<<SQLEND
	SELECT * FROM Thesis
	WHERE thesisID = :thesisID;
SQLEND;
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':thesisID', $thesisID, PDO::PARAM_STR);
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
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getLoginData($username) {
	global $db;
	$sql = "SELECT personID, password FROM Person WHERE personID = :username";
	$stmt = $db->prepare($sql);
	$stmt->execute(array($username));
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
	SELECT firstname, lastname, Person.personID, email
	FROM Person
	JOIN Person_has_Thesis ON Person_has_Thesis.personID = Person.personID
	WHERE Person_has_Thesis.role = "student" AND Person_has_Thesis.thesisID = :thesisID;
SQLEND;

    $stmt = $db->prepare($sql);
    $stmt->bindValue(":thesisID", $thesisID, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
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

function getPersons($permission=null) {
    global $db;
    $sql = <<<SQLEND
    SELECT * FROM Person
    ORDER BY Person.lastName, Person.FirstName;
SQLEND;
    if ($permission != null) {
        $sql = <<<SQLEND
        SELECT * FROM Person
        WHERE Person.permission=:permission
        ORDER BY Person.lastName, Person.FirstName;
SQLEND;
    }

    $stmt = $db->prepare($sql);
    if ($permission != null)
        $stmt->bindValue(':permission', $permission);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getAllTheses()
{
    global $db;
    $sql = <<<SQLEND
	SELECT Thesis.ThesisID, Thesis.subject,
	Person_has_Thesis.role,
	Person.personID, Person.firstname, Person.lastname
	FROM Person_has_Thesis
	RIGHT OUTER JOIN Thesis ON Thesis.thesisID = Person_has_Thesis.thesisID
	RIGHT OUTER JOIN Person ON Person.personID = Person_has_Thesis.personID;
SQLEND;
    $stmt = $db->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getThesisStatus($thesisID) {
    global $db;
    $sql = <<<SQLEND
    SELECT Status_statusID FROM Thesis_has_Status
    INNER JOIN Thesis ON Thesis.thesisID = Thesis_has_Status.Thesis_thesisID
    WHERE Thesis.thesisID = :thesisID;
SQLEND;
    $stmt = $db->prepare($sql);
    $stmt->bindValue(":thesisID", $thesisID);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getStatuses() {
    global $db;
    $sql = <<<SQLEND
	SELECT * FROM Status;
SQLEND;
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $statuses = $stmt->fetchAll(PDO::FETCH_ASSOC);

    return $statuses;
}

function thesisReadyForReview($thesisID) {
   global $db;
   $sql = <<<SQLEND
   SELECT 1 FROM Thesis
   INNER JOIN Thesis_has_Status on Thesis_thesisID = Thesis.thesisID
   INNER JOIN Status on Status.statusID = Status_statusID
   WHERE Status.statusID = 4 and Thesis.thesisID = :thesisID;
SQLEND;
	$stmt = $db->prepare($sql);
    $stmt->bindValue(":thesisID", $thesisID);
    $stmt->execute();
   	$ready = $stmt->fetch(PDO::FETCH_ASSOC);
    return $ready != null;
}

function firstTimeLogin($personID) {
	global $db;
	$sql = <<<SQLEND
	SELECT firstTimeLogin FROM Person
	WHERE personID = :personID;
SQLEND;
	$stmt = $db->prepare($sql);
    $stmt->bindValue(":personID", $personID);
    $stmt->execute();
   	return $stmt->fetch(PDO::FETCH_ASSOC);
}

function updateFirstTimeLogin($personID) {
	global $db;
	$sql = <<<SQLEND
	UPDATE Person
	SET firstTimeLogin = 0
	WHERE personID = :personID;
SQLEND;
	$stmt = $db->prepare($sql);
	$stmt->bindValue(':personID', $personID, PDO::PARAM_STR);
    $stmt->execute();
}

function personHasThesis($personID, $thesisID) {
    global $db;
   $sql = <<<SQLEND
   SELECT 1 FROM Person
   INNER JOIN Person_has_Thesis on Person_has_Thesis.personID = Person.personID
   WHERE Person.personID = :personID and Person_has_Thesis.thesisID = :thesisID;
SQLEND;
	$stmt = $db->prepare($sql);
    $stmt->bindValue(":personID", $personID);
    $stmt->bindValue(":thesisID", $thesisID);
    $stmt->execute();
   	$ready = $stmt->fetch(PDO::FETCH_ASSOC);
    return $ready == null;
}

function getGrade($personID, $thesisID){
    global $db;
    $sql = <<<SQLEND
    SELECT * FROM Grade
    WHERE Thesis_thesisID = :thesisID and Person_personID = :personID;
SQLEND;
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':thesisID', $thesisID, PDO::PARAM_STR);
    $stmt->bindValue(':personID', $personID, PDO::PARAM_STR);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>


