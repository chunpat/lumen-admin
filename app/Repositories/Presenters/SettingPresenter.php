<?php

namespace App\Repositories\Presenters;

use App\Repositories\Transformers\SettingTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class SettingPresenter extends FractalPresenter
{
   /**
    * Prepare data to present.
    *
    * @return \League\Fractal\TransformerAbstract
    */
   public function getTransformer()
   {
       return new SettingTransformer();
   }
}