<?php

namespace Onboarding\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="killreports", schema="dbo")
 * @ORM\Table(name="`dbo.killreports`")
 */
class Kill
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="string")
     */
    protected $uid;

    /**
     * @ORM\Column(name="date", type="datetime")
     */
    protected $createdOn;

    /**
     * @ORM\Column(name="data", type="string")
     */
    protected $data;

    public function setUid($uid)
    {
        $this->uid = $uid;
    }

    public function getUid()
    {
        return $this->uid;
    }

    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
    }

    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    public function setData($data)
    {
        $this->data = $data;
    }

    public function getData()
    {
        return $this->data;
    }

    public function getDataAsArray()
    {
        $data = $this->data;
    }
}
