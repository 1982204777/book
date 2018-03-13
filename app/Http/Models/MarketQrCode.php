<?php

namespace App\Http\Models;

class MarketQrCode extends BaseModel
{
    public $table = 'market_qrcode';

    public function qrcode_scan_histories()
    {
        return $this->hasMany(QrCodeScanHistory::class, 'qrcode_id', 'id');
    }
}
