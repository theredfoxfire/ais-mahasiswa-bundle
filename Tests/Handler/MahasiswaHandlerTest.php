<?php

namespace Ais\MahasiswaBundle\Tests\Handler;

use Ais\MahasiswaBundle\Handler\MahasiswaHandler;
use Ais\MahasiswaBundle\Model\MahasiswaInterface;
use Ais\MahasiswaBundle\Entity\Mahasiswa;

class MahasiswaHandlerTest extends \PHPUnit_Framework_TestCase
{
    const MAHASISWA_CLASS = 'Ais\MahasiswaBundle\Tests\Handler\DummyMahasiswa';

    /** @var MahasiswaHandler */
    protected $mahasiswaHandler;
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $om;
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $repository;

    public function setUp()
    {
        if (!interface_exists('Doctrine\Common\Persistence\ObjectManager')) {
            $this->markTestSkipped('Doctrine Common has to be installed for this test to run.');
        }
        
        $class = $this->getMock('Doctrine\Common\Persistence\Mapping\ClassMetadata');
        $this->om = $this->getMock('Doctrine\Common\Persistence\ObjectManager');
        $this->repository = $this->getMock('Doctrine\Common\Persistence\ObjectRepository');
        $this->formFactory = $this->getMock('Symfony\Component\Form\FormFactoryInterface');

        $this->om->expects($this->any())
            ->method('getRepository')
            ->with($this->equalTo(static::MAHASISWA_CLASS))
            ->will($this->returnValue($this->repository));
        $this->om->expects($this->any())
            ->method('getClassMetadata')
            ->with($this->equalTo(static::MAHASISWA_CLASS))
            ->will($this->returnValue($class));
        $class->expects($this->any())
            ->method('getName')
            ->will($this->returnValue(static::MAHASISWA_CLASS));
    }


    public function testGet()
    {
        $id = 1;
        $mahasiswa = $this->getMahasiswa();
        $this->repository->expects($this->once())->method('find')
            ->with($this->equalTo($id))
            ->will($this->returnValue($mahasiswa));

        $this->mahasiswaHandler = $this->createMahasiswaHandler($this->om, static::MAHASISWA_CLASS,  $this->formFactory);

        $this->mahasiswaHandler->get($id);
    }

    public function testAll()
    {
        $offset = 1;
        $limit = 2;

        $mahasiswas = $this->getMahasiswas(2);
        $this->repository->expects($this->once())->method('findBy')
            ->with(array(), null, $limit, $offset)
            ->will($this->returnValue($mahasiswas));

        $this->mahasiswaHandler = $this->createMahasiswaHandler($this->om, static::MAHASISWA_CLASS,  $this->formFactory);

        $all = $this->mahasiswaHandler->all($limit, $offset);

        $this->assertEquals($mahasiswas, $all);
    }

    public function testPost()
    {
        $title = 'title1';
        $body = 'body1';

        $parameters = array('title' => $title, 'body' => $body);

        $mahasiswa = $this->getMahasiswa();
        $mahasiswa->setTitle($title);
        $mahasiswa->setBody($body);

        $form = $this->getMock('Ais\MahasiswaBundle\Tests\FormInterface'); //'Symfony\Component\Form\FormInterface' bugs on iterator
        $form->expects($this->once())
            ->method('submit')
            ->with($this->anything());
        $form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));
        $form->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($mahasiswa));

        $this->formFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($form));

        $this->mahasiswaHandler = $this->createMahasiswaHandler($this->om, static::MAHASISWA_CLASS,  $this->formFactory);
        $mahasiswaObject = $this->mahasiswaHandler->post($parameters);

        $this->assertEquals($mahasiswaObject, $mahasiswa);
    }

    /**
     * @expectedException Ais\MahasiswaBundle\Exception\InvalidFormException
     */
    public function testPostShouldRaiseException()
    {
        $title = 'title1';
        $body = 'body1';

        $parameters = array('title' => $title, 'body' => $body);

        $mahasiswa = $this->getMahasiswa();
        $mahasiswa->setTitle($title);
        $mahasiswa->setBody($body);

        $form = $this->getMock('Ais\MahasiswaBundle\Tests\FormInterface'); //'Symfony\Component\Form\FormInterface' bugs on iterator
        $form->expects($this->once())
            ->method('submit')
            ->with($this->anything());
        $form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(false));

        $this->formFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($form));

        $this->mahasiswaHandler = $this->createMahasiswaHandler($this->om, static::MAHASISWA_CLASS,  $this->formFactory);
        $this->mahasiswaHandler->post($parameters);
    }

    public function testPut()
    {
        $title = 'title1';
        $body = 'body1';

        $parameters = array('title' => $title, 'body' => $body);

        $mahasiswa = $this->getMahasiswa();
        $mahasiswa->setTitle($title);
        $mahasiswa->setBody($body);

        $form = $this->getMock('Ais\MahasiswaBundle\Tests\FormInterface'); //'Symfony\Component\Form\FormInterface' bugs on iterator
        $form->expects($this->once())
            ->method('submit')
            ->with($this->anything());
        $form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));
        $form->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($mahasiswa));

        $this->formFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($form));

        $this->mahasiswaHandler = $this->createMahasiswaHandler($this->om, static::MAHASISWA_CLASS,  $this->formFactory);
        $mahasiswaObject = $this->mahasiswaHandler->put($mahasiswa, $parameters);

        $this->assertEquals($mahasiswaObject, $mahasiswa);
    }

    public function testPatch()
    {
        $title = 'title1';
        $body = 'body1';

        $parameters = array('body' => $body);

        $mahasiswa = $this->getMahasiswa();
        $mahasiswa->setTitle($title);
        $mahasiswa->setBody($body);

        $form = $this->getMock('Ais\MahasiswaBundle\Tests\FormInterface'); //'Symfony\Component\Form\FormInterface' bugs on iterator
        $form->expects($this->once())
            ->method('submit')
            ->with($this->anything());
        $form->expects($this->once())
            ->method('isValid')
            ->will($this->returnValue(true));
        $form->expects($this->once())
            ->method('getData')
            ->will($this->returnValue($mahasiswa));

        $this->formFactory->expects($this->once())
            ->method('create')
            ->will($this->returnValue($form));

        $this->mahasiswaHandler = $this->createMahasiswaHandler($this->om, static::MAHASISWA_CLASS,  $this->formFactory);
        $mahasiswaObject = $this->mahasiswaHandler->patch($mahasiswa, $parameters);

        $this->assertEquals($mahasiswaObject, $mahasiswa);
    }


    protected function createMahasiswaHandler($objectManager, $mahasiswaClass, $formFactory)
    {
        return new MahasiswaHandler($objectManager, $mahasiswaClass, $formFactory);
    }

    protected function getMahasiswa()
    {
        $mahasiswaClass = static::MAHASISWA_CLASS;

        return new $mahasiswaClass();
    }

    protected function getMahasiswas($maxMahasiswas = 5)
    {
        $mahasiswas = array();
        for($i = 0; $i < $maxMahasiswas; $i++) {
            $mahasiswas[] = $this->getMahasiswa();
        }

        return $mahasiswas;
    }
}

class DummyMahasiswa extends Mahasiswa
{
}
