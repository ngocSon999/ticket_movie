<?php

namespace App\Observers;

use App\Models\User;
use App\Services\SaveTraceService;

class UserObserver
{
    protected SaveTraceService $saveTrace;

    public function __construct(SaveTraceService $saveTrace)
    {
        $this->saveTrace = $saveTrace;
    }

    public bool $afterCommit = true;
    /**
     * Handle the User "created" event.
     */
    /**
     * @param User $user
     * @return void
     */
    public function created(User $user): void
    {
        $this->saveTrace->saveTraces($user, 'create');
    }

    /**
     * Handle the User "updated" event.
     */
    /**
     * @param User $user
     * @return void
     */
    public function updated(User $user): void
    {
        $this->saveTrace->saveTraces($user, 'update');
    }

    /**
     * Handle the User "deleted" event.
     */
    /**
     * @param User $user
     * @return void
     */
    public function deleted(User $user): void
    {
        $this->saveTrace->saveTraces($user, 'delete');
    }

    /**
     * Handle the User "restored" event.
     */
    public function restored(User $user): void
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     */
    public function forceDeleted(User $user): void
    {
        //
    }
}
