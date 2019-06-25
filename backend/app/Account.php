<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

/**
 * Class Account
 * @package App
 *
 * @property string $uid
 * @property int $user_id
 * @property float $balance
 * @property int $status
 */
class Account extends Model
{
    const STATUS_ACTIVE = 1;
    const STATUS_BLOCKED = 2;

    /**
     * @param $userId
     * @param float $initialBalance
     * @return Account
     */
    public static function create($userId, $initialBalance = 500.00)
    {
        $account = new Account();

        $account->uid = Str::uuid()->toString();
        $account->user_id = $userId;
        $account->balance = is_null($initialBalance) ? 0.00 : (float)$initialBalance;
        $account->status = self::STATUS_ACTIVE;

        $account->save();

        return $account;
    }
}
