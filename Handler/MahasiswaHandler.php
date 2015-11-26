<?php

namespace Ais\MahasiswaBundle\Handler;

use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\FormFactoryInterface;
use Ais\MahasiswaBundle\Model\MahasiswaInterface;
use Ais\MahasiswaBundle\Form\MahasiswaType;
use Ais\MahasiswaBundle\Exception\InvalidFormException;

class MahasiswaHandler implements MahasiswaHandlerInterface
{
    private $om;
    private $entityClass;
    private $repository;
    private $formFactory;

    public function __construct(ObjectManager $om, $entityClass, FormFactoryInterface $formFactory)
    {
        $this->om = $om;
        $this->entityClass = $entityClass;
        $this->repository = $this->om->getRepository($this->entityClass);
        $this->formFactory = $formFactory;
    }

    /**
     * Get a Mahasiswa.
     *
     * @param mixed $id
     *
     * @return MahasiswaInterface
     */
    public function get($id)
    {
        return $this->repository->find($id);
    }

    /**
     * Get a list of Mahasiswas.
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0)
    {
        return $this->repository->findBy(array(), null, $limit, $offset);
    }

    /**
     * Create a new Mahasiswa.
     *
     * @param array $parameters
     *
     * @return MahasiswaInterface
     */
    public function post(array $parameters)
    {
        $mahasiswa = $this->createMahasiswa();

        return $this->processForm($mahasiswa, $parameters, 'POST');
    }

    /**
     * Edit a Mahasiswa.
     *
     * @param MahasiswaInterface $mahasiswa
     * @param array         $parameters
     *
     * @return MahasiswaInterface
     */
    public function put(MahasiswaInterface $mahasiswa, array $parameters)
    {
        return $this->processForm($mahasiswa, $parameters, 'PUT');
    }

    /**
     * Partially update a Mahasiswa.
     *
     * @param MahasiswaInterface $mahasiswa
     * @param array         $parameters
     *
     * @return MahasiswaInterface
     */
    public function patch(MahasiswaInterface $mahasiswa, array $parameters)
    {
        return $this->processForm($mahasiswa, $parameters, 'PATCH');
    }

    /**
     * Processes the form.
     *
     * @param MahasiswaInterface $mahasiswa
     * @param array         $parameters
     * @param String        $method
     *
     * @return MahasiswaInterface
     *
     * @throws \Ais\MahasiswaBundle\Exception\InvalidFormException
     */
    private function processForm(MahasiswaInterface $mahasiswa, array $parameters, $method = "PUT")
    {
        $form = $this->formFactory->create(new MahasiswaType(), $mahasiswa, array('method' => $method));
        $form->submit($parameters, 'PATCH' !== $method);
        if ($form->isValid()) {

            $mahasiswa = $form->getData();
            $this->om->persist($mahasiswa);
            $this->om->flush($mahasiswa);

            return $mahasiswa;
        }

        throw new InvalidFormException('Invalid submitted data', $form);
    }

    private function createMahasiswa()
    {
        return new $this->entityClass();
    }

}
