<?php

namespace App\Repositories\Presenters;

use App\Repositories\Transformers\UserSettingTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class UserSettingPresenter extends FractalPresenter
{
   /**
    * Prepare data to present.
    *
    * @return \League\Fractal\TransformerAbstract
    */
   public function getTransformer()
   {
       return new UserSettingTransformer();
   }
}