<?php

namespace App\Http\Transformers;


use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array.
     *
     * @param  \App\User  $user
     * @return array
     */
    public function transform(User $user)
    {

    }

}