<?php

interface twSubscriptionExtListInterface
{
    /**
     * Method used to synchronize list with external source of data
     *
     * @param int $list_id
     * @param sfUser $user
     * @param PropelPDO $connection
     */
    public function syncList($list_id, sfUser $user = null, PropelPDO $connection = null);
}