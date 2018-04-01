<?php

namespace Onboarding\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Persistence\Event\LifecycleEventArgs;
use DateTime;

/**
 * @ORM\Entity
 * @ORM\Table(name="`dbo.extensionpoints`")
 * @ORM\HasLifecycleCallbacks
 */
class ExtensionPointsAddedLog
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer")
     */
    protected $id;

    /**
     *  @ORM\Column(name="points", type="integer")
     */
    protected $points;

    /**
     * @ORM\Column(name="eventtime", type="datetime")
     */
    protected $createdOn;

    /**
     * @ORM\ManyToOne(targetEntity="Account")
     * @ORM\JoinColumn(name="accountid", referencedColumnName="accountID")
     */
    protected $account;

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setPoints($points)
    {
        $this->points = $points;
    }

    public function getPoints()
    {
        return $this->points;
    }

    public function setCreatedOn($createdOn)
    {
        $this->createdOn = $createdOn;
    }

    public function getCreatedOn()
    {
        return $this->createdOn;
    }

    public function setAccount(Account $account)
    {
        $this->account = $account;
    }

    public function getAccount(): Account
    {
        return $this->account;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist(LifecycleEventArgs $args)
    {
        $this->setCreatedOn(new DateTime('now'));
    }
}
