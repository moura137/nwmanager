<?php

namespace Tests\Repositories\Criterias;

use Tests\TestCase;
use Mockery as m;
use NwManager\Repositories\Criterias\InputCriteria;

class InputCriteriaTest extends TestCase
{
    public function testImplementsInstanceOf()
    {
        $input = ['foo' => 'bar'];

        $criteria = new InputCriteria($input);

        $this->assertInstanceOf('Prettus\Repository\Contracts\CriteriaInterface', $criteria);
        $this->assertAttributeEquals($input, 'input', $criteria);
        $this->assertEquals('bar', $criteria->getInput('foo'));
        $this->assertEquals('default', $criteria->getInput('noexists', 'default'));
    }

    public function testApplyWhereAll()
    {
        $fieldsSearchable = ['field1' => 'like', 'field2'];

        $columns = ['field1', 'field2', 'field-date'];
        $closure = function(){};
        $expression = m::mock('Illuminate\Database\Query\Expression');
        $search = 'busca';

        $model = new StubModel;

        $query = m::mock('Illuminate\Database\Eloquent\Builder');
        $query->shouldReceive('getModel')->once()->andReturn($model);
        $query->shouldReceive('example')->once()->ordered()->with('new-value')->andReturn($query);
        $query->shouldReceive('where')->once()->ordered()->with($closure)->andReturn($query);
        $query->shouldReceive('whereRaw')->once()->ordered()->with($expression)->andReturn($query);
        $query->shouldReceive('whereRaw')->once()->ordered()->with('column > ?', [1])->andReturn($query);
        $query->shouldReceive('whereIn')->once()->ordered()->with('field1', ['value1', 'value2'])->andReturn($query);
        $query->shouldReceive('where')->once()->ordered()->with('field2', 'test')->andReturn($query);

        
        $newQuery = m::mock('Illuminate\Database\Query\Builder');
        $newQuery->shouldReceive('orWhere')->once()->ordered()->with('field1', 'like', "%{$search}%")->andReturn($query);
        $newQuery->shouldReceive('orWhere')->once()->ordered()->with('field2', '=', "{$search}")->andReturn($query);

        $query->shouldReceive('where')
            ->once()
            ->ordered()
            ->andReturnUsing(function($test) use ($newQuery, $query) {
                $test($newQuery);
                return $query;
            });
            
        $query->shouldReceive('orderBy')->once()->ordered()->with('field2', 'desc')->andReturn($query);

        $input = [
            'example' => 'new-value',
            $closure,
            $expression,
            'column > ?' => 1,
            'field1' => ['value1', 'value2'],
            'field2' => 'test',
            'orderBy' => 'field2',
            'sortedBy' => 'desc',
            'field-invalid' => 'bar',
            'search' => $search,
        ];

        $criteria = new InputCriteria($input);

        $repo = m::mock('Prettus\Repository\Contracts\RepositoryInterface');
        $repo->shouldReceive('getFieldsSearchable')->once()->andReturn($fieldsSearchable);

        $this->assertEquals($query, $criteria->apply($query, $repo));
    }
}

class StubModel
{
    public function scopeExample($query, $value)
    {
        //
    }

    public function columns()
    {
        return ['field1', 'field2', 'field-date'];
    }

    public function getDates()
    {
        return ['field-date'];
    }
}