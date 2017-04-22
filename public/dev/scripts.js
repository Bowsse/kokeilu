// updates version information
function changeVersion(versionID = null) {
	var select = document.getElementById("versionSelect");
	
	if (versionID === null) {
		var versionID = $(select).find('option:selected').attr("name");
	}
	
	$("#versionHidden").val(versionID);
	console.log("version was changed to " + versionID);	
	$.ajax({
      type: "GET",
      dataType: "html",
      url: "version_information.php?&versionID="+versionID,
      async: true,
      success: function(result) {
		  $("#versionData").empty();
		  $("#versionData").append(result);
	  }
	});
	
}