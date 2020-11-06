<?php

namespace App\Repositories\Presenters;

use App\Repositories\Transformers\LoginLogTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class LoginLogPresenter extends FractalPresenter
{
   /**
    * Prepare data to present.
    *
    * @return \League\Fractal\TransformerAbstract
    */
   public function getTransformer()
   {
       return new LoginLogTransformer();
   }
}