<!--
<form name=aCmdForm action="index.php" method=POST>
	<input type="hidden" id="subCmd" name="subCmd" value="" />
	<input type="hidden" id="param1" name="param1" value="" />
</form>

-->


	<div id="header">
		<h1>labRats</h1>

		<div id="container">
			
			<div id="sitetitle">
				
			</div>
			
			<div id="menu">
				<ul>
					<li><a href="http://webdesigninguae.wordpress.com">Home</a></li>
					<li ><a href="http://webdesigninguae.wordpress.com/about/" title="About">About</a></li>

				</ul>
			</div>
		</div>


	</div>

	<div id="content">Content Section
		<form action="index.php" method="post" name="aCmdForm">
			<input type="hidden" id="subCmd" name="subCmd" value="" />
			<input type="hidden" id="param1" name="param1" value="" />
			<fieldset>
 
				<label>Description:</label>
				<textarea id="descr" rows="3" cols="35"> <?php echo $displayObj->text_record['recDescr']; ?></textarea></>
				<br /><br />
				<label>Text:</label>
				<textarea id="latedText" name="latedText" rows="3" cols="35"> <?php echo $displayObj->text_record['recText']; ?></textarea></>
				</br >

			</fieldset>
	<input type="button" value="Save"  style="width: 100px;margin-left: 20px;" onclick="submitCmdForm('save', <?php echo $displayObj->text_record['recId']; ?>)"/>
	<input type="button" value="Cancel"  style="width: 100px" onclick="submitCmdForm('list', 0)" />
		</form>

	</div>
