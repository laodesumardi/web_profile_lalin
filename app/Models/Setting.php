<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'key', 'value', 'group', 'type', 'options', 'label', 'description', 'sort_order'
    ];

    protected $casts = [
        'options' => 'array',
        'sort_order' => 'integer',
    ];

    /**
     * Get a setting value by key
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        $setting = Cache::rememberForever('setting.' . $key, function () use ($key) {
            return self::where('key', $key)->first();
        });

        return $setting ? $setting->value : $default;
    }

    /**
     * Set a setting value by key
     *
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set($key, $value = null)
    {
        if (is_array($key)) {
            foreach ($key as $k => $v) {
                self::set($k, $v);
            }
            return;
        }

        $setting = self::firstOrNew(['key' => $key]);
        $setting->value = $value;
        $setting->save();

        Cache::put('setting.' . $key, $setting);
    }

    /**
     * Get all settings as a key-value array
     *
     * @return array
     */
    public static function allSettings()
    {
        return Cache::rememberForever('settings.all', function () {
            return self::all()->pluck('value', 'key')->toArray();
        });
    }

    /**
     * Clear settings cache
     *
     * @return void
     */
    public static function clearCache()
    {
        Cache::forget('settings.all');
        $settings = self::all();
        foreach ($settings as $setting) {
            Cache::forget('setting.' . $setting->key);
        }
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::saved(function ($model) {
            $model->clearCache();
        });

        static::deleted(function ($model) {
            $model->clearCache();
        });
    }
}
