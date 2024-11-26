<?php

use App\Models\Account;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('Transaction.Report.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('Account.Report.{account}', function ($user, Account $account) {
    return (int) $user->id === (int) $account->user_id;
});
