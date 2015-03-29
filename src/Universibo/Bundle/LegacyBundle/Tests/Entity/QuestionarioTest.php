<?php
namespace Universibo\Bundle\LegacyBundle\Tests\Entity;

use Universibo\Bundle\CoreBundle\Tests\Entity\EntityTest;
use Universibo\Bundle\LegacyBundle\Entity\Questionario;

class QuestionarioTest extends EntityTest
{
    /**
     * @var Questionario
     */
    private $questionario;

    protected function setUp()
    {
        $this->questionario = new Questionario();
    }

    /**
     * @dataProvider accessorDataProvider
     *
     * @param string $name
     * @param mixed  $value
     */
    public function testAccessors($name, $value)
    {
        $this->autoTestAccessor($this->questionario, $name, $value, true);
    }

    public function accessorDataProvider()
    {
        return [
            ['id', rand()],
            ['data', rand()],
            ['nome', 'Mario'],
            ['cognome', 'Rossi'],
            ['mail', 'hello@example.com'],
            ['telefono', '3401234567'],
            ['tempoDisponibile', 42],
            ['tempoInternet', 42],
            ['attivitaOffline', 'S'],
            ['attivitaModeratore', 'S'],
            ['attivitaContenuti', 'S'],
            ['attivitaTest', 'S'],
            ['attivitaGrafica', 'S'],
            ['attivitaProgettazione', 'S'],
            ['altro', 'Hello '.rand()],
            ['idUtente', 43],
            ['cdl', 'gestionale']
        ];
    }
}
