<?php

// Criteria descriptions from file
$json = file_get_contents("json/criteria.json");

$tabledata = json_decode($json, true);
?>
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
</head>
<section class="wide">

<script type="text/javascript">
    // ÄLÄ KOSKE KU KERRAN SAIT TOIMIMAAN :DDD
    $(function () {
        // When your submit button is clicked
        $("form").submit(function (e) {
            // check every row

            if (!$('input[name="11"]').is(':checked') || !$('input[name="12"]').is(':checked') || !$('input[name="13"]').is(':checked') || !$('input[name="21"]').is(':checked') || !$('input[name="22"]').is(':checked') || !$('input[name="23"]').is(':checked') || !$('input[name="24"]').is(':checked') || !$('input[name="31"]').is(':checked') || !$('input[name="32"]').is(':checked') || !$('input[name="33"]').is(':checked') || !$('input[name="41"]').is(':checked') || !$('input[name="42"]').is(':checked') || !$('input[name="43"]').is(':checked') || !$('input[name="51"]').is(':checked') || !$('input[name="52"]').is(':checked') || !$('input[name="53"]').is(':checked')) {

                alert("Select all rows.");
                e.preventDefault();
            }
            else
            {
                confirm('Submit?');
            }
/*
            var x = 0;
            
            var jsarray = [ <?php echo '"'.implode('","', $inputRow). '"' ?>];

            jsarray.forEach(myFunc);

            function myFunc(item){
            	if ($('input[name="' + item + '"]').is(':checked')) {

                alert("CHECKED");
                e.preventDefault();
            }
            	*/

        });
    });
</script>

<form action="confirmation_page.php" method="post">
<table border='1'>
<tr><td></td><td>0</td><td>1</td><td>2</td><td>3</td><td>4</td><td>5</td></tr>

<?php

$inputRow = array();

// Topics
foreach($tabledata as $iTopic=>$item)
{
	?>
	<tr><td colspan='7' class="sub">
	<?php

	echo "{$item['item']['topic']}</td></tr>\n";

	// Rows
	foreach($item['item']['subtopic'] as $iRow=>$sub)
	{
		echo "<tr>";

		// Cells
		foreach($sub['text'] as $key=>$description)
		{
			if($key == 0)
			{
			echo "<td>{$description}</td>";
		    }
		    else
			{

				// Radiobutton name and value to match criteria numbering
				$radioValue = $key - 1;
				$topic = $iTopic + 1;
				$row = $iRow + 1;
				$radioRow = "{$topic}{$row}";
				$radioID = "{$radioRow}{$radioValue}";
				echo "<td><label for='" . $radioID . "' class='evaluation'><input type='radio' name='" . $radioRow . "' id='" . $radioID . "' value='" . $radioValue .  "'><br>{$description}</label></td>";
				array_push($inputRow, $radioRow);

			}

		}
		echo "</tr>";
 }
}
				echo "</table>\n";
				echo "<b>Comments</b>"; 
				$placeholder = "Comments";

?>

<textarea placeholder="<?php echo $placeholder?>"rows="5" cols="50" name="comments" style="width:100%;"></textarea>
		<br>
		<div id="button_holder">
			<button type="submit" class="button" value="Submit">Submit</button>
		</div>

</form>

</section>
