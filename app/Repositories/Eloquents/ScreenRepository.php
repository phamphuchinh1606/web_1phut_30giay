<?php

namespace App\Repositories\Eloquents;

use App\Models\Screen;
use App\Repositories\Base\BaseRepository;

/**
 * Class ChannelBotRepository
 *
 * @package App\Repositories\Eloquents
 */
class ScreenRepository extends BaseRepository
{
    public function __construct(Screen $model)
    {
        $this->model = $model;
    }

    public function selectAll()
    {
        return $this->model::orderBy('screen_type')->get();
    }

    public function getScreenAdmin(){
        return $this->model::where('screen_type', Screen::SCREEN_TYPE_ADMIN)->get();
    }

    public function getScreenEmployee(){
        return $this->model::where('screen_type', Screen::SCREEN_TYPE_EMPLOYEE)->get();
    }
}
