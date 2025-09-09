<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\LogsActivity;

class Setting extends Model
{
    use HasFactory, LogsActivity;
    
    /**
     * Les attributs qui sont assignables en masse.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'key',
        'value',
        'group',
        'type',
        'hero_subtitle', // ✅ 
    ];
    
    /**
     * Les attributs qui doivent être castés.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'value' => 'json',
    ];
    
    /**
     * Récupère un paramètre par sa clé.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function getValue(string $key, $default = null)
    {
        $setting = self::where('key', $key)->first();
        
        if (!$setting) {
            return $default;
        }
        
        return $setting->value;
    }
    
    /**
     * Récupère tous les paramètres d'un groupe.
     *
     * @param string $group
     * @return array
     */
    public static function getGroup(string $group)
    {
        $settings = self::where('group', $group)->get();
        
        $result = [];
        foreach ($settings as $setting) {
            $result[$setting->key] = $setting->value;
        }
        
        return $result;
    }
    
    /**
     * Définit un paramètre.
     *
     * @param string $key
     * @param mixed $value
     * @param string $group
     * @param string $type
     * @return Setting
     */
    public static function setValue(string $key, $value, string $group = 'general', string $type = 'string')
    {
        $setting = self::where('key', $key)->first();
        
        if (!$setting) {
            $setting = new self();
            $setting->key = $key;
            $setting->group = $group;
            $setting->type = $type;
        }
        
        $setting->value = $value;
        $setting->save();
        
        return $setting;
    }
    
    /**
     * Définit plusieurs paramètres à la fois.
     *
     * @param array $data
     * @param string $group
     * @return void
     */
    public static function setMany(array $data, string $group = 'general')
    {
        foreach ($data as $key => $value) {
            self::setValue($key, $value, $group);
        }
    }
}