{if $common_pageType == "index"}
{include file=header_index.tpl}
{elseif $common_pageType == "popup"}
{include file=header_popup.tpl}
{/if}

<table width="98%" border="0" summary="">
  <tbody>
    <tr> 
      <td class="testoOcchiello" align="left" width="100%">sei in: <SPAN class="sei_in">Facoltà 
        -> Ingegneria -> Gestionale V.O. </SPAN></TD>
    </tr>
    <tr> 
      <td class="testoOcchiello" align="left" width="100%"><table width="90%" border="0" align="center" summary="">                  
    <tr> 
      <!--spazio per i CDLdi facoltà -->
      <td><table vAlign="center" align="left" width="100%" border="0" cellspacing="0" summary="">
          <tbody>
            <tr><br/> 
              <td class="titoloHome" align="center">
                  {$ins_title} AA {$ins_annoAccademico}</td>
			                     
			<tr><td>&nbsp;</td></tr>
			<tr><td align="center" class="testoOcchiello">{$ins_nomeDoc}</td></tr>
			<tr><td>&nbsp;</td></tr>
			<tr> 
              
            <td align="center"  colspan="2"><a class="menu" href=""><img src="universibo_file/cartellina-in.gif" width="15" height="15" border="0" hspace="3" alt="aggiungi ai preferiti">aggiungi 
              l'esame {$ins_lang} ai tuoi preferiti </a></td>
            </tr>
          </tbody>
        </table></td>
    </tr>
    
    <tr>
      <!-- terza riga della tabella centrale contenente il primo blocchetto di esami lauree triennali -->
      <td><table width="70%" border="0" align="center" cellpadding="5" cellspacing="0" class="testoOcchiello" summary="">
          <tbody>
            <tr> 
              <td bgcolor="#999999" height="1" ></td>
            </tr>
            <!--bordino grigio-->
            <tr> 
              <td bgcolor="#EFEFEF"><table width="100%" align="center" cellpadding="0" cellspacing="2" border="0" summary="">
                  <tr> 
                    <td  width="33%"> 
                      <!-- primo blocchetto work in progress -->
                      <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" summary="">
                        <!-- TABELLA BORDINI GRIGI -->
                        <tr> 
                          <td bgcolor="#999999" height="1" colspan="5"></td>
                        </tr>
                        <tr> 
                          <td width="1" bgcolor="#999999"><img border="0" src="universibo_file/spacer.gif"></td>
                          <td align="center"> <table width="100%" cellSpacing="0" cellPadding="3" border="0" summary="">
                              <tbody>
                                <tr> 
                                  <td class="testoOcchiello"  align="center">{$ins_langForum}<a href=""></a></td>
                                  <td><a href="{$ins_langForumLink}"><img align="center" src="universibo_file/forum.gif" border="0" alt="forum esame"></a></td>
                                </tr>
                              </tbody>
                            </table></td>
                          <td width="1" bgcolor="#999999"><img border="0" src="universibo_file/spacer.gif"></td>
                        </tr>
                        <tr> 
                          <td bgcolor="#999999" height="1" colspan="3"></td>
                        </tr>
                      </table></td>
                    <!-- fine primo blocchetto work in process -->
                    <td width="33%"> 
                      <!--secondo blocchetto work in process -->
                      <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" summary="">
                        <!-- TABELLA BORDINI GRIGI -->
                        <tr> 
                          <td bgcolor="#999999" height="1" colspan="5"></td>
                        </tr>
                        <tr> 
                          <td width="1" bgcolor="#999999"><img border="0" src="universibo_file/spacer.gif"></td>
                          <td align="center"> <table width="100%" cellSpacing="0" cellPadding="3" border="0" summary="">
                              <tbody>
                                <tr> 
                                  <td class="testoOcchiello" align="center">{$ins_langAppelli}<a href=""></a></td>
                                  <td><a href="{$ins_langAppelliLink}"><img align="center" src="universibo_file/appelli.gif" border="0" alt="appelli esame"></a></td>
                                </tr>
                              </tbody>
                            </table></td>
                          <td width="1" bgcolor="#999999"><img border="0" src="universibo_file/spacer.gif"></td>
                        </tr>
                        <tr> 
                          <td bgcolor="#999999" height="1" colspan="3"></td>
                        </tr>
                      </table></td>
                    <!-- fine secondo blocchetto work in process -->
                    <td width="33%"> 
                      <!--terzo blocchetto work in process -->
                      <table width="100%" border="0" cellspacing="0" cellpadding="0" align="center" summary="">
                        <!-- TABELLA BORDINI GRIGI -->
                        <tr> 
                          <td bgcolor="#999999" height="1" colspan="5"></td>
                        </tr>
                        <tr> 
                          <td width="1" bgcolor="#999999"><img border="0" src="universibo_file/spacer.gif"></td>
                          <td align="center"> <table width="100%" cellSpacing="0" cellPadding="3" border="0" summary="">
                              <tbody>
                                <tr> 
                                  <td class="testoOcchiello"  align="center">{$ins_langOrario}<a href=""></a></td>
                                  <td><a href="{$ins_langOrarioLink}"><img align="center" src="universibo_file/clock-4.gif" border="0" alt="orario lezioni"></a></td>
                                </tr>
                              </tbody>
                            </table></td>
                          <td width="1" bgcolor="#999999"><img border="0" src="universibo_file/spacer.gif"></td>
                        </tr>
                        <tr> 
                          <td bgcolor="#999999" height="1" colspan="3"></td>
                        </tr>
                      </table></td>
                    <!-- fine terzo blocchetto work in process -->
                  </tr>
                </table></td>
            </tr>					
			{*PRIMA RIGA*}
			{if $ins_langObiettiviLink==""}
            <tr> 
              <td bgcolor="#F8F8F8">&nbsp;{$ins_langObiettivi}</td>
            </tr>
			{else}
			 <tr> 
              <td bgcolor="#F8F8F8"><a href="{$ins_langObiettiviLink}">&nbsp;{$ins_langObiettivi}</a></td>
            </tr>
			{/if}					
			{*SECONDA RIGA*}
			{if $ins_langProgrammaLink==""}
            <tr> 
              <td bgcolor="#EFEFEF">&nbsp;{$ins_langProgramma}</td>
            </tr>
			{else}
			 <tr> 
              <td bgcolor="#EFEFEF"><a href="{$ins_langProgrammaLink}">&nbsp;{$ins_langProgramma}</a></td>
            </tr>
			{/if}
			{*TERZA RIGA*}
			{if $ins_langMaterialeLink==""}
            <tr> 
              <td bgcolor="#F8F8F8">&nbsp;{$ins_langMateriale}</td>
            </tr>
			{else}
			 <tr> 
              <td bgcolor="#F8F8F8"><a href="{$ins_langMaterialeLink}">&nbsp;{$ins_langMateriale}</a></td>
            </tr>
			{/if}
			{*QUARTA RIGA*}
			{if $ins_langModalitaLink==""}
            <tr> 
              <td bgcolor="#EFEFEF">&nbsp;{$ins_langModalita}</td>
            </tr>
			{else}
			 <tr> 
              <td bgcolor="#EFEFEF"><a href="{$ins_langModalitaLink}">&nbsp;{$ins_langModalita}</a></td>
            </tr>
			{/if}                  
          </tbody>
        </table></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
    </tr></table>

{if $common_pageType == "index"}
{include file=footer_index.tpl}
{elseif $common_pageType == "popup"}
{include file=footer_popup.tpl}
{/if}
    
