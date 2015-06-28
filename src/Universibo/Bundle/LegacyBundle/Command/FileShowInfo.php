<?php
namespace Universibo\Bundle\LegacyBundle\Command;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Universibo\Bundle\LegacyBundle\App\UniversiboCommand;

/**
 * FileShowInfo: mostra tutte le informazioni correlate ad un file
 *
 * @package universibo
 * @subpackage commands
 * @version 2.0.0
 * @author Ilias Bartolini <brain79@virgilio.it>
 * @license GPL, {@link http://www.opensource.org/licenses/gpl-license.php}
 */

class FileShowInfo extends UniversiboCommand
{
    public function execute(Request $request)
    {
        $frontcontroller = $this->getFrontController();

        $template = $frontcontroller->getTemplateEngine();
        $id_file = $request->attributes->get('id_file');

        if (!preg_match('/^([0-9]{1,9})$/', $id_file)) {
            throw new NotFoundHttpException('Invalid file ID');
        }

        $tipo_file = $this->get('universibo_legacy.repository.files.file_item_studenti')->isFileStudenti($id_file);

        if (null != ($id_canale = $request->get('id_canale'))) {
            $this->executePlugin('ShowFileInfo', ['id_file' => $id_file,
                                    'id_canale' => $id_canale]);
        } else
            $this->executePlugin('ShowFileInfo', ['id_file' => $id_file]);
        if ($tipo_file == true) {
            $template->assign('isFileStudente', 'true');
            $this
                    ->executePlugin('ShowFileStudentiCommenti',
                            ['id_file' => $id_file]);
        } else
            $template->assign('isFileStudente', 'false');

        return;

    }
}
