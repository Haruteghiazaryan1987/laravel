<?php
namespace App\Repositories;

// use App\Models\BlogCategory as Model;
// use Illuminate\Database\Eloquent\Collection;

/** 
 * Class BlogCategoryRepository
 * 
 * @package App\Repositories
 */
abstract class CoreRepository
{
  /**
   * @var Model
   */
  protected $model;

  /**
   * CategoryRepository constructor
   */
  public function __construct(){
    $this->model=app($this->getModelClass());
  }
  /**
   * @return mixed
   */
  abstract protected function getModelClass();

  /**
   * @return Model|\Illuminate\Foundation\Application|mixed
   */
  protected function startConditions() {
    return clone $this->model;
  }
}