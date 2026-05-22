<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class CompanySetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'company_address',
        'company_phone',
        'company_email',
        'owner_name',
        'owner_position',
        'signature_path',
        'stamp_path',
        'logo_path',
    ];

    /**
     * Get singleton instance (hanya 1 record)
     */
    public static function getInstance()
    {
        $setting = self::first();
        
        if (!$setting) {
            $setting = self::create([
                'company_name' => 'CV. Konveksi Seragam Sekolah',
                'owner_name' => 'Pemilik',
                'owner_position' => 'Owner/Pimpinan',
            ]);
        }
        
        return $setting;
    }

    /**
     * Get signature URL
     */
    public function getSignatureUrlAttribute()
    {
        if ($this->signature_path && Storage::disk('public')->exists($this->signature_path)) {
            return Storage::disk('public')->url($this->signature_path);
        }
        
        return null;
    }

    /**
     * Get stamp URL
     */
    public function getStampUrlAttribute()
    {
        if ($this->stamp_path && Storage::disk('public')->exists($this->stamp_path)) {
            return Storage::disk('public')->url($this->stamp_path);
        }
        
        return null;
    }

    /**
     * Get logo URL
     */
    public function getLogoUrlAttribute()
    {
        if ($this->logo_path && Storage::disk('public')->exists($this->logo_path)) {
            return Storage::disk('public')->url($this->logo_path);
        }
        
        return null;
    }

    /**
     * Get signature full path untuk PDF
     */
    public function getSignatureFullPathAttribute()
    {
        if ($this->signature_path && Storage::disk('public')->exists($this->signature_path)) {
            return storage_path('app/public/' . $this->signature_path);
        }
        
        return null;
    }

    /**
     * Get stamp full path untuk PDF
     */
    public function getStampFullPathAttribute()
    {
        if ($this->stamp_path && Storage::disk('public')->exists($this->stamp_path)) {
            return storage_path('app/public/' . $this->stamp_path);
        }
        
        return null;
    }

    /**
     * Get logo full path untuk PDF
     */
    public function getLogoFullPathAttribute()
    {
        if ($this->logo_path && Storage::disk('public')->exists($this->logo_path)) {
            return storage_path('app/public/' . $this->logo_path);
        }
        
        return null;
    }

    /**
     * Delete old file when updating
     */
    public function deleteOldFile($fieldName)
    {
        if ($this->{$fieldName} && Storage::disk('public')->exists($this->{$fieldName})) {
            Storage::disk('public')->delete($this->{$fieldName});
        }
    }
}
