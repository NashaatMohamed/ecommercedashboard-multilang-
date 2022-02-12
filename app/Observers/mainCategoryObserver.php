<?php

namespace App\Observers;

use App\Models\manCategory;

class mainCategoryObserver
{
    /**
     * Handle the manCategory "created" event.
     *
     * @param  \App\Models\manCategory  $manCategory
     * @return void
     */
    public function created(manCategory $manCategory)
    {
        //
    }

    /**
     * Handle the manCategory "updated" event.
     *
     * @param  \App\Models\manCategory  $manCategory
     * @return void
     */
    public function updated(manCategory $manCategory)
    {
        $manCategory->vendor() ->update(["active" => $manCategory->active]);
    }

    /**
     * Handle the manCategory "deleted" event.
     *
     * @param  \App\Models\manCategory  $manCategory
     * @return void
     */
    public function deleted(manCategory $manCategory)
    {
        //
    }

    /**
     * Handle the manCategory "restored" event.
     *
     * @param  \App\Models\manCategory  $manCategory
     * @return void
     */
    public function restored(manCategory $manCategory)
    {
        //
    }

    /**
     * Handle the manCategory "force deleted" event.
     *
     * @param  \App\Models\manCategory  $manCategory
     * @return void
     */
    public function forceDeleted(manCategory $manCategory)
    {
        //
    }
}
