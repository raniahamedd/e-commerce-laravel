<?php

namespace App\Models\Scopes;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class StoreScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $user = Auth::user();
        if($user && $user->store_id){ // ازا اليوزر اله ستور راح يعرضلي منتجاته بس ازا ملوش افتراضيا برجع كل البضائع بيكون بهذا الحالة الشخض هوا الادمن
            $builder->where('store_id','=',$user->store_id);
        }
    }

}
