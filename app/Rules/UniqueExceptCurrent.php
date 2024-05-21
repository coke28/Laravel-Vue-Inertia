<?php

namespace App\Rules;

use Closure;
use DB;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueExceptCurrent implements ValidationRule
{
    protected $table;

    protected $column;

    protected $model;

    public function __construct($table, $column, $model)
    {
        $this->table = $table;
        $this->column = $column;
        $this->model = $model;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        //
        $query = DB::table($this->table)
            ->where($this->column, $value)
            ->whereNotNull('deleted_at');
        if ($this->model) {
            $query = $query->where('id', '!=', $this->model->id);
        }
        $query = $query->count();
        if ($query > 0) {
            $fail('The :attribute is already in use.');

        }

    }
}
