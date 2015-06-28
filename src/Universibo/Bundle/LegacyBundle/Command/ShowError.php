<?php
namespace Universibo\Bundle\LegacyBundle\Command;

use Symfony\Component\HttpFoundation\Request;
use Universibo\Bundle\LegacyBundle\App\UniversiboCommand;

/**
 * ShowError: mostra una pagina con la descrizione dell'errore per gli ErrorDefault
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 * @todo implementare il log degli errori tramite il logger.
 */
class ShowError extends UniversiboCommand
{
    public function execute(Request $request)
    {
        $frontcontroller = $this->getFrontController();
        $template = $frontcontroller->getTemplateEngine();

        $session = $this->get('session');

        $param = $session->get('error_param', ['msg' => 'Errore di sistema']);

        $template->assign('error_default', $param['msg']);

        return 'default';
    }
}
