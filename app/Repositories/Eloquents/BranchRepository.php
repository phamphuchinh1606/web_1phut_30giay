<?php


namespace App\Repositories\Eloquents;

use App\Repositories\Base\BaseRepository;
use App\Models\Branch;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class BranchRepository extends BaseRepository
{
    public function __construct(Branch $model)
    {
        $this->model = $model;
    }
}
