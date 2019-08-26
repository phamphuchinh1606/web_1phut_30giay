<?php

namespace App\Repositories\Eloquents;

use App\Common\Constant;
use App\User;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    public function selectAll()
    {
        return $this->model::where('delete_flg', Constant::DELETE_FLG_OFF)->orderBy('id')->get();
    }

}
