<?php

namespace App\Repositories\Presenters;

use App\Repositories\Transformers\ResourceTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

class ResourcePresenter extends FractalPresenter
{
   /**
    * Prepare data to present.
    *
    * @return \League\Fractal\TransformerAbstract
    */
   public function getTransformer()
   {
       return new ResourceTransformer();
   }
}