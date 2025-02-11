<?php

namespace TimetrackerBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * Log
 *
 * @ORM\Table(name="logs")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Log
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="card_signature", type="string", length=255)
     */
    private $cardSignature;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="time", type="datetime")
     */
    private $time;

    /**
     * @var boolean
     * 
     * @ORM\Column(name="is_edited", type="boolean", options={"default": false})
     */
    private $isEdited;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="backup_time", type="datetime", nullable=true)
     */
    private $backupTime;

    /**
     * @ORM\ManyToOne(targetEntity="Card", inversedBy="log")
     * @ORM\JoinColumn(name="card_signature", referencedColumnName="signature")
     */
    protected $card;

    /**
     * @ORM\PreUpdate
     */
    public function preUpdate(PreUpdateEventArgs $eventArgs)
    {
        if ( ! $this->isEdited )
        {
            $this->isEdited = true;
            $this->backupTime = $eventArgs->getOldValue('time');
        }
    }

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
     * Set time
     *
     * @param \DateTime $time
     * @return Log
     */
    public function setTime($time)
    {
        $this->time = $time;

        return $this;
    }

    /**
     * Get time
     *
     * @return \DateTime 
     */
    public function getTime()
    {
        return $this->time;
    }

    /**
     * Set card
     *
     * @param \TimetrackerBundle\Entity\Card $card
     * @return Log
     */
    public function setCard(\TimetrackerBundle\Entity\Card $card = null)
    {
        $this->card = $card;

        return $this;
    }

    /**
     * Get card
     *
     * @return \TimetrackerBundle\Entity\Card 
     */
    public function getCard()
    {
        return $this->card;
    }

    /**
     * Set cardSignature
     *
     * @param string $cardSignature
     * @return Log
     */
    public function setCardSignature($cardSignature)
    {
        $this->cardSignature = $cardSignature;

        return $this;
    }

    /**
     * Get cardSignature
     *
     * @return string 
     */
    public function getCardSignature()
    {
        return $this->cardSignature;
    }

    /**
     * Set isEdited
     *
     * @param boolean $isEdited
     * @return Log
     */
    public function setIsEdited($isEdited)
    {
        $this->isEdited = $isEdited;

        return $this;
    }

    /**
     * Get isEdited
     *
     * @return boolean 
     */
    public function getIsEdited()
    {
        return $this->isEdited;
    }

    /**
     * Set backupTime
     *
     * @param \DateTime $backupTime
     * @return Log
     */
    public function setBackupTime($backupTime)
    {
        $this->backupTime = $backupTime;

        return $this;
    }

    /**
     * Get backupTime
     *
     * @return \DateTime 
     */
    public function getBackupTime()
    {
        return $this->backupTime;
    }

    public function getEmployee()
    {
        return $this->getCard()->getEmployee();
    }
}
