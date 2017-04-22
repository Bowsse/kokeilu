
<?php
// Links to pages
$permission = $_SESSION['permission'];

// if student
if ($permission == 0) {
?>
<div class="sidebar">
	<a href="student_thesis.php">Thesis</a>
	<a href="user_information.php">User information</a>
	<a href="student_supervisors.php">Supervisors</a>
	<a href='student_thesis_status.php'>Status</a>
	<a href='final_review.php'>Final review</a> </div>
</div>
<?php

} 

// if supervisor
if ($permission == 1) {
?>
<div class="sidebar">
	<a href='supervisor_main.php'>Theses</a>
	<a href='user_information.php'>User information</a>
</div>
<?php
}

?>