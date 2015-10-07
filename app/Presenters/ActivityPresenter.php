<?php

namespace NwManager\Presenters;

use NwManager\Transformers\ActivityTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ActivityPresenter
 *
 * @package NwManager\Presenters;
 */
class ActivityPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ActivityTransformer();
    }
}
