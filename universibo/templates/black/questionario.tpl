
&nbsp;<br />
<img src="tpl/black/questionario_18.gif" width="144" height="22" alt="{$question_TitleAlt|escape:"htmlall"}" />
&nbsp;<br />
&nbsp;<br />
<table align="center" cellspacing="0" cellpadding="0" width="90%" summary="">
<tr>
<td class="Normal">

 {* come vogliamo gestire il get *}
 
<form action="aChiLoMando" id="f3" method="post">
<fieldset>
<legend><p class="NormalC">{$question_PersonalInfo|escape:"htmlall"}</p></legend>
<table width="90%" align="center" class="Normal" summary="">
<tr>
<td><label for="f3_nome">{$question_PersonalInfoData[0]|escape:"htmlall"}</label></td>
<td><input id="f3_nome" maxLength="30" size="50" name="f3_nome"></td>
</tr>
<tr>
<td><label for="f3_cognome">{$question_PersonalInfoData[1]|escape:"htmlall"}</label></td>
<td><input id="f3_cognome" maxLength="30" size="50" name="f3_cognome"></td>
</tr>
<tr>
<td><label for="f3_mail">{$question_PersonalInfoData[2]|escape:"htmlall"}</label></td>
<td><input id="f3_mail" maxLength="30" size="50" name="f3_mail"></td>
</tr>
<tr>
<td><label for="f3_tel">{$question_PersonalInfoData[3]|escape:"htmlall"}</label></td>
<td><input id="f3_tel" maxLength="30" size="50" name="f3_tel"></td>
</tr>
</table>
</fieldset>
 <p>&nbsp;</p>

	<fieldset>
	<legend><p class="NormalC">{$question_q1|escape:"htmlall"}</p></legend>
	 <table width="90%" align="center" class="Normal" summary="">
	<tr>
	 <td><input id="f3_tempo_0" type="radio" value="120" name="f3_tempo"> <label for="f3_tempo_0">{$question_q1Answers[0]|escape:"htmlall"}</label></td></tr>
	<tr>
	 <td><input id="f3_tempo_1" type="radio" value="30" name="f3_tempo"> <label for="f3_tempo_1">{$question_q1Answers[1]|escape:"htmlall"}</label></td></tr>
	<tr>
	 <td><input id="f3_tempo_2" type="radio" value="1" name="f3_tempo"> <label for="f3_tempo_2">{$question_q1Answers[2]|escape:"htmlall"}</label></td></tr></table>
	</fieldset>
 <p>&nbsp;</p>

	<fieldset>
	<legend><p class="NormalC">{$question_q2|escape:"htmlall"}</p></legend>
		<table width="90%" align="center" class="Normal" summary="">
		<tr><td><input type="radio" id="f3_internet_0" name="f3_internet" value="1"> <label for="f3_internet_0">{$question_q2Answers[0]|escape:"htmlall"}</label></td>
		</tr>
		<tr><td><input type="radio" id="f3_internet_1" name="f3_internet" value="60"> <label for="f3_internet_1">{$question_q2Answers[1]|escape:"htmlall"}</label></td>
		</tr>
		<tr><td><input type="radio" id="f3_internet_2" name="f3_internet" value="200"> <label for="f3_internet_2">{$question_q2Answers[2]|escape:"htmlall"}</label></td>
		</tr>
		<tr><td><input type="radio" id="f3_internet_3" name="f3_internet" value="1000"> <label for="f3_internet_3">{$question_q2Answers[3]|escape:"htmlall"}</label></td>
		</tr>
	</table>
	</fieldset>
 <p>&nbsp;</p>

	<fieldset>
	<legend><p class="NormalC">{$question_q3|escape:"htmlall"}</p></legend>
	<table width="90%" align="center" class="Normal" summary="">
	<tr>
	 <td><input id="f3_offline" type="checkbox" name="f3_offline"> <label for="f3_offline">{$question_q3AnswersMulti[0]|escape:"htmlall"}</label></td></tr>
		<tr>
	 <td><input id="f3_moderatore" type="checkbox" name="f3_moderatore"> <label for="f3_moderatore">{$question_q3AnswersMulti[1]|escape:"htmlall"}</label></td></tr>
	<tr>
	 <td><input id="f3_contenuti" type="checkbox" name="f3_contenuti"> <label for="f3_contenuti">{$question_q3AnswersMulti[2]|escape:"htmlall"}</label></td></tr>
	<tr>
	 <td><input id="f3_test" type="checkbox" name="f3_test"> <label for="f3_test">{$question_q3AnswersMulti[3]|escape:"htmlall"}</label></td></tr>
	<tr>
	 <td><input id="f3_grafica" type="checkbox" name="f3_grafica"> <label for="f3_grafica">{$question_q3AnswersMulti[4]|escape:"htmlall"}</label></td></tr>
	<tr>
	 <td><input id="f3_prog" type="checkbox" name="f3_prog"> <label for="f3_prog">{$question_q3AnswersMulti[5]|escape:"htmlall"}</td></tr>
	</table>
	</fieldset>
 <p>&nbsp;</p>

		
 <label for="f3_altro"><p class="NormalC">{$question_PersonalNotes|escape} </p></label>
 <table width="90%" align="center" class="Normal" summary="">
	<tr><td><textarea id="f3_altro" cols="50" rows="5" name="f3_altro"></textarea></td></tr></table>

 <p>&nbsp;</p>

 <table width="90%" align="center" class="Normal" summary="">
	<tr><td><input id="f3_privacy" type="checkbox" name="f3_privacy"> <label for="f3_privacy">{$question_Privacy|escape}</label></td></tr></table>
 
 <p align="center">&nbsp;<input type="submit" value="{$question_Send|escape}" name="quest_submit"></p>

</form>

</td></tr></table>

