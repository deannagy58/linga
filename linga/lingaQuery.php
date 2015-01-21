<?php

/*

this file contains dfgjkhlk jhlsdfkjghl ksdjhglkjhsdlkjghlksdhgklj h


*/


$linga_sqlQuery['getTexts']['description'] = "login a user into the app";
$linga_sqlQuery['getTexts']['querystring'] = "SELECT text_id, text_text FROM linguini where text_project = :project and text_language = :language ";
						
$linga_sqlQuery['getAText']['description'] = "get a specific entry based on project, language";
$linga_sqlQuery['getAText']['querystring'] = "SELECT text_description, text_text FROM linguini where text_project = :project and text_language = :language and text_id = :rec_id  ";
					
$linga_sqlQuery['addText-A']['description'] = "add a new entry a specific entry based on project, language";
$linga_sqlQuery['addText-A']['querystring'] = "INSERT INTO linguini (text_group_id, text_project, text_language, text_description, text_label, text_text) values (0, :project, :language, :desc, :label, :text)";

$linga_sqlQuery['addText-B']['description'] = "add a new entry a specific entry based on project, language";
$linga_sqlQuery['addText-B']['querystring'] = "INSERT INTO linguini (text_group_id, text_project, text_language, text_description, text_label, text_text) values ";
							
$linga_sqlQuery['addText-C']['description'] = "add a new entry a specific entry based on project, language";
$linga_sqlQuery['addText-C']['querystring'] = "UPDATE linguini set text_group_id = :p_id where text_id = :p_id ";

$linga_sqlQuery['updateText']['description'] = "add a new entry a specific entry based on project, language";
$linga_sqlQuery['updateText']['querystring'] = "UPDATE linguini set text_text = :newTranslation where text_project = :project and text_language = :language and text_id = :rec_id  ";






							
?>

