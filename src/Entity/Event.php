<?php

namespace FOSOpenScouting\Keeo\Entity;

class Event extends Entity
{
    protected $id;
    protected $name;
    protected $code;
    protected $description;
    protected $event_category_id;
    protected $fos_structure_id;
    protected $delegate_subscriptions;
    protected $no_subunits;
    protected $address_id;
    protected $start_date;
    protected $end_date;
    protected $administrative_cost;
    protected $administrative_cost_from;
    protected $is_online_subscribable;
    protected $mail_subscription_id;
    protected $mail_reminder_id;
    protected $mail_cancellation_id;
    protected $is_archived;
    protected $archivation_date;
    protected $is_published;
    protected $deleted;
    protected $address;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getEventCategoryId()
    {
        return $this->event_category_id;
    }

    /**
     * @return mixed
     */
    public function getFosStructureId()
    {
        return $this->fos_structure_id;
    }

    /**
     * @return mixed
     */
    public function getDelegateSubscriptions()
    {
        return $this->delegate_subscriptions;
    }

    /**
     * @return mixed
     */
    public function getNoSubunits()
    {
        return $this->no_subunits;
    }

    /**
     * @return mixed
     */
    public function getAddressId()
    {
        return $this->address_id;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->start_date;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->end_date;
    }

    /**
     * @return mixed
     */
    public function getAdministrativeCost()
    {
        return $this->administrative_cost;
    }

    /**
     * @return mixed
     */
    public function getAdministrativeCostFrom()
    {
        return $this->administrative_cost_from;
    }

    /**
     * @return mixed
     */
    public function getIsOnlineSubscribable()
    {
        return $this->is_online_subscribable;
    }

    /**
     * @return mixed
     */
    public function getMailSubscriptionId()
    {
        return $this->mail_subscription_id;
    }

    /**
     * @return mixed
     */
    public function getMailReminderId()
    {
        return $this->mail_reminder_id;
    }

    /**
     * @return mixed
     */
    public function getMailCancellationId()
    {
        return $this->mail_cancellation_id;
    }

    /**
     * @return mixed
     */
    public function getIsArchived()
    {
        return $this->is_archived;
    }

    /**
     * @return mixed
     */
    public function getArchivationDate()
    {
        return $this->archivation_date;
    }

    /**
     * @return mixed
     */
    public function getIsPublished()
    {
        return $this->is_published;
    }

    /**
     * @return mixed
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }


}