<?php

namespace NwManager\Presenters;

use NwManager\Transformers\ProjectTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ProjectPresenter
 *
 * @package NwManager\Presenters;
 */
class ProjectPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ProjectTransformer();
    }
}
