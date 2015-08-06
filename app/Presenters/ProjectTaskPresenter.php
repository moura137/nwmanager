<?php

namespace NwManager\Presenters;

use NwManager\Transformers\ProjectTaskTransformer;
use Prettus\Repository\Presenter\FractalPresenter;

/**
 * Class ProjectTaskPresenter
 *
 * @package NwManager\Presenters;
 */
class ProjectTaskPresenter extends FractalPresenter
{
    /**
     * Transformer
     *
     * @return \League\Fractal\TransformerAbstract
     */
    public function getTransformer()
    {
        return new ProjectTaskTransformer();
    }
}
