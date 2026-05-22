<?php

namespace App\Http\Controllers;

use App\Models\CompanySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanySettingController extends Controller
{
    /**
     * Display the company settings form
     */
    public function index()
    {
        $setting = CompanySetting::getInstance();
        
        return view('settings.company.index', compact('setting'));
    }

    /**
     * Update company settings
     */
    public function update(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string|max:255',
            'company_address' => 'nullable|string',
            'company_phone' => 'nullable|string|max:50',
            'company_email' => 'nullable|email|max:100',
            'owner_name' => 'required|string|max:255',
            'owner_position' => 'required|string|max:255',
            'signature' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'stamp' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'unpaid_order_auto_delete_days' => 'required|integer|min:1|max:365',
        ]);

        $setting = CompanySetting::getInstance();

        // Update basic fields
        $setting->company_name = $request->company_name;
        $setting->company_address = $request->company_address;
        $setting->company_phone = $request->company_phone;
        $setting->company_email = $request->company_email;
        $setting->owner_name = $request->owner_name;
        $setting->owner_position = $request->owner_position;
        $setting->unpaid_order_auto_delete_days = $request->unpaid_order_auto_delete_days;

        // Handle signature upload
        if ($request->hasFile('signature')) {
            // Delete old signature
            $setting->deleteOldFile('signature_path');
            
            // Store new signature
            $signaturePath = $request->file('signature')->store('company/signatures', 'public');
            $setting->signature_path = $signaturePath;
        }

        // Handle stamp upload
        if ($request->hasFile('stamp')) {
            // Delete old stamp
            $setting->deleteOldFile('stamp_path');
            
            // Store new stamp
            $stampPath = $request->file('stamp')->store('company/stamps', 'public');
            $setting->stamp_path = $stampPath;
        }

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo
            $setting->deleteOldFile('logo_path');
            
            // Store new logo
            $logoPath = $request->file('logo')->store('company/logos', 'public');
            $setting->logo_path = $logoPath;
        }

        $setting->save();

        return redirect()->route('company-settings.index')
            ->with('success', 'Pengaturan perusahaan berhasil diperbarui!');
    }

    /**
     * Delete signature
     */
    public function deleteSignature()
    {
        $setting = CompanySetting::getInstance();
        $setting->deleteOldFile('signature_path');
        $setting->signature_path = null;
        $setting->save();

        return redirect()->route('company-settings.index')
            ->with('success', 'Tanda tangan berhasil dihapus!');
    }

    /**
     * Delete stamp
     */
    public function deleteStamp()
    {
        $setting = CompanySetting::getInstance();
        $setting->deleteOldFile('stamp_path');
        $setting->stamp_path = null;
        $setting->save();

        return redirect()->route('company-settings.index')
            ->with('success', 'Stempel berhasil dihapus!');
    }

    /**
     * Delete logo
     */
    public function deleteLogo()
    {
        $setting = CompanySetting::getInstance();
        $setting->deleteOldFile('logo_path');
        $setting->logo_path = null;
        $setting->save();

        return redirect()->route('company-settings.index')
            ->with('success', 'Logo berhasil dihapus!');
    }
}
