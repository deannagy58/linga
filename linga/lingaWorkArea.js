



function submitCmdForm(cmd, rec){
	//alert("in submitCmdForm: " + cmd + ":"+ rec);

	if (cmd == "delete")
	{
		var answer = confirm("Are you sure you want to delete the record?");
		if (!answer)
		{
			return;
		}
	}
	//copy values into form and submit
	document.getElementById('subCmd').value = cmd;
	document.getElementById('param1').value = rec;
	document.aCmdForm.submit();

} // end of submitCmdForm()


