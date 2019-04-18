<?php

namespace xguard\Listeners;

use xguard\Events\Role\Created;
use xguard\Events\Role\PermissionsUpdated;
use xguard\Events\Role\Updated;
use xguard\Events\Role\Deleted;
use xguard\Services\Logging\UserActivity\Logger;

class RoleEventsSubscriber
{
    /**
     * @var Logger
     */
    private $logger;

    public function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }

    public function onCreate(Created $event)
    {
        $message = trans(
            'log.new_role',
            ['name' => $event->getRole()->display_name]
        );

        $this->logger->log($message);
    }

    public function onUpdate(Updated $event)
    {
        $message = trans(
            'log.updated_role',
            ['name' => $event->getRole()->display_name]
        );

        $this->logger->log($message);
    }

    public function onDelete(Deleted $event)
    {
        $message = trans(
            'log.deleted_role',
            ['name' => $event->getRole()->display_name]
        );

        $this->logger->log($message);
    }

    public function onPermissionsUpdate(PermissionsUpdated $event)
    {
        $this->logger->log(trans('log.updated_role_permissions'));
    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $class = 'xguard\Listeners\RoleEventsSubscriber';

        $events->listen(Created::class, "{$class}@onCreate");
        $events->listen(Updated::class, "{$class}@onUpdate");
        $events->listen(Deleted::class, "{$class}@onDelete");
        $events->listen(PermissionsUpdated::class, "{$class}@onPermissionsUpdate");
    }
}
