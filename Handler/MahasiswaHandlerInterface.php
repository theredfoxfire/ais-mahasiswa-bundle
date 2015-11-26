<?php

namespace Ais\MahasiswaBundle\Handler;

use Ais\MahasiswaBundle\Model\MahasiswaInterface;

interface MahasiswaHandlerInterface
{
    /**
     * Get a Mahasiswa given the identifier
     *
     * @api
     *
     * @param mixed $id
     *
     * @return MahasiswaInterface
     */
    public function get($id);

    /**
     * Get a list of Mahasiswas.
     *
     * @param int $limit  the limit of the result
     * @param int $offset starting from the offset
     *
     * @return array
     */
    public function all($limit = 5, $offset = 0);

    /**
     * Post Mahasiswa, creates a new Mahasiswa.
     *
     * @api
     *
     * @param array $parameters
     *
     * @return MahasiswaInterface
     */
    public function post(array $parameters);

    /**
     * Edit a Mahasiswa.
     *
     * @api
     *
     * @param MahasiswaInterface   $dosen
     * @param array           $parameters
     *
     * @return MahasiswaInterface
     */
    public function put(MahasiswaInterface $dosen, array $parameters);

    /**
     * Partially update a Mahasiswa.
     *
     * @api
     *
     * @param MahasiswaInterface   $dosen
     * @param array           $parameters
     *
     * @return MahasiswaInterface
     */
    public function patch(MahasiswaInterface $dosen, array $parameters);
}
