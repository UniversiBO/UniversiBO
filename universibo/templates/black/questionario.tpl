
&nbsp;<br />
<img src="tpl/black/questionario_18.gif" width="144" height="22" alt="{$question_TitleAlt|escape}" />
&nbsp;<br />
&nbsp;<br />
<table align="center" cellspacing="0" cellpadding="0" width="90%" summary="">
<tr>
<td class="Normal">

 {* come vogliamo gestire il get? *}
 
 <FORM action="aChiLoMando?" method="post">
 <p class="NormalC">{$question_PersonalInfo|escape}</p>
<table width="90%" align="center" class="Normal" summary="">
<tr>
<td>{$question_PersonalInfoData[0]|escape}</td>
<td><input maxLength="30" size="50" name="nome"></td>
</tr>
<tr>
<td>{$question_PersonalInfoData[1]|escape}</td>
<td><input maxLength="30" size="50" name="cognome"></td>
</tr>
<tr>
<td>{$question_PersonalInfoData[2]|escape}</td>
<td><input maxLength="30" size="50" name="mail"></td>
</tr>
<tr>
<td>{$question_PersonalInfoData[3]|escape}</td>
<td><input maxLength="30" size="50" name="tel"></td>
</tr>
</table>
 <p>&nbsp;</p>

	<p class="NormalC">{$question_q1|escape}</p>
 <table width="90%" align="center" class="Normal" summary="">
	<tr>
	 <td><input type="radio" value="120" name="tempo"> {$question_q1Answers[0]|escape}</td></tr>
	<tr>
	 <td><input type="radio" value="30" name="tempo"> {$question_q1Answers[1]|escape}</td></tr>
	<tr>
	 <td><input type="radio" value="1" name="tempo"> {$question_q1Answers[2]|escape}</td></tr></table>

 <p>&nbsp;</p>


	<p class="NormalC">{$question_q2|escape}</p>
		<table width="90%" align="center" class="Normal" summary="">
		<tr><td><input type="radio" name="internet" value="1"> {$question_q2Answers[0]|escape}</td>
		</tr>
		<tr><td><input type="radio" name="internet" value="60"> {$question_q2Answers[1]|escape}</td>
		</tr>
		<tr><td><input type="radio" name="internet" value="200"> {$question_q2Answers[2]|escape}</td>
		</tr>
		<tr><td><input type="radio" name="internet" value="1000"> {$question_q2Answers[3]|escape}</td>
		</tr>
	</table>
 <p>&nbsp;</p>

	<p class="NormalC">{$question_q3|escape}</p>
 <table width="90%" align="center" class="Normal" summary="">
	<tr>
	 <td><input type="checkbox" name="offline"> {$question_q3AnswersMulti[0]|escape}</td></tr>
		<tr>
	 <td><input type="checkbox" name="moderatore"> {$question_q3AnswersMulti[1]|escape}</td></tr>
	<tr>
	 <td><input type="checkbox" name="contenuti"> {$question_q3AnswersMulti[2]|escape}</td></tr>
	<tr>
	 <td><input type="checkbox" name="test"> {$question_q3AnswersMulti[3]|escape}</td></tr>
	<tr>
	 <td><input type="checkbox" name="grafica"> {$question_q3AnswersMulti[4]|escape}</td></tr>
	<tr>
	 <td><input type="checkbox" name="prog"> {$question_q3AnswersMulti[5]|escape}</td></tr>
</table>

 <p>&nbsp;</p>

		
 <p class="NormalC">{$question_PersonalNotes|escape} </p>
 <table width="90%" align="center" class="Normal" summary="">
	<tr><td><textarea cols="50" rows="5" name="altro"></textarea></td></tr></table>

 <p>&nbsp;</p>

 <table width="90%" align="center" class="Normal" summary="">
	<tr><td><input type="checkbox" name="privacy"> {$question_Privacy|escape} </td></tr></table>
 
 <p align="center">&nbsp;<input type="submit" value="{$question_Send|escape}" name="quest_submit"></p>

</FORM>

</td></tr></table>

