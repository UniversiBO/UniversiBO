<?php

include ('UniversiboCommand'.PHP_EXTENSION);

/**
 * ShowCredits is an extension of UniversiboCommand class.
 *
 * It shows Credits page
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Fabrizio Pinto
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */
 
class ShowCredits extends UniversiboCommand {
	function execute(){

		$frontcontroller =& $this->getFrontController();
		$template =& $frontcontroller->getTemplateEngine();
		
		$template->assign('showCredits_langTitleAlt','Credits');
		$template->assign('showCredits_langIntro','Questo sito è stato realizzato e funziona utilizzando internamente solo software freeware e open source e appoggiandosi alle altre strutture rese disponibili dall\'ateneo');
		$template->assign('showCredits_langDebian','Il sistema operativo su cui si appoggia il nostro server è GNU Linux di cui abbiamo scelto la distribuzione Debian relase Woody
[url=http://www.debian.org]www.debian.org[/url]		');
		$template->assign('showCredits_langApache','Il programma di web server utilizzato è il diffusissimo Apache Web Server e per mantenere la massima sicurezza dei dati inviati viene utilizzato il protocollo HTTPS/SSL 
[url=http://www.apache.org]www.apache.org[/url]	');
		$template->assign('showCredits_langPostgres','Come programma di database locale per il mantenimento e trattamento dei dati si è scelto PostgreSQL
[url=http://www.postgresql.org]www.postgresql.org[/url]
		');
		$template->assign('showCredits_langPhp','Il motore utilizzato per creare e scrivere le pagine di questo sito è basato su PHP4, il codice sorgente di queste pagine sarà reso disponibile con licenza GPL appena tecnicamente possibile.
[url=http://www.php.net]www.php.net[/url]
		');
		$template->assign('showCredits_langPhpbb','In queste pagine abbiamo integrato componenti e moduli PHP OpenSource disponibili con licenza GPL.
La classe PHPMailer per la gestione dell\'inoltro delle mail
[url=htpp://phpmailer.sourceforge.net]phpmailer.sourceforge.net[/url]
Il forum è basato su PHPBB a cui sono state apportate piccole modifiche
[url=http://www.phpbb.com]www.phpbb.com[/url]
		');
		$template->assign('showCredits_langW3c','Le pagine sono create nell\'intento di rispettare gli standard più diffusi e di permettere la maggiore accessibilità possibile per tutti.
[url=http://www.w3c.org]www.w3c.org[/url]
		');
		$template->assign('showCredits_langSmarty','Si è utilizzato il template engine Smarty per scindere la presentazione delle informazioni dalla logica applicativa.
[url=http://smarty.php.net]smarty.php.net[/url]
		');
				
		return 'default';						
	}
}

?>