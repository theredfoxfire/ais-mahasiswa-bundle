<?php

namespace Ais\MahasiswaBundle\Model;

Interface MahasiswaInterface
{
	    /**
     * Get id
     *
     * @return integer
     */
    public function getId();

    /**
     * Set nim
     *
     * @param string $nim
     *
     * @return Mahasiswa
     */
    public function setNim($nim);

    /**
     * Get nim
     *
     * @return string
     */
    public function getNim();

    /**
     * Set nama
     *
     * @param string $nama
     *
     * @return Mahasiswa
     */
    public function setNama($nama);

    /**
     * Get nama
     *
     * @return string
     */
    public function getNama();

    /**
     * Set namaSingkat
     *
     * @param string $namaSingkat
     *
     * @return Mahasiswa
     */
    public function setNamaSingkat($namaSingkat);

    /**
     * Get namaSingkat
     *
     * @return string
     */
    public function getNamaSingkat();

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Mahasiswa
     */
    public function setUserId($userId);

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId();

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Mahasiswa
     */
    public function setEmail($email);

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail();

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Mahasiswa
     */
    public function setPhone($phone);

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone();

    /**
     * Set foto
     *
     * @param string $foto
     *
     * @return Mahasiswa
     */
    public function setFoto($foto);

    /**
     * Get foto
     *
     * @return string
     */
    public function getFoto();

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Mahasiswa
     */
    public function setIsActive($isActive);

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive();

    /**
     * Set isDelete
     *
     * @param boolean $isDelete
     *
     * @return Mahasiswa
     */
    public function setIsDelete($isDelete);

    /**
     * Get isDelete
     *
     * @return boolean
     */
    public function getIsDelete();
}
