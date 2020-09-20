<?php
namespace TeamX\Repository;

abstract class BaseRepository implements BaseRepositoryInterface
{
    protected $model;

    function __construct(){
        $this->setModel();
    }
    final private function setModel(){
        $this->model=app()->make($this->getModel());
    }
    abstract protected function getModel();
    function all(){
        return $this->model->all();
    }
    function find($model,$column=null){
        if($column){
            return $this->model->where($column,$model)->first();
        }
        return $this->model->find($model);
    }
    function get($model,$column){
        return $this->model->where($column,$model)->get();
    }
    function findOrFail($model,$column=null,$content=null){
        if($column&&$content){
            if($result=$this->model->where($column,$content)->first()){
                return $result;
            }
            return abort(404);
        }
        return $this->model->findOrFail($model);
    }
    function create($attribute=[]){
        return $this->model->create($attribute);
    }
    function delete($model=null,$column=null){
        if($column&&$model){
            return $this->model->where($column,$model)->delete();
        }elseif($model&&!$column){
            return $this->model->find($model)->delete();
        }
        return $this->model->delete();
    }
    function onlyTrashed(){
        return $this->model->onlyTrashed();
    }
    function restore(){
        return $this->model->restore();
    }
}