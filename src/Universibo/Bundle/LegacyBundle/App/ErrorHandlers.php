<?php
namespace Universibo\Bundle\LegacyBundle\App;

use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Universibo\Bundle\LegacyBundle\Exception\Exception;
use Universibo\Bundle\LegacyBundle\Framework\Error;
use Universibo\Bundle\LegacyBundle\Framework\FrontController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Definisce gli handler da utilizzare per la classe Error,
 * si ? deciso di raggrupparli in questa classe solo per dagli un ordine migliore.
 *
 * @package universibo
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, <{@link http://www.opensource.org/licenses/gpl-license.php}>
 * @copyright CopyLeft UniversiBO 2001-2003
 * @todo implementare le operazioni sul logger
 */

class ErrorHandlers
{
    const LEVEL_DEFAULT = 0;
    const LEVEL_CRITICAL = 1;
    const LEVEL_NOTICE = 2;

    /**
     * Logger
     *
     * @var LoggerInterface
     */
    private $logger;

    private $session;

    public function __construct(LoggerInterface $logger, SessionInterface $session)
    {
        $this->logger = $logger;
        $this->session = $session;
    }

    /**
     * Handler per errori di categoria ERROR_CRITICAL
     * Salva l'indicazione dell'errore sul logger, insieme a tutti i parametri della richiesta,
     * Mostra sul browser un messaggio di errore e interrompe l'esecuzione
     *
     * @param $param mixed,array Tipo restituito da chi cattura l'errore,
     * questo handler ? in grado di gestire un parametro array avente la seguente struttura
     * $param = [  "msg"=>"messaggio di errore da mostrare",
     *                  "file"=>"file in cui ? avvenuto l'errore",
     *                  "line"=>"linea di codice in cui ? avvenuto l'errore",
     *                  "log"=>"(opzionale)se impostato viene salvato come messaggio sul logger"
     *                  ]
     */
    public function critical_handler($param)
    {
        throw new Exception($param['msg']);
    }

    /**
     * Handler per errori di categoria ERROR_DEFAULT
     * Salva opzionalmente l'indicazione dell'errore sul logger, insieme a tutti i parametri della richiesta,
     * Redirige il browser ad una pagina dell'applicazione in cui viene mostrato il messaggio di errore
     *
     * @param $param mixed,[] Tipo restituito da chi cattura l'errore,
     * questo handler ? in grado di gestire un parametro arrequireray avente la seguente struttura
     * $param = [  "msg"=>"messaggio di errore da mostrare",
     *                  "file"=>"file in cui ? avvenuto l'errore",
     *                  "line"=>"linea di codice in cui ? avvenuto l'errore",
     *                  "log"=>"(opzionale)se impostato viene salvato come messaggio sul logger"
     *                  ]
     */
    public function default_handler($param)
    {
        $this->session->set('error_param', $param);

        $log_array = [ 'timestamp'  => time(),
                'date'  => date("Y-m-d",time()),
                'time'  => date("H:i",time()),
                'error_level'  => 'DEFAULT',
                'id_utente' => (array_key_exists('id_utente',$param)) ? $param['id_utente'] : -1,
                'ip_utente' => (isset($_SERVER) && array_key_exists('REMOTE_ADDR',$_SERVER))? $_SERVER['REMOTE_ADDR']: '0.0.0.0',
                'file'  => $param['file'],
                'line'  => $param['line'],
        ];

        $this->logger->error($param['msg'], $log_array);

        $uri = FrontController::getContainer()->get('router')->generate('universibo_legacy_error', [], true);
        FrontController::redirectUri($uri);
        exit(1);
    }

    /**
     * Handler per errori di categoria ERROR_NOTICE
     * Appende il messaggio di errore, in una variabile del TemplateEngine.
     * NON interrompe l'esecuzione.
     *
     * @param $param mixed,[] Tipo restituito da chi cattura l'errore,
     * questo handler ? in grado di gestire un parametro array avente la seguente struttura
     * $param = [  "msg"=>"messaggio di errore da mostrare",
     *                  "file"=>"file in cui ? avvenuto l'errore",
     *                  "line"=>"linea di codice in cui ? avvenuto l'errore",
     *                  "log"=>"(opzionale)se impostato viene salvato come messaggio sul logger",
     *                  "template_engine"=>"Riferimento all'oggetto template engine"
     *                  ]
     */
    public function notice_handler($param)
    {

        $template = $param['template_engine'];
        $template->assign('error_notice_present', 'true');

        if (array_key_exists('log', $param) && $param['log'] == true ) {
            $log_array = [ 'timestamp'  => time(),
                    'date'  => date("Y-m-d",time()),
                    'time'  => date("H:i",time()),
                    'error_level'  => 'DEFAULT',
                    'id_utente' => (array_key_exists('id_utente',$param)) ? $param['id_utente'] : -1,
                    'ip_utente' => (isset($_SERVER) && array_key_exists('REMOTE_ADDR',$_SERVER))? $_SERVER['REMOTE_ADDR']: '0.0.0.0',
                    'file'  => $param['file'],
                    'line'  => $param['line'],
            ];
            $this->logger->notice($param['msg'], $log_array);
        }
        /** ALTERNATIVA ALL'USO DI append()
         $current_error = $template->get_template_vars('error_notice');
         if ($current_error == NULL) {
         $current_error = [];require
         }
         $current_error[] = $param['msg'];
         $template->assign('error_notice', $current_error);
         */
        $template->append('error_notice', $param['msg']);

        /**
         echo 'Notice: ',$param['msg'], '<br />
         file: ',$param['file'], '<br />
         line: ',$param['line'], '<br />
         log: ',$param['log'], '<br />
         template engine: ',$param['template_engine'], '<br />';
         */
    }

    public function register()
    {
        Error::setHandler(self::LEVEL_DEFAULT, [$this, 'default_handler']);
        Error::setHandler(self::LEVEL_CRITICAL, [$this, 'critical_handler']);
        Error::setHandler(self::LEVEL_NOTICE, [$this, 'notice_handler']);
    }
}

define('_ERROR_DEFAULT'  ,ErrorHandlers::LEVEL_DEFAULT);
define('_ERROR_CRITICAL' ,ErrorHandlers::LEVEL_CRITICAL);
define('_ERROR_NOTICE'   ,ErrorHandlers::LEVEL_NOTICE);
