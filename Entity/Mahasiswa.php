<?php

namespace Ais\MahasiswaBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Ais\MahasiswaBundle\Model\MahasiswaInterface;

/**
 * Mahasiswa
 */
class Mahasiswa implements MahasiswaInterface
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $nim;

    /**
     * @var string
     */
    private $nama;

    /**
     * @var string
     */
    private $nama_singkat;

    /**
     * @var integer
     */
    private $user_id;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $phone;

    /**
     * @var string
     */
    private $foto;

    /**
     * @var boolean
     */
    private $is_active;

    /**
     * @var boolean
     */
    private $is_delete;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nim
     *
     * @param string $nim
     *
     * @return Mahasiswa
     */
    public function setNim($nim)
    {
        $this->nim = $nim;

        return $this;
    }

    /**
     * Get nim
     *
     * @return string
     */
    public function getNim()
    {
        return $this->nim;
    }

    /**
     * Set nama
     *
     * @param string $nama
     *
     * @return Mahasiswa
     */
    public function setNama($nama)
    {
        $this->nama = $nama;

        return $this;
    }

    /**
     * Get nama
     *
     * @return string
     */
    public function getNama()
    {
        return $this->nama;
    }

    /**
     * Set namaSingkat
     *
     * @param string $namaSingkat
     *
     * @return Mahasiswa
     */
    public function setNamaSingkat($namaSingkat)
    {
        $this->nama_singkat = $namaSingkat;

        return $this;
    }

    /**
     * Get namaSingkat
     *
     * @return string
     */
    public function getNamaSingkat()
    {
        return $this->nama_singkat;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Mahasiswa
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Mahasiswa
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param string $phone
     *
     * @return Mahasiswa
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set foto
     *
     * @param string $foto
     *
     * @return Mahasiswa
     */
    public function setFoto($foto)
    {
        $this->foto = $foto;

        return $this;
    }

    /**
     * Get foto
     *
     * @return string
     */
    public function getFoto()
    {
        return $this->foto;
    }

    /**
     * Set isActive
     *
     * @param boolean $isActive
     *
     * @return Mahasiswa
     */
    public function setIsActive($isActive)
    {
        $this->is_active = $isActive;

        return $this;
    }

    /**
     * Get isActive
     *
     * @return boolean
     */
    public function getIsActive()
    {
        return $this->is_active;
    }

    /**
     * Set isDelete
     *
     * @param boolean $isDelete
     *
     * @return Mahasiswa
     */
    public function setIsDelete($isDelete)
    {
        $this->is_delete = $isDelete;

        return $this;
    }

    /**
     * Get isDelete
     *
     * @return boolean
     */
    public function getIsDelete()
    {
        return $this->is_delete;
    }
    /**
     * @var integer
     */
    private $daftar_id;


    /**
     * Set daftarId
     *
     * @param integer $daftarId
     *
     * @return Mahasiswa
     */
    public function setDaftarId($daftarId)
    {
        $this->daftar_id = $daftarId;

        return $this;
    }

    /**
     * Get daftarId
     *
     * @return integer
     */
    public function getDaftarId()
    {
        return $this->daftar_id;
    }
}
