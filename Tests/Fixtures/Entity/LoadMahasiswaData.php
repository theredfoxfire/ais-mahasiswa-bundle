<?php

namespace Ais\MahasiswaBundle\Tests\Fixtures\Entity;

use Ais\MahasiswaBundle\Entity\Mahasiswa;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;


class LoadMahasiswaData implements FixtureInterface
{
    static public $mahasiswas = array();

    public function load(ObjectManager $manager)
    {
        $mahasiswa = new Mahasiswa();
        $mahasiswa->setTitle('title');
        $mahasiswa->setBody('body');

        $manager->persist($mahasiswa);
        $manager->flush();

        self::$mahasiswas[] = $mahasiswa;
    }
}
