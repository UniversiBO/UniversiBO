<?php
namespace Universibo\Bundle\LegacyBundle\Tests\Entity\Files;

use Universibo\Bundle\CoreBundle\Entity\User;
use Universibo\Bundle\CoreBundle\Tests\Entity\EntityTest;
use Universibo\Bundle\LegacyBundle\Entity\Files\FileItem;

class FileItemTest extends EntityTest
{
    /**
     * @var User
     */
    private $file;

    protected function setUp()
    {
        $this->file = new FileItem(1, 255, 255, 81, '$titolo', '$descrizione', 45345345, 3443737, 34535, 0, 'hello.jpg', 1, 1, '', '', '', '', '', '', '');
    }

    /**
     * @dataProvider accessorDataProvider
     *
     * @param string $name
     * @param mixed  $value
     */
    public function testAccessors($name, $value)
    {
        $this->autoTestAccessor($this->file, $name, $value);
    }

    public function accessorDataProvider()
    {
        return [
            ['idFile', 42],
            ['categoriaDesc', 'esami']
        ];
    }
}
