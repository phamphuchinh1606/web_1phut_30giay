<?php

namespace App\Repositories\Eloquents;

use App\Models\UserBranch;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class UserBranchRepository extends BaseRepository
{
    public function __construct(UserBranch $model)
    {
        $this->model = $model;
    }

}
