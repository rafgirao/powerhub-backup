<?php

namespace App\Rules;

use App\Services\Helper;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

/**
 * Class AccountCheckRule
 * @package App\Rules
 */
class AccountCheckRule implements Rule
{
    /**
     * @var
     */
    /**
     * @var string
     */
    /**
     * @var string|null
     */
    private $table, $column, $columnValue;

    /**
     * Create a new rule instance.
     *
     * @param $table
     * @param null $columnValue
     * @param string $column
     */
    public function __construct($table, $columnValue = null, $column = 'id')
    {
        $this->table        = $table;
        $this->column       = $column;
        $this->columnValue  = $columnValue;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        (new Helper)->getAccountInfo();
        $act = session()->get('account')->id;;

        $result = DB::table($this->table)
            ->where($attribute, $value)
            ->where('account', $act)
            ->first();

        if ($result && $result->{$this->column} == $this->columnValue)
            return true;

        return is_null($result);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'O valor para :attribute já está em uso!';
    }
}
