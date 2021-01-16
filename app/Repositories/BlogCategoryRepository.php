<?php
namespace App\Repositories;

use App\Models\BlogCategory as Model;
// use Illuminate\Database\Eloquent\Collection;

/** 
 * Class BlogCategoryRepository
 * 
 * @package App\Repositories
 */
class BlogCategoryRepository extends CoreRepository
{
  /**
   * @return string
   */
  protected function getModelClass() {
    return Model::class;
  }

  /**
   * Получить модель для редактирования в админке
   * 
   * @param int id
   * 
   * @return Model
   */
  public function getEdit($id) {
    return $this->startConditions()->find($id);
  }
  /**
   * Получить список катгории для вывода в виподаюшем списке
   * 
   * @return Collection
   */
  public function getForComboBox() {
    // return $this->startConditions()->all();

    $column=implode(',',[
      'id',
      'CONCAT (id, ". ",title) AS id_title'
    ]);
    /* $result=$this->startConditions()->all();
    $result=$this
            ->startConditions()
            ->select('blog_categories.*',\DB::raw('CONCAT (id, ". ",title) AS id_title'))
            ->toBase()
            ->get(); */
            
    $result=$this
            ->startConditions()
            ->selectRaw($column)
            ->toBase()                    //TODO colekcia STD clasa
            ->get();

    return $result;        
  }

  /**
   * Получить категории для вивода пагинации
   * @param int\null $perPage
   * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
   */
  public function getAllWithPaginate($perPage=null) {
    $column=['id','title','parent_id'];

    $result=$this
        ->startConditions()
        ->select($column)
        ->paginate($perPage);
    
    return $result;
  }
}