<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Файл:    modifier.userinfo.php
 * Тип:     modifier
 * Имя:     user
 * Назначение:  Get the user info by id.
 * -------------------------------------------------------------
 */
function smarty_modifier_userinfo($id, $field = null)
{
    global $modx;
    $excluded = ['cachepwd', 'salt','sessionid', 'password', 'session_stale', 'remote_key', 'remote_data', 'hash_class', 'internalKey'];

    if (!function_exists('modifier_userinfo_extended')) {
        function modifier_userinfo_extended($field, array $data)
        {
            foreach (explode('.', $field) as $segment) {
                if (isset($data[$segment])) {
                    $data = $data[$segment];
                } else {
                    return '';
                }
            }
            return $data;
        }
    }

    if (!$id || !is_numeric($id)) {
        return '';
    }

    $appEnv = getenv('APP_ENV', true) ?: 'prod';
    // MODX 3: xPDO::getObjectGraph() was removed, using getObject + getOne instead
    $user = $appEnv === 'test' ? $modx->user : $modx->getObject(\MODX\Revolution\modUser::class, ['id' => (int)$id]);
    if (!$user) {
        return '';
    }

    /** @var \MODX\Revolution\modUserProfile $profile */
    $profile = $user->getOne('Profile') ?: $modx->newObject(\MODX\Revolution\modUserProfile::class);
    $userData = array_diff_key(array_merge($user->toArray(), $profile->toArray()), array_flip($excluded));
    if (!empty($field)) {
        if (strpos($field, 'extended.') === 0) {
            $result = modifier_userinfo_extended($field, $userData);
        } else {
            $result = $userData[$field] ?? '';
        }
    } else {
        $result = $userData;
    }

    return $result;
}