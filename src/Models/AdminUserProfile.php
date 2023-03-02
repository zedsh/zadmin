<?php

namespace zedsh\zadmin\Models;

use Database\Factories\UserFactory;
use Eloquent;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Notifications\DatabaseNotificationCollection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laravel\Sanctum\HasApiTokens;
use Laravel\Sanctum\PersonalAccessToken;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $inn
 * @property string $ogrn
 * @property string $organization
 * @property Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $remember_token
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read DatabaseNotificationCollection|DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @property-read Collection|PersonalAccessToken[] $tokens
 * @property-read int|null $tokens_count
 * @method static UserFactory factory(...$parameters)
 * @method static Builder|User newModelQuery()
 * @method static Builder|User newQuery()
 * @method static Builder|User query()
 * @method static Builder|User whereCreatedAt($value)
 * @method static Builder|User whereEmail($value)
 * @method static Builder|User whereEmailVerifiedAt($value)
 * @method static Builder|User whereId($value)
 * @method static Builder|User whereInn($value)
 * @method static Builder|User whereName($value)
 * @method static Builder|User whereOgrn($value)
 * @method static Builder|User whereOrganization($value)
 * @method static Builder|User wherePassword($value)
 * @method static Builder|User whereRememberToken($value)
 * @method static Builder|User whereUpdatedAt($value)
 * @mixin Eloquent
 * @property int $role
 * @method static Builder|User whereRole($value)
 * @property string|null $phone_number
 * @property bool $filled
 * @property int|null $chat_id
 * @property-read \App\Models\Chat|null $chat
 * @method static Builder|User whereChatId($value)
 * @method static Builder|User whereFilled($value)
 * @method static Builder|User wherePhoneNumber($value)
 * @property-read Collection|\App\Models\Request[] $requests
 * @property-read int|null $requests_count
 * @property-read mixed $role_name
 * @property-read \App\Models\ExternalData|null $externalData
 */
class AdminUserProfile extends User
{
    protected $table = 'users';
}
