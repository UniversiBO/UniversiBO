{if $common_pageType == "index"}
{include file=header_index.tpl}
{elseif $common_pageType == "popup"}
{include file=header_popup.tpl}
{/if}

{* questo è solo un tentativo di ricreare il questionario... bisogna decidere 
a chi far controllare la correttezza dei risultati *}

<!-- INIZIO PAGINA CENTRALE -->

{include file=avviso_notice.tpl}


&nbsp;<br />
<img src="tpl/black/questionario_18.gif" width="144" height="22" alt="{$question_TitleAlt|escape}" />
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
<p class="NormalC">{$question_InformaticKnowledge|escape}</p>

<p class="NormalC">{$question_q4|escape}</p>

 <table width="90%" align="center" class="Normal" summary="">
	<tr><td>{$question_q4Sub1|escape}</td></tr>
	 
	<tr>
	 <td><input type="radio" value="4" name="win"> {$question_q4AnswersSub1[0]|escape}</td></tr>
	<tr>
	 <td><input type="radio" value="3" name="win"> {$question_q4AnswersSub1[1]|escape}</td></tr>
	<tr>
	 <td><input type="radio" value="1" name="win"> {$question_q4AnswersSub1[2]|escape}</td></tr>
 </table>
					
					
 <table width="90%" align="center" class="Normal" summary="">
	<tr><td>{$question_q4Sub2|escape}</td></tr>
	 
	<tr>
	 <td><input type="radio" value="4" name="linux"> {$question_q4AnswersSub2[0]|escape}</td></tr>
	<tr>
	 <td><input type="radio" value="3" name="linux"> {$question_q4AnswersSub2[1]|escape}</td></tr>
	<tr>
	 <td><input type="radio" value="1" name="linux"> {$question_q4AnswersSub2[2]|escape}</td></tr>
	<tr>
	 <td><input type="radio" value="0" name="linux"> {$question_q4AnswersSub2[3]|escape}</td></tr></table>
					
					
<p class="NormalC">{$question_q5|escape}</p>
 <table width="90%" align="center" class="Normal" summary="">
	<tr><td>{$question_q5Sub1|escape}</td></tr>
	<tr>
	 <td><input type="radio" value="4" name="html"> {$question_q5AnswersSub1[0]|escape}</td></tr>
	<tr>
	 <td><input type="radio" value="3" name="html"> {$question_q5AnswersSub1[1]|escape}</td></tr>
	<tr>
	 <td><input type="radio" value="0" name="html"> {$question_q5AnswersSub1[2]|escape}</td></tr></table>
				
				
 <table width="90%" align="center" class="Normal" summary="">
	<tr><td>{$question_q5Sub2|escape}</td></tr>
	 
	<tr>
	 <td><input type="radio" value="4" name="php"> {$question_q5AnswersSub2[0]|escape}</td></tr>
	<tr>
	 <td><input type="radio" value="2" name="php"> {$question_q5AnswersSub2[1]|escape}</td></tr>
	<tr>
	 <td><input type="radio" value="0" name="php"> {$question_q5AnswersSub2[2]|escape}</td></tr></table>
				
				
 <table width="90%" align="center" class="Normal" summary="">
	<tr><td>{$question_q5Sub3|escape}</td></tr>
	 
	<tr>
	 <td><input type="radio" value="4" name="javascript"> {$question_q5AnswersSub3[0]|escape}</td></tr>
	<tr>
	 <td><input type="radio" value="2" name="javascript"> {$question_q5AnswersSub3[1]|escape}</td></tr>
	<tr>
	 <td><input type="radio" value="0" name="javascript"> {$question_q5AnswersSub3[2]|escape}</td></tr></table>
				
				
 <table width="90%" align="center" class="Normal" summary="">
	<tr><td>{$question_q5Sub4|escape}</td></tr>
	 
	<tr>
 <td><input type="radio" value="4" name="xml"> {$question_q5AnswersSub4[0]|escape}</td></tr>
	<tr>
 <td><input type="radio" value="2" name="xml"> {$question_q5AnswersSub4[1]|escape}</td></tr>
  <tr>
	 <td><input type="radio" value="0" name="xml"> {$question_q5AnswersSub4[2]|escape}</td></tr></table>
				
				
				
 <table width="90%" align="center" class="Normal" summary="">
	<tr><td>{$question_q5Sub5|escape}</td></tr>
	 
	<tr>
	 <td><input type="radio" value="4" name="java"> {$question_q5AnswersSub5[0]|escape}</td></tr>
	<tr>
	 <td><input type="radio" value="2" name="java"> {$question_q5AnswersSub5[1]|escape}</td></tr>
	<tr>
	 <td><input type="radio" value="0" name="java"> {$question_q5AnswersSub5[2]|escape}</td></tr></table>


 <table width="90%" align="center" class="Normal" summary="">
	<tr><td>{$question_q5Sub6|escape}</td></tr>
	 
	<tr>
	 <td><input type="radio" value="4" name="sql"> {$question_q5AnswersSub6[0]|escape}</td></tr>
	<tr>
	 <td><input type="radio" value="2" name="sql"> {$question_q5AnswersSub6[1]|escape}</td></tr>
	<tr>
	 <td><input type="radio" value="0" name="sql"> {$question_q5AnswersSub6[2]|escape}</td></tr></table>
 
 <p class="NormalC">{$question_q6}</p>
 <table width="90%" align="center" class="Normal" summary="">
	<tr><td>{$question_q6Sub1|escape}</td></tr>
	 
	<tr>
	 <td><input type="radio" value="4" name="photoshop"> {$question_q6AnswersSub1[0]|escape} 
		</td></tr>
	<tr>
	 <td><input type="radio" value="2" name="photoshop"> {$question_q6AnswersSub1[1]|escape}</td></tr>
	<tr>
	 <td><input type="radio" value="0" name="photoshop"> {$question_q6AnswersSub1[2]|escape}</td></tr></table>
 <table width="90%" align="center" class="Normal" summary="">
	<tr><td>{$question_q6Sub2|escape}</td></tr>
	 
	<tr>
	 <td><input type="radio" value="4" name="gimp"> {$question_q6AnswersSub2[0]|escape} 
	</td></tr>
	<tr>
	 <td><input type="radio" value="2" name="gimp"> {$question_q6AnswersSub2[1]|escape} </td></tr>
	<tr> 
	 <td><input type="radio" value="0" name="gimp"> {$question_q6AnswersSub2[2]|escape} </td></tr></table>

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

{if $common_pageType == "index"}
{include file=footer_index.tpl}
{elseif $common_pageType == "popup"}
{include file=footer_popup.tpl}
{/if}