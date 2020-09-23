<?php
namespace Mung9thang12\Repository;

interface BaseRepositoryInterface
{
    function all();

    function find($model,$column=null);
    function findOrFail($model,$collumn=null);
    function create($attribute=[]);
}