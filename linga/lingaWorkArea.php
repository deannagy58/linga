
<form name=aCmdForm action="index.php" method=POST>
	<input type="hidden" id="subCmd" name="subCmd" value="" />
	<input type="hidden" id="param1" name="param1" value="" />
</form>



	<div id="header">
		<h1>labRats</h1>

		<div id="container">
			
			<div id="sitetitle">
			</div>
			
			<div id="menu">
				<ul>
					<li><?php echo $displayObj['uid']; ?></li>
					<li> | </li>
					<li onclick="submitCmdForm('logout', 0)">logout</li>
				</ul>
			</div>
		</div>


</div>
		<!-- navigation start -->
		<div id="navbar">
			<?php echo $displayObj['nav']; ?>
		</div>	
		<!-- navigation end -->



	
	<!-- </div> -->

	<div id="content">
		
    <label>Translation:</label>
		<?php echo $displayObj['lang2Tr']; ?>
	
		<p id ="parag">
	The p element automatically creates some space before and after itself. The space is automatically applied by the browser, or you can specify it in a style sheet.
	The p element automatically creates some space before and after itself. The space is automatically applied by the browser, or you can specify it in a style sheet.
	</p>
	

<div style="margin: 25px;">
<?php echo $displayObj['txtRecs']; ?>
</div>

	</div>


	<div id="footer">Footer Section - <p class="ex2"><b>Bold</b> fields are required. <u>U</u>nderlined letters are accesskeys.</p>
	</div>
<div class="footerII">My footer</div>



